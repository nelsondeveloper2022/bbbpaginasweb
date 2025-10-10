<?php

namespace App\Http\Controllers;

use App\Models\BbbCliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    /**
     * Display a listing of the clientes.
     */
    public function index()
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return redirect()->route('admin.profile.edit')
                           ->with('error', 'Primero debes completar la información de tu empresa.');
        }

        // Estadísticas para el panel
        $stats = [
            'total_clientes' => BbbCliente::forEmpresa($empresa->idEmpresa)->count(),
            'clientes_activos' => BbbCliente::forEmpresa($empresa->idEmpresa)->where('estado', 'activo')->count(),
            'clientes_con_ventas' => BbbCliente::forEmpresa($empresa->idEmpresa)->whereHas('ventasOnline')->count(),
            'nuevos_este_mes' => BbbCliente::forEmpresa($empresa->idEmpresa)
                                         ->whereMonth('created_at', now()->month)
                                         ->whereYear('created_at', now()->year)
                                         ->count()
        ];

        return view('clientes.index', compact('stats', 'empresa'));
    }

    /**
     * Show the form for creating a new cliente.
     */
    public function create()
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return redirect()->route('admin.profile.edit')
                           ->with('error', 'Primero debes completar la información de tu empresa.');
        }

        return view('clientes.create', compact('empresa'));
    }

    /**
     * Store a newly created cliente in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return redirect()->route('admin.profile.edit')
                           ->with('error', 'Primero debes completar la información de tu empresa.');
        }

        $request->validate([
            'nombre' => 'required|string|max:200',
            'email' => 'required|email|max:200',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500'
        ]);

        $data = $request->all();
        $data['idEmpresa'] = $empresa->idEmpresa;
        $data['estado'] = 'activo';

        BbbCliente::create($data);

        return redirect()->route('admin.clientes.index')
                       ->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Display the specified cliente.
     */
    public function show(BbbCliente $cliente)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        // Verificar que el cliente pertenezca a la empresa del usuario
        if ($cliente->idEmpresa !== $empresa->idEmpresa) {
            abort(403, 'No tienes permiso para ver este cliente.');
        }

        // Cargar ventas del cliente con sus detalles
        $ventas = $cliente->ventasOnline()
                          ->with(['detalles.producto', 'detalles'])
                          ->orderBy('fecha', 'desc')
                          ->get();

        return view('clientes.show', compact('cliente', 'empresa', 'ventas'));
    }

    /**
     * Show the form for editing the specified cliente.
     */
    public function edit(BbbCliente $cliente)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        // Verificar que el cliente pertenezca a la empresa del usuario
        if ($cliente->idEmpresa !== $empresa->idEmpresa) {
            abort(403, 'No tienes permiso para editar este cliente.');
        }

        return view('clientes.edit', compact('cliente', 'empresa'));
    }

    /**
     * Update the specified cliente in storage.
     */
    public function update(Request $request, BbbCliente $cliente)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        // Verificar que el cliente pertenezca a la empresa del usuario
        if ($cliente->idEmpresa !== $empresa->idEmpresa) {
            abort(403, 'No tienes permiso para editar este cliente.');
        }

        $request->validate([
            'nombre' => 'required|string|max:200',
            'email' => 'required|email|max:200',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'estado' => 'required|in:activo,inactivo'
        ]);

        $cliente->update($request->all());

        return redirect()->route('admin.clientes.index')
                       ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified cliente from storage.
     */
    public function destroy(BbbCliente $cliente)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        // Verificar que el cliente pertenezca a la empresa del usuario
        if ($cliente->idEmpresa !== $empresa->idEmpresa) {
            abort(403, 'No tienes permiso para eliminar este cliente.');
        }

        // Verificar si tiene ventas asociadas
        if ($cliente->ventasOnline()->exists()) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el cliente porque tiene ventas asociadas.'
                ], 400);
            }
            return redirect()->route('admin.clientes.index')
                           ->with('error', 'No se puede eliminar el cliente porque tiene ventas asociadas.');
        }

        $cliente->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cliente eliminado exitosamente.'
            ]);
        }

        return redirect()->route('admin.clientes.index')
                       ->with('success', 'Cliente eliminado exitosamente.');
    }

    /**
     * Get data for DataTables AJAX
     */
    public function getData(Request $request)
    {

        $user = Auth::user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return response()->json(['error' => 'No se encontró información de la empresa'], 404);
        }



        $query = BbbCliente::with('ventasOnline')
        ->forEmpresa($empresa->idEmpresa);

        // Aplicar filtros si existen (igual que productos)
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%")
                  ->orWhere('telefono', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('estado') && $request->estado !== '') {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('con_ventas') && $request->con_ventas !== '') {
            if ($request->con_ventas === 'si') {
                $query->whereHas('ventasOnline');
            } elseif ($request->con_ventas === 'no') {
                $query->whereDoesntHave('ventasOnline');
            }
        }

        $clientes = $query->orderBy('nombre')->get();

        return response()->json([
            'data' => $clientes->map(function ($cliente) {
                return [
                    'idCliente' => $cliente->idCliente,
                    'nombre' => $cliente->nombre,
                    'email' => $cliente->email,
                    'telefono' => $cliente->telefono ?? '-',
                    'direccion' => $cliente->direccion ?? '',
                    'estado' => $cliente->estado,
                    'estado_badge' => $cliente->estado === 'activo' 
                        ? '<span class="badge bg-success">Activo</span>' 
                        : '<span class="badge bg-secondary">Inactivo</span>',
                    'ventas_count' => $cliente->ventasOnline->count(),
                    'total_ventas' => format_cop_price($cliente->ventasOnline->sum('total')),
                    'created_at' => format_colombian_date($cliente->created_at, 'j M Y'),
                    'acciones' => ''
                ];
            })
        ]);
    }


}