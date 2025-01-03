<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class CartCount extends Component
{
    protected $listeners = ['cartUpdated' => 'refreshCount'];

    public $cartCount = 0;

    public function mount()
    {
        $this->cartCount = $this->getCartCount();
    }

    public function refreshCount()
    {
        $this->cartCount = $this->getCartCount();
    }

    private function getCartCount()
    {
        return Session::get('cart', collect())->count();
    }

    public function render()
    {
        return view('livewire.frontend.cart-count');
    }
}
