<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BbbEmpresa;
use App\Models\BbbEmpresaPago;
use App\Models\BbbEmpresaPasarela;
use App\Models\BbbVentaPagoConfirmacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class PagosController extends Controller
{
    /**
     * Display the payment configuration page.
     */
    public function index(Request $request)
    {
        try {
            // Obtener la empresa del usuario autenticado
            // Ajusta esto según tu lógica de autenticación
            $idEmpresa = $this->getEmpresaId();
            
            if (!$idEmpresa) {
                return redirect()->back()->with('error', 'No se pudo identificar la empresa.');
            }

            // Obtener o crear la configuración de pagos
            $pagoConfig = BbbEmpresaPago::firstOrCreate(
                ['idEmpresa' => $idEmpresa],
                [
                    'pago_online' => false,
                    'moneda' => 'COP'
                ]
            );

            // Obtener la pasarela Wompi
            $wompiPasarela = BbbEmpresaPasarela::where('idPagoConfig', $pagoConfig->idPagoConfig)
                ->where('nombre_pasarela', 'Wompi')
                ->first();

            // Desencriptar la llave privada para mostrar en el formulario
            if ($wompiPasarela && $wompiPasarela->private_key) {
                try {
                    $wompiPasarela->decrypted_private_key = Crypt::decryptString($wompiPasarela->private_key);
                } catch (\Exception $e) {
                    Log::warning('Could not decrypt private key: ' . $e->getMessage());
                    $wompiPasarela->decrypted_private_key = '';
                }
            }

            // Obtener confirmaciones de pago recientes
            $confirmaciones = BbbVentaPagoConfirmacion::where('idEmpresa', $idEmpresa)
                ->with(['venta', 'venta.cliente'])
                ->orderBy('fecha_confirmacion', 'desc')
                ->paginate(20);

            return view('admin.pagos.index', compact('pagoConfig', 'wompiPasarela', 'confirmaciones'));
        } catch (\Exception $e) {
            Log::error('Error loading payment configuration: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cargar la configuración de pagos.');
        }
    }

    /**
     * Store or update Wompi configuration.
     */
    public function storeWompi(Request $request)
    {
        Log::info('StoreWompi iniciado', ['request_data' => $request->all()]);
        
        try {
            $idEmpresa = $this->getEmpresaId();
            Log::info('StoreWompi idEmpresa obtenido', ['idEmpresa' => $idEmpresa]);
            
            if (!$idEmpresa) {
                Log::error('StoreWompi: No se pudo identificar la empresa');
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se pudo identificar la empresa.'
                    ], 400);
                }
                return redirect()->back()->with('error', 'No se pudo identificar la empresa.');
            }

            // Obtener o crear la configuración de pagos
            Log::info('StoreWompi: Creando configuración de pagos para empresa', ['idEmpresa' => $idEmpresa]);
            $pagoConfig = BbbEmpresaPago::firstOrCreate(
                ['idEmpresa' => $idEmpresa],
                [
                    'pago_online' => false,
                    'moneda' => 'COP'
                ]
            );

            // 1) Buscar una configuración Wompi existente para ajustar reglas y reutilizar claves si es necesario
            // Buscar si ya existe una pasarela Wompi para ajustar reglas y conservar claves
            $existingWompi = BbbEmpresaPasarela::where('idPagoConfig', $pagoConfig->idPagoConfig)
                ->where('nombre_pasarela', 'Wompi')
                ->first();

            // 2) Validar input del formulario
            //    - Si ya existe configuración Wompi, permitimos private_key vacío para mantener el valor actual.
            $rules = [
                'public_key' => 'required|string|max:255',
                'private_key' => ($existingWompi ? 'nullable' : 'required') . '|string|max:255',
                'events_key' => 'nullable|string|max:255',
                'integrity_key' => 'nullable|string|max:255',
                'sandbox' => 'nullable|boolean',
                'activo' => 'nullable|boolean',
            ];

            $messages = [
                'public_key.required' => 'La llave pública es obligatoria.',
                'private_key.required' => 'La llave privada es obligatoria.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                Log::warning('StoreWompi validación falló', ['errors' => $validator->errors()]);
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => '❌ Llaves inválidas. Verifica tus credenciales en https://wompi.co antes de continuar.',
                        'errors' => $validator->errors(),
                    ], 422);
                }
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // 3) Determinar las llaves a validar contra la API de Wompi
            //    - Si no se envía private_key y existe una configurada, usamos la guardada (desencriptada)
            $publicKeyToValidate = $request->input('public_key');
            $privateKeyToValidate = $request->input('private_key');

            if (!$privateKeyToValidate && $existingWompi && $existingWompi->private_key) {
                try {
                    $privateKeyToValidate = Crypt::decryptString($existingWompi->private_key);
                } catch (\Exception $e) {
                    Log::warning('No se pudo desencriptar la private_key existente para validar: ' . $e->getMessage());
                }
            }

            // 4) Validación remota contra la API de Wompi ANTES de guardar
            //    Detalle técnico:
            //    - GET https://production.wompi.co/v1/merchants/{public_key}
            //    - Header: Authorization: Bearer {private_key}
            //    - 200 con data => llaves válidas. 401/403 => llaves inválidas.
            if (!$publicKeyToValidate || !$privateKeyToValidate) {
                $msg = '❌ Llaves inválidas. Verifica tus credenciales en https://wompi.co antes de continuar.';
                if ($request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => $msg], 400);
                }
                return redirect()->back()->with('error', $msg);
            }

            // Si el usuario marcó sandbox podríamos consultar sandbox, pero el requerimiento pide producción
            $baseUrl = 'https://production.wompi.co/v1';

            try {
                $response = Http::timeout(10)
                    ->withHeaders([
                        'Authorization' => 'Bearer ' . $privateKeyToValidate,
                    ])
                    ->get($baseUrl . '/merchants/' . $publicKeyToValidate);

                if ($response->status() === 200 && !empty($response->json('data'))) {
                    Log::info('Validación Wompi exitosa');
                    // Continúa con el guardado
                } elseif (in_array($response->status(), [401, 403])) {
                    Log::warning('Validación Wompi falló con status ' . $response->status());
                    $msg = '❌ Llaves inválidas. Verifica tus credenciales en https://wompi.co antes de continuar.';
                    if ($request->expectsJson()) {
                        return response()->json(['success' => false, 'message' => $msg], 401);
                    }
                    return redirect()->back()->with('error', $msg);
                } else {
                    Log::warning('Respuesta inesperada de Wompi', ['status' => $response->status(), 'body' => $response->body()]);
                    $msg = '❌ No se pudo validar las llaves en este momento. Intenta nuevamente.';
                    if ($request->expectsJson()) {
                        return response()->json(['success' => false, 'message' => $msg], 502);
                    }
                    return redirect()->back()->with('error', $msg);
                }
            } catch (\Exception $e) {
                Log::error('Error al validar llaves con Wompi: ' . $e->getMessage());
                $msg = '❌ Error de conexión al validar las llaves. Intenta nuevamente.';
                if ($request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => $msg], 500);
                }
                return redirect()->back()->with('error', $msg);
            }

            // 5) Preparar configuración extra para almacenar junto a las llaves
            $extraConfig = [
                'sandbox' => $request->boolean('sandbox'),
            ];

            if ($request->filled('events_key')) {
                $extraConfig['events_key'] = $request->events_key;
            }

            if ($request->filled('integrity_key')) {
                $extraConfig['integrity_key'] = $request->integrity_key;
            }

            // 6) Guardar/actualizar la configuración de Wompi (sin guardar si la validación falló)
            //    Si no se envió private_key y ya existía, conservar la anterior
            $privateKeyToSave = $request->filled('private_key')
                ? Crypt::encryptString($request->private_key)
                : ($existingWompi ? $existingWompi->private_key : null);

            $wompiPasarela = BbbEmpresaPasarela::updateOrCreate(
                [
                    'idPagoConfig' => $pagoConfig->idPagoConfig,
                    'nombre_pasarela' => 'Wompi'
                ],
                [
                    'public_key' => $request->public_key,
                    'private_key' => $privateKeyToSave, // Encriptada o existente
                    'extra_config' => $extraConfig,
                    'activo' => $request->boolean('activo', true),
                ]
            );

            // 7) Si se activa Wompi, activar también pagos online
            if ($wompiPasarela->activo) {
                $pagoConfig->update(['pago_online' => true]);
                Log::info('StoreWompi: Pagos online activados');
            }

            Log::info('StoreWompi: Configuración guardada exitosamente', ['wompiPasarela_id' => $wompiPasarela->idPasarela]);
            
            // 8) Responder acorde: JSON para peticiones AJAX (Axios) o redirect para formularios normales
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => '✅ Pasarela Wompi configurada correctamente.'
                ]);
            }

            return redirect()->route('admin.pagos.index')
                ->with('success', '✅ Pasarela Wompi configurada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error saving Wompi configuration: ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => '❌ Error al guardar la configuración de Wompi.'
                ], 500);
            }
            return redirect()->back()
                ->with('error', '❌ Error al guardar la configuración de Wompi.')
                ->withInput();
        }
    }

    /**
     * Toggle Wompi activation status.
     */
    public function toggleWompi(Request $request)
    {
        try {
            $idEmpresa = $this->getEmpresaId();
            
            if (!$idEmpresa) {
                return response()->json(['error' => 'No se pudo identificar la empresa.'], 400);
            }

            $pagoConfig = BbbEmpresaPago::where('idEmpresa', $idEmpresa)->first();
            
            if (!$pagoConfig) {
                return response()->json(['error' => 'No se encontró la configuración de pagos.'], 404);
            }

            $wompiPasarela = BbbEmpresaPasarela::where('idPagoConfig', $pagoConfig->idPagoConfig)
                ->where('nombre_pasarela', 'Wompi')
                ->first();

            if (!$wompiPasarela) {
                return response()->json(['error' => 'No se encontró la configuración de Wompi.'], 404);
            }

            // Toggle activo
            $wompiPasarela->activo = !$wompiPasarela->activo;
            $wompiPasarela->save();

            // Si se desactiva Wompi, desactivar pagos online
            if (!$wompiPasarela->activo) {
                $pagoConfig->update(['pago_online' => false]);
            } else {
                $pagoConfig->update(['pago_online' => true]);
            }

            return response()->json([
                'success' => true,
                'activo' => $wompiPasarela->activo,
                'message' => $wompiPasarela->activo ? 'Wompi activado exitosamente.' : 'Wompi desactivado exitosamente.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error toggling Wompi: ' . $e->getMessage());
            return response()->json(['error' => 'Error al cambiar el estado de Wompi.'], 500);
        }
    }

    /**
     * Show payment confirmation details.
     */
    public function showConfirmacion($id)
    {
        try {
            $idEmpresa = $this->getEmpresaId();
            
            $confirmacion = BbbVentaPagoConfirmacion::where('idEmpresa', $idEmpresa)
                ->where('idPagoConfirmacion', $id)
                ->with(['venta', 'venta.cliente', 'venta.detalles.producto'])
                ->firstOrFail();

            return view('admin.pagos.confirmacion', compact('confirmacion'));
        } catch (\Exception $e) {
            Log::error('Error loading payment confirmation: ' . $e->getMessage());
            return redirect()->route('admin.pagos.index')
                ->with('error', 'Error al cargar la confirmación de pago.');
        }
    }

    /**
     * Filter payment confirmations.
     */
    public function filterConfirmaciones(Request $request)
    {
        try {
            $idEmpresa = $this->getEmpresaId();
            
            $query = BbbVentaPagoConfirmacion::where('idEmpresa', $idEmpresa)
                ->with(['venta', 'venta.cliente']);

            // Filtrar por estado
            if ($request->filled('estado')) {
                $query->where('estado', $request->estado);
            }

            // Filtrar por fecha
            if ($request->filled('fecha_desde')) {
                $query->whereDate('fecha_confirmacion', '>=', $request->fecha_desde);
            }

            if ($request->filled('fecha_hasta')) {
                $query->whereDate('fecha_confirmacion', '<=', $request->fecha_hasta);
            }

            // Filtrar por referencia
            if ($request->filled('referencia')) {
                $query->where('referencia', 'like', '%' . $request->referencia . '%');
            }

            $confirmaciones = $query->orderBy('fecha_confirmacion', 'desc')
                ->paginate(20)
                ->appends($request->all());

            // Obtener configuración para la vista
            $pagoConfig = BbbEmpresaPago::where('idEmpresa', $idEmpresa)->first();
            $wompiPasarela = $pagoConfig ? $pagoConfig->wompiPasarela : null;

            return view('admin.pagos.index', compact('pagoConfig', 'wompiPasarela', 'confirmaciones'));
        } catch (\Exception $e) {
            Log::error('Error filtering payment confirmations: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al filtrar confirmaciones de pago.');
        }
    }

    /**
     * Get the empresa ID for the authenticated user.
     * Ajusta este método según tu lógica de autenticación.
     */
    private function getEmpresaId()
    {
        // Opción 1: Si el usuario tiene una relación directa con empresa
        if (Auth::check() && Auth::user()->idEmpresa) {
            return Auth::user()->idEmpresa;
        }

        // Opción 2: Si hay una empresa en sesión
        if (session()->has('empresa_id')) {
            return session('empresa_id');
        }

        // Opción 3: Si hay una empresa por defecto en el request
        if (request()->has('empresa_id')) {
            return request('empresa_id');
        }

        // Opción 4: Obtener la primera empresa (para testing)
        $empresa = BbbEmpresa::first();
        return $empresa ? $empresa->idEmpresa : null;
    }
}
