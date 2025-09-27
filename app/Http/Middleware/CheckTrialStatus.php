<?php

namespace App\Http\Middleware;

use App\Models\BbbPlan;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class CheckTrialStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        if (!$user) {
            return $next($request);
        }

        // Obtener plan actual del usuario
        $plan = BbbPlan::find($user->id_plan);
        $dias = $plan->dias ?? 0;

        // Definir rutas siempre permitidas cuando hay vencimiento
        $allowedRoutesWhenExpired = [
            'dashboard',
            'admin.plans.index',
            'admin.plans.purchase',
            'admin.plans.success',
            'profile.edit',
            'profile.update',
            'profile.password.update',
            'logout'
        ];

        // Planes permanentes (one-time payment) - Plan 1 y 2
        if (in_array($user->id_plan, [1, 2]) && $dias <= 0) {
            return $next($request);
        }

        // Para todos los planes con días (incluye plan 6 - Free 15 días, y plan 5 - Arriendo)
        if ($dias > 0) {
            $expires = $user->trial_ends_at ? Carbon::parse($user->trial_ends_at) : null;
            
            // Si no tiene fecha de expiración o ya expiró
            if (!$expires || $expires->isPast()) {
                // Marcar trial como expirado en sesión
                session()->flash('trial_expired', true);
                
                // Solo permitir rutas específicas cuando está expirado
                if (in_array($request->route()->getName(), $allowedRoutesWhenExpired)) {
                    return $next($request);
                }
                
                // Redirigir a gestión de planes para renovar/comprar
                return redirect()->route('admin.plans.index')
                    ->with('error', 'Tu plan ha expirado. Adquiere un nuevo plan para continuar.');
            }
            
            // Si el plan está próximo a vencer (5 días o menos)
            if ($user->isPlanExpiringSoon()) {
                session()->flash('trial_expiring_soon', true);
            }
        }

        // Sin plan asignado - redirigir a selección de planes
        if (!$user->id_plan || $user->id_plan == 0) {
            if (in_array($request->route()->getName(), $allowedRoutesWhenExpired)) {
                session()->flash('no_plan_assigned', true);
                return $next($request);
            }
            
            return redirect()->route('admin.plans.index')
                ->with('info', 'Selecciona un plan para comenzar a usar la plataforma.');
        }

        return $next($request);
    }
}