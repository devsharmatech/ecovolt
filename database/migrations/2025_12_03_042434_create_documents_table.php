<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('document_type');
            $table->foreignId('lead_id')->nullable()->constrained('leads')->onDelete('set null');
            $table->enum('status', ['pending', 'verified'])->default('pending');
            $table->date('uploaded_date');
            $table->date('verified_date')->nullable();
            $table->string('document_path')->nullable(); // Path to uploaded document file
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
};