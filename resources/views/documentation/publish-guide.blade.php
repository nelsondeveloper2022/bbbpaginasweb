@extends('layouts.dashboard')

@section('title', 'Guía para Publicar tu Web - BBB Páginas Web')
@section('description', 'Paso a paso completo para publicar tu sitio web profesional con BBB Páginas Web')

@section('content')
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="dashboard-title">
                <i class="bi bi-globe me-3"></i>
                Cómo Publicar tu Sitio Web
            </h1>
            <p class="text-muted mb-0">Guía completa paso a paso</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('documentation.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-2"></i>
                Volver a Documentación
            </a>
            <a href="{{ route('landing.configurar') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-gear me-2"></i>
                Ir a Configuración
            </a>
        </div>
    </div>
</div>

<!-- Progreso del proceso -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">
                    <i class="bi bi-list-check me-2"></i>
                    Tu progreso para publicar
                </h5>
                <div class="progress-steps">
                    @php
                        $steps = [
                            [
                                'title' => 'Verificar Email',
                                'description' => 'Confirma tu dirección de correo',
                                'completed' => auth()->user()->isEmailVerified(),
                                'icon' => 'bi-envelope-check',
                                'route' => 'profile.edit'
                            ],
                            [
                                'title' => 'Completar Perfil',
                                'description' => 'Información personal y empresarial',
                                'completed' => auth()->user()->hasCompleteProfile(),
                                'icon' => 'bi-person-check',
                                'route' => 'profile.edit'
                            ],
                            [
                                'title' => 'Configurar Sitio Web',
                                'description' => 'Diseño, contenido y personalización',
                                'completed' => false, // TODO: Verificar si tiene landing configurada
                                'icon' => 'bi-palette',
                                'route' => 'landing.configurar'
                            ],
                            [
                                'title' => 'Publicar Online',
                                'description' => 'Tu sitio estará disponible en internet',
                                'completed' => false, // TODO: Verificar si está publicada
                                'icon' => 'bi-cloud-upload',
                                'route' => 'landing.configurar'
                            ]
                        ];
                    @endphp

                    <div class="row">
                        @foreach($steps as $index => $step)
                            <div class="col-md-3 mb-3">
                                <div class="step-item {{ $step['completed'] ? 'completed' : 'pending' }}">
                                    <div class="step-number">
                                        @if($step['completed'])
                                            <i class="bi bi-check-lg"></i>
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </div>
                                    <div class="step-content">
                                        <h6 class="step-title">{{ $step['title'] }}</h6>
                                        <p class="step-description">{{ $step['description'] }}</p>
                                        @if(!$step['completed'])
                                            <a href="{{ route($step['route']) }}" class="btn btn-sm btn-primary">
                                                <i class="{{ $step['icon'] }} me-1"></i>
                                                Completar
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pasos detallados -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-journal-text me-2"></i>
                    Guía Paso a Paso
                </h5>
            </div>
            <div class="card-body">
                <!-- Paso 1: Verificar Email -->
                <div class="guide-step mb-5">
                    <div class="d-flex align-items-start">
                        <div class="step-badge {{ auth()->user()->isEmailVerified() ? 'bg-success' : 'bg-warning' }}">
                            <i class="bi bi-envelope-check"></i>
                        </div>
                        <div class="step-content-detailed ms-3">
                            <h4 class="step-title-detailed">1. Verificar tu Email</h4>
                            @if(auth()->user()->isEmailVerified())
                                <div class="alert alert-success">
                                    <i class="bi bi-check-circle me-2"></i>
                                    ✅ Tu email está verificado
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    ⚠️ Tu email <strong>{{ auth()->user()->email }}</strong> necesita verificación
                                </div>
                                <div class="mb-3">
                                    <button onclick="sendVerificationEmail()" class="btn btn-warning">
                                        <i class="bi bi-envelope-plus me-2"></i>
                                        Enviar Email de Verificación
                                    </button>
                                </div>
                            @endif
                            <p class="text-muted">
                                La verificación de email es <strong>obligatoria</strong> para publicar tu sitio web. 
                                Esto garantiza la seguridad de tu cuenta y permite el envío de notificaciones importantes.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Paso 2: Completar Perfil -->
                <div class="guide-step mb-5">
                    <div class="d-flex align-items-start">
                        <div class="step-badge {{ auth()->user()->hasCompleteProfile() ? 'bg-success' : 'bg-primary' }}">
                            <i class="bi bi-person-check"></i>
                        </div>
                        <div class="step-content-detailed ms-3">
                            <h4 class="step-title-detailed">2. Completar tu Perfil</h4>
                            @if(auth()->user()->hasCompleteProfile())
                                <div class="alert alert-success">
                                    <i class="bi bi-check-circle me-2"></i>
                                    ✅ Tu perfil está completo
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Tu perfil está {{ auth()->user()->getProfileCompletion() }}% completo
                                </div>
                                <div class="mb-3">
                                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                        <i class="bi bi-person-gear me-2"></i>
                                        Completar Perfil
                                    </a>
                                </div>
                            @endif
                            <div class="completion-details">
                                <h6>Información requerida:</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="bi {{ auth()->user()->name ? 'bi-check-circle text-success' : 'bi-circle text-muted' }} me-2"></i>
                                        Nombre completo
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi {{ auth()->user()->empresa_nombre ? 'bi-check-circle text-success' : 'bi-circle text-muted' }} me-2"></i>
                                        Nombre de la empresa
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi {{ auth()->user()->empresa_email ? 'bi-check-circle text-success' : 'bi-circle text-muted' }} me-2"></i>
                                        Email corporativo
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi {{ auth()->user()->movil ? 'bi-check-circle text-success' : 'bi-circle text-muted' }} me-2"></i>
                                        Teléfono de contacto
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paso 3: Configurar Sitio Web -->
                <div class="guide-step mb-5">
                    <div class="d-flex align-items-start">
                        <div class="step-badge bg-info">
                            <i class="bi bi-palette"></i>
                        </div>
                        <div class="step-content-detailed ms-3">
                            <h4 class="step-title-detailed">3. Configurar tu Sitio Web</h4>
                            <p class="text-muted mb-3">
                                Personaliza el diseño, contenido y funcionalidades de tu página web.
                            </p>
                            <div class="mb-3">
                                <a href="{{ route('landing.configurar') }}" class="btn btn-info">
                                    <i class="bi bi-palette me-2"></i>
                                    Ir a Configuración
                                </a>
                            </div>
                            
                            <div class="config-options">
                                <h6>Opciones de personalización:</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-unstyled">
                                            <li class="mb-2">
                                                <i class="bi bi-palette me-2 text-info"></i>
                                                Diseño y colores
                                            </li>
                                            <li class="mb-2">
                                                <i class="bi bi-type me-2 text-info"></i>
                                                Tipografía y estilos
                                            </li>
                                            <li class="mb-2">
                                                <i class="bi bi-image me-2 text-info"></i>
                                                Imágenes y logotipos
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-unstyled">
                                            <li class="mb-2">
                                                <i class="bi bi-file-text me-2 text-info"></i>
                                                Contenido y textos
                                            </li>
                                            <li class="mb-2">
                                                <i class="bi bi-share me-2 text-info"></i>
                                                Redes sociales
                                            </li>
                                            <li class="mb-2">
                                                <i class="bi bi-envelope me-2 text-info"></i>
                                                Información de contacto
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paso 4: Publicar Online -->
                <div class="guide-step mb-5">
                    <div class="d-flex align-items-start">
                        <div class="step-badge bg-success">
                            <i class="bi bi-cloud-upload"></i>
                        </div>
                        <div class="step-content-detailed ms-3">
                            <h4 class="step-title-detailed">4. Publicar tu Sitio Web</h4>
                            <p class="text-muted mb-3">
                                Una vez completada la configuración, podrás publicar tu sitio web para que esté disponible en internet.
                            </p>
                            
                            <div class="publishing-info">
                                <h6>¿Qué sucede al publicar?</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="bi bi-globe me-2 text-success"></i>
                                        Tu sitio estará disponible 24/7 en internet
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi bi-link-45deg me-2 text-success"></i>
                                        Obtendrás una URL única para tu empresa
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi bi-phone me-2 text-success"></i>
                                        Optimizado para móviles y tablets
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi bi-shield-check me-2 text-success"></i>
                                        Certificado SSL incluido (conexión segura)
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tips adicionales -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card bg-light">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-lightbulb me-2"></i>
                    Tips para el Éxito
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Antes de publicar:</h6>
                        <ul>
                            <li>Revisa toda la información de contacto</li>
                            <li>Verifica que las imágenes se vean correctamente</li>
                            <li>Prueba todos los enlaces y botones</li>
                            <li>Asegúrate de que el contenido sea claro y atractivo</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">Después de publicar:</h6>
                        <ul>
                            <li>Comparte el enlace en tus redes sociales</li>
                            <li>Incluye la URL en tu firma de email</li>
                            <li>Actualiza tu información regularmente</li>
                            <li>Monitorea las visitas y contactos</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.progress-steps .step-item {
    text-align: center;
    position: relative;
}

.step-number {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    font-weight: bold;
    font-size: 1.2rem;
}

.step-item.completed .step-number {
    background: #28a745;
    color: white;
}

.step-item.pending .step-number {
    background: #6c757d;
    color: white;
}

.step-title {
    font-weight: 600;
    margin-bottom: 5px;
}

.step-description {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 10px;
}

.guide-step {
    border-left: 3px solid #e9ecef;
    padding-left: 0;
}

.step-badge {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.step-title-detailed {
    color: #333;
    margin-bottom: 15px;
}

.completion-details h6 {
    color: #666;
    margin-bottom: 10px;
}
</style>

<script>
// Función para enviar email de verificación (reutilizada del dashboard)
async function sendVerificationEmail() {
    const button = event.target;
    const originalText = button.innerHTML;
    
    button.disabled = true;
    button.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Enviando...';
    
    try {
        const response = await fetch('/email/send-verification', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            showNotification(data.message, 'success');
            button.innerHTML = '<i class="bi bi-check-circle me-2"></i> Email Enviado';
            button.classList.remove('btn-warning');
            button.classList.add('btn-success');
            
            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('btn-success');
                button.classList.add('btn-warning');
                button.disabled = false;
            }, 5000);
        } else {
            showNotification(data.message, 'error');
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