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
            'manage vendors',
            'manage customers',
            'manage entities',
            'manage customer types',
            'manage countries',
            'create roles',
            'assign permissions',
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
            'manage vendors',
            'manage customers',
            'manage entities',
            'manage customer types',
            'manage countries',
        ]);

        $vendorRole = Role::create(['name' => 'vendor']);
        $vendorRole->givePermissionTo([
            'view dashboard',
        ]);

        // Assign roles to existing users based on their type
        User::where('type', 'admin')->get()->each(function ($user) use ($superAdminRole) {
            $user->assignRole($superAdminRole);
        });

        User::where('type', 'vendor')->get()->each(function ($user) use ($vendorRole) {
            $user->assignRole($vendorRole);
        });


        $superAdminEmail = 'superadmin@celergen.com';

        $superAdminUser = User::firstOrCreate(
            ['email' => $superAdminEmail],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('admin@123'),
                'type' => 'super-admin'
            ]
        );

        // Assign super-admin role to this user
        $superAdminUser->assignRole($superAdminRole);
    }
}
