<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Component;
use App\Models\OrderMaster;
use App\Models\Inventory;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use App\Notifications\WarehouseOrderUpdate;
use App\Enums\OrderWorkflowType;
use App\Models\OrderDetails;

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
                
                // Get the original order and its remaining quantity
                $originalOrder = $this->order;
                
                // Calculate remaining quantity based on order type
                if ($originalOrder->parent_order_id) {
                    // This is a child order, get remaining from parent
                    $parentOrder = OrderMaster::find($originalOrder->parent_order_id);
                    $remainingQuantity = $parentOrder ? $parentOrder->remaining_quantity : 0;
                } else {
                    // This is the parent order
                    $remainingQuantity = $originalOrder->remaining_quantity ?? $originalOrder->orderDetails->sum('quantity');
                }

                \Log::info('Delivery Validation', [
                    'order_id' => $this->order->order_id,
                    'total_selected' => $totalSelectedQuantity,
                    'remaining' => $remainingQuantity,
                    'is_initial' => $this->isInitialConsignment
                ]);

                // Validate quantities based on workflow type
                if ($this->order->workflow_type === OrderWorkflowType::CONSIGNMENT) {
                    if ($this->isInitialConsignment) {
                        // Initial consignment validation
                        $orderTotalQuantity = $originalOrder->orderDetails->sum('quantity');
                        if ($totalSelectedQuantity !== $orderTotalQuantity) {
                            throw new \Exception("Initial consignment delivery must equal full order quantity: {$orderTotalQuantity}");
                        }
                    } else {
                        // For subsequent deliveries, validate against remaining quantity
                        if ($totalSelectedQuantity > $remainingQuantity) {
                            throw new \Exception("Cannot deliver more than remaining quantity: {$remainingQuantity}. Attempted: {$totalSelectedQuantity}");
                        }
                    }
                }

                // Process inventory updates
                foreach ($this->order->orderDetails as $detail) {
                    $this->processInventoryUpdates($detail, $this->inventoryQuantities);
                }

                // Update order status
                $this->order->delivery_status = $this->deliveryStatus;
                
                // Update remaining quantities
                if ($this->order->workflow_type === OrderWorkflowType::CONSIGNMENT) {
                    if ($this->isInitialConsignment) {
                        // For initial consignment, set the full quantity as remaining
                        $this->order->remaining_quantity = $this->order->orderDetails->sum('quantity');
                    } else {
                        // For subsequent deliveries, update the parent order's remaining quantity
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

                $this->order->modified_by = auth()->id();
                $this->order->save();

                // Generate sales invoice for consignment sales
                if (!$this->isInitialConsignment && $totalSelectedQuantity > 0) {
                    $this->generateConsignmentSaleInvoice($totalSelectedQuantity);
                }

                \Log::info('Delivery Update Completed', [
                    'order_id' => $this->order->order_id,
                    'total_selected_quantity' => $totalSelectedQuantity,
                    'new_remaining_quantity' => $this->order->remaining_quantity
                ]);
            });

            session()->flash('success', 'Delivery updated successfully.');
            return redirect()->route('admin.orders.delivery', $this->order_id);

        } catch (\Exception $e) {
            session()->flash('error', 'Error updating delivery: ' . $e->getMessage());
            \Log::error('Delivery Update Error', [
                'order_id' => $this->order->order_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
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

            // Update inventory
            $inventory->consumed += $quantity;
            $inventory->remaining = $inventory->quantity - $inventory->consumed;
            $inventory->modified_by = auth()->id();
            $inventory->save();

            // Create stock movement record
            Stock::create([
                'inventory_id' => $inventory->id,
                'product_id' => $detail->product_id,
                'previous_quantity' => $inventory->remaining + $quantity,
                'quantity_change' => -$quantity,
                'new_quantity' => $inventory->remaining,
                'reason' => $this->isInitialConsignment ? 
                    'Initial Consignment Delivery' : 
                    'Consignment Sale Delivery',
                'created_by' => auth()->id(),
            ]);

            // Notify warehouse if needed
            if ($inventory->warehouse?->email) {
                $inventory->warehouse->notify(new WarehouseOrderUpdate($this->order, $inventory));
            }
        }
    }

    private function generateConsignmentSaleInvoice($deliveredQuantity)
    {
        try {
            DB::transaction(function () use ($deliveredQuantity) {
                // Get the next order_id
                $lastorder_id = OrderMaster::max('order_id');
                $nextorder_id = $lastorder_id + 1;

                // Create a new invoice for the consignment sale
                $newInvoice = new OrderMaster();
                $newInvoice->order_id = $nextorder_id;
                $newInvoice->order_number = 'DO-' . date('Ymd') . '-' . rand(1000, 9999);
                $newInvoice->parent_order_id = $this->order->parent_order_id ?? $this->order->order_id;
                $newInvoice->order_date = now();
                $newInvoice->customer_id = $this->order->customer_id;
                $newInvoice->entity_id = $this->order->entity_id;
                $newInvoice->shipping_address = $this->order->shipping_address;
                
                // Calculate proportional amounts
                $ratio = $deliveredQuantity / $this->order->orderDetails->sum('quantity');
                $newInvoice->subtotal = round($this->order->subtotal * $ratio, 2);
                $newInvoice->discount = round($this->order->discount * $ratio, 2);
                $newInvoice->freight = round($this->order->freight * $ratio, 2);
                $newInvoice->tax = round($this->order->tax * $ratio, 2);
                $newInvoice->total = round($this->order->total * $ratio, 2);
                
                $newInvoice->payment_mode = $this->order->payment_mode;
                $newInvoice->payment_terms = $this->order->payment_terms;
                $newInvoice->delivery_status = 'Delivered';
                $newInvoice->order_status = 'Pending';
                $newInvoice->order_type = 'Partial';
                $newInvoice->workflow_type = OrderWorkflowType::CONSIGNMENT;
                $newInvoice->is_initial_consignment = false;
                $newInvoice->total_order_quantity = $deliveredQuantity;
                $newInvoice->remaining_quantity = 0;
                $newInvoice->remarks = 'Consignment Sale DO - ' . now()->format('Y-m-d');
                $newInvoice->created_by = auth()->id();
                $newInvoice->modified_by = auth()->id();
                $newInvoice->save();

                // Copy order details with updated quantities
                foreach ($this->order->orderDetails as $detail) {
                    $detailQuantity = $this->calculateDetailQuantity($detail, $deliveredQuantity);
                    
                    if ($detailQuantity > 0) {
                        OrderDetails::create([
                            'order_id' => $nextorder_id,
                            'product_id' => $detail->product_id,
                            'manual_product_name' => $detail->manual_product_name,
                            'unit_price' => $detail->unit_price,
                            'quantity' => $detailQuantity,
                            'discount' => $detail->discount,
                            'total' => round($detailQuantity * $detail->unit_price - $detail->discount, 2),
                        ]);
                    }
                }

                \Log::info('Consignment DO generated', [
                    'original_order_id' => $this->order->order_id,
                    'new_do_id' => $nextorder_id,
                    'delivered_quantity' => $deliveredQuantity,
                    'remaining_quantity' => $this->order->remaining_quantity
                ]);
            });

            return true;
        } catch (\Exception $e) {
            \Log::error('Error generating consignment DO: ' . $e->getMessage(), [
                'order_id' => $this->order->order_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
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
