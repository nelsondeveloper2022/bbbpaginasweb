@extends('layouts.dashboard')

@section('title', 'Detalle de Confirmación de Pago')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="fas fa-receipt me-2"></i>
                Detalle de Confirmación de Pago
            </h2>
            <p class="text-muted">Información completa de la transacción</p>
        </div>
        <a href="{{ route('admin.pagos.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Volver
        </a>
    </div>

    <div class="row">
        <!-- Información de la Transacción -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Información de la Transacción
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">ID de Confirmación</label>
                            <h6>{{ $confirmacion->idPagoConfirmacion }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Estado</label>
                            <div>
                                <span class="badge bg-{{ $confirmacion->getStatusBadgeColor() }} fs-6">
                                    {{ $confirmacion->getStatusText() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Referencia</label>
                            <h6>
                                <span class="badge bg-secondary">{{ $confirmacion->referencia }}</span>
                            </h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">ID de Transacción</label>
                            <h6>
                                <code class="bg-light p-2 rounded">{{ $confirmacion->transaccion_id }}</code>
                            </h6>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Monto</label>
                            <h4 class="text-success mb-0">{{ $confirmacion->getFormattedAmount() }}</h4>
                            <small class="text-muted">{{ $confirmacion->moneda }}</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Fecha de Confirmación</label>
                            <h6>{{ $confirmacion->fecha_confirmacion->format('d/m/Y H:i:s') }}</h6>
                            <small class="text-muted">{{ $confirmacion->fecha_confirmacion->diffForHumans() }}</small>
                        </div>
                    </div>

                    @if($confirmacion->venta)
                        <hr>
                        
                        <h6 class="mb-3">
                            <i class="fas fa-shopping-cart me-2"></i>
                            Información de la Venta
                        </h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">ID de Venta</label>
                                <h6>{{ $confirmacion->venta->idVenta }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Estado de Venta</label>
                                <div>
                                    <span class="{{ $confirmacion->venta->status_badge_class }}">
                                        {{ $confirmacion->venta->status_display }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Total de Venta</label>
                                <h6>${{ number_format($confirmacion->venta->total, 2, ',', '.') }}</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Fecha de Venta</label>
                                <h6>{{ $confirmacion->venta->fecha->format('d/m/Y H:i') }}</h6>
                            </div>
                        </div>

                        @if($confirmacion->venta->cliente)
                            <hr>
                            
                            <h6 class="mb-3">
                                <i class="fas fa-user me-2"></i>
                                Información del Cliente
                            </h6>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Nombre</label>
                                    <h6>{{ $confirmacion->venta->cliente->nombre }} {{ $confirmacion->venta->cliente->apellido ?? '' }}</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Email</label>
                                    <h6>
                                        <a href="mailto:{{ $confirmacion->venta->cliente->email }}">
                                            {{ $confirmacion->venta->cliente->email }}
                                        </a>
                                    </h6>
                                </div>
                            </div>

                            @if($confirmacion->venta->cliente->telefono)
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="text-muted small">Teléfono</label>
                                        <h6>{{ $confirmacion->venta->cliente->telefono }}</h6>
                                    </div>
                                </div>
                            @endif
                        @endif

                        @if($confirmacion->venta->detalles && $confirmacion->venta->detalles->count() > 0)
                            <hr>
                            
                            <h6 class="mb-3">
                                <i class="fas fa-list me-2"></i>
                                Productos
                            </h6>

                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Producto</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-end">Precio</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($confirmacion->venta->detalles as $detalle)
                                            <tr>
                                                <td>
                                                    @if($detalle->producto)
                                                        {{ $detalle->producto->nombre }}
                                                    @else
                                                        Producto #{{ $detalle->idProducto }}
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $detalle->cantidad }}</td>
                                                <td class="text-end">${{ number_format($detalle->precio, 2, ',', '.') }}</td>
                                                <td class="text-end"><strong>${{ number_format($detalle->subtotal, 2, ',', '.') }}</strong></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="3" class="text-end">Total:</th>
                                            <th class="text-end">${{ number_format($confirmacion->venta->total, 2, ',', '.') }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Información Adicional -->
        <div class="col-lg-4 mb-4">
            <!-- Timeline -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-gradient-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-clock me-2"></i>
                        Historial
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <small class="text-muted">Creado</small>
                                <p class="mb-0 small">{{ $confirmacion->created_at->format('d/m/Y H:i:s') }}</p>
                            </div>
                        </div>
                        @if($confirmacion->updated_at != $confirmacion->created_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <small class="text-muted">Actualizado</small>
                                    <p class="mb-0 small">{{ $confirmacion->updated_at->format('d/m/Y H:i:s') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Respuesta Completa de Wompi -->
            @if($confirmacion->respuesta_completa)
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-gradient-secondary text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-code me-2"></i>
                            Respuesta Completa de Wompi
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="responseAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingResponse">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseResponse" aria-expanded="false">
                                        Ver JSON completo
                                    </button>
                                </h2>
                                <div id="collapseResponse" class="accordion-collapse collapse" aria-labelledby="headingResponse" data-bs-parent="#responseAccordion">
                                    <div class="accordion-body">
                                        <pre class="bg-dark text-light p-3 rounded" style="max-height: 400px; overflow-y: auto; font-size: 0.75rem;"><code>{{ json_encode($confirmacion->respuesta_completa, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #d22e23 0%, #b01e1a 100%);
}

.bg-gradient-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 100%);
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -23px;
    top: 0;
    width: 2px;
    height: 100%;
    background: #e9ecef;
}

.timeline-marker {
    position: absolute;
    left: -28px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content {
    padding-left: 10px;
}

pre code {
    display: block;
    word-wrap: break-word;
    white-space: pre-wrap;
}
</style>
@endpush
