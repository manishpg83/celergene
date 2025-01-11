<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Checkout extends Component
{
    public $billingAddress;
    public $user;

    public function mount()
    {
        $this->user = Auth::user();

        if ($this->user) {
            $this->billingAddress = DB::table('customers')
                ->where('user_id', $this->user->id)
                ->select('billing_address', 'billing_country', 'billing_postal_code', 'first_name', 'last_name', 'mobile_number', 'email', 'company_name')
                ->first();
        }
    }

    public function render()
    {
        return view('livewire.frontend.checkout', [
            'billingAddress' => $this->billingAddress,
        ]);
    }
}
