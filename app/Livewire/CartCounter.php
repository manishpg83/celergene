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
        
        if (!is_array($cart)) {
            $cart = [];
        }
        
        if (empty($cart)) {
            $this->cartCount = 0;
        } else {
            $quantities = array_column($cart, 'quantity');
            $this->cartCount = array_sum($quantities);
        }
    }

    public function render()
    {
        return view('livewire.cart-counter');
    }
}