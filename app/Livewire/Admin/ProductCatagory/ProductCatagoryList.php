<?php

namespace App\Livewire\Admin\ProductCatagory;

use App\Models\ProductCatagory;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class ProductCatagoryList extends Component
{
    use WithPagination;

    public $perPage = 25;
    public $search = '';
    public $confirmingDeletion = false;
    public $categoryId;
    public $category_name;
    public $status;
    public $isEditing = false;

    protected $updatesQueryString = ['search', 'perPage'];

    public function render()
    {
        $categories = ProductCatagory::query()
            ->withTrashed()
            ->where(function ($query) {
                $query->where('category_name', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->perPage);

        $perpagerecords = perpagerecords();

        return view('livewire.admin.product-catagory.product-catagory-list', [
            'categories' => $categories,
            'perpagerecords' => $perpagerecords,
        ]);
    }

    public function toggleActive($id)
    {
        $category = ProductCatagory::find($id);
        if ($category && !$category->trashed()) {
            $category->status = $category->status === 'active' ? 'inactive' : 'active';
            $category->save();
            notyf()->success('Category status updated successfully.');
        }
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
        $category = ProductCatagory::withTrashed()->find($id);

        if ($category->trashed()) {
            notyf()->error('Cannot edit a suspended entity. Please restore it first.');
            return;
        }
        $this->categoryId = $category->id;
        $this->category_name = $category->category_name;
        $this->status = $category->status;
        $this->isEditing = true;
        
        $this->dispatch('openEditTab', route('admin.productscategory.add', ['id' => $id]));
    }

    public function updateCategory()
    {
        $this->validate([
            'category_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('product_catagories', 'category_name')->ignore($this->categoryId),
            ],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $category = ProductCatagory::findOrFail($this->categoryId);
        $category->category_name = $this->category_name;
        $category->status = $this->status;
        $category->save();

        $this->resetForm();
        notyf()->success('Category updated successfully.');
    }

    public function resetForm()
    {
        $this->categoryId = null;
        $this->category_name = '';
        $this->status = '';
        $this->isEditing = false;
    }
}