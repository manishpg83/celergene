<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCatagory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['category_name' => 'Supplement', 'status' => 'active'],
            ['category_name' => 'Skincare', 'status' => 'active'],
            ['category_name' => 'Eye Cream', 'status' => 'active'],
        ];

        foreach ($categories as $category) {
            ProductCatagory::updateOrCreate(
                ['category_name' => $category['category_name']], 
                ['status' => $category['status']] 
            );
        }

        $products = [
            [
                'product_code' => 'CELSER',
                'brand' => 'Celergen',
                'product_img' => 'product_img/ea58psxEKe9oR7H2jrQtZ3KGjdninPFQ59jhHWZ6.jpg',
                'product_name' => 'Celergen Serum Royale',
                'invoice_description' => 'Celergen Serum 30ml TARIC 33049900',
                'product_category' => 2,
                'origin' => 'Swiss',
                'batch_number' => 'na',
                'expire_date' => '2026-12-01',
                'currency' => 'USD',
                'unit_price' => 1.00,
                'remarks_notes' => 'Adjusted by OSY 6 Feb 2025 Expiry date - NA',
                'description' => 'Celergen Serum',
                'is_online' => 1,
                'created_by' => 1,
                'modified_by' => 1,
                'created_at' => '2025-01-21 07:11:12',
                'updated_at' => '2025-04-03 06:37:25',
            ],
            [
                'product_code' => 'CELGEN1',
                'brand' => 'Celergen',
                'product_img' => 'product_img/ea58psxEKe9oR7H2jrQtZ3KGjdninPFQ59jhHWZ6.jpg',
                'product_name' => 'Celergen Gen 30ml',
                'invoice_description' => 'Celergen Gen 30ml TARIC 33049900',
                'product_category' => 1, 
                'origin' => 'Swiss',
                'batch_number' => 'na',
                'expire_date' => null,
                'currency' => 'USD',
                'unit_price' => 1.00,
                'remarks_notes' => null,
                'description' => 'Celergen Gen 30ml TARIC 33049900',
                'is_online' => 1,
                'created_by' => 1,
                'modified_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_code' => 'CELGEN2',
                'brand' => 'Celergen',
                'product_img' => 'product_img/ea58psxEKe9oR7H2jrQtZ3KGjdninPFQ59jhHWZ6.jpg',
                'product_name' => 'Celergen Gen 30ml',
                'invoice_description' => 'Celergen Gen 30ml TARIC 33049900',
                'product_category' => 1, 
                'origin' => 'Swiss',
                'batch_number' => 'na',
                'expire_date' => null,
                'currency' => 'USD',
                'unit_price' => 1.00,
                'remarks_notes' => null,
                'description' => 'Celergen Gen 30ml TARIC 33049900',
                'is_online' => 1,
                'created_by' => 1,
                'modified_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],            
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['product_code' => $product['product_code']], // Check by product_code
                $product // Set the product data to update or create
            );
        }
    }
}
