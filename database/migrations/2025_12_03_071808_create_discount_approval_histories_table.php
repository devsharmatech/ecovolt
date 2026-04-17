<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_discount_approval_histories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('discount_approval_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discount_offer_id')->constrained('discount_offers')->onDelete('cascade');
            $table->string('action'); // pending, approved, rejected
            $table->string('acted_by');
            $table->text('comments')->nullable();
            $table->timestamp('acted_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discount_approval_histories');
    }
};