<?php

namespace App\Http\Controllers;

use App\Services\RecaptchaEnterpriseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestRecaptchaController extends Controller
{
    public function show()
    {
        return view('test-recaptcha');
    }

    public function store(Request $request)
    {
        $rules = [
            'test_input' => ['required', 'string', 'max:255'],
        ];

        // Agregar validación de reCAPTCHA Enterprise si está configurado
        $recaptchaService = app(RecaptchaEnterpriseService::class);
        if ($recaptchaService->isConfigured()) {
            $rules['recaptcha_token'] = [
                'required',
                $recaptchaService->validationRule('TEST', 0.3) // Score más bajo para prueba
            ];
        }

        $messages = [
            'test_input.required' => 'El campo de prueba es obligatorio.',
            'test_input.max' => 'El campo de prueba no puede tener más de 255 caracteres.',
            'recaptcha_token.required' => 'La verificación de seguridad es obligatoria.',
        ];

        $request->validate($rules, $messages);

        // Log para depuración
        Log::info('Prueba de reCAPTCHA completada exitosamente', [
            'test_input' => $request->test_input,
            'recaptcha_configured' => $recaptchaService->isConfigured(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return back()->with('success', '¡Verificación exitosa! reCAPTCHA Enterprise está funcionando correctamente.');
    }
}