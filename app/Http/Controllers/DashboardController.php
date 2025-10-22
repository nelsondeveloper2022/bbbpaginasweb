<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard principal
     */
    public function index()
    {
        $user = Auth::user();
        
        // Verificar si el usuario necesita configurar su landing
        $needsLandingSetup = false;
        $landingSetupMessage = '';
        
        // Verificar si no tiene empresa asignada
        if (!$user->idEmpresa || !$user->empresa) {
            $needsLandingSetup = true;
            $landingSetupMessage = 'Debes asignar tu cuenta a una empresa';
        }
        // Verificar si no tiene landing configurada
        elseif (!$user->empresa->landing || !$user->empresa->landing->exists) {
            $needsLandingSetup = true;
            $landingSetupMessage = 'Debes configurar tu landing page';
        }
        // Verificar si la landing no está completa (sin título principal)
        elseif (!$user->empresa->landing->titulo_principal) {
            $needsLandingSetup = true;
            $landingSetupMessage = 'Debes completar la configuración de tu landing page';
        }
        
        // Si necesita configurar la landing, redirigir automáticamente
        if ($needsLandingSetup) {
            return redirect()->route('admin.landing.configurar')
                ->with('warning', $landingSetupMessage . '. Completa esta configuración para acceder al dashboard completo.');
        }
        
        // Calcular información de suscripción y trial
        $trialDaysLeft = 0;
        $trialExpired = false;
        $subscriptionDaysLeft = 0;
        $hasActiveSubscription = $user->hasActiveSubscription();
        $isPlanExpiringSoon = $user->isPlanExpiringSoon();
        
        if ($user->trial_ends_at && !$hasActiveSubscription) {
            $trialDaysLeft = now()->diffInDays($user->trial_ends_at, false);
            $trialExpired = $user->trialExpired();
            
            // Si es negativo, significa que ya expiró
            if ($trialDaysLeft < 0) {
                $trialDaysLeft = 0;
                $trialExpired = true;
            }
        }
        
        // Calcular días restantes de suscripción
        if ($hasActiveSubscription) {
            $subscriptionDaysLeft = now()->diffInDays($user->subscription_ends_at, false);
        }

        // Mostrar el dashboard principal solo si la landing está configurada
        return view('dashboard', compact(
            'user', 
            'trialDaysLeft', 
            'trialExpired', 
            'hasActiveSubscription',
            'subscriptionDaysLeft',
            'isPlanExpiringSoon'
        ));
    }


}
