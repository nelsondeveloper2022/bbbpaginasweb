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
        // Tabla de configuración de pagos de la empresa
        if (!Schema::hasTable('bbbempresapagos')) {
            Schema::create('bbbempresapagos', function (Blueprint $table) {
                $table->id('idPagoConfig');
                $table->unsignedBigInteger('idEmpresa');
                $table->boolean('pago_online')->default(false);
                $table->string('moneda', 10)->default('COP');
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

                $table->index('idEmpresa', 'idx_empresa_pago');
                $table->foreign('idEmpresa', 'fk_pago_empresa')
                    ->references('idEmpresa')
                    ->on('bbbempresa')
                    ->onDelete('cascade');
            });
        }

        // Tabla de pasarelas de pago
        if (!Schema::hasTable('bbbempresapasarelas')) {
            Schema::create('bbbempresapasarelas', function (Blueprint $table) {
                $table->id('idPasarela');
                $table->unsignedBigInteger('idPagoConfig');
                $table->string('nombre_pasarela', 100)->comment('Ej: Wompi');
                $table->text('public_key')->nullable();
                $table->text('private_key')->nullable();
                $table->json('extra_config')->nullable();
                $table->boolean('activo')->default(true);
                $table->timestamp('created_at')->useCurrent();

                $table->index('idPagoConfig', 'idx_pago_pasarela');
                $table->foreign('idPagoConfig', 'fk_pasarela_pago')
                    ->references('idPagoConfig')
                    ->on('bbbempresapagos')
                    ->onDelete('cascade');
            });
        }

        // Tabla de confirmaciones de pago
        if (!Schema::hasTable('bbbventapagoconfirmacion')) {
            Schema::create('bbbventapagoconfirmacion', function (Blueprint $table) {
                $table->id('idPagoConfirmacion');
                $table->unsignedBigInteger('idVenta');
                $table->unsignedBigInteger('idEmpresa');
                $table->string('referencia', 200)->nullable();
                $table->string('transaccion_id', 200)->nullable();
                $table->decimal('monto', 12, 2);
                $table->string('moneda', 10)->default('COP');
                $table->string('estado', 50)->default('pendiente');
                $table->json('respuesta_completa')->nullable();
                $table->timestamp('fecha_confirmacion')->useCurrent();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

                $table->index('idEmpresa', 'idx_empresa_pago_confirmacion');
                $table->index('idVenta', 'idx_venta_pago_confirmacion');
                $table->index('transaccion_id', 'idx_transaccion_id');
                $table->index('referencia', 'idx_referencia');

                $table->foreign('idEmpresa', 'fk_pago_confirmacion_empresa')
                    ->references('idEmpresa')
                    ->on('bbbempresa')
                    ->onDelete('cascade');

                $table->foreign('idVenta', 'fk_pago_confirmacion_venta')
                    ->references('idVenta')
                    ->on('bbbventaonline')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bbbventapagoconfirmacion');
        Schema::dropIfExists('bbbempresapasarelas');
        Schema::dropIfExists('bbbempresapagos');
    }
};
