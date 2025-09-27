<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaService
{
    protected $secretKey;
    protected $verifyUrl;

    public function __construct()
    {
        $this->secretKey = config('app.recaptcha.secret_key');
        $this->verifyUrl = config('app.recaptcha.verify_url');
    }

    /**
     * Verificar el token de reCAPTCHA
     *
     * @param string $token
     * @param string $userIp
     * @return array
     */
    public function verify(string $token, string $userIp = null): array
    {
        if (empty($this->secretKey)) {
            Log::warning('reCAPTCHA secret key not configured');
            return [
                'success' => false,
                'error' => 'reCAPTCHA not configured',
                'error_codes' => ['missing-secret-key']
            ];
        }

        if (empty($token)) {
            return [
                'success' => false,
                'error' => 'reCAPTCHA token is required',
                'error_codes' => ['missing-input-response']
            ];
        }

        try {
            $response = Http::asForm()->post($this->verifyUrl, [
                'secret' => $this->secretKey,
                'response' => $token,
                'remoteip' => $userIp,
            ]);

            if (!$response->successful()) {
                Log::error('reCAPTCHA API request failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return [
                    'success' => false,
                    'error' => 'reCAPTCHA verification failed',
                    'error_codes' => ['api-request-failed']
                ];
            }

            $result = $response->json();
            
            // Log del resultado para debugging
            Log::info('reCAPTCHA verification result', [
                'success' => $result['success'] ?? false,
                'error_codes' => $result['error-codes'] ?? [],
                'score' => $result['score'] ?? null,
                'action' => $result['action'] ?? null,
                'user_ip' => $userIp
            ]);

            return [
                'success' => $result['success'] ?? false,
                'error_codes' => $result['error-codes'] ?? [],
                'score' => $result['score'] ?? null,
                'action' => $result['action'] ?? null,
                'challenge_ts' => $result['challenge_ts'] ?? null,
                'hostname' => $result['hostname'] ?? null,
            ];

        } catch (\Exception $e) {
            Log::error('reCAPTCHA verification exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'error' => 'reCAPTCHA verification error: ' . $e->getMessage(),
                'error_codes' => ['exception']
            ];
        }
    }

    /**
     * Validar el token y lanzar excepción si falla
     *
     * @param string $token
     * @param string $userIp
     * @return bool
     * @throws \Exception
     */
    public function validateOrFail(string $token, string $userIp = null): bool
    {
        $result = $this->verify($token, $userIp);

        if (!$result['success']) {
            $errorMessage = $this->getHumanReadableError($result['error_codes'] ?? []);
            throw new \Exception($errorMessage);
        }

        return true;
    }

    /**
     * Obtener mensaje de error legible para el usuario
     *
     * @param array $errorCodes
     * @return string
     */
    protected function getHumanReadableError(array $errorCodes): string
    {
        if (empty($errorCodes)) {
            return 'Error de verificación reCAPTCHA';
        }

        $messages = [
            'missing-input-secret' => 'Error de configuración del servidor',
            'invalid-input-secret' => 'Error de configuración del servidor',  
            'missing-input-response' => 'Por favor complete la verificación reCAPTCHA',
            'invalid-input-response' => 'Verificación reCAPTCHA inválida, por favor inténtelo de nuevo',
            'bad-request' => 'Error en la solicitud de verificación',
            'timeout-or-duplicate' => 'La verificación reCAPTCHA ha expirado, por favor inténtelo de nuevo',
            'missing-secret-key' => 'Error de configuración del servidor',
            'api-request-failed' => 'Error de conexión con el servicio de verificación',
            'exception' => 'Error interno del servidor'
        ];

        // Retornar el primer mensaje encontrado
        foreach ($errorCodes as $code) {
            if (isset($messages[$code])) {
                return $messages[$code];
            }
        }

        return 'Error de verificación reCAPTCHA: ' . implode(', ', $errorCodes);
    }

    /**
     * Obtener la clave del sitio para uso en frontend
     *
     * @return string
     */
    public function getSiteKey(): string
    {
        return config('app.recaptcha.site_key', '');
    }

    /**
     * Verificar si reCAPTCHA está configurado
     *
     * @return bool
     */
    public function isConfigured(): bool
    {
        return !empty($this->secretKey) && !empty($this->getSiteKey());
    }
}
