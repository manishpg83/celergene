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
                $totalSelectedQuantity = array_sum(array_map('intval', $this->inventoryQuantities));

                $originalOrder = $this->order;

                if ($originalOrder->workflow_type === OrderWorkflowType::STANDARD) {
                    $orderTotalQuantity = $originalOrder->orderDetails->sum('quantity');

                    if ($totalSelectedQuantity !== $orderTotalQuantity) {
                        notyf()->error("For Standard orders, the delivered quantity must equal the order quantity: {$orderTotalQuantity}. You entered: {$totalSelectedQuantity}");
                        return;
                    }
                }
                else if ($originalOrder->workflow_type === OrderWorkflowType::CONSIGNMENT) {
                    if ($this->isInitialConsignment) {
                        $orderTotalQuantity = $originalOrder->orderDetails->sum('quantity');
                        if ($totalSelectedQuantity !== $orderTotalQuantity) {
                            notyf()->error("Initial consignment delivery must equal full order quantity: {$orderTotalQuantity}");
                            return;
                        }
                    } else {
                        $remainingQuantity = $originalOrder->orderDetails()
                            ->sum('remaining_quantity');

                        if ($totalSelectedQuantity > $remainingQuantity) {
                            notyf()->error("Cannot deliver more than the remaining quantity: {$remainingQuantity}. Attempted: {$totalSelectedQuantity}");
                            return;
                        }
                    }
                }

                foreach ($this->order->orderDetails as $detail) {
                    $this->processInventoryUpdates($detail, $this->inventoryQuantities);
                    $orderInvoice = OrderInvoice::where('order_id', $this->order->order_id)->first();
                    if (!$orderInvoice) {
                        // Either retrieve the order invoice again or handle this case differently
                        $orderInvoice = OrderInvoice::where('order_id', $this->order->order_id)->firstOrFail();
                        // or
                        throw new \Exception("OrderInvoice not found for order_id: {$this->order->order_id}");
                    }
                    foreach ($this->inventoryQuantities as $inventoryId => $quantity) {
                        if ($quantity > 0) {
                            if ($quantity > $this->remainingQuantity) {
                                notyf()->error("Cannot deliver more than the remaining quantity: {$this->remainingQuantity}. Attempted: {$quantity}");
                                Log::error("Delivery update failed for Order ID {$this->order_id}: Attempted quantity {$quantity} exceeds remaining quantity {$this->remainingQuantity} for product ID {$detail->product_id}.");
                                return;
                            }
                
                           
                            $inventory = Inventory::find($inventoryId);
                            if (!$inventory) {
                                throw new \Exception("Inventory not found for inventory_id: {$inventoryId}");
                            }
                            
                            $warehouseId = $inventory->warehouse_id;
                            
                            if (!$warehouseId) {
                                throw new \Exception("Warehouse ID not found for inventory_id: {$inventoryId}");
                            }

                            Log::info("Updating DeliveryOrderDetail for Order ID {$this->order_id}, Product ID {$detail->product_id}, Inventory ID {$inventoryId}, Quantity: {$quantity}");
                            
                            $deliveryOrder = DeliveryOrder::create([
                                'order_id' => $this->order->order_id,
                                'delivery_number' => DeliveryOrder::generateDeliveryNumber(),
                                'warehouse_id' => $warehouseId,
                                'delivery_date' => now(),
                                'status' => 'Delivered',
                                'remarks' => 'Generated for partial delivery',
                                'created_by' => Auth::id(),
                                'modified_by' => Auth::id(),
                                'order_invoice_id' => $orderInvoice->id, 
                            ]);
                
                            DeliveryOrderDetail::updateOrCreate(
                                [
                                    'delivery_order_id' => $deliveryOrder->id,
                                    'product_id' => $detail->product_id,
                                    'inventory_id' => $inventoryId,
                                ],
                                [
                                    'quantity' => $quantity,
                                    'unit_price' => $detail->unit_price,
                                    'discount' => $detail->discount,
                                    'total' => $quantity * $detail->unit_price * (1 - $detail->discount / 100),
                                ]
                            );
                        }
                    }
                }
                

                $this->order->delivery_status = $this->deliveryStatus;

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
                                notyf()->error("Invalid remaining quantity calculation. Current: {$remainingQuantity}, Attempted: {$totalSelectedQuantity}");
                                return;
                            }
                            $parentOrder->remaining_quantity = $newRemainingQuantity;
                            $parentOrder->save();
                        }
                    }
                }

                $this->order->modified_by = Auth::id();
                $this->order->save();

                if (!$this->isInitialConsignment && $totalSelectedQuantity > 0) {
                    $this->generateConsignmentSaleInvoice($totalSelectedQuantity);
                }
            });

            notyf()->success('Delivery updated successfully.');
            return redirect()->route('admin.orders.delivery', $this->order_id);
        } catch (\Exception $e) {
            notyf()->error('Error updating delivery: ' . $e->getMessage());
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
                        // Either retrieve the order invoice again or handle this case differently
                        $orderInvoice = OrderInvoice::where('order_id', $this->order->order_id)->firstOrFail();
                        // or
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

    public function render()
    {
        return view('livewire.admin.orders.order-delivery');
    }
}
