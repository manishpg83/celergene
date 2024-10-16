<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Livewire\Component;
use App\Models\ProductCatagory;
use Illuminate\Support\Facades\Auth;

class AddProduct extends Component
{
    public $product_id;
    public $brand;
    public $product_name;
    public $product_category;
    public $origin;
    public $batch_number;
    public $expire_date;
    public $currency;
    public $unit_price;
    public $remarks_notes;
    public $description;
    public $created_by;
    public $modified_by;
    public $isEditMode = false;
    public $categories = [];

    protected $rules = [
        'brand' => 'required|string|max:255',
        'product_name' => 'required|string|max:255',
        'product_category' => 'required|integer',
        'origin' => 'required|string|max:255',
        'batch_number' => 'required|string|max:255',
        'expire_date' => 'required|date',
        'currency' => 'required|string|max:3',
        'unit_price' => 'required|numeric',
        'remarks_notes' => 'nullable|string',
        'description' => 'required|string',
    ];

    public function mount()
    {
        $this->categories = ProductCatagory::where('status', 'active')->get();

        $this->product_id = request()->query('id');

        if ($this->product_id) {
            $product = Product::find($this->product_id);
            if ($product) {
                $this->fill($product->toArray());
                $this->isEditMode = true;
            }
        }
    }

    public function submit()
    {
        $this->validate();

        if ($this->isEditMode) {
            $product = Product::find($this->product_id);
            $this->created_by = $product->created_by;
        } else {
            $this->created_by = Auth::id();
        }

        $this->modified_by = Auth::id();

        Product::updateOrCreate(
            ['id' => $this->product_id],
            [
                'brand' => $this->brand,
                'product_name' => $this->product_name,
                'product_category' => $this->product_category,
                'origin' => $this->origin,
                'batch_number' => $this->batch_number,
                'expire_date' => $this->expire_date,
                'currency' => $this->currency,
                'unit_price' => $this->unit_price,
                'remarks_notes' => $this->remarks_notes,
                'description' => $this->description,
                'created_by' => $this->created_by,
                'modified_by' => $this->modified_by,
            ]
        );

        notyf()->success($this->isEditMode ? 'Product updated successfully.' : 'Product added successfully.');
        return redirect()->route('admin.products.index');
    }

    public function back()
    {
        return redirect()->route('admin.products.index');
    }

    public function render()
    {
        return view('livewire.admin.products.add-product');
    }
}
