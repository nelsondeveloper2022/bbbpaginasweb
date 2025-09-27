<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaEnterpriseService
{
    private $siteKey;
    private $apiKey;
    private $projectId;
    private $verifyUrl;

    public function __construct()
    {
        $this->siteKey = config('app.recaptcha.site_key');
        $this->apiKey = config('app.recaptcha.api_key');
        $this->projectId = config('app.recaptcha.project_id');
        $this->verifyUrl = config('app.recaptcha.verify_url');
    }

    /**
     * Verificar el token de reCAPTCHA Enterprise
     *
     * @param string $token
     * @param string $expectedAction
     * @param float $minimumScore
     * @return array
     */
    public function verify(string $token, string $expectedAction = 'LOGIN', float $minimumScore = 0.5): array
    {
        // Modo de desarrollo - acepta cualquier token que no esté vacío
        if (empty($this->apiKey) || $this->apiKey === 'your-api-key-here') {
            Log::info('reCAPTCHA Enterprise en modo de desarrollo', [
                'token_length' => strlen($token),
                'expected_action' => $expectedAction,
                'minimum_score' => $minimumScore
            ]);
            
            // En desarrollo, solo verificamos que haya un token
            if (strlen($token) > 20) {
                return [
                    'success' => true,
                    'score' => 0.9,
                    'action' => $expectedAction,
                    'action_match' => true,
                    'score_valid' => true,
                    'token_valid' => true,
                    'development_mode' => true
                ];
            } else {
                return [
                    'success' => false,
                    'error' => 'Token inválido o vacío',
                    'score' => 0,
                    'development_mode' => true
                ];
            }
        }

        if (!$this->isConfigured()) {
            Log::warning('reCAPTCHA Enterprise no está configurado correctamente');
            return [
                'success' => false,
                'error' => 'reCAPTCHA no configurado',
                'score' => 0
            ];
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->verifyUrl . '?key=' . $this->apiKey, [
                'event' => [
                    'token' => $token,
                    'expectedAction' => $expectedAction,
                    'siteKey' => $this->siteKey,
                ]
            ]);

            if (!$response->successful()) {
                Log::error('Error en la respuesta de reCAPTCHA Enterprise', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                return [
                    'success' => false,
                    'error' => 'Error de conexión con reCAPTCHA',
                    'score' => 0
                ];
            }

            $data = $response->json();

            // Verificar si hay errores en la respuesta
            if (isset($data['error'])) {
                Log::error('Error en reCAPTCHA Enterprise', ['error' => $data['error']]);
                return [
                    'success' => false,
                    'error' => $data['error']['message'] ?? 'Error desconocido',
                    'score' => 0
                ];
            }

            // Extraer los resultados de la evaluación
            $tokenProperties = $data['tokenProperties'] ?? [];
            $riskAnalysis = $data['riskAnalysis'] ?? [];

            $isValid = $tokenProperties['valid'] ?? false;
            $action = $tokenProperties['action'] ?? '';
            $score = $riskAnalysis['score'] ?? 0;

            // Validaciones
            $actionMatch = strtoupper($action) === strtoupper($expectedAction);
            $scoreValid = $score >= $minimumScore;

            Log::info('Resultado de reCAPTCHA Enterprise', [
                'token_valid' => $isValid,
                'action' => $action,
                'expected_action' => $expectedAction,
                'action_match' => $actionMatch,
                'score' => $score,
                'minimum_score' => $minimumScore,
                'score_valid' => $scoreValid
            ]);

            return [
                'success' => $isValid && $actionMatch && $scoreValid,
                'score' => $score,
                'action' => $action,
                'action_match' => $actionMatch,
                'score_valid' => $scoreValid,
                'token_valid' => $isValid,
                'raw_response' => $data
            ];

        } catch (\Exception $e) {
            Log::error('Excepción en verificación de reCAPTCHA Enterprise', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'error' => 'Error interno en la verificación',
                'score' => 0
            ];
        }
    }

    /**
     * Verificar si reCAPTCHA está configurado correctamente
     *
     * @return bool
     */
    public function isConfigured(): bool
    {
        return !empty($this->siteKey) && 
               !empty($this->projectId);
    }

    /**
     * Obtener la clave del sitio
     *
     * @return string|null
     */
    public function getSiteKey(): ?string
    {
        return $this->siteKey;
    }

    /**
     * Crear una regla de validación personalizada para reCAPTCHA
     *
     * @param string $expectedAction
     * @param float $minimumScore
     * @return \Closure
     */
    public function validationRule(string $expectedAction = 'LOGIN', float $minimumScore = 0.5): \Closure
    {
        return function ($attribute, $value, $fail) use ($expectedAction, $minimumScore) {
            if (empty($value)) {
                $fail('La verificación de seguridad es requerida.');
                return;
            }

            $result = $this->verify($value, $expectedAction, $minimumScore);

            if (!$result['success']) {
                $error = $result['error'] ?? 'Verificación de seguridad fallida';
                $fail("Verificación de seguridad inválida: {$error}");
                return;
            }

            // Verificaciones adicionales específicas
            if (!$result['token_valid']) {
                $fail('Token de seguridad inválido.');
                return;
            }

            if (!$result['action_match']) {
                $fail('Acción de seguridad no coincide.');
                return;
            }

            if (!$result['score_valid']) {
                $fail('Puntuación de seguridad insuficiente. Intenta de nuevo.');
                return;
            }
        };
    }
}