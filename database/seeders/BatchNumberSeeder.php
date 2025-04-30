<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BatchNumber;

class BatchNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define multiple batch numbers
        $batchNumbers = [
            [
                'batch_number' => 'BN-2025-001',
                'status' => 'active',
            ],
            [
                'batch_number' => 'BN-2025-002',
                'status' => 'inactive',
            ],
            [
                'batch_number' => 'BN-2025-003',
                'status' => 'active',
            ],
            [
                'batch_number' => 'BN-2025-004',
                'status' => 'inactive',
            ],
            [
                'batch_number' => 'BN-2025-005',
                'status' => 'active',
            ]
        ];

        // Loop through and insert the batch numbers into the database
        foreach ($batchNumbers as $data) {
            BatchNumber::updateOrCreate(
                ['batch_number' => $data['batch_number']], // Unique check
                ['status' => $data['status']] // Data to update or insert
            );
        }
    }
}
