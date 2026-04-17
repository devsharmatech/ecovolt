<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('white_label_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->string('logo_url')->nullable();
            $table->string('primary_color')->default('#007bff');
            $table->string('secondary_color')->default('#6c757d');
            $table->string('subdomain_prefix')->nullable();
            $table->string('welcome_email_template')->nullable();
            $table->string('password_reset_email_template')->nullable();
            $table->timestamps();
            
            $table->unique(['tenant_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('white_label_settings');
    }
};