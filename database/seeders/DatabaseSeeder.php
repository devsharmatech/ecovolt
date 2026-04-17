<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(RolePermissionSeeder::class);

        // Keep the Admin logic, clear all other legacy test users for clean state
        User::where('email', '!=', 'admin@gmail.com')->delete();

        if (User::where('email', 'admin@gmail.com')->count() == 0) {
            $admin = User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
            ]);
            $admin->assignRole('admin');
        }

        $accounts = User::factory()->create([
            'name' => 'Accounts Manager',
            'email' => 'accounts@ecovolt.com',
            'password' => Hash::make('12345678'),
        ]);
        $accounts->assignRole('accounts');

        $dealer = User::factory()->create([
            'name' => 'Partner Dealer',
            'email' => 'dealer@ecovolt.com',
            'password' => Hash::make('12345678'),
        ]);
        $dealer->assignRole('dealer');

        $employee = User::factory()->create([
            'name' => 'Internal Employee',
            'email' => 'employee@ecovolt.com',
            'password' => Hash::make('12345678'),
        ]);
        $employee->assignRole('employee');
        
        $customer = User::factory()->create([
            'name' => 'Retail Customer',
            'email' => 'customer@ecovolt.com',
            'password' => Hash::make('12345678'),
        ]);
        $customer->assignRole('customer');
        
    }
}
