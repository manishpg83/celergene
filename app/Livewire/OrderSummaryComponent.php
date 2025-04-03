<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class OrderSummaryComponent extends Component
{
    public $cartItems = [];
    public $subtotal = 0;
    public $total = 0;
    public $showCheckoutButton = true;
    
    protected $listeners = [
        'cartUpdated' => 'updateSummary',
        'cart-updated' => 'updateSummary'
    ];

    public function mount($showCheckoutButton = true)
    {
        $this->showCheckoutButton = $showCheckoutButton;
        $this->updateSummary();
    }

    public function updateSummary()
    {
        $cart = session()->get('cart', []);
        $this->cartItems = is_array($cart) ? $cart : [];
        $this->calculateTotals();
        $this->dispatch('$refresh');
    }

    private function calculateTotals()
    {
        $this->subtotal = 0;
        
        foreach ($this->cartItems as $productCode => $item) {
            $product = Product::where('product_code', $productCode)->first();
            if ($product && isset($item['quantity'])) {
                $this->subtotal += $product->unit_price * $item['quantity'];
            }
        }
        
        $this->total = $this->subtotal;
    }

    public function attemptCheckout()
    {
        if ($this->isCartEmpty()) {
            $this->dispatch('alert', type: 'error', message: 'Please add items to your cart before checkout');
            return;
        }

        return redirect()->route('checkout');
    }

    // Make this public so it's accessible in the view
    public function isCartEmpty()
    {
        return empty($this->cartItems);
    }

    public function render()
    {
        return view('livewire.order-summary-component', [
            'products' => Product::whereIn('product_code', array_keys($this->cartItems))->get(),
            'isCartEmpty' => $this->isCartEmpty() // Pass this to the view
        ]);
    }
}