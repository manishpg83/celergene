<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use App\Models\Product;
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
    public $created_by;
    public $modified_by;
    public $isEditMode = false;

    protected $rules = [
        'brand' => 'required|string',
        'product_name' => 'required|string',
        'product_category' => 'required|string',
        'origin' => 'required|string',
        'batch_number' => 'required|string',
        'expire_date' => 'required|date',
        'currency' => 'required|string',
        'unit_price' => 'required|numeric',
        'remarks_notes' => 'nullable|string',
    ];

    public function mount()
    {
        $this->product_id = request()->query('id');

        if ($this->product_id) {
            $product = Product::find($this->product_id);
            if ($product) {
                $this->brand = $product->brand;
                $this->product_name = $product->product_name;
                $this->product_category = $product->product_category;
                $this->origin = $product->origin;
                $this->batch_number = $product->batch_number;
                $this->expire_date = $product->expire_date;
                $this->currency = $product->currency;
                $this->unit_price = $product->unit_price;
                $this->remarks_notes = $product->remarks_notes;
                $this->created_by = $product->created_by;
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
