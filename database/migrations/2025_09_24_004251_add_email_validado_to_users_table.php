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
            $table->boolean('emailValidado')->default(false)->after('email_verified_at');
            $table->string('email_verification_token', 64)->nullable()->after('emailValidado');
            $table->timestamp('email_verification_sent_at')->nullable()->after('email_verification_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['emailValidado', 'email_verification_token', 'email_verification_sent_at']);
        });
    }
};
