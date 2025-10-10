@extends('layouts.dashboard')

@section('title', 'Crear Producto - BBB Páginas Web')
@section('description', 'Crear un nuevo producto para tu catálogo')

@section('content')
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="dashboard-title">
                <i class="bi bi-plus-circle text-primary-gold me-2"></i>
                Crear Producto
            </h1>
            <p class="text-muted mb-0">Agrega un nuevo producto al catálogo de {{ $empresa->nombre }}</p>
        </div>
        <div>
            <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Volver a Productos
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 col-lg-7">
        <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data" id="productoForm">
            @csrf
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Información Básica
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-7 col-md-7">
                            <label for="nombre" class="form-label fw-semibold">
                                <i class="bi bi-box-seam text-primary me-1"></i>
                                Nombre del Producto <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('nombre') is-invalid @enderror" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="{{ old('nombre') }}" 
                                   required
                                   maxlength="200"
                                   placeholder="Ej: Laptop Dell Inspiron 15">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-lg-5 col-md-3">
                            <label for="referencia" class="form-label fw-semibold">
                                <i class="bi bi-tag text-info me-1"></i>
                                Referencia / SKU
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('referencia') is-invalid @enderror" 
                                   id="referencia" 
                                   name="referencia" 
                                   value="{{ old('referencia') }}" 
                                   maxlength="200"
                                   placeholder="PROD-001">
                            @error('referencia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text"><small>Código único</small></div>
                        </div>
                        <div class="col-lg-7 col-md-2">
                            <label for="estado" class="form-label fw-semibold">
                                <i class="bi bi-toggle-on text-success me-1"></i>
                                Estado <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-lg @error('estado') is-invalid @enderror" 
                                    id="estado" 
                                    name="estado" 
                                    required>
                                <option value="activo" {{ old('estado', 'activo') === 'activo' ? 'selected' : '' }}>
                                    ✓ Activo
                                </option>
                                <option value="inactivo" {{ old('estado') === 'inactivo' ? 'selected' : '' }}>
                                    ✗ Inactivo
                                </option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mt-2">

                        <div class="col-12">
                            <label for="descripcion" class="form-label fw-semibold">
                                <i class="bi bi-text-paragraph text-secondary me-1"></i>
                                Descripción
                            </label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      id="descripcion" 
                                      name="descripcion" 
                                      rows="4"
                                      maxlength="5000"
                                      placeholder="Describe las características, beneficios y detalles del producto...">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text d-flex justify-content-between">
                                <span><i class="bi bi-info-circle me-1"></i>Proporciona detalles que ayuden a identificar el producto</span>
                                <span><span id="descripcion-count">0</span> / 5000</span>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3">
                        <i class="bi bi-currency-dollar text-success me-2"></i>
                        Información de Precios y Stock
                    </h6>

                    <div class="row g-3">
                        <div class="col-lg-4 col-md-4">
                            <label for="precio" class="form-label fw-semibold">
                                <i class="bi bi-cash-stack text-success me-1"></i>
                                Precio de Venta <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-success text-white">
                                    <i class="bi bi-currency-dollar"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('precio') is-invalid @enderror" 
                                       id="precio" 
                                       name="precio" 
                                       value="{{ old('precio') }}" 
                                       required
                                       placeholder="0"
                                       data-mask="000.000.000.000,00"
                                       data-mask-reverse="true">
                                @error('precio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text"><small>💰 Precio de venta al público</small></div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <label for="costo" class="form-label fw-semibold">
                                <i class="bi bi-calculator text-warning me-1"></i>
                                Costo del Producto
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-warning">
                                    <i class="bi bi-receipt"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('costo') is-invalid @enderror" 
                                       id="costo" 
                                       name="costo" 
                                       value="{{ old('costo', 0) }}" 
                                       placeholder="0"
                                       data-mask="000.000.000.000,00"
                                       data-mask-reverse="true">
                                @error('costo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text"><small>📊 Costo de adquisición</small></div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <label for="stock" class="form-label fw-semibold">
                                <i class="bi bi-box text-info me-1"></i>
                                Stock Inicial <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-info text-white">
                                    <i class="bi bi-boxes"></i>
                                </span>
                                <input type="number" 
                                       class="form-control @error('stock') is-invalid @enderror" 
                                       id="stock" 
                                       name="stock" 
                                       value="{{ old('stock', 0) }}" 
                                       required
                                       min="0"
                                       step="1"
                                       placeholder="0">
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text"><small>📦 Cantidad disponible</small></div>
                        </div>
                    </div>

                    <!-- Indicador de margen de ganancia -->
                    <div class="row g-3 mt-2">
                        <div class="col-12">
                            <div class="alert alert-success border-start border-success border-4 d-none" id="margen-info" style="background-color: #d1e7dd;">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="bi bi-graph-up-arrow fs-4"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="mb-1 text-success">
                                            <i class="bi bi-calculator me-2"></i>
                                            Margen de Ganancia
                                        </h6>
                                        <div class="d-flex gap-4">
                                            <div>
                                                <small class="text-muted d-block">Porcentaje</small>
                                                <strong class="fs-5 text-success" id="margen-percentage">0%</strong>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Ganancia por unidad</small>
                                                <strong class="fs-5 text-success" id="ganancia-unidad">$0</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-images me-2"></i>
                        Imágenes del Producto
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen Principal</label>
                        <input type="file" 
                               class="form-control @error('imagen') is-invalid @enderror" 
                               id="imagen" 
                               name="imagen"
                               accept="image/*"
                               onchange="previewImage(this, 'imagen-preview')">
                        @error('imagen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Formatos: JPG, PNG, GIF, WEBP. Tamaño máximo: 5MB</div>
                        
                        <!-- Preview imagen principal -->
                        <div id="imagen-preview" class="mt-3" style="display: none;">
                            <img src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="galeria" class="form-label">Galería de Imágenes</label>
                        <input type="file" 
                               class="form-control @error('galeria.*') is-invalid @enderror" 
                               id="galeria" 
                               name="galeria[]"
                               accept="image/*"
                               multiple
                               onchange="previewGallery(this)">
                        @error('galeria.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Puedes seleccionar múltiples imágenes. Máximo 5MB por imagen.</div>
                        
                        <!-- Preview galería -->
                        <div id="galeria-preview" class="mt-3 row"></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary-gold">
                            <i class="bi bi-check-circle me-1"></i>
                            Crear Producto
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="card sticky-top" style="top: 20px;">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-lightbulb me-2"></i>
                    Consejos
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-primary-gold">📝 Nombre efectivo</h6>
                    <p class="small text-muted">Usa nombres descriptivos y específicos. Incluye marca, modelo y características principales.</p>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-primary-gold">📸 Imágenes de calidad</h6>
                    <p class="small text-muted">Usa imágenes claras y bien iluminadas. La imagen principal debe mostrar el producto completo.</p>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-primary-gold">💰 Precio competitivo</h6>
                    <p class="small text-muted">Investiga precios similares en el mercado para establecer un precio atractivo.</p>
                </div>
                
                <div class="mb-0">
                    <h6 class="text-primary-gold">📦 Control de stock</h6>
                    <p class="small text-muted">Mantén actualizado el stock para evitar ventas de productos no disponibles.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .sticky-top {
        z-index: 1020;
    }
    
    .img-thumbnail {
        border: 2px solid #f0ac21;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
$(document).ready(function() {
    // Mask para precio y costo (sin decimales para Colombia)
    $('#precio').mask('000.000.000.000', {reverse: true});
    $('#costo').mask('000.000.000.000', {reverse: true});
    
    // Calcular margen de ganancia en tiempo real
    function calcularMargen() {
        const precioText = $('#precio').val().replace(/\./g, '');
        const costoText = $('#costo').val().replace(/\./g, '');
        
        const precio = parseInt(precioText) || 0;
        const costo = parseInt(costoText) || 0;
        
        if (precio > 0 && costo > 0) {
            const ganancia = precio - costo;
            const margen = ((ganancia / costo) * 100);
            
            $('#margen-percentage').text(margen.toFixed(1) + '%');
            $('#ganancia-unidad').text('$' + ganancia.toLocaleString('es-CO', {maximumFractionDigits: 0}));
            
            // Cambiar color según el margen
            const alertBox = $('#margen-info');
            alertBox.removeClass('alert-success alert-warning alert-danger').addClass('alert-info');
            
            if (margen > 50) {
                alertBox.removeClass('alert-info').addClass('alert-success');
            } else if (margen > 20) {
                alertBox.removeClass('alert-info').addClass('alert-warning');
            } else if (margen > 0) {
                alertBox.removeClass('alert-info').addClass('alert-danger');
            }
            
            alertBox.removeClass('d-none');
        } else {
            $('#margen-info').addClass('d-none');
        }
    }
    
    // Event listeners para cálculo de margen
    $('#precio, #costo').on('input blur', calcularMargen);
    
    // Contador de caracteres para descripción
    $('#descripcion').on('input', function() {
        const count = $(this).val().length;
        $('#descripcion-count').text(count);
        
        if (count > 4500) {
            $('#descripcion-count').addClass('text-warning');
        } else if (count > 4800) {
            $('#descripcion-count').addClass('text-danger').removeClass('text-warning');
        } else {
            $('#descripcion-count').removeClass('text-warning text-danger');
        }
    });
    
    // Trigger inicial para el contador
    $('#descripcion').trigger('input');
});

function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    const img = preview.querySelector('img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}

function previewGallery(input) {
    const preview = document.getElementById('galeria-preview');
    preview.innerHTML = '';
    
    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-6 col-md-4 mb-2';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail w-100';
                    img.style.height = '120px';
                    img.style.objectFit = 'cover';
                    
                    col.appendChild(img);
                    preview.appendChild(col);
                }
                
                reader.readAsDataURL(file);
            }
        });
    }
}
</script>
@endpush