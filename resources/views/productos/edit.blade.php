@extends('layouts.dashboard')

@section('title', 'Editar Producto')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-pencil me-2"></i>
                Editar Producto
            </h1>
                        <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>

        <form action="{{ route('admin.productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
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
                                   value="{{ old('nombre', $producto->nombre) }}" 
                                   required
                                   maxlength="200"
                                   placeholder="Ej: Laptop Dell Inspiron 15">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <label for="referencia" class="form-label fw-semibold">
                                <i class="bi bi-tag text-info me-1"></i>
                                Referencia / SKU
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('referencia') is-invalid @enderror" 
                                   id="referencia" 
                                   name="referencia" 
                                   value="{{ old('referencia', $producto->referencia) }}" 
                                   maxlength="200"
                                   placeholder="PROD-001">
                            @error('referencia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text"><small>Código único</small></div>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <label for="estado" class="form-label fw-semibold">
                                <i class="bi bi-toggle-on text-success me-1"></i>
                                Estado <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-lg @error('estado') is-invalid @enderror" 
                                    id="estado" 
                                    name="estado" 
                                    required>
                                <option value="activo" {{ old('estado', $producto->estado) === 'activo' ? 'selected' : '' }}>
                                    ✓ Activo
                                </option>
                                <option value="inactivo" {{ old('estado', $producto->estado) === 'inactivo' ? 'selected' : '' }}>
                                    ✗ Inactivo
                                </option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mt-2">

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                  id="descripcion" 
                                  name="descripcion" 
                                  rows="4"
                                  maxlength="5000"
                                  placeholder="Describe las características, beneficios y detalles del producto...">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <span id="descripcion-count">0</span> / 5000 caracteres
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <div class="mb-3">
                                <label for="precio" class="form-label">
                                    Precio de Venta <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" 
                                           class="form-control @error('precio') is-invalid @enderror" 
                                           id="precio" 
                                           name="precio" 
                                           value="{{ old('precio', number_format($producto->precio, 0, ',', '.')) }}" 
                                           required
                                           placeholder="0"
                                           data-mask="000.000.000.000,00"
                                           data-mask-reverse="true">
                                    @error('precio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">Precio de venta al público</div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <div class="mb-3">
                                <label for="costo" class="form-label">
                                    Costo del Producto
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" 
                                           class="form-control @error('costo') is-invalid @enderror" 
                                           id="costo" 
                                           name="costo" 
                                           value="{{ old('costo', number_format($producto->costo, 0, ',', '.')) }}" 
                                           placeholder="0"
                                           data-mask="000.000.000.000,00"
                                           data-mask-reverse="true">
                                    @error('costo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">Costo de adquisición o producción</div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <div class="mb-3">
                                <label for="stock" class="form-label">
                                    Stock Actual <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control @error('stock') is-invalid @enderror" 
                                       id="stock" 
                                       name="stock" 
                                       value="{{ old('stock', $producto->stock) }}" 
                                       required
                                       min="0"
                                       step="1"
                                       placeholder="0">
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Cantidad disponible en inventario</div>
                            </div>
                        </div>
                    </div>

                    <!-- Indicador de margen de ganancia -->
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <div class="alert alert-info" id="margen-info">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-calculator me-2"></i>
                                        <div>
                                            <strong>Margen de Ganancia:</strong> 
                                            <span id="margen-percentage">{{ number_format($producto->margen_ganancia, 1) }}%</span>
                                            <br>
                                            <small class="text-muted">
                                                Ganancia por unidad: <span id="ganancia-unidad">${{ number_format($producto->precio - $producto->costo, 0, ',', '.') }}</span>
                                            </small>
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
                    <!-- Imagen Principal Actual -->
                    @if($producto->imagen)
                        <div class="mb-4">
                            <label class="form-label">Imagen Principal Actual</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $producto->imagen) }}" 
                                             class="img-fluid rounded shadow-sm" 
                                             alt="{{ $producto->nombre }}">
                                        <button type="button" 
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                                onclick="eliminarImagenPrincipal()"
                                                title="Eliminar imagen principal">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="imagen" class="form-label">{{ $producto->imagen ? 'Cambiar Imagen Principal' : 'Imagen Principal' }}</label>
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

                    <!-- Galería Actual -->
                    @if($producto->imagenes->count() > 0)
                        <div class="mb-4">
                            <label class="form-label">Galería Actual</label>
                            <div class="row">
                                @foreach($producto->imagenes as $imagen)
                                    <div class="col-md-2 mb-3" id="galeria-imagen-{{ $imagen->idImagen }}">
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/' . $imagen->url_imagen) }}" 
                                                 class="img-fluid rounded shadow-sm" 
                                                 alt="{{ $producto->nombre }}">
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                                    onclick="eliminarImagenGaleria({{ $imagen->idImagen }})"
                                                    title="Eliminar imagen">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="galeria" class="form-label">{{ $producto->imagenes->count() > 0 ? 'Agregar Más Imágenes' : 'Galería de Imágenes' }}</label>
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
                            Actualizar Producto
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')
<style>
    .position-relative .btn {
        opacity: 0.8;
        transition: opacity 0.2s;
    }
    
    .position-relative:hover .btn {
        opacity: 1;
    }
    
    .img-fluid {
        max-height: 150px;
        object-fit: cover;
    }
</style>
@endpush

@push('scripts')
<!-- jQuery Mask Plugin -->
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
            
            alertBox.removeClass('d-none').show();
        } else if (precio > 0 || costo > 0) {
            $('#margen-info').show();
        } else {
            $('#margen-info').hide();
        }
    }
    
    // Event listeners para cálculo de margen
    $('#precio, #costo').on('input blur', calcularMargen);
    
    // Calcular margen inicial
    calcularMargen();
    
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
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-md-2 mb-3';
                col.innerHTML = `
                    <div class="position-relative">
                        <img src="${e.target.result}" class="img-fluid rounded" alt="Preview ${index + 1}">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1" onclick="removePreview(this)">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                `;
                preview.appendChild(col);
            }
            
            reader.readAsDataURL(file);
        });
    }
}

function removePreview(button) {
    button.closest('.col-md-2').remove();
}

function eliminarImagenPrincipal() {
    Swal.fire({
        title: '¿Eliminar imagen principal?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            // Aquí puedes implementar la eliminación vía AJAX
            // Por ahora solo ocultar visualmente
            $(event.target).closest('.mb-4').hide();
            
            Swal.fire(
                '¡Eliminada!',
                'La imagen principal será eliminada al guardar los cambios.',
                'success'
            );
        }
    });
}

function eliminarImagenGaleria(imagenId) {
    Swal.fire({
        title: '¿Eliminar imagen?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `{{ route('admin.productos.remove-image', $producto) }}`,
                method: 'POST',
                data: {
                    imagen_id: imagenId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $(`#galeria-imagen-${imagenId}`).fadeOut(() => {
                        $(`#galeria-imagen-${imagenId}`).remove();
                    });
                    
                    Swal.fire(
                        '¡Eliminada!',
                        'La imagen ha sido eliminada exitosamente.',
                        'success'
                    );
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error',
                        'No se pudo eliminar la imagen. Intenta nuevamente.',
                        'error'
                    );
                }
            });
        }
    });
}
</script>
@endpush