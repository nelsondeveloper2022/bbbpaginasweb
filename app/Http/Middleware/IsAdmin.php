<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Debes iniciar sesión para acceder.');
        }

        // Si estamos impersonando, verificar que el admin original sea válido
        if (session()->has('impersonating_admin_id')) {
            $adminId = session('impersonating_admin_id');
            $admin = \App\Models\User::find($adminId);
            
            if (!$admin || !$admin->isAdmin()) {
                // Limpiar sesión corrupta
                session()->forget(['impersonating_admin_id', 'impersonating_admin_name', 'impersonation_started_at']);
                Auth::logout();
                return redirect()->route('admin.login')->with('error', 'Sesión de administrador inválida.');
            }
            
            // Cuando se está impersonando, permitir todas las rutas de admin
            // porque el admin original ya fue validado
            return $next($request);
        }

        // Verificar si el usuario es administrador
        if (!Auth::user()->isAdmin()) {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Acceso denegado. Solo administradores.');
        }

        return $next($request);
    }
}
