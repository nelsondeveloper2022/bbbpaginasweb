@extends('layouts.dashboard')

@section('title', 'Planes de Suscripción')

@section('content')
<div class="container-fluid">
    @if($trialExpired)
    <!-- Trial Expired Alert -->
    <div class="alert alert-danger alert-dismissible mb-4">
        <div class="d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill me-3 fs-2"></i>
            <div class="flex-grow-1">
                <h4 class="alert-heading mb-2">
                    <i class="bi bi-clock-history me-2"></i>
                    Tu período gratuito de 15 días ha finalizado
                </h4>
                <p class="mb-3 fs-5">
                    Para continuar usando la plataforma y acceder a todas las funciones, 
                    debes adquirir uno de nuestros planes.
                </p>
                <div class="bg-light p-3 rounded">
                    <h6 class="text-primary mb-2">
                        <i class="bi bi-star-fill me-1"></i>
                        ¿Qué incluyen nuestros planes?
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Acceso completo al dashboard</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Configuración de tu landing page</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Publicación de tu sitio web</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Soporte técnico</li>
                    </ul>
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
                        Planes de Suscripción
                    </h1>
                    <p class="text-muted mb-0">Elige el plan que mejor se adapte a tus necesidades</p>
                </div>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver al Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Plans Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-grid-3x3-gap me-2"></i>
                        Planes Disponibles
                    </h5>
                </div>
                <div class="card-body p-4">
                    <!-- Desktop/Tablet Grid -->
                    <div class="row justify-content-center d-none d-md-flex">
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
                    <h3 class="plan-title">{{ $plan->nombre }}</h3>
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
                            Seleccionar Plan
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

                    <!-- Mobile Carousel -->
                    <div class="d-block d-md-none">
                        <div id="plansCarousel" class="carousel slide" data-bs-ride="carousel">
                            <!-- Indicators -->
                            <div class="carousel-indicators">
                                @foreach($plans as $index => $plan)
                                <button type="button" data-bs-target="#plansCarousel" data-bs-slide-to="{{ $index }}" 
                                        class="{{ $index === 0 ? 'active' : '' }}" 
                                        aria-current="{{ $index === 0 ? 'true' : 'false' }}" 
                                        aria-label="Plan {{ $index + 1 }}"></button>
                                @endforeach
                            </div>

                            <!-- Carousel Inner -->
                            <div class="carousel-inner">
                                @foreach($plans as $index => $plan)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <div class="px-3">
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
                                                <h3 class="plan-title">{{ $plan->nombre }}</h3>
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
                                                        Seleccionar Plan
                                                    </button>
                                                </form>
                                                
                                                <small class="text-muted d-block mt-2">
                                                    <i class="bi bi-shield-check me-1"></i>
                                                    Pago seguro con Wompi
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Controls -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#plansCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#plansCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Siguiente</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Information Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 bg-light">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">
                                <i class="bi bi-question-circle me-2"></i>
                                ¿Tienes dudas sobre los planes?
                            </h5>
                            <p class="text-muted mb-3">
                                Nuestro equipo está disponible para ayudarte a elegir el plan perfecto para tu negocio.
                            </p>
                            <a href="mailto:{{ config('app.support.email') }}" class="btn btn-outline-primary">
                                <i class="bi bi-envelope me-2"></i>
                                Contactar Soporte
                            </a>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-success mb-3">
                                <i class="bi bi-shield-check me-2"></i>
                                Garantía de Satisfacción
                            </h5>
                            <p class="text-muted mb-3">
                                Ofrecemos una garantía de 30 días. Si no estás satisfecho, te devolvemos tu dinero.
                            </p>
                            <ul class="list-unstyled text-muted small">
                                <li><i class="bi bi-check2 me-2 text-success"></i>Pagos 100% seguros</li>
                                <li><i class="bi bi-check2 me-2 text-success"></i>Soporte técnico incluido</li>
                                <li><i class="bi bi-check2 me-2 text-success"></i>Actualizaciones automáticas</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
    transform: translateY(-5px);
}

.featured-plan {
    border-color: #007bff;
    box-shadow: 0 5px 15px rgba(0,123,255,0.2);
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
    font-size: 3rem;
    font-weight: 700;
    color: #007bff;
    line-height: 1;
}

.price-period {
    font-size: 1rem;
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
    padding: 0.5rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.plan-features li:last-child {
    border-bottom: none;
}

/* Carousel Styles */
.carousel-indicators {
    margin-bottom: 1rem;
}

.carousel-indicators button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: rgba(0, 123, 255, 0.3);
    border: 0;
    margin: 0 4px;
}

.carousel-indicators button.active {
    background-color: #007bff;
}

.carousel-control-prev,
.carousel-control-next {
    width: 40px;
    height: 40px;
    background-color: rgba(0, 123, 255, 0.1);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    margin: 0 10px;
}

.carousel-control-prev:hover,
.carousel-control-next:hover {
    background-color: rgba(0, 123, 255, 0.2);
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    width: 20px;
    height: 20px;
    background-size: 100%, 100%;
}

.carousel-item {
    transition: transform 0.4s ease-in-out;
}

@media (max-width: 768px) {
    .price-amount {
        font-size: 2.5rem;
    }
    
    .plan-card {
        margin-bottom: 1rem;
        min-height: 450px;
    }
    
    /* Carousel specific mobile styles */
    .carousel-indicators {
        position: static;
        margin: 1rem 0;
    }
    
    .carousel-control-prev,
    .carousel-control-next {
        width: 35px;
        height: 35px;
    }
    
    .carousel-inner {
        padding: 0 10px;
    }
    
    /* Ensure cards have consistent height in mobile carousel */
    .carousel-item .plan-card {
        height: 100%;
        min-height: 480px;
    }
    
    .carousel-item .card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize carousel with auto-play disabled on mobile
    const carousel = document.getElementById('plansCarousel');
    if (carousel) {
        const bsCarousel = new bootstrap.Carousel(carousel, {
            interval: false, // Disable auto-play
            wrap: true,      // Enable infinite loop
            touch: true      // Enable touch/swipe
        });
        
        // Add touch support for better mobile experience
        let startX = 0;
        let startY = 0;
        
        carousel.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
        });
        
        carousel.addEventListener('touchend', function(e) {
            if (!startX || !startY) return;
            
            const endX = e.changedTouches[0].clientX;
            const endY = e.changedTouches[0].clientY;
            
            const diffX = startX - endX;
            const diffY = startY - endY;
            
            // Only trigger if horizontal swipe is more significant than vertical
            if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
                if (diffX > 0) {
                    bsCarousel.next();
                } else {
                    bsCarousel.prev();
                }
            }
            
            startX = 0;
            startY = 0;
        });
    }
});
</script>
@endpush
@endsection