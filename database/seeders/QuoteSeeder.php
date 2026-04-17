<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Quote;

class QuoteSeeder extends \Illuminate\Database\Seeder
{
    public function run(): void
    {
        \DB::table('quotes')->truncate();
        
        $projects = \App\Models\Project::with('lead')->get();

        if ($projects->isEmpty()) {
            // Create some dummy projects if none exist
            $dealer = User::role('dealer')->first();
            for ($i = 1; $i <= 5; $i++) {
                $lead = \App\Models\Lead::create([
                    'lead_code' => 'LED-00' . $i,
                    'name' => 'Sample Customer ' . $i,
                    'phone' => '98290' . str_pad($i, 5, '0', STR_PAD_LEFT),
                    'email' => 'customer' . $i . '@example.com',
                    'address' => 'Sample Address ' . $i,
                    'kw_capacity' => 3 + $i,
                    'system_type' => $i % 2 == 0 ? 'on-grid' : 'hybrid',
                    'dealer_id' => $dealer ? $dealer->id : 0,
                    'status' => 'booked'
                ]);

                $projects->push(\App\Models\Project::create([
                    'project_code' => 'PRJ-00' . $i,
                    'lead_id' => $lead->id,
                    'customer_name' => $lead->name,
                    'kw_capacity' => $lead->kw_capacity,
                    'system_type' => $lead->system_type,
                    'total_amount' => 150000 + ($i * 10000),
                    'status' => 'pending',
                    'current_stage' => 'requirement_analysis'
                ]));
            }
        }

        foreach ($projects as $project) {
            $customer = User::where('phone', optional($project->lead)->phone)->first();
            
            // If no customer user exists, create one
            if (!$customer) {
                $customer = User::create([
                    'name' => $project->customer_name,
                    'email' => strtolower(str_replace(' ', '', $project->customer_name)) . '@demo.com',
                    'phone' => $project->lead ? $project->lead->phone : '999990000' . $project->id,
                    'password' => \Hash::make('password')
                ]);
                $customerRole = \Spatie\Permission\Models\Role::where('name', 'customer')->first();
                if ($customerRole) {
                    $customer->assignRole($customerRole);
                }
            }

            Quote::create([
                'user_id' => $customer->id,
                'project_id' => $project->id,
                'proposal_id' => 'EV-2024-' . strtoupper(substr(md5($project->id . time()), 0, 6)),
                'package_name' => $project->kw_capacity . 'kW ' . ucfirst($project->system_type) . ' Solar Package',
                'total_price' => $project->total_amount,
                'status' => 'pending',
                'components' => [
                    'panels' => 'High Efficiency Mono Panels',
                    'inverter' => ucfirst($project->system_type) . ' Solar Inverter',
                    'battery' => ($project->system_type == 'hybrid' || $project->system_type == 'off-grid') ? 'Li-Lon Battery Pack' : 'N/A',
                    'warranty' => '10 Years Standard Warranty'
                ],
                'timeline' => 'Installation timeline: 10-15 working days post approval.',
                'quote_date' => now()
            ]);
        }
    }
}
