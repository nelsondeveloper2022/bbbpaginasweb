@extends('layouts.dashboard')

@section('title', 'Personalizar tu Sitio Web - BBB Páginas Web')
@section('description', 'Aprende a personalizar y configurar tu landing page')

@section('content')
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="dashboard-title">
                <i class="bi bi-palette me-3"></i>
                Personalizar tu Sitio Web
            </h1>
            <p class="text-muted mb-0">Haz que tu sitio web refleje tu marca y personalidad</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('documentation.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-2"></i>
                Volver
            </a>
            @if(auth()->user()->bbbLanding)
                <a href="{{ route('landing.preview', auth()->user()->bbbLanding) }}" 
                   target="_blank" class="btn btn-success btn-sm">
                    <i class="bi bi-eye me-2"></i>
                    Ver mi Sitio
                </a>
            @endif
        </div>
    </div>
</div>

<!-- Estado del sitio web -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h6 class="mb-2">Estado de tu Sitio Web</h6>
                        @if(auth()->user()->bbbLanding)
                            @if(auth()->user()->bbbLanding->is_published)
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-success">Publicado</span>
                                    <span class="badge bg-info">
                                        {{ auth()->user()->bbbLanding->updated_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-muted mb-0">
                                    Tu sitio web está online en: 
                                    <a href="{{ auth()->user()->bbbLanding->getPublicUrl() }}" 
                                       target="_blank" class="text-decoration-none">
                                        {{ auth()->user()->bbbLanding->getPublicUrl() }}
                                    </a>
                                </p>
                            @else
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-warning">Borrador</span>
                                    <span class="badge bg-secondary">No publicado</span>
                                </div>
                                <p class="text-muted mb-0">
                                    Tu sitio web está listo pero aún no está publicado online
                                </p>
                            @endif
                        @else
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-secondary">Sin configurar</span>
                            </div>
                            <p class="text-muted mb-0">
                                Aún no has configurado tu sitio web. Completa tu perfil para generarlo automáticamente.
                            </p>
                        @endif
                    </div>
                    <div class="col-md-4 text-md-end">
                        @if(!auth()->user()->bbbLanding)
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>
                                Crear Sitio Web
                            </a>
                        @elseif(!auth()->user()->bbbLanding->is_published)
                            <a href="{{ route('documentation.publish-guide') }}" class="btn btn-success">
                                <i class="bi bi-globe me-2"></i>
                                Publicar Sitio
                            </a>
                        @else
                            <a href="{{ route('landing.edit', auth()->user()->bbbLanding) }}" class="btn btn-info">
                                <i class="bi bi-pencil me-2"></i>
                                Editar Sitio
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Elementos personalizables -->
<div class="row">
    <div class="col-12 mb-4">
        <h4>
            <i class="bi bi-sliders text-primary me-2"></i>
            Elementos que Puedes Personalizar
        </h4>
        <p class="text-muted">Tu sitio web se genera automáticamente, pero puedes personalizar estos elementos:</p>
    </div>

    <!-- Información básica -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle text-primary me-2"></i>
                    Información Básica
                </h6>
            </div>
            <div class="card-body">
                <div class="customization-item">
                    <div class="custom-icon">
                        <i class="bi bi-building text-success"></i>
                    </div>
                    <div class="custom-content">
                        <h6>Nombre de la Empresa</h6>
                        <p class="text-muted mb-1">Aparece como título principal</p>
                        <div class="custom-status">
                            @if(!empty(auth()->user()->empresa_nombre))
                                <span class="badge bg-success-soft text-success">
                                    {{ auth()->user()->empresa_nombre }}
                                </span>
                            @else
                                <span class="badge bg-warning">Pendiente</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="customization-item">
                    <div class="custom-icon">
                        <i class="bi bi-file-text text-info"></i>
                    </div>
                    <div class="custom-content">
                        <h6>Descripción del Negocio</h6>
                        <p class="text-muted mb-1">Texto principal que describe tu empresa</p>
                        <div class="custom-status">
                            @if(!empty(auth()->user()->empresa_descripcion))
                                <span class="badge bg-success-soft text-success">Configurada</span>
                            @else
                                <span class="badge bg-secondary">Opcional</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="customization-item">
                    <div class="custom-icon">
                        <i class="bi bi-link-45deg text-warning"></i>
                    </div>
                    <div class="custom-content">
                        <h6>URL del Sitio Web</h6>
                        <p class="text-muted mb-1">Se genera automáticamente del nombre de tu empresa</p>
                        <div class="custom-status">
                            @if(auth()->user()->bbbLanding)
                                <code class="small">{{ auth()->user()->bbbLanding->getPublicUrl() }}</code>
                            @else
                                <span class="badge bg-secondary">Se generará automáticamente</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil me-2"></i>
                        Editar Información
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Información de contacto -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-telephone text-success me-2"></i>
                    Información de Contacto
                </h6>
            </div>
            <div class="card-body">
                <div class="customization-item">
                    <div class="custom-icon">
                        <i class="bi bi-envelope text-primary"></i>
                    </div>
                    <div class="custom-content">
                        <h6>Email de Contacto</h6>
                        <p class="text-muted mb-1">Email principal para que te contacten</p>
                        <div class="custom-status">
                            @if(!empty(auth()->user()->empresa_email))
                                <span class="badge bg-success-soft text-success">
                                    {{ auth()->user()->empresa_email }}
                                </span>
                            @else
                                <span class="badge bg-warning">Requerido</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="customization-item">
                    <div class="custom-icon">
                        <i class="bi bi-telephone text-success"></i>
                    </div>
                    <div class="custom-content">
                        <h6>Teléfono de Contacto</h6>
                        <p class="text-muted mb-1">Número principal para llamadas</p>
                        <div class="custom-status">
                            @if(!empty(auth()->user()->empresa_telefono))
                                <span class="badge bg-success-soft text-success">
                                    {{ auth()->user()->empresa_telefono }}
                                </span>
                            @else
                                <span class="badge bg-warning">Requerido</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="customization-item">
                    <div class="custom-icon">
                        <i class="bi bi-whatsapp text-success"></i>
                    </div>
                    <div class="custom-content">
                        <h6>WhatsApp</h6>
                        <p class="text-muted mb-1">Se genera automáticamente desde tu teléfono</p>
                        <div class="custom-status">
                            @if(!empty(auth()->user()->empresa_telefono))
                                <span class="badge bg-success-soft text-success">Activo</span>
                            @else
                                <span class="badge bg-secondary">Requiere teléfono</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="customization-item">
                    <div class="custom-icon">
                        <i class="bi bi-geo-alt text-info"></i>
                    </div>
                    <div class="custom-content">
                        <h6>Dirección</h6>
                        <p class="text-muted mb-1">Ubicación física de tu negocio</p>
                        <div class="custom-status">
                            @if(!empty(auth()->user()->empresa_direccion))
                                <span class="badge bg-success-soft text-success">Configurada</span>
                            @else
                                <span class="badge bg-secondary">Opcional</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('profile.edit') }}" class="btn btn-success btn-sm">
                        <i class="bi bi-telephone me-2"></i>
                        Editar Contacto
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Características automáticas -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-magic text-warning me-2"></i>
                    Características Automáticas
                </h6>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">
                    Estas características se incluyen automáticamente en tu sitio web sin necesidad de configuración:
                </p>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-phone text-primary"></i>
                            </div>
                            <div class="feature-content">
                                <h6>Diseño Responsive</h6>
                                <p class="text-muted mb-0">Se adapta perfectamente a móviles, tablets y computadoras</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-shield-check text-success"></i>
                            </div>
                            <div class="feature-content">
                                <h6>Certificado SSL</h6>
                                <p class="text-muted mb-0">Sitio seguro con HTTPS automático</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-speedometer2 text-info"></i>
                            </div>
                            <div class="feature-content">
                                <h6>Carga Rápida</h6>
                                <p class="text-muted mb-0">Optimizado para velocidad y rendimiento</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-search text-warning"></i>
                            </div>
                            <div class="feature-content">
                                <h6>SEO Básico</h6>
                                <p class="text-muted mb-0">Configurado para aparecer en Google</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-whatsapp text-success"></i>
                            </div>
                            <div class="feature-content">
                                <h6>Botón de WhatsApp</h6>
                                <p class="text-muted mb-0">Contacto directo flotante en el sitio</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-palette text-secondary"></i>
                            </div>
                            <div class="feature-content">
                                <h6>Diseño Profesional</h6>
                                <p class="text-muted mb-0">Colores y tipografía profesional</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Próximas funciones -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-light">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-clock text-warning me-2"></i>
                    Próximas Funciones de Personalización
                </h6>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">
                    Estamos trabajando en estas funciones que estarán disponibles próximamente:
                </p>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="upcoming-feature">
                            <i class="bi bi-images text-primary mb-2"></i>
                            <h6>Galería de Imágenes</h6>
                            <p class="text-muted small mb-0">Sube y muestra fotos de tus productos o servicios</p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="upcoming-feature">
                            <i class="bi bi-palette text-info mb-2"></i>
                            <h6>Colores Personalizados</h6>
                            <p class="text-muted small mb-0">Elige los colores que representen tu marca</p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="upcoming-feature">
                            <i class="bi bi-file-earmark-text text-success mb-2"></i>
                            <h6>Páginas Adicionales</h6>
                            <p class="text-muted small mb-0">Crea páginas de servicios, sobre nosotros, etc.</p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="upcoming-feature">
                            <i class="bi bi-chat-square-text text-warning mb-2"></i>
                            <h6>Formulario de Contacto</h6>
                            <p class="text-muted small mb-0">Recibe mensajes directamente desde tu sitio</p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="upcoming-feature">
                            <i class="bi bi-share text-secondary mb-2"></i>
                            <h6>Redes Sociales</h6>
                            <p class="text-muted small mb-0">Enlaces a tus perfiles de redes sociales</p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="upcoming-feature">
                            <i class="bi bi-graph-up text-danger mb-2"></i>
                            <h6>Estadísticas</h6>
                            <p class="text-muted small mb-0">Ve cuántas personas visitan tu sitio</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <p class="text-muted mb-0">
                        ¿Tienes alguna función específica en mente? 
                        <a href="https://wa.me/{{ config('app.support.mobile') }}?text=Hola%2C%20me%20gustaría%20sugerir%20una%20función%20para%20BBB%20Páginas%20Web" 
                           target="_blank" class="text-decoration-none">
                            Cuéntanos por WhatsApp
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Consejos de personalización -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-lightbulb text-warning me-2"></i>
                    Consejos para un Sitio Web Exitoso
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="tip-card">
                            <div class="tip-icon">
                                <i class="bi bi-check-circle text-success"></i>
                            </div>
                            <div class="tip-content">
                                <h6>Información Clara y Completa</h6>
                                <p class="text-muted mb-0">
                                    Asegúrate de que todos los campos estén llenos con información precisa. 
                                    Los clientes necesitan saber exactamente qué haces y cómo contactarte.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="tip-card">
                            <div class="tip-icon">
                                <i class="bi bi-telephone text-primary"></i>
                            </div>
                            <div class="tip-content">
                                <h6>Facilita el Contacto</h6>
                                <p class="text-muted mb-0">
                                    El botón de WhatsApp es tu herramienta más poderosa. Asegúrate de que 
                                    tu número esté correcto y responde rápido a los mensajes.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="tip-card">
                            <div class="tip-icon">
                                <i class="bi bi-arrow-clockwise text-info"></i>
                            </div>
                            <div class="tip-content">
                                <h6>Mantén la Información Actualizada</h6>
                                <p class="text-muted mb-0">
                                    Revisa y actualiza tu información regularmente. Los cambios se reflejan 
                                    inmediatamente en tu sitio web publicado.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="tip-card">
                            <div class="tip-icon">
                                <i class="bi bi-share text-warning"></i>
                            </div>
                            <div class="tip-content">
                                <h6>Comparte tu Sitio Web</h6>
                                <p class="text-muted mb-0">
                                    Una vez publicado, comparte la URL en tus redes sociales, tarjetas de 
                                    presentación y materiales de marketing.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.customization-item,
.feature-item,
.tip-card {
    display: flex;
    align-items-flex-start;
    margin-bottom: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #eee;
}

.customization-item:last-child,
.feature-item:last-child,
.tip-card:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.custom-icon,
.feature-icon,
.tip-icon {
    flex-shrink: 0;
    margin-right: 1rem;
    margin-top: 0.25rem;
}

.custom-icon i,
.feature-icon i,
.tip-icon i {
    font-size: 1.5rem;
}

.custom-content,
.feature-content,
.tip-content {
    flex-grow: 1;
}

.custom-content h6,
.feature-content h6,
.tip-content h6 {
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.custom-status {
    margin-top: 0.5rem;
}

.upcoming-feature {
    text-align: center;
    padding: 1rem;
}

.upcoming-feature i {
    font-size: 2rem;
    display: block;
}

.upcoming-feature h6 {
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.badge.bg-success-soft {
    background-color: rgba(25, 135, 84, 0.1) !important;
    color: var(--bs-success) !important;
}
</style>
@endsection