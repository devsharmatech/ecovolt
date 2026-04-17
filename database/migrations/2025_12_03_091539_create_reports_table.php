<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('lead_id')->unique();
            $table->string('name');
            $table->string('email');
            $table->enum('status', ['New', 'Question', 'Qualified', 'Closed', 'Lost']);
            $table->enum('source', ['Website', 'Referral', 'Social Media', 'Email', 'Other']);
            $table->date('date');
            $table->decimal('amount', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reports');
    }
};