<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class MyAccount extends Component
{
    public $user;
    public $customer;

    public function mount()
    {
        $this->user = Auth::user();
        $this->customer = Customer::where('user_id', $this->user->id)->first();
    }

    public function render()
    {
        return view('livewire.frontend.my-account', [
            'user' => $this->user,
            'customer' => $this->customer,
        ]);
    }
}
