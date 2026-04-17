<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payments')->truncate();

        Payment::create([
            'customer_name' => 'Rahul Sharma',
            'customer_email' => 'rahul@example.com',
            'amount' => 140000.00,
            'payment_status' => 'Received',
            'payment_method' => 'Bank Transfer',
            'transaction_id' => 'TXN987654321',
            'payment_date' => now(),
            'created_at' => now(),
        ]);

        Payment::create([
            'customer_name' => 'Priya Verma',
            'customer_email' => 'priya@example.com',
            'amount' => 70000.00,
            'payment_status' => 'Pending',
            'payment_method' => 'UPI',
            'transaction_id' => 'TXN555444333',
            'created_at' => now(),
        ]);
    }
}
