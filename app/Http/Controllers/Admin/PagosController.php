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
            $validator = Validator::make($request->all(), [
                'public_key' => 'required|string|max:255',
                'private_key' => 'required|string|max:255',
                'events_key' => 'nullable|string|max:255',
                'integrity_key' => 'nullable|string|max:255',
                'sandbox' => 'nullable|boolean',
                'activo' => 'nullable|boolean',
            ], [
                'public_key.required' => 'La llave pública es obligatoria.',
                'private_key.required' => 'La llave privada es obligatoria.',
            ]);

            if ($validator->fails()) {
                Log::warning('StoreWompi validación falló', ['errors' => $validator->errors()]);
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $idEmpresa = $this->getEmpresaId();
            Log::info('StoreWompi idEmpresa obtenido', ['idEmpresa' => $idEmpresa]);
            
            if (!$idEmpresa) {
                Log::error('StoreWompi: No se pudo identificar la empresa');
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

            // Preparar configuración extra
            $extraConfig = [
                'sandbox' => $request->boolean('sandbox'),
            ];

            if ($request->filled('events_key')) {
                $extraConfig['events_key'] = $request->events_key;
            }

            if ($request->filled('integrity_key')) {
                $extraConfig['integrity_key'] = $request->integrity_key;
            }

            // Obtener o crear la pasarela Wompi
            $wompiPasarela = BbbEmpresaPasarela::updateOrCreate(
                [
                    'idPagoConfig' => $pagoConfig->idPagoConfig,
                    'nombre_pasarela' => 'Wompi'
                ],
                [
                    'public_key' => $request->public_key,
                    'private_key' => Crypt::encryptString($request->private_key), // Encriptar la llave privada
                    'extra_config' => $extraConfig,
                    'activo' => $request->boolean('activo', true),
                ]
            );

            // Si se activa Wompi, activar también pagos online
            if ($wompiPasarela->activo) {
                $pagoConfig->update(['pago_online' => true]);
                Log::info('StoreWompi: Pagos online activados');
            }

            Log::info('StoreWompi: Configuración guardada exitosamente', ['wompiPasarela_id' => $wompiPasarela->idPasarela]);
            
            return redirect()->route('admin.pagos.index')
                ->with('success', 'Configuración de Wompi guardada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error saving Wompi configuration: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al guardar la configuración de Wompi.')
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
