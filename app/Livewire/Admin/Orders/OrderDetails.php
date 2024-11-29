<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Component;
use App\Models\OrderMaster;

class OrderDetails extends Component
{
    public $order;
    public $order_id;

    public function mount($order_id)
    {
        $this->order_id = $order_id;
        $this->order = OrderMaster::where('order_id', $order_id)->firstOrFail();
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