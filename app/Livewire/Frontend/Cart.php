<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Product;

class Cart extends Component
{
    public function render()
    {
        $products = Product::where('id', '!=', 1)->get();
        return view('livewire.frontend.cart', ['products' => $products]);
    }
}
