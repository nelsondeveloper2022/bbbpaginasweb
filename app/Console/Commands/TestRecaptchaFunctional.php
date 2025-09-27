<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Http\Middleware\RecaptchaMiddleware;
use App\Services\RecaptchaService;
use Illuminate\Support\Facades\Http;

class TestRecaptchaFunctional extends Command
{
    protected $signature = 'bbb:test-recaptcha-functional';
    protected $description = 'Realizar pruebas funcionales del sistema reCAPTCHA';

    public function handle()
    {
        $this->info('🧪 PRUEBAS FUNCIONALES RECAPTCHA - BBB PÁGINAS WEB');
        $this->line('====================================================');

        // Test 1: Configuración del servicio
        $this->testServiceConfiguration();
        
        // Test 2: Validación de token inválido
        $this->testInvalidToken();
        
        // Test 3: Validación sin token
        $this->testMissingToken();
        
        // Test 4: Conectividad con Google
        $this->testGoogleConnectivity();

        $this->line('====================================================');
        $this->info('✅ Pruebas funcionales completadas');
        
        return 0;
    }

    private function testServiceConfiguration()
    {
        $this->line('');
        $this->info('1. 🔧 TEST CONFIGURACIÓN DEL SERVICIO');
        $this->line('--------------------------------------');

        try {
            $service = app(RecaptchaService::class);
            
            if ($service->isConfigured()) {
                $this->info('✅ Servicio correctamente configurado');
                
                $siteKey = $service->getSiteKey();
                if (!empty($siteKey)) {
                    $this->info('✅ Site key disponible: ' . substr($siteKey, 0, 20) . '...');
                } else {
                    $this->error('❌ Site key no disponible');
                }
            } else {
                $this->error('❌ Servicio NO configurado');
            }
        } catch (\Exception $e) {
            $this->error('❌ Error en configuración: ' . $e->getMessage());
        }
    }

    private function testInvalidToken()
    {
        $this->line('');
        $this->info('2. 🚫 TEST TOKEN INVÁLIDO');
        $this->line('-------------------------');

        try {
            $service = app(RecaptchaService::class);
            $result = $service->verify('invalid_token_test', '127.0.0.1');
            
            if (!$result['success']) {
                $this->info('✅ Token inválido correctamente rechazado');
                $this->info('   Mensaje: ' . ($result['error'] ?? 'Token inválido'));
            } else {
                $this->error('❌ Token inválido fue ACEPTADO (problema de seguridad)');
            }
        } catch (\Exception $e) {
            $this->error('❌ Error en test: ' . $e->getMessage());
        }
    }

    private function testMissingToken()
    {
        $this->line('');
        $this->info('3. 🚫 TEST TOKEN FALTANTE');
        $this->line('-------------------------');

        try {
            $service = app(RecaptchaService::class);
            $result = $service->verify('', '127.0.0.1');
            
            if (!$result['success']) {
                $this->info('✅ Token faltante correctamente rechazado');
                $this->info('   Mensaje: ' . ($result['error'] ?? 'Token requerido'));
            } else {
                $this->error('❌ Token faltante fue ACEPTADO (problema de seguridad)');
            }
        } catch (\Exception $e) {
            $this->error('❌ Error en test: ' . $e->getMessage());
        }
    }

    private function testGoogleConnectivity()
    {
        $this->line('');
        $this->info('4. 🌐 TEST CONECTIVIDAD CON GOOGLE');
        $this->line('----------------------------------');

        try {
            $verifyUrl = config('app.recaptcha.verify_url');
            
            // Test básico de conectividad
            $response = Http::timeout(10)->get($verifyUrl);
            
            if ($response->successful() || $response->status() === 405) {
                // 405 Method Not Allowed es normal para GET en la API de reCAPTCHA
                $this->info('✅ Conectividad con Google reCAPTCHA exitosa');
                $this->info('   URL: ' . $verifyUrl);
                $this->info('   Status: ' . $response->status());
            } else {
                $this->warn("⚠️ Respuesta inesperada de Google: " . $response->status());
            }
        } catch (\Exception $e) {
            $this->error('❌ Error de conectividad: ' . $e->getMessage());
            $this->warn('   Verificar conexión a internet y firewall');
        }
    }
}
