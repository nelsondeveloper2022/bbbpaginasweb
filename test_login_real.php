<?php

/**
 * Script para probar login de forma real
 * Ejecutar con: php test_login_real.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Crear un request de login
$request = Illuminate\Http\Request::create(
    '/login',
    'POST',
    [
        'email' => 'nelsonmon1699@gmail.com',
        'password' => 'BBB2025temp!',
        '_token' => 'test-token' // El middleware CSRF está deshabilitado en tests
    ]
);

// Agregar headers
$request->headers->set('Accept', 'text/html,application/xhtml+xml');
$request->headers->set('Content-Type', 'application/x-www-form-urlencoded');

echo "=== PROBANDO LOGIN REAL ===" . PHP_EOL;
echo "Email: nelsonmon1699@gmail.com" . PHP_EOL;
echo "Password: BBB2025temp!" . PHP_EOL;
echo PHP_EOL;

try {
    // Iniciar sesión para obtener CSRF token válido
    $session = $app->make('session')->driver();
    $session->start();
    $request->setLaravelSession($session);
    
    // Generar token CSRF válido
    $token = $session->token();
    $request->merge(['_token' => $token]);
    
    echo "CSRF Token: $token" . PHP_EOL;
    echo PHP_EOL;
    
    // Ejecutar el request
    $response = $kernel->handle($request);
    
    echo "Status Code: " . $response->getStatusCode() . PHP_EOL;
    echo PHP_EOL;
    
    // Ver si hay errores de validación
    if ($response->getStatusCode() === 302) {
        echo "✅ REDIRECCIÓN (Login exitoso o error)" . PHP_EOL;
        echo "Location: " . $response->headers->get('Location') . PHP_EOL;
    } elseif ($response->getStatusCode() === 422) {
        echo "❌ ERROR DE VALIDACIÓN" . PHP_EOL;
        echo $response->getContent() . PHP_EOL;
    } else {
        echo "Response Content (primeros 500 chars):" . PHP_EOL;
        echo substr($response->getContent(), 0, 500) . PHP_EOL;
    }
    
    // Verificar sesión
    echo PHP_EOL;
    echo "=== VERIFICANDO SESIÓN ===" . PHP_EOL;
    if (Auth::check()) {
        echo "✅ Usuario autenticado: " . Auth::user()->email . PHP_EOL;
    } else {
        echo "❌ Usuario NO autenticado" . PHP_EOL;
    }
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . PHP_EOL;
    echo "File: " . $e->getFile() . ":" . $e->getLine() . PHP_EOL;
    echo PHP_EOL;
    echo "Stack trace:" . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
}

$kernel->terminate($request, $response ?? null);
