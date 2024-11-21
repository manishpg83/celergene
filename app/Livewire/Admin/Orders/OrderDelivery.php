<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Component;
use App\Models\OrderMaster;
use App\Models\Inventory;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class OrderDelivery extends Component
{
    public $invoiceId;
    public $order;
    public $deliveryStatus;
    public $selectedInventories = [];
    public $inventoryQuantities = [];

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
                foreach ($this->order->orderDetails as $detail) {
                    $firstInventory = Inventory::where('product_code', $detail->product_id)
                        ->orderBy('created_at')
                        ->first();

                    if ($firstInventory) {
                        $firstInventory->consumed = (int)$firstInventory->consumed - (int)$detail->quantity;
                        $firstInventory->remaining = (int)$firstInventory->quantity - (int)$firstInventory->consumed;
                        $firstInventory->save();

                        Stock::create([
                            'inventory_id' => $firstInventory->id,
                            'product_id' => $detail->product_id,
                            'previous_quantity' => (int)$firstInventory->remaining - (int)$detail->quantity,
                            'quantity_change' => (int)$detail->quantity,
                            'new_quantity' => (int)$firstInventory->remaining,
                            'reason' => 'Order Delivery Update - Restore',
                            'created_by' => auth()->id(),
                        ]);
                    }
                    $totalSelectedQuantity = array_sum(array_map('intval', $this->inventoryQuantities));
                    if ($totalSelectedQuantity != (int)$detail->quantity) {
                        throw new \Exception("Selected quantities must equal order quantity of {$detail->quantity}");
                    }
                    foreach ($this->inventoryQuantities as $inventoryId => $quantity) {
                        $quantity = (int)$quantity;
                        if ($quantity > 0) {
                            $inventory = Inventory::findOrFail($inventoryId);
                            if ((int)$inventory->remaining < $quantity) {
                                throw new \Exception("Insufficient quantity in inventory #{$inventoryId}");
                            }
                            $inventory->consumed = (int)$inventory->consumed + $quantity;
                            $inventory->remaining = (int)$inventory->quantity - (int)$inventory->consumed;
                            $inventory->modified_by = auth()->id();
                            $inventory->save();

                            Stock::create([
                                'inventory_id' => $inventory->id,
                                'product_id' => $detail->product_id,
                                'previous_quantity' => (int)$inventory->remaining + $quantity,
                                'quantity_change' => -$quantity,
                                'new_quantity' => (int)$inventory->remaining,
                                'reason' => 'Order Delivery Update - New Allocation',
                                'created_by' => auth()->id(),
                            ]);
                        }
                    }
                }
                $this->order->delivery_status = $this->deliveryStatus;
                $this->order->modified_by = auth()->id();
                $this->order->save();
            });

            notyf()->success('Delivery updated successfully.');

        } catch (\Exception $e) {
            notyf()->error('Error updating delivery: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.orders.order-delivery');
    }
}
