<?php

namespace App\Livewire\Admin\ProductCatagory;

use App\Models\ProductCatagory;
use Livewire\Component;
use Livewire\WithPagination;

class ProductCatagoryList extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $search = '';
    public $confirmingDeletion = false;
    public $categoryId;

    protected $updatesQueryString = ['search', 'perPage'];

    public function render()
    {
        $categories = ProductCatagory::query()
            ->withTrashed()
            ->where(function ($query) {
                $query->where('category_name', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->perPage);

        return view('livewire.admin.product-catagory.product-catagory-list', [
            'categories' => $categories,
        ]);
    }

    public function confirmDelete($id)
    {
        $this->confirmingDeletion = true;
        $this->categoryId = $id;
    }

    public function suspend($id)
    {
        $category = ProductCatagory::find($id);
        if ($category) {
            $category->delete();
            notyf()->success('Category suspended. Click permanently delete to remove.');
        }
    }

    public function deleteProduct()
    {
        $category = ProductCatagory::withTrashed()->find($this->categoryId);

        if ($category && $category->trashed()) {
            $category->forceDelete();
            notyf()->success('Category permanently deleted.');
        }

        $this->confirmingDeletion = false;
    }

    public function restoreProduct($id)
    {
        $category = ProductCatagory::withTrashed()->find($id);
        if ($category) {
            $category->restore();
            notyf()->success('Category restored successfully.');
        }
    }

    public function edit($id)
    {
        return redirect()->route('admin.productscategory.add', ['id' => $id]);
    }
}
