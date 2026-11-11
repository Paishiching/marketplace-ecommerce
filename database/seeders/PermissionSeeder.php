<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'products.view', 'products.manage',
            'orders.view', 'orders.manage',
            'vendors.view', 'vendors.manage',
            'suppliers.view', 'suppliers.manage',
            'affiliates.view', 'affiliates.manage',
            'resellers.view', 'resellers.manage',
            'commissions.view', 'commissions.manage',
            'withdrawals.view', 'withdrawals.approve',
            'coupons.manage', 'campaigns.manage',
            'reports.view',
            'settings.manage',
            'users.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['slug' => $permission], ['name' => str_replace(['.', '_'], ' ', $permission)]);
        }

        $superadmin = Role::where('name', 'superadmin')->first();
        $superadmin?->permissions()->sync(Permission::pluck('id'));

        $admin = Role::where('name', 'admin')->first();
        $admin?->permissions()->sync(
            Permission::whereNotIn('slug', ['settings.manage', 'users.manage'])->pluck('id')
        );
    }
}
