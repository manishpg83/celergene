<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Component;
use App\Models\OrderMaster;
use App\Models\DeliveryOrder;

class OrderDetails extends Component
{
    public $order;
    public $order_id;
    public $deliveryOrders;

    public function mount($order_id)
    {
        $this->order_id = $order_id;
        $this->order = OrderMaster::where('order_id', $order_id)->firstOrFail();
        // Fetch related delivery orders
        $this->deliveryOrders = DeliveryOrder::where('order_id', $order_id)->get();
    }

    public function back()
    {
        return redirect()->route('admin.orders.index');
    }

    public function render()
    {
        return view('livewire.admin.orders.order-details');
    }
}
