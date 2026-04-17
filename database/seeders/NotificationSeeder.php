<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Notification::create([
            'user_id' => 1,
            'title' => 'Peak Generation Reached',
            'description' => 'Excellent! Your solar system reached 5.2kW generation today morning. Efficiency is at 98%.',
            'type' => 'Alerts',
            'is_read' => false,
        ]);

        \App\Models\Notification::create([
            'user_id' => 1,
            'title' => 'Payment Confirmed',
            'description' => "We've received your payment of $1,200 for the Material Phase. Your receipt is now available.",
            'type' => 'Payments',
            'is_read' => false,
        ]);

        \App\Models\Notification::create([
            'user_id' => 1,
            'title' => 'Monthly Service Scheduled',
            'description' => 'Technician Rahul will visit tomorrow between 10 AM - 12 PM for routine maintenance.',
            'type' => 'Service',
            'is_read' => true,
        ]);
    }
}
