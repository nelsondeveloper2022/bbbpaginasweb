@extends('layouts.dashboard')

@section('title', 'Checkout - ' . $plan->nombre)

@section('content')
<div class="container-fluid">
    <!-- Progress Bar -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="progress-container">
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <small class="text-muted">
                        <i class="bi bi-check-circle-fill text-success me-1"></i>
                        Plan Seleccionado
                    </small>
                    <small class="text-primary fw-bold">
                        <i class="bi bi-credit-card me-1"></i>
                        Checkout
                    </small>
                    <small class="text-muted">
                        <i class="bi bi-check-circle me-1"></i>
                        Confirmación
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Plan Summary -->
        <div class="col-lg-4 order-lg-2 mb-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-basket me-2"></i>
                        Resumen de Compra
                    </h5>
                </div>
                <div class="card-body">
                    <div class="plan-summary">
                        <div class="text-center mb-4">
                            <div class="plan-icon mb-3">
                                <i class="{{ $plan->icono ?? 'bi bi-star' }} fs-1 text-primary"></i>
                            </div>
                            <h4 class="plan-name">{{ $plan->nombre }}</h4>
                            @if($plan->destacado)
                                <span class="badge bg-primary mb-2">Más Popular</span>
                            @endif
                        </div>

                        <div class="plan-details mb-4">
                            <div class="row">
                                <div class="col-6">
                                    <strong>Precio:</strong>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="h5 text-primary">${{ number_format($plan->precioPesos, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <strong>Duración:</strong>
                                </div>
                                <div class="col-6 text-end">
                                    @if($plan->dias > 0)
                                        {{ $plan->dias }} días
                                    @else
                                        Permanente
                                    @endif
                                </div>
                            </div>
                            @if($plan->dias > 0)
                            <div class="row">
                                <div class="col-6">
                                    <strong>Vence:</strong>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="text-success">{{ now()->addDays($plan->dias)->format('d/m/Y') }}</span>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="border-top pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Total a Pagar:</h5>
                                <h4 class="mb-0 text-primary">${{ number_format($plan->precioPesos, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <div class="d-flex align-items-center justify-content-center">
                        <img src="https://wompi.co/images/logo.svg" alt="Wompi" height="24" class="me-2">
                        <small class="text-muted">Pago seguro con Wompi</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <div class="col-lg-8 order-lg-1">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-credit-card me-2"></i>
                        Información de Pago
                    </h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <h6 class="alert-heading">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Error en el proceso
                            </h6>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Wompi Checkout Widget -->
                    <div id="wompi-checkout-container">
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary mb-3" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <p class="text-muted">Cargando formulario de pago seguro...</p>
                        </div>
                    </div>

                    <!-- Alternative Payment Methods -->
                    <div class="mt-4">
                        <h6 class="text-muted mb-3">
                            <i class="bi bi-shield-check me-2"></i>
                            Métodos de pago aceptados:
                        </h6>
                        <div class="row g-2">
                            <div class="col-6 col-md-3">
                                <div class="payment-method-card text-center p-2 border rounded">
                                    <i class="bi bi-credit-card fs-4 text-primary"></i>
                                    <small class="d-block text-muted">Tarjetas</small>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="payment-method-card text-center p-2 border rounded">
                                    <i class="bi bi-phone fs-4 text-success"></i>
                                    <small class="d-block text-muted">Nequi</small>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="payment-method-card text-center p-2 border rounded">
                                    <i class="bi bi-bank fs-4 text-info"></i>
                                    <small class="d-block text-muted">PSE</small>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="payment-method-card text-center p-2 border rounded">
                                    <i class="bi bi-wallet2 fs-4 text-warning"></i>
                                    <small class="d-block text-muted">Daviplata</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Notice -->
                    <div class="alert alert-info mt-4" role="alert">
                        <div class="d-flex">
                            <i class="bi bi-shield-lock-fill fs-4 text-info me-3"></i>
                            <div>
                                <h6 class="alert-heading mb-2">Transacción Segura</h6>
                                <p class="mb-1">
                                    Tu información está protegida con encriptación SSL de 256 bits. 
                                    Wompi cumple con los estándares PCI DSS para máxima seguridad.
                                </p>
                                <small class="text-muted">
                                    No almacenamos información de tarjetas de crédito en nuestros servidores.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-4">
                <a href="{{ route('admin.plans.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>
                    Volver a Planes
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Wompi Checkout Script -->
<script src="https://checkout.wompi.co/widget.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuración del checkout de Wompi
    console.log('Initializing Wompi Admin with public key:', '{{ config("wompi.public_key") }}');
    console.log('Environment:', '{{ config("wompi.environment") }}');
    
    const checkout = new WidgetCheckout({
        currency: 'COP',
        amountInCents: {{ $amountInCents }}, // Monto en centavos
        reference: '{{ $reference }}',
        publicKey: '{{ config("wompi.public_key") }}',
        signature: {
            integrity: '{{ $signature }}'
        },
        redirectUrl: '{{ route("admin.plans.success") }}',
        customerData: {
            email: '{{ auth()->user()->email }}',
            fullName: '{{ trim((auth()->user()->nombres ?? auth()->user()->name) . " " . (auth()->user()->apellidos ?? "")) }}',
            phoneNumber: '{{ auth()->user()->celular ?? auth()->user()->movil ?? "3189696117" }}',
            phoneNumberPrefix: '+57',
            legalId: '{{ auth()->user()->documento ?? (1000000000 + auth()->user()->id) }}',
            legalIdType: 'CC'
        },
        shippingAddress: {
            addressLine1: '{{ auth()->user()->direccion ?? "Calle 123 # 45-67" }}',
            city: '{{ auth()->user()->ciudad ?? "Bogotá" }}',
            phoneNumber: '{{ auth()->user()->celular ?? auth()->user()->movil ?? "3189696117" }}',
            region: '{{ auth()->user()->departamento ?? "Cundinamarca" }}',
            country: 'CO'
        }
    });

    // Abrir el widget automáticamente
    checkout.open(function(result) {
        console.log('Resultado del pago:', result);
        
        if (result.transaction && result.transaction.status) {
            const status = result.transaction.status;
            
            if (status === 'APPROVED') {
                console.log('Pago aprobado:', result.transaction);
                showAlert('success', 'Pago Exitoso', 'Tu pago ha sido procesado correctamente.');
                
                // Redirigir después de un momento
                setTimeout(() => {
                    window.location.href = '{{ route("admin.plans.success") }}?reference=' + result.transaction.reference;
                }, 2000);
                
            } else if (status === 'DECLINED') {
                console.log('Pago rechazado:', result.transaction);
                showAlert('error', 'Pago Rechazado', 'Tu pago fue rechazado. Por favor verifica los datos e intenta nuevamente.');
                
            } else if (status === 'PENDING') {
                console.log('Pago pendiente:', result.transaction);
                showAlert('info', 'Pago Pendiente', 'Tu pago está siendo procesado. Te notificaremos cuando se complete.');
                
                // Redirigir a página de pendiente
                setTimeout(() => {
                    window.location.href = '{{ route("admin.plans.success") }}?reference=' + result.transaction.reference + '&status=pending';
                }, 2000);
            }
        } else {
            console.log('Widget cerrado sin completar pago');
        }
    });
});

function showAlert(type, title, message) {
    let alertClass, iconClass;
    
    switch(type) {
        case 'success':
            alertClass = 'alert-success';
            iconClass = 'bi-check-circle';
            break;
        case 'error':
            alertClass = 'alert-danger';
            iconClass = 'bi-exclamation-triangle';
            break;
        case 'info':
            alertClass = 'alert-info';
            iconClass = 'bi-info-circle';
            break;
        default:
            alertClass = 'alert-primary';
            iconClass = 'bi-info-circle';
    }
    
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            <i class="${iconClass} me-2"></i>
            <strong>${title}</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Insertar al inicio del container
    const container = document.querySelector('.container-fluid');
    container.insertAdjacentHTML('afterbegin', alertHtml);
}
</script>

<style>
.progress-container {
    margin-bottom: 2rem;
}

.plan-summary {
    font-size: 0.95rem;
}

.plan-icon {
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.plan-name {
    color: #2c3e50;
    font-weight: 600;
}

.plan-details .row {
    margin-bottom: 0.5rem;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.plan-details .row:last-child {
    border-bottom: none;
}

.payment-method-card {
    transition: all 0.2s ease;
    cursor: default;
}

.payment-method-card:hover {
    background-color: #f8f9fa;
    border-color: #007bff !important;
}

#wompi-checkout-container {
    min-height: 400px;
}

@media (max-width: 992px) {
    .sticky-top {
        position: relative !important;
        top: auto !important;
    }
}
</style>
@endsection