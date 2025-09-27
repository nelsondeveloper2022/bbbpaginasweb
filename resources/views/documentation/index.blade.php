@extends('layouts.dashboard')

@section('title', 'Documentación y Ayuda - BBB Páginas Web')
@section('description', 'Centro de ayuda y documentación completa para usar la plataforma BBB Páginas Web')

@section('content')
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="dashboard-title">
                <i class="bi bi-book-half me-3"></i>
                Documentación y Ayuda
            </h1>
            <p class="text-muted mb-0">Todo lo que necesitas saber para usar BBB Páginas Web</p>
        </div>
        <div class="d-flex gap-2">
            <a href="https://wa.me/{{ config('app.support.mobile') }}?text=Hola%20vengo%20de%20la%20empresa%20{{ urlencode(auth()->user()->empresa_nombre ?? auth()->user()->name ?? 'Mi empresa') }}%20tengo%20una%20duda%20sobre%20el%20administrador" 
               target="_blank" class="btn btn-success btn-sm">
                <i class="bi bi-whatsapp me-2"></i>
                Soporte WhatsApp
            </a>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-arrow-left me-2"></i>
                Volver al Dashboard
            </a>
        </div>
    </div>
</div>

<!-- Navegación rápida -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-primary text-white">
            <div class="card-body py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="mb-1">
                            <i class="bi bi-lightbulb me-2"></i>
                            ¿Necesitas ayuda inmediata?
                        </h5>
                        <p class="mb-0">Contacta nuestro soporte técnico directamente</p>
                    </div>
                    <div>
                        <a href="https://wa.me/{{ config('app.support.mobile') }}" target="_blank" class="btn btn-light btn-lg">
                            <i class="bi bi-whatsapp me-2"></i>
                            Soporte 24/7
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Guías principales -->
<div class="row g-4 mb-5">
    <!-- Inicio Rápido -->
    <div class="col-lg-4 col-md-6">
        <div class="card h-100 documentation-card">
            <div class="card-body text-center">
                <div class="documentation-icon bg-success text-white mb-3">
                    <i class="bi bi-rocket-takeoff fs-1"></i>
                </div>
                <h5 class="card-title">Inicio Rápido</h5>
                <p class="card-text text-muted">Configura tu cuenta y publica tu primera página web en minutos</p>
                <a href="{{ route('documentation.quick-start') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-arrow-right me-2"></i>
                    Comenzar ahora
                </a>
            </div>
        </div>
    </div>

    <!-- Publicar Web -->
    <div class="col-lg-4 col-md-6">
        <div class="card h-100 documentation-card">
            <div class="card-body text-center">
                <div class="documentation-icon bg-primary text-white mb-3">
                    <i class="bi bi-globe fs-1"></i>
                </div>
                <h5 class="card-title">Publicar tu Web</h5>
                <p class="card-text text-muted">Paso a paso para crear y publicar tu sitio web profesional</p>
                <a href="{{ route('documentation.publish-guide') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-arrow-right me-2"></i>
                    Ver guía
                </a>
            </div>
        </div>
    </div>

    <!-- Configurar Perfil -->
    <div class="col-lg-4 col-md-6">
        <div class="card h-100 documentation-card">
            <div class="card-body text-center">
                <div class="documentation-icon bg-info text-white mb-3">
                    <i class="bi bi-person-gear fs-1"></i>
                </div>
                <h5 class="card-title">Configurar Perfil</h5>
                <p class="card-text text-muted">Completa tu información personal y empresarial</p>
                <a href="{{ route('documentation.profile-guide') }}" class="btn btn-info btn-sm">
                    <i class="bi bi-arrow-right me-2"></i>
                    Configurar
                </a>
            </div>
        </div>
    </div>

    <!-- Planes y Suscripciones -->
    <div class="col-lg-4 col-md-6">
        <div class="card h-100 documentation-card">
            <div class="card-body text-center">
                <div class="documentation-icon bg-warning text-white mb-3">
                    <i class="bi bi-credit-card fs-1"></i>
                </div>
                <h5 class="card-title">Planes y Pagos</h5>
                <p class="card-text text-muted">Información sobre planes, pagos y renovaciones</p>
                <a href="{{ route('documentation.plans-guide') }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-arrow-right me-2"></i>
                    Ver planes
                </a>
            </div>
        </div>
    </div>

    <!-- Landing Pages -->
    <div class="col-lg-4 col-md-6">
        <div class="card h-100 documentation-card">
            <div class="card-body text-center">
                <div class="documentation-icon bg-purple text-white mb-3">
                    <i class="bi bi-palette fs-1"></i>
                </div>
                <h5 class="card-title">Diseño de Páginas</h5>
                <p class="card-text text-muted">Personaliza el diseño y contenido de tu sitio web</p>
                <a href="{{ route('documentation.landing-guide') }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-arrow-right me-2"></i>
                    Personalizar
                </a>
            </div>
        </div>
    </div>

    <!-- Recibos y Pagos -->
    <div class="col-lg-4 col-md-6">
        <div class="card h-100 documentation-card">
            <div class="card-body text-center">
                <div class="documentation-icon bg-success text-white mb-3">
                    <i class="bi bi-receipt fs-1"></i>
                </div>
                <h5 class="card-title">Recibos y Pagos</h5>
                <p class="card-text text-muted">Aprende a descargar y gestionar tus recibos de pago</p>
                <a href="{{ route('documentation.receipts-guide') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-arrow-right me-2"></i>
                    Ver guía
                </a>
            </div>
        </div>
    </div>

    <!-- FAQ -->
    <div class="col-lg-4 col-md-6">
        <div class="card h-100 documentation-card">
            <div class="card-body text-center">
                <div class="documentation-icon bg-secondary text-white mb-3">
                    <i class="bi bi-question-circle fs-1"></i>
                </div>
                <h5 class="card-title">Preguntas Frecuentes</h5>
                <p class="card-text text-muted">Respuestas a las dudas más comunes de nuestros usuarios</p>
                <a href="{{ route('documentation.faq') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-right me-2"></i>
                    Ver FAQ
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Estado de tu cuenta -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Estado de tu Cuenta
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Perfil</h6>
                        @if(auth()->user()->isEmailVerified())
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <span>Email verificado</span>
                            </div>
                        @else
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                                <span>Email sin verificar</span>
                                <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-danger ms-2">Verificar</a>
                            </div>
                        @endif

                        @if(auth()->user()->hasCompleteProfile())
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <span>Perfil completo</span>
                            </div>
                        @else
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                                <span>Perfil incompleto</span>
                                <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-warning ms-2">Completar</a>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success mb-3">Plan Actual</h6>
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-star-fill text-warning me-2"></i>
                            <span>{{ auth()->user()->plan->nombre ?? 'Sin plan' }}</span>
                        </div>
                        @if(auth()->user()->trial_ends_at)
                            @php
                                $daysLeft = intval(now()->diffInDays(auth()->user()->trial_ends_at, false));
                            @endphp
                            @if($daysLeft > 0)
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-clock-fill text-info me-2"></i>
                                    <span>{{ $daysLeft }} días restantes</span>
                                </div>
                            @else
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                                    <span>Plan expirado</span>
                                    <a href="{{ route('admin.plans.index') }}" class="btn btn-sm btn-danger ms-2">Renovar</a>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.documentation-card {
    transition: all 0.3s ease;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.documentation-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.documentation-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.bg-purple {
    background: linear-gradient(135deg, #6f42c1, #8a63d2) !important;
}
</style>
@endsection