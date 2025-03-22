<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('mobile')->nullable()->after('email'); // Add mobile column
            $table->string('mobile_verification_code')->nullable(); // Store verification code
            $table->timestamp('mobile_verification_code_expires_at')->nullable(); // Code expiration time
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['mobile', 'mobile_verification_code', 'mobile_verification_code_expires_at']);
    });
}
};
