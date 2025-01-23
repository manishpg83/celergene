<?php
namespace App\Livewire\Frontend;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CartCount extends Component
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