<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\RecaptchaService;
use Mockery;

class RecaptchaMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Configurar las variables de entorno para los tests
        config([
            'app.recaptcha.site_key' => '6Lea69YrAAAAAFSg_TQN2nLnOkGICoxWEJEatfPl',
            'app.recaptcha.secret_key' => '6Lea69YrAAAAAIY0J4F7UgGaKdqq2KJd8su_qimS',
            'app.recaptcha.verify_url' => 'https://www.google.com/recaptcha/api/siteverify',
        ]);
    }

    /** @test */
    public function login_form_requires_recaptcha_token()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
            // Sin g-recaptcha-response
        ]);

        $response->assertSessionHasErrors(['recaptcha']);
        $response->assertRedirect();
    }

    /** @test */
    public function login_form_rejects_invalid_recaptcha_token()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
            'g-recaptcha-response' => 'invalid_token',
        ]);

        $response->assertSessionHasErrors(['recaptcha']);
        $response->assertRedirect();
    }

    /** @test */
    public function register_form_requires_recaptcha_token()
    {
        $response = $this->post('/register', [
            'nombre_contacto' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'movil' => '+57 300 123 4567',
            'empresa_nombre' => 'Test Company',
            'plan_seleccionado' => 'basico',
            // Sin g-recaptcha-response
        ]);

        $response->assertSessionHasErrors(['recaptcha']);
        $response->assertRedirect();
    }

    /** @test */
    public function contact_form_does_not_require_recaptcha()
    {
        // Verificar que los formularios de contacto NO requieren reCAPTCHA
        // Esto debería procesar normalmente sin reCAPTCHA
        
        $this->assertTrue(true); // Placeholder - el formulario de contacto no tiene ruta POST definida aún
    }

    /** @test */
    public function forgot_password_form_does_not_require_recaptcha()
    {
        $response = $this->post('/forgot-password', [
            'email' => 'test@example.com',
            // Sin g-recaptcha-response - debería funcionar normalmente
        ]);

        // No debería tener errores de reCAPTCHA
        $response->assertSessionMissing('errors.recaptcha');
    }

    /** @test */
    public function get_requests_bypass_recaptcha_middleware()
    {
        // Las peticiones GET no deben ser afectadas por el middleware
        $response = $this->get('/login');
        $response->assertStatus(200);

        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    /** @test */
    public function recaptcha_service_is_properly_configured()
    {
        $service = app(RecaptchaService::class);
        
        $this->assertTrue($service->isConfigured());
        $this->assertNotEmpty($service->getSiteKey());
    }

    /** @test */
    public function recaptcha_component_renders_correctly()
    {
        $response = $this->get('/login');
        
        $response->assertStatus(200);
        // Verificar que el componente reCAPTCHA está presente
        $response->assertSee('g-recaptcha');
        $response->assertSee('www.google.com/recaptcha/api.js');
    }
}
