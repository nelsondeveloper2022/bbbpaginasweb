@extends('layouts.dashboard')

@section('title', 'Configuración de Pagos - BBB Páginas Web')
@section('description', 'Configura las opciones de pago de tu empresa')

@section('content')
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="dashboard-title">
                <i class="bi bi-credit-card-2-back text-primary-gold me-2"></i>
                Configuración de Pagos
            </h1>
            <p class="text-muted mb-0">Gestiona las opciones de pago de {{ $empresa->nombre }}</p>
        </div>
        <div>
            @if($configuracionPagos->pago_online)
                <span class="badge bg-success fs-6 me-2">
                    <i class="bi bi-check-circle me-1"></i>
                    Pagos Habilitados
                </span>
            @else
                <span class="badge bg-warning fs-6 me-2">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Pagos Deshabilitados
                </span>
            @endif
            <a href="{{ route('admin.pagos.pasarelas.create') }}" class="btn btn-primary-gold">
                <i class="bi bi-plus-circle me-1"></i>
                Nueva Pasarela
            </a>
        </div>
    </div>
</div>

<!-- Configuración General -->
    <div class="row">
        <!-- Sidebar de configuración -->
        <div class="col-xl-4 col-lg-5 col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-gear me-2"></i>
                        Configuración
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="#configuracion-general" 
                           class="list-group-item list-group-item-action active"
                           data-bs-toggle="pill">
                            <i class="bi bi-sliders me-2"></i>
                            General
                        </a>
                        <a href="#pasarelas-pago" 
                           class="list-group-item list-group-item-action"
                           data-bs-toggle="pill">
                            <i class="bi bi-credit-card me-2"></i>
                            Pasarelas de Pago
                        </a>
                        <a href="#notificaciones" 
                           class="list-group-item list-group-item-action"
                           data-bs-toggle="pill">
                            <i class="bi bi-bell me-2"></i>
                            Notificaciones
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="col-xl-8 col-lg-7 col-md-8">

<!-- Pasarelas de Pago -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-credit-card me-2"></i>
                Pasarelas de Pago
            </h5>
            <small class="text-muted">
                {{ $configuracionPagos->pasarelas->count() }} pasarela(s) configurada(s)
            </small>
        </div>
    </div>
    
    @if($configuracionPagos->pasarelas->count() > 0)
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Pasarela</th>
                            <th>Estado</th>
                            <th>Ambiente</th>
                            <th>Configuración</th>
                            <th>Última Act.</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($configuracionPagos->pasarelas as $pasarela)
                            <tr class="{{ $pasarela->activo ? '' : 'table-secondary' }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="bi {{ $pasarela->icon_class }} text-primary" 
                                               style="font-size: 1.5rem;"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">{{ $pasarela->display_name }}</h6>
                                            <small class="text-muted">{{ $pasarela->nombre_pasarela }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($pasarela->activo)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Activa
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-pause-circle me-1"></i>
                                            Inactiva
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    {!! $pasarela->environment_badge !!}
                                </td>
                                <td>
                                    <div class="small">
                                        <div><strong>Public Key:</strong> {{ Str::mask($pasarela->public_key, '*', 4, -4) }}</div>
                                        <div><strong>Private Key:</strong> {{ Str::mask($pasarela->private_key, '*', 4, -4) }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small text-muted">
                                        {{ $pasarela->created_at ? $pasarela->created_at->diffForHumans() : 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" 
                                                class="btn btn-outline-info"
                                                onclick="testPasarela('{{ $pasarela->idPasarela }}')"
                                                title="Probar conexión">
                                            <i class="bi bi-wifi"></i>
                                        </button>
                                        
                                        <a href="{{ route('admin.pagos.pasarelas.edit', $pasarela) }}" 
                                           class="btn btn-outline-warning"
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        
                                        <button type="button" 
                                                class="btn btn-outline-{{ $pasarela->activo ? 'secondary' : 'success' }}"
                                                onclick="togglePasarela('{{ $pasarela->idPasarela }}', {{ $pasarela->activo ? 'false' : 'true' }})"
                                                title="{{ $pasarela->activo ? 'Desactivar' : 'Activar' }}">
                                            <i class="bi bi-{{ $pasarela->activo ? 'pause' : 'play' }}-circle"></i>
                                        </button>
                                        
                                        <button type="button" 
                                                class="btn btn-outline-danger"
                                                onclick="eliminarPasarela('{{ $pasarela->idPasarela }}', '{{ $pasarela->display_name }}')"
                                                title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="card-body text-center py-5">
            <i class="bi bi-credit-card-2-front text-muted mb-3" style="font-size: 4rem;"></i>
            <h4 class="text-muted mb-3">No hay pasarelas configuradas</h4>
            <p class="text-muted mb-4">
                Para recibir pagos online, necesitas configurar al menos una pasarela de pago.
            </p>
                                    <a href="{{ route('admin.pagos.pasarelas.create') }}" class="btn btn-primary-gold">
                <i class="bi bi-plus-circle"></i> Agregar Primera Pasarela
            </a>
        </div>
    @endif
</div>

<!-- Información sobre pasarelas disponibles -->
<div class="row mt-4">
    <div class="col-xl-6 col-lg-6 col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    Pasarelas Disponibles
                </h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex align-items-center">
                        <i class="bi bi-credit-card text-primary me-3" style="font-size: 1.5rem;"></i>
                        <div>
                            <h6 class="mb-1">Wompi</h6>
                            <p class="mb-0 small text-muted">Pasarela de pagos colombiana</p>
                        </div>
                    </div>
                    <div class="list-group-item d-flex align-items-center">
                        <i class="bi bi-credit-card-2-front text-warning me-3" style="font-size: 1.5rem;"></i>
                        <div>
                            <h6 class="mb-1">PayU</h6>
                            <p class="mb-0 small text-muted">Procesador de pagos para Latinoamérica</p>
                        </div>
                    </div>
                    <div class="list-group-item d-flex align-items-center">
                        <i class="bi bi-stripe text-info me-3" style="font-size: 1.5rem;"></i>
                        <div>
                            <h6 class="mb-1">Stripe</h6>
                            <p class="mb-0 small text-muted">Plataforma de pagos global</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-6 col-lg-6 col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-lightbulb me-2"></i>
                    Consejos de Seguridad
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-primary-gold">🔐 Claves seguras</h6>
                    <p class="small text-muted">Nunca compartas tus claves privadas. Mantenlas en un lugar seguro.</p>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-primary-gold">🧪 Modo sandbox</h6>
                    <p class="small text-muted">Prueba siempre en modo sandbox antes de activar el modo producción.</p>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-primary-gold">🔄 Webhooks</h6>
                    <p class="small text-muted">Configura webhooks para recibir notificaciones automáticas de pagos.</p>
                </div>
                
                <div class="mb-0">
                    <h6 class="text-primary-gold">📊 Monitoreo</h6>
                    <p class="small text-muted">Revisa regularmente el estado de tus pasarelas de pago.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Forms ocultos -->
<form id="toggleForm" method="POST" style="display: none;">
    @csrf
</form>

<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
function testPasarela(pasarelaId) {
    Swal.fire({
        title: 'Probando conexión...',
        text: 'Verificando la configuración de la pasarela',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    fetch(`/pagos/pasarelas/${pasarelaId}/test`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        Swal.close();
        
        if (data.success) {
            Swal.fire({
                title: '¡Conexión exitosa!',
                text: data.message,
                icon: 'success',
                confirmButtonColor: '#28a745'
            });
        } else {
            Swal.fire({
                title: 'Error de conexión',
                text: data.message,
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
        }
    })
    .catch(error => {
        Swal.close();
        Swal.fire({
            title: 'Error',
            text: 'No se pudo probar la conexión. Intenta nuevamente.',
            icon: 'error',
            confirmButtonColor: '#dc3545'
        });
    });
}

function togglePasarela(pasarelaId, activar) {
    const action = activar ? 'activar' : 'desactivar';
    const title = activar ? 'Activar Pasarela' : 'Desactivar Pasarela';
    const message = `¿Confirmas que deseas ${action} esta pasarela de pago?`;
    
    Swal.fire({
        title: title,
        text: message,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: `Sí, ${action}`,
        cancelButtonText: 'Cancelar',
        confirmButtonColor: activar ? '#28a745' : '#6c757d',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('toggleForm');
            form.action = `/pagos/pasarelas/${pasarelaId}/toggle`;
            form.submit();
        }
    });
}

function eliminarPasarela(pasarelaId, pasarelaNombre) {
    Swal.fire({
        title: '¿Estás seguro?',
        html: `
            <div class="text-center">
                <div class="mb-3">
                    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                </div>
                <p>Estás a punto de eliminar la pasarela:</p>
                <p class="fw-bold text-danger">${pasarelaNombre}</p>
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
            form.action = `/pagos/pasarelas/${pasarelaId}`;
            form.submit();
        }
    });
}
</script>
@endpush