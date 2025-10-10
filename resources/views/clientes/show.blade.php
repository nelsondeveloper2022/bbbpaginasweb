@extends('layouts.dashboard')

@section('title', 'Detalle del Cliente - ' . $cliente->nombre)

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="h3 mb-1">
                    <i class="bi bi-person me-2"></i>
                    {{ $cliente->nombre }}
                </h1>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge {{ $cliente->estado == 'activo' ? 'bg-success' : 'bg-secondary' }} fs-6">
                        <i class="bi bi-{{ $cliente->estado == 'activo' ? 'check-circle' : 'x-circle' }} me-1"></i>
                        {{ ucfirst($cliente->estado) }}
                    </span>
                    <small class="text-muted">
                        Cliente desde {{ format_colombian_date($cliente->created_at, 'j F Y') }}
                    </small>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.clientes.edit', $cliente) }}" class="btn btn-primary-gold">
                    <i class="bi bi-pencil me-1"></i> Editar
                </a>
                <a href="{{ route('admin.clientes.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Volver
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Información del Cliente -->
            <div class="col-xl-8 col-lg-7">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            Información del Cliente
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted small">NOMBRE COMPLETO</label>
                                    <div class="fw-medium">{{ $cliente->nombre }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted small">CORREO ELECTRÓNICO</label>
                                    <div class="fw-medium">
                                        <a href="mailto:{{ $cliente->email }}" class="text-decoration-none">
                                            <i class="bi bi-envelope me-1"></i>
                                            {{ $cliente->email }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($cliente->telefono)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted small">TELÉFONO</label>
                                    <div class="fw-medium">
                                        <a href="tel:{{ $cliente->telefono }}" class="text-decoration-none">
                                            <i class="bi bi-telephone me-1"></i>
                                            {{ $cliente->telefono }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @if($cliente->documento)
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted small">DOCUMENTO</label>
                                    <div class="fw-medium">{{ $cliente->documento }}</div>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif

                        @if($cliente->direccion)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label text-muted small">DIRECCIÓN</label>
                                    <div class="fw-medium">
                                        <i class="bi bi-geo-alt me-1"></i>
                                        {{ $cliente->direccion }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($cliente->fecha_nacimiento)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted small">FECHA DE NACIMIENTO</label>
                                    <div class="fw-medium">
                                        <i class="bi bi-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($cliente->fecha_nacimiento)->locale('es')->isoFormat('D [de] MMMM YYYY') }}
                                        <small class="text-muted">
                                            ({{ \Carbon\Carbon::parse($cliente->fecha_nacimiento)->age }} años)
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($cliente->notas)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-0">
                                    <label class="form-label text-muted small">NOTAS ADICIONALES</label>
                                    <div class="fw-medium">{{ $cliente->notas }}</div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Historial de Ventas -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-cart-check me-2"></i>
                            Historial de Ventas
                        </h5>
                        @if($ventas->count() > 0)
                        <a href="{{ route('admin.ventas.create') }}?cliente_id={{ $cliente->id }}" class="btn btn-sm btn-primary-gold">
                            <i class="bi bi-plus me-1"></i> Nueva Venta
                        </a>
                        @endif
                    </div>
                    <div class="card-body">
                        @if($ventas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Productos</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ventas as $venta)
                                    <tr>
                                        <td>
                                            <div class="fw-medium">{{ format_colombian_date($venta->fecha, 'j M Y') }}</div>
                                            <div class="small text-muted">{{ format_colombian_date($venta->fecha, 'g:i A') }}</div>
                                        </td>
                                        <td>
                                            <div class="fw-medium">{{ $venta->detalles->count() }} producto(s)</div>
                                            <div class="small text-muted">
                                                {{ $venta->detalles->sum('cantidad') }} unidades
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-success">
                                                {{ format_cop_price($venta->total) }}
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $badgeClass = match($venta->estado) {
                                                    'completada' => 'bg-success',
                                                    'pendiente' => 'bg-warning text-dark',
                                                    'cancelada' => 'bg-danger',
                                                    default => 'bg-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">
                                                {{ ucfirst($venta->estado) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.ventas.show', $venta) }}" 
                                                   class="btn btn-sm btn-outline-primary"
                                                   title="Ver detalles">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                @if($venta->estado != 'cancelada')
                                                <a href="{{ route('admin.ventas.edit', $venta) }}" 
                                                   class="btn btn-sm btn-outline-warning"
                                                   title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="bi bi-cart-x display-4 text-muted mb-3 d-block"></i>
                            <h5 class="text-muted">Sin ventas registradas</h5>
                            <p class="text-muted mb-3">Este cliente aún no tiene ventas registradas.</p>
                            <a href="{{ route('admin.ventas.create') }}?cliente_id={{ $cliente->id }}" class="btn btn-primary-gold">
                                <i class="bi bi-plus me-1"></i> Crear Primera Venta
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Panel Lateral - Estadísticas -->
            <div class="col-xl-4 col-lg-5">
                <!-- Estadísticas del Cliente -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-graph-up me-2"></i>
                            Estadísticas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="bg-primary-light p-3 rounded text-center">
                                    <div class="display-6 text-primary fw-bold">{{ $ventas->count() }}</div>
                                    <div class="small text-muted">Total Ventas</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-success-light p-3 rounded text-center">
                                    <div class="display-6 text-success fw-bold">
                                        {{ format_cop_price($ventas->sum('total'), false) }}
                                    </div>
                                    <div class="small text-muted">Total Facturado</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-warning-light p-3 rounded text-center">
                                    <div class="display-6 text-warning fw-bold">
                                        {{ $ventas->where('estado', 'completada')->count() }}
                                    </div>
                                    <div class="small text-muted">Completadas</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-info-light p-3 rounded text-center">
                                    <div class="display-6 text-info fw-bold">
                                        {{ $ventas->sum(function($venta) { return $venta->detalles->sum('cantidad'); }) }}
                                    </div>
                                    <div class="small text-muted">Productos</div>
                                </div>
                            </div>
                        </div>

                        @if($ventas->count() > 0)
                        <hr>
                        <div class="small">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Primera venta:</span>
                                <span class="fw-medium">{{ format_colombian_date($ventas->min('fecha'), 'j M Y') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Última venta:</span>
                                <span class="fw-medium">{{ format_colombian_date($ventas->max('fecha'), 'j M Y') }}</span>
                            </div>
                            @if($ventas->count() > 0)
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Promedio por venta:</span>
                                <span class="fw-medium text-success">
                                    {{ format_cop_price($ventas->avg('total')) }}
                                </span>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Información de Registro -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-clock-history me-2"></i>
                            Información de Registro
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="small">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Creado:</span>
                                <span class="fw-medium">{{ format_colombian_date($cliente->created_at, 'j M Y g:i A') }}</span>
                            </div>
                            @if($cliente->updated_at != $cliente->created_at)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Última actualización:</span>
                                <span class="fw-medium">{{ format_colombian_date($cliente->updated_at, 'j M Y g:i A') }}</span>
                            </div>
                            @endif
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">ID del Cliente:</span>
                                <span class="fw-medium">#{{ $cliente->id }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
.bg-primary-light {
    background-color: rgba(13, 110, 253, 0.1);
}
.bg-success-light {
    background-color: rgba(25, 135, 84, 0.1);
}
.bg-warning-light {
    background-color: rgba(255, 193, 7, 0.1);
}
.bg-info-light {
    background-color: rgba(13, 202, 240, 0.1);
}
</style>
@endpush