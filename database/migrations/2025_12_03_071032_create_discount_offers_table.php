<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_discount_offers_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('discount_offers', function (Blueprint $table) {
            $table->id();
            $table->string('rule_name');
            $table->text('description');
            $table->enum('discount_type', ['percentage', 'fixed_amount']);
            $table->decimal('value', 10, 2);
            $table->enum('status', ['active', 'inactive', 'pending']);
            $table->string('applicable_to')->nullable()->comment('e.g., summer items, first-time customers, orders over amount');
            $table->decimal('minimum_order_amount', 10, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('repeat', ['none', 'daily', 'weekly', 'monthly', 'yearly'])->default('none');
            $table->json('repeat_days')->nullable();
            $table->string('approved_by')->nullable();
            $table->date('approved_date')->nullable();
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('discount_approval_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discount_offer_id')->constrained()->onDelete('cascade');
            $table->string('action'); // pending, approved, rejected
            $table->string('acted_by');
            $table->text('comments')->nullable();
            $table->timestamp('acted_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discount_approval_history');
        Schema::dropIfExists('discount_offers');
    }
};