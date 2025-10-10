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
        Schema::table('bbbclient', function (Blueprint $table) {
            // Verificar si las columnas ya existen antes de agregarlas
            if (!Schema::hasColumn('bbbclient', 'idEmpresa')) {
                $table->unsignedBigInteger('idEmpresa')->after('idCliente');
                $table->foreign('idEmpresa')->references('idEmpresa')->on('bbbempresa')->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('bbbclient', 'telefono')) {
                $table->string('telefono', 20)->nullable()->after('email');
            }
            
            if (!Schema::hasColumn('bbbclient', 'direccion')) {
                $table->text('direccion')->nullable()->after('telefono');
            }
            
            if (!Schema::hasColumn('bbbclient', 'estado')) {
                $table->string('estado', 50)->default('activo')->after('direccion');
            }
            
            if (!Schema::hasColumn('bbbclient', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bbbclient', function (Blueprint $table) {
            // Eliminar columnas agregadas (en orden inverso)
            if (Schema::hasColumn('bbbclient', 'created_at')) {
                $table->dropTimestamps();
            }
            
            if (Schema::hasColumn('bbbclient', 'estado')) {
                $table->dropColumn('estado');
            }
            
            if (Schema::hasColumn('bbbclient', 'direccion')) {
                $table->dropColumn('direccion');
            }
            
            if (Schema::hasColumn('bbbclient', 'telefono')) {
                $table->dropColumn('telefono');
            }
            
            if (Schema::hasColumn('bbbclient', 'idEmpresa')) {
                $table->dropForeign(['idEmpresa']);
                $table->dropColumn('idEmpresa');
            }
        });
    }
};
