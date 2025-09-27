<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileIsComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if ($user && $this->isProfileIncomplete($user)) {
            // Si el usuario está en la página de perfil, permitir acceso
            if ($request->routeIs('profile.*')) {
                return $next($request);
            }
            
            // Redirigir a completar perfil con mensaje
            return redirect()->route('profile.edit')
                ->with('warning', 'Por favor completa tu información de perfil y empresa para continuar.');
        }

        return $next($request);
    }

    /**
     * Determinar si el perfil está incompleto
     */
    private function isProfileIncomplete($user): bool
    {
        // Verificar campos requeridos del usuario
        if (empty($user->name) || empty($user->email)) {
            return true;
        }

        // Verificar información básica de empresa
        if (empty($user->empresa_nombre) || empty($user->empresa_email)) {
            return true;
        }

        return false;
    }
}