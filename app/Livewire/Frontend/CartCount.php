<?php
namespace App\Livewire\Frontend;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

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
        Log::info("Updating cart: Item {$itemId}, Quantity {$quantity}");
    
        $cart = Session::get('cart', collect());
        Log::info("Current cart: ", $cart->toArray());
    
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
    
        Log::info("Updated cart: ", $updatedCart->toArray());
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