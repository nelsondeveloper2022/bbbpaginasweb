@extends('layout            <a href="{{ route('admin.productos.create') }}" class="btn btn-primary-gold">
                <i class="bi bi-plus-circle me-1"></i>
                Agregar Producto
            </a>shboard')

@section('title', 'Productos - BBB Páginas Web')
@section('description', 'Gestiona los productos de tu empresa')

@section('content')
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="dashboard-title">
                <i class="bi bi-box-seam text-primary-gold me-2"></i>
                Productos
            </h1>
            <p class="text-muted mb-0">Gestiona el catálogo de productos de {{ $empresa->nombre }}</p>
        </div>
        <div>
            <a href="{{ route('productos.create') }}" class="btn btn-primary-gold">
                <i class="bi bi-plus-circle me-1"></i>
                Nuevo Producto
            </a>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="card mb-4">
    <div class="card-body">
                <form method="GET" action="{{ route('admin.productos.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="search" class="form-label">Buscar producto</label>
                <input type="text" 
                       class="form-control" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Nombre del producto...">
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6">
                <div class="form-group">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-select" id="estado" name="estado">
                        <option value="">Todos los estados</option>
                        <option value="activo" {{ request('estado') === 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ request('estado') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5 col-md-6">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary-gold flex-fill">
                        <i class="bi bi-search me-1"></i>
                        Buscar
                    </button>
                                        <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary flex-fill">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>
                        Limpiar Filtros
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Lista de productos -->
@if($productos->count() > 0)
    <div class="row">
        @foreach($productos as $producto)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card h-100 producto-card">
                    <div class="position-relative">
                        @if($producto->imagen_url)
                            <img src="{{ $producto->imagen_url }}" 
                                 class="card-img-top" 
                                 alt="{{ $producto->nombre }}"
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                 style="height: 200px;">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        
                        <!-- Estado badge -->
                        <div class="position-absolute top-0 end-0 m-2">
                            @if($producto->estado === 'activo')
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-secondary">Inactivo</span>
                            @endif
                        </div>
                        
                        <!-- Stock badge si es bajo -->
                        @if($producto->stock <= 5)
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-warning text-dark">
                                    Stock: {{ $producto->stock }}
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                        @if($producto->descripcion)
                            <p class="card-text text-muted small flex-grow-1">
                                {{ Str::limit($producto->descripcion, 100) }}
                            </p>
                        @endif
                        
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <strong class="text-primary-red fs-5">
                                        ${{ $producto->precio_formateado }}
                                    </strong>
                                    <br>
                                    <small class="text-muted">Stock: {{ $producto->stock }}</small>
                                </div>
                            </div>
                            
                            <div class="btn-group w-100" role="group">
                                <a href="{{ route('admin.productos.show', $producto) }}" 
                                   class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.productos.edit', $producto) }}" 
                                   class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-outline-danger btn-sm"
                                        onclick="confirmarEliminacion('{{ $producto->idProducto }}', '{{ $producto->nombre }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-center">
        {{ $productos->withQueryString()->links() }}
    </div>

@else
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-box-seam text-muted mb-3" style="font-size: 4rem;"></i>
            <h4 class="text-muted mb-3">No hay productos</h4>
            @if(request()->hasAny(['search', 'estado']))
                <p class="text-muted mb-4">No se encontraron productos con los filtros aplicados.</p>
                <a href="{{ route('productos.index') }}" class="btn btn-outline-primary-gold me-2">
                    <i class="bi bi-arrow-left me-1"></i>
                    Ver todos los productos
                </a>
            @else
                <p class="text-muted mb-4">Aún no has creado ningún producto. ¡Comienza agregando tu primer producto!</p>
            @endif
                            <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-primary-gold me-2">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver
                </a>
            </div>
            <div class="text-center">
            <a href="{{ route('admin.productos.create') }}" class="btn btn-primary-gold">
                <i class="bi bi-plus-circle me-1"></i>
                Crear Primer Producto
            </a>
        </div>
    </div>
@endif

<!-- Form para eliminar producto -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('styles')
<style>
    .producto-card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
    
    .producto-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .card-img-top {
        transition: all 0.3s ease;
    }
    
    .producto-card:hover .card-img-top {
        transform: scale(1.05);
    }
</style>
@endpush

@push('scripts')
<script>
function confirmarEliminacion(productId, productName) {
    Swal.fire({
        title: '¿Estás seguro?',
        html: `
            <div class="text-center">
                <div class="mb-3">
                    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                </div>
                <p>Estás a punto de eliminar el producto:</p>
                <p class="fw-bold text-danger">${productName}</p>
                <p class="text-muted small">Esta acción no se puede deshacer.</p>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-trash me-1"></i> Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteForm');
            form.action = `/productos/${productId}`;
            form.submit();
        }
    });
}
</script>
@endpush