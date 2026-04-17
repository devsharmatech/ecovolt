<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SolarPricingSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Permissions
        Permission::firstOrCreate(['name' => 'pricings.view']);
        Permission::firstOrCreate(['name' => 'pricings.update']);
        Permission::firstOrCreate(['name' => 'pricings.delete']);
        Permission::firstOrCreate(['name' => 'gst.view']);
        Permission::firstOrCreate(['name' => 'gst.update']);
        Permission::firstOrCreate(['name' => 'payments.view']);
        Permission::firstOrCreate(['name' => 'payments.update']);
        Permission::firstOrCreate(['name' => 'discounts.view']);
        Permission::firstOrCreate(['name' => 'discounts.update']);

        // 2. Assign to Admin
        $admin = Role::where('name', 'admin')->first();
        if ($admin) {
            $admin->givePermissionTo(['pricings.view', 'pricings.update', 'pricings.delete', 'gst.view', 'gst.update', 'payments.view', 'payments.update', 'discounts.view', 'discounts.update']);
        }
    }
}
