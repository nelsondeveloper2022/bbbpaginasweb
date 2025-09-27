@extends('layouts.dashboard')

@section('title', 'Trial Expirado - BBB Páginas Web')
@section('description', 'Tu período de prueba ha finalizado')

@section('content')
<div class="container-fluid">
    <!-- Trial Expired Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-danger border-0 shadow-sm" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                <div class="d-flex align-items-center text-white">
                    <div class="me-4">
                        <i class="bi bi-clock-history" style="font-size: 3rem; opacity: 0.9;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h2 class="mb-2 text-white">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            Tu período gratuito de 15 días ha finalizado
                        </h2>
                        <p class="mb-0 fs-5" style="opacity: 0.95;">
                            Para continuar usando la plataforma debes adquirir un plan. 
                            Elige el que mejor se adapte a tus necesidades.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Limited Access Notice -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-shield-exclamation text-warning me-3" style="font-size: 2rem;"></i>
                        <div>
                            <h5 class="card-title text-warning mb-1">Acceso Limitado</h5>
                            <p class="card-text mb-0">
                                Actualmente solo puedes ver esta página y tu perfil. 
                                Para acceder a todas las funciones, adquiere un plan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Plans Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="text-center mb-4">
                <i class="bi bi-credit-card-2-front me-2 text-primary"></i>
                Planes Disponibles
            </h3>
        </div>
    </div>

    <!-- Plans Cards -->
    <div class="row justify-content-center">
        @foreach($plans as $plan)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 plan-card {{ $plan->destacado ? 'featured-plan' : '' }}">
                @if($plan->destacado)
                <div class="card-ribbon">
                    <span class="badge bg-primary">Más Popular</span>
                </div>
                @endif
                
                <div class="card-header text-center bg-transparent">
                    <div class="plan-icon mb-3">
                        <i class="{{ $plan->icono ?? 'bi bi-star' }} fs-1 text-primary"></i>
                    </div>
                    <h4 class="plan-title">{{ $plan->nombre }}</h4>
                    <div class="plan-price">
                        <span class="price-currency">$</span>
                        <span class="price-amount">{{ number_format($plan->precioPesos, 0, ',', '.') }}</span>
                        <span class="price-period">
                            @if($plan->idPlan == 3)
                                /3 meses
                            @else
                                /año
                            @endif
                        </span>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="plan-description">
                        {!! $plan->descripcion !!}
                    </div>
                </div>
                
                <div class="card-footer bg-transparent text-center">
                    <form action="{{ route('subscription.checkout') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $plan->idPlan }}">
                        <button type="submit" class="btn {{ $plan->destacado ? 'btn-primary' : 'btn-outline-primary' }} btn-lg w-100">
                            <i class="bi bi-credit-card me-2"></i>
                            Adquirir Plan
                        </button>
                    </form>
                    
                    <small class="text-muted d-block mt-2">
                        <i class="bi bi-shield-check me-1"></i>
                        Pago seguro con Wompi
                    </small>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Benefits Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 bg-light">
                <div class="card-body p-4">
                    <h5 class="text-center mb-4">
                        <i class="bi bi-star-fill text-warning me-2"></i>
                        ¿Por qué elegir BBB Páginas Web?
                    </h5>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-3 text-center">
                            <i class="bi bi-lightning-charge text-primary mb-2" style="font-size: 2rem;"></i>
                            <h6>Configuración Rápida</h6>
                            <small class="text-muted">Tu web lista en minutos</small>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3 text-center">
                            <i class="bi bi-palette text-success mb-2" style="font-size: 2rem;"></i>
                            <h6>Diseño Profesional</h6>
                            <small class="text-muted">Templates modernos y elegantes</small>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3 text-center">
                            <i class="bi bi-headset text-info mb-2" style="font-size: 2rem;"></i>
                            <h6>Soporte 24/7</h6>
                            <small class="text-muted">Ayuda cuando la necesites</small>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3 text-center">
                            <i class="bi bi-shield-check text-warning mb-2" style="font-size: 2rem;"></i>
                            <h6>Garantía Total</h6>
                            <small class="text-muted">30 días de garantía</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Support -->
    <div class="row mt-4">
        <div class="col-12 text-center">
            <div class="card border-0">
                <div class="card-body">
                    <h6 class="text-muted mb-3">
                        <i class="bi bi-question-circle me-2"></i>
                        ¿Necesitas ayuda para elegir tu plan?
                    </h6>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="mailto:{{ config('app.support.email') }}" class="btn btn-outline-primary">
                            <i class="bi bi-envelope me-2"></i>
                            Contactar por Email
                        </a>
                        <a href="https://wa.me/{{ config('app.support.mobile') }}" class="btn btn-outline-success" target="_blank">
                            <i class="bi bi-whatsapp me-2"></i>
                            Chat por WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Plan Cards Styling */
.plan-card {
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.plan-card:hover {
    border-color: #007bff;
    box-shadow: 0 10px 25px rgba(0,123,255,0.15);
    transform: translateY(-5px);
}

.featured-plan {
    border-color: #007bff;
    box-shadow: 0 5px 15px rgba(0,123,255,0.2);
    transform: scale(1.05);
}

.card-ribbon {
    position: absolute;
    top: 15px;
    right: -30px;
    transform: rotate(45deg);
    z-index: 1;
}

.card-ribbon .badge {
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
    font-size: 1.4rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.plan-price {
    margin-bottom: 1.5rem;
}

.price-currency {
    font-size: 1.1rem;
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
    margin-bottom: 1.5rem;
    color: #6c757d;
    line-height: 1.6;
    font-size: 0.95rem;
}

.plan-features {
    margin-bottom: 1.5rem;
}

.plan-features li {
    padding: 0.4rem 0;
    border-bottom: 1px solid #f8f9fa;
    font-size: 0.9rem;
}

.plan-features li:last-child {
    border-bottom: none;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .featured-plan {
        transform: none;
    }
    
    .price-amount {
        font-size: 2rem;
    }
    
    .plan-card {
        margin-bottom: 2rem;
    }
}

/* Animation for trial expired alert */
@keyframes slideInDown {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.alert {
    animation: slideInDown 0.5s ease-out;
}
</style>
@endsection