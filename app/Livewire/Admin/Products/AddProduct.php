<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use App\Models\Product; // Assuming your Product model is here

class AddProduct extends Component
{
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
        'created_by' => 'required|string',
        'modified_by' => 'required|string',
    ];

    public function submit()
    {
        $this->validate();

        Product::create([
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
        ]);

        session()->flash('message', 'Product added successfully.');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.products.add-product');
    }
}

