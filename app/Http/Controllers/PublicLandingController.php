<?php

namespace App\Http\Controllers;

use App\Models\BbbEmpresa;
use App\Models\BbbLanding;
use App\Models\BbbProducto;
use App\Models\BbbEmpresaPagos;
use App\Models\BbbEmpresaPasarela;
use App\Models\BbbCliente;
use App\Models\BbbVentaOnline;
use App\Models\BbbVentaOnlineDetalle;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class PublicLandingController extends Controller
{
    /**
     * Display the landing page for a specific company slug.
     */
    public function showLanding(Request $request, string $slug): View|Response
    {
        // Find the company by slug
        $empresa = BbbEmpresa::where('slug', $slug)->first();
        if (!$empresa) {
            abort(404, 'Landing page not found');
        }

        // Check the landing status
        $estadoLanding = $empresa->estado ?? 'sin_configurar';
        
        // Handle different states
        switch ($estadoLanding) {
            case 'en_construccion':
                return $this->showConstructionPage($empresa);
            
            case 'vencida':
                return $this->showExpiredPage($empresa);
            
            case 'publicada':
                break; // Continue to show the landing
            
            case 'sin_configurar':
            default:
                return $this->showBasicLanding($empresa);
        }

        // Get the landing configuration for published state
        $landing = $empresa->landing;
        
        if (!$landing) {
            return $this->showBasicLanding($empresa);
        }

        // Load media relations
        $landing->load(['media', 'images', 'icons']);

        // Count active products
        $productosActivos = BbbProducto::where('idEmpresa', $empresa->idEmpresa)
        ->where('estado', 'activo')
        ->count();

        // Check if custom view exists
        $customViewPath = 'landings.' . $slug . '.index';
        
        if (view()->exists($customViewPath)) {
            // Use custom view if it exists
            return view($customViewPath, compact('empresa', 'landing', 'productosActivos'));
        }

        // Fallback to default landing view
        return view('public.landing', compact('empresa', 'landing', 'productosActivos'));
    }

    /**
     * Show a basic landing page when no configuration exists.
     */
    private function showBasicLanding(BbbEmpresa $empresa): View
    {
        // Create a basic landing object with company info
        $landing = new BbbLanding([
            'titulo_principal' => $empresa->nombre,
            'descripcion' => 'Bienvenido a ' . $empresa->nombre,
            'color_principal' => '#007bff',
            'color_secundario' => '#6c757d',
            'tipografia' => 'Inter'
        ]);
        
        // Set empty relations to avoid errors
        $landing->setRelation('media', collect());
        $landing->setRelation('images', collect());
        $landing->setRelation('icons', collect());

        return view('public.basic-landing', compact('empresa', 'landing'));
    }

    /**
     * Show construction page when landing is being configured.
     */
    private function showConstructionPage(BbbEmpresa $empresa): View
    {
        return view('public.construction', compact('empresa'));
    }

    /**
     * Show expired page when landing has expired.
     */
    private function showExpiredPage(BbbEmpresa $empresa): View
    {
        return view('public.expired', compact('empresa'));
    }

    /**
     * Get company info API endpoint (optional for AJAX calls).
     */
    public function getCompanyInfo(string $slug)
    {
        $empresa = BbbEmpresa::where('slug', $slug)
            ->with(['landing', 'landing.media'])
            ->first();
        
        if (!$empresa) {
            return response()->json(['error' => 'Company not found'], 404);
        }

        return response()->json([
            'empresa' => [
                'nombre' => $empresa->nombre,
                'email' => $empresa->email,
                'movil' => $empresa->movil,
                'direccion' => $empresa->direccion,
                'website' => $empresa->website,
                'facebook' => $empresa->facebook,
                'instagram' => $empresa->instagram,
                'linkedin' => $empresa->linkedin,
                'twitter' => $empresa->twitter,
                'tiktok' => $empresa->tiktok,
                'youtube' => $empresa->youtube,
                'whatsapp' => $empresa->whatsapp,
            ],
            'landing' => $empresa->landing ? [
                'titulo_principal' => $empresa->landing->titulo_principal,
                'subtitulo' => $empresa->landing->subtitulo,
                'descripcion' => $empresa->landing->descripcion,
                'objetivo' => $empresa->landing->objetivo,
                'descripcion_objetivo' => $empresa->landing->descripcion_objetivo,
                'audiencia_descripcion' => $empresa->landing->audiencia_descripcion,
                'audiencia_problemas' => $empresa->landing->audiencia_problemas,
                'audiencia_beneficios' => $empresa->landing->audiencia_beneficios,
                'color_principal' => $empresa->landing->color_principal,
                'color_secundario' => $empresa->landing->color_secundario,
                'estilo' => $empresa->landing->estilo,
                'tipografia' => $empresa->landing->tipografia,
                'logo_url' => $empresa->landing->logo_url ? asset('storage/' . $empresa->landing->logo_url) : null,
                'media' => $empresa->landing->media->map(function($media) {
                    return [
                        'tipo' => $media->tipo,
                        'url' => asset('storage/' . $media->url),
                        'descripcion' => $media->descripcion
                    ];
                })
            ] : null
        ]);
    }

    /**
     * Display the tienda virtual for a specific company slug.
     */
    public function showTienda(Request $request, string $slug): View|Response
    {
        // Find the company by slug
        $empresa = BbbEmpresa::where('slug', $slug)->first();
        
        if (!$empresa) {
            abort(404, 'Tienda not found');
        }

        // Check if the company has active products
        $productosActivos = BbbProducto::where('idEmpresa', $empresa->idEmpresa)
            ->where('estado', 'activo')
            ->count();
        
        $productos = BbbProducto::where('idEmpresa', $empresa->idEmpresa)
        ->where('estado', 'activo')
        ->with(['imagenes' => function($query) {
            $query->ordered();
        }])
        ->get();

        // Get the landing configuration if available
        $landing = $empresa->landing;

        // Check if the company has payment gateway configured
        $tieneCarrito = $this->checkPaymentGatewayConfiguration($empresa->idEmpresa);

        return view('public.tienda', compact('empresa', 'productos', 'productosActivos', 'landing', 'tieneCarrito'));
    }

    /**
     * Check if the company has payment gateway configured
     */
    private function checkPaymentGatewayConfiguration($idEmpresa): bool
    {
        // Check if company has online payment enabled
        $pagoOnline = BbbEmpresaPagos::where('idEmpresa', $idEmpresa)
            ->where('pago_online', true)
            ->first();

        if (!$pagoOnline) {
            return false;
        }

        // Check if company has Wompi gateway configured
        $pasarela = BbbEmpresaPasarela::where('idPagoConfig', $pagoOnline->idPagoConfig)
            ->where('nombre_pasarela', 'Wompi')
            ->where('activo', true)
            ->first();

        return $pasarela !== null;
    }

    /**
     * Show checkout page
     */
    public function showCheckout(Request $request, string $slug): View|RedirectResponse
    {
        $empresa = BbbEmpresa::where('slug', $slug)->first();
        
        if (!$empresa) {
            abort(404, 'Tienda not found');
        }

        // Verificar que la empresa tenga pasarela configurada
        $tieneCarrito = $this->checkPaymentGatewayConfiguration($empresa->idEmpresa);

        if (!$tieneCarrito) {
            return redirect()->route('public.tienda', $slug)
                ->with('error', 'Esta tienda no tiene habilitado el pago en línea.');
        }

        $landing = $empresa->landing;

        return view('public.checkout', compact('empresa', 'landing'));
    }

    /**
     * Add API routes for cart management (if needed)
     */
    public function addToCart(Request $request, string $slug)
    {
        // This method can be used for AJAX cart operations if needed
        $empresa = BbbEmpresa::where('slug', $slug)->first();
        
        if (!$empresa) {
            return response()->json(['error' => 'Tienda not found'], 404);
        }

        // Verify payment gateway is configured
        $tieneCarrito = $this->checkPaymentGatewayConfiguration($empresa->idEmpresa);
        
        if (!$tieneCarrito) {
            return response()->json(['error' => 'Carrito no disponible'], 400);
        }

        // Cart operations are handled client-side with localStorage
        return response()->json(['success' => true]);
    }

    /**
     * Process checkout with BbbCliente integration and Wompi payment for online store
     */
    public function processCheckout(Request $request, string $slug)
    {
        try {
            $empresa = BbbEmpresa::where('slug', $slug)->first();
            
            if (!$empresa) {
                return back()->withErrors(['error' => 'Tienda no encontrada'])->withInput();
            }

            // Verify payment gateway is configured
            $tieneCarrito = $this->checkPaymentGatewayConfiguration($empresa->idEmpresa);
            
            if (!$tieneCarrito) {
                return back()->withErrors(['error' => 'Pago en línea no disponible para esta tienda'])->withInput();
            }

            // Validate request data using BbbCliente fields and cart items
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'documento' => 'required|string|max:50',
                'telefono' => 'required|string|max:20',
                'direccion' => 'nullable|string|max:500',
                'items' => 'required|array|min:1',
                'items.*.id' => 'required|exists:bbbproductos,idProducto',
                'items.*.cantidad' => 'required|integer|min:1',
                'items.*.precio' => 'required|numeric|min:0',
                'total' => 'required|numeric|min:0',
                'terms' => 'required|accepted'
            ], [
                'nombre.required' => 'El nombre completo es requerido',
                'email.required' => 'El correo electrónico es requerido',
                'email.email' => 'El formato del correo electrónico no es válido',
                'documento.required' => 'El documento de identidad es requerido',
                'telefono.required' => 'El teléfono es requerido',
                'direccion.max' => 'La dirección no puede exceder 500 caracteres',
                'items.required' => 'Debe agregar al menos un producto al carrito',
                'items.min' => 'Debe agregar al menos un producto al carrito',
                'total.required' => 'El total es requerido',
                'terms.required' => 'Debe aceptar los términos y condiciones',
                'terms.accepted' => 'Debe aceptar los términos y condiciones'
            ]);

            // Create or update BbbCliente
            $cliente = BbbCliente::updateOrCreate(
                [
                    'email' => $validatedData['email'],
                    'idEmpresa' => $empresa->idEmpresa
                ],
                [
                    'nombre' => $validatedData['nombre'],
                    'documento' => $validatedData['documento'],
                    'telefono' => $validatedData['telefono'],
                    'direccion' => $validatedData['direccion'] ?? null,
                    'estado' => 'activo'
                ]
            );

            // Calculate shipping cost
            $totalEnvio = $empresa->flete ?? 0;
            
            // Create BbbVentaOnline record
            $venta = BbbVentaOnline::create([
                'idEmpresa' => $empresa->idEmpresa,
                'idCliente' => $cliente->idCliente,
                'total' => $validatedData['total'],
                'totalEnvio' => $totalEnvio,
                'estado' => 'pendiente',
                'metodo_pago' => 'wompi'
            ]);

            // Create BbbVentaOnlineDetalle records for each item
            foreach ($validatedData['items'] as $item) {
                BbbVentaOnlineDetalle::create([
                    'idVenta' => $venta->idVenta,
                    'idProducto' => $item['id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'subtotal' => $item['precio'] * $item['cantidad']
                ]);
            }

            // Calculate amount in cents
            $amountInCents = $validatedData['total'] * 100;

            // Generate unique reference
            $reference = 'BBB_STORE_' . $empresa->idEmpresa . '_' . $venta->idVenta . '_' . time();

            // MODO PRUEBA: Si el email es nelsonmon1699@gmail.com, completar venta automáticamente
            if ($validatedData['email'] === 'nelsonmon1699@gmail.com') {
                Log::info('MODO PRUEBA: Completando venta automáticamente', ['venta_id' => $venta->idVenta]);
                
                // Actualizar venta como completada
                $venta->update([
                    'estado' => 'completado',
                    'metodo_pago' => 'prueba_automatica',
                    'observaciones' => json_encode([
                        'modo' => 'prueba_automatica',
                        'referencia_prueba' => $reference,
                        'fecha_pago' => now(),
                        'customer_data' => [
                            'nombre' => $validatedData['nombre'],
                            'documento' => $validatedData['documento'],
                            'telefono' => $validatedData['telefono']
                        ]
                    ])
                ]);

                // Redirigir directamente a página de éxito
                return redirect()->route('public.payment.success', $empresa->slug)
                    ->with('venta_id', $venta->idVenta)
                    ->with('test_mode', true);
            }

            // Flujo normal con Wompi
            // Get Wompi configuration
            $pasarela = $this->getWompiConfiguration($empresa->idEmpresa);
            if (!$pasarela) {
                return back()->withErrors(['error' => 'Configuración de pagos no disponible'])->withInput();
            }

            // Create Wompi transaction
            $checkoutUrl = $this->createWompiTransaction([
                'amount_in_cents' => $amountInCents,
                'currency' => 'COP', // Assuming COP for store purchases
                'reference' => $reference,
                'customer_email' => $validatedData['email'],
                'customer_name' => $validatedData['nombre'],
                'customer_phone' => $validatedData['telefono'],
                'customer_document' => $validatedData['documento'],
                'redirect_url' => route('public.payment.success', $empresa->slug),
                'venta_id' => $venta->idVenta
            ], $pasarela);

            if (!$checkoutUrl) {
                return back()->withErrors(['error' => 'Error al crear la transacción de pago. Inténtelo de nuevo.'])->withInput();
            }

            // Update venta with Wompi reference and processing status
            $venta->update([
                'observaciones' => json_encode([
                    'wompi_reference' => $reference,
                    'customer_data' => [
                        'nombre' => $validatedData['nombre'],
                        'documento' => $validatedData['documento'],
                        'telefono' => $validatedData['telefono']
                    ]
                ]),
                'estado' => 'procesando'
            ]);

            // Redirect to Wompi checkout
            return redirect($checkoutUrl);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error in processCheckout: ' . $e->getMessage(), [
                'slug' => $slug,
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors(['error' => 'Ocurrió un error inesperado. Por favor, inténtelo de nuevo.'])->withInput();
        }
    }

    /**
     * Get Wompi configuration for the empresa
     */
    private function getWompiConfiguration($idEmpresa)
    {
        $pagoOnline = BbbEmpresaPagos::where('idEmpresa', $idEmpresa)
            ->where('pago_online', true)
            ->first();

        if (!$pagoOnline) {
            return null;
        }

        $pasarela = BbbEmpresaPasarela::where('idPagoConfig', $pagoOnline->idPagoConfig)
            ->where('nombre_pasarela', 'Wompi')
            ->where('activo', true)
            ->first();

        if (!$pasarela) {
            return null;
        }

        return $pasarela;
    }

    /**
     * Create Wompi transaction and return checkout URL
     */
    private function createWompiTransaction($data, BbbEmpresaPasarela $pasarela)
    {
        try {
            // Generate integrity signature using the pasarela's integrity key
            $integrityKey = $pasarela->getIntegrityKey();
            if (!$integrityKey) {
                Log::error('No integrity key found for pasarela', ['pasarela_id' => $pasarela->idPasarela]);
                return null;
            }

            $integritySignature = hash('sha256', 
                $data['reference'] . 
                $data['amount_in_cents'] . 
                $data['currency'] . 
                $integrityKey
            );

            // Prepare checkout URL with parameters using the pasarela configuration
            $checkoutParams = http_build_query([
                'public-key' => $pasarela->public_key,
                'currency' => $data['currency'],
                'amount-in-cents' => $data['amount_in_cents'],
                'reference' => $data['reference'],
                'signature:integrity' => $integritySignature,
                'customer-data:email' => $data['customer_email'],
                'customer-data:full-name' => $data['customer_name'],
                'customer-data:phone-number' => $data['customer_phone'],
                'customer-data:legal-id' => $data['customer_document'],
                'customer-data:legal-id-type' => 'CC',
                'redirect-url' => $data['redirect_url'],
            ]);

            // Use the pasarela's checkout URL method
            $checkoutUrl = $pasarela->getCheckoutUrl() . '?' . $checkoutParams;

            return $checkoutUrl;

        } catch (\Exception $e) {
            Log::error('Error creating Wompi transaction: ' . $e->getMessage(), [
                'data' => $data,
                'pasarela_id' => $pasarela->idPasarela,
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Check if a slug is available.
     */
    public function checkSlugAvailability(Request $request)
    {
        $slug = $request->get('slug');
        
        if (!$slug) {
            return response()->json(['available' => false, 'message' => 'Slug is required']);
        }

        $exists = BbbEmpresa::where('slug', $slug)->exists();
        
        return response()->json([
            'available' => !$exists,
            'slug' => $slug,
            'message' => $exists ? 'This slug is already taken' : 'Slug is available'
        ]);
    }

    /**
     * Handle payment success from Wompi or test mode
     */
    public function paymentSuccess(Request $request, string $slug)
    {
        $empresa = BbbEmpresa::where('slug', $slug)->first();
        
        if (!$empresa) {
            abort(404, 'Tienda no encontrada');
        }

        $venta = null;
        $testMode = $request->session()->get('test_mode', false);
        
        // Modo de prueba - buscar venta por ID de sesión
        if ($testMode && $request->session()->has('venta_id')) {
            $ventaId = $request->session()->get('venta_id');
            $venta = BbbVentaOnline::where('idVenta', $ventaId)
                ->where('idEmpresa', $empresa->idEmpresa)
                ->first();
                
            Log::info('MODO PRUEBA: Redirigiendo a tienda con datos de venta', [
                'venta_id' => $ventaId,
                'venta_found' => $venta ? true : false
            ]);
        } 
        // Flujo normal de Wompi
        else {
            // Get transaction details from Wompi callback
            $transactionId = $request->get('id');
            $reference = $request->get('reference');

            if ($reference) {
                // Find venta by reference in observaciones
                $venta = BbbVentaOnline::where('observaciones', 'like', '%"wompi_reference":"' . $reference . '"%')->first();
                if ($venta) {
                    $observaciones = json_decode($venta->observaciones, true) ?? [];
                    $observaciones['wompi_transaction_id'] = $transactionId;
                    $observaciones['fecha_pago'] = now();
                    
                    $venta->update([
                        'estado' => 'completado',
                        'observaciones' => json_encode($observaciones)
                    ]);
                }
            }
        }

        // Redirigir a la tienda con datos de la transacción
        return redirect()->route('public.tienda', $slug)
            ->with('payment_success', true)
            ->with('venta_data', $venta ? [
                'id' => $venta->idVenta,
                'total' => $venta->total,
                'estado' => $venta->estado,
                'metodo_pago' => $venta->metodo_pago,
                'cliente' => [
                    'nombre' => $venta->cliente->nombre ?? 'N/A',
                    'email' => $venta->cliente->email ?? 'N/A'
                ],
                'test_mode' => $testMode
            ] : null);
    }

    /**
     * Handle payment error from Wompi
     */
    public function paymentError(Request $request, string $slug)
    {
        $empresa = BbbEmpresa::where('slug', $slug)->first();
        
        if (!$empresa) {
            abort(404, 'Tienda no encontrada');
        }

        // Get transaction details from Wompi callback
        $reference = $request->get('reference');
        $venta = null;

        if ($reference) {
            // Find venta by reference in observaciones
            $venta = BbbVentaOnline::where('observaciones', 'like', '%"wompi_reference":"' . $reference . '"%')->first();
            if ($venta) {
                $venta->update(['estado' => 'fallido']);
            }
        }

        // Redirigir a la tienda con error de pago
        return redirect()->route('public.tienda', $slug)
            ->with('payment_error', true)
            ->with('error_message', 'El pago no pudo ser procesado. Por favor, inténtalo de nuevo.')
            ->with('venta_data', $venta ? [
                'id' => $venta->idVenta,
                'total' => $venta->total,
                'estado' => 'fallido'
            ] : null);
    }
}