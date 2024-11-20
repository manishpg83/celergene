<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Component;
use App\Models\OrderMaster;
use App\Models\Inventory;

class OrderDelivery extends Component
{
    public $invoiceId;
    public $order;
    public $deliveryStatus;
    public $deliveryDate;
    public $selectedInventories = [];

    protected $rules = [
        'deliveryStatus' => 'required|in:pending,shipped,delivered,cancelled',
        'deliveryDate' => 'nullable|date|after_or_equal:today',
        'selectedInventories.*.inventory_id' => 'required|exists:inventories,id',
        'selectedInventories.*.quantity' => 'required|integer|min:1',
    ];

    public function mount($invoiceId)
    {
        $this->invoiceId = $invoiceId;

        // Load the order details
        $this->order = OrderMaster::with(['customer', 'orderDetails'])
            ->where('invoice_id', $invoiceId)
            ->firstOrFail();

        // Initialize delivery details
        $this->deliveryStatus = $this->order->delivery_status;
        $this->deliveryDate = $this->order->delivery_date;

        // Get all inventories for the products in the order
        // Assuming that 'Inventory' has 'product_id' and 'warehouse_id' as columns
        $this->selectedInventories = $this->order->orderDetails->map(function ($detail) {
            return [
                'product_id' => $detail->product_id,
                'quantity' => $detail->quantity,
                'inventories' => Inventory::where('product_code', $detail->product_id)->get()
            ];
        });
    }

    public function back()
    {
        return redirect()->route('admin.orders.index');
    }

    public function updateDelivery()
    {
        $this->validate();

        // Update order delivery status
        $this->order->delivery_status = $this->deliveryStatus;
        $this->order->delivery_date = $this->deliveryDate;
        $this->order->save();

        // Loop through the selected inventories and update stock
        foreach ($this->selectedInventories as $inventoryData) {
            foreach ($inventoryData['inventories'] as $inventory) {
                // Find the inventory record for the current warehouse
                $inventoryRecord = Inventory::find($inventory->id);

                if ($inventoryRecord && $inventoryRecord->quantity >= $inventoryData['quantity']) {
                    // Reduce stock from the selected inventory
                    $inventoryRecord->quantity -= $inventoryData['quantity'];
                    $inventoryRecord->save();
                } else {
                    session()->flash('error', 'Not enough stock in the selected warehouse.');
                    return;
                }
            }
        }

        session()->flash('success', 'Delivery details and inventory stock updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.orders.order-delivery');
    }
}
