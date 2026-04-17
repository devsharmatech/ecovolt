<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('system_type')->nullable()->after('customer_name');
            $table->decimal('kw_capacity', 8, 2)->nullable()->after('system_type');
            $table->string('address')->nullable()->after('kw_capacity');
            $table->string('suryaghar_app_no')->nullable()->after('subsidy_amount');
            $table->string('discom_name')->nullable()->after('suryaghar_app_no');
            $table->string('consumer_no')->nullable()->after('discom_name');
            $table->string('meter_no')->nullable()->after('consumer_no');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['system_type', 'kw_capacity', 'address', 'suryaghar_app_no', 'discom_name', 'consumer_no', 'meter_no']);
        });
    }
};
