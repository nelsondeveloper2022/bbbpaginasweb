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
            // Solo agregar movil si no existe
            if (!Schema::hasColumn('users', 'movil')) {
                $table->string('movil')->nullable()->after('email');
            }
            // Solo agregar id_plan si no existe
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
            $table->dropColumn(['movil', 'id_plan']);
        });
    }
};