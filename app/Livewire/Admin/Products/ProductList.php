<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public $perPage = 25;
    public $search = '';
    public $confirmingDeletion = false;
    public $productId;
    public $sortDirection = 'asc';
    public $sortField = 'product_code'; // default field to sort by

    public $sortFields = [
        'product_code' => 'Product Code',
        'product_name' => 'Product Name',
        'brand' => 'Brand',
        'product_category' => 'Category',
        'unit_price' => 'Unit Price',
    ];

    protected $updatesQueryString = ['search', 'perPage', 'sortField', 'sortDirection'];

    public function render()
    {
        $products = Product::query()
            ->withTrashed()
            ->where(function ($query) {
                $query->where('product_name', 'like', '%' . $this->search . '%')
                    ->orWhere('brand', 'like', '%' . $this->search . '%')
                    ->orWhere('product_code', 'like', '%' . $this->search . '%')
                    ->orWhere('product_category', 'like', '%' . $this->search . '%')
                    ->orWhere('unit_price', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $perpagerecords = perpagerecords();
        return view('livewire.admin.products.product-list', [
            'products' => $products,
            'perpagerecords' => $perpagerecords,
        ]);
    }

    public function confirmDelete($id)
    {
        $this->confirmingDeletion = true;
        $this->productId = $id;
    }

    public function suspend($id)
    {
        if ($id == 1) {
            notyf()->error('This product cannot be suspended.');
            return;
        }

        $product = Product::find($id);
        $product->delete();
        notyf()->success('Product suspended. Click permanently delete to remove.');
    }

    public function deleteProduct()
    {
        if ($this->productId == 1) {
            notyf()->error('This product cannot be deleted.');
            $this->confirmingDeletion = false;
            return;
        }

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
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function edit($id)
    {
        $product = Product::withTrashed()->find($id);

        if ($product->trashed()) {
            notyf()->error('Cannot edit a suspended entity. Please restore it first.');
            return;
        }

        $this->dispatch('openEditTab', route('admin.products.add', ['id' => $id]));
    }
}
