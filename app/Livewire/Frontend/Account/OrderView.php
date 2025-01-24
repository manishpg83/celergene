<?php

namespace App\Livewire\Frontend\Account;

use App\Models\OrderMaster;
use Livewire\Component;

class OrderView extends Component
{
    public $order;
    public $formatted_order_number;

    public function mount($order_id)
    {
        $this->order = OrderMaster::findOrFail($order_id);

        $this->formatted_order_number = 'ORD - ' . str_pad($this->order->order_id, 6, '0', STR_PAD_LEFT);
    }

    public function render()
    {
        return view('livewire.frontend.account.order-view', [
            'order' => $this->order,
            'formatted_order_number' => $this->formatted_order_number,
        ]);
    }
}