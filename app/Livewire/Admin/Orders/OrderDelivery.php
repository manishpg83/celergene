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
    public $invoiceId;
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

    public function mount($invoiceId)
    {
        $this->invoiceId = $invoiceId;
        $this->order = OrderMaster::with(['customer', 'orderDetails.product.inventories'])
            ->where('invoice_id', $invoiceId)
            ->firstOrFail();

        $this->deliveryStatus = $this->order->delivery_status;
        
        foreach ($this->order->orderDetails as $detail) {
            foreach ($detail->product->inventories as $inventory) {
                $this->inventoryQuantities[$inventory->id] = 0;
            }
        }

        $deliveredQuantity = abs(Stock::where('reason', 'LIKE', '%Order Delivery Update%')
            ->where('product_id', $this->order->orderDetails->pluck('product_id')->toArray())
            ->sum('quantity_change'));

        switch ($this->order->workflow_type) {
            case OrderWorkflowType::MULTI_DELIVERY->value:
                $this->totalOrderQuantity = $this->order->orderDetails->sum('quantity');
                $this->remainingQuantity = $this->totalOrderQuantity - $deliveredQuantity;
                break;

            case OrderWorkflowType::CONSIGNMENT->value:
                $this->isInitialConsignment = !$this->order->is_initial_consignment;
                if ($this->isInitialConsignment) {
                    $this->totalOrderQuantity = $this->order->orderDetails->sum('quantity');
                    $this->remainingQuantity = $this->totalOrderQuantity;
                } else {
                    $this->totalOrderQuantity = $this->order->orderDetails->sum('quantity');
                    $this->remainingQuantity = $this->totalOrderQuantity - $deliveredQuantity;
                }
                break;
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

                // Validate total selected quantity matches order details
                $orderTotalQuantity = $this->order->orderDetails->sum('quantity');
                
                if ($this->order->workflow_type === OrderWorkflowType::CONSIGNMENT->value) {
                    if ($this->isInitialConsignment) {
                        // For initial consignment, must deliver full quantity
                        if ($totalSelectedQuantity !== $orderTotalQuantity) {
                            throw new \Exception("Initial consignment delivery must equal full order quantity: {$orderTotalQuantity}");
                        }
                    } else {
                        // For subsequent consignment deliveries, check remaining quantity
                        if ($totalSelectedQuantity > $this->remainingQuantity) {
                            throw new \Exception("Cannot deliver more than remaining quantity: {$this->remainingQuantity}");
                        }
                    }
                }

                // Process each order detail
                foreach ($this->order->orderDetails as $detail) {
                    $detailSelectedQuantity = 0;
                    
                    // Process inventory updates for this detail
                    foreach ($this->inventoryQuantities as $inventoryId => $quantity) {
                        if ($quantity > 0) {
                            $inventory = Inventory::findOrFail($inventoryId);
                            
                            // Verify inventory belongs to this product
                            if ($inventory->product_id !== $detail->product_id) {
                                continue;
                            }

                            // Update inventory
                            if ((int)$inventory->remaining < $quantity) {
                                throw new \Exception("Insufficient quantity in inventory #{$inventoryId}");
                            }

                            // Update inventory quantities
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

                            $detailSelectedQuantity += $quantity;

                            // Notify warehouse if needed
                            if ($inventory->warehouse && $inventory->warehouse->email) {
                                $inventory->warehouse->notify(new WarehouseOrderUpdate($this->order, $inventory));
                            }
                        }
                    }
                }

                // Update order status
                $this->order->delivery_status = $this->deliveryStatus;
                
                if ($this->isInitialConsignment) {
                    $this->order->is_initial_consignment = true;
                    $this->order->remaining_quantity = $orderTotalQuantity; // Set initial remaining quantity
                } else {
                    // Update remaining quantity for subsequent deliveries
                    $this->order->remaining_quantity = ($this->order->remaining_quantity ?? $orderTotalQuantity) - $totalSelectedQuantity;
                }
                
                $this->order->modified_by = auth()->id();
                $this->order->save();

                // Create a new invoice for consignment sale if needed
                if (!$this->isInitialConsignment && $totalSelectedQuantity > 0) {
                    // Logic to generate new invoice for the delivered quantity
                    // You'll need to implement this based on your requirements
                    $this->generateConsignmentSaleInvoice($totalSelectedQuantity);
                }
            });

            session()->flash('success', 'Delivery updated successfully.');
            return redirect()->route('admin.orders.delivery', $this->invoiceId);

        } catch (\Exception $e) {
            session()->flash('error', 'Error updating delivery: ' . $e->getMessage());
            \Log::error('Delivery Update Error: ' . $e->getMessage(), [
                'order_id' => $this->order->id,
                'workflow_type' => $this->order->workflow_type,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    private function generateConsignmentSaleInvoice($deliveredQuantity)
    {
        try {
            DB::transaction(function () use ($deliveredQuantity) {
                // Get the next invoice_id
                $lastInvoiceId = OrderMaster::max('invoice_id');
                $nextInvoiceId = $lastInvoiceId + 1;

                // Create a new invoice for the consignment sale
                $newInvoice = new OrderMaster();
                $newInvoice->invoice_id = $nextInvoiceId;
                $newInvoice->invoice_number = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);
                $newInvoice->invoice_date = now();
                $newInvoice->customer_id = $this->order->customer_id;
                $newInvoice->entity_id = $this->order->entity_id;
                $newInvoice->shipping_address = $this->order->shipping_address;
                $newInvoice->subtotal = $this->order->subtotal;
                $newInvoice->discount = $this->order->discount;
                $newInvoice->freight = $this->order->freight;
                $newInvoice->tax = $this->order->tax;
                $newInvoice->total = $this->order->total;
                $newInvoice->workflow_type = OrderWorkflowType::CONSIGNMENT->value;
                $newInvoice->parent_order_id = $this->order->invoice_id; // Use invoice_id here
                $newInvoice->is_initial_consignment = false;
                $newInvoice->delivery_status = 'Delivered';
                $newInvoice->invoice_status = 'Pending';
                $newInvoice->total_order_quantity = $deliveredQuantity;
                $newInvoice->remaining_quantity = 0;
                $newInvoice->payment_mode = $this->order->payment_mode;
                $newInvoice->payment_terms = $this->order->payment_terms;
                $newInvoice->remarks = 'Consignment Sale - ' . now()->format('Y-m-d');
                $newInvoice->created_by = auth()->id();
                $newInvoice->modified_by = auth()->id();
                $newInvoice->save();

                // Copy order details with updated quantities
                foreach ($this->order->orderDetails as $detail) {
                    // Calculate proportional quantity for this detail
                    $detailQuantity = $this->calculateDetailQuantity($detail, $deliveredQuantity);
                    
                    if ($detailQuantity > 0) {
                        $newDetail = new OrderDetails();
                        $newDetail->invoice_id = $nextInvoiceId; // Use the same invoice_id here
                        $newDetail->product_id = $detail->product_id;
                        $newDetail->manual_product_name = $detail->manual_product_name;
                        $newDetail->unit_price = $detail->unit_price;
                        $newDetail->quantity = $detailQuantity;
                        $newDetail->discount = $detail->discount;
                        $newDetail->total = $detailQuantity * $detail->unit_price - $detail->discount;
                        $newDetail->save();
                    }
                }
            });
        } catch (\Exception $e) {
            \Log::error('Error generating consignment sale invoice: ' . $e->getMessage(), [
                'parent_order_id' => $this->order->invoice_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    private function calculateDetailQuantity($detail, $totalDeliveredQuantity)
    {
        // Get the quantity selected for this detail's inventories
        $detailSelectedQuantity = collect($this->inventoryQuantities)
            ->filter(function ($qty, $invId) use ($detail) {
                return $detail->product->inventories->contains('id', $invId);
            })->sum();

        return $detailSelectedQuantity;
    }

    public function render()
    {
        return view('livewire.admin.orders.order-delivery');
    }
}
