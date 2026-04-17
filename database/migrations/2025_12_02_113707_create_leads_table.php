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
        Schema::create('leads', function (Blueprint $box) {
            $box->id();
            $box->string('lead_code')->unique(); // LED-001 format
            
            // Personal & Contact Info
            $box->string('first_name')->nullable();
            $box->string('last_name')->nullable();
            $box->string('email')->nullable();
            $box->string('phone', 15)->nullable();
            
            // Solar Specifics
            $box->enum('system_type', ['On-grid', 'Hybrid', 'Off-grid'])->default('On-grid');
            $box->decimal('kw_capacity', 10, 2)->default(0.00);
            
            // Location & Geo-tagging
            $box->text('full_address')->nullable();
            $box->string('city')->nullable();
            $box->string('state')->nullable();
            $box->string('pincode', 10)->nullable();
            $box->string('geo_latitude')->nullable();
            $box->string('geo_longitude')->nullable();
            
            // Workflow & Assignment
            $box->unsignedBigInteger('assigned_employee_id')->nullable();
            $box->unsignedBigInteger('dealer_id')->nullable(); 
            
            $box->string('stage')->default('Entry'); // Entry -> Assigned -> Qualified -> Survey -> Quotation -> Booking
            $box->boolean('is_archive')->default(false);
            
            // SLA Management
            $box->timestamp('assigned_at')->nullable();
            $box->timestamp('sla_alert_at')->nullable(); 
            $box->timestamp('sla_escalate_at')->nullable(); 

            $box->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};