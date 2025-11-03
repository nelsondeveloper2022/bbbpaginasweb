<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnsureLandingConfigured
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Solo aplicar a usuarios autenticados
            if (!Auth::check()) {
                return $next($request);
            }
            
            $user = Auth::user();
            
            // Si es un admin impersonando, permitir acceso sin restricciones
            if (session()->has('impersonating_admin_id')) {
                Log::info('EnsureLandingConfigured: Admin impersonating detected, bypassing middleware');
                return $next($request);
            }
            
            // Si es administrador, permitir acceso sin restricciones
            if ($user && method_exists($user, 'isAdmin') && $user->isAdmin()) {
                Log::info('EnsureLandingConfigured: Admin user detected, bypassing middleware');
                return $next($request);
            }
            
            // Lista de rutas que están exentas de esta verificación
            $exemptRoutes = [
                'admin.landing.configurar',
                'admin.landing.guardar',
                'admin.landing.publicar',
                'admin.landing.preview',
                'admin.landing.media.subir',
                'admin.landing.media.eliminar',
                'admin.landing.media.obtener',
                'admin.plans.index',
                'admin.plans.*',
                'logout',
                'admin.profile.edit',
                'admin.profile.update'
            ];
            
            // Si la ruta actual está exenta, continuar
            foreach ($exemptRoutes as $exemptRoute) {
                if ($request->routeIs($exemptRoute)) {
                    return $next($request);
                }
            }
            
            // FALLBACK SEGURO: Si hay cualquier problema, permitir acceso durante impersonación
            if (session()->has('impersonating_admin_id')) {
                return $next($request);
            }
            
            // Verificar si el usuario necesita configurar su landing
            $needsLandingSetup = false;
            $landingSetupMessage = '';
            
            // Verificar si no tiene empresa asignada
            if ($user->idEmpresa == 0 || $user->idEmpresa == null) {
                $needsLandingSetup = true;
                $landingSetupMessage = 'Debes asignar tu cuenta a una empresa';
            } else {
                try {
                    // Cargar empresa con su landing usando el modelo directamente
                    $empresa = \App\Models\BbbEmpresa::with('landing')
                        ->where('idEmpresa', $user->idEmpresa)
                        ->first();
                    
                    if (!$empresa) {
                        $needsLandingSetup = true;
                        $landingSetupMessage = 'No se encontró información de tu empresa';
                    }
                    // Verificar si no tiene landing configurada
                    elseif (!$empresa->landing) {
                        $needsLandingSetup = true;
                        $landingSetupMessage = 'Debes configurar tu landing page';
                    }
                    // Verificar si la landing no está completa (sin título principal)
                    elseif (is_null($empresa->landing->titulo_principal) || trim($empresa->landing->titulo_principal) === '') {
                        $needsLandingSetup = true;
                        $landingSetupMessage = 'Debes completar la configuración de tu landing page - falta el título principal';
                    }
                } catch (\Exception $empresaException) {
                    Log::warning('Error al cargar empresa en middleware', [
                        'user_id' => $user->id,
                        'empresa_id' => $user->idEmpresa,
                        'error' => $empresaException->getMessage()
                    ]);
                    // En caso de error, permitir acceso si es impersonación
                    if (session()->has('impersonating_admin_id')) {
                        return $next($request);
                    }
                    $needsLandingSetup = true;
                    $landingSetupMessage = 'Debes configurar tu landing page';
                }
            }
            // Si necesita configurar la landing, redirigir
            if ($needsLandingSetup) {
                return redirect()->route('admin.landing.configurar')
                    ->with('warning', $landingSetupMessage . '. Completa esta configuración para acceder a todas las funcionalidades.');
            }
            
        } catch (\Exception $e) {
            // En caso de error, log detallado y permitir continuar si es admin o impersonación
            Log::error('Error en EnsureLandingConfigured middleware', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'user_id' => Auth::id(),
                'impersonating' => session()->has('impersonating_admin_id'),
                'route' => $request->route() ? $request->route()->getName() : 'NO_ROUTE',
                'url' => $request->url()
            ]);
            
            // FALLBACK FINAL: Siempre permitir si hay impersonación activa
            if (session()->has('impersonating_admin_id')) {
                return $next($request);
            }
            
            // Si es admin, permitir continuar
            if (Auth::check() && method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin()) {
                return $next($request);
            }
            
            return redirect()->route('admin.landing.configurar')
                ->with('error', 'Hubo un problema verificando tu configuración. Por favor, completa la configuración de tu landing page.');
        }
        
        return $next($request);
    }
}
