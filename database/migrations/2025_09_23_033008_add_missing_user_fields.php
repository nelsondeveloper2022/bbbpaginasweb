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
            if (!Schema::hasColumn('users', 'movil')) {
                $table->string('movil')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'company_name')) {
                $table->string('company_name')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'contact_phone')) {
                $table->string('contact_phone')->nullable()->after('company_name');
            }
            if (!Schema::hasColumn('users', 'idEmpresa')) {
                $table->unsignedBigInteger('idEmpresa')->nullable()->after('contact_phone');
            }
            if (!Schema::hasColumn('users', 'id_plan')) {
                $table->unsignedBigInteger('id_plan')->nullable()->after('idEmpresa');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = ['movil', 'company_name', 'contact_phone', 'idEmpresa', 'id_plan'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
