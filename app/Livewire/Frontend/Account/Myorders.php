<?php

namespace App\Livewire\Frontend\Account;

use App\Models\OrderMaster;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Myorders extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $orders = OrderMaster::select('order_id', 'created_at', 'total', 'order_status', 'order_number')
            ->where('created_by', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        foreach ($orders as $order) {
            $order->formatted_order_number = 'ORD - ' . str_pad($order->order_id, 6, '0', STR_PAD_LEFT);
        }

        return view('livewire.frontend.account.myorders', [
            'orders' => $orders,
        ]);
    }
}
