<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define multiple warehouse data
        $warehouses = [
            [
                'warehouse_name' => 'West Bengal',
                'country' => 'India',
                'type' => 'Affiliate',
                'remarks' => 'Sequi exercitation e',
                'phone' => '+1 (304) 637-8063',
                'address' => 'West Bengal',
                'created_by' => 1,  
                'modified_by' => 1, 
                'emails' => [
                    "saurav.briskbrain@gmail.com",
                    "saurav.briskbrain+1@gmail.com"
                ]
            ],
            [
                'warehouse_name' => 'New York Warehouse',
                'country' => 'USA',
                'type' => 'Supplier',
                'remarks' => 'Lorem ipsum dolor sit amet',
                'phone' => '+1 (212) 555-1234',
                'address' => '123 5th Avenue, New York',
                'created_by' => 1,  
                'modified_by' => 1, 
                'emails' => [
                    "ny.warehouse@example.com",
                    "ny.warehouse+2@example.com"
                ]
            ],
            [
                'warehouse_name' => 'London Warehouse',
                'country' => 'United Kingdom',
                'type' => 'Supplier',
                'remarks' => 'Dolor sit amet, consectetur adipiscing elit',
                'phone' => '+44 20 7946 0958',
                'address' => '456 Oxford Street, London',
                'created_by' => 1,  
                'modified_by' => 1, 
                'emails' => [
                    "london.warehouse@example.com",
                    "london.warehouse+3@example.com"
                ]
            ]
        ];

        // Loop through warehouses and create or update them
        foreach ($warehouses as $data) {
            $warehouse = Warehouse::updateOrCreate(
                [
                    'warehouse_name' => $data['warehouse_name'],
                    'country' => $data['country'],
                    'type' => $data['type'],
                ],
                [
                    'remarks' => $data['remarks'],
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                    'created_by' => $data['created_by'],
                    'modified_by' => $data['modified_by'],
                ]
            );

            foreach ($data['emails'] as $email) {
                $warehouse->emails()->updateOrCreate(
                    ['email' => $email], 
                    ['email' => $email] 
                );
            }
        }
    }
}
