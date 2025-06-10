<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\BatchNumber;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InventorySeeder extends Seeder
{
    public function run()
    {
        
        $warehouses = Warehouse::all();  
        $products = Product::all();     
        $batchNumbers = BatchNumber::all(); 

        foreach ($products as $product) {
            foreach ($warehouses as $warehouse) {              
                $batchNumber = $batchNumbers->random();
                $randomQuantity = rand(10, 100);
                Inventory::updateOrCreate(
                    [
                        'product_code' => $product->id, 
                        'warehouse_id' => $warehouse->id,
                        'batch_number' => $batchNumber->batch_number,
                    ],
                    [
                        'expiry' => Carbon::now()->addYear()->format('Y-m-d'), 
                        'quantity' => $randomQuantity,  
                        'consumed' => 0,
                        'remaining' => $randomQuantity, 
                        'created_by' => 1,  
                        'modified_by' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
