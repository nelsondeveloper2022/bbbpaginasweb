<?php

namespace App\Http\Controllers;

use App\Http\Requests\VentaRequest;
use App\Models\BbbVentaOnline;
use App\Models\BbbVentaOnlineDetalle;
use App\Models\BbbProducto;
use App\Models\BbbCliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VentaController extends Controller
{
    /**
     * Display a listing of the ventas.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return redirect()->route('admin.profile.edit')
                           ->with('error', 'Primero debes completar la información de tu empresa.');
        }

                // Estadísticas
        $stats = $this->getVentasStats($empresa->idEmpresa, new Request());

        return view('ventas.index', compact('empresa', 'stats'));
    }

    /**
     * Get data for DataTable
     */
    public function getData(Request $request)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return response()->json(['error' => 'No se encontró la empresa'], 404);
        }

        $query = BbbVentaOnline::forEmpresa($empresa->idEmpresa)
                              ->with(['cliente', 'detalles.producto']);

        // Filtros
        if ($request->filled('buscar')) {
            $search = $request->buscar;
            $query->where(function($q) use ($search) {
                $q->where('idVenta', 'like', "%{$search}%")
                  ->orWhere('observaciones', 'like', "%{$search}%")
                  ->orWhereHas('cliente', function ($subQ) use ($search) {
                      $subQ->where('nombre', 'like', "%{$search}%")
                           ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha', '<=', $request->fecha_hasta);
        }

        $ventas = $query->orderBy('fecha', 'desc')->get();

        // Formatear datos para DataTable
        $data = $ventas->map(function ($venta) {
            return [
                'idVenta' => $venta->idVenta,
                'cliente' => $venta->cliente ? [
                    'nombre' => $venta->cliente->nombre,
                    'email' => $venta->cliente->email
                ] : null,
                'fecha' => $venta->fecha->format('d/m/Y H:i'),
                'productos_info' => $this->formatProductosInfo($venta),
                'total_formateado' => '$' . number_format($venta->total ?? 0, 0, ',', '.'),
                'estado' => $venta->estado,
                'estado_badge' => $this->getEstadoBadge($venta->estado),
                'metodo_pago' => $venta->metodo_pago,
                'metodo_pago_badge' => $this->getMetodoPagoBadge($venta->metodo_pago),
                'observaciones' => $venta->observaciones
            ];
        });

        return response()->json(['data' => $data]);
    }

    /**
     * Show the form for creating a new venta.
     */
    public function create()
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return redirect()->route('admin.profile.edit')
                           ->with('error', 'Primero debes completar la información de tu empresa.');
        }

        $productos = BbbProducto::forEmpresa($empresa->idEmpresa)
                               ->active()
                               ->orderBy('nombre')
                               ->get();

        // Solo cargar algunos clientes para la carga inicial, el resto se carga via AJAX
        $clientes = BbbCliente::forEmpresa($empresa->idEmpresa)
                             ->active()
                             ->orderBy('nombre')
                             ->limit(10)
                             ->get();

        return view('ventas.create', compact('empresa', 'productos', 'clientes'));
    }

    /**
     * Search clientes for AJAX requests
     */
    public function searchClientes(Request $request)
    {
        try {
            $user = Auth::user();
            $empresa = $user->empresa;

            if (!$empresa) {
                return response()->json(['error' => 'Empresa no encontrada'], 404);
            }

            $search = trim($request->get('search', ''));
            
            // Si no hay término de búsqueda, devolver array vacío
            if (empty($search)) {
                return response()->json([]);
            }

            $query = BbbCliente::forEmpresa($empresa->idEmpresa);
            
            // Solo filtrar por activos si tienen estado definido
            $query->where(function($q) {
                $q->where('estado', 'activo')
                  ->orWhereNull('estado');
            });
            
            // Aplicar búsqueda
            $query->search($search);
            
            $clientes = $query->orderBy('nombre')
                             ->limit(20)
                             ->get(['idCliente', 'nombre', 'email', 'documento']);

            return response()->json($clientes);

        } catch (\Exception $e) {
            Log::error('Error searching clientes: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    /**
     * Search productos for AJAX requests
     */
    public function searchProductos(Request $request)
    {
        try {
            $user = Auth::user();
            $empresa = $user->empresa;

            if (!$empresa) {
                return response()->json(['error' => 'Empresa no encontrada'], 404);
            }

            $search = trim($request->get('search', ''));
            
            // Query base con empresa y estado activo
            $query = BbbProducto::forEmpresa($empresa->idEmpresa)->active();
            
            // Aplicar búsqueda si hay término
            if (!empty($search)) {
                $query->search($search);
            }
            
            $productos = $query->orderBy('nombre')
                             ->limit(20)
                             ->get(['idProducto', 'nombre', 'referencia', 'descripcion', 'precio', 'stock']);

            return response()->json($productos);

        } catch (\Exception $e) {
            Log::error('Error searching productos: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    /**
     * Store a newly created venta in storage.
     */
    public function store(VentaRequest $request)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return redirect()->route('admin.profile.edit')
                           ->with('error', 'Primero debes completar la información de tu empresa.');
        }

        try {
            DB::beginTransaction();

            $data = $request->validated();
            
            // Primero calcular el total y verificar stock
            $total = 0;
            $productosValidados = [];
            
            foreach ($data['productos'] as $productoData) {
                $producto = BbbProducto::findOrFail($productoData['idProducto']);
                
                // Verificar que el producto pertenece a la empresa
                if ($producto->idEmpresa !== $empresa->idEmpresa) {
                    throw new \Exception("El producto '{$producto->nombre}' no pertenece a tu empresa.");
                }
                
                // Verificar stock
                if ($producto->stock < $productoData['cantidad']) {
                    throw new \Exception("No hay suficiente stock para el producto: {$producto->nombre}. Stock disponible: {$producto->stock}");
                }

                $subtotal = $productoData['cantidad'] * $producto->precio;
                $total += $subtotal;
                
                $productosValidados[] = [
                    'producto' => $producto,
                    'cantidad' => $productoData['cantidad'],
                    'precio_unitario' => $producto->precio,
                    'subtotal' => $subtotal
                ];
            }

            // Obtener costo de envío del request y agregarlo al total
            $totalEnvio = (float)($data['totalEnvio'] ?? 0);
            $totalFinal = $total + $totalEnvio;

            // Crear la venta con el total calculado
            $venta = BbbVentaOnline::create([
                'idEmpresa' => $empresa->idEmpresa,
                'idCliente' => $data['idCliente'],
                'fecha' => now(),
                'total' => $totalFinal,
                'totalEnvio' => $totalEnvio,
                'estado' => $data['estado'],
                'metodo_pago' => $data['metodo_pago'] ?? null,
                'observaciones' => $data['observaciones'] ?? null
            ]);

            // Crear los detalles y actualizar stock
            foreach ($productosValidados as $item) {
                BbbVentaOnlineDetalle::create([
                    'idVenta' => $venta->idVenta,
                    'idProducto' => $item['producto']->idProducto,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $item['subtotal']
                ]);

                // Actualizar stock
                $item['producto']->decrement('stock', $item['cantidad']);
            }

            DB::commit();

            return redirect()->route('admin.ventas.index')
                           ->with('success', 'Venta creada exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error al crear la venta: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified venta.
     */
    public function show(BbbVentaOnline $venta)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        // Verificar que la venta pertenezca a la empresa del usuario
        if ($venta->idEmpresa !== $empresa->idEmpresa) {
            abort(403, 'No tienes permiso para ver esta venta.');
        }

        $venta->load(['cliente', 'detalles.producto.imagenPrincipal']);

        return view('ventas.show', compact('venta', 'empresa'));
    }

    /**
     * Show the form for editing the specified venta.
     */
    public function edit(BbbVentaOnline $venta)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        // Verificar que la venta pertenezca a la empresa del usuario
        if ($venta->idEmpresa !== $empresa->idEmpresa) {
            abort(403, 'No tienes permiso para editar esta venta.');
        }

        // No permitir editar ventas completadas
        if ($venta->estado === 'completada') {
            return redirect()->route('admin.ventas.show', $venta)
                           ->with('error', 'No se pueden editar ventas completadas.');
        }

        $venta->load(['cliente', 'detalles.producto']);
        
        $productos = BbbProducto::forEmpresa($empresa->idEmpresa)
                               ->active()
                               ->orderBy('nombre')
                               ->get();

        $clientes = BbbCliente::forEmpresa($empresa->idEmpresa)
                             ->active()
                             ->orderBy('nombre')
                             ->get();

        return view('ventas.edit', compact('venta', 'empresa', 'productos', 'clientes'));
    }

    /**
     * Update the specified venta in storage.
     */
    public function update(VentaRequest $request, BbbVentaOnline $venta)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        // Verificar que la venta pertenezca a la empresa del usuario
        if ($venta->idEmpresa !== $empresa->idEmpresa) {
            abort(403, 'No tienes permiso para editar esta venta.');
        }

        // No permitir editar ventas completadas
        if ($venta->estado === 'completada') {
            return redirect()->route('admin.ventas.show', $venta)
                           ->with('error', 'No se pueden editar ventas completadas.');
        }

        try {
            DB::beginTransaction();

            // Restaurar stock de los productos anteriores
            foreach ($venta->detalles as $detalle) {
                $detalle->producto->increment('stock', $detalle->cantidad);
            }

            // Eliminar detalles anteriores
            $venta->detalles()->delete();

            $data = $request->validated();

            // Primero calcular el nuevo total y validar productos
            $total = 0;
            $productosValidados = [];
            
            foreach ($data['productos'] as $productoData) {
                $producto = BbbProducto::findOrFail($productoData['idProducto']);
                
                // Verificar que el producto pertenece a la empresa
                if ($producto->idEmpresa !== $empresa->idEmpresa) {
                    throw new \Exception("El producto '{$producto->nombre}' no pertenece a tu empresa.");
                }
                
                // Verificar stock
                if ($producto->stock < $productoData['cantidad']) {
                    throw new \Exception("No hay suficiente stock para el producto: {$producto->nombre}. Stock disponible: {$producto->stock}");
                }

                $subtotal = $productoData['cantidad'] * $producto->precio;
                $total += $subtotal;
                
                $productosValidados[] = [
                    'producto' => $producto,
                    'cantidad' => $productoData['cantidad'],
                    'precio_unitario' => $producto->precio,
                    'subtotal' => $subtotal
                ];
            }

            // Obtener costo de envío del request y agregarlo al total
            $totalEnvio = (float)($data['totalEnvio'] ?? 0);
            $totalFinal = $total + $totalEnvio;

            // Actualizar la venta con todos los datos
            $venta->update([
                'idCliente' => $data['idCliente'],
                'estado' => $data['estado'],
                'metodo_pago' => $data['metodo_pago'] ?? null,
                'observaciones' => $data['observaciones'] ?? null,
                'total' => $totalFinal,
                'totalEnvio' => $totalEnvio
            ]);

            // Crear nuevos detalles y actualizar stock
            foreach ($productosValidados as $item) {
                BbbVentaOnlineDetalle::create([
                    'idVenta' => $venta->idVenta,
                    'idProducto' => $item['producto']->idProducto,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $item['subtotal']
                ]);

                // Actualizar stock
                $item['producto']->decrement('stock', $item['cantidad']);
            }

            DB::commit();

            return redirect()->route('admin.ventas.index')
                           ->with('success', 'Venta actualizada exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error al actualizar la venta: ' . $e->getMessage());
        }
    }

    /**
     * Change venta status.
     */
    public function changeStatus(Request $request, BbbVentaOnline $venta)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        // Verificar que la venta pertenezca a la empresa del usuario
        if ($venta->idEmpresa !== $empresa->idEmpresa) {
            abort(403, 'No tienes permiso para editar esta venta.');
        }

        $request->validate([
            'estado' => 'required|in:pendiente,procesando,completada,cancelada'
        ]);

        $estadoAnterior = $venta->estado;
        $nuevoEstado = $request->estado;

        // Si se cancela la venta, restaurar stock
        if ($nuevoEstado === 'cancelada' && $estadoAnterior !== 'cancelada') {
            foreach ($venta->detalles as $detalle) {
                $detalle->producto->increment('stock', $detalle->cantidad);
            }
        }

        // Si se reactiva una venta cancelada, reducir stock
        if ($estadoAnterior === 'cancelada' && $nuevoEstado !== 'cancelada') {
            foreach ($venta->detalles as $detalle) {
                if (!$detalle->producto->hasStock($detalle->cantidad)) {
                    return redirect()->back()
                                   ->with('error', "No hay suficiente stock para reactivar la venta. Producto: {$detalle->producto->nombre}");
                }
                $detalle->producto->decrement('stock', $detalle->cantidad);
            }
        }

        $venta->update(['estado' => $nuevoEstado]);

        return redirect()->back()
                       ->with('success', 'Estado de la venta actualizado exitosamente.');
    }



    /**
     * Format productos info for DataTable
     */
    private function formatProductosInfo($venta)
    {
        $totalItems = $venta->detalles->sum('cantidad');
        $primerProducto = $venta->detalles->first();
        
        if (!$primerProducto) {
            return '<span class="text-muted">Sin productos</span>';
        }

        $badge = '<span class="badge bg-light text-dark border me-2">' . $totalItems . ' <i class="bi bi-box ms-1"></i></span>';
        
        if ($primerProducto->producto) {
            $nombreProducto = strlen($primerProducto->producto->nombre) > 25 
                ? substr($primerProducto->producto->nombre, 0, 25) . '...' 
                : $primerProducto->producto->nombre;
            
            $info = '<div><div class="fw-medium text-dark">' . $nombreProducto . '</div>';
            
            if ($venta->detalles->count() > 1) {
                $info .= '<small class="text-muted">+' . ($venta->detalles->count() - 1) . ' más</small>';
            }
            
            $info .= '</div>';
            
            return '<div class="d-flex align-items-center">' . $badge . $info . '</div>';
        }
        
        return $badge . '<span class="text-muted">Producto eliminado</span>';
    }

    /**
     * Get estado badge HTML
     */
    private function getEstadoBadge($estado)
    {
        $badgeConfig = [
            'pendiente' => [
                'class' => 'bg-warning-subtle text-warning border border-warning',
                'icon' => 'bi-clock'
            ],
            'procesando' => [
                'class' => 'bg-info-subtle text-info border border-info',
                'icon' => 'bi-arrow-repeat'
            ],
            'completada' => [
                'class' => 'bg-success-subtle text-success border border-success',
                'icon' => 'bi-check-circle-fill'
            ],
            'cancelada' => [
                'class' => 'bg-danger-subtle text-danger border border-danger',
                'icon' => 'bi-x-circle-fill'
            ]
        ];

        $config = $badgeConfig[$estado] ?? [
            'class' => 'bg-secondary-subtle text-secondary border border-secondary',
            'icon' => 'bi-question-circle'
        ];

        return '<span class="badge ' . $config['class'] . ' px-3 py-2">' .
               '<i class="bi ' . $config['icon'] . ' me-1"></i>' .
               ucfirst($estado) .
               '</span>';
    }

    /**
     * Get ventas statistics.
     */
    private function getVentasStats($idEmpresa, $request)
    {
        $query = BbbVentaOnline::forEmpresa($idEmpresa);

        // Aplicar filtros de fecha si existen
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha', '<=', $request->fecha_hasta);
        }

        return [
            'total_ventas' => $query->count(),
            'ventas_completadas' => $query->where('estado', 'completada')->count(),
            'ventas_pendientes' => $query->where('estado', 'pendiente')->count(),
            'ventas_canceladas' => $query->where('estado', 'cancelada')->count(),
            'ingresos_totales' => $query->where('estado', 'completada')->sum('total'),
            'ticket_promedio' => $query->where('estado', 'completada')->avg('total') ?? 0
        ];
    }

    /**
     * Get metodo pago badge HTML
     */
    private function getMetodoPagoBadge($metodoPago)
    {
        if (!$metodoPago) {
            return '<span class="text-muted"><i class="bi bi-dash-circle me-1"></i>Sin método</span>';
        }

        return '<span class="badge bg-info-subtle text-info border border-info px-3 py-2">' .
               '<i class="bi bi-credit-card me-1"></i>' .
               ucfirst($metodoPago) .
               '</span>';
    }

    /**
     * Show the print view for a venta.
     */
    public function print(BbbVentaOnline $venta)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        // Verificar que la venta pertenezca a la empresa del usuario
        if ($venta->idEmpresa !== $empresa->idEmpresa) {
            abort(403, 'No tienes permiso para ver esta venta.');
        }

        // Cargar relaciones necesarias
        $venta->load(['cliente', 'detalles.producto', 'empresa']);

        return view('ventas.print', compact('venta', 'empresa'));
    }
}