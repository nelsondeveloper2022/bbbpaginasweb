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
        Schema::create('bbb_producto_imagenes', function (Blueprint $table) {
            $table->id('idImagen');
            $table->unsignedBigInteger('idProducto');
            $table->string('imagen');
            $table->string('alt')->nullable();
            $table->integer('orden')->default(0);
            $table->timestamps();

            // Índices y relaciones
            $table->foreign('idProducto')->references('idProducto')->on('bbb_productos')->onDelete('cascade');
            $table->index(['idProducto', 'orden']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bbb_producto_imagenes');
    }
};
