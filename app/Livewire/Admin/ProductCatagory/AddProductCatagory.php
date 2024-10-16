<?php

namespace App\Livewire\Admin\ProductCatagory;

use Livewire\Component;
use App\Models\ProductCatagory;
use Illuminate\Support\Facades\Auth;

class AddProductCatagory extends Component
{
    public $category_id;
    public $category_name;
    public $status;
    public $isEditMode = false;
    public $modified_by;

    protected $rules = [
        'category_name' => 'required|string|max:255|unique:product_catagories,category_name',
        'status' => 'required|in:active,inactive',
    ];

    public function mount()
    {
        $this->category_id = request()->query('id');

        if ($this->category_id) {
            $category = ProductCatagory::find($this->category_id);
            if ($category) {
                $this->category_name = $category->category_name;
                $this->status = $category->status;
                $this->isEditMode = true;
            }
        }
    }

    public function submit()
    {
        $this->validate();

        if ($this->isEditMode) {
            $this->modified_by = Auth::id();
            $category = ProductCatagory::find($this->category_id);
            if ($category) {
                $category->update([
                    'category_name' => $this->category_name,
                    'status' => $this->status,
                    'modified_by' => $this->modified_by,
                ]);
                notyf()->success('Product category updated successfully.');
            }
        } else {
            $this->modified_by = Auth::id();
            ProductCatagory::create([
                'category_name' => $this->category_name,
                'status' => $this->status,
                'created_by' => $this->modified_by,
            ]);
            notyf()->success('Product category added successfully.');
        }

        return redirect()->route('admin.productscategory.index');
    }

    public function softDelete($id)
    {
        $category = ProductCatagory::find($id);
        if ($category) {
            $category->delete();
            notyf()->success('Product category deleted successfully.');
        }
    }

    public function back()
    {
        return redirect()->route('admin.productscategory.index');
    }

    public function render()
    {
        return view('livewire.admin.product-catagory.add-product-catagory');
    }
}
