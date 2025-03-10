<?php

namespace App\Livewire\Admin\Products;

use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductCatagory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
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
    public $minExpireDate;
    public $currencies = [];
    public $is_online = 0;

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
            'product_img' => $this->isEditMode ? 'nullable' : 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
            'product_category' => 'required|integer',
            'origin' => 'required|string|max:255',
            'expire_date' => 'nullable|date_format:Y-m|after_or_equal:' . date('Y-m'),
            'currency' => 'required|string|max:3',
            'unit_price' => 'required|numeric',
            'remarks_notes' => 'nullable|string',
            'description' => 'required|string',
            'is_online' => 'nullable|boolean',
        ];
    }

    public function mount()
    {
        $this->categories = ProductCatagory::where('status', 'active')->get();
        $this->currencies = Currency::where('status', 'active')->pluck('name', 'code')->toArray();
        $this->minExpireDate = date('Y-m');
        $this->product_id = request()->query('id');

        if ($this->product_id) {
            $product = Product::find($this->product_id);
            if ($product) {
                $this->fill($product->toArray());
                $this->isEditMode = true;

                $this->product_img_url = $product->product_img ?: null;
                $this->expire_date = $product->expire_date ? date('Y-m', strtotime($product->expire_date)) : null;
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

        if ($this->product_img instanceof TemporaryUploadedFile) {
            $imagePath = $this->product_img->store('', 'custom_product_images');

            if ($imagePath) {
                if ($this->isEditMode && $product->product_img && Storage::disk('custom_product_images')->exists($product->product_img)) {
                    Storage::disk('custom_product_images')->delete($product->product_img);
                }

                $newImagePath = 'product_img/' . basename($imagePath);
            }
        } else {
            $newImagePath = $this->isEditMode ? $this->product_img_url : null;
        }

        $this->modified_by = Auth::id();

        $formattedExpireDate = $this->expire_date ? $this->expire_date . '-01' : null;

        Product::updateOrCreate(
            ['id' => $this->product_id],
            [
                'product_code' => $this->product_code,
                'brand' => $this->brand,
                'product_name' => $this->product_name,
                'invoice_description' => $this->invoice_description,
                'product_category' => $this->product_category,
                'origin' => $this->origin,
                'expire_date' => $formattedExpireDate,
                'currency' => $this->currency,
                'unit_price' => $this->unit_price,
                'remarks_notes' => $this->remarks_notes,
                'description' => $this->description,
                'is_online' => $this->is_online,
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
