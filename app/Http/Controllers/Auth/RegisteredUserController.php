<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BbbPlan;
use App\Services\RecaptchaEnterpriseService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $planes = BbbPlan::all();
        return view('auth.register', compact('planes'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'nombre_contacto' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'movil' => ['required', 'string', 'max:20'],
            'empresa_nombre' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'plan_seleccionado' => ['required', 'string', 'max:255'],
        ];

        // Agregar validación de reCAPTCHA Enterprise si está configurado
        $recaptchaService = app(RecaptchaEnterpriseService::class);
        if ($recaptchaService->isConfigured()) {
            $rules['recaptcha_token'] = [
                'required',
                $recaptchaService->validationRule('REGISTER', 0.5)
            ];
        }

        $messages = [
            'nombre_contacto.required' => 'El nombre de contacto es obligatorio.',
            'nombre_contacto.max' => 'El nombre de contacto no puede tener más de 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe proporcionar una dirección de correo electrónico válida.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'movil.required' => 'El número móvil es obligatorio.',
            'movil.max' => 'El número móvil no puede tener más de 20 caracteres.',
            'empresa_nombre.required' => 'El nombre de la empresa es obligatorio.',
            'empresa_nombre.max' => 'El nombre de la empresa no puede tener más de 255 caracteres.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'plan_seleccionado.required' => 'Debe seleccionar un plan.',
            'recaptcha_token.required' => 'La verificación de seguridad es obligatoria.',
        ];

        $request->validate($rules, $messages);

        // Calcular fecha de fin del periodo de prueba (15 días)
        $trialDays = 15;
        $trialEndsAt = now()->addDays($trialDays);

        $user = User::create([
            'name' => $request->nombre_contacto,
            'nombre_contacto' => $request->nombre_contacto,
            'email' => $request->email,
            'movil' => $request->movil,
            'empresa_nombre' => $request->empresa_nombre,
            'plan_seleccionado' => $request->plan_seleccionado,
            'password' => Hash::make($request->password),
            'free_trial_days' => $trialDays,
            'trial_ends_at' => $trialEndsAt,
            'idEmpresa' => null, // Por defecto null hasta que se configure
            'id_plan' => null, // Por defecto null durante el período de prueba
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false))->with('success', 'Registro exitoso. Tienes 15 días de prueba gratuita.');
    }
}
