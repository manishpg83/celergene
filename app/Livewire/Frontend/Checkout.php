<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Checkout extends Component
{
    public $billingAddress;
    public $user;
    public $cartItems = [];
    public $subtotal = 0;

    // Notice the updated event handler
    public function receiveCartData($data) // Changed to directly accept $data
    {
        $this->cartItems = $data;
        $this->calculateTotals();
    }

    protected $listeners = ['receiveCartData']; // Just list the event name

    public function mount()
    {
        $this->user = Auth::user();

        if ($this->user) {
            $this->billingAddress = DB::table('customers')
                ->where('user_id', $this->user->id)
                ->select('billing_address', 'billing_country', 'billing_postal_code', 
                        'first_name', 'last_name', 'mobile_number', 'email', 'company_name')
                ->first();
        }
    }

    private function calculateTotals()
    {
        $this->subtotal = 0;
        if (!empty($this->cartItems)) {
            foreach ($this->cartItems as $item) {
                $this->subtotal += ($item['price'] * $item['quantity']);
            }
        }
    }

    public function render()
    {
        return view('livewire.frontend.checkout', [
            'billingAddress' => $this->billingAddress,
            'cartItems' => $this->cartItems
        ]);
    }
}