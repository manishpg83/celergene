<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Product;

class Cart extends Component
{
    public function render()
    {
        $products = Product::whereIn('id', [2, 3, 4])->get();

        return view('livewire.frontend.cart', ['products' => $products]);
    }
}
