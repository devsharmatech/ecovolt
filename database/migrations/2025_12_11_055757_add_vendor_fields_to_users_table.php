<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Business Information
            $table->string('business_name')->nullable()->after('locality');
            $table->string('business_type')->nullable()->after('business_name');
            $table->string('gst_number')->nullable()->after('business_type');
            $table->string('pan_number')->nullable()->after('gst_number');
            
            // Business Address
            $table->text('business_address')->nullable()->after('pan_number');
            $table->string('business_city')->nullable()->after('business_address');
            $table->string('business_state')->nullable()->after('business_city');
            $table->string('business_pincode')->nullable()->after('business_state');
            
            // Bank Details
            $table->string('bank_name')->nullable()->after('business_pincode');
            $table->string('account_number')->nullable()->after('bank_name');
            $table->string('ifsc_code')->nullable()->after('account_number');
            $table->string('account_holder_name')->nullable()->after('ifsc_code');
            
            // Documents
            $table->string('aadhar_card')->nullable()->after('account_holder_name');
            $table->string('pan_card')->nullable()->after('aadhar_card');
            $table->string('gst_certificate')->nullable()->after('pan_card');
            $table->string('bank_passbook')->nullable()->after('gst_certificate');
            
            // Verification
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending')->after('bank_passbook');
            $table->text('verification_notes')->nullable()->after('verification_status');
            
            // Business Description
            $table->text('business_description')->nullable()->after('verification_notes');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'business_name',
                'business_type',
                'gst_number',
                'pan_number',
                'business_address',
                'business_city',
                'business_state',
                'business_pincode',
                'bank_name',
                'account_number',
                'ifsc_code',
                'account_holder_name',
                'aadhar_card',
                'pan_card',
                'gst_certificate',
                'bank_passbook',
                'verification_status',
                'verification_notes',
                'business_description'
            ]);
        });
    }
};