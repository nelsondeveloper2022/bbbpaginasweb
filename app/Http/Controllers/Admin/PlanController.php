<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BbbPlan;
use App\Models\BbbRenovacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlanController extends Controller
{
    /**
     * Mostrar lista de planes disponibles
     */
    public function index()
    {
        $user = Auth::user();
        $plans = BbbPlan::orderBy('precioPesos')->get();
        $currentPlan = $user->plan;
        $trialExpired = $user->trial_ends_at && $user->trial_ends_at->isPast();
        $lastRenovacion = $user->renovaciones()->latest()->first();
        
        return view('admin.plans.index', compact('plans', 'currentPlan', 'trialExpired', 'user', 'lastRenovacion'));
    }



    /**
     * Página de checkout con Wompi
     */
    public function checkout($planId)
    {
        $user = Auth::user();
        $plan = BbbPlan::findOrFail($planId);
        
        // Validar que puede seleccionar este plan
        if (!$this->canSelectPlan($user, $plan)) {
            return redirect()->route('admin.plans.index')
                ->with('error', 'No puedes adquirir este plan según tu plan actual.');
        }

        // No permitir comprar el plan gratuito desde el checkout
        if ($plan->idPlan == 6) {
            return redirect()->route('admin.plans.index')
                ->with('error', 'El plan gratuito no se puede adquirir desde el checkout.');
        }
        
        // Buscar renovación pendiente o crear una nueva
        $renovacion = BbbRenovacion::where('user_id', $user->id)
            ->where('plan_id', $plan->idPlan)
            ->where('status', BbbRenovacion::STATUS_PENDING)
            ->first();
            
        if (!$renovacion) {
            $reference = 'BBB-' . strtoupper(Str::random(10)) . '-' . time();
            
            $renovacion = BbbRenovacion::create([
                'user_id' => $user->id,
                'plan_id' => $plan->idPlan,
                'amount' => $plan->precioPesos,
                'currency' => 'COP',
                'status' => BbbRenovacion::STATUS_PENDING,
                'reference' => $reference,
                'notes' => 'Plan: ' . $plan->nombre
            ]);
        }
        
        $reference = $renovacion->reference;
        $amountInCents = $plan->precioPesos * 100;
        $currency = 'COP';
        $integritySecret = config('services.wompi.integrity_secret');
        
        // Generar firma de integridad según documentación Wompi
        // Formato: "referencia + monto_en_centavos + moneda + secreto_integridad"
        $concatenatedData = $reference . $amountInCents . $currency . $integritySecret;
        $signature = hash('sha256', $concatenatedData);
        
        return view('admin.plans.checkout', compact('plan', 'reference', 'signature', 'amountInCents'));
    }

    /**
     * Página de éxito
     */
    public function success(Request $request)
    {
        $reference = $request->get('reference');
        $renovacion = null;
        
        if ($reference) {
            $renovacion = BbbRenovacion::where('reference', $reference)
                ->where('user_id', Auth::id())
                ->with('plan')
                ->first();
        }
        
        return view('admin.plans.success', compact('renovacion'));
    }

    /**
     * Verificar si el usuario puede seleccionar un plan según reglas de negocio
     */
    private function canSelectPlan($user, $plan)
    {
        $currentPlanId = $user->id_plan;
        $targetPlanId = $plan->idPlan;
        
        // Desde Free (sin plan o plan 6) → cualquier plan excepto otro Free
        if (!$currentPlanId || $currentPlanId == 0 || $currentPlanId == 6) {
            return in_array($targetPlanId, [1, 2, 5]) && $targetPlanId != 6;
        }
        
        // Desde 5 → 1 o 2
        if ($currentPlanId == 5) {
            return in_array($targetPlanId, [1, 2]);
        }
        
        // Desde 1 → 2
        if ($currentPlanId == 1) {
            return $targetPlanId == 2;
        }
        
        // Si está en 2 → no puede cambiar (plan premium final)
        if ($currentPlanId == 2) {
            return false;
        }
        
        return false;
    }


}
