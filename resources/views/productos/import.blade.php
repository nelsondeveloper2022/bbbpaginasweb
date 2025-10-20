@extends('layouts.dashboard')

@section('title', 'Importación Masiva de Productos')

@section('content')
    <div class="container-fluid">
        <!-- Header responsive -->
        <div class="row align-items-center mb-4 g-3">
            <div class="col-12 col-md-auto flex-md-grow-1">
                <h1 class="h3 mb-1">
                    <i class="bi bi-file-earmark-spreadsheet me-2"></i>
                    <span class="d-none d-lg-inline">Importación Masiva de Productos</span>
                    <span class="d-inline d-lg-none">Importación Masiva</span>
                </h1>
                <p class="text-muted mb-0 small">Carga productos desde Excel y sincroniza imágenes desde ZIP</p>
            </div>
            <div class="col-12 col-md-auto">
                <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary w-100 w-md-auto">
                    <i class="bi bi-arrow-left me-1"></i> Volver a Productos
                </a>
            </div>
        </div>

        <!-- Instrucciones responsive -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-info">
                    <h6 class="alert-heading">
                        <i class="bi bi-info-circle me-2"></i>
                        Instrucciones para la importación
                    </h6>
                    <p class="mb-2 small">Sigue estos pasos para importar productos masivamente:</p>
                    <ol class="mb-0 ps-3 small">
                        <li class="mb-1">Prepara un archivo Excel (.xlsx o .xls) con la estructura indicada abajo</li>
                        <li class="mb-1">Opcionalmente, prepara un archivo ZIP con las imágenes de los productos</li>
                        <li>Los productos se crearán o actualizarán según la <strong>referencia</strong></li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Estructura del Excel - Mobile Optimized -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h5 class="mb-0 text-black">
                            <i class="bi bi-table me-2"></i>
                            <span class="d-none d-md-inline">Estructura del Archivo Excel</span>
                            <span class="d-inline d-md-none">Estructura Excel</span>
                        </h5>
                    </div>
                    <div class="card-body p-2 p-md-3">
                        <!-- Vista móvil - Acordeón -->
                        <div class="d-md-none accordion" id="accordionExcelStructure">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNombre">
                                        <strong>A - Nombre</strong> <span class="badge bg-danger ms-2">Obligatorio</span>
                                    </button>
                                </h2>
                                <div id="collapseNombre" class="accordion-collapse collapse" data-bs-parent="#accordionExcelStructure">
                                    <div class="accordion-body small">
                                        <p><strong>Tipo:</strong> Texto</p>
                                        <p><strong>Ejemplo:</strong> Achiote Pepa Kilo</p>
                                        <p class="text-muted mb-0">Se normaliza automáticamente a slug</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseReferencia">
                                        <strong>B - Referencia</strong> <span class="badge bg-danger ms-2">Obligatorio</span>
                                    </button>
                                </h2>
                                <div id="collapseReferencia" class="accordion-collapse collapse" data-bs-parent="#accordionExcelStructure">
                                    <div class="accordion-body small">
                                        <p><strong>Tipo:</strong> Texto</p>
                                        <p><strong>Ejemplo:</strong> 001</p>
                                        <p class="text-muted mb-0">Código único - se usa para crear/actualizar</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDescripcion">
                                        <strong>C - Descripción</strong> <span class="badge bg-secondary ms-2">Opcional</span>
                                    </button>
                                </h2>
                                <div id="collapseDescripcion" class="accordion-collapse collapse" data-bs-parent="#accordionExcelStructure">
                                    <div class="accordion-body small">
                                        <p><strong>Tipo:</strong> Texto</p>
                                        <p><strong>Ejemplo:</strong> Color Intenso Y Sabor Suave, Perfecta Para...</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrecio">
                                        <strong>D - Precio</strong> <span class="badge bg-danger ms-2">Obligatorio</span>
                                    </button>
                                </h2>
                                <div id="collapsePrecio" class="accordion-collapse collapse" data-bs-parent="#accordionExcelStructure">
                                    <div class="accordion-body small">
                                        <p><strong>Tipo:</strong> Número</p>
                                        <p><strong>Ejemplo:</strong> 30000 o $30,000</p>
                                        <p class="text-muted mb-0">Puede ser 0, no negativo</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCosto">
                                        <strong>E - Costo</strong> <span class="badge bg-secondary ms-2">Opcional</span>
                                    </button>
                                </h2>
                                <div id="collapseCosto" class="accordion-collapse collapse" data-bs-parent="#accordionExcelStructure">
                                    <div class="accordion-body small">
                                        <p><strong>Tipo:</strong> Número</p>
                                        <p><strong>Ejemplo:</strong> 17500 o $17,500</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStock">
                                        <strong>F - Stock</strong> <span class="badge bg-danger ms-2">Obligatorio</span>
                                    </button>
                                </h2>
                                <div id="collapseStock" class="accordion-collapse collapse" data-bs-parent="#accordionExcelStructure">
                                    <div class="accordion-body small">
                                        <p><strong>Tipo:</strong> Número</p>
                                        <p><strong>Ejemplo:</strong> 0, 10, 100...</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseImagen">
                                        <strong>G - Nombre Imagen</strong> <span class="badge bg-secondary ms-2">Opcional</span>
                                    </button>
                                </h2>
                                <div id="collapseImagen" class="accordion-collapse collapse" data-bs-parent="#accordionExcelStructure">
                                    <div class="accordion-body small">
                                        <p><strong>Tipo:</strong> Texto</p>
                                        <p><strong>Ejemplo:</strong> achiote pepa.jpg</p>
                                        <p class="text-muted mb-0">Se guarda y normaliza para sincronización</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEstado">
                                        <strong>H - Estado</strong> <span class="badge bg-danger ms-2">Obligatorio</span>
                                    </button>
                                </h2>
                                <div id="collapseEstado" class="accordion-collapse collapse" data-bs-parent="#accordionExcelStructure">
                                    <div class="accordion-body small">
                                        <p><strong>Tipo:</strong> Texto</p>
                                        <p><strong>Ejemplo:</strong> activo o inactivo</p>
                                        <p class="text-muted mb-0">Solo estos dos valores</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Vista desktop - Tabla -->
                        <div class="d-none d-md-block table-responsive">
                            <table class="table table-bordered table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="80">Columna</th>
                                        <th width="150">Campo</th>
                                        <th width="100">Tipo</th>
                                        <th width="120">Obligatorio</th>
                                        <th>Ejemplo / Descripción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center fw-bold">A</td>
                                        <td>Nombre</td>
                                        <td>Texto</td>
                                        <td><span class="badge bg-danger">Sí</span></td>
                                        <td>
                                            Achiote Pepa Kilo
                                            <br><small class="text-muted">Se normaliza automáticamente a slug</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center fw-bold">B</td>
                                        <td>Referencia</td>
                                        <td>Texto</td>
                                        <td><span class="badge bg-danger">Sí</span></td>
                                        <td>
                                            001
                                            <br><small class="text-muted">Código único - se usa para crear/actualizar</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center fw-bold">C</td>
                                        <td>Descripción</td>
                                        <td>Texto</td>
                                        <td><span class="badge bg-secondary">No</span></td>
                                        <td>Color Intenso Y Sabor Suave, Perfecta Para...</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center fw-bold">D</td>
                                        <td>Precio</td>
                                        <td>Número</td>
                                        <td><span class="badge bg-danger">Sí</span></td>
                                        <td>
                                            30000 o $30,000
                                            <br><small class="text-muted">Puede ser 0, no negativo</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center fw-bold">E</td>
                                        <td>Costo</td>
                                        <td>Número</td>
                                        <td><span class="badge bg-secondary">No</span></td>
                                        <td>17500 o $17,500</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center fw-bold">F</td>
                                        <td>Stock</td>
                                        <td>Número</td>
                                        <td><span class="badge bg-danger">Sí</span></td>
                                        <td>0, 10, 100...</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center fw-bold">G</td>
                                        <td>Nombre Imagen</td>
                                        <td>Texto</td>
                                        <td><span class="badge bg-secondary">No</span></td>
                                        <td>
                                            achiote pepa.jpg
                                            <br><small class="text-muted">Se guarda y normaliza para sincronización</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center fw-bold">H</td>
                                        <td>Estado</td>
                                        <td>Texto</td>
                                        <td><span class="badge bg-danger">Sí</span></td>
                                        <td>
                                            activo o inactivo
                                            <br><small class="text-muted">Solo estos dos valores</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario de Importación -->
        <div class="row">
            <!-- PASO 1: Excel -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100" id="step1Card">
                    <div class="card-header bg-primary text-black">
                        <h5 class="mb-0">
                            <i class="bi bi-1-circle me-2 text-black"></i>
                            Paso 1: Cargar Archivo Excel
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="excelForm" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="excelFile" class="form-label">
                                    <i class="bi bi-file-earmark-excel me-1"></i>
                                    Selecciona el archivo Excel <span class="text-danger">*</span>
                                </label>
                                <input type="file" 
                                       class="form-control form-control-lg" 
                                       id="excelFile" 
                                       name="excel_file" 
                                       accept=".xlsx,.xls" 
                                       required>
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Formatos: .xlsx, .xls (máx. 10MB)
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg" id="btnProcessExcel">
                                    <i class="bi bi-arrow-right-circle me-1"></i>
                                    Procesar Excel y Crear/Actualizar Productos
                                </button>
                            </div>
                        </form>

                        <!-- Progreso del Excel -->
                        <div id="excelProgress" class="mt-3 d-none">
                            <div class="progress mb-2" style="height: 25px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                     role="progressbar" 
                                     style="width: 0%" 
                                     id="excelProgressBar">0%</div>
                            </div>
                            <p class="text-center mb-0 small" id="excelProgressText">Procesando...</p>
                        </div>

                        <!-- Resultado del Excel -->
                        <div id="excelResult" class="mt-3 d-none"></div>
                    </div>
                </div>
            </div>

            <!-- PASO 2: Imágenes -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100" id="step2Card">
                    <div class="card-header bg-info text-black">
                        <h5 class="mb-0">
                            <i class="bi bi-2-circle me-2"></i>
                            Paso 2: Cargar Imágenes (Opcional)
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(auth()->user()->empresa->productos()->count() > 0)
                            <div class="alert alert-success small">
                                <i class="bi bi-check-circle me-1"></i>
                                Tienes <strong>{{ auth()->user()->empresa->productos()->count() }}</strong> productos. Puedes cargar imágenes directamente.
                            </div>
                        @endif

                        <form id="imagesForm" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="imagesZip" class="form-label">
                                    <i class="bi bi-file-earmark-zip me-1"></i>
                                    Selecciona el archivo ZIP con imágenes
                                </label>
                                <input type="file" 
                                       class="form-control form-control-lg" 
                                       id="imagesZip" 
                                       name="images_zip" 
                                       accept=".zip">
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Formato: .zip (máx. 50MB). Las imágenes se sincronizan por nombre.
                                </div>
                            </div>

                            <div class="alert alert-warning small">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Las imágenes deben coincidir con los nombres definidos en la columna G del Excel. Se normalizan automáticamente.
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-info btn-lg" id="btnProcessImages">
                                    <i class="bi bi-upload me-1"></i>
                                    Procesar y Asignar Imágenes
                                </button>
                            </div>
                        </form>

                        <!-- Progreso de Imágenes -->
                        <div id="imagesProgress" class="mt-3 d-none">
                            <div class="progress mb-2" style="height: 25px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" 
                                     role="progressbar" 
                                     style="width: 0%" 
                                     id="imagesProgressBar">0%</div>
                            </div>
                            <p class="text-center mb-0 small" id="imagesProgressText">Procesando...</p>
                        </div>

                        <!-- Resultado de Imágenes -->
                        <div id="imagesResult" class="mt-3 d-none"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Errores Detallados -->
        <div class="row" id="errorsSection" style="display: none;">
            <div class="col-12">
                <div class="card border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Errores Encontrados Durante la Importación
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="errorsContent"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Import Productos - Mobile Optimized - Version 1.0 */
    
    .error-item {
        padding: 8px 12px;
        margin-bottom: 6px;
        border-left: 3px solid #dc3545;
        background-color: #f8d7da;
        border-radius: 4px;
    }
    
    .error-item:hover {
        background-color: #f1aeb5;
    }
    
    .success-card {
        border-left: 4px solid #28a745;
    }
    
    .warning-card {
        border-left: 4px solid #ffc107;
    }
    
    .info-card {
        border-left: 4px solid #17a2b8;
    }
    
    /* Mobile Optimizations */
    @media (max-width: 767px) {
        /* Header más compacto */
        .h3 {
            font-size: 1.3rem !important;
        }
        
        /* Botones full-width en móvil */
        .btn-lg {
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }
        
        /* Cards más compactas */
        .card-header h5 {
            font-size: 0.95rem;
        }
        
        /* Acordeón más legible */
        .accordion-button {
            font-size: 0.9rem;
            padding: 0.75rem 1rem;
        }
        
        .accordion-body {
            padding: 1rem;
        }
        
        .accordion-item {
            margin-bottom: 0.5rem;
            border-radius: 0.5rem !important;
            overflow: hidden;
        }
        
        .accordion-button:not(.collapsed) {
            background-color: #e7f3ff;
            color: #0d6efd;
        }
        
        /* Alertas más compactas */
        .alert {
            padding: 0.75rem;
        }
        
        .alert-heading {
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }
        
        /* Progress bars */
        .progress {
            height: 30px !important;
        }
        
        /* Resultados más legibles */
        .row.text-center .col-md-4 {
            margin-bottom: 0.75rem;
        }
        
        .row.text-center h3 {
            font-size: 1.75rem;
        }
        
        /* File inputs más grandes (táctil) */
        .form-control,
        .form-control-lg {
            min-height: 48px;
            font-size: 1rem;
        }
        
        input[type="file"] {
            padding: 0.75rem;
        }
        
        /* Badges más legibles */
        .badge {
            font-size: 0.7rem;
            padding: 0.35em 0.6em;
        }
        
        /* Cards de pasos con mejor espaciado */
        #step1Card .card-header,
        #step2Card .card-header {
            padding: 1rem;
        }
        
        #step1Card .card-body,
        #step2Card .card-body {
            padding: 1rem;
        }
    }
    
    @media (min-width: 768px) and (max-width: 991px) {
        /* Tablets */
        .h3 {
            font-size: 1.5rem !important;
        }
    }
    
    /* Animaciones suaves */
    .card {
        transition: all 0.3s ease;
    }
    
    .card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    /* Progress bar animations */
    .progress-bar-animated {
        animation: progress-bar-stripes 1s linear infinite;
    }
    
    @keyframes progress-bar-stripes {
        0% {
            background-position: 1rem 0;
        }
        100% {
            background-position: 0 0;
        }
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Configurar token CSRF
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // PASO 1: Procesar Excel
    $('#excelForm').on('submit', function(e) {
        e.preventDefault();
        
        const excelFile = $('#excelFile')[0].files[0];
        
        if (!excelFile) {
            Swal.fire({
                title: 'Error',
                text: 'Debes seleccionar un archivo Excel',
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
            return;
        }
        
        // Mostrar progreso
        $('#excelProgress').removeClass('d-none');
        $('#excelResult').addClass('d-none').empty();
        $('#errorsSection').hide();
        $('#btnProcessExcel').prop('disabled', true);
        $('#excelProgressBar').css('width', '10%').text('10%');
        $('#excelProgressText').text('Validando archivo Excel...');
        
        const formData = new FormData();
        formData.append('excel_file', excelFile);
        formData.append('_token', '{{ csrf_token() }}');
        
        $.ajax({
            url: '{{ route("admin.productos.import-excel") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = 10 + Math.round((evt.loaded / evt.total) * 80);
                        $('#excelProgressBar').css('width', percentComplete + '%').text(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                $('#excelProgressBar').css('width', '100%').text('100%').removeClass('progress-bar-animated');
                $('#excelProgressText').text('¡Excel procesado exitosamente!');
                
                setTimeout(() => {
                    $('#excelProgress').addClass('d-none');
                    mostrarResultadoExcel(response);
                    $('#btnProcessExcel').prop('disabled', false);
                }, 1000);
            },
            error: function(xhr) {
                $('#excelProgress').addClass('d-none');
                $('#btnProcessExcel').prop('disabled', false);
                
                let errorMessage = 'Error al procesar el archivo Excel';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    title: 'Error',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            }
        });
    });

    // PASO 2: Procesar Imágenes
    $('#imagesForm').on('submit', function(e) {
        e.preventDefault();
        
        const imagesZip = $('#imagesZip')[0].files[0];
        
        if (!imagesZip) {
            Swal.fire({
                title: 'Error',
                text: 'Debes seleccionar un archivo ZIP con las imágenes',
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
            return;
        }
        
        // Mostrar progreso
        $('#imagesProgress').removeClass('d-none');
        $('#imagesResult').addClass('d-none').empty();
        $('#errorsSection').hide();
        $('#btnProcessImages').prop('disabled', true);
        $('#imagesProgressBar').css('width', '10%').text('10%');
        $('#imagesProgressText').text('Procesando archivo ZIP...');
        
        const formData = new FormData();
        formData.append('images_zip', imagesZip);
        formData.append('_token', '{{ csrf_token() }}');
        
        $.ajax({
            url: '{{ route("admin.productos.import-images") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = 10 + Math.round((evt.loaded / evt.total) * 80);
                        $('#imagesProgressBar').css('width', percentComplete + '%').text(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                $('#imagesProgressBar').css('width', '100%').text('100%').removeClass('progress-bar-animated');
                $('#imagesProgressText').text('¡Imágenes procesadas!');
                
                setTimeout(() => {
                    $('#imagesProgress').addClass('d-none');
                    mostrarResultadoImagenes(response);
                    $('#btnProcessImages').prop('disabled', false);
                }, 1000);
            },
            error: function(xhr) {
                $('#imagesProgress').addClass('d-none');
                $('#btnProcessImages').prop('disabled', false);
                
                let errorMessage = 'Error al procesar las imágenes';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    title: 'Error',
                    html: errorMessage,
                    icon: 'error',
                    confirmButtonColor: '#dc3545',
                    width: '600px'
                });
            }
        });
    });

    function mostrarResultadoExcel(response) {
        let html = '<div class="card success-card">';
        html += '<div class="card-body">';
        html += '<h5 class="card-title text-success"><i class="bi bi-check-circle me-2"></i>Excel Procesado Exitosamente</h5>';
        html += '<div class="row text-center mt-3">';
        html += `<div class="col-md-4">
                    <div class="p-3 bg-success bg-opacity-10 rounded">
                        <h3 class="text-success mb-0">${response.created}</h3>
                        <small class="text-muted">Productos Creados</small>
                    </div>
                </div>`;
        html += `<div class="col-md-4">
                    <div class="p-3 bg-info bg-opacity-10 rounded">
                        <h3 class="text-info mb-0">${response.updated}</h3>
                        <small class="text-muted">Productos Actualizados</small>
                    </div>
                </div>`;
        html += `<div class="col-md-4">
                    <div class="p-3 ${response.errors && response.errors.length > 0 ? 'bg-warning' : 'bg-secondary'} bg-opacity-10 rounded">
                        <h3 class="${response.errors && response.errors.length > 0 ? 'text-warning' : 'text-secondary'} mb-0">${response.errors ? response.errors.length : 0}</h3>
                        <small class="text-muted">Errores</small>
                    </div>
                </div>`;
        html += '</div>';
        html += '</div>';
        html += '</div>';
        
        $('#excelResult').html(html).removeClass('d-none');
        
        // Mostrar errores si los hay
        if (response.errors && response.errors.length > 0) {
            mostrarErrores(response.errors, 'Excel');
        }
        
        // Scroll suave al resultado
        $('html, body').animate({
            scrollTop: $('#excelResult').offset().top - 100
        }, 500);
    }

    function mostrarResultadoImagenes(response) {
        let html = '<div class="card info-card">';
        html += '<div class="card-body">';
        html += '<h5 class="card-title text-info"><i class="bi bi-image me-2"></i>Imágenes Procesadas</h5>';
        html += '<div class="row text-center mt-3">';
        html += `<div class="col-md-4">
                    <div class="p-3 bg-primary bg-opacity-10 rounded">
                        <h3 class="text-primary mb-0">${response.processed}</h3>
                        <small class="text-muted">Archivos Procesados</small>
                    </div>
                </div>`;
        html += `<div class="col-md-4">
                    <div class="p-3 bg-success bg-opacity-10 rounded">
                        <h3 class="text-success mb-0">${response.assigned}</h3>
                        <small class="text-muted">Imágenes Asignadas</small>
                    </div>
                </div>`;
        html += `<div class="col-md-4">
                    <div class="p-3 ${response.errors && response.errors.length > 0 ? 'bg-warning' : 'bg-secondary'} bg-opacity-10 rounded">
                        <h3 class="${response.errors && response.errors.length > 0 ? 'text-warning' : 'text-secondary'} mb-0">${response.errors ? response.errors.length : 0}</h3>
                        <small class="text-muted">Errores</small>
                    </div>
                </div>`;
        html += '</div>';
        html += '</div>';
        html += '</div>';
        
        $('#imagesResult').html(html).removeClass('d-none');
        
        // Mostrar errores si los hay
        if (response.errors && response.errors.length > 0) {
            mostrarErrores(response.errors, 'Imágenes');
        }
        
        // Scroll suave al resultado
        $('html, body').animate({
            scrollTop: $('#imagesResult').offset().top - 100
        }, 500);
    }

    function mostrarErrores(errors, tipo) {
        let html = '<div class="mb-3">';
        html += `<h6 class="text-danger"><i class="bi bi-exclamation-circle me-2"></i>Errores en ${tipo} (${errors.length})</h6>`;
        html += '<div class="list-group">';
        
        errors.forEach((error, index) => {
            html += `<div class="error-item">
                        <span class="badge bg-danger me-2">${index + 1}</span>
                        ${error}
                     </div>`;
        });
        
        html += '</div>';
        html += '</div>';
        
        $('#errorsContent').append(html);
        $('#errorsSection').show();
        
        // Scroll suave a los errores
        setTimeout(() => {
            $('html, body').animate({
                scrollTop: $('#errorsSection').offset().top - 100
            }, 500);
        }, 300);
    }
});
</script>
@endpush
