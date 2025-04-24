<?php

namespace Database\Seeders;

use App\Models\CustomerType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CustomerType::create([
            'customer_type' => 'Individual',
            'status' => 'active',
            'created_at' => '2025-04-17 07:44:38',
            'updated_at' => '2025-04-23 10:00:09',
        ]);

        CustomerType::create([
            'customer_type' => 'Corporate',
            'status' => 'active',
            'created_at' => '2025-04-17 07:44:46',
            'updated_at' => '2025-04-23 10:00:20',
        ]);
    }
}
