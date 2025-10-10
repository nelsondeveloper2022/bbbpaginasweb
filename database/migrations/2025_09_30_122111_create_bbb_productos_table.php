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
        Schema::create('bbb_productos', function (Blueprint $table) {
            $table->id('idProducto');
            $table->unsignedBigInteger('idEmpresa');
            $table->string('nombre', 200);
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 15, 2);
            $table->decimal('costo', 15, 2)->default(0)->comment('Costo del producto');
            $table->integer('stock')->default(0);
            $table->string('slug', 220)->unique();
            $table->string('imagen')->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->timestamps();

            // Índices
            $table->foreign('idEmpresa')->references('idEmpresa')->on('bbb_empresa')->onDelete('cascade');
            $table->index(['idEmpresa', 'estado']);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bbb_productos');
    }
};
