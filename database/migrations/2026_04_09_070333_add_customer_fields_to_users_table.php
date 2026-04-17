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
        Schema::table('users', function (Blueprint $table) {
            $table->string('consumer_id')->nullable()->after('email');
            $table->text('service_address')->nullable()->after('consumer_id');
            $table->string('otp', 4)->nullable()->after('service_address');
            $table->boolean('is_verified')->default(false)->after('otp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['consumer_id', 'service_address', 'otp', 'is_verified']);
        });
    }
};
