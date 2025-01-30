<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\ProductCatagory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;


class AddProduct extends Component
{
    use WithFileUploads;

    public $product_img_url;
    public $product_id;
    public $product_img;
    public $product_code;
    public $brand;
    public $product_name;
    public $product_category;
    public $origin;
    public $batch_number;
    public $expire_date;
    public $currency;
    public $unit_price;
    public $remarks_notes;
    public $invoice_description;
    public $description;
    public $created_by;
    public $modified_by;
    public $isEditMode = false;
    public $categories = [];

    public function rules()
    {
        return [
            'product_code' => [
                'required',
                'string',
                'max:255',
                $this->isEditMode
                    ? 'unique:products,product_code,' . $this->product_id
                    : 'unique:products,product_code',
            ],
            'brand' => 'required|string|max:255',
            'invoice_description' => 'required|string|max:255',
            'product_img' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
            'product_category' => 'required|integer',
            'origin' => 'required|string|max:255',
            'batch_number' => 'required|string|max:255',
            'expire_date' => 'required|date',
            'currency' => 'required|string|max:3',
            'unit_price' => 'required|numeric',
            'remarks_notes' => 'nullable|string',
            'description' => 'required|string',
        ];
    }

    public function mount()
    {
        $this->categories = ProductCatagory::where('status', 'active')->get();
    
        $this->product_id = request()->query('id');
    
        if ($this->product_id) {
            $product = Product::find($this->product_id);
            if ($product) {
                $this->fill($product->toArray());
                $this->isEditMode = true;
    
                // Set the existing image URL if it exists
                $this->product_img_url = $product->product_img ? $product->product_img : null;
            }
        }
    }

    public function submit()
    {
        $this->validate($this->rules());

        if ($this->isEditMode) {
            $product = Product::find($this->product_id);
            $this->created_by = $product->created_by;
        } else {
            $this->created_by = Auth::id();
        }

        $this->modified_by = Auth::id();

        if ($this->product_img) {
            $imagePath = $this->product_img->store('', 'custom_product_images');
            if ($imagePath) {
                if ($this->isEditMode) {
                    $product = Product::find($this->product_id);
                    if ($product && $product->product_img && Storage::disk('custom_product_images')->exists($product->product_img)) {
                        Storage::disk('custom_product_images')->delete($product->product_img);
                    }
                }

                $newImagePath = 'product_img/' . basename($imagePath);
            }
        }



        Product::updateOrCreate(
            ['id' => $this->product_id],
            [
                'product_code' => $this->product_code,
                'brand' => $this->brand,
                'product_name' => $this->product_name,
                'invoice_description' => $this->invoice_description,
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
                'product_img' => $newImagePath ?? ($this->isEditMode ? $this->product_img_url : null),
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
