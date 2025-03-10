<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class CartComponent extends Component
{
    public $cartItems = [];
    public $subtotal = 0;
    public $total = 0;
    public $products;

    protected $listeners = ['cartUpdated' => 'updateCart'];

    public function mount()
    {
        $this->products = Product::where('is_online', true)->get();
        $this->updateCart();
    }

    public function incrementQuantity($productCode)
    {
        $cart = session()->get('cart', []);
        $cart = is_array($cart) ? $cart : [];

        $product = Product::where('product_code', $productCode)->where('is_online', true)->first();

        if ($product) {
            if (!isset($cart[$productCode])) {
                $cart[$productCode] = [
                    'quantity' => 1,
                    'total' => $product->unit_price
                ];
            } else {
                $cart[$productCode]['quantity'] = ($cart[$productCode]['quantity'] ?? 0) + 1;
                $cart[$productCode]['total'] = $cart[$productCode]['quantity'] * $product->unit_price;
            }

            session()->put('cart', $cart);
            $this->dispatch('cartCountUpdated');
            $this->dispatch('cart-updated');
            $this->updateCart();
        }
    }

    public function decrementQuantity($productCode)
    {
        $cart = session()->get('cart', []);
        $cart = is_array($cart) ? $cart : [];

        $product = Product::where('product_code', $productCode)->where('is_online', true)->first();

        if ($product && isset($cart[$productCode])) {
            $cart[$productCode]['quantity'] = ($cart[$productCode]['quantity'] ?? 0) - 1;

            if ($cart[$productCode]['quantity'] <= 0) {
                unset($cart[$productCode]);
            } else {
                $cart[$productCode]['total'] = $cart[$productCode]['quantity'] * $product->unit_price;
            }

            session()->put('cart', $cart);
            $this->dispatch('cartCountUpdated');
            $this->dispatch('cart-updated');
            $this->updateCart();
        }
    }

    public function updateCart()
    {
        $cart = session()->get('cart', []);
        $this->cartItems = is_array($cart) ? $cart : [];
        $this->calculateTotals();
    }

    private function calculateTotals()
    {
        $this->subtotal = 0;

        foreach ($this->cartItems as $productCode => $item) {
            $product = Product::where('product_code', $productCode)->where('is_online', true)->first();
            if ($product && isset($item['quantity'])) {
                $this->subtotal += $product->unit_price * $item['quantity'];
            }
        }

        $this->total = $this->subtotal;
    }

    public function render()
    {
        return view('livewire.cart-component', [
            'products' => $this->products
        ]);
    }
}