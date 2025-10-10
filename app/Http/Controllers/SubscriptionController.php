<?php

namespace App\Http\Controllers;

use App\Models\BbbPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    /**
     * Mostrar la vista de planes disponibles
     */
    public function showPlans()
    {
        $user = Auth::user();
        
        // Obtener los 3 planes principales (puedes ajustar la consulta según tus necesidades)
        $plans = BbbPlan::whereIn('idPlan', [1, 2, 3])
            ->orderBy('orden')
            ->get();

        $trialExpired = $user->trialExpired();
        
        return view('subscription.plans', compact('plans', 'user', 'trialExpired'));
    }

    /**
     * Iniciar el proceso de checkout con Wompi
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:bbbplan,idPlan'
        ]);

        $user = Auth::user();
        $plan = BbbPlan::findOrFail($request->plan_id);
        
        // Crear la referencia única para el pago
        $reference = 'BBB_' . $user->id . '_' . $plan->idPlan . '_' . time();
        
        // Configuración de Wompi - Usar el widget de checkout
        $publicKey = config('wompi.public_key');
        $environment = config('wompi.environment');
        
        // Log para debug en producción
        Log::info('Wompi Configuration', [
            'public_key' => $publicKey,
            'environment' => $environment,
            'app_env' => config('app.env')
        ]);
        
        $checkoutData = [
            'public_key' => $publicKey,
            'currency' => 'COP',
            'amount_in_cents' => $plan->precioPesos * 100,
            'reference' => $reference,
            'customer_email' => $user->email,
            'customer_name' => $user->name,
            'redirect_url' => route('admin.subscription.success'),
            'plan_name' => $plan->nombre,
            'plan_id' => $plan->idPlan
        ];

        // Guardar información temporal del pago
        session([
            'pending_payment' => [
                'user_id' => $user->id,
                'plan_id' => $plan->idPlan,
                'reference' => $reference,
                'amount' => $plan->precioPesos,
                'plan_name' => $plan->nombre
            ]
        ]);
        
        return view('subscription.checkout', compact('checkoutData', 'plan', 'user'));
    }

    /**
     * Página de éxito del pago
     */
    public function success()
    {
        return view('subscription.success');
    }

    /**
     * Verificar estado de la suscripción (AJAX)
     */
    public function checkStatus()
    {
        $user = Auth::user();
        
        return response()->json([
            'active' => $user->hasActiveSubscription(),
            'plan_id' => $user->id_plan,
            'subscription_ends_at' => $user->subscription_ends_at?->format('d/m/Y')
        ]);
    }

    /**
     * Crear transacción en Wompi
     */
    private function createWompiTransaction($data, $config)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://production.wompi.co/v1/payment_sources',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $config['private_key'],
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }
}