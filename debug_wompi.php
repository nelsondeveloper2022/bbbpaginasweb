<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Simular datos del request
$data = [
    'public_key' => 'pub_prod_MQ2T8Hd2rZRvWkkJ8YlhY6z8WYo70j5v',
    'private_key' => 'prv_prod_n60YtBf3FVzjks0f5kpnToo7iim0wk2F',
    'events_key' => 'prod_events_H8C3M14nkogjcNHUoQDdW6X8Y71IMV4S',
    'integrity_key' => 'prod_integrity_3D36HYPOrthTaE4Wh3JQg72hQzZrZrSb',
    'activo' => 1
];

echo "=== DEBUG WOMPI CONFIGURATION ===\n";
echo "Datos recibidos:\n";
print_r($data);

// Validar llaves requeridas
$validator = Illuminate\Support\Facades\Validator::make($data, [
    'public_key' => 'required|string|max:255',
    'private_key' => 'required|string|max:255',
    'events_key' => 'nullable|string|max:255',
    'integrity_key' => 'nullable|string|max:255',
    'sandbox' => 'nullable|boolean',
    'activo' => 'nullable|boolean',
], [
    'public_key.required' => 'La llave pública es obligatoria.',
    'private_key.required' => 'La llave privada es obligatoria.',
]);

echo "\n=== VALIDACIÓN ===\n";
if ($validator->fails()) {
    echo "Errores de validación:\n";
    print_r($validator->errors()->toArray());
} else {
    echo "Validación exitosa\n";
}

// Simular obtención de empresa
echo "\n=== OBTENER EMPRESA ===\n";
try {
    $empresa = App\Models\BbbEmpresa::first();
    if ($empresa) {
        echo "Empresa encontrada: ID = {$empresa->idEmpresa}\n";
        $idEmpresa = $empresa->idEmpresa;
    } else {
        echo "No se encontró ninguna empresa\n";
        exit(1);
    }
} catch (\Exception $e) {
    echo "Error obteniendo empresa: " . $e->getMessage() . "\n";
    exit(1);
}

// Crear/obtener configuración de pagos
echo "\n=== CONFIGURACIÓN DE PAGOS ===\n";
try {
    $pagoConfig = App\Models\BbbEmpresaPago::firstOrCreate(
        ['idEmpresa' => $idEmpresa],
        [
            'pago_online' => false,
            'moneda' => 'COP'
        ]
    );
    echo "Config de pagos: ID = {$pagoConfig->idPagoConfig}\n";
} catch (\Exception $e) {
    echo "Error en configuración de pagos: " . $e->getMessage() . "\n";
    exit(1);
}

// Preparar configuración extra
echo "\n=== CONFIGURACIÓN EXTRA ===\n";
$extraConfig = [
    'sandbox' => false,
];

if (!empty($data['events_key'])) {
    $extraConfig['events_key'] = $data['events_key'];
}

if (!empty($data['integrity_key'])) {
    $extraConfig['integrity_key'] = $data['integrity_key'];
}

echo "Extra config:\n";
print_r($extraConfig);

// Crear/actualizar pasarela Wompi
echo "\n=== PASARELA WOMPI ===\n";
try {
    $wompiPasarela = App\Models\BbbEmpresaPasarela::updateOrCreate(
        [
            'idPagoConfig' => $pagoConfig->idPagoConfig,
            'nombre_pasarela' => 'Wompi'
        ],
        [
            'public_key' => $data['public_key'],
            'private_key' => Illuminate\Support\Facades\Crypt::encryptString($data['private_key']),
            'extra_config' => $extraConfig,
            'activo' => (bool)($data['activo'] ?? true),
        ]
    );
    
    echo "Pasarela Wompi creada/actualizada: ID = {$wompiPasarela->idPasarela}\n";
    echo "Activo: " . ($wompiPasarela->activo ? 'Sí' : 'No') . "\n";
    
    // Si se activa Wompi, activar también pagos online
    if ($wompiPasarela->activo) {
        $pagoConfig->update(['pago_online' => true]);
        echo "Pagos online activados\n";
    }
    
    echo "\n=== ÉXITO ===\n";
    echo "Configuración guardada exitosamente\n";
    
} catch (\Exception $e) {
    echo "Error creando/actualizando pasarela: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}