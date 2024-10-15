<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Livewire\Component;

class ProductList extends Component
{
    public $products;

    public function mount()
    {
        $this->products = Product::all();
    }

    public function render()
    {
        return view('livewire.admin.products.product-list');
    }

    public function deleteProduct($id)
    {
        Product::find($id)->delete();
        $this->products = Product::all(); // Refresh the product list
        session()->flash('message', 'Product deleted successfully.');
    }
}
