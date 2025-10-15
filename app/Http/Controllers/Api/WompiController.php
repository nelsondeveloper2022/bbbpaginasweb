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
        Log::info('=== WOMPI WEBHOOK STARTED ===', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'headers' => $request->headers->all(),
            'content_type' => $request->header('Content-Type'),
            'user_agent' => $request->header('User-Agent'),
        ]);

        try {
            // Verificar la integridad del webhook
            // Event secret puede venir de config/wompi.php o config/services.php
            $eventSecret = config('wompi.events_key') ?: config('services.wompi.event_secret');
            $payload = $request->getContent();
            
            Log::info('Wompi webhook payload received', [
                'payload_length' => strlen($payload),
                'payload_preview' => substr($payload, 0, 500),
                'event_secret_exists' => !empty($eventSecret)
            ]);
            
            // Algunos entornos usan diferentes headers
            $signature = $request->header('X-Event-Signature')
                ?: $request->header('X-Signature')
                ?: $request->header('X-Wompi-Signature');
            
            // Verificación de integridad OBLIGATORIA para producción
            $headerValidated = null;
            if ($signature && $eventSecret) {
                $computedSignature = hash_hmac('sha256', $payload, $eventSecret);
                if (!hash_equals($signature, $computedSignature)) {
                    Log::warning('Wompi webhook: Invalid signature', [
                        'signature' => $signature,
                        'computed' => $computedSignature
                    ]);
                    $headerValidated = false;
                } else {
                    $headerValidated = true;
                }
            } else {
                Log::warning('Wompi webhook: No signature provided or missing event secret');
                // En producción, descomenta para rechazar requests sin firma
                // return response()->json(['error' => 'Missing signature'], 400);
            }

            $data = json_decode($payload, true);
            
            Log::info('Payload decoded', [
                'decode_success' => $data !== null,
                'has_event' => isset($data['event']),
                'has_data' => isset($data['data']),
                'event_type' => $data['event'] ?? 'not_set',
                'data_keys' => $data ? array_keys($data) : 'null'
            ]);
            
            if (!$data || !isset($data['event']) || !isset($data['data'])) {
                Log::error('Wompi webhook: Invalid payload structure', [
                    'payload' => $payload,
                    'decoded_data' => $data,
                    'json_error' => json_last_error_msg()
                ]);
                return response()->json(['error' => 'Invalid payload'], 400);
            }

            // Si viene firma de integridad en el cuerpo, validarla con la INTEGRITY_KEY
            $integrityValidated = $this->validateIntegrityChecksum($data);
            if ($integrityValidated === false) {
                // Si hay checksum pero no coincide y el header no validó, rechazar en producción
                if ($headerValidated !== true) {
                    if (app()->environment('production')) {
                        return response()->json(['error' => 'Invalid checksum'], 400);
                    } else {
                        Log::warning('Wompi webhook: Checksum invalid but continuing (non-production env)');
                    }
                } else {
                    Log::warning('Wompi webhook: Checksum invalid but header signature valid; proceeding');
                }
            }

            $loggedStatus = $data['data']['transaction']['status']
                ?? $data['data']['status']
                ?? 'unknown';
            Log::info('Wompi webhook received', [
                'event' => $data['event'],
                'status' => $loggedStatus,
            ]);

            // Procesar diferentes tipos de eventos
            if ($data['event'] === 'transaction.updated') {
                Log::info('Processing transaction.updated event');
                // El payload de Wompi envía la transacción en data.transaction
                $transaction = $data['data']['transaction'] ?? $data['data'];
                
                Log::info('Transaction data extracted', [
                    'transaction_keys' => array_keys($transaction),
                    'transaction_id' => $transaction['id'] ?? 'not_set',
                    'reference' => $transaction['reference'] ?? 'not_set',
                    'status' => $transaction['status'] ?? 'not_set',
                    'amount_in_cents' => $transaction['amount_in_cents'] ?? 'not_set',
                    'customer_email' => $transaction['customer_email'] ?? 'not_set'
                ]);
                
                $this->processTransactionUpdate($transaction, $payload);
            } else {
                Log::warning('Unhandled event type', ['event' => $data['event']]);
            }

            Log::info('=== WOMPI WEBHOOK COMPLETED SUCCESSFULLY ===');
            return response()->json(['status' => 'ok']);
            
        } catch (\Exception $e) {
            Log::error('=== WOMPI WEBHOOK ERROR ===', [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'stack_trace' => $e->getTraceAsString(),
                'request_method' => $request->method(),
                'request_url' => $request->fullUrl(),
                'request_headers' => $request->headers->all(),
                'request_content' => $request->getContent()
            ]);
            
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    /**
     * Procesar actualización de transacción
     */
    private function processTransactionUpdate($transactionData, $fullPayload)
    {
        Log::info('=== PROCESS TRANSACTION UPDATE STARTED ===', [
            'transaction_data_keys' => array_keys($transactionData ?? []),
            'full_payload_length' => strlen($fullPayload)
        ]);
        
        try {
            $transactionId = $transactionData['id'] ?? null;
            $reference = $transactionData['reference'] ?? null;
            $status = $transactionData['status'] ?? null;
            $amount = ($transactionData['amount_in_cents'] ?? 0) / 100;

            Log::info('Transaction data parsed', [
                'transaction_id' => $transactionId,
                'reference' => $reference,
                'status' => $status,
                'amount' => $amount,
                'currency' => $transactionData['currency'] ?? 'not_set',
                'customer_email' => $transactionData['customer_email'] ?? 'not_set'
            ]);

            // Buscar la renovación por referencia o crearla si no existe
            $renovacion = BbbRenovacion::where('reference', $reference)->first();

            if (!$renovacion) {
                // Si no existe renovación, intentar crearla basándose en la referencia y monto
                $renovacion = $this->createRenovationFromTransaction($transactionData, $fullPayload);
                
                if (!$renovacion) {
                    Log::error('Wompi: Could not create or find renovation', [
                        'reference' => $reference,
                        'transaction_id' => $transactionId,
                        'amount' => $amount
                    ]);
                    return;
                }
            }

            DB::beginTransaction();

            // Idempotencia: si ya está completada, no reprocesar
            if ($renovacion->status === BbbRenovacion::STATUS_COMPLETED) {
                Log::info('Wompi: Renovation already completed. Skipping.', [
                    'reference' => $reference,
                ]);
                DB::commit();
                return;
            }

            // Actualizar renovación con datos del gateway
            $renovacion->update([
                'transaction_id' => $transactionId,
                'status' => $this->mapWompiStatus($status),
                'gateway_payload' => json_decode($fullPayload, true),
                'payment_method' => $transactionData['payment_method']['type'] ?? null,
                'currency' => $transactionData['currency'] ?? $renovacion->currency,
                'amount' => $amount ?: $renovacion->amount,
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

        if (!$user) {
            Log::error('Wompi: User not found for renovation', ['renovation_id' => $renovacion->idRenovacion]);
            return;
        }

        if (!$plan) {
            Log::error('Wompi: Plan not found for renovation', [
                'renovation_id' => $renovacion->idRenovacion,
                'plan_id' => $renovacion->plan_id
            ]);
            return;
        }

        Log::info('Processing approved payment', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'plan_id' => $plan->idPlan,
            'plan_name' => $plan->nombre,
            'plan_dias' => $plan->dias,
            'current_user_plan' => $user->id_plan,
            'current_trial_ends' => $user->trial_ends_at?->toDateTimeString()
        ]);

        // Calcular fechas según el tipo de plan
        $now = Carbon::now();
        $baseDate = $now;
        
        if ($plan->dias > 0) {
            // Plan renovable - calcular nueva fecha de expiración
            if ($user->trial_ends_at && Carbon::parse($user->trial_ends_at)->isFuture()) {
                $baseDate = Carbon::parse($user->trial_ends_at);
                Log::info('Extending from existing trial end date', ['base_date' => $baseDate->toDateTimeString()]);
            } else {
                Log::info('Starting from current date (trial expired or null)', ['base_date' => $baseDate->toDateTimeString()]);
            }
            
            $newExpires = $baseDate->copy()->addDays($plan->dias);
            
            Log::info('Calculated new expiration', [
                'base_date' => $baseDate->toDateTimeString(),
                'plan_dias' => $plan->dias,
                'new_expires' => $newExpires->toDateTimeString()
            ]);
            
            // Actualizar usuario
            $userUpdateData = [
                'id_plan' => $plan->idPlan,
                'trial_ends_at' => $newExpires,
                'subscription_starts_at' => $baseDate,
                'subscription_ends_at' => $newExpires,
            ];
            
            Log::info('Updating user with data', $userUpdateData);
            $user->update($userUpdateData);
            
            // Verificar que se actualizó
            $user->refresh();
            Log::info('User updated - verification', [
                'user_id' => $user->id,
                'new_id_plan' => $user->id_plan,
                'new_trial_ends_at' => $user->trial_ends_at?->toDateTimeString()
            ]);
            
            // Actualizar renovación con fechas
            $renovacion->update([
                'starts_at' => $baseDate,
                'expires_at' => $newExpires,
                'status' => BbbRenovacion::STATUS_COMPLETED,
            ]);
            
            Log::info('Renewable plan activated successfully', [
                'user_id' => $user->id,
                'plan_id' => $plan->idPlan,
                'expires_at' => $newExpires->toDateTimeString()
            ]);
            
        } else {
            // Plan one-time (acceso permanente)
            $userUpdateData = [
                'id_plan' => $plan->idPlan,
                'trial_ends_at' => null,
                'subscription_starts_at' => $now,
                'subscription_ends_at' => null,
            ];
            
            Log::info('Updating user with permanent plan data', $userUpdateData);
            $user->update($userUpdateData);
            
            // Verificar que se actualizó
            $user->refresh();
            Log::info('User updated - verification', [
                'user_id' => $user->id,
                'new_id_plan' => $user->id_plan,
                'new_trial_ends_at' => $user->trial_ends_at?->toDateTimeString()
            ]);
            
            // Actualizar renovación
            $renovacion->update([
                'starts_at' => $now,
                'expires_at' => null, // One-time no expira
                'status' => BbbRenovacion::STATUS_COMPLETED,
            ]);
            
            Log::info('Permanent plan activated successfully', [
                'user_id' => $user->id,
                'plan_id' => $plan->idPlan
            ]);
        }

        // Enviar notificaciones por email
        $this->sendPaymentNotifications($renovacion);
    }    /**
     * Enviar notificaciones de pago confirmado
     */
    private function sendPaymentNotifications(BbbRenovacion $renovacion)
    {
        try {
            $user = $renovacion->user;
            
            if (!$user || !$user->email) {
                Log::error('Cannot send notifications: user or email missing', [
                    'renovation_id' => $renovacion->id,
                    'user_id' => $user?->id,
                    'user_email' => $user?->email
                ]);
                return;
            }

            Log::info('Attempting to send payment notification emails', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'reference' => $renovacion->reference,
                'plan_name' => $renovacion->plan?->nombre,
                'amount' => $renovacion->amount
            ]);
            
            // Email para el cliente
            try {
                Mail::to($user->email)->send(new PaymentConfirmationCustomer($renovacion));
                Log::info('Customer payment notification sent successfully', [
                    'user_email' => $user->email,
                    'reference' => $renovacion->reference
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send customer payment notification', [
                    'user_email' => $user->email,
                    'error' => $e->getMessage(),
                    'reference' => $renovacion->reference
                ]);
            }
            
            // Email para el administrador
            $adminEmail = 'info@bbbpaginasweb.com';
            try {
                Mail::to($adminEmail)->send(new PaymentConfirmationAdmin($renovacion));
                Log::info('Admin payment notification sent successfully', [
                    'admin_email' => $adminEmail,
                    'reference' => $renovacion->reference
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send admin payment notification', [
                    'admin_email' => $adminEmail,
                    'error' => $e->getMessage(),
                    'reference' => $renovacion->reference
                ]);
            }
            
            Log::info('Payment notification process completed', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'reference' => $renovacion->reference
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in payment notification process', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $renovacion->user?->id,
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

    /**
     * Validar checksum de integridad incluido en el body del webhook (si existe).
     * La fórmula (según docs de Wompi) es: sha256(join(values) + INTEGRITY_KEY)
     * donde values siguen el orden de signature.properties y provienen de data.*
     *
     * @return bool|null true si válida, false si inválida, null si no aplica
     */
    private function validateIntegrityChecksum(array $data)
    {
        if (!isset($data['signature']['checksum']) || !isset($data['signature']['properties'])) {
            return null; // No hay checksum en el body
        }

        // Buscar integrity key en múltiples fuentes (config y services)
        $integrityKey = config('wompi.integrity_key') ?: config('services.wompi.integrity_secret');
        if (!$integrityKey) {
            Log::warning('Wompi webhook: integrity_key missing, skipping checksum validation');
            return null;
        }

        $properties = $data['signature']['properties']; // e.g. ['transaction.id','transaction.status','transaction.amount_in_cents']
        $valuesConcat = '';
        $extractedValues = [];
        foreach ($properties as $propPath) {
            // Los paths están relativos a data.*, por ejemplo transaction.id
            $value = $this->getArrayValueByDotPath($data['data'], $propPath);
            $valuesConcat .= (string) $value;
            $extractedValues[] = [
                'path' => $propPath,
                'value' => $value,
            ];
        }

    $expectedChecksum = hash('sha256', $valuesConcat . $integrityKey);
        $providedChecksum = $data['signature']['checksum'];

        if (!hash_equals($expectedChecksum, $providedChecksum)) {
            Log::warning('Wompi webhook: Invalid body checksum', [
                'expected' => $expectedChecksum,
                'provided' => $providedChecksum,
                'properties' => $properties,
                'concat' => $valuesConcat,
                'values' => $extractedValues,
            ]);
            return false;
        }

        Log::info('Wompi webhook: Body checksum validated');
        return true;
    }

    /**
     * Crear renovación desde datos de transacción cuando no existe registro previo
     */
    private function createRenovationFromTransaction($transactionData, $fullPayload)
    {
        try {
            $reference = $transactionData['reference'] ?? null;
            $amount = ($transactionData['amount_in_cents'] ?? 0) / 100;
            $currency = $transactionData['currency'] ?? 'COP';

            if (!$reference) {
                return null;
            }

            // Extraer información del usuario desde el email del cliente o desde la referencia
            $customerEmail = $transactionData['customer_email'] ?? null;
            $user = null;
            
            if ($customerEmail) {
                $user = User::where('email', $customerEmail)->first();
            }

            // Si no se encuentra usuario por email, intentar extraer de la referencia
            if (!$user && preg_match('/BBB-([A-Z0-9]+)-/', $reference, $matches)) {
                // La referencia podría tener un formato que incluya información del usuario
                Log::info('Wompi: Attempting to identify user from reference pattern', [
                    'reference' => $reference,
                    'pattern_match' => $matches[1] ?? null
                ]);
            }

            if (!$user) {
                Log::warning('Wompi: Cannot identify user for transaction', [
                    'reference' => $reference,
                    'customer_email' => $customerEmail
                ]);
                return null;
            }

            // Identificar el plan basándose en el monto y moneda
            $plan = $this->identifyPlanFromAmount($amount, $currency);
            
            if (!$plan) {
                Log::warning('Wompi: Cannot identify plan from amount', [
                    'amount' => $amount,
                    'currency' => $currency
                ]);
                return null;
            }

            // Crear la renovación
            $renovacion = BbbRenovacion::create([
                'user_id' => $user->id,
                'plan_id' => $plan->idPlan,
                'amount' => $amount,
                'currency' => $currency,
                'gateway' => 'wompi',
                'transaction_id' => $transactionData['id'] ?? null,
                'reference' => $reference,
                'status' => BbbRenovacion::STATUS_PENDING,
                'payment_method' => $transactionData['payment_method']['type'] ?? null,
                'gateway_payload' => json_decode($fullPayload, true),
            ]);

            Log::info('Wompi: Created renovation from transaction', [
                'renovation_id' => $renovacion->idRenovacion,
                'user_id' => $user->id,
                'plan_id' => $plan->idPlan,
                'amount' => $amount
            ]);

            return $renovacion;

        } catch (\Exception $e) {
            Log::error('Wompi: Error creating renovation from transaction', [
                'exception' => $e->getMessage(),
                'transaction_data' => $transactionData
            ]);
            return null;
        }
    }

    /**
     * Identificar el plan basándose en el monto pagado
     */
    private function identifyPlanFromAmount($amount, $currency = 'COP')
    {
        if ($currency === 'COP') {
            // Buscar plan por precio en pesos (convertir a centavos para comparación)
            $amountInPesos = $amount;
            
            $plan = BbbPlan::where('precioPesos', $amountInPesos)
                ->orWhere('precioPesos', $amountInPesos * 100) // Por si están en centavos
                ->first();
                
            if ($plan) {
                return $plan;
            }
            
            // Buscar con tolerancia de ±1% para diferencias de redondeo
            $tolerance = $amountInPesos * 0.01;
            $plan = BbbPlan::whereBetween('precioPesos', [
                $amountInPesos - $tolerance,
                $amountInPesos + $tolerance
            ])->first();
            
            return $plan;
        }
        
        if ($currency === 'USD') {
            $plan = BbbPlan::where('preciosDolar', $amount)
                ->first();
            return $plan;
        }
        
        return null;
    }

    /**
     * Obtener un valor de un arreglo usando notación de puntos.
     * Soporta paths como "transaction.id" relativos al arreglo base.
     */
    private function getArrayValueByDotPath(array $array, string $path, $default = null)
    {
        $segments = explode('.', $path);
        $current = $array;
        foreach ($segments as $segment) {
            if (!is_array($current) || !array_key_exists($segment, $current)) {
                return $default;
            }
            $current = $current[$segment];
        }
        return $current;
    }
}