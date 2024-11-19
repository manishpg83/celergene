<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use App\Models\Inventory;

class ProductDetails extends Component
{
    public $productCode;

    public $totalStock = 0;
    public $totalConsumed = 0;
    public $warehouseCount = 0;

    public function mount($productCode)
    {
        $this->productCode = $productCode;

        $this->calculateStockDetails();
    }

    public function calculateStockDetails()
    {
        $inventoryData = Inventory::where('product_code', $this->productCode)->get();

        $this->totalStock = $inventoryData->sum('quantity');
        $this->totalConsumed = $inventoryData->sum('consumed');

        $this->warehouseCount = $inventoryData->groupBy('warehouse_id')->count();
    }

    public function render()
    {
        $inventoryData = Inventory::with('warehouse')
            ->where('product_code', $this->productCode)
            ->get();

        return view('livewire.admin.products.product-details', compact('inventoryData'));
    }
}
