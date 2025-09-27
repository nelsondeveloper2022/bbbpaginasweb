@extends('layouts.dashboard')

@section('title', 'Dashboard - BBB Páginas Web')
@section('description', 'Panel de control principal de BBB Páginas Web')

@section('content')
    <!-- Content Header -->
    <div class="content-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="dashboard-title">Panel de Control</h1>
                <p class="text-muted mb-0">Gestiona tu cuenta y configuraciones</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="text-end">
                    <small class="text-muted d-block">Última conexión</small>
                    <span class="badge bg-success">Ahora</span>
                </div>
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-gear"></i> Configurar
                </a>
            </div>
        </div>
    </div>

<!-- Email Verification Alert - PERMANENTLY VISIBLE UNTIL VERIFIED -->
@if (!auth()->user()->emailValidado)
<div class="email-verification-alert-permanent shadow-sm mb-4" id="emailVerificationAlert" 
     style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); 
            border: 2px solid #dc3545; 
            border-left: 8px solid #dc3545 !important; 
            border-radius: 8px; 
            padding: 20px; 
            margin-bottom: 25px;
            position: sticky;
            top: 10px;
            z-index: 1050;">
    <div class="d-flex align-items-center">
        <div class="me-4">
            <div class="alert-icon-container" style="background: #dc3545; border-radius: 50%; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-shield-exclamation fs-1 text-white"></i>
            </div>
        </div>
        <div class="flex-grow-1">
            <h4 class="mb-2 text-danger fw-bold" style="font-size: 1.3rem;">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                🚨 VERIFICACIÓN OBLIGATORIA PENDIENTE
            </h4>
            <p class="mb-3 fw-bold" style="font-size: 1.1rem; line-height: 1.4;">
                Tu email <strong class="text-decoration-underline">{{ auth()->user()->email }}</strong> no está verificado. 
                <span class="text-danger bg-white px-2 py-1 rounded border">
                    <i class="bi bi-x-circle me-1"></i>
                    TU SITIO WEB NO SE PUBLICARÁ
                </span> hasta completar la verificación.
            </p>
            <div class="d-flex gap-3 flex-wrap align-items-center">
                <button type="button" class="btn btn-danger fw-bold px-4 py-2" 
                        onclick="sendVerificationEmail()" 
                        style="font-size: 1rem; border-radius: 25px;">
                    <i class="bi bi-envelope-plus me-2"></i>
                    Enviar Email de Verificación AHORA
                </button>
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-danger fw-bold px-3 py-2" style="border-radius: 25px;">
                    <i class="bi bi-person-gear me-1"></i>
                    Ir a mi perfil
                </a>
                <div class="bg-warning text-dark px-3 py-2 rounded fw-bold small border border-warning-subtle">
                    <i class="bi bi-info-circle me-1"></i>
                    Esta alerta NO se puede cerrar hasta verificar
                </div>
            </div>
        </div>
        <div class="text-end">
            <div class="lock-animation" style="animation: pulse 2s infinite;">
                <i class="bi bi-lock-fill" style="font-size: 3rem; color: #dc3545; filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.3));"></i>
            </div>
        </div>
    </div>
    
    <!-- Progress Bar de urgencia -->
    <div class="mt-3">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <small class="text-danger fw-bold">Estado de tu cuenta:</small>
            <small class="text-danger fw-bold">BLOQUEADA PARA PUBLICACIÓN</small>
        </div>
        <div class="progress" style="height: 8px; background: #fff;">
            <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" 
                 role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
            </div>
        </div>
        <small class="text-muted mt-1 d-block">
            <i class="bi bi-clock me-1"></i>
            Verifica tu email para desbloquear todas las funciones
        </small>
    </div>
</div>

<style>
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }

    .email-verification-alert-permanent {
        animation: slideDown 0.5s ease-out;
        box-shadow: 0 4px 20px rgba(220, 53, 69, 0.3) !important;
    }

    @keyframes slideDown {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Asegurar que NO se pueda ocultar */
    .email-verification-alert-permanent .btn-close,
    .email-verification-alert-permanent [data-bs-dismiss] {
        display: none !important;
    }
</style>
@endif

<!-- License Status Section -->
@php
    $currentPlan = auth()->user()->plan;
    $planName = $currentPlan ? $currentPlan->nombre : 'Plan Gratuito';
    $isExpired = auth()->user()->trial_ends_at && auth()->user()->trial_ends_at->isPast();
    $daysLeft = 0;
    
    if (auth()->user()->trial_ends_at) {
        $daysLeft = intval(now()->diffInDays(auth()->user()->trial_ends_at, false));
        $daysLeft = max(0, $daysLeft); // Asegurar que no sea negativo
    }
@endphp

<div class="row mb-4">
    <div class="col-12">
        <div class="card license-status-card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center mb-3">
                            @if($isExpired)
                                <div class="status-icon bg-danger text-white me-3">
                                    <i class="bi bi-exclamation-triangle fs-4"></i>
                                </div>
                                <div>
                                    <h4 class="text-danger mb-1 fw-bold">Licencia Vencida</h4>
                                    <p class="text-muted mb-0">Tu plan <strong>{{ $planName }}</strong> venció el {{ auth()->user()->trial_ends_at->format('d/m/Y') }}</p>
                                </div>
                            @else
                                <div class="status-icon bg-success text-white me-3">
                                    <i class="bi bi-check-circle fs-4"></i>
                                </div>
                                <div>
                                    <h4 class="text-success mb-1 fw-bold">Licencia Activa</h4>
                                    <p class="text-muted mb-0">Plan <strong>{{ $planName }}</strong> - {{ intval($daysLeft) }} días restantes</p>
                                </div>
                            @endif
                        </div>
                        
                        @if($isExpired)
                            <div class="alert alert-danger border-0 mb-0" style="background: rgba(220, 53, 69, 0.1);">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-shield-exclamation me-2 fs-5"></i>
                                    <div>
                                        <strong>Acceso restringido:</strong> 
                                        <br><small>Algunas funciones están bloqueadas hasta que renueves tu plan.</small>
                                    </div>
                                </div>
                            </div>
                        @elseif($daysLeft <= 7)
                            <div class="alert alert-warning border-0 mb-0" style="background: rgba(255, 193, 7, 0.1);">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-clock-history me-2 fs-5"></i>
                                    <div>
                                        <strong>¡Tu plan vence pronto!</strong>
                                        <br><small>Renueva ahora para evitar interrupciones en el servicio.</small>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-success border-0 mb-0" style="background: rgba(25, 135, 84, 0.1);">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-shield-check me-2 fs-5"></i>
                                    <div>
                                        <strong>Todo está funcionando perfectamente</strong>
                                        <br><small>Tienes acceso completo a todas las funciones.</small>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="col-md-4 text-md-end">
                        @if($isExpired)
                            <a href="{{ route('admin.plans.index') }}" class="btn btn-danger btn-lg shadow-sm pulse-button">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                ¡Renovar Ahora!
                            </a>
                            <div class="mt-2">
                                <small class="text-danger fw-bold">
                                    <i class="bi bi-clock me-1"></i>
                                    Acción requerida
                                </small>
                            </div>
                        @elseif($daysLeft <= 7)
                            <a href="{{ route('admin.plans.index') }}" class="btn btn-warning btn-lg shadow-sm">
                                <i class="bi bi-clock-history me-2"></i>
                                Renovar Plan
                            </a>
                            <div class="mt-2">
                                <small class="text-warning fw-bold">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Vence en {{ $daysLeft }} días
                                </small>
                            </div>
                        @else
                            <a href="{{ route('admin.plans.index') }}" class="btn btn-primary btn-lg shadow-sm">
                                <i class="bi bi-credit-card me-2"></i>
                                Gestionar Plan
                            </a>
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="bi bi-shield-check me-1"></i>
                                    Todo funcionando bien
                                </small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.license-status-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
}

.status-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.pulse-button {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
    }
}
</style>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        @if(auth()->user()->id_plan == 6)
            <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="stat-number mb-0">
                        @if($hasActiveSubscription)
                            {{ intval($subscriptionDaysLeft) }}
                        @else
                            {{ intval($trialDaysLeft ?? 0) }}
                        @endif
                        </h5>
                        <span class="stat-label">
                        @if($hasActiveSubscription)
                            Días de suscripción
                        @else
                            Días de prueba
                        @endif
                        </span>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        @endif
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon {{ $hasActiveSubscription ? 'bg-success' : ($trialExpired ? 'bg-danger' : 'bg-warning') }}">
                            <i class="bi {{ $hasActiveSubscription ? 'bi-shield-check' : ($trialExpired ? 'bi-shield-exclamation' : 'bi-shield-fill-plus') }}"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="stat-number mb-0">
                                @if($hasActiveSubscription)
                                    Premium
                                @elseif($trialExpired)
                                    Expirado
                                @else
                                    Plan Free
                                @endif
                            </h5>
                            <span class="stat-label">Estado cuenta</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-warning">
                            <i class="bi bi-building"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="stat-number mb-0">{{ auth()->user()->empresa_nombre ?? 'N/A' }}</h5>
                            <span class="stat-label">Empresa</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-info">
                            <i class="bi bi-star"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="stat-number mb-0">{{ Str::limit(auth()->user()->plan->nombre ?? 'Trial', 10, '...') }}</h5>
                            <span class="stat-label">Plan actual</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Main Content Row -->
<div class="row g-4 mb-4">
    <!-- Main Content Grid -->
    <div class="row">
        <!-- Account Information -->
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-person-circle me-2"></i>
                        Información Completa de la Cuenta
                    </h5>
                    <div class="d-flex gap-2">
                        @php
                            $profileCompletion = auth()->user()->getProfileCompletion();
                            $completionColor = $profileCompletion >= 90 ? 'success' : ($profileCompletion >= 70 ? 'warning' : 'danger');
                        @endphp
                        <div class="profile-completion d-none d-md-block">
                            <small class="text-muted">Perfil completo:</small>
                            <span class="badge bg-{{ $completionColor }} ms-1">{{ $profileCompletion }}%</span>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Información Personal -->
                    <div class="mb-4">
                        <h6 class="text-primary fw-bold mb-3">
                            <i class="bi bi-person-badge me-2"></i>
                            Información Personal
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-group mb-3">
                                    <label class="info-label">Nombre completo</label>
                                    <div class="info-value d-flex align-items-center">
                                        <span>{{ auth()->user()->name ?? 'No especificado' }}</span>
                                        @if(empty(auth()->user()->name))
                                            <i class="bi bi-exclamation-triangle text-warning ms-2" title="Campo requerido"></i>
                                        @endif
                                    </div>
                                </div>
                                <div class="info-group mb-3">
                                    <label class="info-label d-flex align-items-center">
                                        <span class="me-2">Correo electrónico</span>
                                        @if(auth()->user()->isEmailVerified())
                                            <span class="badge bg-success">
                                                <i class="bi bi-shield-check me-1"></i>Verificado
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="bi bi-shield-exclamation me-1"></i>Sin verificar
                                            </span>
                                        @endif
                                    </label>
                                    <div class="info-value">
                                        {{ auth()->user()->email }}
                                    </div>
                                </div>
                                <div class="info-group mb-3">
                                    <label class="info-label">Teléfono móvil</label>
                                    <div class="info-value d-flex align-items-center">
                                        <span>{{ auth()->user()->movil ?? 'No especificado' }}</span>
                                        @if(empty(auth()->user()->movil))
                                            <i class="bi bi-info-circle text-info ms-2" title="Campo opcional pero recomendado"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group mb-3">
                                    <label class="info-label">ID de Usuario</label>
                                    <div class="info-value">
                                        <code class="bg-light px-2 py-1 rounded">#{{ auth()->user()->id }}</code>
                                    </div>
                                </div>
                                <div class="info-group mb-3">
                                    <label class="info-label">Miembro desde</label>
                                    <div class="info-value">
                                        {{ auth()->user()->created_at->format('d/m/Y') }}
                                        <small class="text-muted">({{ auth()->user()->created_at->diffForHumans() }})</small>
                                    </div>
                                </div>
                                <div class="info-group mb-3">
                                    <label class="info-label">Última actualización</label>
                                    <div class="info-value">
                                        {{ auth()->user()->updated_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información de la Empresa -->
                    <div class="mb-4">
                        <h6 class="text-info fw-bold mb-3">
                            <i class="bi bi-building me-2"></i>
                            Información de la Empresa
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                @if(auth()->user()->empresa)
                                    <!-- Datos de la empresa relacionada -->
                                    <div class="info-group mb-3">
                                        <label class="info-label">Nombre de la empresa</label>
                                        <div class="info-value">
                                            <strong>{{ auth()->user()->empresa->nombre }}</strong>
                                            <small class="text-success d-block">
                                                <i class="bi bi-link-45deg me-1"></i>
                                                Empresa vinculada
                                            </small>
                                        </div>
                                    </div>
                                    <div class="info-group mb-3">
                                        <label class="info-label">Email corporativo</label>
                                        <div class="info-value">{{ auth()->user()->empresa->email ?? 'No especificado' }}</div>
                                    </div>
                                    <div class="info-group mb-3">
                                        <label class="info-label">Teléfono corporativo</label>
                                        <div class="info-value">{{ auth()->user()->empresa->movil ?? 'No especificado' }}</div>
                                    </div>
                                @else
                                    <!-- Datos básicos del usuario -->
                                    <div class="info-group mb-3">
                                        <label class="info-label">Nombre de la empresa</label>
                                        <div class="info-value d-flex align-items-center">
                                            <span>{{ auth()->user()->empresa_nombre ?? 'No especificado' }}</span>
                                            @if(empty(auth()->user()->empresa_nombre))
                                                <i class="bi bi-exclamation-triangle text-warning ms-2" title="Campo requerido"></i>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="info-group mb-3">
                                        <label class="info-label">Email corporativo</label>
                                        <div class="info-value">{{ auth()->user()->empresa_email ?? 'No especificado' }}</div>
                                    </div>
                                    <div class="info-group mb-3">
                                        <label class="info-label">Dirección</label>
                                        <div class="info-value">{{ auth()->user()->empresa_direccion ?? 'No especificado' }}</div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if(auth()->user()->empresa)
                                    <div class="info-group mb-3">
                                        <label class="info-label">Dirección</label>
                                        <div class="info-value">{{ auth()->user()->empresa->direccion ?? 'No especificado' }}</div>
                                    </div>
                                    <div class="info-group mb-3">
                                        <label class="info-label">Sitio web</label>
                                        <div class="info-value">
                                            @if(auth()->user()->empresa->website)
                                                <a href="{{ auth()->user()->empresa->website }}" target="_blank" class="text-primary">
                                                    {{ auth()->user()->empresa->website }}
                                                    <i class="bi bi-box-arrow-up-right ms-1"></i>
                                                </a>
                                            @else
                                                No especificado
                                            @endif
                                        </div>
                                    </div>
                                    <div class="info-group mb-3">
                                        <label class="info-label">Redes sociales</label>
                                        <div class="info-value">
                                            @if(auth()->user()->hasSocialMedia())
                                                <div class="social-links">
                                                    @if(auth()->user()->empresa->facebook)
                                                        <a href="{{ auth()->user()->empresa->facebook }}" target="_blank" class="me-2">
                                                            <i class="bi bi-facebook text-primary"></i>
                                                        </a>
                                                    @endif
                                                    @if(auth()->user()->empresa->instagram)
                                                        <a href="{{ auth()->user()->empresa->instagram }}" target="_blank" class="me-2">
                                                            <i class="bi bi-instagram text-danger"></i>
                                                        </a>
                                                    @endif
                                                    @if(auth()->user()->empresa->linkedin)
                                                        <a href="{{ auth()->user()->empresa->linkedin }}" target="_blank" class="me-2">
                                                            <i class="bi bi-linkedin text-info"></i>
                                                        </a>
                                                    @endif
                                                    @if(auth()->user()->empresa->youtube)
                                                        <a href="{{ auth()->user()->empresa->youtube }}" target="_blank" class="me-2">
                                                            <i class="bi bi-youtube text-danger"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">No configuradas</span>
                                                <small class="text-info d-block">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    Agrégalas para mejor presencia online
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-info border-0 small">
                                        <i class="bi bi-info-circle me-2"></i>
                                        <strong>¿Tienes una empresa registrada?</strong><br>
                                        Vincula tu cuenta con una empresa para acceder a más funciones.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Información del Plan y Suscripción -->
                    <div class="mb-4">
                        <h6 class="text-success fw-bold mb-3">
                            <i class="bi bi-credit-card me-2"></i>
                            Plan y Suscripción
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-group mb-3">
                                    <label class="info-label">Plan actual</label>
                                    <div class="info-value d-flex align-items-center">
                                        <span class="me-2">{{ auth()->user()->plan->nombre ?? 'Sin plan' }}</span>
                                        @if(auth()->user()->plan)
                                            @if(auth()->user()->currentPlanExpired())
                                                <span class="badge bg-danger">Expirado</span>
                                            @elseif(auth()->user()->hasActiveSubscription())
                                                <span class="badge bg-success">Activo</span>
                                            @elseif(auth()->user()->isOnTrial())
                                                <span class="badge bg-warning">Prueba</span>
                                            @else
                                                <span class="badge bg-secondary">Inactivo</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                @if(auth()->user()->plan)
                                    <div class="info-group mb-3">
                                        <label class="info-label">Precio del plan</label>
                                        <div class="info-value">
                                            @if(auth()->user()->plan->precioPesos > 0)
                                                ${{ number_format(auth()->user()->plan->precioPesos, 0, ',', '.') }} COP
                                                @if(auth()->user()->plan->preciosDolar > 0)
                                                    / ${{ number_format(auth()->user()->plan->preciosDolar, 2) }} USD
                                                @endif
                                            @else
                                                <span class="text-success fw-bold">Gratuito</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="info-group mb-3">
                                        <label class="info-label">Duración del plan</label>
                                        <div class="info-value">
                                            @if(auth()->user()->plan->dias > 0)
                                                {{ auth()->user()->plan->dias }} días
                                            @else
                                                <span class="text-success">Ilimitado</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if(auth()->user()->trial_ends_at)
                                    <div class="info-group mb-3">
                                        <label class="info-label">
                                            @if(auth()->user()->hasActiveSubscription())
                                                Fecha fin de suscripción
                                            @else
                                                Fecha fin de prueba
                                            @endif
                                        </label>
                                        <div class="info-value">
                                            {{ auth()->user()->trial_ends_at->format('d/m/Y H:i') }}
                                            @php
                                                $daysLeft = now()->diffInDays(auth()->user()->trial_ends_at, false);
                                            @endphp
                                            @if($daysLeft > 0)
                                                <small class="text-success d-block">({{ intval($daysLeft) }} días restantes)</small>
                                            @else
                                                <small class="text-danger d-block">(Expirado)</small>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                
                                @if(auth()->user()->subscription_starts_at && auth()->user()->subscription_ends_at)
                                    <div class="info-group mb-3">
                                        <label class="info-label">Período de suscripción</label>
                                        <div class="info-value">
                                            <small class="text-muted">Inicio:</small> {{ auth()->user()->subscription_starts_at->format('d/m/Y') }}<br>
                                            <small class="text-muted">Fin:</small> {{ auth()->user()->subscription_ends_at->format('d/m/Y') }}
                                        </div>
                                    </div>
                                @endif

                                <div class="info-group mb-3">
                                    <label class="info-label">Estado de acceso</label>
                                    <div class="info-value">
                                        @if(auth()->user()->canAccessPlatform())
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Acceso completo
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="bi bi-exclamation-triangle me-1"></i>
                                                Acceso limitado
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Estado del Perfil -->
                    <div class="bg-light rounded p-3">
                        <h6 class="text-secondary fw-bold mb-3">
                            <i class="bi bi-speedometer2 me-2"></i>
                            Estado del Perfil
                        </h6>
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="me-3">Completitud del perfil:</span>
                                    <div class="progress flex-grow-1 me-3" style="height: 8px;">
                                        <div class="progress-bar bg-{{ $completionColor }}" 
                                             role="progressbar" 
                                             style="width: {{ $profileCompletion }}%">
                                        </div>
                                    </div>
                                    <strong class="text-{{ $completionColor }}">{{ $profileCompletion }}%</strong>
                                </div>
                                @php
                                    $completionDetails = auth()->user()->getProfileCompletionDetails();
                                @endphp
                                @if(count($completionDetails) > 0)
                                    <div class="mt-2">
                                        @foreach($completionDetails as $detail)
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="bi {{ $detail['icon'] }} text-{{ $detail['type'] === 'critical' ? 'danger' : ($detail['type'] === 'warning' ? 'warning' : 'info') }} me-2"></i>
                                                <small class="text-muted me-2">{{ $detail['message'] }}</small>
                                                <small class="text-primary">→ {{ $detail['action'] }}</small>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4 text-end">
                                @if(auth()->user()->canPublishWebsite())
                                    <div class="text-success">
                                        <i class="bi bi-check-circle-fill fs-3"></i>
                                        <div class="small fw-bold">¡Listo para publicar!</div>
                                    </div>
                                @else
                                    <div class="text-warning">
                                        <i class="bi bi-exclamation-triangle-fill fs-3"></i>
                                        <div class="small fw-bold">Completa tu perfil</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Status -->
        <div class="col-lg-4 mb-4">
            <!-- Quick Plan Status -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-speedometer2 me-2"></i>
                        Resumen Rápido
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        @if($isExpired)
                            <div class="text-danger mb-3">
                                <i class="bi bi-exclamation-triangle fs-1 text-danger"></i>
                                <h6 class="mt-2 fw-bold">Licencia Vencida</h6>
                                <small class="text-muted">Renueva para acceder</small>
                            </div>
                        @else
                            <div class="text-success mb-3">
                                <i class="bi bi-check-circle fs-1 text-success"></i>
                                <h6 class="mt-2 fw-bold">{{ intval($daysLeft) }} días restantes</h6>
                                <small class="text-muted">Todo funcionando</small>
                            </div>
                        @endif
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.plans.index') }}" class="btn {{ $isExpired ? 'btn-danger' : 'btn-primary' }} btn-sm">
                                @if($isExpired)
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    Renovar Ahora
                                @else
                                    <i class="bi bi-credit-card me-1"></i>
                                    Gestionar Plan
                                @endif
                            </a>
                            @if($isExpired)
                                <small class="text-danger text-center mt-1">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Funciones limitadas
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-lightning me-2"></i>
                        Acciones Rápidas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-person-gear"></i>
                            Configurar Perfil
                        </a>
                        <a href="https://wa.me/{{ config('app.support.mobile') }}?text=Hola%20vengo%20de%20la%20empresa%20{{ urlencode(auth()->user()->empresa_nombre ?? auth()->user()->name ?? 'Mi empresa') }}%20tengo%20una%20duda%20sobre%20el%20administrador" target="_blank" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-headset"></i>
                            Soporte Técnico
                        </a>
                        <a href="{{ route('documentation.index') }}" class="btn btn-outline-info btn-sm">
                            <i class="bi bi-file-text"></i>
                            Documentación
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- Sidebar Actions -->
    <div class="col-lg-4">
        <!-- Trial Progress Card -->
        @if(auth()->user()->id_plan == 6)
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-hourglass-split me-2"></i>
                        Progreso de Prueba
                    </h6>
                </div>
                <div class="card-body">
                    @php
                        $totalTrialDays = 15;
                        $daysUsed = $totalTrialDays - intval($trialDaysLeft ?? 0);
                        $progressPercentage = ($daysUsed / $totalTrialDays) * 100;
                    @endphp
                    
                    <div class="text-center mb-3">
                        <h4 class="text-primary-gold mb-1">{{ intval($trialDaysLeft ?? 0) }}</h4>
                        <small class="text-muted">días restantes de {{ $totalTrialDays }}</small>
                    </div>
                    
                    <div class="progress mb-3" style="height: 10px;">
                        <div class="progress-bar" 
                            role="progressbar" 
                            style="width: {{ $progressPercentage }}%; background: linear-gradient(90deg, var(--primary-gold), var(--primary-red));" 
                            aria-valuenow="{{ $progressPercentage }}" 
                            aria-valuemin="0" 
                            aria-valuemax="100">
                        </div>
                    </div>
                    
                    <p class="text-muted small text-center mb-0">
                        Aprovecha al máximo tu período de prueba
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Features Footer -->
<div class="row g-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body py-4">
                <div class="row text-center">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <i class="bi bi-shield-check text-success" style="font-size: 2.5rem;"></i>
                        <h6 class="text-dark mt-2 mb-1">Cuenta Segura</h6>
                        <small class="text-muted">Protección SSL activa</small>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <i class="bi bi-headset text-primary-gold" style="font-size: 2.5rem;"></i>
                        <h6 class="text-dark mt-2 mb-1">Soporte 24/7</h6>
                        <small class="text-muted">Estamos aquí para ayudarte</small>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <i class="bi bi-cloud-check text-info" style="font-size: 2.5rem;"></i>
                        <h6 class="text-dark mt-2 mb-1">Backup Automático</h6>
                        <small class="text-muted">Tus datos están seguros</small>
                    </div>
                    <div class="col-md-3">
                        <i class="bi bi-speedometer text-primary-red" style="font-size: 2.5rem;"></i>
                        <h6 class="text-dark mt-2 mb-1">Alto Rendimiento</h6>
                        <small class="text-muted">Páginas ultra rápidas</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Email Verification Functions for Dashboard
async function sendVerificationEmail() {
    const button = event.target;
    const originalText = button.innerHTML;
    
    // Mostrar loading
    button.disabled = true;
    button.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Enviando...';
    
    try {
        const response = await fetch('/email/send-verification', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            showNotification(data.message, 'success');
            // Cambiar el botón a estado de éxito
            button.innerHTML = '<i class="bi bi-check-circle me-2"></i> Email Enviado - Revisa tu bandeja';
            button.classList.remove('btn-danger');
            button.classList.add('btn-success');
            
            // Mostrar mensaje adicional en la alerta
            const alertContainer = document.getElementById('emailVerificationAlert');
            if (alertContainer) {
                // Agregar mensaje de email enviado
                const emailSentMessage = document.createElement('div');
                emailSentMessage.className = 'alert alert-info mt-3 border-0';
                emailSentMessage.style.background = 'linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%)';
                emailSentMessage.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="bi bi-envelope-check text-info fs-4 me-3"></i>
                        <div>
                            <strong>Email de verificación enviado</strong><br>
                            <small>Revisa tu bandeja de entrada y haz clic en el enlace de verificación</small>
                        </div>
                    </div>
                `;
                alertContainer.appendChild(emailSentMessage);
                
                // Remover el mensaje después de 10 segundos
                setTimeout(() => {
                    if (emailSentMessage.parentNode) {
                        emailSentMessage.remove();
                    }
                }, 10000);
            }
            
            // Volver al estado original después de 10 segundos
            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('btn-success');
                button.classList.add('btn-danger');
                button.disabled = false;
            }, 10000);
        } else {
            showNotification(data.message, 'error');
            button.disabled = false;
            button.innerHTML = originalText;
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Error al enviar el email. Por favor intenta nuevamente.', 'error');
        button.disabled = false;
        button.innerHTML = originalText;
    }
}

// Verificar estado de verificación periódicamente
function checkVerificationStatus() {
    fetch('/email/verification-status')
        .then(response => response.json())
        .then(data => {
            
            if (data.verified) {
                // Email verificado - AHORA SÍ se puede ocultar la alerta
                const alert = document.getElementById('emailVerificationAlert');
                if (alert) {
                    // Marcar como verificado para permitir ocultación
                    alert.classList.add('verified');
                    
                    // Animación de éxito antes de remover
                    alert.style.background = 'linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%)';
                    alert.style.borderColor = '#28a745';
                    alert.innerHTML = `
                        <div class="text-center py-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                            <h4 class="text-success mt-3 mb-2">¡Email Verificado Exitosamente!</h4>
                            <p class="text-success mb-3">Tu cuenta está ahora completamente verificada. Ya puedes publicar tu sitio web.</p>
                            <div class="progress mb-3">
                                <div class="progress-bar bg-success progress-bar-animated" style="width: 100%"></div>
                            </div>
                        </div>
                    `;
                    
                    // Mostrar por 3 segundos y luego remover
                    setTimeout(() => {
                        alert.style.transition = 'all 1s ease-out';
                        alert.style.transform = 'translateY(-20px)';
                        alert.style.opacity = '0';
                        
                        setTimeout(() => {
                            alert.remove();
                            showNotification('¡Email verificado correctamente! Ya puedes publicar tu sitio web.', 'success');
                            // Recargar la página para actualizar todos los estados
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        }, 1000);
                    }, 3000);
                }
            }
        })
        .catch(error => console.error('Error checking verification status:', error));
}

// Verificar cada 30 segundos si el usuario está en la página
if (document.getElementById('emailVerificationAlert')) {
    setInterval(checkVerificationStatus, 30000);
}

// PROTEGER LA ALERTA DE VERIFICACIÓN - NO PERMITIR QUE SE OCULTE
document.addEventListener('DOMContentLoaded', function() {
    const emailAlert = document.getElementById('emailVerificationAlert');
    if (emailAlert) {
        // Prevenir que Bootstrap oculte la alerta
        emailAlert.addEventListener('close.bs.alert', function(e) {
            e.preventDefault();
            e.stopPropagation();
            return false;
        });
        
        // Prevenir clicks que puedan cerrar la alerta
        emailAlert.addEventListener('closed.bs.alert', function(e) {
            e.preventDefault();
            e.stopPropagation();
            return false;
        });
        
        // Observador para asegurar que la alerta siempre esté visible
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                    const target = mutation.target;
                    if (target.id === 'emailVerificationAlert') {
                        // Si alguien trata de ocultar la alerta, la mostramos de nuevo
                        if (target.style.display === 'none' || target.style.visibility === 'hidden') {
                            target.style.display = 'block';
                            target.style.visibility = 'visible';
                            target.style.opacity = '1';
                        }
                    }
                }
            });
        });
        
        observer.observe(emailAlert, {
            attributes: true,
            attributeFilter: ['style', 'class']
        });
        
        // Forzar visibilidad cada 5 segundos
        setInterval(function() {
            if (emailAlert && !emailAlert.classList.contains('verified')) {
                emailAlert.style.display = 'block';
                emailAlert.style.visibility = 'visible';
                emailAlert.style.opacity = '1';
            }
        }, 5000);
        
        
    }
});

function showNotification(message, type = 'info') {
    // Crear contenedor de notificaciones si no existe
    let container = document.getElementById('notification-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'notification-container';
        container.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
        `;
        document.body.appendChild(container);
    }
    
    // Crear notificación
    const notification = document.createElement('div');
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'error' ? 'alert-danger' : 
                      type === 'warning' ? 'alert-warning' : 'alert-info';
    
    const icon = type === 'success' ? 'bi-check-circle' : 
                 type === 'error' ? 'bi-exclamation-triangle' : 
                 type === 'warning' ? 'bi-exclamation-triangle' : 'bi-info-circle';
    
    notification.className = `alert ${alertClass} alert-dismissible fade show shadow-lg`;
    notification.style.cssText = 'margin-bottom: 10px; animation: slideInRight 0.3s ease-out;';
    notification.innerHTML = `
        <i class="bi ${icon} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    container.appendChild(notification);
    
    // Auto-remove después de 5 segundos
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Agregar estilos para la animación
if (!document.getElementById('notification-styles')) {
    const styles = document.createElement('style');
    styles.id = 'notification-styles';
    styles.textContent = `
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    `;
    document.head.appendChild(styles);
}
</script>
@endsection