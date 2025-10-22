@extends('layouts.dashboard')

@section('title', 'Configura tu Landing')
@section('description', 'Personaliza y configura tu página de aterrizaje')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4 header-landing-config">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">Configura tu Landing Page</h1>
                    <p class="text-muted">Personaliza el contenido y diseño de tu página de aterrizaje</p>
                    
                    @php
                        $empresa = auth()->user()->empresa;
                        $estadoLanding = $empresa->estado ?? 'sin_configurar';
                        
                        // Verificar si la información empresarial mínima está completa
                        $empresaCompleta = $empresa && 
                                          !empty($empresa->nombre) && 
                                          !empty($empresa->whatsapp);
                    @endphp

                    @if($landing->exists)
                        @if($estadoLanding === 'en_construccion')
                            <div class="mt-2">
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-tools me-1"></i>
                                    En Construcción
                                </span>
                                <small class="text-muted ms-2">Tu landing page se está configurando</small>
                            </div>
                        @elseif($estadoLanding === 'publicada')
                            <div class="mt-2">
                                <span class="badge bg-success">
                                    <i class="bi bi-globe me-1"></i>
                                    Publicada
                                </span>
                                <small class="text-muted ms-2">
                                    Disponible en: <a href="{{ route('public.landing', $empresa->slug) }}" target="_blank">{{ config('app.url') }}/{{ $empresa->slug }}</a>
                                </small>
                            </div>
                        @elseif($estadoLanding === 'vencida')
                            <div class="mt-2">
                                <span class="badge bg-danger">
                                    <i class="bi bi-clock-history me-1"></i>
                                    Vencida
                                </span>
                                <small class="text-muted ms-2">Tu landing page necesita renovación</small>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="d-flex gap-2 flex-wrap header-actions">
                    @if($landing->exists)
                        @if($estadoLanding !== 'en_construccion')
                            <a href="{{ route('admin.landing.preview') }}" class="btn btn-outline-secondary" target="_blank">
                                <i class="bi bi-eye me-1"></i>
                                Previsualizar
                            </a>
                        @endif
                    @endif
                    <button type="button" id="limpiar-autoguardado-btn" class="btn btn-outline-warning btn-sm" onclick="confirmarLimpiarAutoguardado()" style="display: none;" title="Limpiar datos guardados automáticamente">
                        <i class="bi bi-trash3 me-1"></i>
                        Limpiar Borradores
                    </button>
                    <button type="submit" form="landing-form-basico" class="btn btn-primary" id="guardar-btn-basico" {{ ($estadoLanding === 'en_construccion' || !$profileComplete) ? 'disabled' : '' }} style="display: none;">
                        <i class="bi bi-rocket me-1"></i>
                        {{ $estadoLanding === 'publicada' ? 'Actualizar' : 'Guardar y Publicar' }} (Básico)
                    </button>
                    <button type="submit" form="landing-form-avanzado" class="btn btn-primary" id="guardar-btn-avanzado-top" {{ ($estadoLanding === 'en_construccion' || !$profileComplete) ? 'disabled' : '' }} style="display: none;">
                        <i class="bi bi-rocket me-1"></i>
                        {{ $estadoLanding === 'publicada' ? 'Actualizar' : 'Guardar y Publicar' }} (Avanzado)
                    </button>
                    {{-- Botón de publicar separado ya no es necesario, se hace automáticamente
                    @if($landing->exists)
                        <button type="button" id="publicar-btn" class="btn btn-success" onclick="publishLanding()" {{ ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada' || !$profileComplete || !$empresaCompleta) ? 'disabled' : '' }}>
                            <i class="bi bi-rocket me-1"></i>
                            Publicar
                        </button>
                    @endif
                    --}}
                </div>
            </div>

            @if($landing->exists && $estadoLanding === 'en_construccion')
                <div class="construction-notice-permanent border-0 shadow-sm mb-4" role="status" data-construction-notice="permanent">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="bi bi-tools display-6 text-warning"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="alert-heading mb-2">
                                <i class="bi bi-info-circle me-2"></i>
                                Tu Landing Page está en construcción
                            </h4>
                            <p class="mb-2">
                                Hemos recibido tu configuración y estamos preparando tu landing page personalizada. 
                                Este proceso puede tomar hasta <strong>24 horas</strong>.
                            </p>
                            <hr class="my-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>¿Qué está pasando?</strong></p>
                                    <ul class="mb-0 small">
                                        <li>Generamos tu diseño personalizado</li>
                                        <li>Optimizamos tus imágenes y contenido</li>
                                        <li>Configuramos tu dominio único</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Mientras tanto:</strong></p>
                                    <ul class="mb-0 small">
                                        <li>Tu landing ya está disponible en tu URL</li>
                                        <li>Recibirás un email cuando esté lista</li>
                                        <li>No es necesario que hagas nada más</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- 🔹 Nuevo bloque de información empresarial -->
                            <div class="alert alert-info mt-4 p-3 border-0">
                                <i class="bi bi-building me-2"></i>
                                <strong>Recuerda:</strong> La información empresarial siempre estará disponible para ser modificada.  
                                Podrás actualizar en cualquier momento datos clave como tu información empresarial,  
                                <strong>información de contacto</strong> y <strong>redes sociales</strong>.
                            </div>

                            <!-- 🔹 Nuevo bloque de soporte para planes pagos -->
                            <div class="alert alert-success mt-3 p-3 border-0">
                                <i class="bi bi-whatsapp me-2"></i>
                                <strong>Soporte Premium:</strong>  
                                Si accedes a un <strong>plan de pago</strong>, podrás escribir a nuestro soporte por WhatsApp en caso de que  
                                <strong>los primeros textos entregados no sean de tu total agrado</strong>, y solicitar un cambio de forma rápida.
                            </div>

                            <div class="mt-3">
                                <a href="{{ $empresa->getLandingUrl() }}" class="btn btn-outline-warning btn-sm me-2" target="_blank">
                                    <i class="bi bi-globe me-1"></i>
                                    Ver mi Landing
                                </a>
                                <small class="text-muted">
                                    Tu URL: <strong>{{ $empresa->getLandingUrl() }}</strong>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

            @endif

            @if($landing->exists && $estadoLanding === 'publicada')
                <div class="alert alert-success border-0 shadow-sm mb-4" role="status">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="bi bi-check-circle display-6 text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="alert-heading mb-2">
                                <i class="bi bi-rocket me-2"></i>
                                ¡Tu Landing Page está publicada y activa!
                            </h4>
                            <p class="mb-2">
                                Tu landing page está funcionando perfectamente y recibiendo visitantes.
                            </p>
                            <hr class="my-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>¿Qué puedes modificar?</strong></p>
                                    <ul class="mb-0 small">
                                        <li><strong>Información Empresarial:</strong> Nombre, contacto, dirección</li>
                                        <li><strong>Redes Sociales:</strong> Enlaces y perfiles</li>
                                        <li><strong>Políticas y Términos:</strong> Documentos legales</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Importante:</strong></p>
                                    <ul class="mb-0 small">
                                        <li>El diseño y contenido están protegidos</li>
                                        <li>Los cambios empresariales se aplican inmediatamente</li>
                                        <li>Tu landing sigue funcionando normalmente</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="mt-3">
                                <a href="{{ $empresa->getLandingUrl() }}" class="btn btn-success btn-sm me-2" target="_blank">
                                    <i class="bi bi-globe me-1"></i>
                                    Ver mi Landing Publicada
                                </a>
                                <small class="text-muted">
                                    Tu URL: <strong>{{ $empresa->getLandingUrl() }}</strong>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Alerta para formulario completo -->
            <div id="formulario-completo-alert" class="alert alert-info border-0 shadow-sm mb-4" style="display: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;" role="alert">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-rocket-takeoff display-6 text-white"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h4 class="alert-heading mb-2 text-white">
                            <i class="bi bi-check-circle me-2"></i>
                            ¡Tu formulario está completo!
                        </h4>
                        <p class="mb-2">
                            Has completado todos los campos necesarios para tu landing page. 
                            <strong>Es muy importante que ahora hagas clic en "Publicar"</strong> para que tu landing esté disponible.
                        </p>
                        <hr class="my-3" style="border-color: rgba(255,255,255,0.3);">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <small class="text-white-50">
                                    <i class="bi bi-lightbulb me-1"></i>
                                    Una vez publicada, tu landing estará lista en 24 horas máximo
                                </small>
                            </div>
                            <button type="button" class="btn btn-light btn-sm" onclick="scrollToPublishButton()">
                                <i class="bi bi-arrow-up me-1"></i>
                                Ir a Publicar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            @if(!$profileComplete)
                <!-- Bloqueo por perfil incompleto -->
                <div class="alert alert-warning border-0 shadow-sm mb-4" style="position: relative;">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-shield-exclamation display-6 text-warning"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h4 class="alert-heading mb-2">
                                        <i class="bi bi-lock me-2"></i>
                                        Completa primero tu perfil antes de continuar
                                    </h4>
                                    <p class="mb-3">
                                        Para configurar tu landing page necesitas completar algunos datos básicos de tu perfil.
                                        Tu perfil está <strong>{{ $profileCompletion }}% completo</strong>.
                                        @if($profileCompletion >= 70)
                                            <span class="text-success">¡Ya casi está listo!</span>
                                        @endif
                                    </p>
                                    
                                    <!-- Barra de progreso -->
                                    <div class="progress mb-3" style="height: 8px;">
                                        <div class="progress-bar 
                                            @if($profileCompletion < 50) bg-danger
                                            @elseif($profileCompletion < 80) bg-warning  
                                            @else bg-success
                                            @endif" 
                                            role="progressbar" 
                                            style="width: {{ $profileCompletion }}%"
                                            aria-valuenow="{{ $profileCompletion }}" 
                                            aria-valuemin="0" 
                                            aria-valuemax="100">
                                        </div>
                                    </div>
                                    @if(!empty($profileDetails))
                                        <div class="mb-3">
                                            <h6 class="mb-2">Datos faltantes:</h6>
                                            <ul class="mb-0">
                                                @foreach($profileDetails as $detail)
                                                    <li class="mb-1">
                                                        <i class="{{ $detail['icon'] }} me-1 text-{{ $detail['type'] === 'critical' ? 'danger' : ($detail['type'] === 'warning' ? 'warning' : 'info') }}"></i>
                                                        {{ $detail['message'] }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <a href="{{ route('admin.profile.edit') }}" class="btn btn-warning btn-lg">
                                <i class="bi bi-person-gear me-2"></i>
                                Completar Perfil
                            </a>
                            @if($profileCompletion >= 80)
                                <div class="mt-2">
                                    <small class="text-success">
                                        <i class="bi bi-check-circle me-1"></i>
                                        ¡Solo te faltan algunos detalles!
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Overlay para bloquear el formulario -->
                <div class="profile-lock-overlay" style="position: relative; pointer-events: none; opacity: 0.6; padding: 20px;">
            @endif

            <!-- FORMULARIO PARA MODO BÁSICO -->
            <form id="landing-form-basico" action="{{ route('admin.landing.guardar') }}" method="POST" enctype="multipart/form-data" {{ !$profileComplete ? 'style=pointer-events:none;' : '' }} style="display: none;">
                @csrf
                <input type="hidden" name="modo_formulario" value="basico">

                <!-- Información Empresarial (Primero) -->
                <div id="seccion-empresa" class="mb-4">
                    <div class="row">
                        <div class="col-12">
                            <!-- Mensaje informativo -->
                            <div class="alert alert-info border-0 mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-info-circle me-3 fs-4"></i>
                                    <div>
                                        <h6 class="mb-1">Información Empresarial para tu Landing Page</h6>
                                        <p class="mb-0 small">Esta información se utilizará para personalizar tu landing page y asegurar que tenga toda la información legal requerida.</p>
                                    </div>
                                </div>
                            </div>

                            @if(!$empresaCompleta)
                            <!-- Mensaje de campos requeridos para publicar -->
                            <div class="alert alert-warning border-0 mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-exclamation-triangle me-3 fs-4"></i>
                                    <div>
                                        <h6 class="mb-1">
                                            <i class="bi bi-rocket me-2"></i>Campos requeridos para publicar
                                        </h6>
                                        <p class="mb-2 small">Para poder publicar tu landing page necesitas completar estos campos mínimos:</p>
                                        <ul class="mb-0 small">
                                            <li><strong>Nombre de la Empresa</strong> - Información básica de tu negocio</li>
                                            <li><strong>WhatsApp</strong> - Para que tus clientes puedan contactarte</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Tabs para Principiantes y Avanzados -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-3">
                                        <i class="bi bi-person-workspace text-primary me-2"></i>
                                        Configuración de Landing Page
                                    </h5>
                                    <!-- Navigation Tabs -->
                                    <ul class="nav nav-tabs card-header-tabs" id="configTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active text-black" 
                                                    id="principiantes-tab" 
                                                    data-bs-toggle="tab" 
                                                    data-bs-target="#principiantes" 
                                                    type="button" 
                                                    role="tab" 
                                                    aria-controls="principiantes" 
                                                    aria-selected="true">
                                                <i class="bi bi-emoji-smile me-2"></i>
                                                Para Principiantes
                                                <span class="badge bg-success ms-2 small">Recomendado</span>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link text-black" 
                                                    id="avanzados-tab" 
                                                    data-bs-toggle="tab" 
                                                    data-bs-target="#avanzados" 
                                                    type="button" 
                                                    role="tab" 
                                                    aria-controls="avanzados" 
                                                    aria-selected="false">
                                                <i class="bi bi-gear me-2"></i>
                                                Para Avanzados
                                                <span class="badge bg-warning ms-2 small">Más opciones</span>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <!-- Tab Content -->
                                    <div class="tab-content" id="configTabsContent">
                                        <!-- Tab Principiantes -->
                                        <div class="tab-pane fade show active" id="principiantes" role="tabpanel" aria-labelledby="principiantes-tab">
                                            <div class="alert alert-info border-0 mb-4">
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-lightbulb me-3 fs-4"></i>
                                                    <div>
                                                        <h6 class="mb-1">¡Perfecto para empezar! 🚀</h6>
                                                        <p class="mb-0 small">Solo necesitas completar los campos básicos para tener tu landing page lista.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Campos básicos -->
                                            <div class="row g-4">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Nombre de la Empresa <span class="text-danger">*</span></label>
                                                    <input type="text" 
                                                           class="form-control @error('empresa_nombre') is-invalid @enderror" 
                                                           name="empresa_nombre"
                                                           value="{{ old('empresa_nombre', $empresa->nombre ?? auth()->user()->empresa_nombre) }}"
                                                           placeholder="Mi Empresa"
                                                           required>
                                                    @error('empresa_nombre')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">WhatsApp <span class="text-danger">*</span></label>
                                                    <input type="tel" 
                                                           class="form-control @error('whatsapp') is-invalid @enderror" 
                                                           name="whatsapp"
                                                           value="{{ old('whatsapp', $empresa->whatsapp ?? '') }}"
                                                           placeholder="+57 300 123 4567"
                                                           required>
                                                    @error('whatsapp')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-bold">Título Principal <span class="text-danger">*</span></label>
                                                    <input type="text" 
                                                           class="form-control @error('titulo_principal') is-invalid @enderror" 
                                                           name="titulo_principal"
                                                           value="{{ old('titulo_principal', $landing->titulo_principal ?? '') }}"
                                                           placeholder="Tu título aquí"
                                                           required>
                                                    @error('titulo_principal')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-bold">
                                                        Descripción del negocio <span class="text-danger">*</span>
                                                        <small class="text-muted d-block mt-1">
                                                            Cuéntanos en detalle a qué se dedica tu empresa, qué ofreces y por qué te eligen tus clientes. 
                                                            Entre más completa sea esta descripción, mejor se verá tu landing y más fácil será conectar con tus visitantes.
                                                        </small>
                                                    </label>
                                                    <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                                              name="descripcion" 
                                                              rows="3" 
                                                              placeholder="Ejemplo: Somos una barbería moderna especializada en cortes y estilos personalizados..."
                                                              required>{{ old('descripcion', $landing->descripcion ?? '') }}</textarea>
                                                    @error('descripcion')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Campo objetivo oculto para formulario básico -->
                                            <input type="hidden" name="objetivo" value="{{ old('objetivo', $landing->objetivo ?? 'generar_contactos') }}">
                                            
                                            <!-- Email por defecto del usuario para formulario básico -->
                                            <input type="hidden" name="empresa_email" value="{{ old('empresa_email', $empresa->email ?? auth()->user()->email) }}">

                                            <!-- Secciones Opcionales -->
                                            
                                            <!-- Logo de la Empresa (Opcional) -->
                                            <div class="card mt-4 mb-4">
                                                <div class="card-header">
                                                    <h5 class="card-title mb-0">
                                                        <i class="bi bi-image text-primary me-2"></i>
                                                        Logo de la Empresa
                                                        <span class="badge bg-info ms-2">Opcional</span>
                                                    </h5>
                                                </div>
                                                <div class="card-body text-center">
                                                    <div class="logo-preview mb-3" id="logo-preview-simple">
                                                        <div class="logo-placeholder bg-light border-2 border-dashed border-secondary rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                                            <div class="text-center">
                                                                <i class="bi bi-image display-4 text-muted"></i>
                                                                <p class="text-muted mt-2 mb-0">Sube tu logo aquí</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="file" 
                                                           class="form-control @error('logo') is-invalid @enderror" 
                                                           id="logo-simple" 
                                                           name="logo"
                                                           accept="image/*" 
                                                           onchange="previewLogoSimple(event)">
                                                    @error('logo')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <small class="text-muted">Recomendado: PNG transparente, 300x100px</small>
                                                </div>
                                            </div>

                                            <!-- Imágenes Adicionales (Opcional) -->
                                            <div class="card mb-4">
                                                <div class="card-header">
                                                    <h5 class="card-title mb-0">
                                                        <i class="bi bi-images text-primary me-2"></i>
                                                        Imágenes Adicionales
                                                        <span class="badge bg-info ms-2">Opcional</span>
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="upload-zone border-2 border-dashed border-secondary rounded p-4 text-center" 
                                                        id="media-upload-zone-simple"
                                                        ondrop="handleDropSimple(event)" 
                                                        ondragover="handleDragOverSimple(event)"
                                                        ondragleave="handleDragLeaveSimple(event)">
                                                        <i class="bi bi-cloud-upload display-4 text-muted mb-3"></i>
                                                        <p class="mb-2">Arrastra y suelta imágenes aquí o</p>
                                                        <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('media-input-simple').click()">
                                                            Seleccionar Archivos
                                                        </button>
                                                        <input type="file" 
                                                               id="media-input-simple" 
                                                               class="d-none" 
                                                               multiple 
                                                               accept="image/*" 
                                                               onchange="handleFileSelectSimple(event)">
                                                        <small class="text-muted d-block mt-2">
                                                            Formatos: JPG, PNG, GIF, SVG, WEBP. Máx: 2MB por imagen
                                                        </small>
                                                    </div>
                                                    <!-- Gallery simple -->
                                                    <div id="media-gallery-simple" class="row g-3 mt-3">
                                                        <!-- Las imágenes se cargarán aquí dinámicamente -->
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Redes Sociales (Opcional) -->
                                            <div class="card mb-4">
                                                <div class="card-header">
                                                    <h5 class="card-title mb-0">
                                                        <i class="bi bi-share text-primary me-2"></i>
                                                        Redes Sociales
                                                        <span class="badge bg-info ms-2">Opcional</span>
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row g-3">
                                                        <!-- Facebook -->
                                                        <div class="col-md-6">
                                                            <label for="facebook-simple" class="form-label fw-bold">
                                                                <i class="bi bi-facebook me-2"></i>Facebook
                                                            </label>
                                                            <input type="url" 
                                                                   class="form-control @error('facebook') is-invalid @enderror" 
                                                                   id="facebook-simple" 
                                                                   name="facebook"
                                                                   value="{{ old('facebook', $empresa->facebook ?? '') }}"
                                                                   placeholder="https://facebook.com/tu-empresa">
                                                            @error('facebook')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <!-- Instagram -->
                                                        <div class="col-md-6">
                                                            <label for="instagram-simple" class="form-label fw-bold">
                                                                <i class="bi bi-instagram me-2"></i>Instagram
                                                            </label>
                                                            <input type="url" 
                                                                   class="form-control @error('instagram') is-invalid @enderror" 
                                                                   id="instagram-simple" 
                                                                   name="instagram"
                                                                   value="{{ old('instagram', $empresa->instagram ?? '') }}"
                                                                   placeholder="https://instagram.com/tu-empresa">
                                                            @error('instagram')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <!-- WhatsApp Business (adicional) -->
                                                        <div class="col-md-6">
                                                            <label for="whatsapp-business-simple" class="form-label fw-bold">
                                                                <i class="bi bi-whatsapp me-2"></i>WhatsApp Business
                                                            </label>
                                                            <input type="url" 
                                                                   class="form-control" 
                                                                   id="whatsapp-business-simple" 
                                                                   placeholder="https://wa.me/57300123456">
                                                        </div>
                                                        <!-- TikTok -->
                                                        <div class="col-md-6">
                                                            <label for="tiktok-simple" class="form-label fw-bold">
                                                                <i class="bi bi-tiktok me-2"></i>TikTok
                                                            </label>
                                                            <input type="url" 
                                                                   class="form-control @error('tiktok') is-invalid @enderror" 
                                                                   id="tiktok-simple" 
                                                                   name="tiktok"
                                                                   value="{{ old('tiktok', $empresa->tiktok ?? '') }}"
                                                                   placeholder="https://tiktok.com/@tu-empresa">
                                                            @error('tiktok')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Branding y Estilo (Opcional) -->
                                            <div class="card mb-4">
                                                <div class="card-header">
                                                    <h5 class="card-title mb-0">
                                                        <i class="bi bi-palette text-primary me-2"></i>
                                                        Branding y Estilo
                                                        <span class="badge bg-info ms-2">Opcional</span>
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row g-4">
                                                        <!-- Color Principal -->
                                                        <div class="col-md-6">
                                                            <label for="color_principal_simple" class="form-label fw-bold">Color Principal</label>
                                                            <div class="input-group">
                                                                <input type="color" 
                                                                       class="form-control form-control-color @error('color_principal') is-invalid @enderror" 
                                                                       id="color_principal_simple" 
                                                                       name="color_principal"
                                                                       value="{{ old('color_principal', $landing->color_principal ?? '#007bff') }}"
                                                                       title="Selecciona el color principal">
                                                                <input type="text" 
                                                                       class="form-control" 
                                                                       id="color_principal_simple_text" 
                                                                       value="{{ old('color_principal', $landing->color_principal ?? '#007bff') }}" 
                                                                       readonly>
                                                            </div>
                                                            <small class="text-muted">Color principal de tu marca</small>
                                                            @error('color_principal')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <!-- Color Secundario -->
                                                        <div class="col-md-6">
                                                            <label for="color_secundario_simple" class="form-label fw-bold">Color Secundario</label>
                                                            <div class="input-group">
                                                                <input type="color" 
                                                                       class="form-control form-control-color @error('color_secundario') is-invalid @enderror" 
                                                                       id="color_secundario_simple" 
                                                                       name="color_secundario"
                                                                       value="{{ old('color_secundario', $landing->color_secundario ?? '#6c757d') }}"
                                                                       title="Selecciona el color secundario">
                                                                <input type="text" 
                                                                       class="form-control" 
                                                                       id="color_secundario_simple_text" 
                                                                       value="{{ old('color_secundario', $landing->color_secundario ?? '#6c757d') }}" 
                                                                       readonly>
                                                            </div>
                                                            <small class="text-muted">Color secundario para acentos</small>
                                                            @error('color_secundario')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <!-- Estilo de Diseño -->
                                                        <div class="col-md-6">
                                                            <label for="estilo_simple" class="form-label fw-bold">Estilo de Diseño</label>
                                                            <select class="form-select @error('estilo') is-invalid @enderror" 
                                                                    id="estilo_simple" 
                                                                    name="estilo">
                                                                <option value="">Selecciona un estilo</option>
                                                                <option value="moderno" {{ old('estilo', $landing->estilo ?? '') == 'moderno' ? 'selected' : '' }}>Moderno</option>
                                                                <option value="clasico" {{ old('estilo', $landing->estilo ?? '') == 'clasico' ? 'selected' : '' }}>Clásico</option>
                                                                <option value="minimalista" {{ old('estilo', $landing->estilo ?? '') == 'minimalista' ? 'selected' : '' }}>Minimalista</option>
                                                                <option value="elegante" {{ old('estilo', $landing->estilo ?? '') == 'elegante' ? 'selected' : '' }}>Elegante</option>
                                                                <option value="divertido" {{ old('estilo', $landing->estilo ?? '') == 'divertido' ? 'selected' : '' }}>Divertido</option>
                                                            </select>
                                                            <small class="text-muted">Estilo general de tu landing</small>
                                                            @error('estilo')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <!-- Tipografía -->
                                                        <div class="col-md-6">
                                                            <label for="tipografia_simple" class="form-label fw-bold">Tipografía</label>
                                                            <select class="form-select @error('tipografia') is-invalid @enderror" 
                                                                    id="tipografia_simple" 
                                                                    name="tipografia">
                                                                <option value="">Selecciona una tipografía</option>
                                                                <option value="Arial, sans-serif" {{ old('tipografia', $landing->tipografia ?? '') == 'Arial, sans-serif' ? 'selected' : '' }}>Arial</option>
                                                                <option value="'Roboto', sans-serif" {{ old('tipografia', $landing->tipografia ?? '') == "'Roboto', sans-serif" ? 'selected' : '' }}>Roboto (Moderna)</option>
                                                                <option value="'Open Sans', sans-serif" {{ old('tipografia', $landing->tipografia ?? '') == "'Open Sans', sans-serif" ? 'selected' : '' }}>Open Sans (Limpia)</option>
                                                                <option value="'Montserrat', sans-serif" {{ old('tipografia', $landing->tipografia ?? '') == "'Montserrat', sans-serif" ? 'selected' : '' }}>Montserrat (Elegante)</option>
                                                                <option value="'Lato', sans-serif" {{ old('tipografia', $landing->tipografia ?? '') == "'Lato', sans-serif" ? 'selected' : '' }}>Lato (Amigable)</option>
                                                                <option value="Georgia, serif" {{ old('tipografia', $landing->tipografia ?? '') == 'Georgia, serif' ? 'selected' : '' }}>Georgia (Clásica)</option>
                                                            </select>
                                                            <small class="text-muted">Fuente para tu contenido</small>
                                                            @error('tipografia')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <!-- Vista previa de colores -->
                                                        <div class="col-12">
                                                            <label class="form-label fw-bold">Vista previa de colores</label>
                                                            <div class="d-flex gap-3 align-items-center p-3 border rounded">
                                                                <div class="d-flex align-items-center">
                                                                    <div id="color-preview-primary" class="rounded-circle me-2" style="width: 30px; height: 30px; background-color: #007bff;"></div>
                                                                    <span class="small">Principal</span>
                                                                </div>
                                                                <div class="d-flex align-items-center">
                                                                    <div id="color-preview-secondary" class="rounded-circle me-2" style="width: 30px; height: 30px; background-color: #6c757d;"></div>
                                                                    <span class="small">Secundario</span>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <div class="p-2 rounded text-white text-center" id="color-preview-sample" style="background: linear-gradient(135deg, #007bff, #6c757d);">
                                                                        Tu marca aquí
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-4">
                                                <button type="submit" class="btn btn-primary" id="submit-basico">
                                                    <i class="bi bi-save me-1"></i>
                                                    Guardar Configuración Básica
                                                </button>
                                                <button type="button" class="btn btn-outline-primary ms-2" onclick="switchToAdvanced()">
                                                    <i class="bi bi-gear me-1"></i>
                                                    Cambiar a Modo Avanzado
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
            </form>
            <!-- FIN FORMULARIO BÁSICO -->

            <!-- FORMULARIO PARA MODO AVANZADO -->
            <form id="landing-form-avanzado" action="{{ route('admin.landing.guardar') }}" method="POST" enctype="multipart/form-data" {{ !$profileComplete ? 'style=pointer-events:none;' : '' }} style="display: none;">
                @csrf
                <input type="hidden" name="modo_formulario" value="avanzado">
                
                <!-- Tabs para modo avanzado -->
                <div id="seccion-empresa-avanzada" class="mb-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="mb-0">
                                        <i class="bi bi-gear me-2"></i>
                                        Configuración Avanzada
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="configTabsContentAvanzado">
                                        <!-- Tab Avanzados -->
                                        <div class="tab-pane fade" id="avanzados" role="tabpanel" aria-labelledby="avanzados-tab">
                                            <div class="alert alert-warning border-0 mb-4">
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-tools me-3 fs-4"></i>
                                                    <div>
                                                        <h6 class="mb-1">Configuración Avanzada ⚙️</h6>
                                                        <p class="mb-0 small">Aquí tienes acceso a todas las opciones de personalización.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Información Empresarial -->
                            <div class="card mb-4 d-none" id="advanced-section-1">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-building text-primary me-2"></i>
                                        Información Empresarial
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-4">
                                        <!-- Nombre de la Empresa -->
                                        <div class="col-md-6">
                                            <label for="empresa_nombre" class="form-label fw-bold">Nombre de la Empresa <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                class="form-control @error('empresa_nombre') is-invalid @enderror" 
                                                id="empresa_nombre" 
                                                name="empresa_nombre" 
                                                value="{{ old('empresa_nombre', $empresa->nombre ?? auth()->user()->empresa_nombre) }}" 
                                                placeholder="Nombre de la empresa">
                                            @error('empresa_nombre')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Email Corporativo -->
                                        <div class="col-md-6">
                                            <label for="empresa_email" class="form-label fw-bold">Email Corporativo</label>
                                            <input type="email" 
                                                class="form-control @error('empresa_email') is-invalid @enderror" 
                                                id="empresa_email" 
                                                name="empresa_email" 
                                                value="{{ old('empresa_email', $empresa->email ?? auth()->user()->empresa_email) }}" 
                                                placeholder="info@empresa.com">
                                            @error('empresa_email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Teléfono Empresa -->
                                        <div class="col-md-6">
                                            <label for="empresa_movil" class="form-label fw-bold">Teléfono Empresa</label>
                                            <input type="tel" 
                                                class="form-control @error('empresa_movil') is-invalid @enderror" 
                                                id="empresa_movil" 
                                                name="empresa_movil" 
                                                value="{{ old('empresa_movil', $empresa->movil ?? '') }}" 
                                                placeholder="+57 300 123 4567">
                                            @error('empresa_movil')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- WhatsApp -->
                                        <div class="col-md-6">
                                            <label for="whatsapp" class="form-label fw-bold">WhatsApp <span class="text-danger">*</span></label>
                                            <input type="tel" 
                                                class="form-control @error('whatsapp') is-invalid @enderror" 
                                                id="whatsapp" 
                                                name="whatsapp" 
                                                value="{{ old('whatsapp', $empresa->whatsapp ?? '') }}" 
                                                placeholder="+57 300 123 4567">
                                            @error('whatsapp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Dirección -->
                                        <div class="col-12">
                                            <label for="empresa_direccion" class="form-label fw-bold">Dirección de la Empresa</label>
                                            <textarea class="form-control @error('empresa_direccion') is-invalid @enderror" 
                                                    id="empresa_direccion" 
                                                    name="empresa_direccion" 
                                                    rows="3"
                                                    placeholder="Dirección de la empresa">{{ old('empresa_direccion', $empresa->direccion ?? auth()->user()->empresa_direccion) }}</textarea>
                                            @error('empresa_direccion')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Website - Oculto temporalmente --}}
                                        {{-- 
                                        <div class="col-md-6">
                                            <label for="website" class="form-label fw-bold">Sitio Web</label>
                                            <div class="input-group">
                                                <span class="input-group-text">https://</span>
                                                <input type="text" 
                                                    class="form-control @error('website') is-invalid @enderror" 
                                                    id="website" 
                                                    name="website" 
                                                    value="{{ old('website', $empresa->website ?? '') }}" 
                                                    placeholder="www.empresa.com">
                                                @error('website')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <small class="text-muted">No incluyas "https://", se agregará automáticamente</small>
                                        </div>
                                        --}}
                                    </div>
                                </div>
                            </div>

                            <!-- Logo de la Empresa -->
                            <div class="card mb-4 d-none" id="advanced-section-2">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-image text-primary me-2"></i>
                                        Logo de la Empresa
                                        <span class="text-danger">*</span>
                                    </h5>
                                </div>
                                <div class="card-body text-center">
                                    <div class="logo-preview mb-3" id="logo-preview">
                                        @if($landing->logo_url)
                                            <img src="{{ $landing->logo_full_url }}" alt="Logo actual" class="img-fluid rounded" style="max-height: 150px;">
                                        @else
                                            <div class="logo-placeholder bg-light border-2 border-dashed border-secondary rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                                <div class="text-center">
                                                    <i class="bi bi-image display-4 text-muted"></i>
                                                    <p class="text-muted mt-2 mb-0">Sin logo</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" 
                                        class="form-control @error('logo') is-invalid @enderror" 
                                        id="logo" 
                                        name="logo" 
                                        accept="image/*"
                                        required
                                        onchange="previewLogo(event)">
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Recomendado: PNG transparente, 300x100px</small>
                                </div>
                            </div>

                            <!-- Imágenes Adicionales -->
                            <div class="card mb-4 d-none" id="advanced-section-3">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-images text-primary me-2"></i>
                                        Imágenes Adicionales
                                        @php
                                            // Verificar si ya hay imágenes cargadas
                                            $tieneImagenesExistentes = $landing->exists && $landing->media && $landing->media->count() > 0;
                                        @endphp
                                        @if(!$tieneImagenesExistentes)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="upload-zone border-2 border-dashed border-secondary rounded p-4 text-center" 
                                            id="media-upload-zone"
                                            ondrop="handleDrop(event)" 
                                            ondragover="handleDragOver(event)"
                                            ondragleave="handleDragLeave(event)">
                                            <i class="bi bi-cloud-upload display-4 text-muted mb-3"></i>
                                            <p class="mb-2">Arrastra y suelta imágenes aquí o</p>
                                            <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('media-input').click()">
                                                Seleccionar Archivos
                                            </button>
                                            <input type="file" 
                                                   id="media-input" 
                                                   class="d-none" 
                                                   multiple 
                                                   accept="image/*" 
                                                   {{ !$tieneImagenesExistentes ? 'required' : '' }} 
                                                   onchange="handleFileSelect(event)">
                                            <small class="text-muted d-block mt-2">
                                                @if(!$tieneImagenesExistentes)
                                                    <span class="text-danger fw-bold">* Requerido:</span> Sube al menos 1 imagen. 
                                                @else
                                                    <span class="text-info fw-bold">Opcional:</span> Puedes agregar más imágenes. 
                                                @endif
                                                Formatos: JPG, PNG, GIF, SVG, WEBP. Máx: 2MB por imagen
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Gallery de imágenes subidas -->
                                    <div id="media-gallery" class="row g-3">
                                        <!-- Las imágenes se cargarán aquí dinámicamente -->
                                    </div>
                                </div>
                            </div>

                            <!-- Redes Sociales -->
                            <div class="card mb-4 d-none" id="advanced-section-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-share text-primary me-2"></i>
                                        Redes Sociales
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-4">
                                        <!-- Facebook -->
                                        <div class="col-md-6">
                                            <label for="facebook" class="form-label fw-bold">
                                                <i class="bi bi-facebook me-2"></i>Facebook
                                            </label>
                                            <input type="url" 
                                                class="form-control @error('facebook') is-invalid @enderror" 
                                                id="facebook" 
                                                name="facebook" 
                                                value="{{ old('facebook', $empresa->facebook ?? '') }}" 
                                                placeholder="https://facebook.com/tu-empresa">
                                            @error('facebook')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Instagram -->
                                        <div class="col-md-6">
                                            <label for="instagram" class="form-label fw-bold">
                                                <i class="bi bi-instagram me-2"></i>Instagram
                                            </label>
                                            <input type="url" 
                                                class="form-control @error('instagram') is-invalid @enderror" 
                                                id="instagram" 
                                                name="instagram" 
                                                value="{{ old('instagram', $empresa->instagram ?? '') }}" 
                                                placeholder="https://instagram.com/tu-empresa">
                                            @error('instagram')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- LinkedIn -->
                                        <div class="col-md-6">
                                            <label for="linkedin" class="form-label fw-bold">
                                                <i class="bi bi-linkedin me-2"></i>LinkedIn
                                            </label>
                                            <input type="url" 
                                                class="form-control @error('linkedin') is-invalid @enderror" 
                                                id="linkedin" 
                                                name="linkedin" 
                                                value="{{ old('linkedin', $empresa->linkedin ?? '') }}" 
                                                placeholder="https://linkedin.com/company/tu-empresa">
                                            @error('linkedin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Twitter -->
                                        <div class="col-md-6">
                                            <label for="twitter" class="form-label fw-bold">
                                                <i class="bi bi-twitter me-2"></i>Twitter
                                            </label>
                                            <input type="url" 
                                                class="form-control @error('twitter') is-invalid @enderror" 
                                                id="twitter" 
                                                name="twitter" 
                                                value="{{ old('twitter', $empresa->twitter ?? '') }}" 
                                                placeholder="https://twitter.com/tu-empresa">
                                            @error('twitter')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- TikTok -->
                                        <div class="col-md-6">
                                            <label for="tiktok" class="form-label fw-bold">
                                                <i class="bi bi-tiktok me-2"></i>TikTok
                                            </label>
                                            <input type="url" 
                                                class="form-control @error('tiktok') is-invalid @enderror" 
                                                id="tiktok" 
                                                name="tiktok" 
                                                value="{{ old('tiktok', $empresa->tiktok ?? '') }}" 
                                                placeholder="https://tiktok.com/@tu-empresa">
                                            @error('tiktok')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- YouTube -->
                                        <div class="col-md-6">
                                            <label for="youtube" class="form-label fw-bold">
                                                <i class="bi bi-youtube me-2"></i>YouTube
                                            </label>
                                            <input type="url" 
                                                class="form-control @error('youtube') is-invalid @enderror" 
                                                id="youtube" 
                                                name="youtube" 
                                                value="{{ old('youtube', $empresa->youtube ?? '') }}" 
                                                placeholder="https://youtube.com/@tu-empresa">
                                            @error('youtube')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Documentos Legales -->
                            <div class="card mb-4 d-none" id="advanced-section-5">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-file-text text-primary me-2"></i>
                                        Documentos Legales
                                    </h5>
                                    <p class="small text-muted mt-2 mb-0">Información legal para tu sitio web</p>
                                </div>
                                <div class="card-body">
                                    <!-- Términos y Condiciones -->
                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label for="terminos_condiciones" class="form-label fw-bold">
                                                <i class="bi bi-file-text me-2"></i>Términos y Condiciones
                                                <span class="text-danger">*</span>
                                            </label>
                                            <button type="button" class="btn btn-outline-primary btn-sm" 
                                                    onclick="cargarTextoBase('terminos_condiciones')"
                                                    title="Cargar texto base para facilitar el llenado">
                                                <i class="bi bi-magic me-1"></i>
                                                Crear una base
                                            </button>
                                        </div>
                                        <div id="terminos_condiciones_editor" style="height: 200px;"></div>
                                        <textarea class="d-none @error('terminos_condiciones') is-invalid @enderror" 
                                                id="terminos_condiciones" 
                                                name="terminos_condiciones"
                                                required>{{ old('terminos_condiciones', $empresa->terminos_condiciones ?? '') }}</textarea>
                                        @error('terminos_condiciones')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Usa el editor de texto para formatear tus términos y condiciones con negritas, listas, títulos y más.
                                            <br><small class="text-muted">💡 Tip: Usa el botón "crear una base" para obtener un texto inicial que puedes personalizar.</small>
                                        </div>
                                    </div>

                                    <!-- Política de Privacidad -->
                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label for="politica_privacidad" class="form-label fw-bold">
                                                <i class="bi bi-shield-check me-2"></i>Política de Privacidad
                                                <span class="text-danger">*</span>
                                            </label>
                                            <button type="button" class="btn btn-outline-success btn-sm" 
                                                    onclick="cargarTextoBase('politica_privacidad')"
                                                    title="Cargar texto base para facilitar el llenado">
                                                <i class="bi bi-magic me-1"></i>
                                                Crear una base
                                            </button>
                                        </div>
                                        <div id="politica_privacidad_editor" style="height: 200px;"></div>
                                        <textarea class="d-none @error('politica_privacidad') is-invalid @enderror" 
                                                id="politica_privacidad" 
                                                name="politica_privacidad"
                                                required>{{ old('politica_privacidad', $empresa->politica_privacidad ?? '') }}</textarea>
                                        @error('politica_privacidad')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Usa el editor de texto para formatear tu política de privacidad con títulos, listas y formato profesional.
                                            <br><small class="text-muted">💡 Tip: Usa el botón "crear una base" para obtener un texto inicial que puedes personalizar.</small>
                                        </div>
                                    </div>

                                    <!-- Política de Cookies -->
                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label for="politica_cookies" class="form-label fw-bold">
                                                <i class="bi bi-cookie-bite me-2"></i>Política de Cookies
                                            </label>
                                            <button type="button" class="btn btn-outline-warning btn-sm" 
                                                    onclick="cargarTextoBase('politica_cookies')"
                                                    title="Cargar texto base para facilitar el llenado">
                                                <i class="bi bi-magic me-1"></i>
                                                Crear una base
                                            </button>
                                        </div>
                                        <div id="politica_cookies_editor" style="height: 200px;"></div>
                                        <textarea class="d-none @error('politica_cookies') is-invalid @enderror" 
                                                id="politica_cookies" 
                                                name="politica_cookies">{{ old('politica_cookies', $empresa->politica_cookies ?? '') }}</textarea>
                                        @error('politica_cookies')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Usa el editor de texto para explicar el uso de cookies con formato claro y profesional.
                                            <br><small class="text-muted">💡 Tip: Usa el botón "crear una base" para obtener un texto inicial que puedes personalizar.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenido y Diseño (Después) -->
                <div id="seccion-contenido" class="d-none">
                    <div class="row">
                            <!-- Columna Principal -->
                            <div class="col-lg-8">
                                <!-- Sección: URL Personalizada -->
                                <div class="card mb-4 {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'form-disabled-overlay' : '' }}">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="bi bi-globe text-primary me-2"></i>
                                            URL Personalizada
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="slug" class="form-label fw-bold">Tu URL única</label>
                                            <div class="input-group">
                                                <span class="input-group-text">{{ config('app.url') }}/</span>
                                                <input type="text" 
                                                    class="form-control @error('slug') is-invalid @enderror" 
                                                    id="slug" 
                                                    name="slug" 
                                                    value="{{ old('slug', $empresa->slug ?? '') }}"
                                                    placeholder="mi-empresa"
                                                    pattern="[a-z0-9\-]+"
                                                    title="Solo letras minúsculas, números y guiones"
                                                    {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}>
                                                @error('slug')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <small class="text-muted">
                                                Solo letras minúsculas, números y guiones. Ej: mi-empresa, empresa123
                                            </small>
                                        </div>

                                        <!-- Preview dinámico -->
                                        <div class="p-3 border rounded bg-light mb-2">
                                            <small class="d-block mb-1 fw-semibold text-primary">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Tu landing estará disponible en:
                                            </small>
                                            <div id="preview-url" class="fw-bold">
                                                {{ config('app.url') }}/{{ $empresa->slug ?? 'mi-empresa' }}
                                            </div>
                                        </div>

                                        <div class="p-3 border rounded bg-white shadow-sm">
                                            <small class="d-block mb-1 fw-semibold text-secondary">
                                                <i class="bi bi-globe2 me-1"></i>
                                                Si decides adquirir tu propio dominio, también podrás mostrar tu página así:
                                            </small>
                                            <div id="preview-domain" class="fw-bold text-dark">
                                                https://www.{{ $empresa->slug ?? 'mi-empresa' }}.com
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Sección: Objetivo y Audiencia -->
                                <div class="card mb-4 {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'form-disabled-overlay' : '' }}">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="bi bi-target text-primary me-2"></i>
                                            Objetivo y Audiencia
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="objetivo" class="form-label fw-bold">Objetivo Principal <span class="text-danger">*</span></label>
                                                <select class="form-select @error('objetivo') is-invalid @enderror" id="objetivo" name="objetivo" required {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}>
                                                    <option value="">Selecciona tu objetivo</option>
                                                    @foreach($objetivoOptions as $key => $value)
                                                        <option value="{{ $key }}" {{ old('objetivo', $landing->objetivo) == $key ? 'selected' : '' }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('objetivo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="descripcion_objetivo" class="form-label fw-bold">Descripción del Objetivo <span class="text-danger">*</span></label>
                                                <textarea class="form-control @error('descripcion_objetivo') is-invalid @enderror" 
                                                        id="descripcion_objetivo" 
                                                        name="descripcion_objetivo" 
                                                        rows="3"
                                                        placeholder="Describe más detalladamente tu objetivo..."
                                                        required
                                                        {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}>{{ old('descripcion_objetivo', $landing->descripcion_objetivo) }}</textarea>
                                                @error('descripcion_objetivo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="audiencia_descripcion" class="form-label fw-bold">Audiencia Objetivo</label>
                                            <textarea class="form-control @error('audiencia_descripcion') is-invalid @enderror" 
                                                    id="audiencia_descripcion" 
                                                    name="audiencia_descripcion" 
                                                    rows="3"
                                                    placeholder="Ej. Jóvenes de 20 a 30 años interesados en fitness, profesionales que buscan herramientas de productividad..."
                                                    {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}>{{ old('audiencia_descripcion', $landing->audiencia_descripcion) }}</textarea>
                                            @error('audiencia_descripcion')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="audiencia_problemas" class="form-label fw-bold">Problemas que Resuelves <span class="text-danger">*</span></label>
                                                <textarea class="form-control @error('audiencia_problemas') is-invalid @enderror" 
                                                        id="audiencia_problemas" 
                                                        name="audiencia_problemas" 
                                                        rows="4"
                                                        placeholder="¿Qué problemas o dolores tiene tu audiencia que tu producto/servicio puede resolver?"
                                                        required
                                                        {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}>{{ old('audiencia_problemas', $landing->audiencia_problemas) }}</textarea>
                                                @error('audiencia_problemas')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="audiencia_beneficios" class="form-label fw-bold">Beneficios que Ofreces <span class="text-danger">*</span></label>
                                                <textarea class="form-control @error('audiencia_beneficios') is-invalid @enderror" 
                                                        id="audiencia_beneficios" 
                                                        name="audiencia_beneficios" 
                                                        rows="4"
                                                        placeholder="¿Qué beneficios concretos obtiene tu audiencia al usar tu producto/servicio?"
                                                        required
                                                        {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}>{{ old('audiencia_beneficios', $landing->audiencia_beneficios) }}</textarea>
                                                @error('audiencia_beneficios')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sección: Contenido Textual -->
                                <div class="card mb-4 {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'form-disabled-overlay' : '' }}">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="bi bi-text-left text-primary me-2"></i>
                                            Contenido Textual
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="titulo_principal" class="form-label fw-bold">Título Principal <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                class="form-control @error('titulo_principal') is-invalid @enderror" 
                                                id="titulo_principal" 
                                                name="titulo_principal" 
                                                value="{{ old('titulo_principal', $landing->titulo_principal) }}"
                                                placeholder="Ej. Crea tu página web profesional en minutos"
                                                required
                                                {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}>
                                            @error('titulo_principal')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="subtitulo" class="form-label fw-bold">Subtítulo <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                class="form-control @error('subtitulo') is-invalid @enderror" 
                                                id="subtitulo" 
                                                name="subtitulo" 
                                                value="{{ old('subtitulo', $landing->subtitulo) }}"
                                                placeholder="Ej. Sin conocimientos técnicos, con diseños profesionales"
                                                required
                                                {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}>
                                            @error('subtitulo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="descripcion" class="form-label fw-bold">Descripción Principal <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                                    id="descripcion" 
                                                    name="descripcion" 
                                                    rows="4"
                                                    placeholder="Describe tu producto o servicio de manera atractiva y clara..."
                                                    required
                                                    {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}>{{ old('descripcion', $landing->descripcion) }}</textarea>
                                            @error('descripcion')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Sección de Imágenes Adicionales movida a Información Empresarial -->
                            </div>

                            <!-- Columna Lateral -->
                            <div class="col-lg-4">
                                <!-- CSS para fuentes de Google y estilos de vista previa -->
                                <style>
                                    /* Importar Google Fonts */
                                    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Open+Sans:wght@300;400;600;700&family=Montserrat:wght@300;400;500;600;700&family=Lato:wght@300;400;700&family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&family=Merriweather:wght@300;400;700&family=Source+Sans+Pro:wght@300;400;600;700&display=swap');
                                    
                                    /* Estilos para la vista previa de tipografía */
                                    #typography-preview-container {
                                        transition: all 0.3s ease;
                                    }
                                    
                                    #typography-preview-container h3,
                                    #typography-preview-container p,
                                    #typography-preview-container small {
                                        transition: font-family 0.2s ease;
                                        word-wrap: break-word;
                                        overflow-wrap: break-word;
                                    }

                                    /* Animación sutil al cambiar tipografía */
                                    .typography-preview {
                                        animation: fadeIn 0.3s ease;
                                    }

                                    @keyframes fadeIn {
                                        from { opacity: 0.7; }
                                        to { opacity: 1; }
                                    }

                                    /* Estilo para el input de texto de prueba */
                                    #typography-test-text {
                                        border: 2px solid #e9ecef;
                                        transition: border-color 0.2s ease;
                                    }

                                    #typography-test-text:focus {
                                        border-color: #007bff;
                                        box-shadow: 0 0 0 0.1rem rgba(0, 123, 255, 0.25);
                                    }
                                    
                                    
                                    /* Asegurar que las secciones se oculten/muestren correctamente */
                                    .form-section-hidden {
                                        display: none !important;
                                    }
                                    
                                    .form-section-visible {
                                        display: block !important;
                                    }
                                </style>

                                <!-- Script para actualizar dinámicamente -->
                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        const slugInput = document.getElementById("slug");
                                        const previewUrl = document.getElementById("preview-url");
                                        const previewDomain = document.getElementById("preview-domain");

                                        function updatePreviews() {
                                            let slug = slugInput.value.trim() || "mi-empresa";
                                            previewUrl.textContent = "{{ config('app.url') }}/" + slug;
                                            previewDomain.textContent = "https://www." + slug + ".com";
                                        }

                                        slugInput.addEventListener("input", updatePreviews);

                                        // inicializar al cargar la página
                                        updatePreviews();

                                        // Sistema de vista previa de tipografía
                                        const typographySelect = document.getElementById("tipografia");
                                        const testTextInput = document.getElementById("typography-test-text");
                                        const previewTitle = document.getElementById("preview-title");
                                        const previewParagraph = document.getElementById("preview-paragraph");
                                        const previewSmall = document.getElementById("preview-small");

                                        function updateTypographyPreview() {
                                            const selectedFont = typographySelect.value;
                                            const testText = testTextInput.value.trim() || "¡Bienvenidos a nuestra empresa!";

                                            // Aplicar la fuente seleccionada directamente
                                            if (selectedFont) {
                                                previewTitle.style.fontFamily = selectedFont;
                                                previewParagraph.style.fontFamily = selectedFont;
                                                previewSmall.style.fontFamily = selectedFont;
                                            } else {
                                                // Resetear a fuente por defecto
                                                previewTitle.style.fontFamily = '';
                                                previewParagraph.style.fontFamily = '';
                                                previewSmall.style.fontFamily = '';
                                            }

                                            // Actualizar el texto en todos los elementos de vista previa
                                            previewTitle.textContent = testText;
                                            previewParagraph.textContent = testText;
                                            previewSmall.textContent = testText;
                                        }

                                        // Event listeners para actualización en tiempo real
                                        if (typographySelect) {
                                            typographySelect.addEventListener("change", updateTypographyPreview);
                                        }
                                        
                                        if (testTextInput) {
                                            testTextInput.addEventListener("input", updateTypographyPreview);
                                            // También actualizar mientras el usuario escribe
                                            testTextInput.addEventListener("keyup", updateTypographyPreview);
                                        }

                                        // Inicializar vista previa al cargar la página
                                        updateTypographyPreview();
                                    });
                                </script>

                                <!-- Sección de Logo movida a Información Empresarial -->

                                <!-- Sección: Branding -->
                                <div class="card mb-4 {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'form-disabled-overlay' : '' }}">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="bi bi-palette text-primary me-2"></i>
                                            Branding y Estilo
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="color_principal" class="form-label fw-bold">Color Principal <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="color" 
                                                    class="form-control form-control-color @error('color_principal') is-invalid @enderror" 
                                                    id="color_principal" 
                                                    name="color_principal" 
                                                    value="{{ old('color_principal', $landing->color_principal ?: '') }}"
                                                    title="Selecciona el color principal"
                                                    required
                                                    {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}>
                                                <input type="text" 
                                                    class="form-control" 
                                                    value="{{ old('color_principal', $landing->color_principal ?: '') }}"
                                                    readonly>
                                            </div>
                                            @error('color_principal')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="color_secundario" class="form-label fw-bold">Color Secundario <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="color" 
                                                    class="form-control form-control-color @error('color_secundario') is-invalid @enderror" 
                                                    id="color_secundario" 
                                                    name="color_secundario" 
                                                    value="{{ old('color_secundario', $landing->color_secundario ?: '') }}"
                                                    title="Selecciona el color secundario"
                                                    required
                                                    {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}>
                                                <input type="text" 
                                                    class="form-control" 
                                                    value="{{ old('color_secundario', $landing->color_secundario ?: '') }}"
                                                    readonly>
                                            </div>
                                            @error('color_secundario')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="estilo" class="form-label fw-bold">Estilo de Diseño <span class="text-danger">*</span></label>
                                            <select class="form-select @error('estilo') is-invalid @enderror" id="estilo" name="estilo" required {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}>
                                                <option value="">Selecciona un estilo</option>
                                                @foreach($estiloOptions as $key => $value)
                                                    <option value="{{ $key }}" {{ old('estilo', $landing->estilo) == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('estilo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="tipografia" class="form-label fw-bold">Tipografía <span class="text-danger">*</span></label>
                                            <select class="form-select @error('tipografia') is-invalid @enderror" id="tipografia" name="tipografia" required {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}>
                                                <option value="">Selecciona una tipografía</option>
                                                <option value="Arial, sans-serif">Arial</option>
                                                <option value="'Helvetica Neue', Helvetica, sans-serif">Helvetica</option>
                                                <option value="'Times New Roman', Times, serif">Times New Roman</option>
                                                <option value="Georgia, serif">Georgia</option>
                                                <option value="'Courier New', Courier, monospace">Courier New</option>
                                                <option value="Verdana, sans-serif">Verdana</option>
                                                <option value="Tahoma, sans-serif">Tahoma</option>
                                                <option value="'Trebuchet MS', sans-serif">Trebuchet MS</option>
                                                <option value="Impact, sans-serif">Impact</option>
                                                <option value="'Comic Sans MS', cursive">Comic Sans MS</option>
                                                <option value="'Roboto', sans-serif">Roboto (Google Font)</option>
                                                <option value="'Open Sans', sans-serif">Open Sans (Google Font)</option>
                                                <option value="'Montserrat', sans-serif">Montserrat (Google Font)</option>
                                                <option value="'Lato', sans-serif">Lato (Google Font)</option>
                                                <option value="'Poppins', sans-serif">Poppins (Google Font)</option>
                                                <option value="'Playfair Display', serif">Playfair Display (Google Font)</option>
                                                <option value="'Merriweather', serif">Merriweather (Google Font)</option>
                                                <option value="'Source Sans Pro', sans-serif">Source Sans Pro (Google Font)</option>
                                                @foreach($tipografiaOptions as $key => $value)
                                                    <option value="{{ $key }}" {{ old('tipografia', $landing->tipografia) == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('tipografia')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            
                                            <!-- Vista previa de tipografía -->
                                            <div class="mt-3">
                                                <label class="form-label fw-bold text-muted small">
                                                    <i class="bi bi-eye me-1"></i>Vista previa de tipografía
                                                </label>
                                                <div class="card border-light bg-light" style="min-height: 200px;">
                                                    <div class="card-body p-3">
                                                        <!-- Campo de texto personalizable -->
                                                        <div class="mb-3">
                                                            <input type="text" 
                                                                class="form-control" 
                                                                id="typography-test-text" 
                                                                placeholder="Escribe aquí tu texto de prueba..."
                                                                value="¡Bienvenidos a nuestra empresa!"
                                                                maxlength="100"
                                                                {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}>
                                                            <small class="text-muted">Escribe hasta 100 caracteres para probar la tipografía</small>
                                                        </div>

                                                        <!-- Vista previa con diferentes tamaños -->
                                                        <div class="typography-preview p-3 border rounded bg-white" id="typography-preview-container" style="min-height: 120px;">
                                                            <!-- Título grande -->
                                                            <div class="mb-2">
                                                                <h3 class="mb-1" id="preview-title" style="font-size: 1.75rem; font-weight: 600; line-height: 1.2;">
                                                                    ¡Bienvenidos a nuestra empresa!
                                                                </h3>
                                                                <small class="text-muted">Título principal</small>
                                                            </div>
                                                            
                                                            <!-- Texto párrafo -->
                                                            <div class="mb-2">
                                                                <p class="mb-1" id="preview-paragraph" style="font-size: 1rem; line-height: 1.5;">
                                                                    ¡Bienvenidos a nuestra empresa!
                                                                </p>
                                                                <small class="text-muted">Texto de párrafo</small>
                                                            </div>

                                                            <!-- Texto pequeño -->
                                                            <div>
                                                                <small id="preview-small" style="font-size: 0.85rem; line-height: 1.4;">
                                                                    ¡Bienvenidos a nuestra empresa!
                                                                </small>
                                                                <br><small class="text-muted">Texto pequeño</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Botones de Acción al Final del Formulario -->
                <div class="card shadow-sm border-0 mt-4 sticky-bottom-actions">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div>
                                <h6 class="mb-1 fw-bold">¿Listo para continuar?</h6>
                                <small class="text-muted">Guarda tus cambios o publica tu landing page</small>
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                @if($landing->exists)
                                    @if($estadoLanding !== 'en_construccion')
                                        <a href="{{ route('admin.landing.preview') }}" class="btn btn-outline-secondary" target="_blank">
                                            <i class="bi bi-eye me-1"></i>
                                            Previsualizar
                                        </a>
                                    @endif
                                @endif
                                <button type="submit" class="btn btn-primary" id="guardar-btn-avanzado" {{ ($estadoLanding === 'en_construccion' || !$profileComplete) ? 'disabled' : '' }}>
                                    <i class="bi bi-rocket me-1"></i>
                                    {{ $estadoLanding === 'publicada' ? 'Actualizar' : 'Guardar y Publicar' }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary ms-2" onclick="switchToBasic()">
                                    <i class="bi bi-arrow-left me-1"></i>
                                    Volver a Modo Básico
                                </button>
                                {{-- Botón de publicar separado ya no es necesario, se hace automáticamente
                                @if($landing->exists)
                                    <button type="button" id="publicar-btn-bottom" class="btn btn-success" onclick="publishLanding()" {{ ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada' || !$profileComplete || !$empresaCompleta) ? 'disabled' : '' }}>
                                        <i class="bi bi-rocket me-1"></i>
                                        Publicar
                                    </button>
                                @endif
                                --}}
                            </div>
                        </div>
                    </div>
                </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <!-- FIN FORMULARIO AVANZADO -->
            
            @if(!$profileComplete)
                </div> <!-- Cierre del overlay de bloqueo -->
            @endif
        </div>
    </div>
</div>

@push('styles')
<!-- Quill Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<!-- Animate.css for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<style>
    /* El layout ya no usa tabs; estilos eliminados */
    
    /* Botones de acción al final del formulario */
    .sticky-bottom-actions {
        background: white;
        border-top: 3px solid #007bff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        margin-top: 2rem;
    }
    
    .sticky-bottom-actions .card-body {
        padding: 1.5rem 2rem;
    }
    
    .sticky-bottom-actions .btn {
        min-width: 120px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
    }
    
    .sticky-bottom-actions h6 {
        color: var(--dark-bg, #2c3e50);
        margin-bottom: 0.25rem;
    }
    
    .sticky-bottom-actions small {
        color: #6c757d;
    }
    
    /* Responsive para botones de acción */
    @media (max-width: 768px) {
        .sticky-bottom-actions {
            margin-top: 1.5rem;
        }
        
        .sticky-bottom-actions .card-body {
            padding: 1.25rem 1rem;
        }
        
        .sticky-bottom-actions .d-flex {
            flex-direction: column;
            align-items: stretch !important;
        }
        
        .sticky-bottom-actions .gap-2 {
            gap: 0.5rem !important;
            width: 100%;
        }
        
        .sticky-bottom-actions .btn {
            width: 100%;
            min-width: auto;
            padding: 0.65rem 1rem;
        }
        
        /* Header buttons responsive */
        .header-landing-config {
            flex-direction: column;
            align-items: flex-start !important;
        }
        
        .header-landing-config .header-actions {
            flex-direction: column;
            width: 100%;
            margin-top: 1rem;
            gap: 0.5rem !important;
        }
        
        .header-landing-config .header-actions .btn {
            width: 100%;
            justify-content: center;
        }
    }
    
    @media (max-width: 576px) {
        .sticky-bottom-actions h6 {
            font-size: 0.95rem;
        }
        
        .sticky-bottom-actions small {
            font-size: 0.8rem;
        }
    }
    
    /* Estilos para el bloqueo del perfil */
    .profile-lock-overlay {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 193, 7, 0.05));
        border: 2px dashed #ffc107;
        border-radius: 12px;
        position: relative;
    }
    
    .profile-lock-overlay::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: repeating-linear-gradient(
            45deg,
            transparent,
            transparent 10px,
            rgba(255, 193, 7, 0.1) 10px,
            rgba(255, 193, 7, 0.1) 20px
        );
        pointer-events: none;
        border-radius: 10px;
    }
    
    .upload-zone {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .upload-zone:hover,
    .upload-zone.dragover {
        border-color: #007bff !important;
        background-color: #f8f9fa;
    }
    
    .logo-placeholder {
        transition: all 0.3s ease;
    }
    
    /* Estilos para editores Quill */
    .ql-editor {
        min-height: 150px;
        font-size: 14px;
        line-height: 1.5;
    }
    
    .ql-toolbar {
        border-top: 1px solid #ccc;
        border-left: 1px solid #ccc;
        border-right: 1px solid #ccc;
        border-radius: 0.375rem 0.375rem 0 0;
    }
    
    .ql-container {
        border-bottom: 1px solid #ccc;
        border-left: 1px solid #ccc;
        border-right: 1px solid #ccc;
        border-radius: 0 0 0.375rem 0.375rem;
    }
    }
    
    /* Estilos únicos para imágenes adicionales de landing */
    .landing-media-item {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .landing-media-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .landing-media-item img {
        transition: transform 0.3s ease;
    }
    
    .landing-media-item:hover img {
        transform: scale(1.05);
    }
    
    /* Botón eliminar siempre visible en esquina superior derecha */
    .landing-media-item .landing-delete-btn {
        position: absolute !important;
        top: 8px !important;
        right: 8px !important;
        width: 32px !important;
        height: 32px !important;
        border-radius: 50% !important;
        background: rgba(220, 53, 69, 0.95) !important;
        border: 2px solid white !important;
        color: white !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        z-index: 10 !important;
        box-shadow: 0 2px 6px rgba(0,0,0,0.3) !important;
        opacity: 1 !important; /* ⭐ SIEMPRE VISIBLE - NO HOVER */
        visibility: visible !important; /* Asegurar visibilidad */
    }
    
    .landing-media-item .landing-delete-btn:hover {
        background: rgba(220, 53, 69, 1) !important;
        transform: scale(1.1) !important;
        box-shadow: 0 3px 10px rgba(220, 53, 69, 0.5) !important;
        opacity: 1 !important; /* Mantener siempre visible en hover también */
    }
    
    .landing-media-item .landing-delete-btn:active {
        transform: scale(0.95) !important;
    }
    
    /* Forzar que el botón sea visible incluso sin hover en el contenedor */
    .landing-media-item .landing-delete-btn i {
        pointer-events: none; /* El icono no interfiere con el click */
    }
    
    .form-control-color {
        width: 60px !important;
        height: 38px;
        padding: 4px;
        border-radius: 6px 0 0 6px;
    }
    
    /* Estilos para estado en construcción */
    .upload-zone.disabled {
        opacity: 0.6;
        pointer-events: none;
        background-color: #f8f9fa;
        border-color: #dee2e6 !important;
    }
    
    .upload-zone.disabled i,
    .upload-zone.disabled p {
        color: #6c757d !important;
    }
    
    /* Overlay para formulario deshabilitado */
    .form-disabled-overlay {
        position: relative;
    }
    
    .form-disabled-overlay::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(248, 249, 250, 0.8);
        pointer-events: none;
        border-radius: 0.375rem;
        z-index: 1;
    }
    
    /* Mejoras para el alert de construcción permanente */
    .construction-notice-permanent {
        background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        padding: 1.5rem;
        border-radius: 0.5rem;
        position: relative;
        overflow: hidden;
    }
    
    .construction-notice-permanent::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #ffc107, #fd7e14, #ffc107);
        animation: constructionProgress 3s ease-in-out infinite;
    }
    
    @keyframes constructionProgress {
        0%, 100% { transform: translateX(-100%); }
        50% { transform: translateX(100%); }
    }
    
    .construction-notice-permanent .alert-heading {
        color: #856404;
        font-weight: 600;
    }
    
    .construction-notice-permanent hr {
        border-color: #ffc107;
        opacity: 0.3;
        margin: 1rem 0;
    }
    
    .construction-notice-permanent p,
    .construction-notice-permanent li {
        color: #664d03;
    }
    
    .construction-notice-permanent .btn-outline-warning {
        border-color: #856404;
        color: #856404;
        font-weight: 500;
    }
    
    .construction-notice-permanent .btn-outline-warning:hover {
        background-color: #856404;
        border-color: #856404;
        color: white;
    }

    /* Media Queries para móvil - Configurar Landing Page */
    @media (max-width: 768px) {
        .d-flex.justify-content-between.align-items-center.mb-4 {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 1rem;
        }
        
        .d-flex.justify-content-between.align-items-center.mb-4 > div:first-child {
            width: 100%;
        }
        
        .d-flex.justify-content-between.align-items-center.mb-4 > div:last-child {
            width: 100%;
        }
        
        .d-flex.gap-2 {
            flex-direction: column !important;
            gap: 0.5rem !important;
            width: 100%;
        }
        
        .d-flex.gap-2 .btn {
            width: 100% !important;
            justify-content: center;
            text-align: center;
        }
        
        /* Ajustar título para móvil */
        .h3.mb-1.text-gray-800 {
            font-size: 1.5rem !important;
            line-height: 1.2;
        }
        
        /* Ajustar descripción para móvil */
        .text-muted {
            font-size: 0.875rem !important;
        }
        
        /* Botones de utilidad en móvil */
        #limpiar-autoguardado-btn,
        #revisar-campos-btn {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        
        /* Ajustar gap entre botones en móvil */
        .d-flex.gap-2 {
            gap: 0.5rem !important;
        }
    }
    
    /* Estilos para campos resaltados */
    .campo-resaltado {
        animation: pulso-suave 2s ease-in-out;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25) !important;
        border-color: #007bff !important;
    }
    
    @keyframes pulso-suave {
        0%, 100% { 
            transform: scale(1);
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
        }
        50% { 
            transform: scale(1.02);
            box-shadow: 0 0 0 6px rgba(0, 123, 255, 0.15);
        }
    }
</style>
@endpush

@push('scripts')
<!-- Quill Editor JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
// Variables globales para los editores Quill
let terminosEditor, privacidadEditor, cookiesEditor;

// Sistema de Autoguardado Local
const AUTOGUARDADO_KEY = 'landing_form_data';
const AUTOGUARDADO_TIMESTAMP_KEY = 'landing_form_timestamp';
let autoguardadoTimeout = null;

// Función para verificar campos faltantes
function verificarCamposFaltantes() {
    const campos = [
        { id: 'empresa_nombre', nombre: 'Nombre de la Empresa', obligatorio: true, tab: 'empresa' },
        { id: 'whatsapp', nombre: 'WhatsApp', obligatorio: true, tab: 'empresa' },
        { id: 'logo', nombre: 'Logo de la Empresa', obligatorio: true, esArchivo: true, tab: 'contenido' },
        { id: 'terminos_condiciones', nombre: 'Términos y Condiciones', obligatorio: true, tab: 'empresa' },
        { id: 'politica_privacidad', nombre: 'Política de Privacidad', obligatorio: true, tab: 'empresa' },
        { id: 'color_principal', nombre: 'Color Principal', obligatorio: true, tab: 'contenido' },
        { id: 'color_secundario', nombre: 'Color Secundario', obligatorio: true, tab: 'contenido' },
        { id: 'tipografia', nombre: 'Tipografía', obligatorio: true, tab: 'contenido' },
        { id: 'estilo', nombre: 'Estilo de Diseño', obligatorio: true, tab: 'contenido' },
        { id: 'objetivo', nombre: 'Objetivo del Negocio', obligatorio: false, tab: 'contenido' },
        { id: 'descripcion_objetivo', nombre: 'Descripción del Objetivo', obligatorio: true, tab: 'contenido' },
        { id: 'audiencia_descripcion', nombre: 'Descripción de la Audiencia', obligatorio: false, tab: 'contenido' },
        { id: 'audiencia_problemas', nombre: 'Problemas que Resuelves', obligatorio: true, tab: 'contenido' },
        { id: 'audiencia_beneficios', nombre: 'Beneficios que Ofreces', obligatorio: true, tab: 'contenido' },
        { id: 'titulo_principal', nombre: 'Título Principal', obligatorio: false, tab: 'contenido' },
        { id: 'subtitulo', nombre: 'Subtítulo', obligatorio: true, tab: 'contenido' },
        { id: 'descripcion', nombre: 'Descripción Principal', obligatorio: true, tab: 'contenido' }
    ];
    
    const faltantes = [];
    
    campos.forEach(campo => {
        const elemento = document.getElementById(campo.id);
        let valor = '';
        
        if (campo.esArchivo) {
            const tieneArchivo = elemento?.files?.length > 0;
            const tieneImagenExistente = document.querySelector('#logo-preview img[src*="storage"]') !== null;
            valor = tieneArchivo || tieneImagenExistente;
        } else {
            valor = elemento?.value?.trim() || '';
        }
        
        if (!valor) {
            faltantes.push({
                id: campo.id,
                nombre: campo.nombre,
                obligatorio: campo.obligatorio,
                tab: campo.tab,
                elemento: elemento
            });
        }
    });
    
    return faltantes;
}

// Función para mostrar alerta interactiva de campos faltantes
function mostrarAlertaCamposFaltantes(titulo = 'Campos por completar', icono = 'info') {
    const camposFaltantes = verificarCamposFaltantes();
    
    if (camposFaltantes.length === 0) {
        Swal.fire({
            title: '¡Formulario completo! 🎉',
            text: 'Todos los campos están completados correctamente.',
            icon: 'success',
            confirmButtonText: 'Excelente',
            timer: 2000,
            timerProgressBar: true
        });
        return;
    }
    
    const obligatorios = camposFaltantes.filter(c => c.obligatorio);
    const opcionales = camposFaltantes.filter(c => !c.obligatorio);
    
    let mensaje = '<div class="text-start">';
    
    if (obligatorios.length > 0) {
        mensaje += '<div class="mb-3"><strong class="text-danger fs-6">🚨 Campos obligatorios faltantes:</strong>';
        mensaje += '<div class="mt-2">';
        obligatorios.forEach((campo, index) => {
            mensaje += `
                <button type="button" class="btn btn-outline-danger btn-sm w-100 mb-1 text-start" onclick="irACampo('${campo.id}', '${campo.nombre}')">
                    <i class="bi bi-exclamation-triangle me-2"></i><strong>${campo.nombre}</strong>
                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-cursor me-1"></i>Clic para ir al campo
                    </small>
                </button>
            `;
        });
        mensaje += '</div></div>';
    }
    
    if (opcionales.length > 0) {
        mensaje += '<div class="mb-3"><strong class="text-warning fs-6">📝 Campos opcionales pendientes:</strong>';
        mensaje += '<div class="mt-2">';
        
        // Mostrar máximo 5 campos opcionales para no saturar
        const opcionalesMostrar = opcionales.slice(0, 5);
        opcionalesMostrar.forEach((campo, index) => {
            mensaje += `
                <button type="button" class="btn btn-outline-warning btn-sm w-100 mb-1 text-start" onclick="irACampo('${campo.id}', '${campo.nombre}')">
                    <i class="bi bi-pencil me-2"></i>${campo.nombre}
                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-cursor me-1"></i>Clic para ir al campo
                    </small>
                </button>
            `;
        });
        
        if (opcionales.length > 5) {
            mensaje += `<small class="text-muted">... y ${opcionales.length - 5} campos más</small>`;
        }
        
        mensaje += '</div></div>';
    }
    
    mensaje += `
        <div class="alert alert-info border-0 mb-0">
            <i class="bi bi-lightbulb me-2"></i>
            <strong>Tip:</strong> Haz clic en cualquier campo de arriba para ir directamente a él y completarlo.
        </div>
    `;
    
    mensaje += '</div>';
    
    Swal.fire({
        title: titulo,
        html: mensaje,
        icon: icono,
        confirmButtonText: 'Entendido',
        confirmButtonColor: obligatorios.length > 0 ? '#dc3545' : '#3085d6',
        width: '700px',
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        }
    });
}

// Función para ir a un campo específico
function irACampo(campoId, nombreCampo) {
    if (!campoId) {
        console.warn('ID de campo no válido:', campoId);
        return;
    }
    
    // Cerrar el SweetAlert primero
    Swal.close();
    
    // Desplazarse directamente al campo y resaltarlo
    const elemento = document.getElementById(campoId);
    if (elemento) {
        elemento.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => {
            elemento.focus();
            elemento.style.boxShadow = '0 0 0 3px rgba(0, 123, 255, 0.25)';
            elemento.style.borderColor = '#007bff';
            setTimeout(() => {
                elemento.style.boxShadow = '';
                elemento.style.borderColor = '';
            }, 2000);
        }, 500);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar editores Quill para documentos legales
    initializeQuillEditors();
    
    // Sincronizar editores con campos ocultos antes de enviar formulario
    const form = document.getElementById('landing-form');
    if (form) {
        form.addEventListener('submit', function(event) {
            syncQuillEditorsWithHiddenFields();
            
            // Almacenar el estado de los campos para mostrar alerta después del guardado
            const camposFaltantes = verificarCamposFaltantes();
            
            // Guardar el estado en sessionStorage para usar después del redirect
            if (camposFaltantes.length > 0) {
                sessionStorage.setItem('mostrarAlertaCamposFaltantes', JSON.stringify(camposFaltantes));
            } else {
                sessionStorage.setItem('mostrarAlertaFormularioCompleto', 'true');
            }
            
            // Marcar que el formulario se está enviando para limpiar autoguardado después
            sessionStorage.setItem('formulario_enviado', 'true');
            
            // Permitir que el formulario se envíe normalmente
            // Las alertas se mostrarán después del guardado exitoso
        });
    }
    // Sincronizar color pickers con inputs de texto
    const colorInputs = document.querySelectorAll('input[type="color"]');
    colorInputs.forEach(colorInput => {
        const textInput = colorInput.nextElementSibling;
        
        colorInput.addEventListener('change', function() {
            textInput.value = this.value;
        });
    });
    
    // Cargar medios existentes
    loadExistingMedia();
    
    // Agregar listeners para validación en tiempo real
    const campos = [
        'empresa_nombre',
        'whatsapp', 
        'logo',
        'color_principal',
        'color_secundario',
        'tipografia',
        'estilo'
    ];
    
    // Agregar listeners a todos los campos requeridos
    campos.forEach(campoId => {
        const campo = document.getElementById(campoId);
        if (campo) {
            if (campo.type === 'file') {
                campo.addEventListener('change', validarCamposRequeridos);
            } else {
                campo.addEventListener('input', validarCamposRequeridos);
                campo.addEventListener('change', validarCamposRequeridos);
                campo.addEventListener('blur', validarCamposRequeridos);
            }
        }
    });
    
    // Validar al cargar la página
    validarCamposRequeridos();
    
    // Mostrar alertas después del guardado si existen en sessionStorage
    mostrarAlertasPostGuardado();
    
    // Inicializar sistema de autoguardado
    inicializarAutoguardado();
    
    // Restaurar datos guardados automáticamente
    restaurarDatosGuardados();
    
    // JavaScript para validar slug en tiempo real
    const slugInput = document.getElementById('slug');
    if (slugInput) {
        slugInput.addEventListener('input', function(e) {
            let value = e.target.value;
            
            // Convertir a minúsculas y reemplazar espacios con guiones
            value = value.toLowerCase().replace(/\s+/g, '-');
            
            // Eliminar caracteres no válidos
            value = value.replace(/[^a-z0-9\-]/g, '');
            
            // Eliminar guiones múltiples
            value = value.replace(/-+/g, '-');
            
            // Eliminar guiones al inicio y final
            value = value.replace(/^-+|-+$/g, '');
            
            // Actualizar el valor del input
            e.target.value = value;
            
            // Validar longitud mínima
            if (value.length < 3 && value.length > 0) {
                e.target.classList.add('is-invalid');
                if (!e.target.nextElementSibling || !e.target.nextElementSibling.classList.contains('invalid-feedback')) {
                    const feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    feedback.textContent = 'El slug debe tener al menos 3 caracteres';
                    e.target.parentNode.appendChild(feedback);
                }
            } else {
                e.target.classList.remove('is-invalid');
                const feedback = e.target.parentNode.querySelector('.invalid-feedback');
                if (feedback && feedback.textContent === 'El slug debe tener al menos 3 caracteres') {
                    feedback.remove();
                }
            }
        });
        
        // Evitar pegar contenido no válido
        slugInput.addEventListener('paste', function(e) {
            e.preventDefault();
            const paste = (e.clipboardData || window.clipboardData).getData('text');
            const cleanPaste = paste.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9\-]/g, '').replace(/-+/g, '-').replace(/^-+|-+$/g, '');
            e.target.value = cleanPaste;
            e.target.dispatchEvent(new Event('input'));
        });
    }
});

// Función para inicializar editores Quill
function initializeQuillEditors() {
    const toolbarOptions = [
        ['bold', 'italic', 'underline'],
        [{ 'header': [1, 2, 3, false] }],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        ['clean']
    ];
    
    // Editor para Términos y Condiciones
    if (document.getElementById('terminos_condiciones_editor')) {
        terminosEditor = new Quill('#terminos_condiciones_editor', {
            theme: 'snow',
            modules: { toolbar: toolbarOptions },
            placeholder: 'Define los términos y condiciones de uso de tus servicios...'
        });
        
        // Cargar contenido existente
        const terminosContent = document.getElementById('terminos_condiciones').value;
        if (terminosContent) {
            terminosEditor.root.innerHTML = terminosContent;
        }
    }
    
    // Editor para Política de Privacidad
    if (document.getElementById('politica_privacidad_editor')) {
        privacidadEditor = new Quill('#politica_privacidad_editor', {
            theme: 'snow',
            modules: { toolbar: toolbarOptions },
            placeholder: 'Define cómo manejas los datos personales de tus clientes...'
        });
        
        // Cargar contenido existente
        const privacidadContent = document.getElementById('politica_privacidad').value;
        if (privacidadContent) {
            privacidadEditor.root.innerHTML = privacidadContent;
        }
    }
    
    // Editor para Política de Cookies
    if (document.getElementById('politica_cookies_editor')) {
        cookiesEditor = new Quill('#politica_cookies_editor', {
            theme: 'snow',
            modules: { toolbar: toolbarOptions },
            placeholder: 'Explica el uso de cookies en tu sitio web...'
        });
        
        // Cargar contenido existente
        const cookiesContent = document.getElementById('politica_cookies').value;
        if (cookiesContent) {
            cookiesEditor.root.innerHTML = cookiesContent;
        }
    }
}

// Función para sincronizar editores con campos ocultos
function syncQuillEditorsWithHiddenFields() {
    if (terminosEditor) {
        document.getElementById('terminos_condiciones').value = terminosEditor.root.innerHTML;
    }
    if (privacidadEditor) {
        document.getElementById('politica_privacidad').value = privacidadEditor.root.innerHTML;
    }
    if (cookiesEditor) {
        document.getElementById('politica_cookies').value = cookiesEditor.root.innerHTML;
    }
}

// Previsualización del logo
function previewLogo(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('logo-preview');
    const MAX_SIZE_BYTES = 2 * 1024 * 1024; // 2MB
    
    if (file) {
        if (!file.type || !file.type.startsWith('image/')) {
            Swal.fire({
                title: 'Archivo inválido',
                text: 'Debes seleccionar una imagen válida (JPG, PNG, GIF, SVG, WEBP).',
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
            event.target.value = '';
            return;
        }
        if (file.size > MAX_SIZE_BYTES) {
            Swal.fire({
                title: 'Imagen demasiado grande',
                text: 'La imagen debe ser máximo de 2MB.',
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
            event.target.value = '';
            return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Vista previa del logo" class="img-fluid rounded" style="max-height: 150px;">`;
        };
        reader.readAsDataURL(file);
    }
}

// Manejo de drag & drop
function handleDragOver(event) {
    event.preventDefault();
    event.currentTarget.classList.add('dragover');
}

function handleDragLeave(event) {
    event.currentTarget.classList.remove('dragover');
}

function handleDrop(event) {
    event.preventDefault();
    event.currentTarget.classList.remove('dragover');
    
    const files = event.dataTransfer.files;
    handleFiles(files);
}

function handleFileSelect(event) {
    const files = event.target.files;
    handleFiles(files);
}

function handleFiles(files) {
    const MAX_SIZE_BYTES = 2 * 1024 * 1024; // 2MB
    // Permitir subida de imágenes en todos los estados ya que se cargan dinámicamente
    Array.from(files).forEach(file => {
        // Validación básica en frontend para mejorar UX
        if (!file.type || !file.type.startsWith('image/')) {
            Swal.fire({
                title: 'Archivo inválido',
                text: 'Debes seleccionar una imagen válida (JPG, PNG, GIF, SVG, WEBP).',
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
            return;
        }
        if (file.size > MAX_SIZE_BYTES) {
            Swal.fire({
                title: 'Imagen demasiado grande',
                text: 'La imagen debe ser máximo de 2MB.',
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
            return;
        }
        uploadMedia(file);
    });
}

function uploadMedia(file) {
    const formData = new FormData();
    formData.append('media', file);
    formData.append('tipo', 'imagen');
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    // Mostrar loading
    const gallery = document.getElementById('media-gallery');
    const loadingItem = createLoadingItem();
    gallery.appendChild(loadingItem);
    
    fetch('{{ route("admin.landing.media.subir") }}', {
        method: 'POST',
        body: formData
    })
    .then(async (response) => {
        let data = {};
        try { data = await response.json(); } catch (_) {}
        loadingItem.remove();
        if (!response.ok || !data.success) {
            let msg = 'Hubo un problema al subir la imagen.';
            if (data && data.errors) {
                // Unir todos los mensajes de error del backend
                msg = Object.values(data.errors).flat().join('\n');
            } else if (data && data.message) {
                msg = data.message;
            }
            Swal.fire({
                title: 'Error al subir imagen',
                text: msg,
                icon: 'error',
                confirmButtonText: 'Entendido'
            });
            return;
        }
        addMediaToGallery(data.media);
    })
    .catch(error => {
        loadingItem.remove();
        console.error('Error:', error);
        Swal.fire({
            title: 'Error al subir imagen',
            text: 'Hubo un problema al subir la imagen. Por favor, intenta de nuevo.',
            icon: 'error',
            confirmButtonText: 'Entendido'
        });
    });
}

function createLoadingItem() {
    const col = document.createElement('div');
    col.className = 'col-md-6 col-lg-4';
    col.innerHTML = `
        <div class="landing-media-item border rounded p-3 text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-2 mb-0 text-muted">Subiendo...</p>
        </div>
    `;
    return col;
}

function addMediaToGallery(media) {
    const gallery = document.getElementById('media-gallery');
    const col = document.createElement('div');
    col.className = 'col-md-6 col-lg-4';
    col.setAttribute('data-media-id', media.id);
    
    col.innerHTML = `
        <div class="landing-media-item border rounded overflow-hidden">
            <img src="${media.url}" alt="${media.descripcion || 'Imagen'}" class="img-fluid w-100" style="height: 150px; object-fit: cover;">
            <button type="button" class="landing-delete-btn btn" onclick="deleteMedia(${media.id})" title="Eliminar imagen">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;
    
    gallery.appendChild(col);
}

function deleteMedia(mediaId) {
    // Permitir eliminación de imágenes en todos los estados ya que se cargan dinámicamente
    if (!confirm('¿Estás seguro de que quieres eliminar esta imagen?')) {
        return;
    }
    
    fetch(`{{ url('admin/landing/media/eliminar') }}/${mediaId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.querySelector(`[data-media-id="${mediaId}"]`).remove();
        } else {
            alert('Error al eliminar la imagen: ' + (data.message || 'Error desconocido'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al eliminar la imagen');
    });
}

function loadExistingMedia() {
    fetch('{{ route("admin.landing.media.obtener") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.media.length > 0) {
                data.media.forEach(media => {
                    addMediaToGallery(media);
                });
            }
        })
        .catch(error => {
            console.error('Error loading media:', error);
        });
}

@if(!$profileComplete)
// Validación adicional para perfil incompleto
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('landing-form');
    const submitBtn = form.querySelector('button[type="submit"]');
    const publishBtn = document.querySelector('button[onclick="publishLanding()"]');
    
    // Prevenir envío del formulario
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Debes completar tu perfil antes de guardar la configuración de tu landing page.');
        return false;
    });
    
    // Prevenir publicación
    window.publishLanding = function() {
        alert('Debes completar tu perfil antes de publicar tu landing page.');
        return false;
    };
    
    // Agregar tooltips a botones deshabilitados
    if (submitBtn) {
        submitBtn.setAttribute('title', 'Completa tu perfil para habilitar esta función');
        submitBtn.setAttribute('data-bs-toggle', 'tooltip');
    }
    if (publishBtn) {
        publishBtn.setAttribute('title', 'Completa tu perfil para habilitar esta función');
        publishBtn.setAttribute('data-bs-toggle', 'tooltip');
    }
    
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
@endif

// Si hay errores en información empresarial, desplazarse a la primera ocurrencia
document.addEventListener('DOMContentLoaded', function() {
    const primeraInvalida = document.querySelector('#seccion-empresa .is-invalid');
    if (primeraInvalida) {
        primeraInvalida.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});

// Función para cargar texto base en documentos legales
function cargarTextoBase(tipoDocumento) {
    let editor;
    
    // Obtener el editor correspondiente
    switch(tipoDocumento) {
        case 'terminos_condiciones':
            editor = terminosEditor;
            break;
        case 'politica_privacidad':
            editor = privacidadEditor;
            break;
        case 'politica_cookies':
            editor = cookiesEditor;
            break;
        default:
            console.error('Editor no encontrado para:', tipoDocumento);
            return;
    }
    
    if (!editor) {
        console.error('Editor Quill no inicializado para:', tipoDocumento);
        return;
    }
    
    // Definir textos base
    const documentosLegalesBase = {
        'terminos_condiciones': `<h3>TÉRMINOS Y CONDICIONES DE USO</h3>

<h4>1. Aceptación de los Términos</h4>
<p>Al acceder y utilizar este sitio web, usted acepta estar sujeto a estos términos y condiciones de uso y todas las leyes y reglamentos aplicables.</p>

<h4>2. Uso del Sitio Web</h4>
<p>Está permitido descargar temporalmente una copia de los materiales en este sitio web solo para visualización transitoria personal y no comercial.</p>

<h4>3. Limitaciones</h4>
<p>Bajo ninguna circunstancia usted o terceros podrán:</p>
<ul>
<li>Modificar o copiar los materiales</li>
<li>Usar los materiales para propósitos comerciales sin autorización</li>
<li>Intentar realizar ingeniería inversa de cualquier software del sitio web</li>
</ul>

<h4>4. Descargo de Responsabilidad</h4>
<p>Los materiales en este sitio web se proporcionan "tal como están". No ofrecemos garantías, expresas o implícitas.</p>

<h4>5. Limitaciones</h4>
<p>En ningún caso seremos responsables por daños que surjan del uso o la incapacidad de usar los materiales en nuestro sitio web.</p>

<h4>6. Modificaciones</h4>
<p>Podemos revisar estos términos de servicio en cualquier momento sin previo aviso.</p>`,
        'politica_privacidad': `<h3>POLÍTICA DE PRIVACIDAD</h3>

<h4>1. Información que Recopilamos</h4>
<p>Recopilamos información que usted nos proporciona directamente, como:</p>
<ul>
<li>Nombre y información de contacto</li>
<li>Información de la cuenta</li>
<li>Comunicaciones con nosotros</li>
</ul>

<h4>2. Cómo Utilizamos su Información</h4>
<p>Utilizamos la información recopilada para:</p>
<ul>
<li>Proporcionar, mantener y mejorar nuestros servicios</li>
<li>Comunicarnos con usted</li>
<li>Personalizar su experiencia</li>
</ul>

<h4>3. Compartir Información</h4>
<p>No vendemos, intercambiamos ni transferimos su información personal a terceros sin su consentimiento, excepto cuando sea necesario para proporcionar el servicio.</p>

<h4>4. Seguridad de los Datos</h4>
<p>Implementamos medidas de seguridad apropiadas para proteger su información personal contra acceso no autorizado, alteración, divulgación o destrucción.</p>

<h4>5. Sus Derechos</h4>
<p>Usted tiene derecho a:</p>
<ul>
<li>Acceder a su información personal</li>
<li>Corregir datos inexactos</li>
<li>Solicitar la eliminación de sus datos</li>
</ul>

<h4>6. Contacto</h4>
<p>Si tiene preguntas sobre esta política de privacidad, contáctenos.</p>`,
        'politica_cookies': `<h3>POLÍTICA DE COOKIES</h3>

<h4>1. ¿Qué son las Cookies?</h4>
<p>Las cookies son pequeños archivos de texto que se almacenan en su dispositivo cuando visita nuestro sitio web. Nos ayudan a mejorar su experiencia de navegación.</p>

<h4>2. Tipos de Cookies que Utilizamos</h4>

<h5>Cookies Esenciales</h5>
<p>Estas cookies son necesarias para el funcionamiento básico del sitio web y no pueden desactivarse.</p>

<h5>Cookies de Rendimiento</h5>
<p>Nos ayudan a entender cómo los visitantes interactúan con nuestro sitio web recopilando información de forma anónima.</p>

<h5>Cookies de Funcionalidad</h5>
<p>Permiten que el sitio web recuerde las elecciones que hace para proporcionarle una experiencia más personalizada.</p>

<h4>3. Gestión de Cookies</h4>
<p>Puede configurar su navegador para rechazar cookies, eliminar las existentes o recibir avisos cuando se instalen. Ten en cuenta que desactivar cookies puede afectar la funcionalidad del sitio.</p>

<h4>4. Cookies de Terceros</h4>
<p>Algunos de nuestros socios también pueden establecer cookies en su dispositivo. No tenemos control sobre estas cookies de terceros.</p>

<h4>5. Actualizaciones</h4>
<p>Esta política de cookies puede actualizarse ocasionalmente. Le recomendamos revisar esta página periódicamente.</p>`
    };
    
    // Verificar si ya hay contenido
    const currentContent = editor.getText().trim();
    if (currentContent.length > 10) {
        if (!confirm('Ya tienes contenido escrito. ¿Quieres reemplazarlo con el texto base?')) {
            return;
        }
    }
    
    // Cargar el texto base
    const textoBase = documentosLegalesBase[tipoDocumento];
    if (textoBase) {
        editor.root.innerHTML = textoBase.trim();
        
        // Mostrar feedback visual
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="bi bi-check-circle me-1"></i>¡Texto cargado!';
        button.classList.add('btn-success');
        button.classList.remove('btn-outline-primary', 'btn-outline-success', 'btn-outline-warning');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.classList.remove('btn-success');
            
            // Restaurar la clase original
            if (tipoDocumento === 'terminos_condiciones') {
                button.classList.add('btn-outline-primary');
            } else if (tipoDocumento === 'politica_privacidad') {
                button.classList.add('btn-outline-success');
            } else if (tipoDocumento === 'politica_cookies') {
                button.classList.add('btn-outline-warning');
            }
        }, 2000);
        
        // Scroll al editor
        editor.container.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

// Sistema de Autoguardado Local (ya declarado anteriormente)

// Función para inicializar el sistema de autoguardado
function inicializarAutoguardado() {
    const campos = [
        // Información empresarial
        'empresa_nombre', 'empresa_email', 'empresa_movil', 'whatsapp',
        'empresa_direccion', 'website', 'facebook', 'instagram', 
        'linkedin', 'twitter', 'tiktok', 'youtube',
        
        // Configuración de landing
        'objetivo', 'descripcion_objetivo', 'audiencia_descripcion',
        'audiencia_problemas', 'audiencia_beneficios', 'color_principal',
        'color_secundario', 'tipografia', 'estilo', 'titulo_principal',
        'subtitulo', 'descripcion', 'slug',
        
        // Documentos legales (campos ocultos)
        'terminos_condiciones', 'politica_privacidad', 'politica_cookies'
    ];
    
    // Agregar listeners a todos los campos
    campos.forEach(campoId => {
        const campo = document.getElementById(campoId);
        if (campo) {
            // Para diferentes tipos de campos
            if (campo.tagName === 'SELECT') {
                campo.addEventListener('change', () => guardarCampoLocal(campoId, campo.value));
            } else if (campo.type === 'color') {
                campo.addEventListener('change', () => guardarCampoLocal(campoId, campo.value));
            } else {
                // Input text, textarea, etc.
                campo.addEventListener('input', () => {
                    clearTimeout(autoguardadoTimeout);
                    autoguardadoTimeout = setTimeout(() => {
                        guardarCampoLocal(campoId, campo.value);
                    }, 500); // Esperar 500ms después de que pare de escribir
                });
            }
        }
    });
    
    // Agregar listener para editores Quill
    setTimeout(() => {
        if (terminosEditor) {
            terminosEditor.on('text-change', () => {
                clearTimeout(autoguardadoTimeout);
                autoguardadoTimeout = setTimeout(() => {
                    guardarCampoLocal('terminos_condiciones', terminosEditor.root.innerHTML);
                }, 1000);
            });
        }
        
        if (privacidadEditor) {
            privacidadEditor.on('text-change', () => {
                clearTimeout(autoguardadoTimeout);
                autoguardadoTimeout = setTimeout(() => {
                    guardarCampoLocal('politica_privacidad', privacidadEditor.root.innerHTML);
                }, 1000);
            });
        }
        
        if (cookiesEditor) {
            cookiesEditor.on('text-change', () => {
                clearTimeout(autoguardadoTimeout);
                autoguardadoTimeout = setTimeout(() => {
                    guardarCampoLocal('politica_cookies', cookiesEditor.root.innerHTML);
                }, 1000);
            });
        }
    }, 2000); // Esperar a que se inicialicen los editores Quill
    
    // Actualizar botón de limpiar borradores al inicializar
    actualizarBotonLimpiarBorradores();
}

// Función para guardar un campo en localStorage
function guardarCampoLocal(campoId, valor) {
    try {
        // Obtener datos existentes
        let datosGuardados = JSON.parse(localStorage.getItem(AUTOGUARDADO_KEY) || '{}');
        
        // Actualizar el campo específico
        datosGuardados[campoId] = valor;
        datosGuardados._timestamp = new Date().getTime();
        
        // Guardar en localStorage
        localStorage.setItem(AUTOGUARDADO_KEY, JSON.stringify(datosGuardados));
        localStorage.setItem(AUTOGUARDADO_TIMESTAMP_KEY, new Date().getTime());
        
        // Mostrar indicador visual temporal
        mostrarIndicadorAutoguardado();
        
        // Actualizar botón de limpiar borradores
        actualizarBotonLimpiarBorradores();
        
    } catch (error) {
        console.warn('Error guardando datos localmente:', error);
    }
}

// Función para restaurar datos guardados
function restaurarDatosGuardados() {
    try {
        const datosGuardados = JSON.parse(localStorage.getItem(AUTOGUARDADO_KEY) || '{}');
        const timestamp = localStorage.getItem(AUTOGUARDADO_TIMESTAMP_KEY);
        
        // Verificar si los datos no son muy antiguos (7 días)
        const ahora = new Date().getTime();
        const sietesDias = 7 * 24 * 60 * 60 * 1000;
        
        if (!timestamp || (ahora - timestamp) > sietesDias) {
            limpiarDatosGuardados();
            return;
        }
        
        let camposRestaurados = 0;
        
        // Restaurar cada campo
        Object.keys(datosGuardados).forEach(campoId => {
            if (campoId.startsWith('_')) return; // Ignorar metadatos
            
            const campo = document.getElementById(campoId);
            const valor = datosGuardados[campoId];
            
            if (campo && valor && valor.trim() !== '') {
                const valorActual = campo.value || '';
                const placeholderValue = campo.getAttribute('placeholder') || '';
                
                // Solo restaurar si el campo está vacío actualmente (no sea placeholder ni valor por defecto)
                if (valorActual.trim() === '' || 
                    valorActual === placeholderValue ||
                    (campo.type === 'color' && (valorActual === '#000000' || valorActual === '#007bff' || valorActual === '#6c757d'))) {
                    
                    campo.value = valor;
                    camposRestaurados++;
                    
                    // Disparar evento change para que se actualicen las validaciones
                    campo.dispatchEvent(new Event('change', { bubbles: true }));
                    campo.dispatchEvent(new Event('input', { bubbles: true }));
                }
            }
        });
        
        // Restaurar editores Quill después de un delay
        setTimeout(() => {
            if (terminosEditor && datosGuardados.terminos_condiciones && !terminosEditor.getText().trim()) {
                terminosEditor.root.innerHTML = datosGuardados.terminos_condiciones;
                camposRestaurados++;
            }
            if (privacidadEditor && datosGuardados.politica_privacidad && !privacidadEditor.getText().trim()) {
                privacidadEditor.root.innerHTML = datosGuardados.politica_privacidad;
                camposRestaurados++;
            }
            if (cookiesEditor && datosGuardados.politica_cookies && !cookiesEditor.getText().trim()) {
                cookiesEditor.root.innerHTML = datosGuardados.politica_cookies;
                camposRestaurados++;
            }
            
            // Re-validar después de restaurar
            validarCamposRequeridos();
        }, 2000);
        
        // Mostrar mensaje si se restauraron campos
        if (camposRestaurados > 0) {
            mostrarMensajeRestauracion(camposRestaurados, timestamp);
        }
        
        // Actualizar botón de limpiar borradores
        actualizarBotonLimpiarBorradores();
        
    } catch (error) {
        console.warn('Error restaurando datos guardados:', error);
        limpiarDatosGuardados();
    }
}

// Función para mostrar indicador de autoguardado
function mostrarIndicadorAutoguardado() {
    // Crear o actualizar indicador
    let indicador = document.getElementById('autoguardado-indicator');
    
    if (!indicador) {
        indicador = document.createElement('div');
        indicador.id = 'autoguardado-indicator';
        indicador.innerHTML = '<i class="bi bi-cloud-check-fill me-1"></i>Guardado';
        indicador.style.cssText = `
            position: fixed;
            top: 80px;
            right: 20px;
            background: linear-gradient(135deg, #198754, #20c997);
            color: white;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
            z-index: 9999;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
            box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
            backdrop-filter: blur(10px);
        `;
        document.body.appendChild(indicador);
    }
    
    // Actualizar contenido con timestamp
    const ahora = new Date();
    const tiempo = ahora.toLocaleTimeString('es-ES', { 
        hour: '2-digit', 
        minute: '2-digit',
        second: '2-digit' 
    });
    indicador.innerHTML = `<i class="bi bi-cloud-check-fill me-1"></i>Guardado ${tiempo}`;
    
    // Mostrar indicador con animación
    indicador.style.opacity = '1';
    indicador.style.transform = 'translateY(0)';
    
    // Ocultar después de 3 segundos
    setTimeout(() => {
        indicador.style.opacity = '0';
        indicador.style.transform = 'translateY(-10px)';
    }, 3000);
}

// Función para mostrar mensaje de restauración
function mostrarMensajeRestauracion(cantidad, timestamp) {
    const fecha = new Date(parseInt(timestamp));
    const fechaFormateada = fecha.toLocaleString('es-ES', {
        day: 'numeric',
        month: 'short',
        hour: '2-digit',
        minute: '2-digit'
    });
    
    // Crear alerta de restauración más elegante
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-info alert-dismissible fade show border-0 shadow-sm mb-4';
    alertDiv.innerHTML = `
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
                <i class="bi bi-arrow-clockwise display-6 text-info"></i>
            </div>
            <div class="flex-grow-1 ms-3">
                <h5 class="alert-heading mb-1">
                    <i class="bi bi-cloud-download me-2"></i>
                    Datos restaurados automáticamente
                </h5>
                <p class="mb-2">
                    Se recuperaron <strong>${cantidad} campos</strong> guardados el ${fechaFormateada}. 
                    Puedes continuar desde donde lo dejaste.
                </p>
                <hr class="my-2">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Los datos se guardan automáticamente mientras escribes
                    </small>
                    <button type="button" class="btn btn-outline-info btn-sm" onclick="confirmarLimpiarAutoguardado(); this.closest('.alert').remove();">
                        <i class="bi bi-trash3 me-1"></i>Limpiar Borradores
                    </button>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    
    // Insertar al principio del contenido, después del encabezado
    const contenidoPrincipal = document.querySelector('.container-fluid > .row > .col-12');
    if (contenidoPrincipal) {
        const primeraSeccion = contenidoPrincipal.querySelector('.d-flex.justify-content-between.align-items-center.mb-4');
        if (primeraSeccion && primeraSeccion.nextSibling) {
            contenidoPrincipal.insertBefore(alertDiv, primeraSeccion.nextSibling);
        } else {
            contenidoPrincipal.insertBefore(alertDiv, contenidoPrincipal.firstChild);
        }
        
        // Auto-remover después de 10 segundos
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.classList.remove('show');
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 300);
            }
        }, 10000);
    }
}

// Función para limpiar datos guardados
function limpiarDatosGuardados() {
    localStorage.removeItem(AUTOGUARDADO_KEY);
    localStorage.removeItem(AUTOGUARDADO_TIMESTAMP_KEY);
    actualizarBotonLimpiarBorradores();
}

// Función para confirmar limpieza de autoguardado
function confirmarLimpiarAutoguardado() {
    Swal.fire({
        title: '¿Limpiar borradores guardados?',
        text: 'Se eliminarán todos los datos guardados automáticamente. Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bi bi-trash3 me-1"></i>Sí, limpiar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            limpiarDatosGuardados();
            
            Swal.fire({
                title: '¡Borradores limpiados!',
                text: 'Los datos guardados automáticamente han sido eliminados.',
                icon: 'success',
                confirmButtonText: 'Entendido',
                timer: 2000,
                timerProgressBar: true
            });
        }
    });
}

// Función para actualizar la visibilidad del botón de limpiar borradores
function actualizarBotonLimpiarBorradores() {
    const boton = document.getElementById('limpiar-autoguardado-btn');
    const hayDatos = localStorage.getItem(AUTOGUARDADO_KEY) !== null;
    
    if (boton) {
        boton.style.display = hayDatos ? 'inline-block' : 'none';
    }
}

// Función para mostrar alertas después del guardado
function mostrarAlertasPostGuardado() {
    // Solo mostrar alertas personalizadas si hay un mensaje de éxito del servidor
    const hasServerSuccess = document.querySelector('.alert-success') !== null;
    const formularioEnviado = sessionStorage.getItem('formulario_enviado');
    
    if (!hasServerSuccess) {
        return; // No mostrar si no hubo guardado exitoso
    }
    
    // Si el formulario fue enviado exitosamente, limpiar datos de autoguardado
    if (formularioEnviado) {
        sessionStorage.removeItem('formulario_enviado');
        limpiarDatosGuardados();
        console.log('✅ Formulario guardado exitosamente - Datos de autoguardado limpiados');
    }
    
    // Verificar si hay alertas pendientes en sessionStorage
    const alertaCamposFaltantes = sessionStorage.getItem('mostrarAlertaCamposFaltantes');
    const alertaFormularioCompleto = sessionStorage.getItem('mostrarAlertaFormularioCompleto');
    
    if (alertaFormularioCompleto) {
        sessionStorage.removeItem('mostrarAlertaFormularioCompleto');
        // Esperar un poco para que se muestre primero la alerta del servidor
        setTimeout(() => {
            mostrarAlertaFormularioCompletoGuardado();
        }, 1500);
    } else if (alertaCamposFaltantes) {
        const camposFaltantes = JSON.parse(alertaCamposFaltantes);
        sessionStorage.removeItem('mostrarAlertaCamposFaltantes');
        // Esperar un poco para que se muestre primero la alerta del servidor
        setTimeout(() => {
            mostrarAdvertenciaCamposFaltantesPostGuardado(camposFaltantes);
        }, 1500);
    }
}

// Función para mostrar alerta cuando el formulario está completo y fue guardado
function mostrarAlertaFormularioCompletoGuardado() {
    Swal.fire({
        title: '¡Guardado exitoso! 🎉',
        html: `
            <div class="text-start">
                <p class="mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i>Tu configuración se ha guardado correctamente.</p>
                <div class="alert alert-success" role="alert">
                    <h5 class="alert-heading"><i class="bi bi-rocket me-2"></i>¡Tu formulario está completo!</h5>
                    <p class="mb-2">Has completado todos los campos necesarios para tu landing page.</p>
                    <hr>
                    <p class="mb-0"><strong>Es muy importante que ahora hagas clic en "Publicar"</strong> para que tu landing esté disponible en 24 horas.</p>
                </div>
            </div>
        `,
        icon: 'success',
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-rocket me-1"></i> Ir a Publicar',
        cancelButtonText: 'Entendido',
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        width: '600px',
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            scrollToPublishButton();
        }
    });
}

// Función para mostrar advertencia de campos faltantes después del guardado
function mostrarAdvertenciaCamposFaltantesPostGuardado(camposFaltantes) {
    const obligatorios = camposFaltantes.filter(c => c.obligatorio);
    const opcionales = camposFaltantes.filter(c => !c.obligatorio);
    
    let mensaje = '<div class="text-start">';
    
    // Mensaje de guardado exitoso
    mensaje += '<div class="alert alert-success mb-3" role="alert">';
    mensaje += '<i class="bi bi-check-circle-fill me-2"></i><strong>¡Guardado exitoso!</strong><br>';
    mensaje += 'Tu información se ha guardado correctamente. Puedes continuar completando los campos restantes.';
    mensaje += '</div>';
    
    if (obligatorios.length > 0) {
        mensaje += '<div class="mb-3"><strong class="text-danger">⚠️ Campos obligatorios por completar:</strong>';
        mensaje += '<ul class="list-unstyled mt-2 mb-0">';
        obligatorios.forEach((campo, index) => {
            mensaje += `<li class="mb-1">
                <button type="button" class="btn btn-sm btn-outline-danger w-100 text-start" onclick="irACampo('${campo.id}', '${campo.nombre}')">
                    <i class="bi bi-arrow-right me-2"></i><strong>${campo.nombre}</strong>
                    <small class="text-muted d-block">Hacer clic para ir al campo</small>
                </button>
            </li>`;
        });
        mensaje += '</ul></div>';
    }
    
    if (opcionales.length > 0) {
        mensaje += '<div><strong class="text-warning">📋 Campos opcionales sin completar:</strong>';
        mensaje += '<ul class="list-unstyled mt-2 mb-0">';
        opcionales.forEach((campo, index) => {
            mensaje += `<li class="mb-1">
                <button type="button" class="btn btn-sm btn-outline-warning w-100 text-start" onclick="irACampo('${campo.id}', '${campo.nombre}')">
                    <i class="bi bi-arrow-right me-2"></i>${campo.nombre}
                    <small class="text-muted d-block">Hacer clic para ir al campo</small>
                </button>
            </li>`;
        });
        mensaje += '</ul></div>';
    }
    
    mensaje += '<hr class="my-3"><p class="text-info mb-0"><i class="bi bi-info-circle me-1"></i><strong>Tip:</strong> Haz clic en cualquier campo de arriba para ir directamente a él.</p></div>';
    
    Swal.fire({
        title: 'Información guardada - Campos pendientes',
        html: mensaje,
        icon: 'info',
        confirmButtonText: 'Entendido',
        confirmButtonColor: '#3085d6',
        width: '700px',
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        }
    });
}

// Función para mostrar tooltip informativo sobre el campo
function mostrarTooltipCampo(elemento, nombreCampo) {
    // Crear tooltip temporal
    const tooltip = document.createElement('div');
    tooltip.innerHTML = `<i class="bi bi-arrow-down me-1"></i>Completa: ${nombreCampo}`;
    tooltip.style.cssText = `
        position: absolute;
        background: #007bff;
        color: white;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        z-index: 9999;
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        pointer-events: none;
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
    `;
    
    // Posicionar el tooltip
    const rect = elemento.getBoundingClientRect();
    tooltip.style.left = rect.left + 'px';
    tooltip.style.top = (rect.top - 35) + 'px';
    
    document.body.appendChild(tooltip);
    
    // Mostrar tooltip
    setTimeout(() => {
        tooltip.style.opacity = '1';
        tooltip.style.transform = 'translateY(0)';
    }, 100);
    
    // Ocultar y remover tooltip después de 3 segundos
    setTimeout(() => {
        tooltip.style.opacity = '0';
        tooltip.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            if (tooltip.parentNode) {
                tooltip.remove();
            }
        }, 300);
    }, 3000);
}

// Función para desplazar a botón publicar
function scrollToPublishButton() {
    const publishBtn = document.getElementById('publicar-btn');
    if (publishBtn) {
        publishBtn.scrollIntoView({ 
            behavior: 'smooth', 
            block: 'center' 
        });
        
        // Añadir efecto visual temporal
        publishBtn.classList.add('animate__animated', 'animate__pulse');
        setTimeout(() => {
            publishBtn.classList.remove('animate__animated', 'animate__pulse');
        }, 1000);
    }
}

// Función para publicar la landing page
function publishLanding() {
    // Verificar campos obligatorios antes de publicar
    const camposFaltantes = verificarCamposFaltantes();
    const obligatoriosFaltantes = camposFaltantes.filter(c => c.obligatorio);
    
    if (obligatoriosFaltantes.length > 0) {
        mostrarAlertaCamposFaltantes('No se puede publicar - Campos obligatorios faltantes', 'error');
        return;
    }
    
    Swal.fire({
        title: '¿Publicar Landing Page?',
        text: '¿Estás seguro de que quieres publicar tu landing page? Una vez publicada podrías ver los resultados en 24 horas.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, publicar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Crear formulario temporal para enviar la solicitud POST
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.landing.publicar") }}';
            form.style.display = 'none';

            // Agregar token CSRF
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            // Agregar al DOM y enviar
            document.body.appendChild(form);
            form.submit();

            // Mostrar mensaje de éxito
            Swal.fire({
                title: '¡Landing Publicada!',
                text: 'En 24 horas podrás ver información completa de tu web publicada.',
                icon: 'success',
                confirmButtonText: 'Entendido'
            });
        }
    });
}

// Función para validar formulario antes de envío (mantenida para compatibilidad)
function validarFormularioAntesDeEnvio() {
    // Esta función ahora solo valida campos críticos para otros usos
    const empresaNombre = document.getElementById('empresa_nombre')?.value?.trim() || '';
    const whatsapp = document.getElementById('whatsapp')?.value?.trim() || '';
    
    // Solo retorna false si realmente no se puede proceder
    // Para el formulario principal, ahora usamos la nueva lógica en el event listener
    return true; // Permitir envío siempre, las validaciones se manejan en el evento submit
}

// Función para validar campos requeridos y habilitar/deshabilitar botones
function validarCamposRequeridos() {
    // Obtener valores de campos requeridos
    const empresaNombre = document.getElementById('empresa_nombre')?.value?.trim() || '';
    const whatsapp = document.getElementById('whatsapp')?.value?.trim() || '';
    const logo = document.getElementById('logo')?.files?.length > 0 || document.querySelector('#logo-preview img[src*="storage"]') !== null;
    const colorPrincipal = document.getElementById('color_principal')?.value?.trim() || '';
    const colorSecundario = document.getElementById('color_secundario')?.value?.trim() || '';
    const tipografia = document.getElementById('tipografia')?.value?.trim() || '';
    const estilo = document.getElementById('estilo')?.value?.trim() || '';
    
    const publicarBtn = document.getElementById('publicar-btn');
    const guardarBtn = document.getElementById('guardar-btn');
    const formularioCompletoAlert = document.getElementById('formulario-completo-alert');
    
    // Validar campos para publicar
    if (publicarBtn) {
        const camposCompletosPublicar = empresaNombre && whatsapp;
        const estadoLanding = '{{ $estadoLanding }}';
        const profileComplete = {{ $profileComplete ? 'true' : 'false' }};
        
        // Verificar todas las condiciones de validación para publicar
        const debeDeshabilitarse = (
            estadoLanding === 'en_construccion' || 
            estadoLanding === 'publicada' || 
            !profileComplete || 
            !camposCompletosPublicar
        );
        
        // Sincronizar botón inferior también
        const publicarBtnBottom = document.getElementById('publicar-btn-bottom');
        const botonesPublicar = [publicarBtn, publicarBtnBottom].filter(btn => btn);
        
        botonesPublicar.forEach(botonPublicar => {
            if (debeDeshabilitarse) {
                botonPublicar.classList.add('disabled');
                botonPublicar.disabled = true;
                
                // Determinar el motivo específico del bloqueo
                if (estadoLanding === 'en_construccion') {
                    botonPublicar.innerHTML = '<i class="bi bi-tools me-1"></i>En Construcción';
                    botonPublicar.title = 'Tu landing ya está en construcción';
                } else if (estadoLanding === 'publicada') {
                    botonPublicar.innerHTML = '<i class="bi bi-check-circle me-1"></i>Ya Publicada';
                    botonPublicar.title = 'Tu landing ya está publicada';
                } else if (!profileComplete) {
                    botonPublicar.innerHTML = '<i class="bi bi-person-x me-1"></i>Perfil Incompleto';
                    botonPublicar.title = 'Completa tu perfil para publicar';
                } else if (!camposCompletosPublicar) {
                    botonPublicar.innerHTML = '<i class="bi bi-exclamation-triangle me-1"></i>Campos Incompletos';
                    botonPublicar.title = 'Completa el nombre de la empresa y WhatsApp para publicar';
                }
            } else {
                botonPublicar.classList.remove('disabled');
                botonPublicar.disabled = false;
                botonPublicar.innerHTML = '<i class="bi bi-rocket me-1"></i>Publicar';
                botonPublicar.title = 'Tu landing está lista para publicar';
            }
        });
    }
    
    // Nueva lógica para el botón guardar - siempre habilitado excepto casos específicos
    // Sincronizar ambos botones (superior e inferior)
    const guardarBtnBottom = document.getElementById('guardar-btn-bottom');
    const botones = [guardarBtn, guardarBtnBottom].filter(btn => btn); // Filtrar null
    
    botones.forEach(boton => {
        if (boton) {
            const estadoLanding = '{{ $estadoLanding }}';
            const profileComplete = {{ $profileComplete ? 'true' : 'false' }};
            
            // Solo deshabilitar en casos muy específicos
            const debeDeshabilitarseGuardar = (
                estadoLanding === 'en_construccion' || 
                !profileComplete
            );
            
            if (debeDeshabilitarseGuardar) {
                boton.classList.add('disabled');
                boton.disabled = true;
                
                if (estadoLanding === 'en_construccion') {
                    boton.title = 'No se puede modificar mientras está en construcción';
                } else if (!profileComplete) {
                    boton.title = 'Completa tu perfil para continuar';
                }
            } else {
                boton.classList.remove('disabled');
                boton.disabled = false;
                boton.title = '';
            }
        }
    });
    
    // Mostrar/ocultar alerta de formulario completo
    if (formularioCompletoAlert) {
        const todoCompleto = empresaNombre && whatsapp && logo && colorPrincipal && 
                            colorSecundario && tipografia && estilo;
        const estadoLanding = '{{ $estadoLanding }}';
        const profileComplete = {{ $profileComplete ? 'true' : 'false' }};
        
        // Mostrar alerta solo si todo está completo pero no ha sido publicado
        if (todoCompleto && profileComplete && estadoLanding !== 'en_construccion' && estadoLanding !== 'publicada') {
            formularioCompletoAlert.style.display = 'block';
        } else {
            formularioCompletoAlert.style.display = 'none';
        }
    }
    
    // Actualizar botón de revisar campos
    actualizarBotonRevisarCampos();
}

// Función para actualizar el botón de revisar campos
function actualizarBotonRevisarCampos() {
    const boton = document.getElementById('revisar-campos-btn');
    if (!boton) return;
    
    const camposFaltantes = verificarCamposFaltantes();
    const totalFaltantes = camposFaltantes.length;
    const obligatoriosFaltantes = camposFaltantes.filter(c => c.obligatorio).length;
    
    if (totalFaltantes === 0) {
        boton.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i>Completo';
        boton.className = 'btn btn-outline-success btn-sm';
        boton.title = 'Todos los campos están completos';
    } else {
        let texto = 'Revisar Campos';
        let clase = 'btn btn-outline-info btn-sm';
        let icono = 'bi bi-list-check me-1';
        
        if (obligatoriosFaltantes > 0) {
            texto = `Faltan ${obligatoriosFaltantes} obligatorios`;
            clase = 'btn btn-outline-danger btn-sm';
            icono = 'bi bi-exclamation-triangle me-1';
            boton.title = `${obligatoriosFaltantes} campos obligatorios y ${totalFaltantes - obligatoriosFaltantes} opcionales por completar`;
        } else {
            texto = `${totalFaltantes} opcionales`;
            boton.title = `${totalFaltantes} campos opcionales por completar`;
        }
        
        boton.innerHTML = `<i class="${icono}"></i>${texto}`;
        boton.className = clase;
    }
}

// JavaScript simplificado para tabs
function switchToAdvanced() {
    // Activar el tab de avanzados
    const avanzadosTab = document.getElementById('avanzados-tab');
    if (avanzadosTab) {
        avanzadosTab.click();
    }
}

// Manejar cambio de tabs
document.addEventListener('DOMContentLoaded', function() {
    console.log('Inicializando tabs básicos...');
    
    const principiantesTab = document.getElementById('principiantes-tab');
    const avanzadosTab = document.getElementById('avanzados-tab');
    
    if (principiantesTab) {
        principiantesTab.addEventListener('shown.bs.tab', function (e) {
            console.log('Mostrando tab principiantes');
            // Ocultar secciones avanzadas
            const advancedSections = document.querySelectorAll('[id^="advanced-section-"]');
            advancedSections.forEach(section => {
                section.classList.add('d-none');
            });
            
            // Ocultar sección de contenido
            const contenidoSection = document.getElementById('seccion-contenido');
            if (contenidoSection) {
                contenidoSection.classList.add('d-none');
            }
        });
    }
    
    if (avanzadosTab) {
        avanzadosTab.addEventListener('shown.bs.tab', function (e) {
            console.log('Mostrando tab avanzados');
            // Mostrar secciones avanzadas
            const advancedSections = document.querySelectorAll('[id^="advanced-section-"]');
            advancedSections.forEach(section => {
                section.classList.remove('d-none');
            });
            
            // Mostrar sección de contenido
            const contenidoSection = document.getElementById('seccion-contenido');
            if (contenidoSection) {
                contenidoSection.classList.remove('d-none');
            }
        });
    }
    
    console.log('Tabs inicializados correctamente');
});

// ============ FUNCIONES PARA SECCIONES OPCIONALES DEL FORMULARIO BÁSICO ============

// Preview del logo simple
function previewLogoSimple(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('logo-preview-simple');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Logo Preview" class="img-fluid rounded" style="max-height: 150px;">`;
        };
        reader.readAsDataURL(file);
    }
}

// Manejo de imágenes adicionales simple
function handleDropSimple(e) {
    e.preventDefault();
    e.stopPropagation();
    
    const zone = document.getElementById('media-upload-zone-simple');
    zone.classList.remove('drag-over');
    
    const files = e.dataTransfer.files;
    handleFilesSimple(files);
}

function handleDragOverSimple(e) {
    e.preventDefault();
    e.stopPropagation();
    
    const zone = document.getElementById('media-upload-zone-simple');
    zone.classList.add('drag-over');
}

function handleDragLeaveSimple(e) {
    e.preventDefault();
    e.stopPropagation();
    
    const zone = document.getElementById('media-upload-zone-simple');
    zone.classList.remove('drag-over');
}

function handleFileSelectSimple(e) {
    const files = e.target.files;
    handleFilesSimple(files);
}

function handleFilesSimple(files) {
    const gallery = document.getElementById('media-gallery-simple');
    
    Array.from(files).forEach(file => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-md-3 col-sm-4 col-6';
                col.innerHTML = `
                    <div class="media-item position-relative">
                        <img src="${e.target.result}" alt="${file.name}" class="img-fluid rounded shadow-sm" style="height: 120px; width: 100%; object-fit: cover;">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1" onclick="removeImageSimple(this)" title="Eliminar">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                `;
                gallery.appendChild(col);
            };
            reader.readAsDataURL(file);
        }
    });
}

function removeImageSimple(button) {
    const col = button.closest('.col-md-3');
    if (col) {
        col.remove();
    }
}

// Manejo de colores en branding simple
function initializeColorPickers() {
    // Color principal
    const colorPrincipal = document.getElementById('color_principal_simple');
    const colorPrincipalText = document.getElementById('color_principal_simple_text');
    const previewPrimary = document.getElementById('color-preview-primary');
    
    if (colorPrincipal && colorPrincipalText && previewPrimary) {
        colorPrincipal.addEventListener('input', function() {
            colorPrincipalText.value = this.value;
            previewPrimary.style.backgroundColor = this.value;
            updateColorPreview();
        });
    }

    // Color secundario
    const colorSecundario = document.getElementById('color_secundario_simple');
    const colorSecundarioText = document.getElementById('color_secundario_simple_text');
    const previewSecondary = document.getElementById('color-preview-secondary');
    
    if (colorSecundario && colorSecundarioText && previewSecondary) {
        colorSecundario.addEventListener('input', function() {
            colorSecundarioText.value = this.value;
            previewSecondary.style.backgroundColor = this.value;
            updateColorPreview();
        });
    }

    function updateColorPreview() {
        const sample = document.getElementById('color-preview-sample');
        if (sample && colorPrincipal && colorSecundario) {
            sample.style.background = `linear-gradient(135deg, ${colorPrincipal.value}, ${colorSecundario.value})`;
        }
    }
}

// Función para cambiar entre formularios independientes
function switchToBasic() {
    console.log('Cambiando a modo básico');
    
    // Ocultar formulario avanzado y sus botones
    document.getElementById('landing-form-avanzado').style.display = 'none';
    document.getElementById('guardar-btn-avanzado-top').style.display = 'none';
    
    // Mostrar formulario básico y sus botones  
    document.getElementById('landing-form-basico').style.display = 'block';
    document.getElementById('guardar-btn-basico').style.display = 'inline-block';
    
    // Actualizar tabs activos
    document.querySelector('#principiantes-tab').classList.add('active');
    document.querySelector('#avanzados-tab').classList.remove('active');
}

function switchToAdvanced() {
    console.log('Cambiando a modo avanzado');
    
    // Ocultar formulario básico y sus botones
    document.getElementById('landing-form-basico').style.display = 'none';
    document.getElementById('guardar-btn-basico').style.display = 'none';
    
    // Mostrar formulario avanzado y sus botones
    document.getElementById('landing-form-avanzado').style.display = 'block';
    document.getElementById('guardar-btn-avanzado-top').style.display = 'inline-block';
    
    // Actualizar tabs activos
    document.querySelector('#avanzados-tab').classList.add('active');
    document.querySelector('#principiantes-tab').classList.remove('active');
}

// Función simplificada - ya no necesitamos manejar campos requeridos
function updateRequiredFields() {
    // Esta función ya no es necesaria con formularios separados
    console.log('Formularios independientes - no se requiere manejo de campos');
}

// Función para forzar actualización de campos (mantenida para compatibilidad)
function forceUpdateFields() {
    console.log('Formularios independientes - no se requiere actualización forzada');
}

// Inicializar formularios cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    initializeColorPickers();
    
    // Configurar listeners para los tabs
    const principiantesTabBtn = document.querySelector('#principiantes-tab');
    const avanzadosTabBtn = document.querySelector('#avanzados-tab');
    
    if (principiantesTabBtn) {
        principiantesTabBtn.addEventListener('click', function() {
            switchToBasic();
        });
    }
    
    if (avanzadosTabBtn) {
        avanzadosTabBtn.addEventListener('click', function() {
            switchToAdvanced();
        });
    }
    
    // Mostrar formulario básico por defecto
    setTimeout(() => {
        switchToBasic();
    }, 500);
});

// Agregar estilos CSS para drag and drop y efectos
const simpleFormStyles = document.createElement('style');
simpleFormStyles.textContent = `
    .drag-over {
        border-color: #007bff !important;
        background-color: rgba(0, 123, 255, 0.1) !important;
    }
    
    .media-item {
        transition: transform 0.2s ease;
    }
    
    .media-item:hover {
        transform: translateY(-2px);
    }
    
    .form-control-color {
        width: 50px !important;
        height: 38px !important;
        padding: 4px !important;
    }
    
    .badge.bg-info {
        background-color: #17a2b8 !important;
    }
`;
document.head.appendChild(simpleFormStyles);

// Exponer funciones globalmente para uso desde atributos onclick en el HTML
window.verificarCamposFaltantes = verificarCamposFaltantes;
window.mostrarAlertaCamposFaltantes = mostrarAlertaCamposFaltantes;
window.irACampo = irACampo;
window.mostrarTooltipCampo = mostrarTooltipCampo;
window.switchToAdvanced = switchToAdvanced;
window.switchToBasic = switchToBasic;
window.previewLogoSimple = previewLogoSimple;
window.handleDropSimple = handleDropSimple;
window.handleDragOverSimple = handleDragOverSimple;
window.handleDragLeaveSimple = handleDragLeaveSimple;
window.handleFileSelectSimple = handleFileSelectSimple;
window.removeImageSimple = removeImageSimple;
window.updateRequiredFields = updateRequiredFields;
window.switchTab = switchTab;
window.forceUpdateFields = forceUpdateFields;
</script>
@endpush
@endsection