@extends('layouts.dashboard')

@section('title', 'Planes y Pagos - BBB Páginas Web')
@section('description', 'Información sobre planes, precios y métodos de pago')

@section('content')
<!-- Header -->
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="dashboard-title">
                <i class="bi bi-credit-card me-3 text-warning"></i>
                Planes y Suscripciones
            </h1>
            <p class="text-muted mb-0">Todo lo que necesitas saber sobre nuestros planes</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.documentation.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver a Academy
            </a>
            <a href="{{ route('admin.plans.index') }}" class="btn btn-warning">
                <i class="bi bi-gem me-2"></i>
                Ver planes
            </a>
        </div>
    </div>
</div>

<!-- Estado actual del usuario -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h6 class="mb-2">Tu Plan Actual</h6>
                        @php
                            $currentPlan = auth()->user()->plan;
                            $trialEnd = auth()->user()->trial_ends_at;
                            $daysLeft = $trialEnd ? now()->diffInDays($trialEnd, false) : 0;
                            $isOnTrial = auth()->user()->isOnTrial();
                            $hasExpired = auth()->user()->currentPlanExpired();
                        @endphp

                        @if($currentPlan)
                            <div class="d-flex align-items-center gap-2 mb-2">
                                @if($isOnTrial)
                                    <span class="badge bg-primary">{{ $currentPlan->nombre }}</span>
                                    @if($daysLeft > 0)
                                        <span class="badge bg-success">{{ $daysLeft }} días restantes</span>
                                    @else
                                        <span class="badge bg-danger">Vencido</span>
                                    @endif
                                @elseif($hasExpired)
                                    <span class="badge bg-danger">{{ $currentPlan->nombre }} - Expirado</span>
                                @else
                                    <span class="badge bg-success">{{ $currentPlan->nombre }} - Activo</span>
                                @endif
                            </div>
                            
                            <div class="mb-2">
                                @if($currentPlan->descripcion)
                                    <small class="text-muted">{!! Str::limit(strip_tags($currentPlan->descripcion), 100) !!}</small>
                                @endif
                            </div>

                            <div class="plan-details">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted d-block">Precio:</small>
                                        @if($currentPlan->precioPesos > 0)
                                            <span class="fw-bold">${{ number_format($currentPlan->precioPesos, 0, ',', '.') }} COP</span>
                                            @if($currentPlan->preciosDolar > 0)
                                                <small class="text-muted">/ ${{ number_format($currentPlan->preciosDolar, 2) }} USD</small>
                                            @endif
                                        @else
                                            <span class="fw-bold text-success">Gratuito</span>
                                        @endif
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted d-block">Duración:</small>
                                        @if($currentPlan->dias > 0)
                                            <span class="fw-bold">{{ $currentPlan->dias }} días</span>
                                        @else
                                            <span class="fw-bold text-primary">Ilimitado</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($isOnTrial && $trialEnd)
                                <p class="text-muted mb-0 mt-2">
                                    <i class="bi bi-clock me-1"></i>
                                    @if($daysLeft > 0)
                                        Tienes acceso hasta el {{ $trialEnd->format('d/m/Y') }}
                                    @else
                                        Tu período de prueba venció el {{ $trialEnd->format('d/m/Y') }}
                                    @endif
                                </p>
                            @endif
                        @else
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-secondary">Sin Plan</span>
                            </div>
                            <p class="text-muted mb-0">
                                No tienes un plan asignado. Contacta al soporte para resolver este problema.
                            </p>
                        @endif
                    </div>
                    <div class="col-md-4 text-md-end">
                        @if($hasExpired)
                            <a href="{{ route('admin.plans.index') }}" class="btn btn-danger">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Renovar Plan
                            </a>
                        @elseif($isOnTrial && $daysLeft <= 3)
                            <a href="{{ route('admin.plans.index') }}" class="btn btn-warning">
                                <i class="bi bi-clock me-2"></i>
                                Renovar Antes de Vencer
                            </a>
                        @elseif($isOnTrial)
                            <a href="{{ route('admin.plans.index') }}" class="btn btn-primary">
                                <i class="bi bi-star me-2"></i>
                                Ver Planes Disponibles
                            </a>
                        @elseif($currentPlan && auth()->user()->hasFreePlan())
                            <a href="{{ route('admin.plans.index') }}" class="btn btn-success">
                                <i class="bi bi-arrow-up-circle me-2"></i>
                                Mejorar Plan
                            </a>
                        @else
                            <a href="{{ route('admin.plans.index') }}" class="btn btn-outline-primary">
                                <i class="bi bi-gear me-2"></i>
                                Gestionar Plan
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Planes disponibles -->
<div class="row mb-5">
    <div class="col-12">
        <h4 class="mb-4">
            <i class="bi bi-star text-primary me-2"></i>
            Planes Disponibles
        </h4>
    </div>

    @php
        $availablePlans = \App\Models\BbbPlan::orderBy('orden')->get();
        $userPlanId = auth()->user()->id_plan;
    @endphp

    @forelse($availablePlans as $plan)
    <div class="col-lg-4 mb-4">
        <div class="card h-100 {{ $plan->idPlan == $userPlanId ? 'border-primary' : '' }} {{ $plan->destacado ? 'shadow-lg' : '' }}">
            @if($plan->idPlan == $userPlanId)
                <div class="card-header bg-primary text-white text-center">
                    <small class="badge bg-light text-primary">Tu Plan Actual</small>
                </div>
            @elseif($plan->destacado)
                <div class="card-header bg-warning text-dark text-center">
                    <small class="badge bg-dark text-warning">Más Popular</small>
                </div>
            @endif
            
            <div class="card-body text-center">
                <div class="plan-icon mb-3">
                    <i class="{{ $plan->icono ?? 'bi bi-star' }} text-primary" style="font-size: 3rem;"></i>
                </div>
                <h5 class="card-title">{{ $plan->nombre }}</h5>
                <div class="price-display mb-4">
                    @if($plan->precioPesos > 0)
                        <span class="price-amount">${{ number_format($plan->precioPesos, 0, ',', '.') }}</span>
                        <span class="price-period">
                            @if($plan->dias > 0)
                                /{{ $plan->dias }} días
                            @else
                                permanente
                            @endif
                        </span>
                        @if($plan->preciosDolar > 0)
                            <div class="text-muted small mt-1">
                                ${{ number_format($plan->preciosDolar, 2) }} USD
                            </div>
                        @endif
                    @else
                        <span class="price-amount text-success">Gratuito</span>
                        @if($plan->dias > 0)
                            <span class="price-period">/{{ $plan->dias }} días</span>
                        @endif
                    @endif
                </div>
                
                @if($plan->descripcion)
                    <div class="plan-description text-muted mb-4">
                        {!! $plan->descripcion !!}
                    </div>
                @endif

                @if($plan->idPlan == $userPlanId)
                    <button class="btn btn-outline-primary w-100" disabled>
                        <i class="bi bi-check-circle me-2"></i>
                        Plan Actual
                    </button>
                @elseif($hasExpired || $isOnTrial)
                    <a href="{{ route('admin.plans.index') }}" class="btn btn-primary w-100">
                        <i class="bi bi-star me-2"></i>
                        Elegir Plan
                    </a>
                @else
                    <a href="{{ route('admin.plans.index') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-arrow-up-circle me-2"></i>
                        Cambiar Plan
                    </a>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle me-2"></i>
            No hay planes disponibles en este momento. Contacta al soporte para más información.
        </div>
    </div>
    @endforelse
</div>

<!-- Métodos de pago -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-wallet2 text-success me-2"></i>
                    Métodos de Pago
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <p class="mb-3">Aceptamos múltiples métodos de pago seguros:</p>
                        <div class="payment-methods">
                            <div class="payment-method">
                                <i class="bi bi-credit-card text-primary"></i>
                                <div class="method-info">
                                    <h6>Tarjetas de Crédito y Débito</h6>
                                    <p class="text-muted mb-0">Visa, Mastercard, American Express</p>
                                </div>
                            </div>
                            <div class="payment-method">
                                <i class="bi bi-bank text-info"></i>
                                <div class="method-info">
                                    <h6>PSE - Pagos Seguros en Línea</h6>
                                    <p class="text-muted mb-0">Débito directo desde tu cuenta bancaria</p>
                                </div>
                            </div>
                            <div class="payment-method">
                                <i class="bi bi-shop text-warning"></i>
                                <div class="method-info">
                                    <h6>Puntos de Pago Físicos</h6>
                                    <p class="text-muted mb-0">Efecty, Baloto, y otros corresponsales</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="bg-primary text-white rounded p-3 mb-3 d-inline-block">
                            <i class="bi bi-shield-check" style="font-size: 2rem;"></i>
                        </div>
                        <p class="text-muted small">
                            Pagos procesados de manera segura por Wompi
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preguntas frecuentes sobre pagos -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-question-circle text-info me-2"></i>
                    Preguntas Frecuentes sobre Pagos
                </h6>
            </div>
            <div class="card-body">
                <div class="accordion" id="paymentFaq">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#payment1">
                                ¿Cuándo se cobra mi plan?
                            </button>
                        </h2>
                        <div id="payment1" class="accordion-collapse collapse show" data-bs-parent="#paymentFaq">
                            <div class="accordion-body">
                                El cobro se realiza automáticamente cada mes en la misma fecha en que activaste tu plan. 
                                Te enviaremos un recordatorio por email 3 días antes del vencimiento.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#payment2">
                                ¿Puedo cambiar mi método de pago?
                            </button>
                        </h2>
                        <div id="payment2" class="accordion-collapse collapse" data-bs-parent="#paymentFaq">
                            <div class="accordion-body">
                                Sí, puedes actualizar tu método de pago en cualquier momento desde tu panel de control. 
                                Los cambios se aplicarán en el próximo ciclo de facturación.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#payment3">
                                ¿Qué pasa si mi pago falla?
                            </button>
                        </h2>
                        <div id="payment3" class="accordion-collapse collapse" data-bs-parent="#paymentFaq">
                            <div class="accordion-body">
                                Si tu pago falla, intentaremos procesar el cobro nuevamente en 3 días. Te notificaremos 
                                por email para que puedas actualizar tu método de pago. Después de 7 días sin pago exitoso, 
                                tu sitio web se suspenderá temporalmente.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#payment4">
                                ¿Puedo cancelar mi plan?
                            </button>
                        </h2>
                        <div id="payment4" class="accordion-collapse collapse" data-bs-parent="#paymentFaq">
                            <div class="accordion-body">
                                Sí, puedes cancelar tu plan en cualquier momento. La cancelación será efectiva al final 
                                del período de facturación actual. Tu sitio web permanecerá activo hasta esa fecha.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#payment5">
                                ¿Ofrecen descuentos por pago anual?
                            </button>
                        </h2>
                        <div id="payment5" class="accordion-collapse collapse" data-bs-parent="#paymentFaq">
                            <div class="accordion-body">
                                Actualmente solo ofrecemos planes mensuales, pero estamos trabajando en opciones de pago 
                                anual con descuentos especiales. Te notificaremos cuando estén disponibles.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Soporte para pagos -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h6 class="text-white mb-3">¿Necesitas ayuda con tu pago?</h6>
                <p class="mb-3 opacity-75">
                    Nuestro equipo de soporte está disponible para ayudarte con cualquier problema de pago
                </p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="https://wa.me/{{ config('app.support.mobile') }}?text=Hola%2C%20necesito%20ayuda%20con%20mi%20pago" 
                       target="_blank" class="btn btn-light">
                        <i class="bi bi-whatsapp me-2"></i>
                        WhatsApp
                    </a>
                    <a href="mailto:{{ config('app.support.email') }}" class="btn btn-outline-light">
                        <i class="bi bi-envelope me-2"></i>
                        Email
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.price-display {
    margin: 1.5rem 0;
}

.price-amount {
    font-size: 2.5rem;
    font-weight: bold;
    color: var(--bs-primary);
}

.price-period {
    font-size: 1rem;
    color: var(--bs-secondary);
}

.plan-icon {
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.payment-methods {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.payment-method {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.payment-method i {
    font-size: 2rem;
    width: 50px;
    text-align: center;
}

.method-info h6 {
    margin-bottom: 0.25rem;
    font-weight: 600;
}

.method-info p {
    font-size: 0.875rem;
}

@media (max-width: 768px) {
    .price-amount {
        font-size: 2rem;
    }
    
    .payment-method {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .payment-method i {
        width: auto;
    }
}
</style>
@endsection