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

        // Si es un admin impersonando, permitir acceso sin restricciones
        if (session()->has('impersonating_admin_id')) {
            return $next($request);
        }

        // Si es un administrador, permitir acceso sin restricciones
        if ($user->isAdmin()) {
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
            'admin.profile.edit',
            'admin.profile.update',
            'admin.profile.password.update',
            'logout',
            // Permitir configuración de pagos para que puedan renovar
            'admin.pagos.index',
            'admin.pagos.wompi.store',
            'admin.pagos.wompi.toggle',
            'admin.pagos.confirmacion',
            'admin.pagos.filter'
        ];

        // Planes permanentes (one-time payment) - Plan 1 y 2
        if (in_array($user->id_plan, [1, 2]) && $dias <= 0) {
            return $next($request);
        }

        
        // Para todos los planes con días (incluye plan 6 - Free 15 días, y plan 5 - Arriendo)
        if ($dias > 0) {
            // Verificar si el usuario tiene un plan activo
            if (!$user->hasActivePlan()) {
                // Determinar el mensaje según el tipo de expiración
                $expirationMessage = 'Tu plan ha expirado. Adquiere un nuevo plan para continuar.';
                
                if ($user->subscription_ends_at && $user->subscription_ends_at->isPast()) {
                    $expirationMessage = 'Tu suscripción ha expirado. Renueva tu plan para continuar.';
                } elseif ($user->trial_ends_at && $user->trial_ends_at->isPast()) {
                    $expirationMessage = 'Tu periodo de prueba ha expirado. Adquiere un plan para continuar.';
                }
                
                // Marcar como expirado en sesión
                session()->flash('plan_expired', true);
                
                // Solo permitir rutas específicas cuando está expirado
                if (in_array($request->route()->getName(), $allowedRoutesWhenExpired)) {
                    return $next($request);
                }
                
                // Redirigir a gestión de planes para renovar/comprar
                return redirect()->route('admin.plans.index')
                    ->with('error', $expirationMessage);
            }
            
            // Si el plan está próximo a vencer (5 días o menos)
            if ($user->isPlanExpiringSoon()) {
                session()->flash('plan_expiring_soon', true);
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