@extends('layouts.dashboard')

@section('title', 'Configuración de Pagos')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="fas fa-credit-card me-2"></i>
                Configuración de Pagos
            </h2>
            <p class="text-muted">Administra la configuración de Wompi y visualiza las confirmaciones de pago</p>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Errores en el formulario:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Configuración de Wompi -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-cog me-2"></i>
                        Configuración de Wompi
                    </h5>
                </div>
                <div class="card-body">
                    @if($wompiPasarela)
                        <!-- Estado actual -->
                        <div class="alert alert-{{ $wompiPasarela->activo ? 'success' : 'warning' }} d-flex align-items-center" role="alert">
                            <i class="fas fa-{{ $wompiPasarela->activo ? 'check-circle' : 'exclamation-triangle' }} fa-2x me-3"></i>
                            <div>
                                <strong>Estado:</strong> 
                                {{ $wompiPasarela->activo ? 'Activo' : 'Inactivo' }}
                                @if($wompiPasarela->isSandbox())
                                    <span class="badge bg-warning text-dark ms-2">Modo Sandbox</span>
                                @else
                                    <span class="badge bg-success ms-2">Modo Producción</span>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            No hay configuración de Wompi. Complete el formulario a continuación para comenzar.
                        </div>
                    @endif

                    <!-- Formulario de configuración -->
                    <form action="{{ route('admin.pagos.wompi.store') }}" method="POST" id="wompiForm">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="public_key" class="form-label">
                                <i class="fas fa-key me-1"></i>
                                Llave Pública (Public Key) *
                            </label>
                            <input type="text" 
                                   class="form-control @error('public_key') is-invalid @enderror" 
                                   id="public_key" 
                                   name="public_key" 
                                   value="{{ old('public_key', $wompiPasarela->public_key ?? '') }}"
                                   placeholder="pub_prod_xxxxxxxxxx"
                                   required>
                            @error('public_key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Esta llave es pública y se usa en el frontend.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="private_key" class="form-label">
                                <i class="fas fa-lock me-1"></i>
                                Llave Privada (Private Key) *
                            </label>
                            <input type="text" 
                                   class="form-control @error('private_key') is-invalid @enderror" 
                                   id="private_key" 
                                   name="private_key" 
                                   value="{{ old('private_key', $wompiPasarela->decrypted_private_key ?? '') }}"
                                   placeholder="prv_prod_xxxxxxxxxx"
                                   {{ $wompiPasarela ? '' : 'required' }}>
                            @error('private_key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Esta llave es privada y se usa en el backend. Se encriptará al guardar.
                                @if($wompiPasarela)
                                    Dejar en blanco para mantener la actual.
                                @endif
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="events_key" class="form-label">
                                <i class="fas fa-bell me-1"></i>
                                Events Key (Opcional)
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="events_key" 
                                   name="events_key" 
                                   value="{{ old('events_key', $wompiPasarela->extra_config['events_key'] ?? '') }}"
                                   placeholder="prod_events_xxxxxxxxxx">
                            <small class="form-text text-muted">
                                Llave para validar eventos de Wompi.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="integrity_key" class="form-label">
                                <i class="fas fa-shield-alt me-1"></i>
                                Integrity Key (Opcional)
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="integrity_key" 
                                   name="integrity_key" 
                                   value="{{ old('integrity_key', $wompiPasarela->extra_config['integrity_key'] ?? '') }}"
                                   placeholder="prod_integrity_xxxxxxxxxx">
                            <small class="form-text text-muted">
                                Llave para validar la integridad de las transacciones.
                            </small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="sandbox" 
                                       name="sandbox" 
                                       value="1"
                                       {{ old('sandbox', $wompiPasarela->extra_config['sandbox'] ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="sandbox">
                                    <i class="fas fa-flask me-1"></i>
                                    Modo Sandbox (Pruebas)
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                Activa este modo para realizar pruebas. Desactívalo en producción.
                            </small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="activo" 
                                       name="activo" 
                                       value="1"
                                       {{ old('activo', $wompiPasarela->activo ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activo">
                                    <i class="fas fa-toggle-on me-1"></i>
                                    Activar Wompi
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                Los pagos solo se procesarán si Wompi está activo.
                            </small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Guardar Configuración
                            </button>
                        </div>
                    </form>

                    @if($wompiPasarela)
                        <hr class="my-4">
                        
                        <!-- Información adicional -->
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Información de la Integración
                                </h6>
                                <ul class="mb-0 small">
                                    <li><strong>URL del Webhook:</strong> 
                                        <code>{{ url('/wompi/confirmacion-pago') }}</code>
                                    </li>
                                    <li><strong>API URL:</strong> 
                                        <code>{{ $wompiPasarela->getApiUrl() }}</code>
                                    </li>
                                    <li><strong>Checkout URL:</strong> 
                                        <code>{{ $wompiPasarela->getCheckoutUrl() }}</code>
                                    </li>
                                    <li class="mt-2">
                                        <a href="https://docs.wompi.co/" target="_blank" class="text-decoration-none">
                                            <i class="fas fa-external-link-alt me-1"></i>
                                            Documentación de Wompi
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Estado de Pagos Online -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>
                        Estado de Pagos Online
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center py-4">
                        @if($pagoConfig && $pagoConfig->pago_online)
                            <div class="mb-3">
                                <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                            </div>
                            <h4 class="text-success">Pagos Online Activos</h4>
                            <p class="text-muted">Los clientes pueden realizar pagos en línea</p>
                        @else
                            <div class="mb-3">
                                <i class="fas fa-times-circle text-warning" style="font-size: 4rem;"></i>
                            </div>
                            <h4 class="text-warning">Pagos Online Inactivos</h4>
                            <p class="text-muted">Los pagos en línea están desactivados</p>
                        @endif
                    </div>

                    <hr>

                    <!-- Estadísticas rápidas -->
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="stat-card">
                                <h3 class="text-success mb-0">
                                    {{ $confirmaciones->where('estado', 'APPROVED')->count() }}
                                </h3>
                                <small class="text-muted">Aprobados</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-card">
                                <h3 class="text-warning mb-0">
                                    {{ $confirmaciones->where('estado', 'PENDING')->count() }}
                                </h3>
                                <small class="text-muted">Pendientes</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-card">
                                <h3 class="text-danger mb-0">
                                    {{ $confirmaciones->where('estado', 'DECLINED')->count() }}
                                </h3>
                                <small class="text-muted">Rechazados</small>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Moneda configurada -->
                    <div class="alert alert-light border" role="alert">
                        <strong><i class="fas fa-money-bill-wave me-2"></i>Moneda:</strong> 
                        {{ $pagoConfig ? $pagoConfig->moneda : 'No configurada' }}
                    </div>

                    {{-- en este espacio se agrega un input para valor flete (global) --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmaciones de Pago -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-secondary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list-alt me-2"></i>
                        Confirmaciones de Pago
                    </h5>
                    <button class="btn btn-sm btn-light" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                        <i class="fas fa-filter me-1"></i>
                        Filtros
                    </button>
                </div>
                
                <!-- Filtros -->
                <div class="collapse" id="filterCollapse">
                    <div class="card-body bg-light border-bottom">
                        <form action="{{ route('admin.pagos.filter') }}" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select name="estado" id="estado" class="form-select">
                                    <option value="">Todos</option>
                                    <option value="APPROVED" {{ request('estado') == 'APPROVED' ? 'selected' : '' }}>Aprobado</option>
                                    <option value="PENDING" {{ request('estado') == 'PENDING' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="DECLINED" {{ request('estado') == 'DECLINED' ? 'selected' : '' }}>Rechazado</option>
                                    <option value="VOIDED" {{ request('estado') == 'VOIDED' ? 'selected' : '' }}>Anulado</option>
                                    <option value="ERROR" {{ request('estado') == 'ERROR' ? 'selected' : '' }}>Error</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="fecha_desde" class="form-label">Desde</label>
                                <input type="date" name="fecha_desde" id="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="fecha_hasta" class="form-label">Hasta</label>
                                <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="referencia" class="form-label">Referencia</label>
                                <input type="text" name="referencia" id="referencia" class="form-control" placeholder="Buscar..." value="{{ request('referencia') }}">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i>
                                    Filtrar
                                </button>
                                <a href="{{ route('admin.pagos.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i>
                                    Limpiar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    @if($confirmaciones->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Referencia</th>
                                        <th>Transacción ID</th>
                                        <th>Monto</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($confirmaciones as $confirmacion)
                                        <tr>
                                            <td>{{ $confirmacion->idPagoConfirmacion }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $confirmacion->referencia }}</span>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ Str::limit($confirmacion->transaccion_id, 20) }}</small>
                                            </td>
                                            <td>
                                                <strong>{{ $confirmacion->getFormattedAmount() }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $confirmacion->getStatusBadgeColor() }}">
                                                    {{ $confirmacion->getStatusText() }}
                                                </span>
                                            </td>
                                            <td>
                                                <small>{{ $confirmacion->fecha_confirmacion->format('d/m/Y H:i') }}</small>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.pagos.confirmacion', $confirmacion->idPagoConfirmacion) }}" 
                                                   class="btn btn-sm btn-outline-primary"
                                                   title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $confirmaciones->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay confirmaciones de pago registradas</p>
                        </div>
                    @endif
                </div>
            </div>
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

.stat-card {
    padding: 1rem 0;
}

.card {
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>
@endpush
