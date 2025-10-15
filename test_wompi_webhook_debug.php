<?php
/**
 * Script de prueba para debuggear el webhook de Wompi
 * Ejecutar: php test_wompi_webhook_debug.php
 */

// Incluir autoload de Laravel
require_once __DIR__ . '/vendor/autoload.php';

// Bootear Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\Api\WompiController;
use Illuminate\Support\Facades\Log;

echo "=== TEST WOMPI WEBHOOK DEBUG ===\n";

// Payload de ejemplo basado en tu estructura
$payload = [
    "data" => [
        "transaction" => [
            "id" => "1312437-1760414356-52175",
            "origin" => null,
            "status" => "APPROVED",
            "currency" => "COP",
            "reference" => "BBB-AO0QDZYLLS-1760414260",
            "created_at" => "2025-10-14T03:59:16.428Z",
            "billing_data" => null,
            "finalized_at" => "2025-10-14T04:00:19.018Z",
            "redirect_url" => "https://bbbpaginasweb.com/admin/plans/success",
            "customer_data" => [
                "legal_id" => "1101760826",
                "device_id" => "1f01f7f9390ebfbb419c9255183d9484",
                "full_name" => "Juan Rodríguez",
                "browser_info" => [
                    "browser_tz" => "300",
                    "browser_language" => "es-MX",
                    "browser_user_agent" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.6 Safari/605.1.15",
                    "browser_color_depth" => "24",
                    "browser_screen_width" => "2560",
                    "browser_screen_height" => "1080"
                ],
                "phone_number" => "3168122902",
                "legal_id_type" => "CC",
            ],
            "customer_email" => "juandieqoro@gmail.com",
            "payment_method" => [
                "type" => "NEQUI",
                "extra" => [
                    "is_three_ds" => false,
                    "transaction_id" => "350-123-47019-1760414357P4ma",
                    "three_ds_auth_type" => null,
                    "external_identifier" => "1760414357P4ma",
                    "nequi_transaction_id" => "350-123-47019-1760414357P4ma"
                ],
                "afe_decision" => "APPROVE",
                "phone_number" => "3168122902"
            ],
            "status_message" => null,
            "amount_in_cents" => 4500000,
            "payment_link_id" => null,
            "shipping_address" => [
                "city" => "Bogotá",
                "region" => "Cundinamarca",
                "country" => "CO",
                "phone_number" => "3168122902",
                "address_line_1" => "Calle 123 # 45-67"
            ],
            "payment_source_id" => null,
            "payment_method_type" => "NEQUI"
        ]
    ],
    "event" => "transaction.updated",
    "sent_at" => "2025-10-14T04:00:19.569Z",
    "signature" => [
        "checksum" => "189ea4f55543e56261fd246ada2e3e1a1e11fdf5c1ca1c4e3fdd39fa865aa06b",
        "properties" => [
            "transaction.id",
            "transaction.status",
            "transaction.amount_in_cents"
        ]
    ],
    "timestamp" => 1760414419,
    "environment" => "prod"
];

$jsonPayload = json_encode($payload);

echo "Payload generado:\n";
echo substr($jsonPayload, 0, 200) . "...\n\n";

// Crear request simulado
$request = Request::create('/api/payments/wompi/webhook', 'POST', [], [], [], [], $jsonPayload);
$request->headers->set('Content-Type', 'application/json');

echo "Creando controller y ejecutando webhook...\n";

try {
    $controller = new WompiController();
    $response = $controller->webhook($request);
    
    echo "Respuesta recibida:\n";
    echo "Status: " . $response->getStatusCode() . "\n";
    echo "Content: " . $response->getContent() . "\n";
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== Revisa los logs en storage/logs/laravel.log ===\n";