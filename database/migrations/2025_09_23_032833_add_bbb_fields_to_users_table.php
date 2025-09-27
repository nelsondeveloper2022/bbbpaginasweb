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
            $table->string('movil')->nullable()->after('email');
            $table->string('company_name')->nullable()->after('movil');
            $table->string('contact_phone')->nullable()->after('company_name');
            $table->unsignedBigInteger('idEmpresa')->nullable()->after('contact_phone');
            $table->unsignedBigInteger('id_plan')->nullable()->after('idEmpresa');
            $table->string('nombre_contacto')->nullable()->after('id_plan');
            $table->string('empresa_nombre')->nullable()->after('nombre_contacto');
            $table->string('plan_seleccionado')->nullable()->after('empresa_nombre');
            $table->timestamp('trial_ends_at')->nullable()->after('plan_seleccionado');
            $table->integer('free_trial_days')->default(15)->after('trial_ends_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'movil',
                'company_name',
                'contact_phone',
                'idEmpresa',
                'id_plan',
                'nombre_contacto',
                'empresa_nombre',
                'plan_seleccionado',
                'trial_ends_at',
                'free_trial_days'
            ]);
        });
    }
};
