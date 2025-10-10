<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoRequest;
use App\Models\BbbProducto;
use App\Models\BbbProductoImagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    /**
     * Display a listing of the productos.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return redirect()->route('admin.profile.edit')
                           ->with('error', 'Primero debes completar la información de tu empresa.');
        }

        $query = BbbProducto::forEmpresa($empresa->idEmpresa)
                           ->with(['imagenes', 'imagenPrincipal']);

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $productos = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('productos.index', compact('productos', 'empresa'));
    }

    /**
     * Show the form for creating a new producto.
     */
    public function create()
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return redirect()->route('admin.profile.edit')
                           ->with('error', 'Primero debes completar la información de tu empresa.');
        }

        return view('productos.create', compact('empresa'));
    }

    /**
     * Store a newly created producto in storage.
     */
    public function store(ProductoRequest $request)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return redirect()->route('admin.profile.edit')
                           ->with('error', 'Primero debes completar la información de tu empresa.');
        }

        $data = $request->validated();
        $data['idEmpresa'] = $empresa->idEmpresa;
        
        // Generar slug único
        $data['slug'] = $this->generateUniqueSlug($data['nombre'], $empresa->idEmpresa);

        // Procesar imagen principal si existe
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . Str::random(10) . '.' . $imagen->extension();
            $path = $imagen->storeAs('productos/' . $empresa->idEmpresa, $nombreImagen, 'public');
            $data['imagen'] = $path;
        }

        $producto = BbbProducto::create($data);

        // Procesar galería de imágenes
        if ($request->hasFile('galeria')) {
            $this->processGalleryImages($request->file('galeria'), $producto, $empresa->idEmpresa);
        }

        return redirect()->route('admin.productos.index')
                        ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified producto.
     */
    public function show(BbbProducto $producto)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        // Verificar que el producto pertenezca a la empresa del usuario
        if ($producto->idEmpresa !== $empresa->idEmpresa) {
            abort(403, 'No tienes permiso para ver este producto.');
        }

        $producto->load(['imagenes' => function ($query) {
            $query->orderBy('orden', 'asc');
        }, 'imagenPrincipal']);

        return view('productos.show', compact('producto', 'empresa'));
    }

    /**
     * Show the form for editing the specified producto.
     */
    public function edit(BbbProducto $producto)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        // Verificar que el producto pertenezca a la empresa del usuario
        if ($producto->idEmpresa !== $empresa->idEmpresa) {
            abort(403, 'No tienes permiso para editar este producto.');
        }

        $producto->load(['imagenes' => function ($query) {
            $query->orderBy('orden', 'asc');
        }]);

        return view('productos.edit', compact('producto', 'empresa'));
    }

    /**
     * Update the specified producto in storage.
     */
    public function update(ProductoRequest $request, BbbProducto $producto)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        // Verificar que el producto pertenezca a la empresa del usuario
        if ($producto->idEmpresa !== $empresa->idEmpresa) {
            abort(403, 'No tienes permiso para editar este producto.');
        }

        $data = $request->validated();

        // Actualizar slug si cambió el nombre
        if ($data['nombre'] !== $producto->nombre) {
            $data['slug'] = $this->generateUniqueSlug($data['nombre'], $empresa->idEmpresa, $producto->idProducto);
        }

        // Procesar nueva imagen principal si existe
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . Str::random(10) . '.' . $imagen->extension();
            $path = $imagen->storeAs('productos/' . $empresa->idEmpresa, $nombreImagen, 'public');
            $data['imagen'] = $path;
        }

        $producto->update($data);

        // Procesar nueva galería de imágenes si existe
        if ($request->hasFile('galeria')) {
            $this->processGalleryImages($request->file('galeria'), $producto, $empresa->idEmpresa);
        }

        return redirect()->route('admin.productos.index')
                        ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified producto from storage.
     */
    public function destroy(BbbProducto $producto)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        // Verificar que el producto pertenezca a la empresa del usuario
        if ($producto->idEmpresa !== $empresa->idEmpresa) {
            abort(403, 'No tienes permiso para eliminar este producto.');
        }

        // Verificar si el producto tiene ventas asociadas
        if ($producto->detallesVenta()->exists()) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el producto porque tiene ventas asociadas. Puede desactivarlo en su lugar.'
                ], 422);
            }
            
            return redirect()->route('admin.productos.index')
                           ->with('error', 'No se puede eliminar el producto porque tiene ventas asociadas. Puede desactivarlo en su lugar.');
        }

        // Eliminar imágenes del almacenamiento
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        foreach ($producto->imagenes as $imagen) {
            Storage::disk('public')->delete($imagen->url_imagen);
        }

        $producto->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Producto eliminado exitosamente.'
            ]);
        }

        return redirect()->route('admin.productos.index')
                        ->with('success', 'Producto eliminado exitosamente.');
    }

    /**
     * Remove the specified product via AJAX.
     */
    public function destroyAjax(BbbProducto $producto)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        // Verificar que el producto pertenezca a la empresa del usuario
        if ($producto->idEmpresa !== $empresa->idEmpresa) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para eliminar este producto.'
            ], 403);
        }

        // Verificar si el producto tiene ventas asociadas
        if ($producto->detallesVenta()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar el producto porque tiene ventas asociadas. Puede desactivarlo en su lugar.'
            ], 422);
        }

        // Eliminar imágenes del almacenamiento
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        foreach ($producto->imagenes as $imagen) {
            Storage::disk('public')->delete($imagen->url_imagen);
        }

        $producto->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado exitosamente.'
        ]);
    }

    /**
     * Remove imagen from galería.
     */
    public function removeImage(Request $request, BbbProducto $producto)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        // Verificar que el producto pertenezca a la empresa del usuario
        if ($producto->idEmpresa !== $empresa->idEmpresa) {
            abort(403, 'No tienes permiso para editar este producto.');
        }

        $imagenId = $request->input('imagen_id');
        $imagen = BbbProductoImagen::where('idImagen', $imagenId)
                                  ->where('idProducto', $producto->idProducto)
                                  ->first();

        if ($imagen) {
            Storage::disk('public')->delete($imagen->url_imagen);
            $imagen->delete();
        }

        return response()->json(['success' => true]);
    }

    /**
     * Generate unique slug for producto.
     */
    private function generateUniqueSlug($nombre, $idEmpresa, $excludeId = null)
    {
        $baseSlug = Str::slug($nombre);
        $slug = $baseSlug;
        $counter = 1;

        $query = BbbProducto::where('idEmpresa', $idEmpresa)->where('slug', $slug);
        
        if ($excludeId) {
            $query->where('idProducto', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Process gallery images.
     */
    private function processGalleryImages($images, $producto, $idEmpresa)
    {
        foreach ($images as $index => $imagen) {
            $nombreImagen = time() . '_' . Str::random(10) . '.' . $imagen->extension();
            $path = $imagen->storeAs('productos/' . $idEmpresa . '/galeria', $nombreImagen, 'public');

            BbbProductoImagen::create([
                'idProducto' => $producto->idProducto,
                'url_imagen' => $path,
                'es_principal' => false,
                'orden' => $index + 1
            ]);
        }
    }

    /**
     * Get products data for DataTable.
     */
    public function getData(Request $request)
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return response()->json(['error' => 'No se encontró información de la empresa'], 404);
        }

        $query = BbbProducto::with('imagenes')
                           ->forEmpresa($empresa->idEmpresa);

        // Aplicar filtros si existen
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('descripcion', 'like', "%{$buscar}%")
                  ->orWhere('referencia', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('estado') && $request->estado !== '') {
            $query->where('estado', $request->estado);
        }

        $productos = $query->get();

        return response()->json([
            'data' => $productos->map(function ($producto) {
                return [
                    'idProducto' => $producto->idProducto,
                    'imagen' => $producto->imagen_url,
                    'todas_imagenes' => $producto->all_images,
                    'nombre' => $producto->nombre,
                    'referencia' => $producto->referencia,
                    'descripcion' => Str::limit($producto->descripcion, 100),
                    'precio' => $producto->precio,
                    'precio_formateado' => '$' . number_format($producto->precio, 0, ',', '.'),
                    'costo' => $producto->costo,
                    'costo_formateado' => '$' . number_format($producto->costo, 0, ',', '.'),
                    'margen' => $producto->margen_ganancia,
                    'stock' => $producto->stock,
                    'estado' => $producto->estado,
                    'estado_badge' => $producto->estado === 'activo' 
                        ? '<span class="badge bg-success">Activo</span>' 
                        : '<span class="badge bg-secondary">Inactivo</span>',
                    'default_icon' => $producto->default_icon,
                    'created_at' => $producto->created_at->format('d/m/Y'),
                    'acciones' => ''
                ];
            })
        ]);
    }

    /**
     * Update product price and stock quickly.
     */
    public function updateQuick(Request $request, BbbProducto $producto)
    {
        $user = Auth::user();
        
        // Verificar que el producto pertenece a la empresa del usuario
        if ($producto->idEmpresa !== $user->empresa->idEmpresa) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $request->validate([
            'precio' => 'required|numeric|min:0|max:999999999',
            'costo' => 'nullable|numeric|min:0|max:999999999',
            'stock' => 'required|integer|min:0'
        ]);

        $producto->update([
            'precio' => $request->precio,
            'costo' => $request->costo ?? 0,
            'stock' => $request->stock
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado exitosamente',
            'data' => [
                'precio_formateado' => '$' . number_format($producto->precio, 0, ',', '.'),
                'costo_formateado' => '$' . number_format($producto->costo, 0, ',', '.'),
                'stock' => $producto->stock,
                'margen' => $producto->margen_ganancia
            ]
        ]);
    }


}