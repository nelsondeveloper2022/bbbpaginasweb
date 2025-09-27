@extends('layouts.landing')

@section('title')
{{ __('plans.payment_success_title') }} - BBB Páginas Web
@endsection

@section('content')
<div class="payment-result-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="payment-result-card success">
                    <div class="icon-container">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    
                    <h1 class="title">{{ __('plans.payment_success_title') }}</h1>
                    <p class="subtitle">{{ __('plans.payment_success_message') }}</p>
                    
                    @if(isset($carrito))
                    <div class="order-details">
                        <h3>{{ __('plans.order_details') }}</h3>
                        <div class="detail-row">
                            <span class="label">{{ __('plans.plan') }}:</span>
                            <span class="value">{{ $carrito->bbbPlan->nombre ?? 'N/A' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">{{ __('plans.customer') }}:</span>
                            <span class="value">{{ $carrito->nombrecontacto }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">{{ __('plans.email') }}:</span>
                            <span class="value">{{ $carrito->email }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">{{ __('plans.reference') }}:</span>
                            <span class="value">{{ $carrito->wompi_reference ?? 'N/A' }}</span>
                        </div>
                    </div>
                    @endif
                    
                    <div class="actions">
                        <a href="{{ route('landing.index', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">
                            {{ __('plans.back_to_home') }}
                        </a>
                        <a href="{{ route('plans.index', ['locale' => app()->getLocale()]) }}" class="btn btn-outline">
                            {{ __('plans.view_plans') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.payment-result-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 2rem 0;
    display: flex;
    align-items: center;
}

.payment-result-card {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    text-align: center;
    box-shadow: 0 20px 60px rgba(0,0,0,0.1);
}

.payment-result-card.success .icon-container {
    background: linear-gradient(135deg, #4CAF50, #45a049);
    color: white;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    font-size: 3rem;
}

.title {
    color: #2c3e50;
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.subtitle {
    color: #7f8c8d;
    font-size: 1.2rem;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.order-details {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 2rem;
    margin: 2rem 0;
    text-align: left;
}

.order-details h3 {
    color: #2c3e50;
    margin-bottom: 1.5rem;
    text-align: center;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e9ecef;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-row .label {
    font-weight: 600;
    color: #495057;
}

.detail-row .value {
    color: #2c3e50;
    font-weight: 500;
}

.actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn {
    padding: 1rem 2rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    color: white;
    text-decoration: none;
}

.btn-outline {
    border: 2px solid #667eea;
    color: #667eea;
    background: transparent;
}

.btn-outline:hover {
    background: #667eea;
    color: white;
    text-decoration: none;
}

@media (max-width: 768px) {
    .payment-result-card {
        padding: 2rem 1.5rem;
    }
    
    .title {
        font-size: 2rem;
    }
    
    .actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
    }
}
</style>
@endsection