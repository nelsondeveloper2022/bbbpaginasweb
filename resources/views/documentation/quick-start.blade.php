@extends('layouts.dashboard')

@section('title', 'Guía de Inicio Rápido - BBB Páginas Web')
@section('description', 'Configura tu cuenta y publica tu primera página web en minutos')

@section('content')
<!-- Header -->
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="dashboard-title">
                <i class="bi bi-rocket-takeoff me-3 text-success"></i>
                Inicio Rápido
            </h1>
            <p class="text-muted mb-0">Configura tu cuenta y publica tu web en 10 minutos</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.documentation.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver a Academy
            </a>
            <a href="{{ route('admin.landing.configurar') }}" class="btn btn-success">
                <i class="bi bi-rocket me-2"></i>
                Empezar ahora
            </a>
        </div>
    </div>
</div>

<!-- Cronómetro estimado -->
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-info border-0 shadow-sm">
            <div class="d-flex align-items-center">
                <i class="bi bi-clock-history fs-3 me-3"></i>
                <div>
                    <h5 class="alert-heading mb-1">Tiempo estimado: 5-10 minutos</h5>
                    <p class="mb-0">Sigue estos pasos en orden y tendrás tu sitio web publicado rápidamente</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lista de verificación rápida -->
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-list-check me-2"></i>
                    Lista de Verificación Rápida
                </h5>
            </div>
            <div class="card-body p-0">
                <!-- Paso 1: Email -->
                <div class="quick-step {{ auth()->user()->isEmailVerified() ? 'completed' : 'pending' }}">
                    <div class="step-content">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="step-icon {{ auth()->user()->isEmailVerified() ? 'completed' : 'pending' }}">
                                    @if(auth()->user()->isEmailVerified())
                                        <i class="bi bi-check-lg"></i>
                                    @else
                                        1
                                    @endif
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1">Verificar Email</h6>
                                    <small class="text-muted">Confirma {{ auth()->user()->email }}</small>
                                </div>
                            </div>
                            <div>
                                @if(auth()->user()->isEmailVerified())
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Completado
                                    </span>
                                @else
                                    <button onclick="sendVerificationEmail()" class="btn btn-warning btn-sm">
                                        <i class="bi bi-envelope-plus me-1"></i>
                                        Verificar
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paso 2: Información Básica -->
                <div class="quick-step {{ auth()->user()->name && auth()->user()->empresa_nombre ? 'completed' : 'pending' }}">
                    <div class="step-content">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="step-icon {{ auth()->user()->name && auth()->user()->empresa_nombre ? 'completed' : 'pending' }}">
                                    @if(auth()->user()->name && auth()->user()->empresa_nombre)
                                        <i class="bi bi-check-lg"></i>
                                    @else
                                        2
                                    @endif
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1">Información Básica</h6>
                                    <small class="text-muted">Nombre y empresa</small>
                                </div>
                            </div>
                            <div>
                                @if(auth()->user()->name && auth()->user()->empresa_nombre)
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Completado
                                    </span>
                                @else
                                    <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-person-gear me-1"></i>
                                        Completar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paso 3: Contacto -->
                <div class="quick-step {{ auth()->user()->movil && auth()->user()->empresa_email ? 'completed' : 'pending' }}">
                    <div class="step-content">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="step-icon {{ auth()->user()->movil && auth()->user()->empresa_email ? 'completed' : 'pending' }}">
                                    @if(auth()->user()->movil && auth()->user()->empresa_email)
                                        <i class="bi bi-check-lg"></i>
                                    @else
                                        3
                                    @endif
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1">Información de Contacto</h6>
                                    <small class="text-muted">Teléfono y email empresarial</small>
                                </div>
                            </div>
                            <div>
                                @if(auth()->user()->movil && auth()->user()->empresa_email)
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Completado
                                    </span>
                                @else
                                    <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-phone me-1"></i>
                                        Agregar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paso 4: Configurar Sitio -->
                <div class="quick-step pending">
                    <div class="step-content">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="step-icon pending">4</div>
                                <div class="ms-3">
                                    <h6 class="mb-1">Configurar Sitio Web</h6>
                                    <small class="text-muted">Diseño y contenido</small>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('landing.configurar') }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-palette me-1"></i>
                                    Configurar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paso 5: Publicar -->
                <div class="quick-step pending">
                    <div class="step-content">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="step-icon pending">5</div>
                                <div class="ms-3">
                                    <h6 class="mb-1">¡Publicar Online!</h6>
                                    <small class="text-muted">Tu sitio estará disponible 24/7</small>
                                </div>
                            </div>
                            <div>
                                <span class="badge bg-secondary">Pendiente</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel lateral con tips -->
    <div class="col-lg-4">
        <!-- Progreso general -->
        <div class="card mb-4">
            <div class="card-body text-center">
                @php
                    $totalSteps = 5;
                    $completedSteps = 0;
                    if(auth()->user()->isEmailVerified()) $completedSteps++;
                    if(auth()->user()->name && auth()->user()->empresa_nombre) $completedSteps++;
                    if(auth()->user()->movil && auth()->user()->empresa_email) $completedSteps++;
                    
                    $progressPercentage = ($completedSteps / $totalSteps) * 100;
                @endphp
                
                <div class="progress-circle mb-3">
                    <svg width="100" height="100">
                        <circle cx="50" cy="50" r="45" stroke="#e9ecef" stroke-width="6" fill="none"/>
                        <circle cx="50" cy="50" r="45" stroke="#28a745" stroke-width="6" fill="none"
                                stroke-dasharray="283" stroke-dashoffset="{{ 283 - (283 * $progressPercentage / 100) }}"
                                style="transform: rotate(-90deg); transform-origin: 50px 50px; transition: stroke-dashoffset 0.5s ease;"/>
                        <text x="50" y="55" text-anchor="middle" font-size="20" font-weight="bold" fill="#28a745">
                            {{ round($progressPercentage) }}%
                        </text>
                    </svg>
                </div>
                
                <h5 class="mb-2">{{ $completedSteps }} de {{ $totalSteps }} pasos</h5>
                <p class="text-muted small">
                    @if($completedSteps == 0)
                        ¡Empecemos! Verifica tu email primero
                    @elseif($completedSteps < 3)
                        Buen comienzo, completa tu perfil
                    @elseif($completedSteps < 5)
                        ¡Casi listo! Configura tu sitio web
                    @else
                        ¡Excelente! Ya puedes publicar
                    @endif
                </p>
            </div>
        </div>

        <!-- Tips rápidos -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-lightbulb me-2"></i>
                    Tips Rápidos
                </h6>
            </div>
            <div class="card-body">
                <div class="tip-item mb-3">
                    <div class="d-flex">
                        <i class="bi bi-shield-check text-success me-2 mt-1"></i>
                        <small>
                            <strong>Email verificado</strong> es obligatorio para publicar tu sitio
                        </small>
                    </div>
                </div>
                <div class="tip-item mb-3">
                    <div class="d-flex">
                        <i class="bi bi-phone text-info me-2 mt-1"></i>
                        <small>
                            <strong>Teléfono</strong> aparecerá en tu sitio para que te contacten
                        </small>
                    </div>
                </div>
                <div class="tip-item mb-3">
                    <div class="d-flex">
                        <i class="bi bi-palette text-warning me-2 mt-1"></i>
                        <small>
                            <strong>Personalización</strong> hace que tu sitio sea único
                        </small>
                    </div>
                </div>
                <div class="tip-item">
                    <div class="d-flex">
                        <i class="bi bi-globe text-primary me-2 mt-1"></i>
                        <small>
                            <strong>URL personalizada</strong> será bbbpaginasweb.com/{{ auth()->user()->empresa && auth()->user()->empresa->slug ? auth()->user()->empresa->slug : 'tuempresa' }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Soporte rápido -->
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="mb-2">
                    <i class="bi bi-headset me-2"></i>
                    ¿Necesitas ayuda?
                </h6>
                <p class="small mb-3">Nuestro equipo está listo para ayudarte en cualquier momento</p>
                <a href="https://wa.me/{{ config('app.support.mobile') }}?text=Hola%2C%20necesito%20ayuda%20con%20mi%20sitio%20web%20de%20{{ urlencode(auth()->user()->empresa_nombre ?? 'mi empresa') }}" 
                   target="_blank" class="btn btn-light btn-sm">
                    <i class="bi bi-whatsapp me-2"></i>
                    Contactar Soporte
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.quick-step {
    border-bottom: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.quick-step:last-child {
    border-bottom: none;
}

.quick-step.completed {
    background: rgba(40, 167, 69, 0.05);
}

.quick-step.pending:hover {
    background: rgba(0, 123, 255, 0.05);
}

.step-content {
    padding: 20px;
}

.step-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1rem;
}

.step-icon.completed {
    background: #28a745;
    color: white;
}

.step-icon.pending {
    background: #6c757d;
    color: white;
}

.progress-circle {
    position: relative;
}

.tip-item {
    padding: 8px 0;
}
</style>

<script>
async function sendVerificationEmail() {
    const button = event.target;
    const originalText = button.innerHTML;
    
    button.disabled = true;
    button.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Enviando...';
    
    try {
        const response = await fetch('/admin/email/send-verification', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            showNotification('Email de verificación enviado. Revisa tu bandeja de entrada.', 'success');
            button.innerHTML = '<i class="bi bi-check-circle me-2"></i> Enviado';
            button.classList.remove('btn-warning');
            button.classList.add('btn-success');
            
            // Actualizar la página después de 3 segundos para reflejar cambios
            setTimeout(() => {
                window.location.reload();
            }, 3000);
        } else {
            showNotification(data.message || 'Error al enviar el email', 'error');
            button.disabled = false;
            button.innerHTML = originalText;
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Error al enviar el email. Por favor intenta nuevamente.', 'error');
        button.disabled = false;
        button.innerHTML = originalText;
    }
}

function showNotification(message, type = 'info') {
    let container = document.getElementById('notification-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'notification-container';
        container.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
        `;
        document.body.appendChild(container);
    }
    
    const notification = document.createElement('div');
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'error' ? 'alert-danger' : 
                      type === 'warning' ? 'alert-warning' : 'alert-info';
    
    const icon = type === 'success' ? 'bi-check-circle' : 
                 type === 'error' ? 'bi-exclamation-triangle' : 
                 type === 'warning' ? 'bi-exclamation-triangle' : 'bi-info-circle';
    
    notification.className = `alert ${alertClass} alert-dismissible fade show shadow-lg`;
    notification.style.cssText = 'margin-bottom: 10px; animation: slideInRight 0.3s ease-out;';
    notification.innerHTML = `
        <i class="bi ${icon} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    container.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}
</script>
@endsection