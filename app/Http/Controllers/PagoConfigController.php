<?php

namespace App\Http\Controllers;

use App\Http\Requests\PagoConfigRequest;
use App\Http\Requests\PasarelaRequest;
use App\Models\BbbEmpresaPagos;
use App\Models\BbbEmpresaPasarela;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagoConfigController extends Controller
{
    /**
     * Display the payment configuration.
     */
    public function index()
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return redirect()->route('admin.profile.edit')
                           ->with('error', 'Primero debes completar la información de tu empresa.');
        }

        // Obtener o crear configuración de pagos
        $configuracionPagos = BbbEmpresaPagos::firstOrCreate(
            ['idEmpresa' => $empresa->idEmpresa],
            [
                'pago_online' => false,
                'moneda' => 'COP'
            ]
        );

        $configuracionPagos->load(['pasarelas']);

        return view('pagos.index', compact('configuracionPagos', 'empresa'));
    }

    /**
     * Update payment configuration.
     */
    public function updateConfig(PagoConfigRequest $request)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return redirect()->route('admin.profile.edit')
                           ->with('error', 'Primero debes completar la información de tu empresa.');
        }

        $configuracionPagos = BbbEmpresaPagos::where('idEmpresa', $empresa->idEmpresa)->first();

        if (!$configuracionPagos) {
            $configuracionPagos = BbbEmpresaPagos::create([
                'idEmpresa' => $empresa->idEmpresa,
                'pago_online' => $request->pago_online ?? false,
                'moneda' => $request->moneda ?? 'COP'
            ]);
        } else {
            $configuracionPagos->update($request->validated());
        }

        return redirect()->route('admin.pagos.index')
                        ->with('success', 'Configuración de pagos actualizada exitosamente.');
    }

    /**
     * Show the form for creating a new pasarela.
     */
    public function createPasarela()
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return redirect()->route('admin.profile.edit')
                           ->with('error', 'Primero debes completar la información de tu empresa.');
        }

        $configuracionPagos = BbbEmpresaPagos::where('idEmpresa', $empresa->idEmpresa)->first();

        if (!$configuracionPagos) {
            return redirect()->route('admin.pagos.index')
                           ->with('error', 'Primero debes configurar los pagos básicos.');
        }

        $pasarelasDisponibles = [
            'wompi' => 'Wompi',
            'payu' => 'PayU',
            'stripe' => 'Stripe',
            'mercadopago' => 'MercadoPago',
            'paypal' => 'PayPal'
        ];

        return view('pagos.create-pasarela', compact('configuracionPagos', 'empresa', 'pasarelasDisponibles'));
    }

    /**
     * Store a newly created pasarela.
     */
    public function storePasarela(PasarelaRequest $request)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return redirect()->route('admin.profile.edit')
                           ->with('error', 'Primero debes completar la información de tu empresa.');
        }

        $configuracionPagos = BbbEmpresaPagos::where('idEmpresa', $empresa->idEmpresa)->first();

        if (!$configuracionPagos) {
            return redirect()->route('admin.pagos.index')
                           ->with('error', 'Primero debes configurar los pagos básicos.');
        }

        $data = $request->validated();
        $data['idPagoConfig'] = $configuracionPagos->idPagoConfig;

        // Procesar configuración extra según la pasarela
        $extraConfig = [];
        
        if ($data['nombre_pasarela'] === 'wompi') {
            $extraConfig['sandbox'] = $request->boolean('sandbox', false);
            $extraConfig['webhook_url'] = $request->webhook_url;
        }

        $data['extra_config'] = $extraConfig;

        BbbEmpresaPasarela::create($data);

        return redirect()->route('admin.pagos.index')
                        ->with('success', 'Pasarela de pago configurada exitosamente.');
    }

    /**
     * Show the form for editing the specified pasarela.
     */
    public function editPasarela(BbbEmpresaPasarela $pasarela)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        // Verificar que la pasarela pertenezca a la empresa del usuario
        if ($pasarela->pagoConfig->idEmpresa !== $empresa->idEmpresa) {
            abort(403, 'No tienes permiso para editar esta pasarela.');
        }

        $pasarelasDisponibles = [
            'wompi' => 'Wompi',
            'payu' => 'PayU',
            'stripe' => 'Stripe',
            'mercadopago' => 'MercadoPago',
            'paypal' => 'PayPal'
        ];

        return view('pagos.edit-pasarela', compact('pasarela', 'empresa', 'pasarelasDisponibles'));
    }

    /**
     * Update the specified pasarela.
     */
    public function updatePasarela(PasarelaRequest $request, BbbEmpresaPasarela $pasarela)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        // Verificar que la pasarela pertenezca a la empresa del usuario
        if ($pasarela->pagoConfig->idEmpresa !== $empresa->idEmpresa) {
            abort(403, 'No tienes permiso para editar esta pasarela.');
        }

        $data = $request->validated();

        // Procesar configuración extra según la pasarela
        $extraConfig = $pasarela->extra_config ?? [];
        
        if ($data['nombre_pasarela'] === 'wompi') {
            $extraConfig['sandbox'] = $request->boolean('sandbox', false);
            $extraConfig['webhook_url'] = $request->webhook_url;
        }

        $data['extra_config'] = $extraConfig;

        $pasarela->update($data);

        return redirect()->route('admin.pagos.index')
                        ->with('success', 'Pasarela de pago actualizada exitosamente.');
    }

    /**
     * Toggle pasarela status.
     */
    public function togglePasarela(BbbEmpresaPasarela $pasarela)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        // Verificar que la pasarela pertenezca a la empresa del usuario
        if ($pasarela->pagoConfig->idEmpresa !== $empresa->idEmpresa) {
            abort(403, 'No tienes permiso para editar esta pasarela.');
        }

        $pasarela->update(['activo' => !$pasarela->activo]);

        $status = $pasarela->activo ? 'activada' : 'desactivada';
        
        return redirect()->route('admin.pagos.index')
                        ->with('success', "Pasarela {$status} exitosamente.");
    }

    /**
     * Remove the specified pasarela.
     */
    public function destroyPasarela(BbbEmpresaPasarela $pasarela)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        // Verificar que la pasarela pertenezca a la empresa del usuario
        if ($pasarela->pagoConfig->idEmpresa !== $empresa->idEmpresa) {
            abort(403, 'No tienes permiso para eliminar esta pasarela.');
        }

        $pasarela->delete();

        return redirect()->route('admin.pagos.index')
                        ->with('success', 'Pasarela de pago eliminada exitosamente.');
    }

    /**
     * Test pasarela connection.
     */
    public function testPasarela(BbbEmpresaPasarela $pasarela)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        // Verificar que la pasarela pertenezca a la empresa del usuario
        if ($pasarela->pagoConfig->idEmpresa !== $empresa->idEmpresa) {
            abort(403, 'No tienes permiso para probar esta pasarela.');
        }

        // Aquí implementarías la lógica específica para probar cada pasarela
        $testResult = $this->performPasarelaTest($pasarela);

        return response()->json([
            'success' => $testResult['success'],
            'message' => $testResult['message']
        ]);
    }

    /**
     * Perform specific pasarela test.
     */
    private function performPasarelaTest(BbbEmpresaPasarela $pasarela)
    {
        switch ($pasarela->nombre_pasarela) {
            case 'wompi':
                return $this->testWompi($pasarela);
            case 'payu':
                return $this->testPayU($pasarela);
            default:
                return [
                    'success' => true,
                    'message' => 'Configuración guardada correctamente. Prueba manual requerida.'
                ];
        }
    }

    /**
     * Test Wompi connection.
     */
    private function testWompi(BbbEmpresaPasarela $pasarela)
    {
        try {
            $baseUrl = $pasarela->isSandbox() 
                ? 'https://sandbox.wompi.co/v1' 
                : 'https://production.wompi.co/v1';

            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . $pasarela->public_key
            ])->get($baseUrl . '/merchants/' . $pasarela->public_key);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Conexión con Wompi establecida correctamente.'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al conectar con Wompi: ' . $response->body()
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al probar la conexión: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Test PayU connection.
     */
    private function testPayU(BbbEmpresaPasarela $pasarela)
    {
        // Implementar test específico para PayU
        return [
            'success' => true,
            'message' => 'Configuración de PayU guardada. Verificación manual recomendada.'
        ];
    }
}