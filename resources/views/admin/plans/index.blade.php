@extends('layouts.dashboard')

@section('title', 'Gestión de Planes')

@section('content')
<div class="container-fluid">
    @if($trialExpired || session('trial_expired'))
    <!-- Trial Expired Alert -->
    <div class="alert alert-danger mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill me-3 fs-2 text-danger"></i>
            <div class="flex-grow-1">
                <h4 class="alert-heading mb-2 text-danger">
                    <i class="bi bi-clock-history me-2"></i>
                    @if($currentPlan && $currentPlan->idPlan == 6)
                        Tu período gratuito de 15 días ha finalizado
                    @else
                        Tu plan ha expirado
                    @endif
                </h4>
                <p class="mb-3 fs-5">
                    Para continuar usando todas las funciones de la plataforma, 
                    necesitas adquirir uno de nuestros planes premium.
                </p>
                <div class="bg-light p-3 rounded border-start border-warning border-4">
                    <h6 class="text-primary mb-2">
                        <i class="bi bi-star-fill me-1"></i>
                        Beneficios al adquirir un plan:
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled mb-0">
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Acceso completo al dashboard</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Configuración avanzada de landing</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Publicación ilimitada</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled mb-0">
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Soporte técnico prioritario</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Analytics detallados</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i>Integración con herramientas</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-1">
                        <i class="bi bi-credit-card-2-front me-2 text-primary"></i>
                        Gestión de Planes
                    </h1>
                    <p class="text-muted mb-0">Administra tu suscripción y elige el plan ideal para tu negocio</p>
                </div>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver al Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Available Plans Header -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <div class="mb-4">
                <h2 class="fw-bold text-primary mb-3">
                    <i class="bi bi-grid-3x3-gap me-2"></i>
                    Planes Disponibles
                </h2>
                <p class="text-muted fs-5 mb-0">
                    Elige el plan perfecto para hacer crecer tu negocio
                </p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="bg-light rounded-3 p-4">
                        <div class="row text-center">
                            <div class="col-md-4 mb-2 mb-md-0">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <small class="fw-semibold">Configuración completa</small>
                            </div>
                            <div class="col-md-4 mb-2 mb-md-0">
                                <i class="bi bi-headset text-success me-2"></i>
                                <small class="fw-semibold">Soporte técnico</small>
                            </div>
                            <div class="col-md-4">
                                <i class="bi bi-shield-check text-success me-2"></i>
                                <small class="fw-semibold">Pago seguro</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Plans Carousel with Side Controls -->
    <div class="carousel-container position-relative">
        <!-- Left Arrow -->
        <button class="carousel-control-prev-custom" type="button" data-bs-target="#plansCarousel" data-bs-slide="prev">
            <i class="bi bi-chevron-left"></i>
        </button>
        
        <!-- Right Arrow -->
        <button class="carousel-control-next-custom" type="button" data-bs-target="#plansCarousel" data-bs-slide="next">
            <i class="bi bi-chevron-right"></i>
        </button>
        
        <div id="plansCarousel" class="carousel slide" data-bs-ride="false">
        <div class="carousel-inner">
            @php $firstSlideRendered = true; @endphp
            @foreach($plans->chunk(2) as $chunkIndex => $planChunk)
                @php
                    $hasPaid = $planChunk->contains(function ($p) {
                        return (($p->precioPesos ?? 0) > 0);
                    });
                @endphp
                @if(!$hasPaid)
                    @continue
                @endif
                <div class="carousel-item {{ $firstSlideRendered ? 'active' : '' }}">
                    <div class="row justify-content-center">
                        @foreach($planChunk as $plan)
                            @if(($plan->precioPesos ?? 0) <= 0)
                                @continue
                            @endif
                        <div class="col-lg-5 col-md-6 mb-4">
                            <div class="card h-100 plan-card {{ $plan->destacado ? 'featured-plan' : '' }} {{ $currentPlan && $currentPlan->idPlan == $plan->idPlan ? 'current-plan' : '' }}">
                                @if($plan->destacado)
                                <div class="card-ribbon">
                                    <span class="badge bg-primary">Más Popular</span>
                                </div>
                                @endif
                                
                                @if($currentPlan && $currentPlan->idPlan == $plan->idPlan)
                                <div class="card-ribbon-current">
                                    <span class="badge bg-success">Plan Actual</span>
                                </div>
                                @endif
                                
                                <div class="card-header text-center bg-transparent">
                                    <div class="plan-icon mb-3">
                                        <i class="{{ $plan->icono ?? 'bi bi-star' }} fs-1 text-primary"></i>
                                    </div>
                                    <h3 class="plan-title">{{ $plan->nombre }}</h3>
                                    <div class="plan-price">
                                        <span class="price-currency">$</span>
                                        <span class="price-amount">{{ number_format($plan->precioPesos, 0, ',', '.') }}</span>
                                        @if($plan->dias > 0)
                                            <span class="price-period">/ {{ $plan->dias }} días</span>
                                        @else
                                            <span class="price-period">pago único</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="card-body">
                                    <div class="plan-description">
                                        {!! $plan->descripcion !!}
                                    </div>
                                </div>
                                
                                <div class="card-footer bg-transparent text-center">
                                    @php
                                        $canSelect = canSelectPlan($user, $plan) ?? true;
                                        $isCurrentPlan = $currentPlan && $currentPlan->idPlan == $plan->idPlan;
                                    @endphp
                                    
                                    @if($isCurrentPlan)
                                        @if(stripos($plan->nombre, 'free') !== false)
                                            {{-- Plan Free actual - no se puede renovar --}}
                                            <button class="btn btn-success btn-lg w-100" disabled>
                                                <i class="bi bi-gift-fill me-2"></i>
                                                Plan Gratuito Activo
                                            </button>
                                            <small class="text-muted d-block mt-2 text-center">
                                                Los planes gratuitos no se renuevan. Adquiere un plan premium.
                                            </small>
                                        @elseif(isPlanRenewable($plan))
                                            <a href="{{ route('admin.plans.purchase', $plan->idPlan) }}" class="btn btn-success btn-lg w-100">
                                                <i class="bi bi-arrow-repeat me-2"></i>
                                                Renovar Plan
                                            </a>
                                        @else
                                            <button class="btn btn-success btn-lg w-100" disabled>
                                                <i class="bi bi-check-circle-fill me-2"></i>
                                                Plan Permanente
                                            </button>
                                        @endif
                                    @elseif($canSelect)
                                        <a href="{{ route('admin.plans.purchase', $plan->idPlan) }}" class="btn {{ $plan->destacado ? 'btn-primary' : 'btn-outline-primary' }} btn-lg w-100">
                                            <i class="bi bi-credit-card me-2"></i>
                                            Adquirir Plan
                                        </a>
                                    @else
                                        <button class="btn btn-secondary btn-lg w-100" disabled>
                                            <i class="bi bi-lock me-2"></i>
                                            No Disponible
                                        </button>
                                        <small class="text-muted d-block mt-2">
                                            No puedes cambiar a este plan según tu plan actual
                                        </small>
                                    @endif
                                    
                                    <small class="text-muted d-block mt-2">
                                        <i class="bi bi-shield-check me-1"></i>
                                        Pago seguro con Wompi
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @php $firstSlideRendered = false; @endphp
            @endforeach
        </div>
        
        <!-- Carousel indicators -->
        <div class="carousel-indicators-custom mt-4">
            @foreach($plans->chunk(2) as $chunkIndex => $planChunk)
            <button type="button" data-bs-target="#plansCarousel" data-bs-slide-to="{{ $chunkIndex }}" 
                    class="indicator-dot {{ $chunkIndex == 0 ? 'active' : '' }}" aria-current="true">
            </button>
            @endforeach
        </div>
        </div> <!-- End carousel -->
    </div> <!-- End carousel-container -->

    <!-- Help Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 bg-light">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">
                                <i class="bi bi-question-circle me-2"></i>
                                ¿Dudas sobre los planes?
                            </h5>
                            <p class="text-muted mb-3">
                                Te ayudamos a elegir el plan perfecto para tu negocio.
                            </p>
                            <a href="mailto:{{ config('app.support.email') }}" class="btn btn-outline-primary">
                                <i class="bi bi-envelope me-2"></i>
                                Contactar Soporte
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Current Plan Info -->
@if($currentPlan)
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="mb-4 text-center">
                <h3 class="fw-bold text-dark mb-2">Tu Plan Actual</h3>
                <p class="text-muted">Información detallada de tu plan activo</p>
            </div>
            
            <div class="card shadow-lg border-0 overflow-hidden">
                <div class="row g-0">
                    <!-- Plan Info Column -->
                    <div class="col-lg-8">
                        <div class="card-body h-100 p-4 p-lg-5">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-primary bg-gradient rounded-circle p-3 me-3">
                                    <i class="bi bi-star-fill text-white fs-4"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1 fw-bold text-dark">{{ $currentPlan->nombre }}</h4>
                                    @if(auth()->user()->empresa && auth()->user()->empresa->nombre)
                                        <small class="text-muted fw-medium">
                                            <i class="bi bi-building me-1"></i>
                                            {{ auth()->user()->empresa->nombre }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="border-start border-primary border-4 ps-3">
                                        <h6 class="text-primary fw-semibold mb-2">Descripción del Plan</h6>
                                        <div class="text-muted small lh-lg">
                                            {!! $currentPlan->descripcion !!}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="border-start border-success border-4 ps-3">
                                        <h6 class="text-success fw-semibold mb-2">Características</h6>
                                        <div class="small">
                                            @if($currentPlan->dias > 0)
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="bi bi-calendar-check text-success me-2"></i>
                                                    <span>Duración: {{ $currentPlan->dias }} días</span>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="bi bi-arrow-repeat text-success me-2"></i>
                                                    <span>Plan renovable</span>
                                                </div>
                                            @else
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="bi bi-infinity text-success me-2"></i>
                                                    <span>Plan de por vida</span>
                                                </div>
                                            @endif
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-shield-check text-success me-2"></i>
                                                <span>Acceso completo</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-headset text-success me-2"></i>
                                                <span>Soporte incluido</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Status Column -->
                    <div class="col-lg-4 bg-light">
                        <div class="card-body h-100 p-4 d-flex flex-column justify-content-center">
                            <div class="text-center mb-4">
                                @if($user->trial_ends_at)
                                    @if($user->trial_ends_at->isFuture())
                                        <div class="bg-success bg-gradient rounded-circle p-3 d-inline-flex mb-3">
                                            <i class="bi bi-check-circle-fill text-white fs-1"></i>
                                        </div>
                                        <h5 class="fw-bold text-success mb-2">Plan Activo</h5>
                                        <p class="mb-3 text-muted">Tu plan está funcionando correctamente</p>
                                        <div class="bg-white rounded-3 p-3 shadow-sm">
                                            <small class="text-muted d-block mb-1">Vence el:</small>
                                            <strong class="text-dark fs-5">{{ $user->trial_ends_at->format('d/m/Y') }}</strong>
                                            <small class="text-muted d-block mt-1">
                                                @php
                                                    $timeRemaining = calculate_precise_time_remaining($user->trial_ends_at);
                                                @endphp
                                                @if($timeRemaining)
                                                    (en {{ $timeRemaining }})
                                                @endif
                                            </small>
                                        </div>
                                    @else
                                        <div class="bg-danger bg-gradient rounded-circle p-3 d-inline-flex mb-3">
                                            <i class="bi bi-exclamation-triangle-fill text-white fs-1"></i>
                                        </div>
                                        <h5 class="fw-bold text-danger mb-2">Plan Vencido</h5>
                                        <p class="mb-3 text-muted">Tu plan venció el {{ $user->trial_ends_at->format('d/m/Y') }}</p>
                                        <div class="bg-white rounded-3 p-3 shadow-sm">
                                            <small class="text-danger fw-semibold">¡Renueva ahora!</small>
                                        </div>
                                    @endif
                                @else
                                    <div class="bg-primary bg-gradient rounded-circle p-3 d-inline-flex mb-3">
                                        <i class="bi bi-infinity text-white fs-1"></i>
                                    </div>
                                    <h5 class="fw-bold text-primary mb-2">Plan Permanente</h5>
                                    <p class="mb-3 text-muted">Acceso de por vida</p>
                                @endif
                            </div>
                            
                            @if($lastRenovacion)
                            <div class="border-top pt-3">
                                <h6 class="text-muted mb-3 fw-semibold">
                                    <i class="bi bi-receipt me-2"></i>Último Pago
                                </h6>
                                <div class="bg-white rounded-3 p-3 shadow-sm">
                                    <div class="row g-2 small">
                                        <div class="col-6">
                                            <strong class="text-dark">Fecha:</strong>
                                        </div>
                                        <div class="col-6 text-end">
                                            {{ $lastRenovacion->created_at->format('d/m/Y') }}
                                        </div>
                                        <div class="col-6">
                                            <strong class="text-dark">Valor:</strong>
                                        </div>
                                        <div class="col-6 text-end fw-bold text-primary">
                                            ${{ number_format($lastRenovacion->amount, 0, ',', '.') }}
                                        </div>
                                        <div class="col-12 text-center mt-2">
                                            <span class="badge bg-{{ $lastRenovacion->status === 'completed' ? 'success' : 'secondary' }} px-3">
                                                {{ ucfirst($lastRenovacion->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<style>
.plan-card {
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.plan-card:hover {
    border-color: #007bff;
    box-shadow: 0 10px 25px rgba(0,123,255,0.15);
    transform: translateY(-3px);
}

.featured-plan {
    border-color: #007bff;
    box-shadow: 0 5px 15px rgba(0,123,255,0.2);
}

.current-plan {
    border-color: #28a745;
    background: linear-gradient(135deg, #f8fff9 0%, #e8f5e8 100%);
}

.card-ribbon, .card-ribbon-current {
    position: absolute;
    top: 15px;
    right: -30px;
    transform: rotate(45deg);
    z-index: 1;
}

.card-ribbon-current {
    right: -35px;
}

.card-ribbon .badge, .card-ribbon-current .badge {
    padding: 5px 40px;
    font-size: 0.75rem;
}

.plan-icon {
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.plan-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.plan-price {
    margin-bottom: 1.5rem;
}

.price-currency {
    font-size: 1.2rem;
    font-weight: 500;
    color: #6c757d;
    vertical-align: top;
}

.price-amount {
    font-size: 2.5rem;
    font-weight: 700;
    color: #007bff;
    line-height: 1;
}

.price-period {
    font-size: 0.9rem;
    color: #6c757d;
    font-weight: 500;
}

.plan-description {
    margin-bottom: 2rem;
    color: #6c757d;
    line-height: 1.6;
}

.plan-features {
    margin-bottom: 2rem;
}

.plan-features li {
    padding: 0.4rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.plan-features li:last-child {
    border-bottom: none;
}

/* Carousel Container */
.carousel-container {
    position: relative;
    padding: 0 60px; /* Space for side arrows */
}

#plansCarousel {
    position: relative;
}

/* Side Controls */
.carousel-control-prev-custom,
.carousel-control-next-custom {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 2px solid #007bff;
    background-color: white;
    color: #007bff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    z-index: 10;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
    cursor: pointer;
}

.carousel-control-prev-custom {
    left: 10px;
}

.carousel-control-next-custom {
    right: 10px;
}

.carousel-control-prev-custom:hover,
.carousel-control-next-custom:hover {
    background-color: #007bff;
    color: white;
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
}

.carousel-inner {
    padding: 10px 0;
}

.carousel-item {
    transition: transform 0.6s ease-in-out;
}

/* Custom Indicators */
.carousel-indicators-custom {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin: 0;
    padding: 0;
    list-style: none;
}

.indicator-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #007bff;
    background-color: transparent;
    transition: all 0.3s ease;
    cursor: pointer;
}

.indicator-dot.active,
.indicator-dot:hover {
    background-color: #007bff;
    transform: scale(1.2);
}

/* Plan card adjustments for carousel */
.carousel .plan-card {
    margin: 0 10px;
    max-width: none;
}

/* Responsive carousel */
@media (max-width: 768px) {
    .price-amount {
        font-size: 2rem;
    }
    
    .plan-card {
        margin-bottom: 2rem;
    }
    
    .carousel-container {
        padding: 0 20px; /* Reduce padding on mobile */
    }
    
    .carousel-control-prev-custom,
    .carousel-control-next-custom {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .carousel-control-prev-custom {
        left: 5px;
    }
    
    .carousel-control-next-custom {
        right: 5px;
    }
    
    .col-lg-5 {
        flex: 0 0 100%;
        max-width: 100%;
    }
}

@media (max-width: 576px) {
    .carousel .plan-card {
        margin: 0 5px;
    }
    
    .plan-title {
        font-size: 1.3rem;
    }
    
    .price-amount {
        font-size: 1.8rem;
    }
    
    .carousel-container {
        padding: 0 15px;
    }
    
    .carousel-control-prev-custom,
    .carousel-control-next-custom {
        width: 35px;
        height: 35px;
        font-size: 0.9rem;
    }
    
    .carousel-control-prev-custom {
        left: 0;
    }
    
    .carousel-control-next-custom {
        right: 0;
    }
}
</style>

@php
function canSelectPlan($user, $plan) {
    $currentPlanId = $user->id_plan;
    $targetPlanId = $plan->idPlan;
    
    // No permitir comprar planes que contengan "free" en el nombre (case insensitive)
    if (stripos($plan->nombre, 'free') !== false) {
        return false;
    }
    
    // Desde Free (sin plan, plan 0, plan 1 o plan 2) → cualquier plan de pago
    if (!$currentPlanId || $currentPlanId == 0 || $currentPlanId == 1 || $currentPlanId == 2) {
        return stripos($plan->nombre, 'free') === false;
    }
    
    // Desde plan 3 (Arriendo Landing) → puede cambiar a cualquier plan superior
    if ($currentPlanId == 3) {
        return in_array($targetPlanId, [4, 5, 6]);
    }
    
    // Desde plan 4 (Arriendo Landing + Carrito) → puede cambiar a planes superiores
    if ($currentPlanId == 4) {
        return in_array($targetPlanId, [5, 6]);
    }
    
    // Desde plan 5 (Plan Básico) → puede cambiar a plan 6
    if ($currentPlanId == 5) {
        return $targetPlanId == 6;
    }
    
    // Si está en plan 6 → no puede cambiar (plan premium final)
    if ($currentPlanId == 6) {
        return false;
    }
    
    return false;
}

function isPlanRenewable($plan) {
    // Solo los planes con días > 0 son renovables
    // Los planes que contengan "free" en el nombre no se pueden renovar desde el admin
    return $plan->dias > 0 && stripos($plan->nombre, 'free') === false;
}
@endphp

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize carousel
    const carousel = document.getElementById('plansCarousel');
    const bsCarousel = new bootstrap.Carousel(carousel, {
        interval: false, // Disable auto-play
        wrap: true,
        keyboard: true
    });
    
    // Add touch/swipe support for mobile
    let startX = 0;
    let endX = 0;
    
    carousel.addEventListener('touchstart', function(e) {
        startX = e.touches[0].clientX;
    });
    
    carousel.addEventListener('touchend', function(e) {
        endX = e.changedTouches[0].clientX;
        handleSwipe();
    });
    
    function handleSwipe() {
        const threshold = 50; // Minimum swipe distance
        const diff = startX - endX;
        
        if (Math.abs(diff) > threshold) {
            if (diff > 0) {
                // Swipe left - next slide
                bsCarousel.next();
            } else {
                // Swipe right - previous slide
                bsCarousel.prev();
            }
        }
    }
    
    // Add smooth animation to plan cards
    const planCards = document.querySelectorAll('.plan-card');
    planCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Auto-focus on current plan when carousel loads
    const currentPlanCard = document.querySelector('.current-plan');
    if (currentPlanCard) {
        // Find which carousel item contains the current plan
        const carouselItem = currentPlanCard.closest('.carousel-item');
        if (carouselItem && !carouselItem.classList.contains('active')) {
            const slideIndex = Array.from(carouselItem.parentNode.children).indexOf(carouselItem);
            bsCarousel.to(slideIndex);
        }
    }
});
</script>

@endsection