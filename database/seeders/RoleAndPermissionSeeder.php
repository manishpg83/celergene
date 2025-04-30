<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view products',
            'create products',
            'edit products',
            'delete products',
            'manage vendors',
            'view orders',
            'manage orders'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'vendor']);
            Permission::create(['name' => $permission, 'guard_name' => 'admin']);
        }

        // Create roles and assign permissions

        // Admin roles
        $superAdmin = Role::create(['name' => 'super-admin', 'guard_name' => 'admin']);
        $superAdmin->givePermissionTo(Permission::where('guard_name', 'admin')->get());

        // Vendor roles
        $fullVendor = Role::create(['name' => 'user-full', 'guard_name' => 'vendor']);
        $fullVendor->givePermissionTo([
            'view products',
            'create products',
            'edit products',
            'delete products',
            'view orders'
        ]);

        $readOnlyVendor = Role::create(['name' => 'user-readonly', 'guard_name' => 'vendor']);
        $readOnlyVendor->givePermissionTo([
            'view products',
            'view orders'
        ]);
    }
}
