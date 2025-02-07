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
                $this->inventorySampleQuantities[$inventory->id] = 0;

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
        return collect($this->inventorySampleQuantities)
            ->filter(function ($qty, $invId) use ($detail) {
                return $detail->product->inventories->contains('id', $invId);
            })
            ->map(fn($value) => (float) $value) 
            ->sum();
    }

    public function updateDelivery()
    {
        $this->validate();
        try {
            DB::transaction(function () {
                $originalOrder = $this->order;

                foreach ($this->order->orderDetails as $detail) {
                    $totalSelectedSamples = $this->getTotalSelectedSampleQuantity($detail);
                    $remainingSamples = $this->calculateRemainingSampleQuantity($detail);

                    if ($totalSelectedSamples > $remainingSamples) {
                        throw new \Exception("Selected sample quantity ({$totalSelectedSamples}) exceeds remaining sample quantity ({$remainingSamples}) for product {$detail->product->product_name}");
                    }
                }
                $totalSelectedQuantity = array_sum(array_map('intval', $this->inventoryQuantities));

                $existingDeliveries = DeliveryOrderDetail::whereHas('deliveryOrder', function ($query) use ($originalOrder) {
                    $query->where('order_id', $originalOrder->order_id);
                })->sum('quantity');

                $orderTotalQuantity = $originalOrder->orderDetails->sum('quantity');

                if (
                    $existingDeliveries > 0 &&
                    in_array($originalOrder->workflow_type, [
                        OrderWorkflowType::STANDARD,
                        OrderWorkflowType::CONSIGNMENT
                    ])
                ) {
                    notyf()->error("This order type can only be delivered once.");
                    return false;
                }

                if ($originalOrder->workflow_type === OrderWorkflowType::STANDARD) {
                    if ($totalSelectedQuantity !== $orderTotalQuantity) {
                        notyf()->error("For Standard orders, you must deliver the exact order quantity of {$orderTotalQuantity}.");
                        return false;
                    }
                } elseif ($originalOrder->workflow_type === OrderWorkflowType::CONSIGNMENT) {
                    if ($this->isInitialConsignment) {
                        if ($totalSelectedQuantity !== $orderTotalQuantity) {
                            notyf()->error("Initial Consignment delivery must be the exact order quantity of {$orderTotalQuantity}.");
                            return false;
                        }
                    } else {
                        $remainingQuantity = $originalOrder->orderDetails()->sum('remaining_quantity');

                        if ($totalSelectedQuantity > $remainingQuantity) {
                            notyf()->error("Cannot deliver more than remaining quantity: {$remainingQuantity}.");
                            return false;
                        }

                        if (abs($totalSelectedQuantity - $remainingQuantity) > 0.001) {
                            notyf()->error("You must deliver the exact remaining quantity of {$remainingQuantity}.");
                            return false;
                        }
                    }
                } elseif ($originalOrder->workflow_type === OrderWorkflowType::MULTI_DELIVERY) {
                    $totalQuantitiesToDeliver = [];

                    foreach ($this->inventoryQuantities as $inventoryId => $quantity) {
                        if ($quantity > 0) {
                            $inventory = Inventory::findOrFail($inventoryId);
                            $productDetail = $originalOrder->orderDetails->where('product_id', $inventory->product_code)->first();
                            if (!$productDetail) {
                                notyf()->error("Product Code {$inventory->product_code} not found in the order details.");
                                return false;
                            }
                            if (!isset($totalQuantitiesToDeliver[$inventory->product_code])) {
                                $totalQuantitiesToDeliver[$inventory->product_code] = 0;
                            }
                            $totalQuantitiesToDeliver[$inventory->product_code] += $quantity;

                            $deliveredQuantity = DeliveryOrderDetail::whereHas('deliveryOrder', function ($query) use ($originalOrder) {
                                $query->where('order_id', $originalOrder->order_id);
                            })
                                ->where('product_id', $inventory->product_code)
                                ->sum('quantity');

                            $totalQuantityToDeliver = $deliveredQuantity + $totalQuantitiesToDeliver[$inventory->product_code];

                            if ($totalQuantityToDeliver > $productDetail->quantity) {
                                notyf()->error("Cannot deliver more than the ordered quantity for product Code {$inventory->product_code}. Ordered: {$productDetail->quantity}, Already Delivered: {$deliveredQuantity}, Requested: {$totalQuantitiesToDeliver[$inventory->product_code]}");
                                return false;
                            }
                        }
                    }
                    $totalDeliveredQuantity = DeliveryOrderDetail::whereHas('deliveryOrder', function ($query) use ($originalOrder) {
                        $query->where('order_id', $originalOrder->order_id);
                    })->sum('quantity');

                    if ($totalDeliveredQuantity > $orderTotalQuantity) {
                        notyf()->error("Cannot deliver more than the total order quantity of {$orderTotalQuantity}. Total already delivered: {$totalDeliveredQuantity}");
                        return false;
                    }
                }
                $warehouseDeliveryOrders = [];
                $warehouseProductDetails = [];
                foreach ($this->inventoryQuantities as $inventoryId => $quantity) {
                    if ($quantity > 0 || $this->inventorySampleQuantities[$inventoryId] > 0) {
                        $orderInvoice = OrderInvoice::where('order_id', $this->order->order_id)->firstOrFail();

                        $inventory = Inventory::findOrFail($inventoryId);
                        $warehouseId = $inventory->warehouse_id;

                        if ($quantity > $inventory->remaining) {
                            throw new \Exception("Insufficient inventory for inventory ID {$inventoryId}. Available: {$inventory->remaining}, Requested: {$quantity}");
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
                                'status' => 'Delivered',
                                'remarks' => $this->remarks,
                                'created_by' => Auth::id(),
                                'modified_by' => Auth::id(),
                                'order_invoice_id' => $orderInvoice->id,
                            ]);
                            $warehouseDeliveryOrders[$warehouseId] = $deliveryOrder;
                        }

                        $deliveryOrder = $warehouseDeliveryOrders[$warehouseId];
                        foreach ($this->order->orderDetails as $detail) {
                            if ($detail->product_id === $inventory->product_code) {
                                if ($this->inventorySampleQuantities[$inventoryId] > 0) {
                                    if ($detail->sample_quantity_remaining >= $this->inventorySampleQuantities[$inventoryId]) {
                                        $detail->decrement('sample_quantity_remaining', $this->inventorySampleQuantities[$inventoryId]);
                                    } else {
                                        throw new \Exception("Not enough sample quantity remaining for product ID {$detail->product_id}.");
                                    }
                                }
                                DeliveryOrderDetail::create([
                                    'delivery_order_id' => $deliveryOrder->id,
                                    'product_id' => $detail->product_id,
                                    'inventory_id' => $inventoryId,
                                    'sample_quantity' => $this->inventorySampleQuantities[$inventoryId],
                                    'quantity' => $quantity,
                                    'unit_price' => $detail->unit_price,
                                    'discount' => $detail->discount,
                                    'total' => $quantity * $detail->unit_price * (1 - $detail->discount / 100),
                                    'order_detail_id' => $detail->id,
                                ]);
                                if (!isset($warehouseProductDetails[$warehouseId])) {
                                    $warehouseProductDetails[$warehouseId] = [];
                                }
                                Log::info("Delivery Order Detail Created", [
                                    'product' => $detail->product->product_name,
                                    'quantity' => $quantity,
                                    'sample_quantity' => $this->inventorySampleQuantities[$inventoryId]
                                ]);
                                $warehouseProductDetails[$warehouseId][] = [
                                    'product_name' => $detail->product->product_name,
                                    'quantity' => $quantity,
                                    'sample_quantity' => $this->inventorySampleQuantities[$inventoryId],

                                ];
                                break;
                            }
                        }
                    }
                }

                foreach ($warehouseDeliveryOrders as $warehouseId => $deliveryOrder) {
                    $warehouseName = Warehouse::where('id', $warehouseId)->value('warehouse_name');
                    $emails = DB::table('warehouse_emails')->where('warehouse_id', $warehouseId)->pluck('email');
                    $shippingAddress = $this->order->shipping_address;
                    foreach ($emails as $email) {
                        Notification::route('mail', $email)->notify(new WarehouseOrderUpdate(
                            $this->order->load(['customer']),
                            $warehouseProductDetails[$warehouseId],
                            $deliveryOrder,
                            $warehouseName,
                            $shippingAddress
                        ));
                    }
                }

                $this->order->delivery_status = $this->deliveryStatus;
                $this->order->modified_by = Auth::id();
                $this->order->save();

                if ($this->order->workflow_type === OrderWorkflowType::CONSIGNMENT) {
                    if ($this->isInitialConsignment) {
                        $this->order->remaining_quantity = $this->order->orderDetails->sum('quantity');
                    } else {
                        $parentOrder = $originalOrder->parent_order_id ?
                            OrderMaster::find($originalOrder->parent_order_id) :
                            $originalOrder;
                        if ($parentOrder) {
                            $newRemainingQuantity = $remainingQuantity - $totalSelectedQuantity;
                            if ($newRemainingQuantity < 0) {
                                notyf()->error("Invalid remaining quantity calculation.");
                                return false;
                            }
                            $parentOrder->remaining_quantity = $newRemainingQuantity;
                            $parentOrder->save();
                        }
                    }
                }Log::info("Order Delivery Updated Successfully", ['order_id' => $this->order_id]);

                notyf()->success('Delivery updated successfully.');
                return redirect()->route('admin.orders.details', ['order_id' => $this->order_id]);

            });
        } catch (\Exception $e) {
            Log::error('Delivery update error: ' . $e->getMessage());
            notyf()->error('Error updating delivery: ' . $e->getMessage());
            return false;
        }
    }

    public function render()
    {
        return view('livewire.admin.orders.order-delivery');
    }
}
