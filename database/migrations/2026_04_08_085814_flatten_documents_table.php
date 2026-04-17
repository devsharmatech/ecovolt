<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            // Document paths
            $table->string('pan_path')->nullable();
            $table->string('aadhaar_path')->nullable();
            $table->string('bill_path')->nullable();
            $table->string('bank_path')->nullable();
            $table->string('geo_path')->nullable();
            
            // Text info
            $table->string('email_val')->nullable();
            $table->string('mobile_val')->nullable();

            // Removing old columns
            $table->dropColumn(['document_type', 'document_path']);
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->string('document_type')->nullable();
            $table->string('document_path')->nullable();
            $table->dropColumn(['pan_path', 'aadhaar_path', 'bill_path', 'bank_path', 'geo_path', 'email_val', 'mobile_val']);
        });
    }
};
