@extends('layouts.dashboard')

@section('title', 'Pago Exitoso')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Success Card -->
            <div class="card border-success shadow-lg">
                <div class="card-header bg-success text-white text-center py-4">
                    <div class="success-icon mb-3">
                        <i class="bi bi-check-circle-fill" style="font-size: 4rem;"></i>
                    </div>
                    <h2 class="mb-0">¡Pago Exitoso!</h2>
                    <p class="mb-0 opacity-75">Tu plan ha sido activado correctamente</p>
                </div>
                
                <div class="card-body p-5">
                    @if($renovacion)
                    <!-- Transaction Details -->
                    <div class="transaction-details mb-4">
                        <h4 class="text-center mb-4">Detalles de la Transacción</h4>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="text-muted small">Plan Adquirido:</label>
                                    <div class="fw-bold">{{ $renovacion->plan->nombre }}</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="text-muted small">Monto Pagado:</label>
                                    <div class="fw-bold text-success">
                                        ${{ number_format($renovacion->amount, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="text-muted small">Fecha de Pago:</label>
                                    <div class="fw-bold">{{ $renovacion->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="text-muted small">ID Transacción:</label>
                                    <div class="fw-bold font-monospace">{{ $renovacion->transaction_id }}</div>
                                </div>
                            </div>
                            
                            @if($renovacion->plan->dias > 0)
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="text-muted small">Duración:</label>
                                    <div class="fw-bold">{{ $renovacion->plan->dias }} días</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="text-muted small">Vigencia hasta:</label>
                                    <div class="fw-bold text-primary">
                                        {{ auth()->user()->trial_ends_at ? auth()->user()->trial_ends_at->format('d/m/Y H:i') : 'N/A' }}
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="col-12">
                                <div class="detail-item">
                                    <label class="text-muted small">Tipo de Plan:</label>
                                    <div class="fw-bold text-primary">
                                        <i class="bi bi-infinity me-1"></i>
                                        Acceso de por vida
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Plan Benefits -->
                    <div class="plan-benefits mb-4">
                        <h5 class="text-center mb-4">¿Qué puedes hacer ahora?</h5>
                        
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="benefit-card text-center p-3 bg-light rounded">
                                    <i class="bi bi-globe fs-2 text-primary mb-2"></i>
                                    <h6>Crear tu Landing</h6>
                                    <small class="text-muted">Diseña y personaliza tu página web</small>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="benefit-card text-center p-3 bg-light rounded">
                                    <i class="bi bi-graph-up fs-2 text-success mb-2"></i>
                                    <h6>Analytics</h6>
                                    <small class="text-muted">Monitorea el rendimiento de tu sitio</small>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="benefit-card text-center p-3 bg-light rounded">
                                    <i class="bi bi-headset fs-2 text-info mb-2"></i>
                                    <h6>Soporte</h6>
                                    <small class="text-muted">Acceso prioritario a ayuda técnica</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="action-buttons text-center">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-4">
                                <i class="bi bi-house-door me-2"></i>
                                Ir al Dashboard
                            </a>
                            
                            <a href="{{ route('admin.plans.index') }}" class="btn btn-outline-primary btn-lg px-4">
                                <i class="bi bi-credit-card me-2"></i>
                                Ver Mis Planes
                            </a>
                        </div>
                        
                        <div class="mt-4">
                            <a href="#" onclick="window.print()" class="btn btn-outline-secondary">
                                <i class="bi bi-printer me-2"></i>
                                Imprimir Recibo
                            </a>
                        </div>
                    </div>

                    <!-- Email Notification -->
                    <div class="alert alert-info mt-4" role="alert">
                        <i class="bi bi-envelope me-2"></i>
                        <strong>Confirmación por email:</strong> 
                        Hemos enviado los detalles de tu compra a <strong>{{ auth()->user()->email }}</strong>
                    </div>
                </div>
                
                <div class="card-footer bg-light text-center">
                    <div class="d-flex align-items-center justify-content-center">
                        <img src="https://wompi.co/images/logo.svg" alt="Wompi" height="20" class="me-2">
                        <small class="text-muted">Transacción procesada de forma segura por Wompi</small>
                    </div>
                </div>
            </div>

            <!-- Support Section -->
            <div class="text-center mt-4">
                <p class="text-muted">
                    ¿Tienes alguna pregunta sobre tu compra?
                    <a href="mailto:{{ config('app.support.email') }}" class="text-decoration-none">
                        Contáctanos
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
.success-icon {
    animation: checkmark 0.6s ease-in-out;
}

@keyframes checkmark {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    50% {
        transform: scale(1.2);
        opacity: 0.8;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.detail-item {
    padding: 0.75rem;
    border-radius: 0.375rem;
    background-color: #f8f9fa;
    height: 100%;
}

.detail-item label {
    font-weight: 500;
    margin-bottom: 0.25rem;
    display: block;
}

.benefit-card {
    transition: all 0.3s ease;
    height: 100%;
}

.benefit-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.transaction-details {
    border: 2px solid #e9ecef;
    border-radius: 0.5rem;
    padding: 2rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

@media print {
    .btn, .card-footer, .alert-info:last-child {
        display: none !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    
    .card-header {
        background: white !important;
        color: black !important;
    }
}

@media (max-width: 768px) {
    .card-body {
        padding: 2rem 1.5rem !important;
    }
    
    .transaction-details {
        padding: 1.5rem;
    }
    
    .success-icon i {
        font-size: 3rem !important;
    }
}
</style>

<!-- Auto-refresh user data script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar confetti si está disponible
    if (typeof confetti !== 'undefined') {
        confetti({
            particleCount: 100,
            spread: 70,
            origin: { y: 0.6 }
        });
    }
    
    // Auto scroll to top
    window.scrollTo(0, 0);
});
</script>

<!-- Confetti effect (opcional) -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
@endsection