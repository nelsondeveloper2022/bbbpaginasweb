<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RecaptchaService;
use Illuminate\Support\Facades\File;

class VerifyRecaptchaCommand extends Command
{
    protected $signature = 'bbb:verify-recaptcha';
    protected $description = 'Verificar la implementación completa de reCAPTCHA en el sistema';

    public function handle()
    {
        $this->info('🔍 VERIFICACIÓN COMPLETA DE RECAPTCHA - BBB PÁGINAS WEB');
        $this->line('========================================================');

        // 1. Verificar configuración
        $this->checkConfiguration();
        
        // 2. Verificar servicio
        $this->checkService();
        
        // 3. Verificar middleware
        $this->checkMiddleware();
        
        // 4. Verificar componente Blade
        $this->checkBladeComponent();
        
        // 5. Verificar formularios
        $this->checkForms();
        
        // 6. Verificar rutas
        $this->checkRoutes();

        $this->line('========================================================');
        $this->info('✅ Verificación completa finalizada');
        
        return 0;
    }

    private function checkConfiguration()
    {
        $this->line('');
        $this->info('1. 🔧 CONFIGURACIÓN');
        $this->line('-------------------');

        $config = config('app.recaptcha');
        
        if (empty($config['site_key'])) {
            $this->error('❌ RECAPTCHA_SITE_KEY no configurada');
        } else {
            $this->info('✅ RECAPTCHA_SITE_KEY: ' . substr($config['site_key'], 0, 20) . '...');
        }

        if (empty($config['secret_key'])) {
            $this->error('❌ RECAPTCHA_SECRET_KEY no configurada');
        } else {
            $this->info('✅ RECAPTCHA_SECRET_KEY: ' . substr($config['secret_key'], 0, 20) . '...');
        }

        $this->info('✅ VERIFY_URL: ' . $config['verify_url']);
    }

    private function checkService()
    {
        $this->line('');
        $this->info('2. 🚗 SERVICIO RECAPTCHA');
        $this->line('------------------------');

        $servicePath = app_path('Services/RecaptchaService.php');
        
        if (File::exists($servicePath)) {
            $this->info('✅ RecaptchaService existe');
            
            $service = app(RecaptchaService::class);
            
            if ($service->isConfigured()) {
                $this->info('✅ RecaptchaService configurado correctamente');
            } else {
                $this->error('❌ RecaptchaService NO configurado');
            }
        } else {
            $this->error('❌ RecaptchaService NO existe');
        }
    }

    private function checkMiddleware()
    {
        $this->line('');
        $this->info('3. 🛡️ MIDDLEWARE');
        $this->line('----------------');

        $middlewarePath = app_path('Http/Middleware/RecaptchaMiddleware.php');
        
        if (File::exists($middlewarePath)) {
            $this->info('✅ RecaptchaMiddleware existe');
            
            // Verificar si está registrado en bootstrap/app.php
            $bootstrapPath = base_path('bootstrap/app.php');
            $bootstrapContent = File::get($bootstrapPath);
            
            if (str_contains($bootstrapContent, 'RecaptchaMiddleware')) {
                $this->info('✅ RecaptchaMiddleware registrado en bootstrap/app.php');
            } else {
                $this->error('❌ RecaptchaMiddleware NO registrado en bootstrap/app.php');
            }
        } else {
            $this->error('❌ RecaptchaMiddleware NO existe');
        }
    }

    private function checkBladeComponent()
    {
        $this->line('');
        $this->info('4. 🎨 COMPONENTE BLADE');
        $this->line('----------------------');

        $componentPath = resource_path('views/components/recaptcha.blade.php');
        
        if (File::exists($componentPath)) {
            $this->info('✅ Componente recaptcha.blade.php existe');
            
            $content = File::get($componentPath);
            if (str_contains($content, 'g-recaptcha')) {
                $this->info('✅ Componente contiene elementos reCAPTCHA');
            } else {
                $this->error('❌ Componente NO contiene elementos reCAPTCHA válidos');
            }
        } else {
            $this->error('❌ Componente recaptcha.blade.php NO existe');
        }
    }

    private function checkForms()
    {
        $this->line('');
        $this->info('5. 📝 FORMULARIOS');
        $this->line('-----------------');

        $forms = [
            'Login' => resource_path('views/auth/login.blade.php'),
            'Registro' => resource_path('views/auth/register.blade.php'),
            'Contacto' => resource_path('views/components/contact-form.blade.php'),
            'Recuperar Contraseña' => resource_path('views/auth/forgot-password.blade.php'),
            'Reset Contraseña' => resource_path('views/auth/reset-password.blade.php'),
        ];

        foreach ($forms as $name => $path) {
            if (File::exists($path)) {
                $content = File::get($path);
                $hasRecaptcha = str_contains($content, 'x-recaptcha') || str_contains($content, '<x-recaptcha');
                
                if ($hasRecaptcha) {
                    if (in_array($name, ['Login', 'Registro'])) {
                        $this->info("✅ $name: reCAPTCHA implementado (CORRECTO)");
                    } else {
                        $this->warn("⚠️ $name: reCAPTCHA implementado (NO DEBERÍA)");
                    }
                } else {
                    if (in_array($name, ['Login', 'Registro'])) {
                        $this->error("❌ $name: reCAPTCHA NO implementado (DEBERÍA TENERLO)");
                    } else {
                        $this->info("✅ $name: reCAPTCHA NO implementado (CORRECTO)");
                    }
                }
            } else {
                $this->warn("⚠️ $name: Archivo no encontrado");
            }
        }
    }

    private function checkRoutes()
    {
        $this->line('');
        $this->info('6. 🛣️ RUTAS CON MIDDLEWARE');
        $this->line('-------------------------');

        $routeFiles = [
            'web.php' => base_path('routes/web.php'),
            'auth.php' => base_path('routes/auth.php'),
        ];

        $foundRecaptchaRoutes = false;

        foreach ($routeFiles as $name => $path) {
            if (File::exists($path)) {
                $content = File::get($path);
                if (str_contains($content, 'recaptcha')) {
                    $this->info("✅ $name: Contiene middleware reCAPTCHA");
                    $foundRecaptchaRoutes = true;
                } else {
                    $this->warn("⚠️ $name: NO contiene middleware reCAPTCHA");
                }
            }
        }

        if (!$foundRecaptchaRoutes) {
            $this->error('❌ NO se encontraron rutas con middleware reCAPTCHA configurado');
        }
    }
}
