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
        Schema::create('license_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('license_id'); // ID de la licencia (user_id)
            $table->string('license_type'); // trial, subscription
            $table->date('expiration_date'); // Fecha de expiración
            $table->integer('days_before_expiry'); // 5, 3, 1
            $table->string('notification_type'); // reminder_5_days, reminder_3_days, reminder_1_day
            $table->string('email_sent_to');
            $table->text('email_content')->nullable();
            $table->boolean('email_sent')->default(false);
            $table->timestamp('sent_at')->nullable();
            $table->json('user_data')->nullable(); // Datos del usuario al momento del envío
            $table->timestamps();
            
            // Evitar duplicados
            $table->unique(['user_id', 'notification_type', 'expiration_date'], 'license_notifications_unique');
            
            // Índices para optimizar consultas
            $table->index(['expiration_date', 'notification_type']);
            $table->index(['email_sent', 'sent_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license_notifications');
    }
};
