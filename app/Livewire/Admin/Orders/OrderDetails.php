<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Component;
use App\Models\OrderMaster;
use App\Models\DeliveryOrder;
use App\Models\OrderInvoice;

class OrderDetails extends Component
{
    public $order;
    public $order_id;
    public $deliveryOrders;
    public $invoices;

    public function mount($order_id)
    {
        $this->order_id = $order_id;
        $this->order = OrderMaster::where('order_id', $order_id)->firstOrFail();

        $this->deliveryOrders = DeliveryOrder::where('order_id', $order_id)->get();

        $this->invoices = OrderInvoice::where('order_id', $order_id)->get();
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

