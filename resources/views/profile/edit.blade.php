@extends('layouts.dashboard')

@section('title', 'Perfil - BBB Páginas Web')
@section('description', 'Configuración de perfil y empresa')

@push('styles')
<link href="{{ asset('css/profile-enhancements.css') }}" rel="stylesheet">
<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
<style>
    /* Mobile Payment Cards */
    .payment-card-mobile {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 1rem;
        transition: box-shadow 0.2s;
    }
    
    .payment-card-mobile:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    @media (max-width: 575px) {
        .payment-card-mobile {
            padding: 0.75rem;
        }
        
        .payment-card-mobile .badge {
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }
        
        .payment-card-mobile .btn-sm {
            font-size: 0.75rem;
            padding: 0.4rem 0.6rem;
            min-height: 44px;
        }
    }
</style>
@endpush

@section('content')
@php
    $planPermiteProductos = Auth::user()->  plan->aplicaProductos ?? false;    
@endphp

<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-person-gear me-3"></i>Mi Perfil
    </h1>
    <p class="page-subtitle">Gestiona tu información personal, seguridad y configuración de la cuenta.</p>
</div>

<!-- Email Verification Alert - PERMANENTLY VISIBLE UNTIL VERIFIED -->
@if (!auth()->user()->emailValidado)
<div class="email-verification-alert-permanent shadow-sm" id="emailVerificationAlert" 
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

<!-- Unified Profile View -->
<div class="row">
    <!-- Left Column - Profile Information -->
    <div class="col-lg-8">
        <!-- User Avatar & Quick Info -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="user-avatar d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; font-size: 2.5rem; background: linear-gradient(135deg, #FFD700, #FFA500); color: white; border-radius: 50%; font-weight: bold;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                    <div class="col">
                        <h4 class="text-dark mb-1">{{ $user->name }}</h4>
                        <p class="text-muted mb-1">{{ $user->email }}</p>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-success me-2">
                                <i class="bi bi-check-circle me-1"></i>Activo
                            </span>
                            @if($user->isOnTrial())
                                <span class="badge bg-info">
                                    <i class="bi bi-gift me-1"></i>Prueba Gratuita
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="text-end">
                            <small class="text-muted">Miembro desde</small>
                            <div class="fw-bold text-dark">{{ $user->created_at->format('M Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Complete Profile Form -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pb-0">
                <h5 class="text-dark fw-bold mb-0">
                    <i class="bi bi-person-lines-fill me-2 text-primary-gold"></i>
                    Información Completa del Perfil
                </h5>
                <p class="text-muted small mt-1 mb-0">Actualiza tu información personal y configuración de cuenta</p>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <!-- Personal Information Section -->
                    <div class="profile-section mb-5">
                        <div class="section-header mb-4">
                            <h6 class="text-primary-gold fw-bold mb-1">
                                <i class="bi bi-person-circle me-2"></i>Datos Personales
                            </h6>
                            <div class="border-bottom border-warning" style="width: 50px; height: 2px;"></div>
                        </div>

                        <div class="row g-4">
                            <!-- Nombre -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control border-0 bg-light @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $user->name) }}" 
                                           required 
                                           placeholder="Nombre completo">
                                    <label for="name">
                                        <i class="bi bi-person me-2"></i>Nombre Completo
                                    </label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email Personal -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" 
                                           class="form-control border-0 bg-light @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $user->email) }}" 
                                           required 
                                           placeholder="correo@personal.com">
                                    <label for="email">
                                        <i class="bi bi-envelope me-2"></i>Email Personal
                                    </label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Teléfono Móvil -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" 
                                           class="form-control border-0 bg-light @error('movil') is-invalid @enderror" 
                                           id="movil" 
                                           name="movil" 
                                           value="{{ old('movil', $user->movil) }}" 
                                           placeholder="+57 300 123 4567">
                                    <label for="movil">
                                        <i class="bi bi-telephone me-2"></i>Teléfono Móvil
                                    </label>
                                    @error('movil')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Fecha de Registro -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" 
                                           class="form-control border-0 bg-light" 
                                           value="{{ $user->created_at->format('d/m/Y H:i') }}" 
                                           readonly 
                                           placeholder="Fecha de registro">
                                    <label>
                                        <i class="bi bi-calendar me-2"></i>Fecha de Registro
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información sobre dónde encontrar datos empresariales -->
                    <div class="alert alert-info border-0 mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-info-circle me-3 fs-4"></i>
                            <div>
                                <h6 class="mb-1">¿Buscas configurar tu información empresarial?</h6>
                                <p class="mb-2 small">La información de tu empresa, redes sociales y documentos legales ahora se configuran directamente en tu landing page.</p>
                                <a href="{{ route('admin.landing.configurar') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-building me-1"></i>
                                    Ir a Configurar Landing Page
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary-gold px-5 py-3 fw-bold">
                            <i class="bi bi-check-lg me-2"></i>
                            Actualizar Información Personal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Configuración de Flete -->
        @if($planPermiteProductos)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header border-0 bg-light">
                <h5 class="mb-0 text-dark fw-bold">
                    <i class="bi bi-truck me-2 text-primary-gold"></i>
                    Configuración de Envío
                </h5>
                <p class="text-muted mb-0 small">Configura el valor del flete que aplicará a todos los productos</p>
            </div>
            <div class="card-body p-4">
                <div class="alert alert-info border-0 mb-4">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-info-circle me-3 fs-5"></i>
                        <div>
                            <strong>Valor Global:</strong> Este valor de flete se aplicará automáticamente a todos los productos y ciudades en tu tienda online.
                        </div>
                    </div>
                </div>

                <form id="fleteForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="flete" class="form-label fw-bold">
                                <i class="bi bi-currency-dollar me-1"></i>
                                Valor del Flete (COP)
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">$</span>
                                <input type="number" 
                                       class="form-control" 
                                       id="flete" 
                                       name="flete" 
                                       value="{{ auth()->user()->empresa->flete ?? 0 }}"
                                       min="0" 
                                       step="100"
                                       placeholder="0">
                                <span class="input-group-text bg-light">COP</span>
                            </div>
                            <div class="form-text">
                                <i class="bi bi-lightbulb me-1"></i>
                                Ingresa 0 si ofreces envío gratuito
                            </div>
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="w-100">
                                <div class="bg-light rounded p-3 text-center">
                                    <i class="bi bi-check-circle text-success fs-4 mb-2"></i>
                                    <div class="small text-muted">
                                        <strong>Guardado automático</strong><br>
                                        Los cambios se guardan al modificar el valor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="mt-4 p-3 bg-light rounded">
                    <h6 class="mb-2">
                        <i class="bi bi-eye me-1"></i>
                        Vista previa en checkout:
                    </h6>
                    <div class="d-flex justify-content-between align-items-center small">
                        <span>Envío:</span>
                        <span class="fw-bold" id="preview-flete">
                            @if(auth()->user()->empresa && auth()->user()->empresa->flete > 0)
                                ${{ number_format(auth()->user()->empresa->flete, 0, ',', '.') }}
                            @else
                                Gratis
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Right Column - Plan & Security -->
    <div class="col-lg-4">
        <!-- Profile Completion Widget -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header border-0 bg-white">
                <h6 class="mb-0 text-dark fw-bold">
                    <i class="bi bi-person-check me-2 text-primary-gold"></i>
                    Completitud del Perfil
                </h6>
            </div>
            <div class="card-body p-4">
                @php
                    $completion = $user->getProfileCompletion();
                @endphp
                
                <div class="text-center mb-3">
                    <div class="position-relative d-inline-block">
                        <svg width="80" height="80" class="progress-ring">
                            <circle stroke="#e9ecef" stroke-width="6" fill="transparent" r="35" cx="40" cy="40"/>
                            <circle stroke="{{ $completion >= 80 ? '#28a745' : ($completion >= 50 ? '#ffc107' : '#dc3545') }}" 
                                    stroke-width="6" 
                                    fill="transparent" 
                                    r="35" 
                                    cx="40" 
                                    cy="40"
                                    stroke-dasharray="220"
                                    stroke-dashoffset="{{ 220 - ($completion * 220 / 100) }}"
                                    stroke-linecap="round"
                                    transform="rotate(-90 40 40)"/>
                        </svg>
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <span class="fw-bold h5 text-dark">{{ $completion }}%</span>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mb-3">
                    @if($completion >= 80 && auth()->user()->isEmailVerified())
                        <span class="badge bg-success px-3 py-2">
                            <i class="bi bi-check-circle me-1"></i>Perfil Completo
                        </span>
                    @elseif($completion >= 50)
                        <span class="badge bg-warning px-3 py-2">
                            <i class="bi bi-exclamation-circle me-1"></i>Casi Completo
                        </span>
                    @else
                        <span class="badge bg-danger px-3 py-2">
                            <i class="bi bi-x-circle me-1"></i>Necesita Atención
                        </span>
                    @endif
                </div>
                
                <!-- Critical Email Verification Notice -->
                @if (!auth()->user()->isEmailVerified())
                <div class="alert alert-danger p-2 mb-3 small border-0">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-shield-exclamation text-danger me-2"></i>
                        <div class="flex-grow-1">
                            <strong>Email sin verificar</strong><br>
                            <span class="text-muted small">Requerido para publicación web</span>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="small text-muted text-center">
                    @if(!auth()->user()->isEmailVerified())
                        <span class="text-danger fw-bold">¡Verifica tu email para poder publicar!</span>
                    @elseif($completion < 100)
                        Completa tu perfil para obtener mejores resultados
                    @else
                        ¡Excelente! Tu perfil está completo y verificado
                    @endif
                </div>
                
                <!-- Completion Details -->
                @php $details = auth()->user()->getProfileCompletionDetails(); @endphp
                @if(count($details) > 0)
                <div class="mt-3">
                    <div class="small fw-bold text-muted mb-2">Pendientes:</div>
                    @foreach($details as $detail)
                    <div class="d-flex align-items-center mb-1 small">
                        <i class="bi {{ $detail['icon'] }} me-2 text-{{ $detail['type'] === 'critical' ? 'danger' : ($detail['type'] === 'warning' ? 'warning' : 'info') }}"></i>
                        <span class="text-muted">{{ $detail['message'] }}</span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <!-- Current Plan Section -->
        @if($user->plan)
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header border-0 bg-gradient" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 text-dark fw-bold">
                            <i class="bi bi-star-fill text-warning me-2"></i>
                            Plan Actual
                        </h6>
                        @if($user->isOnTrial())
                            <span class="badge bg-info text-white px-3 py-2">
                                <i class="bi bi-gift me-1"></i>Prueba
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="plan-icon mx-auto mb-3">
                            <div class="rounded-circle bg-primary-gold d-flex align-items-center justify-content-center mx-auto" style="width: 60px; height: 60px;">
                                <i class="bi bi-award text-white fs-3"></i>
                            </div>
                        </div>
                        <h5 class="text-primary-gold mb-2 fw-bold">{{ $user->plan->nombre }}</h5>
                        <div class="text-muted mb-3 small" style="line-height: 1.6;">{!! $user->plan->descripcion ?? 'Plan seleccionado para impulsar tu negocio' !!}</div>
                        <div class="price-section mb-4">
                            <span class="h4 text-dark fw-bold">${{ number_format($user->plan->precioPesos, 0, ',', '.') }}</span>
                            <div class="text-muted small">COP / mes</div>
                        </div>
                    </div>

                    <!-- Plan Benefits -->
                    <div class="plan-benefits mb-4">
                        <div class="d-flex align-items-center text-success mb-2">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <small>Página web profesional</small>
                        </div>
                        <div class="d-flex align-items-center text-success mb-2">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <small>Soporte técnico incluido</small>
                        </div>
                        <div class="d-flex align-items-center text-success mb-2">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <small>Actualizaciones automáticas</small>
                        </div>
                    </div>

                    <!-- Upgrade CTA -->
                    <div class="upgrade-cta p-3 rounded mb-3" style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); border: 1px solid #ffd700;">
                        <div class="text-center">
                            <i class="bi bi-rocket-takeoff text-warning fs-4 mb-2 d-block"></i>
                            <h6 class="text-dark mb-2 fw-bold">¡Potencia tu negocio!</h6>
                            <p class="small text-muted mb-3">
                                Desbloquea más funcionalidades premium
                            </p>
                            <button type="button" class="btn btn-warning fw-bold w-100" onclick="showUpgradeModal()">
                                <i class="bi bi-arrow-up-circle me-2"></i>
                                Mejorar Plan
                            </button>
                        </div>
                    </div>

                    <!-- Plan Management -->
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-primary-gold btn-sm" onclick="showComingSoonAlert()">>
                            <i class="bi bi-gear me-2"></i>
                            Gestionar Plan
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Security Quick Access -->
        <div class="card border-0 shadow-sm">
            <div class="card-header border-0 bg-white">
                <h6 class="mb-0 text-dark fw-bold">
                    <i class="bi bi-shield-lock me-2 text-success"></i>
                    Seguridad de la Cuenta
                </h6>
            </div>
            <div class="card-body p-4">
                <!-- Email Verification Status -->
                <div class="d-flex align-items-center mb-3">
                    @if(auth()->user()->isEmailVerified())
                        <i class="bi bi-check-circle-fill text-success me-3"></i>
                        <div>
                            <div class="fw-bold small text-success">Email verificado</div>
                            <div class="text-muted small">Tu email está confirmado</div>
                        </div>
                    @else
                        <i class="bi bi-exclamation-triangle-fill text-danger me-3"></i>
                        <div>
                            <div class="fw-bold small text-danger">Email sin verificar</div>
                            <div class="text-muted small">Verificación pendiente</div>
                        </div>
                    @endif
                </div>
                
                <!-- SSL Status -->
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-shield-fill-check text-success me-3"></i>
                    <div>
                        <div class="fw-bold small">Conexión segura</div>
                        <div class="text-muted small">SSL activo</div>
                    </div>
                </div>
                
                <!-- Account Status Summary -->
                <div class="d-flex align-items-center mb-3">
                    @if(auth()->user()->isEmailVerified())
                        <i class="bi bi-shield-check text-success me-3"></i>
                        <div>
                            <div class="fw-bold small text-success">Cuenta protegida</div>
                            <div class="text-muted small">Todas las verificaciones completas</div>
                        </div>
                    @else
                        <i class="bi bi-shield-exclamation text-warning me-3"></i>
                        <div>
                            <div class="fw-bold small text-warning">Seguridad parcial</div>
                            <div class="text-muted small">Verificación de email pendiente</div>
                        </div>
                    @endif
                </div>
                
                @if(!auth()->user()->isEmailVerified())
                <div class="alert alert-warning p-2 mb-3 small border-0">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Verifica tu email</strong> para activar todas las funciones de seguridad.
                </div>
                @endif
                
                <hr class="my-3">
                
                <div class="d-grid gap-2">
                    @if(!auth()->user()->isEmailVerified())
                    <button type="button" class="btn btn-warning btn-sm" onclick="sendVerificationEmail()">
                        <i class="bi bi-envelope-check me-2"></i>
                        Verificar Email
                    </button>
                    @endif
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#passwordModal">
                        <i class="bi bi-key me-2"></i>
                        Cambiar Contraseña
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment History Section -->
<div class="row mt-5">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                    <h5 class="mb-0 text-dark fw-bold">
                        <i class="bi bi-receipt me-2 text-primary"></i>
                        <span class="d-none d-md-inline">Histórico de </span>Pagos
                    </h5>
                    <div>
                        @php
                            $totalPagos = auth()->user()->renovaciones()->count();
                            $pagosCompletados = auth()->user()->renovaciones()->completed()->count();
                        @endphp
                        <span class="badge bg-primary fs-6 px-3 py-2">
                            {{ $totalPagos }} {{ Str::plural('pago', $totalPagos) }}
                        </span>
                        @if($pagosCompletados > 0)
                            <span class="badge bg-success fs-6 px-3 py-2 ms-2">
                                {{ $pagosCompletados }} completado{{ $pagosCompletados > 1 ? 's' : '' }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                @php
                    $renovaciones = auth()->user()->renovaciones()->with(['plan'])->orderBy('created_at', 'desc')->get();
                @endphp
                
                @if($renovaciones->count() > 0)
                    <!-- Vista Desktop -->
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3 border-0">
                                        <i class="bi bi-calendar me-1"></i>Fecha
                                    </th>
                                    <th class="px-4 py-3 border-0">
                                        <i class="bi bi-tag me-1"></i>Plan
                                    </th>
                                    <th class="px-4 py-3 border-0">
                                        <i class="bi bi-currency-dollar me-1"></i>Monto
                                    </th>
                                    <th class="px-4 py-3 border-0">
                                        <i class="bi bi-info-circle me-1"></i>Estado
                                    </th>
                                    <th class="px-4 py-3 border-0">
                                        <i class="bi bi-gear me-1"></i>Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($renovaciones as $renovacion)
                                <tr class="border-bottom">
                                    <td class="px-4 py-3 align-middle">
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold text-dark">
                                                {{ $renovacion->created_at->format('d/m/Y') }}
                                            </span>
                                            <small class="text-muted">
                                                {{ $renovacion->created_at->format('H:i') }}
                                            </small>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 align-middle">
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold text-dark">
                                                {{ $renovacion->plan->nombre ?? 'Plan no encontrado' }}
                                            </span>
                                            @if($renovacion->plan && $renovacion->plan->dias > 0)
                                                <small class="text-muted">
                                                    {{ $renovacion->plan->dias }} días
                                                </small>
                                            @elseif($renovacion->plan)
                                                <small class="text-muted">De por vida</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 align-middle">
                                        <span class="fw-bold text-primary fs-6">
                                            ${{ number_format($renovacion->amount, 0, ',', '.') }}
                                        </span>
                                        <small class="text-muted d-block">
                                            {{ $renovacion->currency ?? 'COP' }}
                                        </small>
                                    </td>
                                    <td class="px-4 py-3 align-middle">
                                        @php
                                            $statusConfig = [
                                                'completed' => ['class' => 'bg-success', 'icon' => 'check-circle', 'text' => 'Completado'],
                                                'pending' => ['class' => 'bg-warning', 'icon' => 'hourglass-split', 'text' => 'Pendiente'],
                                                'failed' => ['class' => 'bg-danger', 'icon' => 'x-circle', 'text' => 'Fallido'],
                                                'cancelled' => ['class' => 'bg-secondary', 'icon' => 'dash-circle', 'text' => 'Cancelado'],
                                                'refunded' => ['class' => 'bg-info', 'icon' => 'arrow-counterclockwise', 'text' => 'Reembolsado']
                                            ];
                                            $config = $statusConfig[$renovacion->status] ?? ['class' => 'bg-secondary', 'icon' => 'question-circle', 'text' => ucfirst($renovacion->status)];
                                        @endphp
                                        <span class="badge {{ $config['class'] }} px-3 py-2">
                                            <i class="bi bi-{{ $config['icon'] }} me-1"></i>
                                            {{ $config['text'] }}
                                        </span>
                                        @if($renovacion->transaction_id)
                                            <small class="text-muted d-block mt-1">
                                                ID: {{ $renovacion->transaction_id }}
                                            </small>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 align-middle">
                                        <div class="btn-group" role="group">
                                            <button type="button" 
                                                    class="btn btn-outline-primary btn-sm" 
                                                    onclick="downloadInvoice('{{ $renovacion->id }}')"
                                                    title="Descargar recibo">
                                                <i class="bi bi-download"></i>
                                            </button>
                                            @if($renovacion->notes)
                                                <button type="button" 
                                                        class="btn btn-outline-info btn-sm" 
                                                        onclick="showPaymentDetails('{{ $renovacion->id }}', '{{ addslashes($renovacion->notes) }}', '{{ $renovacion->gateway ?? 'N/A' }}', '{{ $renovacion->payment_method ?? 'N/A' }}')"
                                                        title="Ver detalles">
                                                    <i class="bi bi-info-circle"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Vista Mobile -->
                    <div class="d-md-none px-3 py-2">
                        @foreach($renovaciones as $renovacion)
                            <div class="payment-card-mobile mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <div class="fw-semibold">{{ $renovacion->created_at->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $renovacion->created_at->format('H:i') }}</small>
                                    </div>
                                    @php
                                        $statusConfig = [
                                            'completed' => ['class' => 'bg-success', 'icon' => 'check-circle', 'text' => 'Completado'],
                                            'pending' => ['class' => 'bg-warning', 'icon' => 'hourglass-split', 'text' => 'Pendiente'],
                                            'failed' => ['class' => 'bg-danger', 'icon' => 'x-circle', 'text' => 'Fallido'],
                                            'cancelled' => ['class' => 'bg-secondary', 'icon' => 'dash-circle', 'text' => 'Cancelado'],
                                            'refunded' => ['class' => 'bg-info', 'icon' => 'arrow-counterclockwise', 'text' => 'Reembolsado']
                                        ];
                                        $config = $statusConfig[$renovacion->status] ?? ['class' => 'bg-secondary', 'icon' => 'question-circle', 'text' => ucfirst($renovacion->status)];
                                    @endphp
                                    <span class="badge {{ $config['class'] }} px-2 py-1">
                                        <i class="bi bi-{{ $config['icon'] }} me-1"></i>
                                        {{ $config['text'] }}
                                    </span>
                                </div>
                                <div class="row g-2 mb-2">
                                    <div class="col-6">
                                        <small class="text-muted d-block">Plan</small>
                                        <div class="fw-semibold">{{ $renovacion->plan->nombre ?? 'N/A' }}</div>
                                        @if($renovacion->plan && $renovacion->plan->dias > 0)
                                            <small class="text-muted">{{ $renovacion->plan->dias }} días</small>
                                        @elseif($renovacion->plan)
                                            <small class="text-muted">De por vida</small>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Monto</small>
                                        <div class="fw-bold text-primary">${{ number_format($renovacion->amount, 0, ',', '.') }}</div>
                                        <small class="text-muted">{{ $renovacion->currency ?? 'COP' }}</small>
                                    </div>
                                </div>
                                @if($renovacion->transaction_id)
                                    <div class="mb-2">
                                        <small class="text-muted">ID: {{ $renovacion->transaction_id }}</small>
                                    </div>
                                @endif
                                <div class="d-flex gap-2">
                                    <button type="button" 
                                            class="btn btn-outline-primary btn-sm flex-fill" 
                                            onclick="downloadInvoice('{{ $renovacion->id }}')">
                                        <i class="bi bi-download me-1"></i> Recibo
                                    </button>
                                    @if($renovacion->notes)
                                        <button type="button" 
                                                class="btn btn-outline-info btn-sm flex-fill" 
                                                onclick="showPaymentDetails('{{ $renovacion->id }}', '{{ addslashes($renovacion->notes) }}', '{{ $renovacion->gateway ?? 'N/A' }}', '{{ $renovacion->payment_method ?? 'N/A' }}')">
                                            <i class="bi bi-info-circle me-1"></i> Detalles
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Payment Summary Footer -->
                    <div class="px-4 py-3 bg-light border-top">
                        <div class="row text-center g-3">
                            <div class="col-6 col-md-3">
                                <div class="stat-item">
                                    <div class="stat-value text-primary fw-bold">{{ $totalPagos }}</div>
                                    <div class="stat-label text-muted small">Total de Pagos</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="stat-item">
                                    <div class="stat-value text-success fw-bold">{{ $pagosCompletados }}</div>
                                    <div class="stat-label text-muted small">Completados</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                @php
                                    $totalGastado = auth()->user()->renovaciones()->completed()->sum('amount');
                                @endphp
                                <div class="stat-item">
                                    <div class="stat-value text-info fw-bold">${{ number_format($totalGastado, 0, ',', '.') }}</div>
                                    <div class="stat-label text-muted small">Total Gastado</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                @php
                                    $ultimoPago = auth()->user()->renovaciones()->completed()->latest()->first();
                                @endphp
                                <div class="stat-item">
                                    @if($ultimoPago)
                                        <div class="stat-value text-warning fw-bold">{{ $ultimoPago->created_at->diffForHumans() }}</div>
                                        <div class="stat-label text-muted small">Último Pago</div>
                                    @else
                                        <div class="stat-value text-muted fw-bold">--</div>
                                        <div class="stat-label text-muted small">Sin pagos</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-receipt text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                        </div>
                        <h5 class="text-muted mb-3">No hay pagos registrados</h5>
                        <p class="text-muted mb-4">
                            Cuando realices tu primer pago, aparecerá aquí tu histórico completo.
                        </p>
                        <a href="{{ route('admin.plans.index') }}" class="btn btn-primary">
                            <i class="bi bi-credit-card me-2"></i>
                            Ver Planes Disponibles
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Payment Details Modal -->
<div class="modal fade" id="paymentDetailsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-info-circle me-2"></i>
                    Detalles del Pago
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <strong>Gateway de pago:</strong>
                    </div>
                    <div class="col-6" id="paymentGateway">
                        -
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <strong>Método de pago:</strong>
                    </div>
                    <div class="col-6" id="paymentMethod">
                        -
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <strong>Notas:</strong>
                        <div class="mt-2 p-3 bg-light rounded" id="paymentNotes">
                            -
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Password Change Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-shield-lock text-primary me-2"></i>
                    Cambiar Contraseña
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.profile.password.update') }}" id="passwordForm">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="password" 
                                   class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" 
                                   name="current_password" 
                                   required 
                                   placeholder="Contraseña actual">
                            <label for="current_password">
                                <i class="bi bi-lock me-2"></i>Contraseña Actual
                            </label>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   placeholder="Nueva contraseña">
                            <label for="password">
                                <i class="bi bi-key me-2"></i>Nueva Contraseña
                            </label>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required 
                                   placeholder="Confirmar nueva contraseña">
                            <label for="password_confirmation">
                                <i class="bi bi-key-fill me-2"></i>Confirmar Nueva Contraseña
                            </label>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Requerimientos:</strong>
                        <ul class="mb-0 mt-2 small">
                            <li>Mínimo 8 caracteres</li>
                            <li>Se recomienda incluir mayúsculas, minúsculas y números</li>
                        </ul>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="passwordForm" class="btn btn-primary-gold">
                    <i class="bi bi-check-lg me-2"></i>
                    Actualizar Contraseña
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>
                    Eliminar Cuenta
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que quieres eliminar tu cuenta?</p>
                <p class="text-danger small mb-3">
                    <strong>Esta acción no se puede deshacer.</strong> 
                    Todos tus datos, configuraciones y contenido serán eliminados permanentemente.
                </p>
                
                <form method="POST" action="{{ route('admin.profile.destroy') }}" id="deleteAccountForm">
                    @csrf
                    @method('DELETE')
                    
                    <div class="form-floating">
                        <input type="password" 
                               class="form-control" 
                               id="password_delete" 
                               name="password" 
                               required 
                               placeholder="Confirma tu contraseña">
                        <label for="password_delete">
                            <i class="bi bi-lock me-2"></i>Confirma tu contraseña
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="deleteAccountForm" class="btn btn-danger">
                    <i class="bi bi-trash me-2"></i>
                    Eliminar Cuenta Permanentemente
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Upgrade Plan Modal -->
<div class="modal fade" id="upgradeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0 bg-gradient" style="background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);">
                <h5 class="modal-title text-white fw-bold">
                    <i class="bi bi-rocket-takeoff me-2"></i>
                    Upgrade Your Business Plan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <h4 class="text-dark mb-2">¡Potencia tu negocio al máximo!</h4>
                    <p class="text-muted">Descubre todas las funcionalidades premium que te ayudarán a crecer</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="upgrade-feature p-3 rounded bg-light">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-lightning-charge-fill text-warning fs-4 me-3"></i>
                                <h6 class="mb-0">Diseño Premium</h6>
                            </div>
                            <p class="small text-muted mb-0">Plantillas exclusivas y personalizaciones avanzadas</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="upgrade-feature p-3 rounded bg-light">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-graph-up text-success fs-4 me-3"></i>
                                <h6 class="mb-0">Analytics Avanzado</h6>
                            </div>
                            <p class="small text-muted mb-0">Métricas detalladas y reportes de rendimiento</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="upgrade-feature p-3 rounded bg-light">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-headset text-primary fs-4 me-3"></i>
                                <h6 class="mb-0">Soporte Priority</h6>
                            </div>
                            <p class="small text-muted mb-0">Atención personalizada 24/7</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="upgrade-feature p-3 rounded bg-light">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-shield-check text-success fs-4 me-3"></i>
                                <h6 class="mb-0">Seguridad Plus</h6>
                            </div>
                            <p class="small text-muted mb-0">Backups automáticos y SSL avanzado</p>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <div class="pricing-highlight p-4 rounded" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border: 2px solid #FFD700;">
                        <h5 class="text-dark mb-2">Plan Premium</h5>
                        <div class="mb-3">
                            <span class="h2 text-primary-gold fw-bold">$99.900</span>
                            <span class="text-muted"> COP/mes</span>
                        </div>
                        <p class="small text-muted mb-3">Ahorra un 20% con el pago anual</p>
                        <button type="button" class="btn btn-warning btn-lg fw-bold px-5" onclick="showUpgradeAlert()">>
                            <i class="bi bi-credit-card me-2"></i>
                            Actualizar Ahora
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- SweetAlert2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

    <!-- Quill.js Rich Text Editor (Gratuito) -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <!-- Estilos personalizados para Quill -->
    <style>
    .quill-container {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .quill-container:focus-within {
        border-color: rgb(225, 109, 34);
        box-shadow: 0 0 0 0.2rem rgba(225, 109, 34, 0.25);
    }

    .ql-toolbar {
        border-top: none;
        border-left: none;
        border-right: none;
        border-bottom: 1px solid #e0e0e0;
        border-radius: 8px 8px 0 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        padding: 12px;
    }

    .ql-container {
        border: none;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 14px;
        /* Altura fija responsiva */
        height: 300px;
        border-radius: 0 0 8px 8px;
        overflow-y: auto;
    }

    .ql-editor {
        line-height: 1.6;
        padding: 20px;
        color: #333;
        /* Altura mínima para el contenido */
        min-height: 260px;
        max-height: none;
    }

    /* Responsive: altura más pequeña en pantallas móviles */
    @media (max-width: 768px) {
        .ql-container {
            height: 200px;
        }
        
        .ql-editor {
            min-height: 160px;
            padding: 15px;
        }
    }

    /* Responsive: altura mediana en tablets */
    @media (min-width: 769px) and (max-width: 1024px) {
        .ql-container {
            height: 250px;
        }
        
        .ql-editor {
            min-height: 210px;
        }
    }

    .ql-editor h1, .ql-editor h2, .ql-editor h3 {
        color: rgb(225, 109, 34);
        font-weight: 600;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .ql-editor h1 { font-size: 24px; }
    .ql-editor h2 { font-size: 20px; }
    .ql-editor h3 { font-size: 16px; }

    .ql-editor p { 
        margin-bottom: 12px; 
    }

    .ql-editor ul, .ql-editor ol { 
        margin: 12px 0; 
        padding-left: 20px; 
    }

    .ql-editor li { 
        margin-bottom: 6px; 
    }

    .ql-editor strong { 
        color: #2c3e50; 
        font-weight: 600;
    }

    .ql-toolbar .ql-formats {
        margin-right: 15px;
    }

    .ql-toolbar button {
        border-radius: 4px;
        margin: 0 2px;
    }

    .ql-toolbar button:hover {
        background: rgba(225, 109, 34, 0.1);
    }

    .ql-toolbar .ql-active {
        background: rgb(225, 109, 34) !important;
        color: white !important;
    }

    .ql-snow .ql-tooltip {
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .editor-counter {
        text-align: right;
        padding: 8px 15px;
        font-size: 12px;
        color: #666;
        background: #f8f9fa;
        border-top: 1px solid #e0e0e0;
        border-radius: 0 0 8px 8px;
    }

    .editor-invalid .quill-container {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    </style>

    <!-- Profile Management JavaScript -->
    <script src="{{ asset('js/profile-management.js') }}"></script>

    <script>
        function showUpgradeModal() {
            const upgradeModal = new bootstrap.Modal(document.getElementById('upgradeModal'));
            upgradeModal.show();
        }

        // Email Verification Functions
        async function sendVerificationEmail() {
            const button = event.target;
            const originalText = button.innerHTML;
            
            // Mostrar loading
            button.disabled = true;
            button.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Enviando...';
            
            try {
                const response = await fetch('/admin/email/send-verification', {
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

// === VARIABLES Y CONFIGURACIÓN PARA EDITORES QUILL ===
let quillEditors = {};
const documentosLegalesBase = @json($documentosLegalesBase ?? []);

// Configuración común para todos los editores
const quillConfig = {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, 3, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'indent': '-1'}, { 'indent': '+1' }],
            [{ 'align': [] }],
            ['link'],
            ['blockquote', 'code-block'],
            ['clean']
        ]
    },
    formats: [
        'header', 'bold', 'italic', 'underline', 'strike',
        'color', 'background', 'list', 'indent', 'align',
        'link', 'blockquote', 'code-block'
    ],
    placeholder: 'Escribe aquí tu contenido legal...'
};

// Función para inicializar un editor Quill
function initQuillEditor(editorId, textareaId) {
    const container = document.getElementById(editorId);
    const textarea = document.getElementById(textareaId);
    
    if (!container || !textarea) {
        console.error(`No se encontró el contenedor ${editorId} o textarea ${textareaId}`);
        return;
    }
    
    // Crear editor Quill
    const quill = new Quill(container, quillConfig);
    
    // Cargar contenido inicial del textarea
    const initialContent = textarea.value;
    if (initialContent) {
        quill.root.innerHTML = initialContent;
    }
    
    // Guardar referencia del editor
    quillEditors[textareaId] = quill;
    
    // Crear contador de caracteres
    const counter = document.createElement('div');
    counter.className = 'editor-counter';
    counter.innerHTML = `<small><i class="bi bi-type"></i> <span id="${textareaId}-count">0</span> caracteres</small>`;
    container.parentNode.appendChild(counter);
    
    // Función para actualizar contador
    function updateCounter() {
        const text = quill.getText();
        const count = text.trim().length;
        document.getElementById(`${textareaId}-count`).textContent = count;
        
        // Validación en tiempo real
        const parentContainer = textarea.closest('.mb-3');
        const errorDiv = parentContainer.querySelector('.invalid-feedback');
        
        if (count < 50 && count > 0) {
            parentContainer.classList.add('editor-invalid');
            if (!errorDiv) {
                const invalidFeedback = document.createElement('div');
                invalidFeedback.className = 'invalid-feedback d-block';
                invalidFeedback.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i>Requiere al menos 50 caracteres para un documento legal adecuado.';
                counter.insertAdjacentElement('afterend', invalidFeedback);
            }
        } else {
            parentContainer.classList.remove('editor-invalid');
            if (errorDiv) {
                errorDiv.remove();
            }
        }
    }
    
    // Eventos del editor
    quill.on('text-change', function() {
        // Sincronizar con textarea oculto
        textarea.value = quill.root.innerHTML;
        updateCounter();
    });
    
    // Actualizar contador inicial
    updateCounter();
    
    
    return quill;
}

// Función para validar todos los editores
function validateQuillEditors() {
    let isValid = true;
    const editors = ['terminos_condiciones', 'politica_privacidad', 'politica_cookies'];
    
    editors.forEach(function(textareaId) {
        const quill = quillEditors[textareaId];
        const textarea = document.getElementById(textareaId);
        
        if (quill && textarea) {
            const text = quill.getText().trim();
            const parentContainer = textarea.closest('.mb-3');
            const errorDiv = parentContainer.querySelector('.invalid-feedback');
            
            // Limpiar errores previos
            parentContainer.classList.remove('editor-invalid');
            if (errorDiv) {
                errorDiv.remove();
            }
            
            // Validar contenido mínimo
            if (text.length < 50) {
                isValid = false;
                parentContainer.classList.add('editor-invalid');
                const invalidFeedback = document.createElement('div');
                invalidFeedback.className = 'invalid-feedback d-block';
                invalidFeedback.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i>Este documento legal requiere al menos 50 caracteres de contenido detallado.';
                
                const counter = parentContainer.querySelector('.editor-counter');
                if (counter) {
                    counter.insertAdjacentElement('afterend', invalidFeedback);
                }
            }
        }
    });
    
    return isValid;
}

// Sincronizar editores con textareas antes del envío
function syncQuillEditors() {
    Object.keys(quillEditors).forEach(function(textareaId) {
        const quill = quillEditors[textareaId];
        const textarea = document.getElementById(textareaId);
        if (quill && textarea) {
            textarea.value = quill.root.innerHTML;
        }
    });
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
            
            // === INICIALIZACIÓN DE EDITORES QUILL ===
            // Verificar si Quill está disponible
            if (typeof Quill !== 'undefined') {
                
                
                // Ocultar textareas originales e inicializar editores
                document.querySelectorAll('.tinymce-editor').forEach(function(textarea) {
                    textarea.style.display = 'none';
                    
                    // Crear contenedor del editor Quill
                    const editorContainer = document.createElement('div');
                    editorContainer.id = textarea.id + '_editor';
                    editorContainer.className = 'quill-container';
                    textarea.parentNode.insertBefore(editorContainer, textarea);
                    
                    // Inicializar editor con un pequeño delay
                    setTimeout(() => {
                        initQuillEditor(textarea.id + '_editor', textarea.id);
                    }, 200);
                });
                
                // Validación del formulario
                const form = document.querySelector('form[action="{{ route('admin.profile.update') }}"]');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        // Sincronizar contenido
                        syncQuillEditors();
                        
                        // Validar editores
                        if (!validateQuillEditors()) {
                            e.preventDefault();
                            showNotification('Por favor completa los documentos legales con contenido más detallado.', 'warning');
                            
                            // Scroll al primer error
                            const firstError = document.querySelector('.editor-invalid');
                            if (firstError) {
                                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                            
                            return false;
                        }
                        
                        // Mostrar loading en el botón de submit
                        const submitBtn = form.querySelector('button[type="submit"]');
                        if (submitBtn) {
                            submitBtn.disabled = true;
                            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Guardando perfil...';
                        }
                    });
                }
                
            } else {
                console.error('❌ Quill.js no se ha cargado correctamente');
            }
        });

        function showNotification(message, type = 'info') {
            // Configuración de SweetAlert2 según el tipo
            const config = {
                text: message,
                timer: 4000,
                timerProgressBar: true,
                position: 'top-end',
                toast: true,
                showConfirmButton: false,
                showCloseButton: true,
                customClass: {
                    popup: 'colored-toast'
                }
            };

            // Configurar según el tipo
            switch(type) {
                case 'success':
                    config.icon = 'success';
                    config.iconColor = '#28a745';
                    config.background = '#d4edda';
                    config.color = '#155724';
                    break;
                case 'error':
                    config.icon = 'error';
                    config.iconColor = '#dc3545';
                    config.background = '#f8d7da';
                    config.color = '#721c24';
                    break;
                case 'warning':
                    config.icon = 'warning';
                    config.iconColor = '#ffc107';
                    config.background = '#fff3cd';
                    config.color = '#856404';
                    break;
                default:
                    config.icon = 'info';
                    config.iconColor = '#17a2b8';
                    config.background = '#d1ecf1';
                    config.color = '#0c5460';
            }

            Swal.fire(config);
        }

        // Función para cargar texto base en los editores
        async function cargarTextoBase(tipoDocumento) {
            const quill = quillEditors[tipoDocumento];
            const textarea = document.getElementById(tipoDocumento);
            
            if (!quill || !documentosLegalesBase[tipoDocumento]) {
                console.error('Editor no encontrado o texto base no disponible para:', tipoDocumento);
                return;
            }
            
            // Mostrar confirmación si ya hay contenido
            const currentContent = quill.getText().trim();
            if (currentContent.length > 10) {
                const result = await Swal.fire({
                    title: '⚠️ ¿Reemplazar contenido existente?',
                    html: `
                        <div class="text-start">
                            <p class="mb-3">Ya tienes contenido escrito en este documento.</p>
                            <div class="alert alert-warning border-0 mb-0">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>¡Atención!</strong> Esta acción sobrescribirá todo el texto que hayas escrito.
                            </div>
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bi bi-arrow-repeat me-1"></i> Sí, reemplazar',
                    cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Cancelar',
                    reverseButtons: true,
                    customClass: {
                        popup: 'border-0 shadow-lg',
                        title: 'text-dark fw-bold',
                        confirmButton: 'btn-lg fw-bold',
                        cancelButton: 'btn-lg'
                    }
                });
                
                if (!result.isConfirmed) {
                    return;
                }
            }
            
            // Cargar el texto base en el editor
            const textoBase = documentosLegalesBase[tipoDocumento];
            
            // Mostrar loading en el botón
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.disabled = true;
            button.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Cargando texto base...';
            
            // Simular un pequeño delay para mejor UX
            setTimeout(() => {
                // Cargar contenido en Quill
                quill.root.innerHTML = textoBase;
                
                // Sincronizar con textarea
                textarea.value = textoBase;
                
                // Mostrar notificación de éxito
                const tipoNombre = {
                    'terminos_condiciones': 'Términos y Condiciones',
                    'politica_privacidad': 'Política de Privacidad', 
                    'politica_cookies': 'Política de Cookies'
                }[tipoDocumento];
                
                showNotification(
                    `✅ Texto base cargado para ${tipoNombre}. ¡Ahora puedes personalizarlo según tus necesidades!`, 
                    'success'
                );
                
                // Scroll al editor para que el usuario vea el contenido
                quill.root.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Highlight del editor por un momento
                const container = quill.container;
                container.style.transition = 'all 0.3s ease';
                container.style.borderColor = '#28a745';
                container.style.boxShadow = '0 0 0 0.2rem rgba(40, 167, 69, 0.25)';
                
                setTimeout(() => {
                    container.style.borderColor = '#dee2e6';
                    container.style.boxShadow = '0 2px 8px rgba(0,0,0,0.05)';
                }, 2000);
                
                // Restaurar el botón
                button.disabled = false;
                button.innerHTML = originalText;
                
                // Cambiar temporalmente el texto del botón para confirmar la acción
                button.innerHTML = '<i class="bi bi-check-circle me-1"></i>¡Texto cargado! Personalízalo';
                button.classList.remove('btn-outline-primary', 'btn-outline-success', 'btn-outline-warning');
                button.classList.add('btn-success');
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('btn-success');
                    
                    // Restaurar la clase original según el tipo
                    if (tipoDocumento === 'terminos_condiciones') {
                        button.classList.add('btn-outline-primary');
                    } else if (tipoDocumento === 'politica_privacidad') {
                        button.classList.add('btn-outline-success');
                    } else if (tipoDocumento === 'politica_cookies') {
                        button.classList.add('btn-outline-warning');
                    }
                }, 3000);
                
            }, 800);
        }

        // Funciones para SweetAlert de "Próximamente disponible"
        function showComingSoonAlert() {
            Swal.fire({
                title: '🚧 Funcionalidad en Desarrollo',
                html: `
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="bi bi-tools" style="font-size: 4rem; color: #ffc107;"></i>
                        </div>
                        <p class="mb-3">Esta funcionalidad estará disponible próximamente.</p>
                        <div class="alert alert-info border-0 mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            Estamos trabajando para traerte las mejores herramientas de gestión.
                        </div>
                    </div>
                `,
                icon: 'info',
                confirmButtonColor: '#17a2b8',
                confirmButtonText: '<i class="bi bi-check-lg me-1"></i> Entendido',
                customClass: {
                    popup: 'border-0 shadow-lg',
                    title: 'text-primary fw-bold'
                }
            });
        }

        function showUpgradeModal() {
            Swal.fire({
                title: '⭐ Plan Premium Próximamente',
                html: `
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="bi bi-rocket-takeoff" style="font-size: 4rem; color: #ffc107;"></i>
                        </div>
                        <p class="mb-3">El sistema de pagos y planes premium estará disponible muy pronto.</p>
                        <div class="alert alert-warning border-0 mb-0">
                            <i class="bi bi-gift me-2"></i>
                            Por ahora disfruta de todas las funcionalidades de forma gratuita.
                        </div>
                    </div>
                `,
                icon: 'info',
                confirmButtonColor: '#ffc107',
                confirmButtonText: '<i class="bi bi-check-lg me-1"></i> ¡Genial!',
                customClass: {
                    popup: 'border-0 shadow-lg',
                    title: 'text-warning fw-bold'
                }
            });
        }
        
        // Función para mostrar detalles del pago
        function showPaymentDetails(renovacion) {
            const statusBadge = {
                'completado': '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Completado</span>',
                'pendiente': '<span class="badge bg-warning"><i class="bi bi-clock me-1"></i>Pendiente</span>',
                'cancelado': '<span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Cancelado</span>',
                'procesando': '<span class="badge bg-info"><i class="bi bi-arrow-repeat me-1"></i>Procesando</span>'
            };
            
            const formatDate = (dateString) => {
                const date = new Date(dateString);
                return date.toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            };
            
            Swal.fire({
                title: '<i class="bi bi-receipt me-2"></i>Detalles del Pago',
                html: `
                    <div class="text-start">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">Fecha de Pago</h6>
                                <p class="fw-bold mb-0">${formatDate(renovacion.created_at)}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">Estado</h6>
                                <div>${statusBadge[renovacion.estado.toLowerCase()] || renovacion.estado}</div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">Plan</h6>
                                <p class="fw-bold mb-0">${renovacion.plan_nombre || 'No especificado'}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">Monto</h6>
                                <p class="fw-bold mb-0 text-success fs-5">$${Number(renovacion.monto || 0).toLocaleString('es-ES')}</p>
                            </div>
                        </div>
                        
                        ${renovacion.fecha_inicio ? `
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">Fecha de Inicio</h6>
                                <p class="mb-0">${formatDate(renovacion.fecha_inicio)}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">Fecha de Fin</h6>
                                <p class="mb-0">${renovacion.fecha_fin ? formatDate(renovacion.fecha_fin) : 'No especificada'}</p>
                            </div>
                        </div>
                        ` : ''}
                        
                        ${renovacion.metodo_pago ? `
                        <div class="row mb-3">
                            <div class="col-12">
                                <h6 class="text-muted mb-2">Método de Pago</h6>
                                <p class="mb-0">${renovacion.metodo_pago}</p>
                            </div>
                        </div>
                        ` : ''}
                        
                        ${renovacion.referencia_pago ? `
                        <div class="row mb-3">
                            <div class="col-12">
                                <h6 class="text-muted mb-2">Referencia de Pago</h6>
                                <p class="mb-0 font-monospace">${renovacion.referencia_pago}</p>
                            </div>
                        </div>
                        ` : ''}
                        
                        <hr class="my-3">
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-outline-primary btn-sm" onclick="downloadInvoice(${renovacion.id})">
                                <i class="bi bi-download me-1"></i>
                                Descargar Recibo
                            </button>
                            <small class="text-muted">ID: #${renovacion.id}</small>
                        </div>
                    </div>
                `,
                width: 600,
                showConfirmButton: false,
                showCloseButton: true,
                customClass: {
                    popup: 'border-0 shadow-lg',
                    title: 'text-primary fw-bold',
                    closeButton: 'btn-close-white'
                }
            });
        }

        // Configuración del flete - Guardado automático
        document.addEventListener('DOMContentLoaded', function() {
            const fleteInput = document.getElementById('flete');
            const previewFlete = document.getElementById('preview-flete');
            let timeout;

            if (fleteInput) {
                fleteInput.addEventListener('input', function() {
                    clearTimeout(timeout);
                    
                    // Actualizar vista previa inmediatamente
                    const value = parseInt(this.value) || 0;
                    if (value > 0) {
                        previewFlete.textContent = '$' + value.toLocaleString('es-CO');
                    } else {
                        previewFlete.textContent = 'Gratis';
                    }

                    // Debounce - guardar después de 1 segundo sin cambios
                    timeout = setTimeout(() => {
                        updateFlete(value);
                    }, 1000);
                });

                // También guardar cuando pierde el foco
                fleteInput.addEventListener('blur', function() {
                    clearTimeout(timeout);
                    const value = parseInt(this.value) || 0;
                    updateFlete(value);
                });
            }

            function updateFlete(value) {
                fetch('{{ route("admin.profile.flete.update") }}', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        flete: value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mostrar toast de éxito discreto
                        showToast('success', 'Flete actualizado correctamente');
                    } else {
                        showToast('error', data.message || 'Error al actualizar el flete');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('error', 'Error de conexión al actualizar el flete');
                });
            }

            function showToast(type, message) {
                Swal.fire({
                    icon: type,
                    title: message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'colored-toast'
                    }
                });
            }
        });
    </script>

@endsection
