<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Project 1: Cash payment — mid-way at Commissioning
        Project::create([
            'project_code'          => 'PRJ-0001',
            'lead_id'               => 1, // Rahul Sharma — LED-001
            'customer_name'         => 'Rahul Sharma',
            'payment_mode'          => 'cash',
            'current_stage'         => 'commissioning',
            'status'                => 'active',

            // Financial
            'total_amount'          => 148500.00,
            'part_payment_amount'   => 45000.00,
            'subsidy_amount'        => 78000.00,

            // Timeline — all previous stages completed
            'kyc_completed_at'      => now()->subDays(30),
            'geo_tag_at'            => now()->subDays(27),
            'suryaghar_at'          => now()->subDays(24),
            'payment_selected_at'   => now()->subDays(20),
            'net_metering_at'       => now()->subDays(14),
            'inspection_at'         => now()->subDays(10),
            'part_payment_at'       => now()->subDays(6),

            'notes'                 => '5kW On-Grid system. Roof is RCC flat — no shading issues. Delhi DISCOM: BSES Rajdhani. Consumer No: DL123456789.',
            'created_at'            => now()->subDays(30),
            'updated_at'            => now()->subDays(2),
        ]);

        // Project 2: Bank finance — completed (subsidy redeemed)
        Project::create([
            'project_code'          => 'PRJ-0002',
            'lead_id'               => 2, // Priya Verma — LED-002
            'customer_name'         => 'Priya Verma',
            'payment_mode'          => 'bank',
            'current_stage'         => 'subsidy_redemption',
            'status'                => 'completed',

            // Financial
            'total_amount'          => 295000.00,
            'part_payment_amount'   => 90000.00,
            'subsidy_amount'        => 94500.00,

            // Timeline — all stages completed (bank route)
            'kyc_completed_at'      => now()->subDays(60),
            'geo_tag_at'            => now()->subDays(57),
            'suryaghar_at'          => now()->subDays(54),
            'payment_selected_at'   => now()->subDays(50),
            'bank_login_at'         => now()->subDays(45),
            'bank_disbursement_at'  => now()->subDays(38),
            'net_metering_at'       => now()->subDays(28),
            'inspection_at'         => now()->subDays(20),
            'part_payment_at'       => now()->subDays(14),
            'commissioning_at'      => now()->subDays(8),
            'subsidy_at'            => now()->subDays(2),

            'notes'                 => '10kW Hybrid system — Tata Solar panels. Bank: SBI Green Loan. DISCOM: MSEDCL Mumbai. Consumer No: MH-9988776655. Project completed successfully.',
            'created_at'            => now()->subDays(60),
            'updated_at'            => now()->subDays(2),
        ]);
    }
}
