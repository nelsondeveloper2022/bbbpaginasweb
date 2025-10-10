@extends('layouts.dashboard')

@section('title', 'Venta #' . $venta->idVenta)

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-receipt me-2"></i>
                Venta #{{ $venta->idVenta }}
            </h1>
            <div class="d-flex gap-2">
                @if($venta->estado !== 'completada')
                    <a href="{{ route('admin.ventas.edit', $venta) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-1"></i> Editar
                    </a>
                @endif
                <a href="{{ route('admin.ventas.print', $venta) }}" target="_blank" class="btn btn-outline-primary">
                    <i class="bi bi-printer me-1"></i> Imprimir
                </a>
                <a href="{{ route('admin.ventas.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Volver
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Información de la Venta -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            Información de la Venta
                        </h5>
                        <div>
                            @switch($venta->estado)
                                @case('pendiente')
                                    <span class="badge bg-warning fs-6">Pendiente</span>
                                    @break
                                @case('procesando')
                                    <span class="badge bg-info fs-6">Procesando</span>
                                    @break
                                @case('completada')
                                    <span class="badge bg-success fs-6">Completada</span>
                                    @break
                                @case('cancelada')
                                    <span class="badge bg-danger fs-6">Cancelada</span>
                                    @break
                            @endswitch
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td><strong>Fecha de Venta:</strong></td>
                                        <td>{{ format_colombian_datetime($venta->fecha) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Estado:</strong></td>
                                        <td>
                                            <span class="text-capitalize">{{ $venta->estado }}</span>
                                            @if($venta->estado !== 'completada')
                                                <button class="btn btn-sm btn-outline-primary ms-2" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#cambiarEstadoModal">
                                                    Cambiar
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Método de Pago:</strong></td>
                                        <td class="text-capitalize">{{ $venta->metodo_pago ?? 'No especificado' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td><strong>Total de Productos:</strong></td>
                                        <td>{{ $venta->detalles->sum('cantidad') }} unidades</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Costo de Envío:</strong></td>
                                        <td>
                                            @if($venta->totalEnvio && $venta->totalEnvio > 0)
                                                {{ format_cop_price($venta->totalEnvio) }}
                                            @else
                                                <span class="text-success">Gratis</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total de la Venta:</strong></td>
                                        <td><strong class="text-primary">{{ format_cop_price($venta->total) }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Observaciones -->
                        @if($venta->observaciones)
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="alert alert-info mb-0">
                                    <h6 class="alert-heading">
                                        <i class="bi bi-chat-left-text me-2"></i>
                                        Observaciones
                                    </h6>
                                    <p class="mb-0">{{ $venta->observaciones }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Productos -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-box me-2"></i>
                            Productos ({{ $venta->detalles->count() }})
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Producto</th>
                                        <th width="100" class="text-center">Cantidad</th>
                                        <th width="120" class="text-end">Precio Unit.</th>
                                        <th width="120" class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($venta->detalles as $detalle)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($detalle->producto->imagenPrincipal)
                                                        <img src="{{ $detalle->producto->imagenPrincipal->url_complete }}" 
                                                             class="rounded me-3" 
                                                             style="width: 50px; height: 50px; object-fit: cover;"
                                                             alt="{{ $detalle->producto->nombre }}">
                                                    @else
                                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                                             style="width: 50px; height: 50px;">
                                                            <i class="bi bi-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <strong>{{ $detalle->producto->nombre }}</strong>
                                                        @if($detalle->producto->descripcion)
                                                            <br><small class="text-muted">{{ Str::limit($detalle->producto->descripcion, 50) }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-secondary">{{ $detalle->cantidad }}</span>
                                            </td>
                                            <td class="text-end">
                                                {{ format_cop_price($detalle->precio_unitario) }}
                                            </td>
                                            <td class="text-end">
                                                <strong>{{ format_cop_price($detalle->subtotal) }}</strong>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="3" class="text-end">Subtotal:</th>
                                        <th class="text-end">
                                            {{ format_cop_price($venta->detalles->sum('subtotal')) }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-end">Envío:</th>
                                        <th class="text-end">
                                            @if($venta->totalEnvio && $venta->totalEnvio > 0)
                                                {{ format_cop_price($venta->totalEnvio) }}
                                            @else
                                                <span class="text-success">Gratis</span>
                                            @endif
                                        </th>
                                    </tr>
                                    <tr class="border-top">
                                        <th colspan="3" class="text-end">Total:</th>
                                        <th class="text-end">
                                            <span class="h5 text-primary">{{ format_cop_price($venta->total) }}</span>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Cliente -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-person me-2"></i>
                            Cliente
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="bg-primary-gold rounded-circle mx-auto d-flex align-items-center justify-content-center" 
                                 style="width: 60px; height: 60px;">
                                <i class="bi bi-person-fill text-white fs-4"></i>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">
                                <strong>{{ $venta->cliente->nombre }}</strong>
                            </h6>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Email:</small>
                            <a href="mailto:{{ $venta->cliente->email }}" class="text-decoration-none" style="font-size: 0.9rem; word-break: break-all;">
                                {{ $venta->cliente->email }}
                            </a>
                        </div>

                        @if($venta->cliente->telefono)
                        <div class="mb-3">
                            <small class="text-muted d-block">Teléfono:</small>
                            <a href="tel:{{ $venta->cliente->telefono }}" class="text-decoration-none">
                                {{ $venta->cliente->telefono }}
                            </a>
                        </div>
                        @endif

                        @if($venta->cliente->direccion)
                        <div class="mb-3">
                            <small class="text-muted d-block">Dirección:</small>
                            <div style="font-size: 0.9rem; line-height: 1.4; word-wrap: break-word;">
                                {{ $venta->cliente->direccion }}
                            </div>
                        </div>
                        @endif

                        <div class="mb-3">
                            <small class="text-muted d-block">Registrado:</small>
                            <span style="font-size: 0.9rem;">{{ format_colombian_date($venta->cliente->created_at) }}</span>
                        </div>

                        <div class="d-grid">
                            <a href="{{ route('admin.clientes.show', $venta->cliente) }}" class="btn btn-outline-primary">
                                <i class="bi bi-person-lines-fill me-1"></i> Ver Cliente
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cambiar Estado -->
    @if($venta->estado !== 'completada')
        <div class="modal fade" id="cambiarEstadoModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cambiar Estado de Venta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.ventas.change-status', $venta) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="estado" class="form-label">Nuevo Estado</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="pendiente" {{ $venta->estado == 'pendiente' ? 'selected disabled' : '' }}>Pendiente</option>
                                    <option value="procesando" {{ $venta->estado == 'procesando' ? 'selected disabled' : '' }}>Procesando</option>
                                    <option value="completada" {{ $venta->estado == 'completada' ? 'selected disabled' : '' }}>Completada</option>
                                    <option value="cancelada" {{ $venta->estado == 'cancelada' ? 'selected disabled' : '' }}>Cancelada</option>
                                </select>
                            </div>
                            
                            @if($venta->estado === 'cancelada')
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    Al reactivar una venta cancelada se descontará nuevamente el stock de los productos.
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Al cancelar la venta se restaurará el stock de los productos.
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Cambiar Estado</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('styles')
<style>
    @media print {
        .btn, .modal, .navbar, .sidebar {
            display: none !important;
        }
        .card {
            border: 1px solid #000 !important;
        }
    }
</style>
@endpush