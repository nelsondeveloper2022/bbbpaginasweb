@extends('layouts.dashboard')

@section('title', 'Checkout - ' . $plan->nombre)

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Order Summary -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-credit-card me-2"></i>
                        Resumen de tu Compra
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-primary">{{ $plan->nombre }}</h5>
                            <div class="mb-3">
                                {!! $plan->descripcion !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light p-4 rounded">
                                <h6 class="text-muted mb-2">Cliente:</h6>
                                <p class="mb-1"><strong>{{ $user->name }}</strong></p>
                                <p class="mb-3 text-muted">{{ $user->email }}</p>
                                
                                <h6 class="text-muted mb-2">Empresa:</h6>
                                <p class="mb-4">{{ $user->empresa_nombre ?? 'No especificada' }}</p>
                                
                                <div class="border-top pt-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal:</span>
                                        <span>${{ number_format($plan->precioPesos, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>IVA (19%):</span>
                                        <span>${{ number_format($plan->precioPesos * 0.19, 0, ',', '.') }}</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <strong>Total:</strong>
                                        <strong class="text-primary">${{ number_format($plan->precioPesos, 0, ',', '.') }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-shield-check me-2"></i>
                        Método de Pago Seguro
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="https://comercios.wompi.co/widget/wompi-logo.png" alt="Wompi" height="40" class="mb-3">
                        <p class="text-muted">
                            Pago 100% seguro procesado por Wompi. 
                            Acepta tarjetas de crédito, débito, PSE y Nequi.
                        </p>
                    </div>

                    <!-- Wompi Checkout Button -->
                    <div class="d-grid gap-2">
                        <button id="wompi-checkout-btn" class="btn btn-primary btn-lg">
                            <i class="bi bi-credit-card me-2"></i>
                            Proceder al Pago - ${{ number_format($plan->precioPesos, 0, ',', '.') }}
                        </button>
                        
                        <a href="{{ route('subscription.plans') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>
                            Cambiar Plan
                        </a>
                    </div>

                    <!-- Security Info -->
                    <div class="row mt-4 text-center">
                        <div class="col-md-4">
                            <i class="bi bi-shield-lock text-success mb-2" style="font-size: 2rem;"></i>
                            <h6>Pago Seguro</h6>
                            <small class="text-muted">SSL 256-bit</small>
                        </div>
                        <div class="col-md-4">
                            <i class="bi bi-clock-history text-primary mb-2" style="font-size: 2rem;"></i>
                            <h6>Activación Inmediata</h6>
                            <small class="text-muted">Tu plan se activa automáticamente</small>
                        </div>
                        <div class="col-md-4">
                            <i class="bi bi-headset text-info mb-2" style="font-size: 2rem;"></i>
                            <h6>Soporte 24/7</h6>
                            <small class="text-muted">Ayuda cuando la necesites</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Wompi Checkout Widget -->
<script src="https://checkout.wompi.co/widget.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkoutButton = document.getElementById('wompi-checkout-btn');
    
    checkoutButton.addEventListener('click', function() {
        // Mostrar loading
        checkoutButton.disabled = true;
        checkoutButton.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>Procesando...';
        
        // Configurar el widget de Wompi
        const checkout = new WidgetCheckout({
            currency: '{{ $checkoutData["currency"] }}',
            amountInCents: {{ $checkoutData["amount_in_cents"] }},
            reference: '{{ $checkoutData["reference"] }}',
            publicKey: '{{ $checkoutData["public_key"] }}',
            redirectUrl: '{{ $checkoutData["redirect_url"] }}',
            customerData: {
                email: '{{ $checkoutData["customer_email"] }}',
                fullName: '{{ $checkoutData["customer_name"] }}'
            }
        });

        checkout.open(function (result) {
            var transaction = result.transaction;
            console.log('Transaction: ', transaction);
            
            if (transaction.status === 'APPROVED') {
                // Redirigir a página de éxito
                window.location.href = '{{ route("subscription.success") }}';
            } else if (transaction.status === 'DECLINED') {
                // Mostrar error
                alert('El pago fue rechazado. Por favor, intenta con otro método de pago.');
                resetButton();
            } else if (transaction.status === 'ERROR') {
                // Mostrar error
                alert('Ocurrió un error durante el procesamiento. Por favor, intenta de nuevo.');
                resetButton();
            }
        });
    });
    
    function resetButton() {
        checkoutButton.disabled = false;
        checkoutButton.innerHTML = '<i class="bi bi-credit-card me-2"></i>Proceder al Pago - ${{ number_format($plan->precioPesos, 0, ",", ".") }}';
    }
});
</script>

<style>
.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,.125);
}

.bg-light {
    background-color: #f8f9fa !important;
}

.text-primary {
    color: #007bff !important;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    padding: 12px 24px;
    font-weight: 600;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
}

@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
}
</style>
@endsection