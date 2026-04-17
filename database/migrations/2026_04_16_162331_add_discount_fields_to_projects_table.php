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
        Schema::table('projects', function (Blueprint $table) {
            $table->decimal('base_amount', 15, 2)->after('address')->default(0);
            $table->enum('discount_type', ['percentage', 'fixed'])->after('base_amount')->default('fixed');
            $table->decimal('discount_value', 15, 2)->after('discount_type')->default(0);
            $table->decimal('discount_amount', 15, 2)->after('discount_value')->default(0);
            $table->enum('discount_status', ['none', 'pending', 'approved', 'rejected'])->after('discount_amount')->default('none');
            $table->foreignId('discount_approved_by')->nullable()->after('discount_status')->constrained('users')->onDelete('set null');
            $table->text('discount_notes')->nullable()->after('discount_approved_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['discount_approved_by']);
            $table->dropColumn([
                'base_amount',
                'discount_type',
                'discount_value',
                'discount_amount',
                'discount_status',
                'discount_approved_by',
                'discount_notes'
            ]);
        });
    }
};
