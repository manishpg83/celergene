<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $search = '';
    public $confirmingDeletion = false;
    public $productId;

    protected $updatesQueryString = ['search', 'perPage'];

    public function render()
    {
        $products = Product::query()
            ->withTrashed()
            ->where(function ($query) {
                $query->where('product_name', 'like', '%' . $this->search . '%')
                    ->orWhere('brand', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->perPage);

        return view('livewire.admin.products.product-list', [
            'products' => $products,
        ]);
    }

    public function confirmDelete($id)
    {
        $this->confirmingDeletion = true;
        $this->productId = $id;
    }

    public function suspend($id)
    {
        $product = Product::find($id);
        $product->delete();
        notyf()->success('Product suspended. Click permanently delete to remove.');
    }

    public function deleteProduct()
    {
        $product = Product::withTrashed()->find($this->productId);

        if ($product->trashed()) {
            $product->forceDelete();
            notyf()->success('Product permanently deleted.');
        }

        $this->confirmingDeletion = false;
    }

    public function restoreProduct($id)
    {
        $product = Product::withTrashed()->find($id);
        $product->restore();
        notyf()->success('Product restored successfully.');
    }

    public function edit($id)
    {
        return redirect()->route('admin.products.add', ['id' => $id]);
    }
}
