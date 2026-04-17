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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('proposal_id')->unique();
            $table->string('package_name');
            $table->decimal('total_price', 15, 2);
            $table->string('status')->default('pending'); // pending, accepted, declined
            $table->json('components'); // panels, inverter, battery, warranty, etc.
            $table->text('timeline')->nullable();
            $table->date('quote_date')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
