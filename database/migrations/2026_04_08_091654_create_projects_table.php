<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_code')->unique(); // PRJ-001
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->string('customer_name');
            $table->enum('payment_mode', ['cash', 'bank', 'pending'])->default('pending');

            // Stage Tracking
            $table->enum('current_stage', [
                'kyc_complete',
                'geo_tag_upload',
                'pm_suryaghar_registration',
                'payment_mode_selection',
                'bank_login',
                'bank_disbursement',
                'net_metering',
                'inspection',
                'part_payment',
                'commissioning',
                'subsidy_redemption',
            ])->default('kyc_complete');

            // Stage Completion Dates
            $table->timestamp('kyc_completed_at')->nullable();
            $table->timestamp('geo_tag_at')->nullable();
            $table->timestamp('suryaghar_at')->nullable();
            $table->timestamp('payment_selected_at')->nullable();
            $table->timestamp('bank_login_at')->nullable();
            $table->timestamp('bank_disbursement_at')->nullable();
            $table->timestamp('net_metering_at')->nullable();
            $table->timestamp('inspection_at')->nullable();
            $table->timestamp('part_payment_at')->nullable();
            $table->timestamp('commissioning_at')->nullable();
            $table->timestamp('subsidy_at')->nullable();

            // Financial
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->decimal('part_payment_amount', 10, 2)->nullable();
            $table->decimal('subsidy_amount', 10, 2)->nullable();
            
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'completed', 'on_hold'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
