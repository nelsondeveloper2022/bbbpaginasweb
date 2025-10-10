<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BbbPlan;
use App\Models\BbbRenovacion;
use App\Mail\PaymentConfirmationCustomer;
use App\Mail\PaymentConfirmationAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class WompiController extends Controller
{
    /**
     * Manejar el webhook de Wompi
     */
    public function webhook(Request $request)
    {
        try {
            // Verificar la integridad del webhook
            $eventSecret = config('wompi.events_key');
            $payload = $request->getContent();
            $signature = $request->header('X-Event-Signature');
            
            // Verificación de integridad OBLIGATORIA para producción
            if ($signature && $eventSecret) {
                $computedSignature = hash_hmac('sha256', $payload, $eventSecret);
                if (!hash_equals($signature, $computedSignature)) {
                    Log::warning('Wompi webhook: Invalid signature', [
                        'signature' => $signature,
                        'computed' => $computedSignature
                    ]);
                    return response()->json(['error' => 'Invalid signature'], 400);
                }
            } else {
                Log::warning('Wompi webhook: No signature provided or missing event secret');
                // En producción, descomenta para rechazar requests sin firma
                // return response()->json(['error' => 'Missing signature'], 400);
            }

            $data = json_decode($payload, true);
            
            if (!$data || !isset($data['event']) || !isset($data['data'])) {
                Log::error('Wompi webhook: Invalid payload', ['payload' => $payload]);
                return response()->json(['error' => 'Invalid payload'], 400);
            }

            Log::info('Wompi webhook received', [
                'event' => $data['event'],
                'status' => $data['data']['status'] ?? 'unknown'
            ]);

            // Procesar diferentes tipos de eventos
            if ($data['event'] === 'transaction.updated') {
                $this->processTransactionUpdate($data['data'], $payload);
            }

            return response()->json(['status' => 'ok']);
            
        } catch (\Exception $e) {
            Log::error('Wompi webhook error: ' . $e->getMessage(), [
                'exception' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    /**
     * Procesar actualización de transacción
     */
    private function processTransactionUpdate($transactionData, $fullPayload)
    {
        try {
            $transactionId = $transactionData['id'] ?? null;
            $reference = $transactionData['reference'] ?? null;
            $status = $transactionData['status'] ?? null;
            $amount = ($transactionData['amount_in_cents'] ?? 0) / 100;

            Log::info('Processing transaction update', [
                'transaction_id' => $transactionId,
                'reference' => $reference,
                'status' => $status,
                'amount' => $amount
            ]);

            // Buscar la renovación por referencia
            $renovacion = BbbRenovacion::where('reference', $reference)
                ->first();

            if (!$renovacion) {
                Log::error('Wompi: Renovation not found', [
                    'reference' => $reference,
                    'transaction_id' => $transactionId
                ]);
                return;
            }

            DB::beginTransaction();

            // Actualizar renovación con datos del gateway
            $renovacion->update([
                'transaction_id' => $transactionId,
                'status' => $this->mapWompiStatus($status),
                'gateway_payload' => json_decode($fullPayload, true),
                'payment_method' => $transactionData['payment_method']['type'] ?? null,
            ]);

            // Solo procesar si está aprobada
            if ($status === 'APPROVED') {
                $this->processApprovedPayment($renovacion);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Wompi: Error processing transaction update', [
                'exception' => $e->getMessage(),
                'transaction_data' => $transactionData
            ]);
        }
    }

    /**
     * Procesar pago aprobado según reglas de negocio
     */
    private function processApprovedPayment(BbbRenovacion $renovacion)
    {
        $user = $renovacion->user;
        $plan = $renovacion->plan;

        Log::info('Processing approved payment', [
            'user_id' => $user->id,
            'plan_id' => $plan->idPlan,
            'plan_dias' => $plan->dias
        ]);

        if ($plan->dias > 0) {
            // Plan renovable (arriendo) - calcular nueva fecha de expiración
            $baseDate = ($user->trial_ends_at && Carbon::parse($user->trial_ends_at)->isFuture()) 
                ? Carbon::parse($user->trial_ends_at) 
                : Carbon::now();
            
            $newExpires = $baseDate->addDays($plan->dias);
            
            // Actualizar usuario
            $user->update([
                'idPlan' => $plan->idPlan,
                'trial_ends_at' => $newExpires,
            ]);
            
            // Actualizar renovación con fechas
            $renovacion->update([
                'starts_at' => $baseDate,
                'expires_at' => $newExpires,
                'status' => BbbRenovacion::STATUS_COMPLETED,
            ]);
            
            Log::info('Renewable plan activated', [
                'user_id' => $user->id,
                'expires_at' => $newExpires->toDateTimeString()
            ]);
            
        } else {
            // Plan one-time (1 o 2) - acceso permanente
            $user->update([
                'idPlan' => $plan->idPlan,
                'trial_ends_at' => null, // Limpiar trial para acceso permanente
            ]);
            
            // Actualizar renovación
            $renovacion->update([
                'starts_at' => Carbon::now(),
                'expires_at' => null, // One-time no expira
                'status' => BbbRenovacion::STATUS_COMPLETED,
            ]);
            
            Log::info('One-time plan activated', [
                'user_id' => $user->id,
                'plan_id' => $plan->idPlan
            ]);
        }

        // Enviar notificaciones por email
        $this->sendPaymentNotifications($renovacion);
    }

    /**
     * Enviar notificaciones de pago confirmado
     */
    private function sendPaymentNotifications(BbbRenovacion $renovacion)
    {
        try {
            $user = $renovacion->user;
            
            // Email para el cliente
            Mail::to($user->email)->send(new PaymentConfirmationCustomer($renovacion));
            
            // Email para el administrador
            Mail::to(config('app.support.email'))->send(new PaymentConfirmationAdmin($renovacion));
            
            Log::info('Payment notification emails sent', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'reference' => $renovacion->reference
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error sending payment notification emails', [
                'exception' => $e->getMessage(),
                'user_id' => $renovacion->user->id,
                'reference' => $renovacion->reference
            ]);
            // No lanzar excepción para no interrumpir el proceso de pago
        }
    }

    /**
     * Mapear estados de Wompi a nuestros estados
     */
    private function mapWompiStatus($wompiStatus)
    {
        $statusMap = [
            'APPROVED' => BbbRenovacion::STATUS_COMPLETED,
            'DECLINED' => BbbRenovacion::STATUS_FAILED,
            'PENDING' => BbbRenovacion::STATUS_PENDING,
            'ERROR' => BbbRenovacion::STATUS_FAILED,
            'VOIDED' => BbbRenovacion::STATUS_CANCELLED,
        ];

        return $statusMap[$wompiStatus] ?? BbbRenovacion::STATUS_FAILED;
    }
}