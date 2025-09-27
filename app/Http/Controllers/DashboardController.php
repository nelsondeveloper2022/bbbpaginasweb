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

        // SIEMPRE mostrar el dashboard principal, nunca redirigir a la vista de planes
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
