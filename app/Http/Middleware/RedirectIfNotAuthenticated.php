<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            // Si es una ruta de checkout, redireccionar al registro con el plan
            if ($request->route('planSlug')) {
                return redirect()->route('register', [
                    'locale' => app()->getLocale(),
                    'plan' => $request->route('planSlug')
                ]);
            }
            
            // De lo contrario, redireccionar al login
            return redirect()->route('login', ['locale' => app()->getLocale()]);
        }

        return $next($request);
    }
}
