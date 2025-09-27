@extends('layouts.dashboard')

@section('title', 'Pago Exitoso')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-5">
                    <!-- Success Icon -->
                    <div class="success-icon mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                    </div>
                    
                    <!-- Success Message -->
                    <h1 class="h2 text-success mb-3">
                        ¡Pago Procesado Exitosamente!
                    </h1>
                    
                    <p class="lead text-muted mb-4">
                        Tu suscripción se activará automáticamente una vez que Wompi confirme tu pago.
                        Esto puede tomar unos minutos.
                    </p>
                    
                    <!-- Status Steps -->
                    <div class="row mb-5">
                        <div class="col-md-4 mb-3">
                            <div class="d-flex flex-column align-items-center">
                                <div class="step-circle bg-success text-white mb-2">
                                    <i class="bi bi-check-lg"></i>
                                </div>
                                <h6 class="text-success">Pago Enviado</h6>
                                <small class="text-muted">Tu pago ha sido procesado</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex flex-column align-items-center">
                                <div class="step-circle bg-warning text-white mb-2">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <h6 class="text-warning">Verificando</h6>
                                <small class="text-muted">Confirmando el pago</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex flex-column align-items-center">
                                <div class="step-circle bg-secondary text-white mb-2">
                                    <i class="bi bi-star"></i>
                                </div>
                                <h6 class="text-muted">Activación</h6>
                                <small class="text-muted">Plan será activado pronto</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Information Box -->
                    <div class="alert alert-info" role="alert">
                        <h6 class="alert-heading">
                            <i class="bi bi-info-circle me-2"></i>
                            ¿Qué sigue?
                        </h6>
                        <ul class="list-unstyled mb-0 text-start">
                            <li class="mb-2">
                                <i class="bi bi-check2 me-2 text-success"></i>
                                Recibirás un email de confirmación una vez que tu pago sea verificado
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check2 me-2 text-success"></i>
                                Tu plan se activará automáticamente
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check2 me-2 text-success"></i>
                                Podrás acceder a todas las funciones de la plataforma
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-house-door me-2"></i>
                            Ir al Dashboard
                        </a>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-person-gear me-2"></i>
                            Ver mi Perfil
                        </a>
                    </div>
                    
                    <!-- Support Section -->
                    <div class="mt-5 pt-4 border-top">
                        <p class="text-muted mb-2">
                            <i class="bi bi-headset me-2"></i>
                            ¿Necesitas ayuda o tienes alguna pregunta?
                        </p>
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <a href="mailto:{{ config('app.support.email') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-envelope me-1"></i>
                                Contactar Soporte
                            </a>
                            <a href="https://wa.me/{{ config('app.support.mobile') }}" class="btn btn-outline-success btn-sm" target="_blank">
                                <i class="bi bi-whatsapp me-1"></i>
                                WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.success-icon {
    animation: bounce 1s ease-in-out;
}

@keyframes bounce {
    0%, 20%, 53%, 80%, 100% {
        transform: translate3d(0,0,0);
    }
    40%, 43% {
        transform: translate3d(0, -15px, 0);
    }
    70% {
        transform: translate3d(0, -7px, 0);
    }
    90% {
        transform: translate3d(0, -2px, 0);
    }
}

.step-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    font-weight: bold;
}

@media (max-width: 768px) {
    .card-body {
        padding: 2rem 1rem !important;
    }
    
    .success-icon i {
        font-size: 4rem !important;
    }
    
    .d-flex.gap-3 {
        flex-direction: column;
        gap: 1rem !important;
    }
    
    .d-flex.gap-3 .btn {
        width: 100%;
    }
}
</style>

<script>
// Auto-refresh para verificar el estado del pago cada 30 segundos
let refreshInterval = setInterval(function() {
    // Verificar si el usuario ya tiene el plan activado
    fetch('{{ route("subscription.check-status") }}')
        .then(response => response.json())
        .then(data => {
            if (data.active) {
                clearInterval(refreshInterval);
                // Mostrar mensaje de éxito y redirigir
                showActivationSuccess();
            }
        })
        .catch(error => console.log('Error checking status:', error));
}, 30000); // 30 segundos

function showActivationSuccess() {
    // Actualizar la UI para mostrar que el plan está activo
    document.querySelector('.bg-warning').classList.replace('bg-warning', 'bg-success');
    document.querySelector('.text-warning').classList.replace('text-warning', 'text-success');
    document.querySelector('.bg-secondary').classList.replace('bg-secondary', 'bg-success');
    document.querySelector('.text-muted').classList.replace('text-muted', 'text-success');
    
    // Mostrar notificación
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-success alert-dismissible';
    alertDiv.innerHTML = `
        <strong>¡Excelente!</strong> Tu plan ha sido activado exitosamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.querySelector('.container-fluid').prepend(alertDiv);
}

// Limpiar interval cuando se salga de la página
window.addEventListener('beforeunload', function() {
    if (refreshInterval) {
        clearInterval(refreshInterval);
    }
});
</script>
@endsection