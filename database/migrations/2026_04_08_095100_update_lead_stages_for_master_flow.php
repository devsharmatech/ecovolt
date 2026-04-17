<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Adding columns for the Master Flow
        Schema::table('leads', function (Blueprint $table) {
            // Update enum or add column if enum is too restrictive
            // Since MySQL enum modification is tricky in Laravel migrations, 
            // we will use a string column for flexible stages if not already.
            $table->string('stage')->default('Entry')->change();
            
            // Financials for Booking
            $table->decimal('booking_amount', 12, 2)->nullable()->after('kw_capacity');
            $table->timestamp('survey_done_at')->nullable();
            $table->timestamp('quotation_sent_at')->nullable();
            $table->timestamp('booking_done_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn(['booking_amount', 'survey_done_at', 'quotation_sent_at', 'booking_done_at']);
        });
    }
};
