<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\BbbEmpresa;
use App\Models\BbbPlan;
use App\Http\Requests\RegisterRequest;
use App\Mail\EmailVerification;

class AuthController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Procesar login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Siempre redirigir al dashboard después de login exitoso
            return redirect()->route('dashboard')
                ->with('success', '¡Bienvenido/a de vuelta, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Mostrar formulario de registro
     */
    public function showRegister(Request $request)
    {
        // Obtener todos los planes disponibles en español para mostrar en el formulario
        $planes = BbbPlan::where('idioma', 'spanish')
                         ->orderBy('orden', 'asc')
                         ->get();

        // Verificar si viene un plan específico en la URL
        $selectedPlan = null;
        if ($request->has('plan')) {
            $selectedPlan = BbbPlan::where('slug', $request->plan)
                                  ->where('idioma', 'spanish')
                                  ->first();
        }

        return view('auth.register', compact('planes', 'selectedPlan'));
    }

    /**
     * Procesar registro
     */
    public function register(RegisterRequest $request)
    {
        try {
            // Los datos ya vienen validados del RegisterRequest
            $validatedData = $request->validated();

            // Crear o buscar la empresa
            $empresa = BbbEmpresa::firstOrCreate(
                [
                    'email' => $validatedData['empresa_email']
                ],
                [
                    'nombre' => $validatedData['empresa_nombre'],
                    'direccion' => $validatedData['empresa_direccion'] ?? null,
                    'telefono' => $validatedData['movil'], // Usamos el móvil como teléfono principal
                    'activo' => true
                ]
            );

            // Crear el usuario con información adicional para BBB
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'movil' => $validatedData['movil'],
                'empresa_nombre' => $validatedData['empresa_nombre'],
                'empresa_email' => $validatedData['empresa_email'],
                'empresa_direccion' => $validatedData['empresa_direccion'] ?? null,
                'idEmpresa' => null, // Por defecto null como especificaste
                'id_plan' => $validatedData['plan_id'] ?? null,
                'trial_ends_at' => now()->addDays(15), // 15 días de prueba
                'free_trial_days' => 15,
            ]);

            // Autenticar al usuario
            Auth::login($user);

            // Enviar email de verificación automáticamente
            try {
                $token = $user->generateEmailVerificationToken();
                Mail::to($user->email)->send(new EmailVerification($user, $token));
                
                $successMessage = '¡Cuenta creada exitosamente! Bienvenido a BBB Páginas Web. Te hemos enviado un email para verificar tu cuenta. Tienes 15 días de prueba gratuita.';
            } catch (\Exception $mailError) {
                Log::error('Error enviando email de verificación durante registro: ' . $mailError->getMessage());
                $successMessage = '¡Cuenta creada exitosamente! Bienvenido a BBB Páginas Web. No olvides verificar tu email en tu perfil para poder publicar tu sitio web. Tienes 15 días de prueba gratuita.';
            }

            // Redirigir al dashboard
            return redirect()
                ->route('dashboard')
                ->with('success', $successMessage);

        } catch (\Exception $e) {
            Log::error('Error en registro de usuario: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Hubo un error al crear tu cuenta. Por favor intenta nuevamente.']);
        }
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}