<?php
namespace App\Livewire\Frontend;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;

class CartCount extends Component
{
    protected $listeners = ['cartUpdated' => 'handleCartUpdate'];

    public $cartCount = 0;

    public function mount()
    {
        $this->cartCount = $this->getCartCount();
    }

    public function handleCartUpdate($itemId, $quantity)
    {
        $cart = Session::get('cart', collect());
        $updatedCart = $cart->filter(function ($item) use ($itemId) {
            return $item['id'] != $itemId;
        });
        if ($quantity > 0) {
            $updatedCart->push([
                'id' => $itemId, 
                'quantity' => $quantity
            ]);
        }
        Session::put('cart', $updatedCart);
        $this->cartCount = $this->calculateTotalQuantity($updatedCart);
    }

    private function getCartCount()
    {
        $cart = Session::get('cart', collect());
        return $this->calculateTotalQuantity($cart);
    }

    private function calculateTotalQuantity($cart)
    {
        return $cart->sum('quantity');
    }

    public function render()
    {
        return view('livewire.frontend.cart-count');
    }
}