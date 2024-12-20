<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Stock;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\OrderMaster;
use App\Models\OrderInvoice;
use App\Models\DeliveryOrder;
use App\Enums\OrderWorkflowType;
use Illuminate\Support\Facades\DB;
use App\Models\DeliveryOrderDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Notifications\WarehouseOrderUpdate;

class OrderDelivery extends Component
{
    public $order_id;
    public $order;
    public $deliveryStatus;
    public $selectedInventories = [];
    public $inventoryQuantities = [];
    public $totalOrderQuantity = 0;
    public $remainingQuantity = 0;
    public $isInitialConsignment = false;

    protected $rules = [
        'deliveryStatus' => 'required|in:Pending,Shipped,Delivered,Cancelled',
        'inventoryQuantities.*' => 'nullable|integer|min:0'
    ];

    public function mount($order_id)
    {
        $this->order_id = $order_id;
        $this->order = OrderMaster::with(['customer', 'orderDetails.product.inventories'])
            ->where('order_id', $order_id)
            ->firstOrFail();

        $this->deliveryStatus = $this->order->delivery_status;

        if ($this->order->workflow_type === OrderWorkflowType::CONSIGNMENT) {
            $this->isInitialConsignment = $this->order->is_initial_consignment;

            if ($this->order->parent_order_id) {
                $parentOrder = OrderMaster::find($this->order->parent_order_id);
                if ($parentOrder) {
                    $this->remainingQuantity = $parentOrder->remaining_quantity;
                    $this->totalOrderQuantity = $parentOrder->remaining_quantity;
                }
            } else {
                $this->totalOrderQuantity = $this->order->orderDetails->sum('quantity');
                $this->remainingQuantity = $this->order->remaining_quantity ?? $this->totalOrderQuantity;
            }
        }

        foreach ($this->order->orderDetails as $detail) {
            foreach ($detail->product->inventories as $inventory) {
                $this->inventoryQuantities[$inventory->id] = 0;
            }
        }

        $deliveredQuantity = abs(Stock::where('reason', 'LIKE', '%Order Delivery Update%')
            ->where('product_id', $this->order->orderDetails->pluck('product_id')->toArray())
            ->sum('quantity_change'));

        if ($this->order->workflow_type === OrderWorkflowType::MULTI_DELIVERY) {
            $this->totalOrderQuantity = $this->order->orderDetails->sum('quantity');
            $this->remainingQuantity = $this->totalOrderQuantity - $deliveredQuantity;
        }
    }

    public function back()
    {
        return redirect()->route('admin.orders.index');
    }

    public function updateDelivery()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                $originalOrder = $this->order;
                $totalSelectedQuantity = array_sum(array_map('intval', $this->inventoryQuantities));

                Log::info('Starting Delivery Update', [
                    'order_id' => $this->order_id,
                    'workflow_type' => $this->order->workflow_type,
                    'inventory_quantities' => $this->inventoryQuantities,
                    'total_selected' => $totalSelectedQuantity,
                    'order_details' => $this->order->orderDetails->map(function($detail) {
                        return [
                            'product_id' => $detail->product_id,
                            'product_name' => $detail->product->product_name,
                            'ordered_quantity' => $detail->quantity,
                            'delivered_quantity' => DeliveryOrderDetail::whereHas('deliveryOrder', function($query) {
                                $query->where('order_id', $this->order_id);
                            })->where('product_id', $detail->product_id)->sum('quantity'),
                            'inventories' => $detail->product->inventories->map(function($inv) {
                                return [
                                    'id' => $inv->id,
                                    'available' => $inv->remaining,
                                    'warehouse' => $inv->warehouse->warehouse_name,
                                    'selected_quantity' => $this->inventoryQuantities[$inv->id] ?? 0
                                ];
                            })
                        ];
                    }),
                    'validation_rules' => [
                        'workflow_type' => $this->order->workflow_type,
                        'is_initial_consignment' => $this->isInitialConsignment ?? false,
                        'existing_deliveries' => DeliveryOrderDetail::whereHas('deliveryOrder', function($query) {
                            $query->where('order_id', $this->order_id);
                        })->sum('quantity'),
                        'total_order_quantity' => $this->order->orderDetails->sum('quantity'),
                        'remaining_quantity' => $this->remainingQuantity
                    ]
                ]);

                // After validation, log the result
                Log::info('Validation Result', [
                    'order_id' => $this->order_id,
                    'workflow_type' => $this->order->workflow_type,
                    'validation_passed' => true,
                    'validation_details' => [
                        'standard' => [
                            'single_delivery' => DeliveryOrderDetail::whereHas('deliveryOrder', function($query) {
                                $query->where('order_id', $this->order_id);
                            })->count() === 0,
                            'exact_quantity' => $totalSelectedQuantity === $this->order->orderDetails->sum('quantity')
                        ],
                        'multi_delivery' => [
                            'remaining_quantity' => $this->remainingQuantity,
                            'selected_within_limit' => $totalSelectedQuantity <= $this->remainingQuantity
                        ],
                        'consignment' => [
                            'is_initial' => $this->isInitialConsignment,
                            'initial_validation' => $this->isInitialConsignment ? [
                                'single_delivery' => DeliveryOrderDetail::whereHas('deliveryOrder', function($query) {
                                    $query->where('order_id', $this->order_id);
                                })->count() === 0,
                                'exact_quantity' => $totalSelectedQuantity === $this->order->orderDetails->sum('quantity')
                            ] : [
                                'remaining_quantity' => $this->remainingQuantity,
                                'selected_within_limit' => $totalSelectedQuantity <= $this->remainingQuantity
                            ]
                        ]
                    ]
                ]);

                // First validate individual product quantities
                $productQuantities = [];
                foreach ($this->order->orderDetails as $detail) {
                    foreach ($detail->product->inventories as $inventory) {
                        if (!isset($productQuantities[$detail->product_id])) {
                            $productQuantities[$detail->product_id] = [
                                'ordered' => $detail->quantity,
                                'selected' => 0,
                                'name' => $detail->product->product_name
                            ];
                        }
                        if (isset($this->inventoryQuantities[$inventory->id])) {
                            $productQuantities[$detail->product_id]['selected'] += intval($this->inventoryQuantities[$inventory->id]);
                        }
                    }
                }

                Log::info('Product Quantities Check', [
                    'product_quantities' => $productQuantities
                ]);

                // Check if any product exceeds its ordered quantity
                foreach ($productQuantities as $productId => $quantities) {
                    if ($quantities['selected'] > $quantities['ordered']) {
                        Log::warning('Product Quantity Exceeded', [
                            'product_id' => $productId,
                            'ordered' => $quantities['ordered'],
                            'selected' => $quantities['selected'],
                            'product_name' => $quantities['name']
                        ]);
                        notyf()->error("Cannot deliver more than ordered quantity ({$quantities['ordered']}) for product: {$quantities['name']}");
                        return false;
                    }
                }

                // Validate product quantities
                if (!$this->validateDeliveryQuantities($productQuantities)) {
                    return false;
                }

                $existingDeliveries = DeliveryOrderDetail::whereHas('deliveryOrder', function ($query) use ($originalOrder) {
                    $query->where('order_id', $originalOrder->order_id);
                })->sum('quantity');

                $orderTotalQuantity = $originalOrder->orderDetails->sum('quantity');

                Log::info('Delivery Update Debug', [
                    'workflow_type' => $originalOrder->workflow_type,
                    'is_initial_consignment' => $this->isInitialConsignment,
                    'total_selected_quantity' => $totalSelectedQuantity,
                    'order_total_quantity' => $orderTotalQuantity,
                    'existing_deliveries' => $existingDeliveries
                ]);

                // Validation based on workflow type
                switch ($originalOrder->workflow_type) {
                    case OrderWorkflowType::STANDARD:
                        if ($existingDeliveries > 0) {
                            notyf()->error("Standard orders can only be delivered once.");
                            return false;
                        }
                        if ($totalSelectedQuantity !== $orderTotalQuantity) {
                            notyf()->error("For Standard orders, you must deliver the exact order quantity of {$orderTotalQuantity}.");
                            return false;
                        }
                        break;

                    case OrderWorkflowType::MULTI_DELIVERY:
                        $remainingToDeliver = $orderTotalQuantity - $existingDeliveries;
                        if ($totalSelectedQuantity > $remainingToDeliver) {
                            notyf()->error("Cannot deliver more than the remaining quantity: {$remainingToDeliver}.");
                            return false;
                        }
                        break;

                    case OrderWorkflowType::CONSIGNMENT:
                        if ($this->isInitialConsignment) {
                            if ($existingDeliveries > 0) {
                                notyf()->error("Initial Consignment can only be delivered once.");
                                return false;
                            }
                            if ($totalSelectedQuantity !== $orderTotalQuantity) {
                                notyf()->error("Initial Consignment delivery must be the exact order quantity of {$orderTotalQuantity}.");
                                return false;
                            }
                        } else {
                            $remainingQuantity = $originalOrder->remaining_quantity;
                            if ($totalSelectedQuantity > $remainingQuantity) {
                                notyf()->error("Cannot deliver more than remaining quantity: {$remainingQuantity}.");
                                return false;
                            }
                        }
                        break;
                }

                // Create delivery orders grouped by warehouse
                foreach ($this->inventoryQuantities as $inventoryId => $quantity) {
                    if ($quantity <= 0) continue;

                    $orderInvoice = OrderInvoice::where('order_id', $this->order->order_id)->firstOrFail();
                    $inventory = Inventory::findOrFail($inventoryId);
                    $warehouseId = $inventory->warehouse_id;

                    $deliveryOrder = DeliveryOrder::create([
                        'order_id' => $this->order->order_id,
                        'delivery_number' => DeliveryOrder::generateDeliveryNumber(),
                        'warehouse_id' => $warehouseId,
                        'delivery_date' => now(),
                        'status' => 'Delivered',
                        'remarks' => 'Generated for delivery',
                        'created_by' => Auth::id(),
                        'modified_by' => Auth::id(),
                        'order_invoice_id' => $orderInvoice->id,
                    ]);

                    foreach ($this->order->orderDetails as $detail) {
                        DeliveryOrderDetail::create([
                            'delivery_order_id' => $deliveryOrder->id,
                            'product_id' => $detail->product_id,
                            'inventory_id' => $inventoryId,
                            'quantity' => $quantity,
                            'unit_price' => $detail->unit_price,
                            'discount' => $detail->discount,
                            'total' => $quantity * $detail->unit_price * (1 - $detail->discount / 100),
                            'order_detail_id' => $detail->id
                        ]);
                    }
                }

                // Update order status
                $this->order->delivery_status = $this->deliveryStatus;
                $this->order->modified_by = Auth::id();
                $this->order->save();

                // Update remaining quantity for consignment orders
                if ($originalOrder->workflow_type === OrderWorkflowType::CONSIGNMENT) {
                    if ($this->isInitialConsignment) {
                        $this->order->remaining_quantity = $orderTotalQuantity;
                    } else {
                        $newRemainingQuantity = $this->remainingQuantity - $totalSelectedQuantity;
                        if ($newRemainingQuantity < 0) {
                            throw new \Exception("Invalid remaining quantity calculation.");
                        }
                        $this->order->remaining_quantity = $newRemainingQuantity;
                    }
                    $this->order->save();
                }
                Log::info('Delivery Update Completed', [
                    'order_id' => $this->order_id,
                    'final_delivery_status' => $this->deliveryStatus,
                    'remaining_quantity' => $this->remainingQuantity ?? null
                ]);
                notyf()->success('Delivery updated successfully.');
                return redirect()->route('admin.orders.delivery', $this->order_id);
            });
        } catch (\Exception $e) {
            Log::error('Delivery update error: ' . $e->getMessage());
            notyf()->error('Error updating delivery: ' . $e->getMessage());
            return false;
        }
    }
    private function processInventoryUpdates($detail, $inventoryQuantities)
    {
        foreach ($inventoryQuantities as $inventoryId => $quantity) {
            if ($quantity <= 0) continue;

            $inventory = Inventory::findOrFail($inventoryId);
            if ($inventory->product_id !== $detail->product_id) continue;

            if ($inventory->remaining < $quantity) {
                throw new \Exception("Insufficient quantity in inventory #{$inventoryId}");
            }

            $inventory->consumed += $quantity;
            $inventory->remaining = $inventory->quantity - $inventory->consumed;
            $inventory->modified_by = Auth::id();
            $inventory->save();

            Stock::create([
                'inventory_id' => $inventory->id,
                'product_id' => $detail->product_id,
                'previous_quantity' => $inventory->remaining + $quantity,
                'quantity_change' => -$quantity,
                'new_quantity' => $inventory->remaining,
                'reason' => $this->isInitialConsignment ?
                    'Initial Consignment Delivery' :
                    'Consignment Sale Delivery',
                'created_by' => Auth::id(),
            ]);

            if ($inventory->warehouse?->email) {
                $inventory->warehouse->notify(new WarehouseOrderUpdate($this->order, $inventory));
            }
            
        }
    }

    private function generateConsignmentSaleInvoice($deliveredQuantity)
    {
        try {
            DB::transaction(function () use ($deliveredQuantity) {
                $orderInvoice = OrderInvoice::where('order_id', $this->order->order_id)->first();
                if (!$orderInvoice) {
                    $orderInvoice = OrderInvoice::where('order_id', $this->order->order_id)->firstOrFail();
                    throw new \Exception("OrderInvoice not found for order_id: {$this->order->order_id}");
                }
                foreach ($this->inventoryQuantities as $inventoryId => $quantity) {
                    if ($quantity <= 0) continue;

                    $inventory = Inventory::find($inventoryId);
                    if (!$inventory) continue;
                    $warehouseId = $inventory->warehouse_id;
                    $deliveryOrder = DeliveryOrder::create([
                        'order_id' => $this->order->order_id,
                        'delivery_number' => DeliveryOrder::generateDeliveryNumber(),
                        'warehouse_id' => $warehouseId,
                        'delivery_date' => now(),
                        'status' => 'Delivered',
                        'remarks' => 'Generated for partial delivery',
                        'created_by' => Auth::id(),
                        'modified_by' => Auth::id(),
                        'order_invoice_id' => $orderInvoice->id
                    ]);
                    foreach ($this->order->orderDetails as $detail) {
                        if ($detail->product_id !== $inventory->product_id) continue;
                        $detailQuantity = $this->calculateDetailQuantity($detail, $quantity);
                        if ($detailQuantity > 0) {
                            DeliveryOrderDetail::create([
                                'delivery_order_id' => $deliveryOrder->id,
                                'product_id' => $detail->product_id,
                                'quantity' => $detailQuantity,
                            ]);
                        }
                    }

                    Log::info('Delivery Order generated', [
                        'order_id' => $this->order->order_id,
                        'delivery_order_id' => $deliveryOrder->id,
                        'delivered_quantity' => $quantity,
                    ]);
                }
            });

            return true;
        } catch (\Exception $e) {
            Log::error('Error generating delivery order: ' . $e->getMessage(), [
                'order_id' => $this->order->order_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    private function calculateDetailQuantity($detail, $totalDeliveredQuantity)
    {
        $originalTotalQuantity = $this->order->orderDetails->sum('quantity');
        if ($originalTotalQuantity <= 0) return 0;

        $ratio = $totalDeliveredQuantity / $originalTotalQuantity;
        return round($detail->quantity * $ratio);
    }

    private function calculateRemainingQuantity($detail)
{
    Log::info('Calculating Remaining Quantity for Product', [
        'order_id' => $this->order_id,
        'product_id' => $detail->product_id,
        'workflow_type' => $this->order->workflow_type
    ]);

    // Get existing deliveries for this specific product
    $existingDeliveries = DeliveryOrderDetail::whereHas('deliveryOrder', function ($query) {
        $query->where('order_id', $this->order_id);
    })
    ->where('product_id', $detail->product_id)
    ->sum('quantity');

    // Calculate selected quantity from inventories for this product
    $selectedQuantity = collect($this->inventoryQuantities)
        ->filter(function ($qty, $invId) use ($detail) {
            return $detail->product->inventories->contains('id', $invId);
        })
        ->sum();

    switch ($this->order->workflow_type) {
        case OrderWorkflowType::MULTI_DELIVERY:
            $remaining = $detail->quantity - $existingDeliveries;
            break;

        case OrderWorkflowType::STANDARD:
            $remaining = $existingDeliveries > 0 ? 0 : $detail->quantity;
            break;

        case OrderWorkflowType::CONSIGNMENT:
            if ($this->isInitialConsignment) {
                $remaining = $existingDeliveries > 0 ? 0 : $detail->quantity;
            } else {
                // For non-initial consignment, calculate per-product remaining quantity
                $productRatio = $detail->quantity / $this->order->orderDetails->sum('quantity');
                $productRemaining = ceil($this->order->remaining_quantity * $productRatio);
                $remaining = $productRemaining - $existingDeliveries;
            }
            break;

        default:
            $remaining = 0;
    }

    $remaining = max(0, $remaining);

    Log::info('Product Remaining Quantity Calculated', [
        'order_id' => $this->order_id,
        'product_id' => $detail->product_id,
        'product_name' => $detail->product->product_name,
        'ordered_quantity' => $detail->quantity,
        'existing_deliveries' => $existingDeliveries,
        'selected_quantity' => $selectedQuantity,
        'remaining_quantity' => $remaining
    ]);

    return $remaining;
}

    private function validateDeliveryQuantities($productQuantities)
    {
        Log::info('Validating Delivery Quantities', [
            'order_id' => $this->order_id,
            'workflow_type' => $this->order->workflow_type,
            'product_quantities' => $productQuantities
        ]);

        foreach ($productQuantities as $productId => $quantities) {
            $existingDeliveries = DeliveryOrderDetail::whereHas('deliveryOrder', function ($query) {
                $query->where('order_id', $this->order_id);
            })
            ->where('product_id', $productId)
            ->sum('quantity');

            $totalAfterDelivery = $existingDeliveries + $quantities['selected'];
            $maxAllowed = $quantities['ordered'];

            if ($totalAfterDelivery > $maxAllowed) {
                Log::warning('Product Quantity Validation Failed', [
                    'product_id' => $productId,
                    'product_name' => $quantities['name'],
                    'ordered' => $maxAllowed,
                    'existing_deliveries' => $existingDeliveries,
                    'attempted_delivery' => $quantities['selected'],
                    'would_exceed_by' => $totalAfterDelivery - $maxAllowed
                ]);

                notyf()->error("Cannot deliver more than ordered quantity for {$quantities['name']}. " . 
                              "Ordered: {$maxAllowed}, " .
                              "Already Delivered: {$existingDeliveries}, " .
                              "Attempting to deliver: {$quantities['selected']}");
                return false;
            }
        }

        return true;
    }

    private function validateWorkflowRules()
    {
        Log::info('Validating Workflow Rules', [
            'order_id' => $this->order_id,
            'workflow_type' => $this->order->workflow_type,
            'is_initial_consignment' => $this->isInitialConsignment ?? false,
            'total_selected' => array_sum($this->inventoryQuantities)
        ]);

        switch ($this->order->workflow_type) {
            case OrderWorkflowType::MULTI_DELIVERY:
                $productValidations = [];
                foreach ($this->order->orderDetails as $detail) {
                    $existingDeliveries = DeliveryOrderDetail::whereHas('deliveryOrder', function ($query) {
                        $query->where('order_id', $this->order_id);
                    })
                    ->where('product_id', $detail->product_id)
                    ->sum('quantity');

                    $selectedQuantity = array_sum(array_intersect_key(
                        $this->inventoryQuantities,
                        $detail->product->inventories->pluck('id')->flip()->all()
                    ));

                    $productValidations[$detail->product_id] = [
                        'name' => $detail->product->product_name,
                        'ordered' => $detail->quantity,
                        'delivered' => $existingDeliveries,
                        'selected' => $selectedQuantity,
                        'remaining' => $detail->quantity - $existingDeliveries,
                        'valid' => ($existingDeliveries + $selectedQuantity) <= $detail->quantity
                    ];
                }

                Log::info('Multi-Delivery Validation', [
                    'order_id' => $this->order_id,
                    'product_validations' => $productValidations
                ]);

                $invalid = collect($productValidations)->first(function ($validation) {
                    return !$validation['valid'];
                });

                if ($invalid) {
                    notyf()->error("Cannot exceed ordered quantity for {$invalid['name']}. " .
                                  "Ordered: {$invalid['ordered']}, " .
                                  "Delivered: {$invalid['delivered']}, " .
                                  "Selected: {$invalid['selected']}, " .
                                  "Remaining: {$invalid['remaining']}");
                    return false;
                }
                return true;

            case OrderWorkflowType::STANDARD:
                $existingDeliveries = DeliveryOrderDetail::whereHas('deliveryOrder', function ($query) {
                    $query->where('order_id', $this->order_id);
                })->exists();

                if ($existingDeliveries) {
                    notyf()->error('Standard orders can only have one delivery.');
                    return false;
                }

                $totalSelected = array_sum($this->inventoryQuantities);
                $orderTotal = $this->order->orderDetails->sum('quantity');

                if ($totalSelected !== $orderTotal) {
                    notyf()->error("Standard orders must deliver exact quantity. " .
                                  "Expected: {$orderTotal}, Selected: {$totalSelected}");
                    return false;
                }
                return true;

            case OrderWorkflowType::CONSIGNMENT:
                if ($this->isInitialConsignment) {
                    // Initial consignment behaves like standard order
                    $existingDeliveries = DeliveryOrderDetail::whereHas('deliveryOrder', function ($query) {
                        $query->where('order_id', $this->order_id);
                    })->exists();

                    if ($existingDeliveries) {
                        notyf()->error('Initial consignment can only have one delivery.');
                        return false;
                    }

                    $totalSelected = array_sum($this->inventoryQuantities);
                    $orderTotal = $this->order->orderDetails->sum('quantity');

                    if ($totalSelected !== $orderTotal) {
                        notyf()->error("Initial consignment must deliver exact quantity. " .
                                      "Expected: {$orderTotal}, Selected: {$totalSelected}");
                        return false;
                    }
                } else {
                    // Non-initial consignment behaves like standard order
                    $existingDeliveries = DeliveryOrderDetail::whereHas('deliveryOrder', function ($query) {
                        $query->where('order_id', $this->order_id);
                    })->exists();

                    if ($existingDeliveries) {
                        notyf()->error('Consignment orders can only have one delivery.');
                        return false;
                    }

                    $totalSelected = array_sum($this->inventoryQuantities);
                    $orderTotal = $this->order->orderDetails->sum('quantity');

                    if ($totalSelected !== $orderTotal) {
                        notyf()->error("Consignment orders must deliver exact quantity. " .
                                      "Expected: {$orderTotal}, Selected: {$totalSelected}");
                        return false;
                    }
                }
                return true;

            default:
                return true;
        }
    }

    public function render()
    {
        return view('livewire.admin.orders.order-delivery');
    }
}
