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
            $table->string('documento', 20)->nullable()->after('direccion');
            $table->date('fecha_nacimiento')->nullable()->after('documento');
            $table->text('notas')->nullable()->after('fecha_nacimiento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bbbclient', function (Blueprint $table) {
            $table->dropColumn(['documento', 'fecha_nacimiento', 'notas']);
        });
    }
};
