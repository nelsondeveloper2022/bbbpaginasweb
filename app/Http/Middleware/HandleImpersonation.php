<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class HandleImpersonation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Compartir el estado de impersonación con todas las vistas
        View::share('isImpersonating', session()->has('impersonating_admin_id'));
        View::share('impersonatingAdminId', session('impersonating_admin_id'));
        
        return $next($request);
    }
}