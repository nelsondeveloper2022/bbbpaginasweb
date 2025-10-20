<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BbbEmpresa;
use App\Models\BbbPlan;
use App\Models\BbbLanding;
use App\Mail\LandingPublishedNotification;
use App\Mail\LandingPublishedCustomerNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    /**
     * Mostrar formulario de login de administrador
     */
    public function showLogin()
    {
        return view('admin.login');
    }

    /**
     * Procesar login de administrador
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if ($user->isAdmin()) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Acceso denegado. Solo administradores.',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    /**
     * Cerrar sesión de administrador
     */
    public function logout(Request $request)
    {
        // Si estamos impersonando, limpiar la sesión de impersonación
        if (session()->has('impersonating_admin_id')) {
            session()->forget('impersonating_admin_id');
        }
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }

    /**
     * Mostrar dashboard de administrador
     */
    public function dashboard()
    {
        $totalUsers = User::regularUsers()->count();
        $totalAdmins = User::admins()->count();
        $activeSubscriptions = User::regularUsers()
            ->whereNotNull('subscription_ends_at')
            ->where('subscription_ends_at', '>', now())
            ->count();
        $activTrials = User::regularUsers()
            ->whereNotNull('trial_ends_at')
            ->where('trial_ends_at', '>', now())
            ->count();

        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalAdmins', 
            'activeSubscriptions', 
            'activTrials'
        ));
    }

    /**
     * Listado de todos los usuarios
     */
    public function users(Request $request)
    {
        $query = User::with(['empresa', 'plan'])
                    ->withCount(['landings'])
                    ->with(['landings' => function($q) {
                        $q->latest()->limit(1);
                    }]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('empresa_nombre', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            switch ($request->status) {
                case 'admin':
                    $query->where('is_admin', true);
                    break;
                case 'active':
                    $query->where('is_admin', false)
                          ->where(function($q) {
                              $q->where('subscription_ends_at', '>', now())
                                ->orWhere('trial_ends_at', '>', now());
                          });
                    break;
                case 'expired':
                    $query->where('is_admin', false)
                          ->where(function($q) {
                              $q->where('subscription_ends_at', '<=', now())
                                ->orWhere('trial_ends_at', '<=', now())
                                ->orWhere(function($subQ) {
                                    $subQ->whereNull('subscription_ends_at')
                                         ->whereNull('trial_ends_at');
                                });
                          });
                    break;
                case 'with_landing':
                    $query->has('landings');
                    break;
                case 'without_landing':
                    $query->doesntHave('landings');
                    break;
                case 'construction':
                    $query->whereHas('empresa', function($q) {
                        $q->where('estado', 'en_construccion');
                    });
                    break;
                case 'published':
                    $query->whereHas('empresa', function($q) {
                        $q->where('estado', 'publicada');
                    });
                    break;
                case 'not_configured':
                    $query->whereHas('empresa', function($q) {
                        $q->where(function($subQ) {
                            $subQ->where('estado', 'sin_configurar')
                                 ->orWhereNull('estado');
                        });
                    });
                    break;
            }
        }

        $users = $query->orderBy('created_at', 'desc')
                      ->paginate(20)
                      ->withQueryString();

        return view('admin.users', compact('users'));
    }

    /**
     * Mostrar detalles de un usuario
     */
    public function userDetail($id)
    {
        $user = User::with(['empresa', 'plan', 'landings.media', 'renovaciones'])
                   ->withCount(['landings'])
                   ->findOrFail($id);
        return view('admin.user-detail', compact('user'));
    }

    /**
     * Listado de administradores
     */
    public function admins()
    {
        $admins = User::admins()
                     ->orderBy('created_at', 'desc')
                     ->paginate(20);

        return view('admin.admins', compact('admins'));
    }

    /**
     * Mostrar formulario para crear administrador
     */
    public function createAdmin()
    {
        return view('admin.create-admin');
    }

    /**
     * Crear nuevo administrador
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => true,
            'emailValidado' => true,
        ]);

        return redirect()->route('admin.admins')->with('success', 'Administrador creado exitosamente.');
    }

    /**
     * Eliminar administrador
     */
    public function deleteAdmin($id)
    {
        $admin = User::admins()->findOrFail($id);
        
        // Prevenir eliminación del último administrador
        if (User::admins()->count() <= 1) {
            return back()->with('error', 'No se puede eliminar el último administrador.');
        }

        $admin->delete();
        return back()->with('success', 'Administrador eliminado exitosamente.');
    }

    /**
     * Cambiar estado de empresa a publicada y enviar email
     */
    public function publishLanding($userId)
    {
        $user = User::with(['empresa', 'landings', 'plan'])->findOrFail($userId);
        
        if (!$user->empresa) {
            return back()->with('error', 'El usuario no tiene una empresa asociada.');
        }

        if (!$user->landings->count()) {
            return back()->with('error', 'El usuario no tiene landings creadas.');
        }

        // Cambiar estado de la empresa
        $user->empresa->update(['estado' => 'publicada']);

        // Reiniciar el trial del usuario basado en su plan
        if ($user->plan && $user->plan->dias > 0) {
            $trialDays = $user->free_trial_days ?: $user->plan->dias;
            $newTrialEnd = now()->addDays($trialDays);
            
            $user->update([
                'trial_ends_at' => $newTrialEnd,
                'free_trial_days' => $trialDays
            ]);
            
            Log::info('Trial reiniciado al publicar landing', [
                'user_id' => $user->id,
                'plan_id' => $user->plan->idPlan,
                'trial_days' => $trialDays,
                'new_trial_end' => $newTrialEnd->toDateTimeString()
            ]);
        }

        // Enviar email de notificación al cliente
        try {
            $landing = $user->landings->first();
            $landingUrl = $this->generateLandingUrl($user->empresa);
            
            // Email al cliente
            Mail::to($user->email)->send(new LandingPublishedCustomerNotification($user, $user->empresa, $landing, $landingUrl));
            
            // Email interno a BBB (opcional)
            Mail::to(config('app.support.email'))->send(new LandingPublishedNotification($user->empresa, $landing));
            
            return back()->with('success', 'Landing publicada, trial reiniciado y email enviado al cliente exitosamente.');
        } catch (\Exception $e) {
            return back()->with('warning', 'Landing publicada y trial reiniciado pero hubo un error enviando el email: ' . $e->getMessage());
        }
    }

    /**
     * Generar token de impersonación y redirigir al dashboard del cliente
     */
    public function impersonate($id)
    {
        $user = User::findOrFail($id);
        $currentAdmin = User::where('email' , 'nelson@bbbpaginasweb.com')->first();
        
        // Verificar que el usuario actual (quien impersona) sea admin
        if (!$currentAdmin->isAdmin()) {
            return redirect()->route('admin.login')->with('error', 'Acceso denegado. Solo administradores pueden impersonar.');
        }
        
        // Verificar que el usuario objetivo se pueda impersonar
        if (!$user->canBeImpersonated()) {
            Log::warning('Cannot impersonate user', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'is_admin' => $user->isAdmin(),
                'idEmpresa' => $user->idEmpresa,
                'empresa_email' => $user->empresa_email,
                'empresa_nombre' => $user->empresa_nombre
            ]);
            
            if ($user->isAdmin()) {
                return back()->with('error', 'No se puede impersonar a otro administrador.');
            } else {
                return back()->with('error', 'Este usuario no tiene una empresa asociada y no se puede impersonar.');
            }
        }
        
        // Generar un token único para la impersonación
        $impersonationToken = Str::random(60) . '_' . time();
        
        // Guardar el token en caché por 1 hora
        Cache::put('impersonation_' . $impersonationToken, [
            'admin_id' => $currentAdmin->id,
            'admin_name' => $currentAdmin->name,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'started_at' => now()->toDateTimeString()
        ], 3600); // 1 hora
        
        // Generar la URL con el token
        $impersonationUrl = url('/admin/impersonate-login/' . $impersonationToken);

        // Para debug: redirigir directamente al token
        return redirect($impersonationUrl);
    }
    
    /**
     * Procesar login de impersonación usando el token
     */
    public function impersonateLogin($token)
    {
        Log::info('ImpersonateLogin method called', ['token' => $token]);
        
        // Verificar el token
        $impersonationData = Cache::get('impersonation_' . $token);
        
        Log::info('Token data retrieved', ['data' => $impersonationData]);
        
        if (!$impersonationData) {
            return redirect()->route('admin.login')->with('error', 'Token de impersonación inválido o expirado.');
        }
        
        // Verificar que el admin todavía existe y es válido
        $admin = User::find($impersonationData['admin_id']);
        if (!$admin || !$admin->isAdmin()) {
            Cache::forget('impersonation_' . $token);
            return redirect()->route('admin.login')->with('error', 'Administrador inválido.');
        }
        
        // Verificar que el usuario objetivo todavía existe
        $user = User::find($impersonationData['user_id']);
        if (!$user || $user->isAdmin()) {
            Cache::forget('impersonation_' . $token);
            return redirect()->route('admin.login')->with('error', 'Usuario objetivo inválido.');
        }
        
        // Guardar información de impersonación en la nueva sesión
        session([
            'impersonating_admin_id' => $impersonationData['admin_id'],
            'impersonating_admin_name' => $impersonationData['admin_name'],
            'impersonation_started_at' => $impersonationData['started_at'],
            'impersonating_user_name' => $impersonationData['user_name'],
            'impersonation_token' => $token
        ]);
        
        // Si el usuario no tiene idEmpresa pero tiene empresa asociada, asignarla temporalmente
        if (!$user->idEmpresa && !empty($user->empresa_nombre)) {
            $empresa = \App\Models\BbbEmpresa::where('nombre', $user->empresa_nombre)->first();
            if ($empresa) {
                // Guardar el idEmpresa original para restaurarlo después
                session(['original_idEmpresa' => $user->idEmpresa]);
                
                // Asignar temporalmente el idEmpresa para esta sesión
                $user->idEmpresa = $empresa->idEmpresa;
                $user->save();
                
                // Marcar que se hizo una asignación temporal
                session(['temp_empresa_assigned' => true]);
                
                Log::info('Temporary empresa assigned for impersonation', [
                    'user_id' => $user->id,
                    'empresa_id' => $empresa->idEmpresa,
                    'empresa_nombre' => $empresa->nombre
                ]);
            }
        }

        // Autenticar como el usuario objetivo en ESTA sesión únicamente
        Auth::login($user, true);
        
        // Consumir el token para que no se pueda reutilizar
        Cache::forget('impersonation_' . $token);
        
        // Debug: verificar que el usuario está autenticado correctamente
        Log::info('Impersonation successful', [
            'admin_id' => $impersonationData['admin_id'],
            'user_id' => $user->id,
            'auth_user_id' => Auth::id(),
            'auth_user_name' => Auth::user()->name ?? 'N/A'
        ]);

        // Redirigir al dashboard del cliente
        return redirect()->route('dashboard')->with('success', 
            'Estás viendo el dashboard como ' . $user->name . '. Esta ventana es independiente de tu sesión de administrador.'
        );
    }
    
    /**
     * Dejar de impersonar (cerrar sesión del cliente)
     */
    public function stopImpersonating()
    {
        $adminId = session('impersonating_admin_id');
        $impersonatingUserName = session('impersonating_user_name', 'usuario');
        $token = session('impersonation_token');
        
        if (!$adminId) {
            return redirect()->route('admin.login')->with('error', 'No estás impersonando a ningún usuario.');
        }
        
        // Si se asignó una empresa temporalmente, restaurar el estado original
        if (session('temp_empresa_assigned')) {
            $currentUser = Auth::user();
            if ($currentUser) {
                $originalIdEmpresa = session('original_idEmpresa');
                $currentUser->idEmpresa = $originalIdEmpresa;
                $currentUser->save();
                
                Log::info('Restored original idEmpresa after impersonation', [
                    'user_id' => $currentUser->id,
                    'restored_idEmpresa' => $originalIdEmpresa
                ]);
            }
        }
        
        // Limpiar cualquier token residual del caché
        if ($token) {
            Cache::forget('impersonation_' . $token);
        }
        
        // Limpiar la sesión de impersonación
        session()->forget([
            'impersonating_admin_id', 
            'impersonating_admin_name', 
            'impersonation_started_at', 
            'impersonating_user_name',
            'impersonation_token',
            'temp_empresa_assigned',
            'original_idEmpresa'
        ]);
        
        // Cerrar sesión del usuario impersonado
        Auth::logout();
        
        // Mostrar página de confirmación que se puede cerrar
        return view('admin.impersonation-ended', [
            'userName' => $impersonatingUserName,
            'adminDashboardUrl' => route('admin.dashboard')
        ]);
    }

    /**
     * Limpiar tokens de impersonación expirados (método de mantenimiento)
     */
    public function cleanExpiredImpersonations()
    {
        // Este método puede ser llamado por un cron job para limpiar tokens expirados
        // Por ahora, el caché se encarga automáticamente con el TTL de 1 hora
        
        return response()->json(['message' => 'Limpieza completada']);
    }

    /**
     * Generar URL de la landing
     */
    private function generateLandingUrl($empresa)
    {
        $baseUrl = config('app.url');
        $slug = $empresa->slug ?: 'empresa-' . $empresa->idEmpresa;
        return $baseUrl . '/' . $slug;
    }
}
