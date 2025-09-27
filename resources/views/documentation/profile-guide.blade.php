@extends('layouts.dashboard')

@section('title', 'Configurar Perfil - BBB Páginas Web')
@section('description', 'Aprende a completar y actualizar tu información de perfil')

@section('content')
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="dashboard-title">
                <i class="bi bi-person-gear me-3"></i>
                Configurar Perfil
            </h1>
            <p class="text-muted mb-0">Completa tu información para personalizar tu sitio web</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('documentation.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-2"></i>
                Volver
            </a>
            <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-pencil me-2"></i>
                Editar Perfil
            </a>
        </div>
    </div>
</div>

<!-- Estado del perfil -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1">Estado de tu Perfil</h6>
                        <p class="text-muted mb-0">Completa tu información para mejorar tu sitio web</p>
                    </div>
                    <div class="text-end">
                        @php
                            $completionPercentage = 0;
                            $totalFields = 8;
                            $completedFields = 0;
                            
                            if (!empty(auth()->user()->name)) $completedFields++;
                            if (!empty(auth()->user()->email) && auth()->user()->hasVerifiedEmail()) $completedFields++;
                            if (!empty(auth()->user()->telefono)) $completedFields++;
                            if (!empty(auth()->user()->empresa_nombre)) $completedFields++;
                            if (!empty(auth()->user()->empresa_email)) $completedFields++;
                            if (!empty(auth()->user()->empresa_telefono)) $completedFields++;
                            if (!empty(auth()->user()->empresa_direccion)) $completedFields++;
                            if (!empty(auth()->user()->empresa_descripcion)) $completedFields++;
                            
                            $completionPercentage = ($completedFields / $totalFields) * 100;
                        @endphp
                        
                        <div class="d-flex align-items-center">
                            <div class="progress me-3" style="width: 120px; height: 8px;">
                                <div class="progress-bar bg-{{ $completionPercentage >= 80 ? 'success' : ($completionPercentage >= 50 ? 'warning' : 'danger') }}" 
                                     style="width: {{ $completionPercentage }}%"></div>
                            </div>
                            <span class="badge bg-{{ $completionPercentage >= 80 ? 'success' : ($completionPercentage >= 50 ? 'warning' : 'danger') }}">
                                {{ round($completionPercentage) }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Información Personal -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-person-circle text-primary me-2"></i>
                    Información Personal
                </h6>
            </div>
            <div class="card-body">
                <div class="step-guide">
                    <div class="step-item {{ !empty(auth()->user()->name) ? 'completed' : '' }}">
                        <div class="step-icon">
                            @if(!empty(auth()->user()->name))
                                <i class="bi bi-check-circle-fill text-success"></i>
                            @else
                                <i class="bi bi-circle text-muted"></i>
                            @endif
                        </div>
                        <div class="step-content">
                            <h6>Nombre Completo</h6>
                            <p class="text-muted mb-1">Tu nombre aparecerá en la información de contacto</p>
                            @if(!empty(auth()->user()->name))
                                <span class="badge bg-success-soft text-success">{{ auth()->user()->name }}</span>
                            @else
                                <span class="badge bg-warning-soft text-warning">Pendiente</span>
                            @endif
                        </div>
                    </div>

                    <div class="step-item {{ !empty(auth()->user()->email) && auth()->user()->hasVerifiedEmail() ? 'completed' : '' }}">
                        <div class="step-icon">
                            @if(!empty(auth()->user()->email) && auth()->user()->hasVerifiedEmail())
                                <i class="bi bi-check-circle-fill text-success"></i>
                            @else
                                <i class="bi bi-circle text-muted"></i>
                            @endif
                        </div>
                        <div class="step-content">
                            <h6>Email Personal</h6>
                            <p class="text-muted mb-1">Necesario para notificaciones importantes</p>
                            @if(!empty(auth()->user()->email))
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-info-soft text-info">{{ auth()->user()->email }}</span>
                                    @if(auth()->user()->hasVerifiedEmail())
                                        <span class="badge bg-success">Verificado</span>
                                    @else
                                        <span class="badge bg-warning">Sin verificar</span>
                                    @endif
                                </div>
                            @else
                                <span class="badge bg-warning-soft text-warning">Pendiente</span>
                            @endif
                        </div>
                    </div>

                    <div class="step-item {{ !empty(auth()->user()->telefono) ? 'completed' : '' }}">
                        <div class="step-icon">
                            @if(!empty(auth()->user()->telefono))
                                <i class="bi bi-check-circle-fill text-success"></i>
                            @else
                                <i class="bi bi-circle text-muted"></i>
                            @endif
                        </div>
                        <div class="step-content">
                            <h6>Teléfono Personal</h6>
                            <p class="text-muted mb-1">Para contacto directo (opcional)</p>
                            @if(!empty(auth()->user()->telefono))
                                <span class="badge bg-success-soft text-success">{{ auth()->user()->telefono }}</span>
                            @else
                                <span class="badge bg-secondary-soft text-secondary">Opcional</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil me-2"></i>
                        Actualizar Información Personal
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Información de Empresa -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-building text-info me-2"></i>
                    Información de Empresa
                </h6>
            </div>
            <div class="card-body">
                <div class="step-guide">
                    <div class="step-item {{ !empty(auth()->user()->empresa_nombre) ? 'completed' : '' }}">
                        <div class="step-icon">
                            @if(!empty(auth()->user()->empresa_nombre))
                                <i class="bi bi-check-circle-fill text-success"></i>
                            @else
                                <i class="bi bi-exclamation-circle-fill text-warning"></i>
                            @endif
                        </div>
                        <div class="step-content">
                            <h6>Nombre de la Empresa</h6>
                            <p class="text-muted mb-1">Aparecerá como título principal en tu sitio web</p>
                            @if(!empty(auth()->user()->empresa_nombre))
                                <span class="badge bg-success-soft text-success">{{ auth()->user()->empresa_nombre }}</span>
                            @else
                                <span class="badge bg-warning">Requerido</span>
                            @endif
                        </div>
                    </div>

                    <div class="step-item {{ !empty(auth()->user()->empresa_email) ? 'completed' : '' }}">
                        <div class="step-icon">
                            @if(!empty(auth()->user()->empresa_email))
                                <i class="bi bi-check-circle-fill text-success"></i>
                            @else
                                <i class="bi bi-exclamation-circle-fill text-warning"></i>
                            @endif
                        </div>
                        <div class="step-content">
                            <h6>Email Corporativo</h6>
                            <p class="text-muted mb-1">Email de contacto para clientes</p>
                            @if(!empty(auth()->user()->empresa_email))
                                <span class="badge bg-success-soft text-success">{{ auth()->user()->empresa_email }}</span>
                            @else
                                <span class="badge bg-warning">Requerido</span>
                            @endif
                        </div>
                    </div>

                    <div class="step-item {{ !empty(auth()->user()->empresa_telefono) ? 'completed' : '' }}">
                        <div class="step-icon">
                            @if(!empty(auth()->user()->empresa_telefono))
                                <i class="bi bi-check-circle-fill text-success"></i>
                            @else
                                <i class="bi bi-exclamation-circle-fill text-warning"></i>
                            @endif
                        </div>
                        <div class="step-content">
                            <h6>Teléfono de la Empresa</h6>
                            <p class="text-muted mb-1">Número principal para contacto</p>
                            @if(!empty(auth()->user()->empresa_telefono))
                                <span class="badge bg-success-soft text-success">{{ auth()->user()->empresa_telefono }}</span>
                            @else
                                <span class="badge bg-warning">Requerido</span>
                            @endif
                        </div>
                    </div>

                    <div class="step-item {{ !empty(auth()->user()->empresa_direccion) ? 'completed' : '' }}">
                        <div class="step-icon">
                            @if(!empty(auth()->user()->empresa_direccion))
                                <i class="bi bi-check-circle-fill text-success"></i>
                            @else
                                <i class="bi bi-circle text-muted"></i>
                            @endif
                        </div>
                        <div class="step-content">
                            <h6>Dirección de la Empresa</h6>
                            <p class="text-muted mb-1">Ubicación física de tu negocio</p>
                            @if(!empty(auth()->user()->empresa_direccion))
                                <span class="badge bg-success-soft text-success">Completada</span>
                            @else
                                <span class="badge bg-secondary-soft text-secondary">Opcional</span>
                            @endif
                        </div>
                    </div>

                    <div class="step-item {{ !empty(auth()->user()->empresa_descripcion) ? 'completed' : '' }}">
                        <div class="step-icon">
                            @if(!empty(auth()->user()->empresa_descripcion))
                                <i class="bi bi-check-circle-fill text-success"></i>
                            @else
                                <i class="bi bi-circle text-muted"></i>
                            @endif
                        </div>
                        <div class="step-content">
                            <h6>Descripción de la Empresa</h6>
                            <p class="text-muted mb-1">Breve descripción de tu negocio</p>
                            @if(!empty(auth()->user()->empresa_descripcion))
                                <span class="badge bg-success-soft text-success">Completada</span>
                            @else
                                <span class="badge bg-secondary-soft text-secondary">Recomendada</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('profile.edit') }}" class="btn btn-info btn-sm">
                        <i class="bi bi-building me-2"></i>
                        Actualizar Información de Empresa
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Consejos y mejores prácticas -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-lightbulb text-warning me-2"></i>
                    Consejos para un Perfil Exitoso
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="tip-item">
                            <div class="tip-icon">
                                <i class="bi bi-check-circle text-success"></i>
                            </div>
                            <div class="tip-content">
                                <h6>Información Completa y Precisa</h6>
                                <p class="text-muted mb-0">
                                    Asegúrate de que toda tu información sea precisa y esté actualizada. 
                                    Los clientes necesitan poder contactarte fácilmente.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="tip-item">
                            <div class="tip-icon">
                                <i class="bi bi-envelope-check text-info"></i>
                            </div>
                            <div class="tip-content">
                                <h6>Verifica tu Email</h6>
                                <p class="text-muted mb-0">
                                    La verificación de email es obligatoria para publicar tu sitio. 
                                    Revisa tu bandeja de entrada y spam.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="tip-item">
                            <div class="tip-icon">
                                <i class="bi bi-telephone text-primary"></i>
                            </div>
                            <div class="tip-content">
                                <h6>Números de Teléfono</h6>
                                <p class="text-muted mb-0">
                                    Incluye el código de país (+57 para Colombia) y asegúrate de que 
                                    los números sean fáciles de marcar.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="tip-item">
                            <div class="tip-icon">
                                <i class="bi bi-file-text text-secondary"></i>
                            </div>
                            <div class="tip-content">
                                <h6>Descripción Atractiva</h6>
                                <p class="text-muted mb-0">
                                    Escribe una descripción clara de tu negocio que explique qué haces 
                                    y por qué los clientes deberían elegirte.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Próximos pasos -->
@if($completionPercentage < 100)
<div class="row mt-4">
    <div class="col-12">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-white mb-2">¡Casi terminamos!</h6>
                        <p class="mb-0 opacity-75">
                            Completa tu perfil para obtener el máximo beneficio de tu sitio web
                        </p>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('profile.edit') }}" class="btn btn-light">
                            <i class="bi bi-arrow-right me-2"></i>
                            Completar Perfil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row mt-4">
    <div class="col-12">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="bi bi-check-circle-fill mb-3" style="font-size: 3rem;"></i>
                <h5 class="text-white mb-2">¡Perfil Completo!</h5>
                <p class="mb-3 opacity-75">
                    Tu información está completa y lista para tu sitio web
                </p>
                <a href="{{ route('documentation.publish-guide') }}" class="btn btn-light">
                    <i class="bi bi-globe me-2"></i>
                    Ver Guía de Publicación
                </a>
            </div>
        </div>
    </div>
</div>
@endif

<style>
.step-guide {
    padding: 0;
}

.step-item {
    display: flex;
    align-items-flex-start;
    margin-bottom: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #eee;
}

.step-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.step-item.completed .step-content h6 {
    color: var(--bs-success);
}

.step-icon {
    flex-shrink: 0;
    margin-right: 1rem;
    margin-top: 0.25rem;
}

.step-icon i {
    font-size: 1.25rem;
}

.step-content {
    flex-grow: 1;
}

.step-content h6 {
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.step-content p {
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.tip-item {
    display: flex;
    align-items-flex-start;
}

.tip-icon {
    flex-shrink: 0;
    margin-right: 1rem;
    margin-top: 0.25rem;
}

.tip-icon i {
    font-size: 1.5rem;
}

.tip-content h6 {
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.badge.bg-success-soft {
    background-color: rgba(25, 135, 84, 0.1) !important;
    color: var(--bs-success) !important;
}

.badge.bg-warning-soft {
    background-color: rgba(255, 193, 7, 0.1) !important;
    color: var(--bs-warning) !important;
}

.badge.bg-info-soft {
    background-color: rgba(13, 202, 240, 0.1) !important;
    color: var(--bs-info) !important;
}

.badge.bg-secondary-soft {
    background-color: rgba(108, 117, 125, 0.1) !important;
    color: var(--bs-secondary) !important;
}
</style>
@endsection