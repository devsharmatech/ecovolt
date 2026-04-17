<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\SupportSetting::create([
            'whatsapp' => '+911234567890',
            'helpline' => '1800-ECO-VOLT',
            'email' => 'support@ecovolt.com'
        ]);

        \App\Models\Faq::create([
            'question' => 'How to track solar generation?',
            'answer' => 'You can track live generation from the \'Energy Insight\' chart on your home dashboard.',
            'order' => 1
        ]);

        \App\Models\Faq::create([
            'question' => 'What to do in case of power loss?',
            'answer' => 'Check your inverter status. If offline, call our emergency helpline immediately.',
            'order' => 2
        ]);

        \App\Models\Faq::create([
            'question' => 'How to download invoices?',
            'answer' => 'Go to the \'Payments\' section and select \'Receipts\' to view and download files.',
            'order' => 3
        ]);
    }
}
