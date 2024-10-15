<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\InitialRolesAndPermissionsSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            InitialRolesAndPermissionsSeeder::class,
        ]);
        /* User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@celergen.com',
            'password' => Hash::make('admin@123'),
            'type' => 'super-admin',
        ]); */
    }
}
