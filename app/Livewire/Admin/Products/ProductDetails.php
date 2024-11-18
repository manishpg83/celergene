<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use App\Models\Inventory;

class ProductDetails extends Component
{
    public $productCode;

    // Calculated properties
    public $totalStock = 0;
    public $totalConsumed = 0;
    public $warehouseCount = 0;

    public function mount($productCode)
    {
        $this->productCode = $productCode;

        // Fetch and calculate totals
        $this->calculateStockDetails();
    }

    public function calculateStockDetails()
    {
        $inventoryData = Inventory::where('product_code', $this->productCode)->get();

        // Calculate total stock and total consumed
        $this->totalStock = $inventoryData->sum('quantity');
        $this->totalConsumed = $inventoryData->sum('consumed');

        // Calculate warehouse count (distinct warehouses)
        $this->warehouseCount = $inventoryData->groupBy('warehouse_id')->count();
    }

    public function render()
    {
        // Fetch inventory data with warehouse details
        $inventoryData = Inventory::with('warehouse')
            ->where('product_code', $this->productCode)
            ->get();

        return view('livewire.admin.products.product-details', compact('inventoryData'));
    }
}
