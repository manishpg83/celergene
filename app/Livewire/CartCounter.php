<?php

namespace App\Livewire;

use Livewire\Component;

class CartCounter extends Component
{
    public $cartCount = 0;

    protected $listeners = ['cartCountUpdated' => 'updateCartCount'];

    public function mount()
    {
        $this->updateCartCount();
    }

    public function updateCartCount()
    {
        $cart = session()->get('cart', []);
        
        // Ensure we're working with an array
        if (!is_array($cart)) {
            $cart = [];
        }
        
        // Only try to sum if we have items
        if (empty($cart)) {
            $this->cartCount = 0;
        } else {
            // Get an array of just the quantities
            $quantities = array_column($cart, 'quantity');
            // Sum the quantities
            $this->cartCount = array_sum($quantities);
        }
    }

    public function render()
    {
        return view('livewire.cart-counter');
    }
}