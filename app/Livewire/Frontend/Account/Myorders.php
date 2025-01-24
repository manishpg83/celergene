<?php

namespace App\Livewire\Frontend\Account;

use App\Models\OrderMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Myorders extends Component
{
    public $orders;

    public function mount()
    {
        $customerId = Auth::id();
        Log::info('Customer ID: ' . $customerId);

        $this->orders = OrderMaster::where('created_by', $customerId)
            ->orderBy('created_at', 'desc')
            ->get();

        Log::info('Orders count: ' . $this->orders->count());
    }

    public function render()
    {
        return view('livewire.frontend.account.myorders', [
            'orders' => $this->orders,
        ]);
    }
}
