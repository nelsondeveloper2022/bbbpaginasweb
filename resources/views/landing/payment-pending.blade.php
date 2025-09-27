@extends('layouts.landing')

@section('title')
{{ __('plans.payment_pending_title') }} - BBB Páginas Web
@endsection

@section('content')
<div class="payment-result-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="payment-result-card pending">
                    <div class="icon-container">
                        <i class="fas fa-clock"></i>
                    </div>
                    
                    <h1 class="title">{{ __('plans.payment_pending_title') }}</h1>
                    <p class="subtitle">{{ __('plans.payment_pending_message') }}</p>
                    
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
                        @if($carrito->wompi_reference)
                        <div class="detail-row">
                            <span class="label">{{ __('plans.reference') }}:</span>
                            <span class="value">{{ $carrito->wompi_reference }}</span>
                        </div>
                        @endif
                    </div>
                    @endif
                    
                    <div class="status-info">
                        <p>{{ __('plans.payment_pending_info') }}</p>
                    </div>
                    
                    <div class="actions">
                        <button id="check-status-btn" class="btn btn-primary">
                            {{ __('plans.check_status') }}
                        </button>
                        <a href="{{ route('landing.index', ['locale' => app()->getLocale()]) }}" class="btn btn-outline">
                            {{ __('plans.back_to_home') }}
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
    background: linear-gradient(135deg, #fdcb6e 0%, #e17055 100%);
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

.payment-result-card.pending .icon-container {
    background: linear-gradient(135deg, #f39c12, #e67e22);
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

.status-info {
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    border-radius: 10px;
    padding: 1.5rem;
    margin: 2rem 0;
    color: #856404;
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
    cursor: pointer;
    background: transparent;
}

.btn-primary {
    background: linear-gradient(135deg, #fdcb6e, #e17055);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(253, 203, 110, 0.3);
    color: white;
    text-decoration: none;
}

.btn-outline {
    border: 2px solid #fdcb6e;
    color: #fdcb6e;
    background: transparent;
}

.btn-outline:hover {
    background: #fdcb6e;
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkStatusBtn = document.getElementById('check-status-btn');
    
    @if(isset($carrito) && $carrito->wompi_transaction_id)
    checkStatusBtn.addEventListener('click', async function() {
        const btn = this;
        const originalText = btn.textContent;
        
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __("plans.checking_status") }}';
        
        try {
            const response = await fetch('/api/payments/wompi/status/{{ $carrito->wompi_transaction_id }}', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                if (data.status === 'APPROVED') {
                    window.location.href = '{{ route("payment.success", ["locale" => app()->getLocale()]) }}?ref={{ $carrito->wompi_reference }}';
                } else if (data.status === 'DECLINED') {
                    window.location.href = '{{ route("payment.error", ["locale" => app()->getLocale()]) }}?ref={{ $carrito->wompi_reference }}';
                } else {
                    // Aún pendiente, mostrar mensaje
                    alert('{{ __("plans.payment_still_pending") }}');
                }
            } else {
                alert('{{ __("plans.error_checking_status") }}');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('{{ __("plans.error_checking_status") }}');
        } finally {
            btn.disabled = false;
            btn.textContent = originalText;
        }
    });
    @else
    checkStatusBtn.style.display = 'none';
    @endif
});
</script>
@endsection