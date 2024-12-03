<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Stock;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\OrderMaster;
use App\Models\OrderDetails;
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

                if ($originalOrder->parent_order_id) {
                    $parentOrder = OrderMaster::find($originalOrder->parent_order_id);
                    $remainingQuantity = $parentOrder ? $parentOrder->remaining_quantity : 0;
                } else {
                    $remainingQuantity = $originalOrder->remaining_quantity ?? $originalOrder->orderDetails->sum('quantity');
                }

                if ($this->order->workflow_type === OrderWorkflowType::CONSIGNMENT) {
                    if ($this->isInitialConsignment) {
                        $orderTotalQuantity = $originalOrder->orderDetails->sum('quantity');
                        if ($totalSelectedQuantity !== $orderTotalQuantity) {
                            throw new \Exception("Initial consignment delivery must equal full order quantity: {$orderTotalQuantity}");
                        }
                    } else {
                        if ($totalSelectedQuantity > $remainingQuantity) {
                            throw new \Exception("Cannot deliver more than remaining quantity: {$remainingQuantity}. Attempted: {$totalSelectedQuantity}");
                        }
                    }
                }

                foreach ($this->order->orderDetails as $detail) {
                    $this->processInventoryUpdates($detail, $this->inventoryQuantities);
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
                                throw new \Exception("Invalid remaining quantity calculation. Current: {$remainingQuantity}, Attempted: {$totalSelectedQuantity}");
                            }
                            $parentOrder->remaining_quantity = $newRemainingQuantity;
                            $parentOrder->save();
                        }
                    }
                }

                $this->order->modified_by = Auth::id();
                $this->order->save();

                if (!$this->isInitialConsignment && $totalSelectedQuantity > 0) {
                    $this->generateConsignmentSaleInvoice($totalSelectedQuantity); // This now creates DeliveryOrder entries.
                }
            });

            session()->flash('success', 'Delivery updated successfully.');
            return redirect()->route('admin.orders.delivery', $this->order_id);
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating delivery: ' . $e->getMessage());
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
                $deliveryOrder = DeliveryOrder::create([
                    'order_id' => $this->order->order_id,
                    'delivery_number' => DeliveryOrder::generateDeliveryNumber(),
                    'warehouse_id' => null,
                    'delivery_date' => now(),
                    'status' => 'Delivered',
                    'remarks' => 'Generated for partial delivery',
                    'created_by' => Auth::id(),
                    'modified_by' => Auth::id(),
                ]);

                foreach ($this->order->orderDetails as $detail) {
                    $detailQuantity = $this->calculateDetailQuantity($detail, $deliveredQuantity);

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
                    'delivered_quantity' => $deliveredQuantity,
                ]);
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
