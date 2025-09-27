<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\RecaptchaService;
use Illuminate\Support\Facades\Log;

class RecaptchaMiddleware
{
    protected $recaptchaService;

    public function __construct(RecaptchaService $recaptchaService)
    {
        $this->recaptchaService = $recaptchaService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Solo validar en requests POST (formularios)
        if (!$request->isMethod('POST')) {
            return $next($request);
        }

        // Verificar si reCAPTCHA está configurado
        if (!$this->recaptchaService->isConfigured()) {
            Log::warning('reCAPTCHA middleware called but service not configured');
            return $next($request);
        }

        // Obtener el token de reCAPTCHA
        $recaptchaToken = $request->input('g-recaptcha-response');

        if (empty($recaptchaToken)) {
            return $this->failedValidation($request, 'Por favor complete la verificación reCAPTCHA');
        }

        // Verificar el token
        $verification = $this->recaptchaService->verify($recaptchaToken, $request->ip());

        if (!$verification['success']) {
            $errorMessage = $this->getErrorMessage($verification['error_codes'] ?? []);
            
            Log::warning('reCAPTCHA validation failed', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->url(),
                'error_codes' => $verification['error_codes'] ?? [],
            ]);

            return $this->failedValidation($request, $errorMessage);
        }

        // Log successful verification
        Log::info('reCAPTCHA validation successful', [
            'ip' => $request->ip(),
            'url' => $request->url(),
            'score' => $verification['score'] ?? null,
        ]);

        return $next($request);
    }

    /**
     * Handle failed validation
     */
    protected function failedValidation(Request $request, string $message): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message,
                'errors' => [
                    'recaptcha' => [$message]
                ]
            ], 422);
        }

        return redirect()->back()
            ->withErrors(['recaptcha' => $message])
            ->withInput($request->except('g-recaptcha-response'));
    }

    /**
     * Get human readable error message
     */
    protected function getErrorMessage(array $errorCodes): string
    {
        if (empty($errorCodes)) {
            return 'Error de verificación reCAPTCHA';
        }

        $messages = [
            'missing-input-response' => 'Por favor complete la verificación reCAPTCHA',
            'invalid-input-response' => 'Verificación reCAPTCHA inválida, por favor inténtelo de nuevo',
            'timeout-or-duplicate' => 'La verificación reCAPTCHA ha expirado, por favor inténtelo de nuevo',
        ];

        foreach ($errorCodes as $code) {
            if (isset($messages[$code])) {
                return $messages[$code];
            }
        }

        return 'Error de verificación de seguridad, por favor inténtelo de nuevo';
    }
}
