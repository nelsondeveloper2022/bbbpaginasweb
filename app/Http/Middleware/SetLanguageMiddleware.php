<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

/**
 * SetLanguageMiddleware - Middleware para manejo de idiomas
 * 
 * Detecta y establece el idioma basado en:
 * 1. Parámetro en la URL
 * 2. Sesión del usuario
 * 3. Idioma por defecto (español)
 */
class SetLanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Definir idiomas disponibles directamente
        $supportedLanguages = ['es', 'en'];
        
        // 1. Verificar si hay idioma en la URL
        $urlLanguage = $request->segment(1);
        
        if (in_array($urlLanguage, $supportedLanguages)) {
            // Si el idioma está en la URL, usarlo
            App::setLocale($urlLanguage);
            Session::put('app_locale', $urlLanguage);
        } else {
            // 2. Verificar si hay idioma en la sesión
            $sessionLanguage = Session::get('app_locale', 'es');
            
            if (in_array($sessionLanguage, $supportedLanguages)) {
                App::setLocale($sessionLanguage);
            } else {
                // 3. Usar idioma por defecto
                App::setLocale('es');
                Session::put('app_locale', 'es');
            }
        }

        return $next($request);
    }
}