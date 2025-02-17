<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Stock;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\OrderMaster;
use App\Models\OrderInvoice;
use App\Models\Warehouse;
use App\Models\DeliveryOrder;
use App\Enums\OrderWorkflowType;
use Illuminate\Support\Facades\DB;
use App\Models\DeliveryOrderDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Notifications\WarehouseOrderUpdate;
use Illuminate\Support\Facades\Notification;


class OrderDelivery extends Component
{
    public $order_id;
    public $order;
    public $currencySymbol;
    public $deliveryStatus;
    public $remarks;
    public $selectedInventories = [];
    public $inventoryQuantities = [];
    public $inventorySampleQuantities = [];
    public $totalOrderQuantity = 0;
    public $remainingQuantity = 0;
    public $isInitialConsignment = false;

    protected $rules = [
        'deliveryStatus' => 'required|in:Pending,Shipped,Delivered,Cancelled',
        'inventoryQuantities.*' => 'nullable|integer|min:0',
        'inventorySampleQuantities.*' => 'nullable|integer|min:0',
        'remarks' => 'nullable|string|max:255'
    ];

    public function mount($order_id)
    {
        $this->order_id = $order_id;
        $this->order = OrderMaster::with(['customer', 'orderDetails.product.inventories', 'currency'])
            ->where('order_id', $order_id)
            ->firstOrFail();

        $this->currencySymbol = $this->order->currency ? $this->order->currency->symbol : '$';

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
                $key = $inventory->id . '_' . $detail->id;
                $this->inventoryQuantities[$key] = 0;
                $this->inventorySampleQuantities[$key] = 0;
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

    public function calculateRemainingQuantity($orderDetail)
    {
        if ($this->order->workflow_type === OrderWorkflowType::MULTI_DELIVERY) {
            $deliveredQuantity = DeliveryOrderDetail::whereHas('deliveryOrder', function ($query) use ($orderDetail) {
                $query->where('order_id', $this->order->order_id);
            })
                ->where('order_detail_id', $orderDetail->id)
                ->sum('quantity');

            return $orderDetail->quantity - $deliveredQuantity;
        }
        return $orderDetail->quantity;
    }

    public function calculateRemainingSampleQuantity($orderDetail)
    {
        $deliveredSampleQuantity = DeliveryOrderDetail::whereHas('deliveryOrder', function ($query) use ($orderDetail) {
            $query->where('order_id', $this->order->order_id);
        })
            ->where('order_detail_id', $orderDetail->id)
            ->sum('sample_quantity');

        return (float) $orderDetail->sample_quantity - (float) $deliveredSampleQuantity;
    }

    public function getTotalSelectedSampleQuantity($detail)
    {
        return collect($this->inventorySampleQuantities)->filter(function ($qty, $invKey) use ($detail) {
            $inventoryId = (int) explode('_', $invKey)[0];
            $detailId = (int) explode('_', $invKey)[1];
            return $detail->id === $detailId &&
                $detail->product->inventories->contains('id', $inventoryId);
        })->map(fn($value) => (float) $value)->sum();
    }
    public function updateDelivery()
    {
        $this->validate();        
        if (empty($this->inventoryQuantities)) {
            Log::error("Inventory quantities are empty for order {$this->order->order_id}. No deliveries to process.");
            notyf()->error("No quantities selected for delivery.");
            return false;
        }

        try {
            DB::transaction(function () {
                $originalOrder = $this->order;
                $totalSelectedSamples = 0;
                $totalSelectedQuantity = 0;

                foreach ($this->order->orderDetails as $detail) {
                    Log::info("Processing OrderDetail ID: {$detail->id}", [
                        'product_name' => $detail->product->product_name,
                        'order_quantity' => $detail->quantity
                    ]);

                    $totalSelectedSamples = $this->getTotalSelectedSampleQuantity($detail);
                    $remainingSamples = $this->calculateRemainingSampleQuantity($detail);

                    if ($totalSelectedSamples > $remainingSamples) {
                        Log::error("Sample quantity exceeds limit for product {$detail->product->product_name}", [
                            'selected_samples' => $totalSelectedSamples,
                            'remaining_samples' => $remainingSamples,
                            'order_id' => $originalOrder->order_id
                        ]);
                        throw new \Exception("Selected sample quantity exceeds the remaining quantity.");
                    }

                    foreach ($detail->product->inventories as $inventory) {
                        $key = $inventory->id . '_' . $detail->id;
                        $selectedQty = $this->inventoryQuantities[$key] ?? 0;
                        $totalSelectedQuantity += $selectedQty;
                    }
                }

                $totalSelectedQuantity = array_sum(array_map('intval', $this->inventoryQuantities));
                $existingDeliveries = DeliveryOrderDetail::whereHas('deliveryOrder', function ($query) use ($originalOrder) {
                    $query->where('order_id', $originalOrder->order_id);
                })->sum('quantity');

                $orderTotalQuantity = $originalOrder->orderDetails->sum('quantity');

                if (
                    $existingDeliveries > 0 && in_array($originalOrder->workflow_type, [
                        OrderWorkflowType::STANDARD,
                        OrderWorkflowType::CONSIGNMENT
                    ])
                ) {
                    Log::warning("Attempted multiple delivery for single-delivery workflow.", ['workflow_type' => $originalOrder->workflow_type]);
                    notyf()->error("This order type can only be delivered once.");
                    return false;
                }

                if ($originalOrder->workflow_type === OrderWorkflowType::STANDARD && $totalSelectedQuantity !== $orderTotalQuantity) {
                    notyf()->error("For Standard orders, you must deliver the exact order quantity of {$orderTotalQuantity}.");
                    return false;
                }

                if ($originalOrder->workflow_type === OrderWorkflowType::CONSIGNMENT) {
                    if ($this->isInitialConsignment && $totalSelectedQuantity !== $orderTotalQuantity) {
                        notyf()->error("Initial Consignment delivery must be the exact order quantity of {$orderTotalQuantity}.");
                        return false;
                    }

                    $remainingQuantity = $originalOrder->orderDetails()->sum('remaining_quantity');
                    if ($totalSelectedQuantity > $remainingQuantity) {
                        notyf()->error("Cannot deliver more than the remaining quantity: {$remainingQuantity}.");
                        return false;
                    }
                }

                if ($originalOrder->workflow_type === OrderWorkflowType::MULTI_DELIVERY) {
                    foreach ($this->inventoryQuantities as $inventoryId => $quantity) {
                        if ($quantity > 0) {
                            $inventory = Inventory::find($inventoryId);
                            if (!$inventory) {
                                notyf()->error("Inventory not found for ID: {$inventoryId}.");
                                return false;
                            }

                            $productDetail = $originalOrder->orderDetails->where('product_id', $inventory->product_code)->first();

                            if ($productDetail) {
                                $existingDeliveriesForProduct = DeliveryOrderDetail::whereHas('deliveryOrder', function ($query) use ($originalOrder) {
                                    $query->where('order_id', $originalOrder->order_id);
                                })
                                ->where('product_id', $productDetail->product_id)
                                ->where('inventory_id', $inventory->id) 
                                ->sum('quantity');
                            
                                $totalQuantityToDeliver = $existingDeliveriesForProduct + $quantity;
                            
                                if ($totalQuantityToDeliver > $productDetail->quantity) {
                                    Log::error("Cannot deliver more than the ordered quantity for product Code {$inventory->product_code}.", [
                                        'order_id' => $originalOrder->order_id,
                                        'product_code' => $inventory->product_code,
                                        'ordered_quantity' => $productDetail->quantity,
                                        'attempted_quantity' => $totalQuantityToDeliver
                                    ]);
                                    notyf()->error("Cannot deliver more than the ordered quantity for product Code {$inventory->product_code}.");
                                    return false;
                                }
                            } else {
                                Log::error("No product detail found for product code {$inventory->product_code}.", [
                                    'order_id' => $originalOrder->order_id,
                                    'product_code' => $inventory->product_code
                                ]);
                                notyf()->error("Product detail not found for product code {$inventory->product_code}.");
                                return false;
                            }
                            

                        }
                    }
                }

                $this->createDeliveryOrders();
                notyf()->success('Delivery updated successfully.');
                return redirect("/admin/orders/{$this->order_id}");
            });
        } catch (\Exception $e) {
            Log::error('Delivery update error.', ['error' => $e->getMessage(), 'order_id' => $this->order->order_id ?? 'N/A']);
            notyf()->error('Error updating delivery: ' . $e->getMessage());
            return false;
        }

        Log::info('Delivery update completed successfully.');
    }

    private function createDeliveryOrders()
    {
        $warehouseDeliveryOrders = [];

        foreach ($this->inventoryQuantities as $inventoryId => $quantity) {
            if ($quantity > 0 || ($this->inventorySampleQuantities[$inventoryId] ?? 0) > 0) {
                try {
                    $orderInvoice = OrderInvoice::where('order_id', $this->order->order_id)->firstOrFail();
                } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                    Log::error("OrderInvoice not found for order {$this->order->order_id}.");
                    notyf()->error("Order invoice not found.");
                    return false;
                }

                list($inventoryIds, $orderDetailId) = explode('_', $inventoryId);
                $inventory = Inventory::findOrFail($inventoryIds);
                $warehouseId = $inventory->warehouse_id;

                if ($quantity > $inventory->remaining) {
                    throw new \Exception("Insufficient inventory for inventory ID {$inventoryId}.");
                }

                if (!$warehouseId) {
                    throw new \Exception("Warehouse ID not found for inventory_id: {$inventoryId}");
                }

                $inventory->decrement('remaining', $quantity);
                $inventory->increment('consumed', $quantity);
                $inventory->modified_by = Auth::id();
                $inventory->save();

                if (!isset($warehouseDeliveryOrders[$warehouseId])) {
                    $deliveryOrder = DeliveryOrder::create([
                        'order_id' => $this->order->order_id,
                        'delivery_number' => DeliveryOrder::generateDeliveryNumber(),
                        'warehouse_id' => $warehouseId,
                        'delivery_date' => now(),
                        'status' => 'Pending',
                        'remarks' => $this->remarks,
                        'created_by' => Auth::id(),
                        'modified_by' => Auth::id(),
                        'order_invoice_id' => $orderInvoice->id,
                    ]);
                    $warehouseDeliveryOrders[$warehouseId] = $deliveryOrder;
                }

                $deliveryOrder = $warehouseDeliveryOrders[$warehouseId];
                $detail = $this->order->orderDetails->firstWhere('id', $orderDetailId);

                if ($detail) {
                    $sampleQty = $this->inventorySampleQuantities[$inventoryId] ?? 0;
                    if ($sampleQty > 0 && $detail->sample_quantity_remaining >= $sampleQty) {
                        $detail->decrement('sample_quantity_remaining', $sampleQty);
                        Log::info("Updated remaining sample quantity for OrderDetail {$detail->id}: {$detail->sample_quantity_remaining}");

                    }

                    $total = $quantity * $detail->unit_price * (1 - $detail->discount / 100);

                    DeliveryOrderDetail::create([
                        'delivery_order_id' => $deliveryOrder->id,
                        'product_id' => $detail->product_id,
                        'inventory_id' => $inventoryIds,
                        'sample_quantity' => $sampleQty,
                        'quantity' => $quantity,
                        'unit_price' => $detail->unit_price,
                        'discount' => $detail->discount,
                        'total' => $total,
                        'order_detail_id' => $detail->id,
                    ]);
                } else {
                    throw new \Exception("Order detail not found for ID {$orderDetailId}.");
                }
            }
        }

        $deliveryOrders = DeliveryOrder::where('order_id', $this->order->order_id)->with('details')->get();
        foreach ($deliveryOrders as $order) {
            Log::info('Final Delivery Order State', [
                'delivery_order_id' => $order->id,
                'details' => $order->details->map(function ($detail) {
                    return [
                        'inventory_id' => $detail->inventory_id,
                        'quantity' => $detail->quantity
                    ];
                }),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.orders.order-delivery');
    }
}
