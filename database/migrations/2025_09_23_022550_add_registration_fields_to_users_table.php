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
            // Agregar campos que faltan para el registro
            if (!Schema::hasColumn('users', 'empresa_nombre')) {
                $table->string('empresa_nombre')->nullable()->after('movil');
            }
            if (!Schema::hasColumn('users', 'empresa_email')) {
                $table->string('empresa_email')->nullable()->after('empresa_nombre');
            }
            if (!Schema::hasColumn('users', 'empresa_direccion')) {
                $table->string('empresa_direccion')->nullable()->after('empresa_email');
            }
            if (!Schema::hasColumn('users', 'trial_ends_at')) {
                $table->timestamp('trial_ends_at')->nullable()->after('updated_at');
            }
            if (!Schema::hasColumn('users', 'free_trial_days')) {
                $table->integer('free_trial_days')->default(15)->after('trial_ends_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'empresa_nombre',
                'empresa_email', 
                'empresa_direccion',
                'trial_ends_at',
                'free_trial_days'
            ]);
        });
    }
};
