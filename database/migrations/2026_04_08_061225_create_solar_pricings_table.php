<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('solar_pricings', function (Blueprint $box) {
            $box->id();
            $box->string('category'); // On-grid, Hybrid, Off-grid
            $box->decimal('price_per_kw', 15, 2); // GST Inclusive Price
            $box->decimal('gst_rate', 5, 2)->default(8.9); // Overall 8.9%
            $box->decimal('margin_floor', 5, 2)->default(15.0); // 15% Margin Hard Stop
            $box->timestamps();
        });

        // Seed initial values from the blueprint
        DB::table('solar_pricings')->insert([
            ['category' => 'On-grid', 'price_per_kw' => 65000, 'gst_rate' => 8.9, 'margin_floor' => 15.0, 'created_at' => now()],
            ['category' => 'Hybrid',  'price_per_kw' => 90000, 'gst_rate' => 8.9, 'margin_floor' => 15.0, 'created_at' => now()],
            ['category' => 'Off-grid', 'price_per_kw' => 55000, 'gst_rate' => 8.9, 'margin_floor' => 15.0, 'created_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solar_pricings');
    }
};
