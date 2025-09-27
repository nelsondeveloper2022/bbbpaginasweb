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
        $user = User::with(['empresa', 'landings'])->findOrFail($userId);
        
        if (!$user->empresa) {
            return back()->with('error', 'El usuario no tiene una empresa asociada.');
        }

        if (!$user->landings->count()) {
            return back()->with('error', 'El usuario no tiene landings creadas.');
        }

        // Cambiar estado de la empresa
        $user->empresa->update(['estado' => 'publicada']);

        // Enviar email de notificación al cliente
        try {
            $landing = $user->landings->first();
            $landingUrl = $this->generateLandingUrl($user->empresa);
            
            // Email al cliente
            Mail::to($user->email)->send(new LandingPublishedCustomerNotification($user, $user->empresa, $landing, $landingUrl));
            
            // Email interno a BBB (opcional)
            Mail::to(config('app.support.email'))->send(new LandingPublishedNotification($user->empresa, $landing));
            
            return back()->with('success', 'Landing publicada y email enviado al cliente exitosamente.');
        } catch (\Exception $e) {
            return back()->with('warning', 'Landing publicada pero hubo un error enviando el email: ' . $e->getMessage());
        }
    }

    /**
     * Generar URL de la landing
     */
    private function generateLandingUrl($empresa)
    {
        $baseUrl = config('app.url');
        $slug = $empresa->slug ?: 'empresa-' . $empresa->idEmpresa;
        return $baseUrl . '/landing/' . $slug;
    }
}
