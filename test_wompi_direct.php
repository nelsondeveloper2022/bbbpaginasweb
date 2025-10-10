<?php

use App\Models\BbbEmpresaPago;
use App\Models\BbbEmpresaPasarela;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

// Test directo de la funcionalidad storeWompi
$data = [
    'public_key' => 'pub_prod_MQ2T8Hd2rZRvWkkJ8YlhY6z8WYo70j5v',
    'private_key' => 'prv_prod_n60YtBf3FVzjks0f5kpnToo7iim0wk2F',
    'events_key' => 'prod_events_H8C3M14nkogjcNHUoQDdW6X8Y71IMV4S',
    'integrity_key' => 'prod_integrity_3D36HYPOrthTaE4Wh3JQg72hQzZrZrSb',
    'activo' => '1'
];

$idEmpresa = 11; // Empresa de Giovanny

echo "=== TEST DIRECTO WOMPI ===\n";
echo "ID Empresa: $idEmpresa\n";

try {
    // Step 1: Obtener o crear la configuración de pagos
    echo "\n--- Step 1: Configuración de pagos ---\n";
    $pagoConfig = BbbEmpresaPago::firstOrCreate(
        ['idEmpresa' => $idEmpresa],
        [
            'pago_online' => false,
            'moneda' => 'COP'
        ]
    );
    echo "Pago Config ID: " . $pagoConfig->idPagoConfig . "\n";

    // Step 2: Preparar configuración extra
    echo "\n--- Step 2: Configuración extra ---\n";
    $extraConfig = [
        'sandbox' => false,
    ];

    if (!empty($data['events_key'])) {
        $extraConfig['events_key'] = $data['events_key'];
    }

    if (!empty($data['integrity_key'])) {
        $extraConfig['integrity_key'] = $data['integrity_key'];
    }
    
    echo "Extra config: " . json_encode($extraConfig) . "\n";

    // Step 3: Crear/actualizar pasarela Wompi
    echo "\n--- Step 3: Crear pasarela Wompi ---\n";
    
    // Primero verificar si existe
    $existing = BbbEmpresaPasarela::where('idPagoConfig', $pagoConfig->idPagoConfig)
        ->where('nombre_pasarela', 'Wompi')
        ->first();
    
    if ($existing) {
        echo "Pasarela existente encontrada: ID = " . $existing->idPasarela . "\n";
    } else {
        echo "No hay pasarela existente, se creará nueva\n";
    }
    
    $wompiPasarela = BbbEmpresaPasarela::updateOrCreate(
        [
            'idPagoConfig' => $pagoConfig->idPagoConfig,
            'nombre_pasarela' => 'Wompi'
        ],
        [
            'public_key' => $data['public_key'],
            'private_key' => Crypt::encryptString($data['private_key']),
            'extra_config' => $extraConfig,
            'activo' => (bool)($data['activo'] ?? true),
        ]
    );

    echo "Pasarela Wompi guardada: ID = " . $wompiPasarela->idPasarela . "\n";
    echo "Activa: " . ($wompiPasarela->activo ? 'Sí' : 'No') . "\n";

    // Step 4: Activar pagos online si Wompi está activo
    if ($wompiPasarela->activo) {
        echo "\n--- Step 4: Activando pagos online ---\n";
        $pagoConfig->update(['pago_online' => true]);
        echo "Pagos online activados\n";
    }

    echo "\n=== ÉXITO COMPLETO ===\n";

} catch (\Exception $e) {
    echo "\n=== ERROR ===\n";
    echo "Mensaje: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}