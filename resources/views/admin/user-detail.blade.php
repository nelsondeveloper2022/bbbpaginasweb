@extends('admin.layout')

@section('title', 'Detalle de Usuario')
@section('page-title', 'Detalle de Usuario')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i>
        Volver a la lista
    </a>
</div>

<div class="row g-4">
    <!-- Información del Usuario -->
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <i class="fas fa-user me-2"></i>
                Información Personal
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="d-flex align-items-center mb-3">
                            @if($user->is_admin)
                                <i class="fas fa-user-shield text-primary me-2" style="font-size: 2rem;"></i>
                            @else
                                <i class="fas fa-user text-muted me-2" style="font-size: 2rem;"></i>
                            @endif
                            <div>
                                <h4 class="mb-0">{{ $user->name }}</h4>
                                @if($user->is_admin)
                                    <span class="status-badge status-admin">Administrador</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="text-muted small">Email</label>
                        <p class="mb-0">{{ $user->email }}</p>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="text-muted small">Móvil</label>
                        <p class="mb-0">{{ $user->movil ?? 'No especificado' }}</p>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="text-muted small">Email Validado</label>
                        <p class="mb-0">
                            @if($user->emailValidado)
                                <span class="text-success">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Validado
                                </span>
                            @else
                                <span class="text-danger">
                                    <i class="fas fa-times-circle me-1"></i>
                                    No validado
                                </span>
                            @endif
                        </p>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="text-muted small">Fecha de Registro</label>
                        <p class="mb-0">{{ $user->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">Última Actividad</label>
                        <p class="mb-0">{{ $user->updated_at->format('d/m/Y H:i:s') }}</p>
                    </div>

                    @if($user->email_verification_sent_at)
                        <div class="col-md-6">
                            <label class="text-muted small">Último Email de Verificación</label>
                            <p class="mb-0">{{ $user->email_verification_sent_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    @endif

                    <div class="col-md-6">
                        <label class="text-muted small">Completitud del Perfil</label>
                        <p class="mb-0">
                            <span class="fw-bold {{ $user->getProfileCompletion() >= 80 ? 'text-success' : ($user->getProfileCompletion() >= 50 ? 'text-warning' : 'text-danger') }}">
                                {{ $user->getProfileCompletion() }}%
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estado de Suscripción -->
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <i class="fas fa-crown me-2"></i>
                Estado de Suscripción
            </div>
            <div class="card-body p-4">
                @if(!$user->is_admin)
                    <div class="text-center mb-4">
                        @php
                            $status = $user->subscription_status;
                            $statusClass = '';
                            $statusIcon = '';
                            switch($status) {
                                case 'Activa':
                                    $statusClass = 'text-success';
                                    $statusIcon = 'fas fa-check-circle';
                                    break;
                                case 'Trial':
                                    $statusClass = 'text-warning';
                                    $statusIcon = 'fas fa-clock';
                                    break;
                                case 'Expirada':
                                    $statusClass = 'text-danger';
                                    $statusIcon = 'fas fa-times-circle';
                                    break;
                            }
                        @endphp
                        <i class="{{ $statusIcon }} {{ $statusClass }}" style="font-size: 3rem;"></i>
                        <h4 class="mt-2 {{ $statusClass }}">{{ $status }}</h4>
                    </div>

                    <div class="row g-3">
                        @if($user->plan)
                            <div class="col-12">
                                <label class="text-muted small">Plan Actual</label>
                                <p class="mb-0">
                                    <span class="badge bg-info">{{ $user->plan->nombre }}</span>
                                </p>
                            </div>
                        @endif

                        @if($user->subscription_starts_at)
                            <div class="col-md-6">
                                <label class="text-muted small">Suscripción Inició</label>
                                <p class="mb-0">{{ $user->subscription_starts_at->format('d/m/Y') }}</p>
                            </div>
                        @endif

                        @if($user->subscription_ends_at)
                            <div class="col-md-6">
                                <label class="text-muted small">Suscripción Termina</label>
                                <p class="mb-0">{{ $user->subscription_ends_at->format('d/m/Y') }}</p>
                            </div>
                        @endif

                        @if($user->trial_ends_at)
                            <div class="col-md-6">
                                <label class="text-muted small">Trial Termina</label>
                                <p class="mb-0">{{ $user->trial_ends_at->format('d/m/Y') }}</p>
                            </div>
                        @endif

                        @if($user->days_remaining !== null)
                            <div class="col-md-6">
                                <label class="text-muted small">Días Restantes</label>
                                <p class="mb-0">
                                    <span class="fw-bold {{ $user->days_remaining <= 7 ? 'text-danger' : ($user->days_remaining <= 30 ? 'text-warning' : 'text-success') }}">
                                        {{ $user->days_remaining }} días
                                    </span>
                                </p>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center">
                        <i class="fas fa-user-shield text-primary" style="font-size: 3rem;"></i>
                        <h4 class="mt-2 text-primary">Usuario Administrador</h4>
                        <p class="text-muted">Este usuario tiene acceso completo al panel de administración.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Información de la Empresa -->
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card-header">
                <i class="fas fa-building me-2"></i>
                Información de la Empresa
            </div>
            <div class="card-body p-4">
                @if($user->empresa || $user->empresa_nombre)
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="text-muted small">Nombre de la Empresa</label>
                            <p class="mb-0">
                                {{ $user->empresa->nombre ?? $user->empresa_nombre ?? 'No especificado' }}
                            </p>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="text-muted small">Email Corporativo</label>
                            <p class="mb-0">
                                {{ $user->empresa->email ?? $user->empresa_email ?? 'No especificado' }}
                            </p>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="text-muted small">Teléfono</label>
                            <p class="mb-0">
                                {{ $user->empresa->movil ?? 'No especificado' }}
                            </p>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="text-muted small">Dirección</label>
                            <p class="mb-0">
                                {{ $user->empresa->direccion ?? $user->empresa_direccion ?? 'No especificada' }}
                            </p>
                        </div>
                        
                        @if($user->empresa && $user->empresa->website)
                            <div class="col-md-6">
                                <label class="text-muted small">Sitio Web</label>
                                <p class="mb-0">
                                    <a href="{{ $user->empresa->website }}" target="_blank" class="text-decoration-none">
                                        {{ $user->empresa->website }}
                                        <i class="fas fa-external-link-alt ms-1"></i>
                                    </a>
                                </p>
                            </div>
                        @endif

                        @if($user->empresa && $user->empresa->whatsapp)
                            <div class="col-md-6">
                                <label class="text-muted small">WhatsApp</label>
                                <p class="mb-0">
                                    <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $user->empresa->whatsapp) }}" target="_blank" class="text-decoration-none text-success">
                                        {{ $user->empresa->whatsapp }}
                                        <i class="fab fa-whatsapp ms-1"></i>
                                    </a>
                                </p>
                            </div>
                        @endif

                        @if($user->empresa && ($user->empresa->facebook || $user->empresa->instagram || $user->empresa->linkedin || $user->empresa->twitter))
                            <div class="col-12">
                                <label class="text-muted small">Redes Sociales</label>
                                <div class="d-flex gap-2 flex-wrap">
                                    @if($user->empresa->facebook)
                                        <a href="{{ $user->empresa->facebook }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fab fa-facebook me-1"></i> Facebook
                                        </a>
                                    @endif
                                    @if($user->empresa->instagram)
                                        <a href="{{ $user->empresa->instagram }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                            <i class="fab fa-instagram me-1"></i> Instagram
                                        </a>
                                    @endif
                                    @if($user->empresa->linkedin)
                                        <a href="{{ $user->empresa->linkedin }}" target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="fab fa-linkedin me-1"></i> LinkedIn
                                        </a>
                                    @endif
                                    @if($user->empresa->twitter)
                                        <a href="{{ $user->empresa->twitter }}" target="_blank" class="btn btn-sm btn-outline-dark">
                                            <i class="fab fa-twitter me-1"></i> Twitter
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-building text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2 mb-0">No hay información de empresa disponible</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Landing Pages -->
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card-header d-flex justify-content-between align-items-center">
                <span>
                    <i class="fas fa-globe me-2"></i>
                    Landing Pages
                </span>
                <span class="badge bg-light text-dark">{{ $user->landings_count }} landing(s)</span>
            </div>
            <div class="card-body p-4">
                @if($user->landings->count() > 0)
                    <div class="row g-4">
                        @foreach($user->landings as $landing)
                            <div class="col-md-12">
                                <div class="border rounded p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h6 class="mb-0">
                                            {{ $landing->titulo_principal ?: 'Sin título' }}
                                        </h6>
                                        @if($user->empresa)
                                            @php
                                                $estadoEmpresa = $user->empresa->estado;
                                            @endphp
                                            @if($estadoEmpresa === 'en_construccion')
                                                <span class="badge bg-warning text-dark">En Construcción</span>
                                            @elseif($estadoEmpresa === 'publicada')
                                                <span class="badge bg-success">Publicada</span>
                                            @elseif($estadoEmpresa === 'sin_configurar' || is_null($estadoEmpresa))
                                                <span class="badge bg-secondary">Sin Configurar</span>
                                            @else
                                                <span class="badge bg-info">{{ ucfirst($estadoEmpresa) }}</span>
                                            @endif
                                        @endif
                                    </div>
                                    
                                    <div class="row g-2 text-sm">
                                        <div class="col-md-6">
                                            <strong>Objetivo:</strong> {{ $landing->objetivo ?: 'No especificado' }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Estilo:</strong> {{ $landing->estilo ?: 'No especificado' }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Tipografía:</strong> {{ $landing->tipografia ?: 'No especificado' }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Imágenes:</strong> {{ $landing->media->count() }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Color Principal:</strong> 
                                            @if($landing->color_principal)
                                                <span class="color-preview" style="background-color: {{ $landing->color_principal }};"></span>
                                                {{ $landing->color_principal }}
                                            @else
                                                No especificado
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Color Secundario:</strong> 
                                            @if($landing->color_secundario)
                                                <span class="color-preview" style="background-color: {{ $landing->color_secundario }};"></span>
                                                {{ $landing->color_secundario }}
                                            @else
                                                No especificado
                                            @endif
                                        </div>
                                        @if($landing->subtitulo)
                                            <div class="col-12">
                                                <strong>Subtítulo:</strong> {{ $landing->subtitulo }}
                                            </div>
                                        @endif
                                        @if($landing->descripcion)
                                            <div class="col-12">
                                                <strong>Descripción:</strong>
                                                <div class="mt-1 p-2 bg-light rounded">
                                                    {{ Str::limit($landing->descripcion, 200) }}
                                                </div>
                                            </div>
                                        @endif
                                        @if($landing->descripcion_objetivo)
                                            <div class="col-12">
                                                <strong>Descripción del Objetivo:</strong>
                                                <div class="mt-1 p-2 bg-light rounded">
                                                    {{ Str::limit($landing->descripcion_objetivo, 150) }}
                                                </div>
                                            </div>
                                        @endif
                                        @if($landing->audiencia_descripcion)
                                            <div class="col-12">
                                                <strong>Audiencia:</strong>
                                                <div class="mt-1 p-2 bg-light rounded">
                                                    {{ Str::limit($landing->audiencia_descripcion, 150) }}
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-12">
                                            <strong>Creada:</strong> {{ $landing->created_at->format('d/m/Y H:i') }}
                                            <strong class="ms-3">Última actualización:</strong> {{ $landing->updated_at->format('d/m/Y H:i') }}
                                        </div>
                                    </div>

                                    <!-- Imágenes de la landing -->
                                    @if($landing->media->count() > 0)
                                        <div class="mt-3">
                                            <strong class="d-block mb-2">Imágenes cargadas:</strong>
                                            <div class="row g-2">
                                                @foreach($landing->media as $media)
                                                    <div class="col-md-3">
                                                        <div class="card">
                                                            <img src="{{ asset('storage/' . $media->url) }}" 
                                                                 class="card-img-top" 
                                                                 style="height: 100px; object-fit: cover;"
                                                                 alt="{{ $media->descripcion }}">
                                                            <div class="card-body p-2">
                                                                <small class="text-muted">{{ $media->tipo }}</small>
                                                                @if($media->descripcion)
                                                                    <p class="small mb-0">{{ Str::limit($media->descripcion, 50) }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Logo si existe -->
                                    @if($landing->logo_url)
                                        <div class="mt-3">
                                            <strong class="d-block mb-2">Logo:</strong>
                                            <img src="{{ asset('storage/' . $landing->logo_url) }}" 
                                                 alt="Logo de {{ $user->empresa->nombre }}" 
                                                 style="max-height: 80px; max-width: 200px; border: 1px solid #dee2e6; border-radius: 5px;">
                                        </div>
                                    @endif

                                    @if($user->empresa && $user->empresa->estado === 'en_construccion')
                                        <div class="mt-3">
                                            <form method="POST" 
                                                  action="{{ route('admin.publish-landing', $user->id) }}" 
                                                  onsubmit="return confirm('¿Está seguro de publicar esta landing page? Se enviará un email al cliente.')">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm publish-button">
                                                    <i class="fas fa-rocket me-1"></i>
                                                    Publicar Landing
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($user->empresa && $user->empresa->estado === 'publicada')
                                        <div class="mt-3">
                                            @php
                                                $slug = $user->empresa->slug ?: 'empresa-' . $user->empresa->idEmpresa;
                                                $landingUrl = config('app.url') . '/' . $slug;
                                            @endphp
                                            <a href="{{ $landingUrl }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-external-link-alt me-1"></i>
                                                Ver Landing Publicada
                                            </a>
                                        </div>
                                    @elseif($user->empresa && ($user->empresa->estado === 'sin_configurar' || is_null($user->empresa->estado)))
                                        <div class="mt-3">
                                            <span class="badge bg-light text-dark">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Usuario aún no ha configurado su landing
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-globe text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2 mb-0">Este usuario no tiene landing pages creadas</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Historial de Renovaciones -->
    @if($user->renovaciones && $user->renovaciones->count() > 0)
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card-header">
                <i class="fas fa-history me-2"></i>
                Historial de Renovaciones
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-admin mb-0">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Plan</th>
                                <th>Monto</th>
                                <th>Estado</th>
                                <th>Método de Pago</th>
                                <th>ID Transacción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->renovaciones as $renovacion)
                                <tr>
                                    <td>{{ $renovacion->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $renovacion->plan->nombre ?? 'Plan eliminado' }}</td>
                                    <td>${{ number_format($renovacion->amount, 0, ',', '.') }} {{ $renovacion->currency }}</td>
                                    <td>
                                        @php
                                            $statusClass = '';
                                            switch($renovacion->status) {
                                                case 'completed':
                                                    $statusClass = 'bg-success';
                                                    $statusText = 'Completado';
                                                    break;
                                                case 'pending':
                                                    $statusClass = 'bg-warning';
                                                    $statusText = 'Pendiente';
                                                    break;
                                                case 'failed':
                                                    $statusClass = 'bg-danger';
                                                    $statusText = 'Fallido';
                                                    break;
                                                case 'cancelled':
                                                    $statusClass = 'bg-secondary';
                                                    $statusText = 'Cancelado';
                                                    break;
                                                default:
                                                    $statusClass = 'bg-light text-dark';
                                                    $statusText = ucfirst($renovacion->status);
                                            }
                                        @endphp
                                        <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                                    </td>
                                    <td>{{ $renovacion->payment_method ?: 'No especificado' }}</td>
                                    <td>
                                        <small class="text-muted">{{ $renovacion->transaction_id ?: 'N/A' }}</small>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection