<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Product;

class Cart extends Component
{
    public function render()
    {
        // Fetch products with IDs 2, 3, and 4
        $products = Product::whereIn('id', [2, 3, 4])->get()->keyBy('id');

        // Pass the products to the view
        return view('livewire.frontend.cart', ['products' => $products]);
    }
}
