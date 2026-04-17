<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;

class LeadSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('leads')->truncate();

        Lead::create([
            'lead_code' => 'LED-001',
            'first_name' => 'Rahul',
            'last_name' => 'Sharma',
            'phone' => '9876543210',
            'email' => 'rahul@example.com',
            'system_type' => 'On-grid',
            'kw_capacity' => 5.0,
            'city' => 'Delhi',
            'stage' => 'Entry',
            'created_at' => now(),
        ]);

        Lead::create([
            'lead_code' => 'LED-002',
            'first_name' => 'Priya',
            'last_name' => 'Verma',
            'phone' => '9888877777',
            'email' => 'priya@example.com',
            'system_type' => 'Hybrid',
            'kw_capacity' => 10.0,
            'city' => 'Mumbai',
            'stage' => 'Assigned',
            'created_at' => now(),
        ]);

        Lead::create([
            'lead_code' => 'LED-003',
            'first_name' => 'Amit',
            'last_name' => 'Gupta',
            'phone' => '9111122222',
            'email' => 'amit@example.com',
            'system_type' => 'Off-grid',
            'kw_capacity' => 3.5,
            'city' => 'Jaipur',
            'stage' => 'Qualified',
            'created_at' => now(),
        ]);
    }
}
