<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Module Permissions (Grouped by module name)
        $modules = [
            'roles'       => ['create', 'view','edit', 'update', 'delete','show'],
            'permissions' => ['create', 'view', 'edit','update', 'delete','show'],
            'users'       => ['create', 'view', 'edit','update', 'delete','show','profile-update', 'avatar-update','change-password','status-update'],
            'leads'       => ['create', 'view', 'edit','update', 'delete','show', 'assign'],
            'documents'   => ['create', 'view', 'edit','update', 'delete','show'],
            'discount-offers' => ['create', 'view', 'edit','update', 'delete','show'],
            'reports'     => ['create', 'view', 'edit','update', 'delete','show'],
            'notification-settings' => ['create', 'view', 'edit','update', 'delete','show'],
            'pricings'    => ['view', 'update', 'delete'],
            'gst'         => ['view', 'update'],
            'payments'    => ['view', 'update'],
            'discounts'   => ['view', 'update'],
            'quotes'      => ['create', 'view', 'edit', 'update', 'delete', 'show'],
            'cms'         => ['create', 'view', 'edit', 'update', 'delete', 'show'],
        ];

        $allPermissions = [];
        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                $permissionName = $module . '.' . $action;
                Permission::firstOrCreate(['name' => $permissionName]);
                $allPermissions[] = $permissionName;
            }
        }

        // 2. Exact requested Roles
        $admin      = Role::firstOrCreate(['name' => 'admin']);
        $employee   = Role::firstOrCreate(['name' => 'employee']);
        $dealer     = Role::firstOrCreate(['name' => 'dealer']);
        $customer   = Role::firstOrCreate(['name' => 'customer']);
        $accounts   = Role::firstOrCreate(['name' => 'accounts']);
       

        // 3. Assign Permissions
        $admin->syncPermissions($allPermissions);
        
        // Accounts can view payments and pricings
        $accounts->givePermissionTo(['payments.view', 'pricings.view', 'gst.view']);
        
        // Dealer can create leads
        $dealer->givePermissionTo(['leads.create', 'leads.view', 'leads.show']);

        // Employee can manage leads assigned to them
        $employee->givePermissionTo(['leads.view', 'leads.show', 'leads.edit']);

        echo "EcoVolt EXACT Roles (Admin, Employee, Dealer, Customer, Accounts) Restored.\n";
    }
}
