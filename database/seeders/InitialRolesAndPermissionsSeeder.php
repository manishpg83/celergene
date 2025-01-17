<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class InitialRolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view dashboard',
            'admin dashboard',
            'manage vendors',
            'manage customers',
            'manage entities',
            'manage warehouses',
            'manage customer types',
            'manage countries',
            'manage product categories',
            'manage products',
            'manage suppliers',
            'manage inventory',
            'manage orders',
            'create roles',
            'assign permissions',
            'manage invoices'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'view dashboard',
            'admin dashboard',
            'manage vendors',
            'manage customers',
            'manage entities',
            'manage warehouses',
            'manage customer types',
            'manage countries',
            'manage product categories',
            'manage products',
            'manage suppliers',
            'manage inventory',
            'manage orders',
            'manage invoices'
        ]);
        // Assign roles to existing users based on their type
        User::where('type', 'admin')->get()->each(function ($user) use ($superAdminRole) {
            $user->assignRole($superAdminRole);
        });


        $superAdminEmail = 'superadmin@celergenswiss.com';
        
        $superAdminUser = User::firstOrCreate(
            ['email' => $superAdminEmail],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('admin@123'),
                'type' => 'super-admin'
            ]
        );

        $superAdminUser->assignRole($superAdminRole);
    }
}
