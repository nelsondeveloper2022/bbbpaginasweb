@extends('layouts.dashboard')

@section('title', 'Ver Producto')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-eye me-2"></i>
                Ver Producto
            </h1>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.productos.edit', $producto) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-1"></i> Editar
                </a>
                <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Volver
                </a>
            </div>
        </div>

        <!-- Información Básica -->
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
                        <label class="form-label fw-semibold">
                            <i class="bi bi-box-seam text-primary me-1"></i>
                            Nombre del Producto
                        </label>
                        <div class="form-control-plaintext fs-5 fw-medium">{{ $producto->nombre }}</div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-tag text-info me-1"></i>
                            Referencia / SKU
                        </label>
                        <div class="form-control-plaintext">
                            {{ $producto->referencia ?: 'No especificada' }}
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-toggle-on text-success me-1"></i>
                            Estado
                        </label>
                        <div class="form-control-plaintext">
                            @if($producto->estado === 'activo')
                                <span class="badge bg-success fs-6">
                                    <i class="bi bi-check-circle me-1"></i>Activo
                                </span>
                            @else
                                <span class="badge bg-danger fs-6">
                                    <i class="bi bi-x-circle me-1"></i>Inactivo
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                @if($producto->descripcion)
                <div class="row g-3 mt-2">
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-text-paragraph me-1"></i>
                            Descripción
                        </label>
                        <div class="form-control-plaintext border-0 bg-light p-3 rounded">
                            {{ $producto->descripcion }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Información de Precios y Stock -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-currency-dollar me-2"></i>
                    Precios y Stock
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-xl-4 col-lg-4 col-md-4">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-tag-fill text-success me-1"></i>
                            Precio de Venta
                        </label>
                        <div class="form-control-plaintext fs-4 fw-bold text-success">
                            ${{ number_format($producto->precio, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-receipt text-warning me-1"></i>
                            Costo del Producto
                        </label>
                        <div class="form-control-plaintext fs-5">
                            ${{ number_format($producto->costo, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-boxes text-info me-1"></i>
                            Stock Actual
                        </label>
                        <div class="form-control-plaintext fs-5">
                            @if($producto->stock > 0)
                                <span class="text-success fw-bold">{{ number_format($producto->stock, 0, ',', '.') }} unidades</span>
                            @elseif($producto->stock == 0)
                                <span class="text-danger fw-bold">Sin stock</span>
                            @else
                                <span class="text-muted">{{ number_format($producto->stock, 0, ',', '.') }} unidades</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Indicador de margen de ganancia -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-calculator me-2"></i>
                                <div>
                                    <strong>Margen de Ganancia:</strong> 
                                    <span class="fw-bold">{{ $producto->costo > 0 ? number_format((($producto->precio - $producto->costo) / $producto->costo) * 100, 1) : 0 }}%</span>
                                    <br>
                                    <small class="text-muted">
                                        Ganancia por unidad: <span class="fw-semibold">${{ number_format($producto->precio - $producto->costo, 0, ',', '.') }}</span>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Imágenes del Producto -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-images me-2"></i>
                    Imágenes del Producto
                </h5>
            </div>
            <div class="card-body">
                @if($producto->imagenPrincipal)
                    <!-- Imagen Principal -->
                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3">
                            <i class="bi bi-star-fill text-warning me-1"></i>
                            Imagen Principal
                        </h6>
                        <div class="text-center">
                            <div class="position-relative d-inline-block">
                                <img src="{{ asset('storage/' . $producto->imagenPrincipal->ruta) }}" 
                                     alt="{{ $producto->nombre }}" 
                                     class="img-fluid rounded shadow-sm"
                                     style="max-height: 300px; max-width: 100%; object-fit: contain;">
                                <span class="position-absolute top-0 start-100 translate-middle badge bg-warning text-dark">
                                    <i class="bi bi-star-fill"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                @endif

                @if($producto->imagenes && $producto->imagenes->count() > 0)
                    <!-- Galería de Imágenes -->
                    <div class="mb-3">
                        <h6 class="fw-semibold mb-3">
                            <i class="bi bi-collection me-1"></i>
                            Galería de Imágenes ({{ $producto->imagenes->count() }} imagen{{ $producto->imagenes->count() !== 1 ? 'es' : '' }})
                        </h6>
                        <div class="row g-3">
                            @foreach($producto->imagenes as $imagen)
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="card h-100">
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/' . $imagen->ruta) }}" 
                                                 alt="{{ $producto->nombre }}" 
                                                 class="card-img-top"
                                                 style="height: 200px; object-fit: cover;">
                                            @if($imagen->es_principal)
                                                <span class="position-absolute top-0 end-0 m-2 badge bg-warning text-dark">
                                                    <i class="bi bi-star-fill me-1"></i>Principal
                                                </span>
                                            @endif
                                        </div>
                                        <div class="card-body p-2">
                                            <small class="text-muted">
                                                <i class="bi bi-sort-numeric-up me-1"></i>
                                                Orden: {{ $imagen->orden ?? 'Sin orden' }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <!-- Sin Imágenes -->
                    <div class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-image display-1 mb-3"></i>
                            <h5>Sin imágenes</h5>
                            <p class="mb-0">Este producto no tiene imágenes asociadas.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Información Adicional -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-clock-history me-2"></i>
                    Información Adicional
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-calendar-plus me-1"></i>
                            Fecha de Creación
                        </label>
                        <div class="form-control-plaintext">
                            {{ $producto->created_at->format('d/m/Y H:i:s') }}
                            <small class="text-muted d-block">{{ $producto->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-calendar-check me-1"></i>
                            Última Actualización
                        </label>
                        <div class="form-control-plaintext">
                            {{ $producto->updated_at->format('d/m/Y H:i:s') }}
                            <small class="text-muted d-block">{{ $producto->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-link-45deg me-1"></i>
                            Slug
                        </label>
                        <div class="form-control-plaintext">
                            <code>{{ $producto->slug ?: 'No generado' }}</code>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-building me-1"></i>
                            Empresa
                        </label>
                        <div class="form-control-plaintext">
                            {{ $empresa->nombre }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver al Listado
            </a>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.productos.edit', $producto) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-1"></i> Editar Producto
                </a>
                @if($producto->estado === 'activo')
                    <button type="button" class="btn btn-outline-warning" onclick="cambiarEstado('inactivo')">
                        <i class="bi bi-pause-circle me-1"></i> Desactivar
                    </button>
                @else
                    <button type="button" class="btn btn-outline-success" onclick="cambiarEstado('activo')">
                        <i class="bi bi-play-circle me-1"></i> Activar
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal para vista previa de imágenes -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Vista Previa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
// Función para cambiar estado del producto
function cambiarEstado(nuevoEstado) {
    const estadoTexto = nuevoEstado === 'activo' ? 'activar' : 'desactivar';
    const estadoCapitalizado = estadoTexto.charAt(0).toUpperCase() + estadoTexto.slice(1);
    
    Swal.fire({
        title: `¿${estadoCapitalizado} producto?`,
        text: `¿Estás seguro de que deseas ${estadoTexto} este producto?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: `Sí, ${estadoTexto}`,
        cancelButtonText: 'Cancelar',
        confirmButtonColor: nuevoEstado === 'activo' ? '#28a745' : '#ffc107',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            // Crear formulario para enviar la petición
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.productos.update", $producto) }}';
            
            // Token CSRF
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            // Método PUT
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);
            
            // Estado
            const estadoInput = document.createElement('input');
            estadoInput.type = 'hidden';
            estadoInput.name = 'estado';
            estadoInput.value = nuevoEstado;
            form.appendChild(estadoInput);
            
            // Mantener otros campos
            const campos = ['nombre', 'referencia', 'descripcion', 'precio', 'costo', 'stock'];
            campos.forEach(campo => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = campo;
                
                switch(campo) {
                    case 'nombre':
                        input.value = '{{ $producto->nombre }}';
                        break;
                    case 'referencia':
                        input.value = '{{ $producto->referencia }}';
                        break;
                    case 'descripcion':
                        input.value = `{{ str_replace(['`', '"', "'"], ['\\`', '\\"', '\\\''], $producto->descripcion ?? '') }}`;
                        break;
                    case 'precio':
                        input.value = '{{ $producto->precio }}';
                        break;
                    case 'costo':
                        input.value = '{{ $producto->costo }}';
                        break;
                    case 'stock':
                        input.value = '{{ $producto->stock }}';
                        break;
                }
                form.appendChild(input);
            });
            
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Función para mostrar vista previa de imágenes
document.addEventListener('DOMContentLoaded', function() {
    // Agregar evento click a todas las imágenes para vista previa
    const imagenes = document.querySelectorAll('.card-img-top, .img-fluid');
    imagenes.forEach(imagen => {
        imagen.style.cursor = 'pointer';
        imagen.addEventListener('click', function() {
            const modalImage = document.getElementById('modalImage');
            modalImage.src = this.src;
            modalImage.alt = this.alt;
            
            const modal = new bootstrap.Modal(document.getElementById('imageModal'));
            modal.show();
        });
    });
});
</script>

@if(session('success'))
<script>
    Swal.fire({
        title: '¡Éxito!',
        text: '{{ session("success") }}',
        icon: 'success',
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        title: 'Error',
        text: '{{ session("error") }}',
        icon: 'error',
        confirmButtonText: 'Entendido'
    });
</script>
@endif
@endpush

@push('styles')
<style>
.form-control-plaintext {
    padding-left: 0;
    padding-right: 0;
}

.img-fluid:hover {
    transform: scale(1.02);
    transition: transform 0.2s ease;
}

.card-img-top:hover {
    transform: scale(1.05);
    transition: transform 0.2s ease;
}

.badge {
    font-size: 0.875em;
}

code {
    color: #6f42c1;
    background-color: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
}
</style>
@endpush