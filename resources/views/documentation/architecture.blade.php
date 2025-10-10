@extends('layouts.dashboard')

@section('title', 'Arquitectura del Proyecto - Documentación BBB')
@section('description', 'Comprende cómo funciona la estructura de Laravel en este proyecto')

@section('content')
<style>
    .architecture-card {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    
    .architecture-card:hover {
        border-left-color: var(--primary-gold);
        transform: translateX(5px);
    }
    
    .code-example {
        background-color: #2d2d2d;
        color: #f8f8f2;
        padding: 1.5rem;
        border-radius: 8px;
        overflow-x: auto;
        margin: 1rem 0;
    }
    
    .code-example code {
        color: #f8f8f2;
        font-family: 'Courier New', monospace;
        font-size: 0.9rem;
    }
    
    .flow-diagram {
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 2rem;
        margin: 2rem 0;
    }
    
    .flow-step {
        background: white;
        border: 2px solid var(--primary-gold);
        border-radius: 8px;
        padding: 1rem;
        margin: 0.5rem 0;
        position: relative;
    }
    
    .flow-arrow {
        text-align: center;
        color: var(--primary-red);
        font-size: 1.5rem;
        margin: 0.5rem 0;
    }
    
    .highlight {
        background-color: #fff3cd;
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
        font-weight: 600;
    }
    
    .folder-structure {
        background: #f8f9fa;
        border-left: 3px solid var(--primary-gold);
        padding: 1rem;
        font-family: 'Courier New', monospace;
        font-size: 0.9rem;
    }
    
    .folder-structure .folder {
        color: var(--primary-gold);
        font-weight: 600;
    }
    
    .folder-structure .file {
        color: #6c757d;
    }
    
    .info-box {
        background: linear-gradient(135deg, rgba(240, 172, 33, 0.1), rgba(210, 46, 35, 0.1));
        border-left: 4px solid var(--primary-gold);
        padding: 1.25rem;
        border-radius: 8px;
        margin: 1.5rem 0;
    }
    
    .info-box-title {
        color: var(--primary-red);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
</style>

<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="dashboard-title">
                <i class="bi bi-diagram-3 me-3"></i>
                Arquitectura del Proyecto
            </h1>
            <p class="text-muted mb-0">Entiende cómo funciona Laravel en este proyecto</p>
        </div>
        <div>
            <a href="{{ route('admin.documentation.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver a Documentación
            </a>
        </div>
    </div>
</div>

<!-- Introducción a Laravel -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    ¿Qué es Laravel?
                </h5>
            </div>
            <div class="card-body">
                <p class="lead">Laravel es un <strong>framework de PHP</strong> que nos ayuda a construir aplicaciones web de forma organizada y eficiente.</p>
                
                <p>Piensa en Laravel como un conjunto de herramientas y reglas que nos facilitan:</p>
                <ul>
                    <li><i class="bi bi-check-circle text-success me-2"></i>Organizar el código de manera clara y profesional</li>
                    <li><i class="bi bi-check-circle text-success me-2"></i>Conectar con bases de datos fácilmente</li>
                    <li><i class="bi bi-check-circle text-success me-2"></i>Crear sitios web seguros y rápidos</li>
                    <li><i class="bi bi-check-circle text-success me-2"></i>Reutilizar código y ahorrar tiempo</li>
                </ul>

                <div class="info-box">
                    <div class="info-box-title">
                        <i class="bi bi-lightbulb-fill me-2"></i>
                        Para Principiantes
                    </div>
                    <p class="mb-0">No necesitas ser experto en programación para entender esto. Vamos a explicar cada parte de forma simple y con ejemplos prácticos del proyecto BBB Páginas Web.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Patrón MVC -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="bi bi-diagram-2 me-2"></i>
                    El Patrón MVC (Modelo-Vista-Controlador)
                </h5>
            </div>
            <div class="card-body">
                <p class="lead">Laravel usa el patrón <strong>MVC</strong>, que separa el código en tres partes principales:</p>

                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card architecture-card h-100 border-primary">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="bi bi-database-fill text-primary" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="text-primary">Modelo (Model)</h5>
                                <p class="text-muted">Se comunica con la base de datos</p>
                                <hr>
                                <div class="text-start">
                                    <small><strong>Ejemplo en este proyecto:</strong></small>
                                    <div class="folder-structure mt-2">
                                        <div class="folder">📂 app/Models/</div>
                                        <div class="file ms-3">📄 BbbProducto.php</div>
                                        <div class="file ms-3">📄 BbbCliente.php</div>
                                        <div class="file ms-3">📄 BbbLanding.php</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card architecture-card h-100 border-warning">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="bi bi-eye-fill text-warning" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="text-warning">Vista (View)</h5>
                                <p class="text-muted">Lo que el usuario ve en su navegador</p>
                                <hr>
                                <div class="text-start">
                                    <small><strong>Ejemplo en este proyecto:</strong></small>
                                    <div class="folder-structure mt-2">
                                        <div class="folder">📂 resources/views/</div>
                                        <div class="file ms-3">📄 dashboard.blade.php</div>
                                        <div class="file ms-3">📄 productos/index.blade.php</div>
                                        <div class="file ms-3">📄 landing/configurar.blade.php</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card architecture-card h-100 border-danger">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="bi bi-gear-fill text-danger" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="text-danger">Controlador (Controller)</h5>
                                <p class="text-muted">Coordina entre el Modelo y la Vista</p>
                                <hr>
                                <div class="text-start">
                                    <small><strong>Ejemplo en este proyecto:</strong></small>
                                    <div class="folder-structure mt-2">
                                        <div class="folder">📂 app/Http/Controllers/</div>
                                        <div class="file ms-3">📄 ProductoController.php</div>
                                        <div class="file ms-3">📄 ClienteController.php</div>
                                        <div class="file ms-3">📄 DashboardController.php</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Flujo de una petición -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="bi bi-arrow-right-circle me-2"></i>
                    ¿Cómo Funciona una Petición en Laravel?
                </h5>
            </div>
            <div class="card-body">
                <p class="lead">Cuando un usuario visita una página, Laravel sigue estos pasos:</p>

                <div class="flow-diagram">
                    <div class="flow-step">
                        <h6><strong>1. Ruta (Route)</strong></h6>
                        <p class="mb-0">El usuario escribe una URL en el navegador, por ejemplo: <code>https://bbbpaginasweb.com/admin/productos</code></p>
                        <div class="folder-structure mt-2">
                            <div class="folder">📄 routes/web.php</div>
                            <div class="ms-3 mt-1 text-muted">Define qué hacer cuando alguien visita esa URL</div>
                        </div>
                    </div>

                    <div class="flow-arrow">
                        <i class="bi bi-arrow-down-circle-fill"></i>
                    </div>

                    <div class="flow-step">
                        <h6><strong>2. Controlador (Controller)</strong></h6>
                        <p class="mb-0">La ruta llama a un método del controlador que procesa la solicitud</p>
                        <div class="folder-structure mt-2">
                            <div class="folder">📄 app/Http/Controllers/ProductoController.php</div>
                            <div class="ms-3 mt-1 text-muted">Método: <code>index()</code> - Lista todos los productos</div>
                        </div>
                    </div>

                    <div class="flow-arrow">
                        <i class="bi bi-arrow-down-circle-fill"></i>
                    </div>

                    <div class="flow-step">
                        <h6><strong>3. Modelo (Model)</strong></h6>
                        <p class="mb-0">El controlador usa el modelo para obtener datos de la base de datos</p>
                        <div class="folder-structure mt-2">
                            <div class="folder">📄 app/Models/BbbProducto.php</div>
                            <div class="ms-3 mt-1 text-muted">Trae los productos de la empresa del usuario</div>
                        </div>
                    </div>

                    <div class="flow-arrow">
                        <i class="bi bi-arrow-down-circle-fill"></i>
                    </div>

                    <div class="flow-step">
                        <h6><strong>4. Vista (View)</strong></h6>
                        <p class="mb-0">El controlador pasa los datos a una vista que genera el HTML</p>
                        <div class="folder-structure mt-2">
                            <div class="folder">📄 resources/views/productos/index.blade.php</div>
                            <div class="ms-3 mt-1 text-muted">Muestra los productos en una tabla bonita</div>
                        </div>
                    </div>

                    <div class="flow-arrow">
                        <i class="bi bi-arrow-down-circle-fill"></i>
                    </div>

                    <div class="flow-step bg-success text-white">
                        <h6><strong>5. Respuesta al Usuario</strong></h6>
                        <p class="mb-0">El navegador recibe y muestra la página completa</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ejemplo Práctico -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="bi bi-code-square me-2"></i>
                    Ejemplo Práctico: Listado de Productos
                </h5>
            </div>
            <div class="card-body">
                <p class="lead">Veamos cómo se conectan las tres partes con un ejemplo real del proyecto:</p>

                <!-- Paso 1: Ruta -->
                <h6 class="mt-4"><i class="bi bi-1-circle-fill text-primary me-2"></i>RUTA en <code>routes/web.php</code></h6>
                <p>Define que cuando alguien visite <span class="highlight">/admin/productos</span>, se ejecute el método <span class="highlight">index</span> del controlador <span class="highlight">ProductoController</span>.</p>
                <div class="code-example">
<code>// Archivo: routes/web.php

Route::prefix('productos')->name('productos.')->group(function () {
    Route::get('/', [ProductoController::class, 'index'])->name('index');
    Route::get('/create', [ProductoController::class, 'create'])->name('create');
    Route::post('/', [ProductoController::class, 'store'])->name('store');
});

// Explicación:
// GET /admin/productos → Ejecuta ProductoController@index
// GET /admin/productos/create → Muestra formulario para crear producto
// POST /admin/productos → Guarda un nuevo producto
</code>
                </div>

                <!-- Paso 2: Controlador -->
                <h6 class="mt-4"><i class="bi bi-2-circle-fill text-danger me-2"></i>CONTROLADOR en <code>app/Http/Controllers/ProductoController.php</code></h6>
                <p>El método <span class="highlight">index()</span> obtiene los productos y los envía a la vista.</p>
                <div class="code-example">
<code>// Archivo: app/Http/Controllers/ProductoController.php

public function index(Request $request)
{
    // 1. Obtener la empresa del usuario autenticado
    $user = Auth::user();
    $empresa = $user->empresa;

    // 2. Usar el MODELO para obtener productos de la base de datos
    $productos = BbbProducto::forEmpresa($empresa->idEmpresa)
                           ->with(['imagenes'])
                           ->orderBy('created_at', 'desc')
                           ->paginate(12);

    // 3. Enviar los datos a la VISTA
    return view('productos.index', compact('productos', 'empresa'));
}

// ¿Qué hace este código?
// 1. Identifica qué empresa está usando el sistema
// 2. Busca todos los productos de esa empresa en la BD
// 3. Los organiza de más reciente a más antiguo
// 4. Los envía a la vista para que los muestre
</code>
                </div>

                <!-- Paso 3: Modelo -->
                <h6 class="mt-4"><i class="bi bi-3-circle-fill text-success me-2"></i>MODELO en <code>app/Models/BbbProducto.php</code></h6>
                <p>Define cómo interactuar con la tabla de productos en la base de datos.</p>
                <div class="code-example">
<code>// Archivo: app/Models/BbbProducto.php

class BbbProducto extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'bbbproductos';
    
    // Llave primaria
    protected $primaryKey = 'idProducto';
    
    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'idEmpresa',
        'nombre',
        'precio',
        'stock',
        'imagen',
        'estado'
    ];
    
    // Método útil: Obtener productos de una empresa específica
    public static function forEmpresa($idEmpresa)
    {
        return self::where('idEmpresa', $idEmpresa);
    }
    
    // Relación: Un producto pertenece a una empresa
    public function empresa()
    {
        return $this->belongsTo(BbbEmpresa::class, 'idEmpresa');
    }
}

// ¿Qué hace este código?
// - Define la estructura de la tabla de productos
// - Permite hacer consultas fácilmente: BbbProducto::all()
// - Define relaciones con otras tablas
</code>
                </div>

                <!-- Paso 4: Vista -->
                <h6 class="mt-4"><i class="bi bi-4-circle-fill text-warning me-2"></i>VISTA en <code>resources/views/productos/index.blade.php</code></h6>
                <p>Muestra los productos al usuario en formato HTML.</p>
                <div class="code-example">
<code>{{-- Archivo: resources/views/productos/index.blade.php --}}

@extends('layouts.dashboard')

@section('content')
    &lt;h1&gt;Mis Productos&lt;/h1&gt;
    
    &lt;div class="row"&gt;
        @foreach($productos as $producto)
            &lt;div class="col-md-4"&gt;
                &lt;div class="card"&gt;
                    &lt;img src="{{ asset('storage/' . $producto->imagen) }}"&gt;
                    &lt;h5&gt;{{ $producto->nombre }}&lt;/h5&gt;
                    &lt;p&gt;Precio: ${{ number_format($producto->precio) }}&lt;/p&gt;
                    &lt;p&gt;Stock: {{ $producto->stock }} unidades&lt;/p&gt;
                &lt;/div&gt;
            &lt;/div&gt;
        @endforeach
    &lt;/div&gt;
@endsection

{{-- ¿Qué hace este código? --}}
{{-- - Recibe la variable $productos del controlador --}}
{{-- - Recorre cada producto con un bucle @foreach --}}
{{-- - Muestra la información en tarjetas bonitas --}}
</code>
                </div>

                <div class="info-box mt-4">
                    <div class="info-box-title">
                        <i class="bi bi-star-fill me-2"></i>
                        Resumen del Flujo
                    </div>
                    <ol class="mb-0">
                        <li><strong>Usuario visita:</strong> /admin/productos</li>
                        <li><strong>Ruta llama a:</strong> ProductoController@index</li>
                        <li><strong>Controlador usa:</strong> BbbProducto (modelo) para obtener datos</li>
                        <li><strong>Controlador envía datos a:</strong> productos/index.blade.php (vista)</li>
                        <li><strong>Usuario ve:</strong> La página con todos sus productos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estructura de Carpetas -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h5 class="mb-0">
                    <i class="bi bi-folder-fill me-2"></i>
                    Estructura de Carpetas del Proyecto
                </h5>
            </div>
            <div class="card-body">
                <p class="lead">Así está organizado el proyecto BBB Páginas Web:</p>

                <div class="row">
                    <div class="col-md-6">
                        <div class="folder-structure">
<strong>bbb/</strong> (Carpeta raíz del proyecto)
├── <span class="folder">📂 app/</span>
│   ├── <span class="folder">📂 Http/</span>
│   │   ├── <span class="folder">📂 Controllers/</span>
│   │   │   ├── <span class="file">ProductoController.php</span>
│   │   │   ├── <span class="file">ClienteController.php</span>
│   │   │   ├── <span class="file">DashboardController.php</span>
│   │   │   └── <span class="file">DocumentationController.php</span>
│   │   └── <span class="folder">📂 Middleware/</span>
│   └── <span class="folder">📂 Models/</span>
│       ├── <span class="file">BbbProducto.php</span>
│       ├── <span class="file">BbbCliente.php</span>
│       ├── <span class="file">BbbEmpresa.php</span>
│       └── <span class="file">User.php</span>
│
├── <span class="folder">📂 resources/</span>
│   └── <span class="folder">📂 views/</span>
│       ├── <span class="folder">📂 layouts/</span>
│       │   └── <span class="file">dashboard.blade.php</span>
│       ├── <span class="folder">📂 productos/</span>
│       │   ├── <span class="file">index.blade.php</span>
│       │   ├── <span class="file">create.blade.php</span>
│       │   └── <span class="file">edit.blade.php</span>
│       └── <span class="folder">📂 documentation/</span>
│           └── <span class="file">index.blade.php</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="folder-structure">
├── <span class="folder">📂 routes/</span>
│   ├── <span class="file">web.php</span> ← Define todas las rutas web
│   └── <span class="file">api.php</span> ← Define rutas de API
│
├── <span class="folder">📂 database/</span>
│   ├── <span class="folder">📂 migrations/</span> ← Estructura de BD
│   └── <span class="folder">📂 seeders/</span> ← Datos de prueba
│
├── <span class="folder">📂 public/</span>
│   ├── <span class="file">index.php</span> ← Punto de entrada
│   ├── <span class="folder">📂 css/</span>
│   ├── <span class="folder">📂 js/</span>
│   └── <span class="folder">📂 images/</span>
│
├── <span class="folder">📂 config/</span>
│   ├── <span class="file">app.php</span>
│   ├── <span class="file">database.php</span>
│   └── <span class="file">mail.php</span>
│
├── <span class="file">.env</span> ← Configuración del entorno
├── <span class="file">composer.json</span> ← Dependencias de PHP
└── <span class="file">artisan</span> ← Herramienta de comandos
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h6 class="text-primary">📚 Descripción de cada carpeta:</h6>
                    <ul>
                        <li><strong>app/Http/Controllers/</strong> - Todos los controladores que procesan las peticiones</li>
                        <li><strong>app/Models/</strong> - Modelos que representan tablas de la base de datos</li>
                        <li><strong>resources/views/</strong> - Archivos Blade (HTML con PHP) que se muestran al usuario</li>
                        <li><strong>routes/web.php</strong> - Define todas las URL del sistema y qué controlador las maneja</li>
                        <li><strong>public/</strong> - Archivos accesibles directamente (CSS, JS, imágenes)</li>
                        <li><strong>database/migrations/</strong> - Archivos que crean y modifican la estructura de la BD</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Conceptos Clave -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-key-fill me-2"></i>
                    Conceptos Clave para Entender
                </h5>
            </div>
            <div class="card-body">
                <div class="accordion" id="conceptsAccordion">
                    <!-- Blade Templates -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#concept1">
                                <i class="bi bi-file-earmark-code me-2"></i>
                                ¿Qué son las plantillas Blade?
                            </button>
                        </h2>
                        <div id="concept1" class="accordion-collapse collapse show" data-bs-parent="#conceptsAccordion">
                            <div class="accordion-body">
                                <p><strong>Blade</strong> es el sistema de plantillas de Laravel. Permite mezclar HTML con código PHP de forma elegante.</p>
                                <div class="code-example">
<code>{{-- Sintaxis Blade --}}

{{ $variable }}           {{-- Imprime una variable (con protección XSS) --}}
{!! $html !!}            {{-- Imprime HTML sin escapar --}}

@if($condicion)          {{-- Condicionales --}}
    &lt;p&gt;Es verdadero&lt;/p&gt;
@else
    &lt;p&gt;Es falso&lt;/p&gt;
@endif

@foreach($items as $item) {{-- Bucles --}}
    &lt;li&gt;{{ $item }}&lt;/li&gt;
@endforeach

@extends('layouts.dashboard')  {{-- Hereda de un layout --}}
@section('content')            {{-- Define una sección --}}
    &lt;h1&gt;Contenido&lt;/h1&gt;
@endsection
</code>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Eloquent ORM -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#concept2">
                                <i class="bi bi-database me-2"></i>
                                ¿Qué es Eloquent ORM?
                            </button>
                        </h2>
                        <div id="concept2" class="accordion-collapse collapse" data-bs-parent="#conceptsAccordion">
                            <div class="accordion-body">
                                <p><strong>Eloquent</strong> permite trabajar con la base de datos usando objetos PHP en lugar de escribir SQL.</p>
                                <div class="code-example">
<code>// En lugar de escribir SQL:
// SELECT * FROM bbbproductos WHERE idEmpresa = 1

// Usamos Eloquent:
$productos = BbbProducto::where('idEmpresa', 1)->get();

// Crear un nuevo producto:
$producto = BbbProducto::create([
    'nombre' => 'Laptop HP',
    'precio' => 2500000,
    'stock' => 10
]);

// Actualizar un producto:
$producto->precio = 2300000;
$producto->save();

// Eliminar un producto:
$producto->delete();
</code>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Middleware -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#concept3">
                                <i class="bi bi-shield-check me-2"></i>
                                ¿Qué es un Middleware?
                            </button>
                        </h2>
                        <div id="concept3" class="accordion-collapse collapse" data-bs-parent="#conceptsAccordion">
                            <div class="accordion-body">
                                <p>Un <strong>middleware</strong> es como un filtro que verifica algo antes de ejecutar la petición.</p>
                                <p><strong>Ejemplos en este proyecto:</strong></p>
                                <ul>
                                    <li><code>auth</code> - Verifica que el usuario esté autenticado</li>
                                    <li><code>check.trial</code> - Verifica que el usuario tenga una licencia activa</li>
                                    <li><code>recaptcha</code> - Verifica el captcha en formularios</li>
                                </ul>
                                <div class="code-example">
<code>// En routes/web.php:
Route::middleware('auth')->group(function () {
    // Solo usuarios autenticados pueden acceder aquí
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
</code>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Validación -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#concept4">
                                <i class="bi bi-check-square me-2"></i>
                                ¿Cómo funciona la Validación?
                            </button>
                        </h2>
                        <div id="concept4" class="accordion-collapse collapse" data-bs-parent="#conceptsAccordion">
                            <div class="accordion-body">
                                <p>Laravel valida automáticamente los datos antes de procesarlos.</p>
                                <div class="code-example">
<code>// En un controlador:
public function store(Request $request)
{
    // Validar los datos del formulario
    $validated = $request->validate([
        'nombre' => 'required|max:255',
        'email' => 'required|email|unique:users',
        'precio' => 'required|numeric|min:0',
        'imagen' => 'nullable|image|max:2048' // 2MB máximo
    ]);
    
    // Si pasa la validación, continúa...
    $producto = BbbProducto::create($validated);
    
    return redirect()->route('productos.index')
                    ->with('success', 'Producto creado!');
}

// Si falla la validación, Laravel redirige automáticamente
// con los errores y los datos anteriores del formulario
</code>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recursos Adicionales -->
<div class="row">
    <div class="col-12">
        <div class="card border-primary">
            <div class="card-body">
                <h5 class="text-primary">
                    <i class="bi bi-bookmark-star me-2"></i>
                    Recursos para Seguir Aprendiendo
                </h5>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <ul>
                            <li><a href="https://laravel.com/docs" target="_blank">Documentación Oficial de Laravel</a></li>
                            <li><a href="https://laracasts.com" target="_blank">Laracasts - Video Tutoriales</a></li>
                            <li><a href="https://www.youtube.com/@LaravelDaily" target="_blank">Laravel Daily en YouTube</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul>
                            <li><a href="{{ route('admin.documentation.quick-start') }}">Guía de Inicio Rápido</a></li>
                            <li><a href="{{ route('admin.documentation.publish-guide') }}">Cómo Publicar tu Web</a></li>
                            <li><a href="{{ route('admin.documentation.faq') }}">Preguntas Frecuentes</a></li>
                        </ul>
                    </div>
                </div>

                <div class="alert alert-info mt-3">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>¿Tienes dudas?</strong> No dudes en contactarnos por WhatsApp. Estamos para ayudarte a entender mejor el sistema.
                    <a href="https://wa.me/{{ config('app.support.mobile') }}" target="_blank" class="btn btn-success btn-sm ms-2">
                        <i class="bi bi-whatsapp me-1"></i>
                        Contactar Soporte
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Auto-scroll suave al hacer clic en enlaces internos
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
</script>
@endpush
