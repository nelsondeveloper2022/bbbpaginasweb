<?php

namespace App\Http\Controllers;

use App\Models\BbbEmpresaPago;
use App\Models\BbbEmpresaPasarela;
use App\Models\BbbVentaOnline;
use App\Models\BbbVentaPagoConfirmacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class WompiController extends Controller
{
    /**
     * Handle Wompi payment confirmation webhook.
     * 
     * Endpoint: POST /wompi/confirmacion-pago
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirmacionPago(Request $request)
    {
        try {
            Log::info('Wompi Webhook Received', [
                'payload' => $request->all(),
                'headers' => $request->headers->all()
            ]);

            // Validar que el payload contenga los datos necesarios
            if (!$request->has('data')) {
                Log::warning('Wompi webhook missing data field');
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid payload structure'
                ], 400);
            }

            $data = $request->input('data');
            $transaction = $data['transaction'] ?? null;

            if (!$transaction) {
                Log::warning('Wompi webhook missing transaction data');
                return response()->json([
                    'success' => false,
                    'message' => 'Missing transaction data'
                ], 400);
            }

            // Extraer datos de la transacción
            $transactionId = $transaction['id'] ?? null;
            $reference = $transaction['reference'] ?? null;
            $status = $transaction['status'] ?? 'PENDING';
            $amountInCents = $transaction['amount_in_cents'] ?? 0;
            $currency = $transaction['currency'] ?? 'COP';
            $paymentMethodType = $transaction['payment_method_type'] ?? null;
            $customerEmail = $transaction['customer_email'] ?? null;

            // Validar datos mínimos
            if (!$transactionId || !$reference) {
                Log::warning('Wompi webhook missing required transaction fields', [
                    'transaction_id' => $transactionId,
                    'reference' => $reference
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Missing required transaction fields'
                ], 400);
            }

            // Buscar la venta por referencia
            $venta = BbbVentaOnline::where('idVenta', $reference)
                ->orWhere('observaciones', 'like', "%{$reference}%")
                ->first();

            if (!$venta) {
                Log::warning('Venta not found for reference', ['reference' => $reference]);
                return response()->json([
                    'success' => false,
                    'message' => 'Sale not found'
                ], 404);
            }

            // Obtener la pasarela Wompi de la empresa
            $pagoConfig = BbbEmpresaPago::where('idEmpresa', $venta->idEmpresa)->first();
            
            if (!$pagoConfig) {
                Log::error('Payment configuration not found for empresa', ['idEmpresa' => $venta->idEmpresa]);
                return response()->json([
                    'success' => false,
                    'message' => 'Payment configuration not found'
                ], 404);
            }

            $wompiPasarela = BbbEmpresaPasarela::where('idPagoConfig', $pagoConfig->idPagoConfig)
                ->where('nombre_pasarela', 'Wompi')
                ->where('activo', true)
                ->first();

            if (!$wompiPasarela) {
                Log::error('Wompi gateway not found or inactive', ['idEmpresa' => $venta->idEmpresa]);
                return response()->json([
                    'success' => false,
                    'message' => 'Wompi gateway not configured'
                ], 404);
            }

            // Validar firma de integridad (si está configurada)
            if ($wompiPasarela->getIntegrityKey()) {
                $isValidSignature = $this->validateSignature($request, $wompiPasarela->getIntegrityKey());
                
                if (!$isValidSignature) {
                    Log::error('Invalid Wompi signature');
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid signature'
                    ], 401);
                }
            }

            // Verificar si ya existe una confirmación para esta transacción
            $existingConfirmacion = BbbVentaPagoConfirmacion::where('transaccion_id', $transactionId)->first();
            
            if ($existingConfirmacion) {
                Log::info('Payment confirmation already exists', ['transaction_id' => $transactionId]);
                
                // Actualizar si el estado cambió
                if ($existingConfirmacion->estado !== $status) {
                    $existingConfirmacion->update([
                        'estado' => $status,
                        'respuesta_completa' => $request->all(),
                    ]);
                    
                    // Actualizar estado de la venta
                    $this->updateVentaStatus($venta, $status);
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Payment confirmation updated'
                ], 200);
            }

            // Convertir monto de centavos a unidades
            $monto = $amountInCents / 100;

            // Crear la confirmación de pago
            $confirmacion = BbbVentaPagoConfirmacion::create([
                'idVenta' => $venta->idVenta,
                'idEmpresa' => $venta->idEmpresa,
                'referencia' => $reference,
                'transaccion_id' => $transactionId,
                'monto' => $monto,
                'moneda' => $currency,
                'estado' => $status,
                'respuesta_completa' => $request->all(),
                'fecha_confirmacion' => now(),
            ]);

            Log::info('Payment confirmation created', [
                'idPagoConfirmacion' => $confirmacion->idPagoConfirmacion,
                'transaction_id' => $transactionId,
                'status' => $status
            ]);

            // Actualizar el estado de la venta
            $this->updateVentaStatus($venta, $status);

            // Enviar notificaciones por email
            $this->sendNotifications($venta, $confirmacion, $customerEmail);

            return response()->json([
                'success' => true,
                'message' => 'Payment confirmation processed successfully',
                'data' => [
                    'confirmation_id' => $confirmacion->idPagoConfirmacion,
                    'status' => $status
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error processing Wompi webhook: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred'
            ], 500);
        }
    }

    /**
     * Validate Wompi webhook signature.
     * 
     * @param Request $request
     * @param string $integrityKey
     * @return bool
     */
    private function validateSignature(Request $request, string $integrityKey): bool
    {
        try {
            // Obtener la firma del header
            $signature = $request->header('X-Event-Signature');
            
            if (!$signature) {
                Log::warning('Wompi signature header not found');
                return false;
            }

            // Obtener el payload raw
            $payload = $request->getContent();
            
            // Calcular la firma esperada
            $expectedSignature = hash_hmac('sha256', $payload, $integrityKey);
            
            // Comparar firmas
            $isValid = hash_equals($expectedSignature, $signature);
            
            if (!$isValid) {
                Log::warning('Wompi signature mismatch', [
                    'expected' => $expectedSignature,
                    'received' => $signature
                ]);
            }
            
            return $isValid;
        } catch (\Exception $e) {
            Log::error('Error validating Wompi signature: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update venta status based on payment status.
     * 
     * @param BbbVentaOnline $venta
     * @param string $paymentStatus
     * @return void
     */
    private function updateVentaStatus(BbbVentaOnline $venta, string $paymentStatus): void
    {
        try {
            $nuevoEstado = match($paymentStatus) {
                'APPROVED' => 'completada',
                'DECLINED' => 'cancelada',
                'VOIDED' => 'cancelada',
                'ERROR' => 'cancelada',
                'PENDING' => 'pendiente',
                default => 'pendiente',
            };

            if ($venta->estado !== $nuevoEstado) {
                $venta->update(['estado' => $nuevoEstado]);
                
                Log::info('Venta status updated', [
                    'idVenta' => $venta->idVenta,
                    'old_status' => $venta->estado,
                    'new_status' => $nuevoEstado
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error updating venta status: ' . $e->getMessage());
        }
    }

    /**
     * Send payment confirmation notifications.
     * 
     * @param BbbVentaOnline $venta
     * @param BbbVentaPagoConfirmacion $confirmacion
     * @param string|null $customerEmail
     * @return void
     */
    private function sendNotifications(BbbVentaOnline $venta, BbbVentaPagoConfirmacion $confirmacion, ?string $customerEmail): void
    {
        try {
            // TODO: Implementar envío de emails personalizados para VentaOnline
            // Por ahora, solo registramos en logs
            
            Log::info('Payment confirmation notification triggered', [
                'idVenta' => $venta->idVenta,
                'idEmpresa' => $venta->idEmpresa,
                'admin_email' => $venta->empresa->email ?? null,
                'customer_email' => $customerEmail ?? $venta->cliente->email ?? null,
                'transaction_id' => $confirmacion->transaccion_id,
                'status' => $confirmacion->estado,
                'amount' => $confirmacion->monto,
            ]);

            // Aquí puedes agregar tu lógica de notificaciones:
            // - Enviar emails personalizados
            // - Enviar notificaciones push
            // - Enviar mensajes por WhatsApp
            // - etc.
            
        } catch (\Exception $e) {
            Log::error('Error in payment notifications: ' . $e->getMessage());
            // No lanzar excepción para no afectar el flujo principal
        }
    }

    /**
     * Get payment status by transaction ID.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTransactionStatus(Request $request, $transactionId)
    {
        try {
            $confirmacion = BbbVentaPagoConfirmacion::where('transaccion_id', $transactionId)
                ->with(['venta', 'empresa'])
                ->first();

            if (!$confirmacion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'transaction_id' => $confirmacion->transaccion_id,
                    'reference' => $confirmacion->referencia,
                    'status' => $confirmacion->estado,
                    'amount' => $confirmacion->monto,
                    'currency' => $confirmacion->moneda,
                    'date' => $confirmacion->fecha_confirmacion,
                ]
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error getting transaction status: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving transaction status'
            ], 500);
        }
    }
}
