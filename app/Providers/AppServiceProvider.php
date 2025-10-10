<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configurar Carbon para zona horaria de Colombia
        Carbon::setLocale('es');
        
        // Configurar timezone por defecto para Carbon
        date_default_timezone_set('America/Bogota');
    }
}
