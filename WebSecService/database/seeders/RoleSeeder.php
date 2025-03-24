<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Find or create admin role
        $adminRole = Role::findOrCreate('admin');
        
        // Find the existing manage_roles permission
        $permission = Permission::where('name', 'manage_roles')->first();
        
        // Give permission to admin role if permission exists
        if ($permission) {
            $adminRole->givePermissionTo($permission);
        }
    }
}