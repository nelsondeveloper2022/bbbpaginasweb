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

    /**
     * Mostrar vista de importación masiva
     */
    public function import()
    {
        $user = Auth::user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return redirect()->route('admin.profile.edit')
                           ->with('error', 'Primero debes completar la información de tu empresa.');
        }

        return view('productos.import', compact('empresa'));
    }

    /**
     * Importar productos desde archivo Excel
     */
    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls|max:10240', // 10MB max
        ]);

        try {
            $user = Auth::user();
            $empresa = $user->empresa;

            if (!$empresa) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró información de la empresa.'
                ], 400);
            }

            $file = $request->file('excel_file');
            
            // Cargar el archivo Excel
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Eliminar la fila de encabezados si existe
            if (isset($rows[0]) && is_string($rows[0][0])) {
                array_shift($rows);
            }

            $created = 0;
            $updated = 0;
            $errors = [];

            foreach ($rows as $index => $row) {
                $lineNumber = $index + 2; // +2 porque empezamos desde 1 y restamos el header

                // Validar que la fila tenga datos
                if (empty($row[0]) && empty($row[1])) {
                    continue; // Saltar filas vacías
                }

                try {
                    // Extraer datos según columnas
                    $nombre = trim($row[0] ?? '');
                    $referencia = trim($row[1] ?? '');
                    $descripcion = trim($row[2] ?? '');
                    $precio = $this->cleanNumber($row[3] ?? 0);
                    $costo = $this->cleanNumber($row[4] ?? 0);
                    $stock = (int) ($row[5] ?? 0);
                    $nombreImagen = trim($row[6] ?? '');
                    $estado = strtolower(trim($row[7] ?? 'activo'));

                    // Validaciones básicas
                    if (empty($nombre)) {
                        $errors[] = "Línea {$lineNumber}: El nombre es obligatorio";
                        continue;
                    }

                    if (empty($referencia)) {
                        $errors[] = "Línea {$lineNumber}: La referencia es obligatoria";
                        continue;
                    }

                    if ($precio < 0) {
                        $errors[] = "Línea {$lineNumber}: El precio no puede ser negativo";
                        continue;
                    }

                    if (!in_array($estado, ['activo', 'inactivo'])) {
                        $errors[] = "Línea {$lineNumber}: El estado debe ser 'activo' o 'inactivo'";
                        continue;
                    }

                    // Normalizar el nombre del producto (slug)
                    $nombreNormalizado = Str::slug($nombre);
                    
                    // Buscar si el producto ya existe por referencia
                    $producto = BbbProducto::forEmpresa($empresa->idEmpresa)
                                          ->where('referencia', $referencia)
                                          ->first();

                    $datos = [
                        'idEmpresa' => $empresa->idEmpresa,
                        'nombre' => $nombre,
                        'referencia' => $referencia,
                        'slug' => $nombreNormalizado,
                        'descripcion' => $descripcion,
                        'precio' => $precio,
                        'costo' => $costo,
                        'stock' => $stock,
                        'estado' => $estado,
                    ];

                    if ($producto) {
                        // Actualizar producto existente
                        
                        // Si el producto ya tiene una imagen bien formada (ruta de storage), NO la sobrescribir
                        if (empty($producto->imagen) || !str_starts_with($producto->imagen, 'productos/')) {
                            // Solo actualizar la imagen si está vacía o no es una ruta de storage válida
                            $datos['imagen'] = $nombreImagen;
                        }
                        
                        $producto->update($datos);
                        $updated++;
                    } else {
                        // Crear nuevo producto - siempre incluir el nombre de imagen del Excel
                        $datos['imagen'] = $nombreImagen;
                        $producto = BbbProducto::create($datos);
                        $created++;
                    }

                } catch (\Exception $e) {
                    $errors[] = "Línea {$lineNumber}: " . $e->getMessage();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Importación completada',
                'created' => $created,
                'updated' => $updated,
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el archivo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Importar imágenes desde archivo ZIP
     */
    public function importImages(Request $request)
    {
        $request->validate([
            'images_zip' => 'required|mimes:zip|max:51200', // 50MB max
        ]);

        try {
            $user = Auth::user();
            $empresa = $user->empresa;

            if (!$empresa) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró información de la empresa.'
                ], 400);
            }

            $zipFile = $request->file('images_zip');
            
            // Crear directorio temporal
            $tempDir = storage_path('app/temp/import_' . time());
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            // Extraer el ZIP
            $zip = new \ZipArchive();
            if ($zip->open($zipFile->getRealPath()) === true) {
                $zip->extractTo($tempDir);
                $zip->close();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pudo abrir el archivo ZIP'
                ], 400);
            }

            $processed = 0;
            $assigned = 0;
            $errors = [];

            // Obtener todos los productos de la empresa
            $productos = BbbProducto::forEmpresa($empresa->idEmpresa)->get();

            if ($productos->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay productos para asignar imágenes. Primero debes importar el Excel con los productos.'
                ], 400);
            }

            // Obtener todos los archivos del directorio temporal recursivamente
            $allFiles = $this->getAllFilesRecursive($tempDir);

            // Crear un mapa de archivos normalizados para búsqueda rápida
            $filesMap = [];
            foreach ($allFiles as $filePath) {
                $fileName = basename($filePath);
                $normalizedName = $this->normalizeImageName($fileName);
                $filesMap[$normalizedName] = $filePath;
            }

            // Procesar cada producto
            foreach ($productos as $producto) {
                try {
                    // Si el producto no tiene nombre de imagen definido, saltar
                    if (empty($producto->imagen)) {
                        continue;
                    }
                    
                    // Si la imagen ya es una ruta de storage (ya fue procesada), saltar
                    if (str_starts_with($producto->imagen, 'productos/')) {
                        continue;
                    }
                    
                    $processed++;
                    
                    // Normalizar el nombre de imagen que esperamos (del Excel)
                    $nombreImagenNormalizado = $this->normalizeImageName($producto->imagen);
                    
                    // Buscar el archivo en el mapa
                    $imageFile = null;
                    
                    // Búsqueda exacta por el nombre de imagen del Excel
                    if (isset($filesMap[$nombreImagenNormalizado])) {
                        $imageFile = $filesMap[$nombreImagenNormalizado];
                    } else {
                        // Búsqueda flexible: buscar por coincidencia parcial con el nombre de imagen
                        foreach ($filesMap as $normalizedFile => $filePath) {
                            if (str_contains($normalizedFile, $nombreImagenNormalizado) || str_contains($nombreImagenNormalizado, $normalizedFile)) {
                                $imageFile = $filePath;
                                break;
                            }
                        }
                        
                        // Si aún no se encuentra, intentar por slug del producto
                        if (!$imageFile) {
                            $slugProducto = $producto->slug;
                            if (isset($filesMap[$slugProducto])) {
                                $imageFile = $filesMap[$slugProducto];
                            } else {
                                foreach ($filesMap as $normalizedFile => $filePath) {
                                    if (str_contains($normalizedFile, $slugProducto) || str_contains($slugProducto, $normalizedFile)) {
                                        $imageFile = $filePath;
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    if (!$imageFile) {
                        $errors[] = "No se encontró imagen para el producto '{$producto->nombre}' (Ref: {$producto->referencia}). Se esperaba: {$producto->imagen}";
                        continue;
                    }
                    
                    // Validar que sea una imagen
                    $mimeType = mime_content_type($imageFile);
                    if (!str_starts_with($mimeType, 'image/')) {
                        $fileName = basename($imageFile);
                        $errors[] = "El archivo {$fileName} no es una imagen válida para el producto '{$producto->nombre}'";
                        continue;
                    }

                    // Guardar la imagen anterior (nombre del Excel) por si necesitamos revertir
                    $imagenAnterior = $producto->imagen;
                    
                    // Generar nombre único para la imagen física
                    $extension = pathinfo($imageFile, PATHINFO_EXTENSION);
                    $newFileName = 'productos/' . $empresa->idEmpresa . '/' . Str::uuid() . '.' . $extension;

                    // Guardar la imagen física
                    $imageContent = file_get_contents($imageFile);
                    Storage::disk('public')->put($newFileName, $imageContent);

                    // Eliminar imagen física anterior si existe y es una ruta de storage
                    if ($imagenAnterior && str_starts_with($imagenAnterior, 'productos/') && Storage::disk('public')->exists($imagenAnterior)) {
                        Storage::disk('public')->delete($imagenAnterior);
                    }

                    // Actualizar el producto con la ruta de la nueva imagen
                    $producto->imagen = $newFileName;
                    $producto->save();

                    $assigned++;

                } catch (\Exception $e) {
                    $errors[] = "Error al procesar imagen para producto '{$producto->nombre}': " . $e->getMessage();
                }
            }

            // Limpiar directorio temporal
            $this->deleteDirectory($tempDir);

            return response()->json([
                'success' => true,
                'message' => 'Imágenes procesadas',
                'processed' => $processed,
                'assigned' => $assigned,
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar las imágenes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Limpiar número de formato (eliminar símbolos de moneda, comas, etc.)
     */
    private function cleanNumber($value)
    {
        if (is_numeric($value)) {
            return (float) $value;
        }

        // Eliminar símbolos de moneda y espacios
        $value = preg_replace('/[^\d,.-]/', '', $value);
        
        // Reemplazar coma por punto decimal
        $value = str_replace(',', '.', $value);
        
        return (float) $value;
    }

    /**
     * Buscar archivo recursivamente en un directorio
     */
    private function searchFileRecursive($dir, $fileName)
    {
        $found = [];
        
        if (!is_dir($dir)) {
            return $found;
        }

        $files = scandir($dir);
        
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $path = $dir . '/' . $file;
            
            if (is_dir($path)) {
                // Buscar recursivamente en subdirectorios
                $subFound = $this->searchFileRecursive($path, $fileName);
                $found = array_merge($found, $subFound);
            } else {
                // Comparar nombres (case-insensitive)
                if (strcasecmp($file, $fileName) === 0) {
                    $found[] = $path;
                }
            }
        }
        
        return $found;
    }

    /**
     * Normalizar nombre de imagen para comparación
     * Convierte el nombre a minúsculas, elimina espacios y caracteres especiales
     */
    private function normalizeImageName($fileName)
    {
        // Obtener el nombre sin extensión
        $nameWithoutExt = pathinfo($fileName, PATHINFO_FILENAME);
        
        // Normalizar: convertir a minúsculas, reemplazar espacios por guiones
        $normalized = Str::slug($nameWithoutExt);
        
        // Obtener la extensión y normalizarla también
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        return $normalized . '.' . $extension;
    }

    /**
     * Obtener todos los archivos recursivamente de un directorio
     */
    private function getAllFilesRecursive($dir)
    {
        $files = [];
        
        if (!is_dir($dir)) {
            return $files;
        }

        $items = scandir($dir);
        
        foreach ($items as $item) {
            if ($item === '.' || $item === '..' || $item === '__MACOSX') {
                continue;
            }

            $path = $dir . '/' . $item;
            
            if (is_dir($path)) {
                // Buscar recursivamente en subdirectorios
                $subFiles = $this->getAllFilesRecursive($path);
                $files = array_merge($files, $subFiles);
            } else {
                // Agregar archivo a la lista
                $files[] = $path;
            }
        }
        
        return $files;
    }

    /**
     * Eliminar directorio recursivamente
     */
    private function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
        }
        
        rmdir($dir);
    }
}