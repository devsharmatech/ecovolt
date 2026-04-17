<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_settings', function (Blueprint $box) {
            $box->id();
            $box->decimal('booking_perc', 5, 2)->default(70.0);
            $box->decimal('commissioning_perc', 5, 2)->default(30.0);
            $box->timestamps();
        });

        DB::table('payment_settings')->insert([
            'booking_perc' => 70.0,
            'commissioning_perc' => 30.0,
            'created_at' => now()
        ]);

        Schema::create('discount_settings', function (Blueprint $box) {
            $box->id();
            $box->decimal('employee_limit', 5, 2)->default(0.0);
            $box->decimal('manager_limit', 5, 2)->default(5.0);
            $box->decimal('coo_limit', 5, 2)->default(10.0);
            $box->decimal('margin_floor', 5, 2)->default(15.0);
            $box->timestamps();
        });

        DB::table('discount_settings')->insert([
            'employee_limit' => 0.0,
            'manager_limit' => 5.0,
            'coo_limit' => 10.0,
            'margin_floor' => 15.0,
            'created_at' => now()
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_settings');
        Schema::dropIfExists('discount_settings');
    }
};
