@extends('layouts.dashboard')

@section('title', 'Editar Venta #' . $venta->idVenta)

@section('content')
    <div class="container-fluid">
        <div class="row align-items-center mb-4">
            <div class="col-12 mb-3 mb-md-0">
                <h1 class="h3 mb-2">
                    <i class="bi bi-pencil-square me-2"></i>
                    Editar Venta <span class="d-none d-sm-inline">#</span>{{ $venta->idVenta }}
                </h1>
            </div>
            <div class="col-12">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.ventas.show', $venta) }}" class="btn btn-outline-info flex-fill flex-sm-grow-0">
                        <i class="bi bi-eye me-1"></i> <span class="d-none d-sm-inline">Ver</span>
                    </a>
                    <a href="{{ route('admin.ventas.print', $venta) }}" target="_blank" class="btn btn-outline-primary flex-fill flex-sm-grow-0">
                        <i class="bi bi-printer me-1"></i> <span class="d-none d-sm-inline">Imprimir</span>
                    </a>
                    <a href="{{ route('admin.ventas.index') }}" class="btn btn-outline-secondary flex-fill flex-sm-grow-0">
                        <i class="bi bi-arrow-left me-1"></i> <span class="d-none d-sm-inline">Volver</span>
                    </a>
                </div>
            </div>
        </div>

        @if($venta->estado === 'completada')
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Advertencia:</strong> Esta venta está completada y no puede ser editada.
            </div>
        @else
            <form action="{{ route('admin.ventas.update', $venta) }}" method="POST" id="ventaEditForm">
                @csrf
                @method('PUT')
                
                <!-- Información del Cliente -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-person me-2"></i>
                            <span class="d-none d-md-inline">Información del </span>Cliente
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-8 mb-3 mb-md-0">
                                <div class="mb-3">
                                    <label for="idCliente" class="form-label">Cliente <span class="text-danger">*</span></label>
                                    <select class="form-select @error('idCliente') is-invalid @enderror" 
                                            id="idCliente" 
                                            name="idCliente" 
                                            required>
                                        <option value="">Buscar cliente por nombre, email o documento...</option>
                                    </select>
                                    @error('idCliente')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <small class="text-muted">
                                            <i class="bi bi-search me-1"></i>
                                            Escriba para buscar por nombre, email o documento
                                        </small>
                                    </div>
                                    <div id="client-info" class="mt-2" style="{{ $venta->cliente ? '' : 'display: none;' }}">
                                        <div class="alert alert-info mb-0">
                                            <div class="d-flex align-items-start">
                                                <i class="bi bi-person-check me-2 mt-1"></i>
                                                <div>
                                                    <strong id="client-name">{{ $venta->cliente->nombre ?? '' }}</strong><br>
                                                    <small class="text-muted">
                                                        <span id="client-email">{{ $venta->cliente->email ?? '' }}</span>
                                                        <span id="client-document">{{ $venta->cliente && $venta->cliente->documento ? ' • Doc: ' . $venta->cliente->documento : '' }}</span>
                                                        <span id="client-phone">{{ $venta->cliente && $venta->cliente->telefono ? ' • Tel: ' . $venta->cliente->telefono : '' }}</span>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label class="form-label d-none d-md-block">&nbsp;</label>
                                    <div>
                                        <a href="{{ route('admin.clientes.create') }}" class="btn btn-outline-primary w-100" target="_blank">
                                            <i class="bi bi-plus-lg me-1"></i> Nuevo Cliente
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Productos -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-box me-2"></i>
                            Productos<span class="d-none d-md-inline"> de la Venta</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Buscador de productos -->
                        <div class="row mb-4">
                            <div class="col-12 col-md-8 mb-3 mb-md-0">
                                <label for="producto-search" class="form-label">Buscar y Agregar Producto</label>
                                <select class="form-select" id="producto-search">
                                    <option value="">Buscar producto por nombre, referencia o descripción...</option>
                                </select>
                                <div class="form-text">
                                    <small class="text-muted">
                                        <i class="bi bi-search me-1"></i>
                                        Escriba para buscar productos disponibles
                                    </small>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label d-none d-md-block">&nbsp;</label>
                                <div>
                                    <a href="{{ route('admin.productos.create') }}" class="btn btn-outline-success w-100" target="_blank">
                                        <i class="bi bi-plus-lg me-1"></i> Nuevo Producto
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Lista de productos agregados -->
                        <div class="productos-list">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 text-muted">
                                    <i class="bi bi-cart3 me-2"></i>
                                    Productos Agregados (<span id="productos-count">{{ $venta->detalles->count() }}</span>)
                                </h6>
                                <button type="button" class="btn btn-outline-danger btn-sm" id="clear-all-productos" style="{{ $venta->detalles->count() > 0 ? '' : 'display: none;' }}">
                                    <i class="bi bi-trash me-1"></i> Limpiar Todo
                                </button>
                            </div>
                            
                            <div id="productos-container" class="border rounded">
                                @if($venta->detalles->count() == 0)
                                <div class="empty-products text-center py-5" id="empty-products">
                                    <i class="bi bi-cart-x display-4 text-muted mb-3"></i>
                                    <p class="text-muted mb-0">No hay productos agregados</p>
                                    <small class="text-muted">Use el buscador arriba para agregar productos</small>
                                </div>
                                @else
                                    @foreach($venta->detalles as $index => $detalle)
                                    <div class="producto-item border-bottom">
                                        <div class="p-3">
                                            <!-- Vista Desktop -->
                                            <div class="row align-items-center d-none d-md-flex">
                                                <div class="col-md-5">
                                                    <div class="d-flex align-items-center">
                                                        <div class="producto-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                            <i class="bi bi-box"></i>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <h6 class="mb-1 producto-nombre">{{ $detalle->producto->nombre }}</h6>
                                                            <small class="text-muted producto-referencia">{{ $detalle->producto->referencia ?? 'Sin referencia' }}</small>
                                                            <input type="hidden" name="productos[{{ $index }}][idProducto]" class="producto-id-input" value="{{ $detalle->idProducto }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label text-muted small">Cantidad</label>
                                                    <div class="input-group input-group-sm">
                                                        <button class="btn btn-outline-secondary btn-cantidad-menos" type="button">
                                                            <i class="bi bi-dash"></i>
                                                        </button>
                                                        <input type="number" 
                                                               class="form-control text-center cantidad-input" 
                                                               name="productos[{{ $index }}][cantidad]" 
                                                               min="1" 
                                                               value="{{ $detalle->cantidad }}"
                                                               required>
                                                        <button class="btn btn-outline-secondary btn-cantidad-mas" type="button">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <small class="text-muted stock-info">Stock: {{ $detalle->producto->stock + $detalle->cantidad }}</small>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label text-muted small">Precio Unit.</label>
                                                    <input type="text" 
                                                           class="form-control form-control-sm precio-unitario" 
                                                           value="{{ format_cop_price($detalle->precio_unitario) }}"
                                                           readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label text-muted small">Subtotal</label>
                                                    <input type="text" 
                                                           class="form-control form-control-sm fw-bold subtotal" 
                                                           value="{{ format_cop_price($detalle->subtotal) }}"
                                                           readonly>
                                                </div>
                                                <div class="col-md-1 text-end">
                                                    <button type="button" class="btn btn-outline-danger btn-sm btn-eliminar-producto" title="Eliminar producto">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Vista Mobile -->
                                            <div class="d-md-none">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <div class="d-flex align-items-start flex-grow-1">
                                                        <div class="producto-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; flex-shrink: 0;">
                                                            <i class="bi bi-box"></i>
                                                        </div>
                                                        <div style="min-width: 0;">
                                                            <h6 class="mb-1 producto-nombre" style="font-size: 0.9rem;">{{ $detalle->producto->nombre }}</h6>
                                                            <small class="text-muted producto-referencia d-block">{{ $detalle->producto->referencia ?? 'Sin referencia' }}</small>
                                                            <input type="hidden" name="productos[{{ $index }}][idProducto]" class="producto-id-input" value="{{ $detalle->idProducto }}">
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-outline-danger btn-sm btn-eliminar-producto ms-2" title="Eliminar">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                                
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <label class="form-label text-muted small mb-1">Cantidad</label>
                                                        <div class="input-group input-group-sm">
                                                            <button class="btn btn-outline-secondary btn-cantidad-menos" type="button">
                                                                <i class="bi bi-dash"></i>
                                                            </button>
                                                            <input type="number" 
                                                                   class="form-control text-center cantidad-input" 
                                                                   name="productos[{{ $index }}][cantidad]" 
                                                                   min="1" 
                                                                   value="{{ $detalle->cantidad }}"
                                                                   required>
                                                            <button class="btn btn-outline-secondary btn-cantidad-mas" type="button">
                                                                <i class="bi bi-plus"></i>
                                                            </button>
                                                        </div>
                                                        <small class="text-muted stock-info d-block mt-1">Stock: {{ $detalle->producto->stock + $detalle->cantidad }}</small>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label text-muted small mb-1">Precio Unit.</label>
                                                        <input type="text" 
                                                               class="form-control form-control-sm precio-unitario" 
                                                               value="{{ format_cop_price($detalle->precio_unitario) }}"
                                                               readonly>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label text-muted small mb-1">Subtotal</label>
                                                        <input type="text" 
                                                               class="form-control form-control-sm fw-bold subtotal" 
                                                               value="{{ format_cop_price($detalle->subtotal) }}"
                                                               readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Template para productos agregados -->
                        <script type="text/template" id="producto-template">
                            <div class="producto-item border-bottom">
                                <div class="p-3">
                                    <!-- Vista Desktop -->
                                    <div class="row align-items-center d-none d-md-flex">
                                        <div class="col-md-5">
                                            <div class="d-flex align-items-center">
                                                <div class="producto-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="bi bi-box"></i>
                                                </div>
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 producto-nombre"></h6>
                                                    <small class="text-muted producto-referencia"></small>
                                                    <input type="hidden" name="productos[INDEX][idProducto]" class="producto-id-input">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label text-muted small">Cantidad</label>
                                            <div class="input-group input-group-sm">
                                                <button class="btn btn-outline-secondary btn-cantidad-menos" type="button">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                <input type="number" 
                                                       class="form-control text-center cantidad-input" 
                                                       name="productos[INDEX][cantidad]" 
                                                       min="1" 
                                                       value="1"
                                                       required>
                                                <button class="btn btn-outline-secondary btn-cantidad-mas" type="button">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                            <small class="text-muted stock-info"></small>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label text-muted small">Precio Unit.</label>
                                            <input type="text" 
                                                   class="form-control form-control-sm precio-unitario" 
                                                   readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label text-muted small">Subtotal</label>
                                            <input type="text" 
                                                   class="form-control form-control-sm fw-bold subtotal" 
                                                   readonly>
                                        </div>
                                        <div class="col-md-1 text-end">
                                            <button type="button" class="btn btn-outline-danger btn-sm btn-eliminar-producto" title="Eliminar producto">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Vista Mobile -->
                                    <div class="d-md-none">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div class="d-flex align-items-start flex-grow-1">
                                                <div class="producto-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; flex-shrink: 0;">
                                                    <i class="bi bi-box"></i>
                                                </div>
                                                <div style="min-width: 0;">
                                                    <h6 class="mb-1 producto-nombre" style="font-size: 0.9rem;"></h6>
                                                    <small class="text-muted producto-referencia d-block"></small>
                                                    <input type="hidden" name="productos[INDEX][idProducto]" class="producto-id-input">
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-outline-danger btn-sm btn-eliminar-producto ms-2" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <label class="form-label text-muted small mb-1">Cantidad</label>
                                                <div class="input-group input-group-sm">
                                                    <button class="btn btn-outline-secondary btn-cantidad-menos" type="button">
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                    <input type="number" 
                                                           class="form-control text-center cantidad-input" 
                                                           name="productos[INDEX][cantidad]" 
                                                           min="1" 
                                                           value="1"
                                                           required>
                                                    <button class="btn btn-outline-secondary btn-cantidad-mas" type="button">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                                <small class="text-muted stock-info d-block mt-1"></small>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label text-muted small mb-1">Precio Unit.</label>
                                                <input type="text" 
                                                       class="form-control form-control-sm precio-unitario" 
                                                       readonly>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label text-muted small mb-1">Subtotal</label>
                                                <input type="text" 
                                                       class="form-control form-control-sm fw-bold subtotal" 
                                                       readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </script>
                    </div>
                </div>

                <!-- Información de la Venta -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            <span class="d-none d-md-inline">Información de la </span>Venta
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-4 mb-3 mb-md-0">
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select class="form-select @error('estado') is-invalid @enderror" 
                                            id="estado" 
                                            name="estado">
                                        <option value="pendiente" {{ (old('estado') ?? $venta->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="procesando" {{ (old('estado') ?? $venta->estado) == 'procesando' ? 'selected' : '' }}>Procesando</option>
                                        <option value="completada" {{ (old('estado') ?? $venta->estado) == 'completada' ? 'selected' : '' }}>Completada</option>
                                        <option value="cancelada" {{ (old('estado') ?? $venta->estado) == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                    </select>
                                    @error('estado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="metodo_pago" class="form-label">Método de Pago</label>
                                    <select class="form-select @error('metodo_pago') is-invalid @enderror" 
                                            id="metodo_pago" 
                                            name="metodo_pago">
                                        <option value="efectivo" {{ (old('metodo_pago') ?? $venta->metodo_pago) == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                                        <option value="tarjeta" {{ (old('metodo_pago') ?? $venta->metodo_pago) == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                                        <option value="transferencia" {{ (old('metodo_pago') ?? $venta->metodo_pago) == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                                        <option value="credito" {{ (old('metodo_pago') ?? $venta->metodo_pago) == 'credito' ? 'selected' : '' }}>Crédito</option>
                                    </select>
                                    @error('metodo_pago')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Fecha de Venta</label>
                                    <input type="text" class="form-control" value="{{ format_colombian_datetime($venta->fecha) }}" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Observaciones -->
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="observaciones" class="form-label">
                                        <i class="bi bi-chat-left-text text-primary me-1"></i>
                                        Observaciones
                                    </label>
                                    <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                              id="observaciones" 
                                              name="observaciones" 
                                              rows="3" 
                                              placeholder="Agrega notas o comentarios sobre esta venta...">{{ old('observaciones') ?? $venta->observaciones }}</textarea>
                                    @error('observaciones')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Opcional: Detalles adicionales, instrucciones de entrega, etc.</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Total -->
                        <div class="row">
                            <div class="col-12 col-md-6 offset-md-6">
                                <div class="bg-light p-3 rounded">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal:</span>
                                        <span id="subtotal-display">{{ format_cop_price($venta->detalles->sum('subtotal')) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>Envío:</span>
                                        <div class="d-flex align-items-center">
                                            <input type="number" 
                                                   class="form-control form-control-sm text-end" 
                                                   id="totalEnvio" 
                                                   name="totalEnvio" 
                                                   value="{{ $venta->totalEnvio ?? 0 }}" 
                                                   min="0" 
                                                   step="1000"
                                                   style="width: 100px;"
                                                   onchange="calcularTotal()">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <strong>Total:</strong>
                                        <strong id="total-final">{{ format_cop_price($venta->total) }}</strong>
                                    </div>
                                    <input type="hidden" id="total-hidden" name="total" value="{{ $venta->total }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">
                    <a href="{{ route('admin.ventas.show', $venta) }}" class="btn btn-secondary order-2 order-sm-1">
                        <i class="bi bi-x-lg me-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary-gold order-1 order-sm-2">
                        <i class="bi bi-check-lg me-1"></i> Actualizar Venta
                    </button>
                </div>
            </form>
        @endif
    </div>
@endsection

@push('styles')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<style>
.select2-container .select2-selection--single {
    height: calc(2.25rem + 2px) !important;
    padding: 0.375rem 0.75rem !important;
    border: 1px solid #ced4da !important;
}

.select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
    padding-left: 0 !important;
    line-height: calc(2.25rem) !important;
}

.select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
    height: calc(2.25rem) !important;
}

.select2-results__option--loading,
.select2-results__option--selected {
    background-color: #f8f9fa !important;
}

.cliente-option {
    padding: 8px 0;
}

.select2-results__option:hover .cliente-option {
    background-color: transparent;
}

.select2-container--bootstrap-5 .select2-dropdown {
    border: 1px solid #ced4da;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.select2-container--bootstrap-5 .select2-results__option--highlighted {
    background-color: #0d6efd !important;
    color: white !important;
}

#client-info .alert {
    border-left: 4px solid #0d6efd;
}

/* Productos Styles */
.productos-list #productos-container {
    min-height: 100px;
    background-color: #f8f9fa;
}

.producto-item {
    background-color: white;
    transition: all 0.2s ease;
}

.producto-item:hover {
    background-color: #f8f9fa;
}

.producto-item:last-child {
    border-bottom: none !important;
}

.producto-avatar {
    font-size: 16px;
    flex-shrink: 0;
}

.empty-products {
    background-color: transparent;
}

.btn-cantidad-menos,
.btn-cantidad-mas {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
}

.cantidad-input {
    width: 60px;
    font-weight: 500;
}

.stock-info {
    font-size: 0.75rem;
}

.stock-low {
    color: #dc3545 !important;
}

.stock-ok {
    color: #28a745 !important;
}

.precio-unitario,
.subtotal {
    font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
}

.subtotal {
    color: #0d6efd;
}

#productos-count {
    background-color: #0d6efd;
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

/* ============================================
   MOBILE OPTIMIZATIONS - v2.0
   ============================================ */

@media (max-width: 767px) {
    /* Header mobile */
    .container-fluid > .row.align-items-center h1 {
        font-size: 1.5rem !important;
    }

    /* Cards mobile */
    .card-header h5 {
        font-size: 1rem !important;
    }

    /* Productos list mobile */
    .producto-item {
        margin-bottom: 0 !important;
    }

    .producto-item .p-3 {
        padding: 0.75rem !important;
    }

    /* Botones de cantidad móvil */
    .btn-cantidad-menos,
    .btn-cantidad-mas {
        width: 28px !important;
        height: 28px !important;
        font-size: 0.75rem;
    }

    .cantidad-input {
        width: 50px !important;
        font-size: 0.875rem;
    }

    /* Inputs mobile */
    .form-control,
    .form-select {
        font-size: 0.875rem !important;
    }

    /* Total resumen */
    .bg-light.p-3 {
        padding: 1rem !important;
    }

    /* Botones finales */
    .btn {
        min-height: 44px;
    }

    /* Select2 mobile */
    .select2-container {
        font-size: 0.875rem;
    }

    .select2-results__option {
        padding: 0.5rem !important;
    }

    /* Empty products */
    .empty-products {
        padding: 2rem 1rem !important;
    }

    .empty-products .display-4 {
        font-size: 2rem !important;
    }
}

@media (max-width: 575px) {
    /* Full width buttons on small mobile */
    .d-flex.flex-wrap.gap-2 > .btn,
    .d-flex.flex-column > .btn {
        width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
let productoIndex = {{ $venta->detalles->count() }};
let productosEnVenta = new Map(); // Para evitar duplicados

// Cargar productos existentes en el Map
@foreach($venta->detalles as $index => $detalle)
productosEnVenta.set({{ $detalle->idProducto }}, {
    index: {{ $index }},
    producto: {
        idProducto: {{ $detalle->idProducto }},
        nombre: '{{ addslashes($detalle->producto->nombre) }}',
        referencia: '{{ addslashes($detalle->producto->referencia ?? '') }}',
        precio: {{ $detalle->precio_unitario }},
        stock: {{ $detalle->producto->stock + $detalle->cantidad }}
    },
    elemento: null // Se configurará después
});
@endforeach

// Inicializar Select2 para búsqueda de productos
function initializeProductoSearch() {
    $('#producto-search').select2({
        theme: 'bootstrap-5',
        placeholder: 'Buscar producto por nombre, referencia o descripción...',
        allowClear: true,
        minimumInputLength: 0,
        language: {
            inputTooShort: function() {
                return 'Escriba para buscar productos';
            },
            searching: function() {
                return 'Buscando productos...';
            },
            noResults: function() {
                return 'No se encontraron productos. <a href="{{ route("admin.productos.create") }}" target="_blank" class="btn btn-sm btn-outline-success ms-2">Crear nuevo</a>';
            },
            errorLoading: function() {
                return 'Error al cargar productos';
            }
        },
        ajax: {
            url: '{{ route("admin.ventas.search-productos") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term || '',
                    page: params.page || 1
                };
            },
            processResults: function (data, params) {
                return {
                    results: data.map(function(producto) {
                        return {
                            id: producto.idProducto,
                            text: producto.nombre + ' - ' + format_cop_price(producto.precio) + 
                                  ' (Stock: ' + producto.stock + ')',
                            producto: producto
                        };
                    })
                };
            },
            cache: true
        },
        templateResult: function(producto) {
            if (producto.loading) {
                return producto.text;
            }
            
            if (!producto.producto) {
                return producto.text;
            }
            
            const prod = producto.producto;
            const stockClass = prod.stock > 10 ? 'stock-ok' : (prod.stock > 0 ? 'text-warning' : 'stock-low');
            
            var html = '<div class="producto-option py-2">';
            html += '<div class="d-flex justify-content-between align-items-start">';
            html += '<div class="flex-fill">';
            html += '<div class="fw-bold text-primary">' + prod.nombre + '</div>';
            html += '<div class="text-muted small">';
            if (prod.referencia) {
                html += '<span class="badge bg-light text-dark me-2"><i class="bi bi-tag me-1"></i>' + prod.referencia + '</span>';
            }
            html += '<i class="bi bi-currency-dollar me-1"></i>' + format_cop_price(prod.precio);
            html += '</div>';
            if (prod.descripcion) {
                html += '<div class="text-muted small mt-1">' + prod.descripcion.substring(0, 80) + '...</div>';
            }
            html += '</div>';
            html += '<div class="text-end">';
            html += '<div class="badge ' + (prod.stock > 0 ? 'bg-success' : 'bg-danger') + '">';
            html += 'Stock: ' + prod.stock;
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            
            return $(html);
        },
        templateSelection: function(producto) {
            return 'Buscar producto...';
        },
        escapeMarkup: function(markup) {
            return markup;
        }
    });

    // Manejar la selección de productos
    $('#producto-search').on('select2:select', function (e) {
        var data = e.params.data;
        if (data.producto) {
            agregarProductoAVenta(data.producto);
            $(this).val(null).trigger('change'); // Limpiar selección
        }
    });
}

// Agregar producto a la venta
function agregarProductoAVenta(producto) {
    // Verificar si el producto ya está agregado
    if (productosEnVenta.has(producto.idProducto)) {
        // Si ya existe, incrementar cantidad
        incrementarCantidadProducto(producto.idProducto);
        return;
    }

    if (producto.stock <= 0) {
        mostrarAlerta('Este producto no tiene stock disponible', 'warning');
        return;
    }

    // Obtener template y contenedor
    const template = document.getElementById('producto-template').innerHTML;
    const container = document.getElementById('productos-container');
    
    // Ocultar mensaje de productos vacíos
    const emptyMessage = document.getElementById('empty-products');
    if (emptyMessage) {
        emptyMessage.style.display = 'none';
    }

    // Crear nuevo producto HTML
    const newProductoHtml = template.replace(/INDEX/g, productoIndex);
    container.insertAdjacentHTML('beforeend', newProductoHtml);
    
    // Obtener el elemento recién creado
    const newItem = container.lastElementChild;
    
    // Rellenar datos del producto
    newItem.querySelector('.producto-nombre').textContent = producto.nombre;
    newItem.querySelector('.producto-referencia').textContent = producto.referencia ? 'Ref: ' + producto.referencia : 'Sin referencia';
    newItem.querySelector('.producto-id-input').value = producto.idProducto;
    newItem.querySelector('.precio-unitario').value = format_cop_price(producto.precio);
    newItem.querySelector('.cantidad-input').setAttribute('max', producto.stock);
    
    // Configurar información de stock
    const stockInfo = newItem.querySelector('.stock-info');
    stockInfo.textContent = `Stock: ${producto.stock}`;
    stockInfo.className = 'text-muted stock-info ' + (producto.stock > 10 ? 'stock-ok' : (producto.stock > 0 ? 'text-warning' : 'stock-low'));
    
    // Configurar eventos
    configurarEventosProducto(newItem, producto);
    
    // Agregar a la lista de productos en venta
    productosEnVenta.set(producto.idProducto, {
        index: productoIndex,
        producto: producto,
        elemento: newItem
    });
    
    // Calcular subtotal inicial
    calcularSubtotalProducto(newItem);
    
    // Actualizar contador
    actualizarContadorProductos();
    
    productoIndex++;
}

// Configurar eventos para un producto
function configurarEventosProducto(elemento, producto) {
    const cantidadInput = elemento.querySelector('.cantidad-input');
    const btnMenos = elemento.querySelector('.btn-cantidad-menos');
    const btnMas = elemento.querySelector('.btn-cantidad-mas');
    const btnEliminar = elemento.querySelector('.btn-eliminar-producto');
    
    // Eventos de cantidad
    cantidadInput.addEventListener('input', function() {
        validarCantidad(this, producto.stock);
        calcularSubtotalProducto(elemento);
    });
    
    cantidadInput.addEventListener('blur', function() {
        if (!this.value || this.value < 1) {
            this.value = 1;
            calcularSubtotalProducto(elemento);
        }
    });
    
    // Botones de cantidad
    btnMenos.addEventListener('click', function() {
        const cantidad = parseInt(cantidadInput.value) || 1;
        if (cantidad > 1) {
            cantidadInput.value = cantidad - 1;
            calcularSubtotalProducto(elemento);
        }
    });
    
    btnMas.addEventListener('click', function() {
        const cantidad = parseInt(cantidadInput.value) || 1;
        if (cantidad < producto.stock) {
            cantidadInput.value = cantidad + 1;
            calcularSubtotalProducto(elemento);
        } else {
            mostrarAlerta(`Stock máximo disponible: ${producto.stock}`, 'warning');
        }
    });
    
    // Botón eliminar
    btnEliminar.addEventListener('click', function() {
        eliminarProductoDeVenta(producto.idProducto);
    });
}

// Validar cantidad según stock
function validarCantidad(input, stockMax) {
    let cantidad = parseInt(input.value) || 0;
    
    if (cantidad > stockMax) {
        cantidad = stockMax;
        input.value = cantidad;
        mostrarAlerta(`Stock máximo disponible: ${stockMax}`, 'warning');
    } else if (cantidad < 1) {
        cantidad = 1;
        input.value = cantidad;
    }
    
    return cantidad;
}

// Calcular subtotal de un producto específico
function calcularSubtotalProducto(elemento) {
    const cantidadInput = elemento.querySelector('.cantidad-input');
    const precioInput = elemento.querySelector('.precio-unitario');
    const subtotalInput = elemento.querySelector('.subtotal');
    
    const cantidad = parseInt(cantidadInput.value) || 0;
    const precioText = precioInput.value.replace(/[$.,]/g, '');
    const precio = parseInt(precioText) || 0;
    
    const subtotal = cantidad * precio;
    subtotalInput.value = format_cop_price(subtotal);
    
    calcularTotal();
}

// Incrementar cantidad de un producto existente
function incrementarCantidadProducto(idProducto) {
    const productoInfo = productosEnVenta.get(idProducto);
    if (!productoInfo) return;
    
    const cantidadInput = productoInfo.elemento.querySelector('.cantidad-input');
    const cantidadActual = parseInt(cantidadInput.value) || 1;
    
    if (cantidadActual < productoInfo.producto.stock) {
        cantidadInput.value = cantidadActual + 1;
        calcularSubtotalProducto(productoInfo.elemento);
        mostrarAlerta('Cantidad incrementada', 'success');
    } else {
        mostrarAlerta(`Stock máximo disponible: ${productoInfo.producto.stock}`, 'warning');
    }
}

// Eliminar producto de la venta
function eliminarProductoDeVenta(idProducto) {
    const productoInfo = productosEnVenta.get(idProducto);
    if (!productoInfo) return;
    
    // Remover elemento del DOM
    productoInfo.elemento.remove();
    
    // Remover del Map
    productosEnVenta.delete(idProducto);
    
    // Actualizar contador
    actualizarContadorProductos();
    
    // Mostrar mensaje vacío si no hay productos
    if (productosEnVenta.size === 0) {
        document.getElementById('empty-products').style.display = 'block';
    }
    
    // Recalcular total
    calcularTotal();
    
    mostrarAlerta('Producto eliminado', 'info');
}

// Limpiar todos los productos
function limpiarTodosLosProductos() {
    if (productosEnVenta.size === 0) return;
    
    if (confirm('¿Está seguro de que desea eliminar todos los productos?')) {
        productosEnVenta.forEach((info, id) => {
            info.elemento.remove();
        });
        
        productosEnVenta.clear();
        document.getElementById('empty-products').style.display = 'block';
        actualizarContadorProductos();
        calcularTotal();
        
        mostrarAlerta('Todos los productos han sido eliminados', 'info');
    }
}

// Actualizar contador de productos
function actualizarContadorProductos() {
    const contador = document.getElementById('productos-count');
    const btnLimpiar = document.getElementById('clear-all-productos');
    
    contador.textContent = productosEnVenta.size;
    
    if (productosEnVenta.size > 0) {
        btnLimpiar.style.display = 'inline-block';
    } else {
        btnLimpiar.style.display = 'none';
    }
}

// Calcular total general
function calcularTotal() {
    let subtotal = 0;
    const subtotales = document.querySelectorAll('.subtotal');
    
    subtotales.forEach(subtotalInput => {
        if (subtotalInput.value) {
            const value = subtotalInput.value.replace(/[$.,]/g, '');
            subtotal += parseInt(value) || 0;
        }
    });
    
    // Obtener costo de envío
    const envioInput = document.getElementById('totalEnvio');
    const costoEnvio = parseInt(envioInput.value) || 0;
    
    // Calcular total
    const total = subtotal + costoEnvio;
    
    // Actualizar display
    document.getElementById('subtotal-display').textContent = format_cop_price(subtotal);
    document.getElementById('total-final').textContent = format_cop_price(total);
    document.getElementById('total-hidden').value = total;
}

// Formatear precio colombiano
function format_cop_price(price) {
    return '$' + price.toLocaleString('es-CO', {maximumFractionDigits: 0});
}

// Mostrar alerta temporal
function mostrarAlerta(mensaje, tipo = 'info') {
    // Crear elemento de alerta
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${tipo} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    
    alertDiv.innerHTML = `
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    // Auto-remover después de 3 segundos
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 3000);
}

// Inicializar Select2 para búsqueda de clientes
function initializeClienteSelect() {
    $('#idCliente').select2({
        theme: 'bootstrap-5',
        placeholder: 'Buscar cliente por nombre, email o documento...',
        allowClear: true,
        minimumInputLength: 1,
        language: {
            inputTooShort: function() {
                return 'Escriba al menos 1 carácter para buscar';
            },
            searching: function() {
                return 'Buscando...';
            },
            noResults: function() {
                return 'No se encontraron clientes. <a href="{{ route("admin.clientes.create") }}" target="_blank" class="btn btn-sm btn-outline-primary ms-2">Crear nuevo</a>';
            },
            errorLoading: function() {
                return 'Error al cargar los resultados';
            }
        },
        ajax: {
            url: '{{ route("admin.ventas.search-clientes") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term,
                    page: params.page || 1
                };
            },
            processResults: function (data, params) {
                return {
                    results: data.map(function(cliente) {
                        return {
                            id: cliente.idCliente,
                            text: cliente.nombre + ' - ' + cliente.email + 
                                  (cliente.documento ? ' (' + cliente.documento + ')' : ''),
                            cliente: cliente
                        };
                    })
                };
            },
            cache: true
        },
        templateResult: function(cliente) {
            if (cliente.loading) {
                return cliente.text;
            }
            
            if (!cliente.cliente) {
                return cliente.text;
            }
            
            var html = '<div class="cliente-option py-2">';
            html += '<div class="fw-bold text-primary">' + cliente.cliente.nombre + '</div>';
            html += '<div class="text-muted small">';
            html += '<i class="bi bi-envelope me-1"></i>' + cliente.cliente.email;
            if (cliente.cliente.documento) {
                html += ' <span class="mx-2">•</span> <i class="bi bi-card-text me-1"></i>' + cliente.cliente.documento;
            }
            if (cliente.cliente.telefono) {
                html += ' <span class="mx-2">•</span> <i class="bi bi-telephone me-1"></i>' + cliente.cliente.telefono;
            }
            html += '</div>';
            html += '</div>';
            
            return $(html);
        },
        templateSelection: function(cliente) {
            if (cliente.cliente) {
                return cliente.cliente.nombre + ' - ' + cliente.cliente.email;
            }
            return cliente.text;
        },
        escapeMarkup: function(markup) {
            return markup;
        }
    });

    // Manejar la selección del cliente
    $('#idCliente').on('select2:select', function (e) {
        var data = e.params.data;
        if (data.cliente) {
            showClientInfo(data.cliente);
        }
    });

    // Manejar cuando se limpia la selección
    $('#idCliente').on('select2:clear', function (e) {
        hideClientInfo();
    });
    
    // Si hay un cliente seleccionado al cargar, agregarlo al select y mostrar su información
    @if($venta->cliente)
        const clienteActual = @json($venta->cliente);
        // Crear la opción para el cliente actual
        const option = new Option(
            clienteActual.nombre + ' - ' + clienteActual.email + (clienteActual.documento ? ' (' + clienteActual.documento + ')' : ''),
            clienteActual.idCliente,
            true,
            true
        );
        option.cliente = clienteActual;
        $('#idCliente').append(option).trigger('change');
        // Mostrar información del cliente
        showClientInfo(clienteActual);
    @endif
}

// Mostrar información del cliente seleccionado
function showClientInfo(cliente) {
    document.getElementById('client-name').textContent = cliente.nombre;
    document.getElementById('client-email').textContent = cliente.email;
    
    const documentSpan = document.getElementById('client-document');
    const phoneSpan = document.getElementById('client-phone');
    
    if (cliente.documento) {
        documentSpan.innerHTML = ' • Doc: ' + cliente.documento;
        documentSpan.style.display = 'inline';
    } else {
        documentSpan.style.display = 'none';
    }
    
    if (cliente.telefono) {
        phoneSpan.innerHTML = ' • Tel: ' + cliente.telefono;
        phoneSpan.style.display = 'inline';
    } else {
        phoneSpan.style.display = 'none';
    }
    
    document.getElementById('client-info').style.display = 'block';
}

// Ocultar información del cliente
function hideClientInfo() {
    document.getElementById('client-info').style.display = 'none';
}

// Event listeners principales
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar Select2 para clientes
    initializeClienteSelect();
    
    // Inicializar Select2 para productos
    initializeProductoSearch();
    
    // Configurar productos existentes
    document.querySelectorAll('.producto-item').forEach((item, index) => {
        const idProducto = parseInt(item.querySelector('.producto-id-input').value);
        const productoInfo = productosEnVenta.get(idProducto);
        
        if (productoInfo) {
            // Asignar el elemento al Map
            productoInfo.elemento = item;
            productosEnVenta.set(idProducto, productoInfo);
            
            // Configurar eventos
            configurarEventosProducto(item, productoInfo.producto);
        }
    });
    
    // Configurar botón limpiar todos los productos
    document.getElementById('clear-all-productos').addEventListener('click', limpiarTodosLosProductos);
    
    // Calcular total inicial
    calcularTotal();
    
    // Configurar eventos de teclado para mejor UX
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K para enfocar búsqueda de productos
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            $('#producto-search').select2('open');
        }
        
        // Escape para limpiar búsqueda
        if (e.key === 'Escape') {
            const activeElement = document.activeElement;
            if (activeElement && (activeElement.id === 'producto-search' || activeElement.closest('.select2-container'))) {
                $('#producto-search').val(null).trigger('change');
                $('#producto-search').select2('close');
            }
        }
    });
    
    console.log('✅ Sistema de edición de ventas inicializado correctamente');
});

// Validar formulario antes de enviar
document.getElementById('ventaEditForm').addEventListener('submit', function(e) {
    // Validar cliente seleccionado
    const clienteSelect = document.getElementById('idCliente');
    if (!clienteSelect.value) {
        e.preventDefault();
        mostrarAlerta('Debe seleccionar un cliente', 'danger');
        clienteSelect.focus();
        return;
    }
    
    // Validar productos agregados
    if (productosEnVenta.size === 0) {
        e.preventDefault();
        mostrarAlerta('Debe agregar al menos un producto a la venta', 'danger');
        document.getElementById('producto-search').focus();
        return;
    }
    
    // Validar que todos los productos tengan cantidad válida
    let hasInvalidProduct = false;
    productosEnVenta.forEach((info, id) => {
        const cantidadInput = info.elemento.querySelector('.cantidad-input');
        const cantidad = parseInt(cantidadInput.value) || 0;
        
        if (cantidad <= 0) {
            hasInvalidProduct = true;
            cantidadInput.focus();
        }
    });
    
    if (hasInvalidProduct) {
        e.preventDefault();
        mostrarAlerta('Todos los productos deben tener una cantidad válida mayor a 0', 'danger');
        return;
    }
    
    // Mostrar indicador de carga
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Actualizando...';
});
</script>
@endpush