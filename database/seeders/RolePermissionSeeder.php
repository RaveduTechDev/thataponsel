<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'view-dashboard']);

        Permission::create(['name' => 'view-agent']);
        Permission::create(['name' => 'create-agent']);
        Permission::create(['name' => 'update-agent']);
        Permission::create(['name' => 'delete-agent']);

        Permission::create(['name' => 'view-barang']);
        Permission::create(['name' => 'create-barang']);
        Permission::create(['name' => 'update-barang']);
        Permission::create(['name' => 'delete-barang']);

        Role::create(['name' => 'super_admin'])->givePermissionTo([
            'view-dashboard',
            'view-agent',
            'create-agent',
            'update-agent',
            'delete-agent',
        ]);
        Role::create(['name' => 'owner'])->givePermissionTo([
            'view-dashboard',
            'view-agent',
            'create-agent',
            'update-agent',
            'delete-agent',
        ]);
        Role::create(['name' => 'admin'])->givePermissionTo([
            'view-dashboard',
            'view-agent',
            'create-agent',
            'update-agent',
            'delete-agent',
        ]);
        Role::create(['name' => 'agen'])->givePermissionTo([
            'view-dashboard',
        ]);
    }
}
