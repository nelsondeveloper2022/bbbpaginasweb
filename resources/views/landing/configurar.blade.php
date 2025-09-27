@extends('layouts.dashboard')

@section('title', 'Configura tu Landing')
@section('description', 'Personaliza y configura tu página de aterrizaje')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
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
                <div class="d-flex gap-2">
                    @if($landing->exists)
                        @if($estadoLanding === 'en_construccion')
                            {{-- <a href="{{ $empresa->getLandingUrl() }}" class="btn btn-outline-secondary" target="_blank">
                                <i class="bi bi-eye me-1"></i>
                                Ver Landing
                            </a> --}}
                        @else
                            <a href="{{ route('landing.preview') }}" class="btn btn-outline-secondary" target="_blank">
                                <i class="bi bi-eye me-1"></i>
                                Previsualizar
                            </a>
                        @endif
                    @endif
                    <button type="submit" form="landing-form" class="btn btn-primary" {{ ($estadoLanding === 'en_construccion' || !$profileComplete) ? 'disabled' : '' }}>
                        <i class="bi bi-save me-1"></i>
                        {{ ($estadoLanding === 'publicada') ? 'Guardar Info. Empresarial' : 'Guardar' }}
                    </button>
                    @if($landing->exists)
                        <button type="button" id="publicar-btn" class="btn btn-success" onclick="publishLanding()" {{ ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada' || !$profileComplete || !$empresaCompleta) ? 'disabled' : '' }}>
                            <i class="bi bi-rocket me-1"></i>
                            Publicar
                        </button>
                    @endif
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
                                Podrás actualizar en cualquier momento datos clave como tu <strong>logo</strong>,  
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
                            <a href="{{ route('profile.edit') }}" class="btn btn-warning btn-lg">
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

            <form id="landing-form" action="{{ route('landing.guardar') }}" method="POST" enctype="multipart/form-data" {{ !$profileComplete ? 'style=pointer-events:none;' : '' }}>
                @csrf

                <!-- Navigation Tabs -->
                <div class="mb-4">
                    <ul class="nav nav-tabs nav-fill" id="landingTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="contenido-tab" data-bs-toggle="tab" data-bs-target="#contenido" type="button" role="tab" aria-controls="contenido" aria-selected="true">
                                <i class="bi bi-palette me-2"></i>
                                Contenido y Diseño
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link position-relative" id="empresa-tab" data-bs-toggle="tab" data-bs-target="#empresa" type="button" role="tab" aria-controls="empresa" aria-selected="false">
                                <i class="fas fa-building me-2"></i>
                                Información Empresarial
                                <span class="badge rounded-pill bg-warning text-dark ms-3">
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                    Importante
                                </span>
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Tab Content -->
                <div class="tab-content" id="landingTabContent">
                    <!-- Tab: Contenido y Diseño -->
                    <div class="tab-pane fade show active" id="contenido" role="tabpanel" aria-labelledby="contenido-tab">
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
                                                <label for="descripcion_objetivo" class="form-label fw-bold">Descripción del Objetivo</label>
                                                <textarea class="form-control @error('descripcion_objetivo') is-invalid @enderror" 
                                                        id="descripcion_objetivo" 
                                                        name="descripcion_objetivo" 
                                                        rows="3"
                                                        placeholder="Describe más detalladamente tu objetivo..."
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
                                                <label for="audiencia_problemas" class="form-label fw-bold">Problemas que Resuelves</label>
                                                <textarea class="form-control @error('audiencia_problemas') is-invalid @enderror" 
                                                        id="audiencia_problemas" 
                                                        name="audiencia_problemas" 
                                                        rows="4"
                                                        placeholder="¿Qué problemas o dolores tiene tu audiencia que tu producto/servicio puede resolver?"
                                                        {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}>{{ old('audiencia_problemas', $landing->audiencia_problemas) }}</textarea>
                                                @error('audiencia_problemas')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="audiencia_beneficios" class="form-label fw-bold">Beneficios que Ofreces</label>
                                                <textarea class="form-control @error('audiencia_beneficios') is-invalid @enderror" 
                                                        id="audiencia_beneficios" 
                                                        name="audiencia_beneficios" 
                                                        rows="4"
                                                        placeholder="¿Qué beneficios concretos obtiene tu audiencia al usar tu producto/servicio?"
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
                                            <label for="subtitulo" class="form-label fw-bold">Subtítulo</label>
                                            <input type="text" 
                                                class="form-control @error('subtitulo') is-invalid @enderror" 
                                                id="subtitulo" 
                                                name="subtitulo" 
                                                value="{{ old('subtitulo', $landing->subtitulo) }}"
                                                placeholder="Ej. Sin conocimientos técnicos, con diseños profesionales"
                                                {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}>
                                            @error('subtitulo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="descripcion" class="form-label fw-bold">Descripción Principal</label>
                                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                                    id="descripcion" 
                                                    name="descripcion" 
                                                    rows="4"
                                                    placeholder="Describe tu producto o servicio de manera atractiva y clara..."
                                                    {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}>{{ old('descripcion', $landing->descripcion) }}</textarea>
                                            @error('descripcion')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Sección: Imágenes Adicionales -->
                                <div class="card mb-4 {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'form-disabled-overlay' : '' }}">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="bi bi-images text-primary me-2"></i>
                                            Imágenes Adicionales
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="upload-zone border-2 border-dashed border-secondary rounded p-4 text-center {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}" 
                                                id="media-upload-zone"
                                                ondrop="{{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? '' : 'handleDrop(event)' }}" 
                                                ondragover="{{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? '' : 'handleDragOver(event)' }}"
                                                ondragleave="{{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? '' : 'handleDragLeave(event)' }}">
                                                <i class="bi bi-cloud-upload display-4 text-muted mb-3"></i>
                                                <p class="mb-2">{{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'Subida de imágenes deshabilitada durante la construcción/publicación' : 'Arrastra y suelta imágenes aquí o' }}</p>
                                                @if(!($landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada')))
                                                    <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('media-input').click()">
                                                        Seleccionar Archivos
                                                    </button>
                                                    <input type="file" id="media-input" class="d-none" multiple accept="image/*" onchange="handleFileSelect(event)">
                                                    <small class="text-muted d-block mt-2">Formatos: JPG, PNG, GIF, SVG (Max: 2MB por imagen)</small>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Gallery de imágenes subidas -->
                                        <div id="media-gallery" class="row g-3">
                                            <!-- Las imágenes se cargarán aquí dinámicamente -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Columna Lateral -->
                            <div class="col-lg-4">
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
                                    });
                                </script>

                                <!-- Sección: Logo -->
                                <div class="card mb-4 {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'form-disabled-overlay' : '' }}">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="bi bi-image text-primary me-2"></i>
                                            Logo
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
                                            onchange="previewLogo(event)"
                                            {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}>
                                        @error('logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Recomendado: PNG transparente, 300x100px</small>
                                    </div>
                                </div>

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
                                            <label for="color_principal" class="form-label fw-bold">Color Principal</label>
                                            <div class="input-group">
                                                <input type="color" 
                                                    class="form-control form-control-color @error('color_principal') is-invalid @enderror" 
                                                    id="color_principal" 
                                                    name="color_principal" 
                                                    value="{{ old('color_principal', $landing->color_principal ?: '#007bff') }}"
                                                    title="Selecciona el color principal"
                                                    {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}>
                                                <input type="text" 
                                                    class="form-control" 
                                                    value="{{ old('color_principal', $landing->color_principal ?: '#007bff') }}"
                                                    readonly>
                                            </div>
                                            @error('color_principal')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="color_secundario" class="form-label fw-bold">Color Secundario</label>
                                            <div class="input-group">
                                                <input type="color" 
                                                    class="form-control form-control-color @error('color_secundario') is-invalid @enderror" 
                                                    id="color_secundario" 
                                                    name="color_secundario" 
                                                    value="{{ old('color_secundario', $landing->color_secundario ?: '#6c757d') }}"
                                                    title="Selecciona el color secundario"
                                                    {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}>
                                                <input type="text" 
                                                    class="form-control" 
                                                    value="{{ old('color_secundario', $landing->color_secundario ?: '#6c757d') }}"
                                                    readonly>
                                            </div>
                                            @error('color_secundario')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="estilo" class="form-label fw-bold">Estilo de Diseño</label>
                                            <select class="form-select @error('estilo') is-invalid @enderror" id="estilo" name="estilo" {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}>
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
                                            <label for="tipografia" class="form-label fw-bold">Tipografía</label>
                                            <select class="form-select @error('tipografia') is-invalid @enderror" id="tipografia" name="tipografia" {{ $landing->exists && ($estadoLanding === 'en_construccion' || $estadoLanding === 'publicada') ? 'disabled' : '' }}>
                                                <option value="">Selecciona una tipografía</option>
                                                @foreach($tipografiaOptions as $key => $value)
                                                    <option value="{{ $key }}" {{ old('tipografia', $landing->tipografia) == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('tipografia')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Cierre del Tab: Contenido y Diseño -->

                    <!-- Tab: Información Empresarial -->
                    <div class="tab-pane fade" id="empresa" role="tabpanel" aria-labelledby="empresa-tab">
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
                                        <!-- Información Empresarial -->
                                        <div class="card mb-4">
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

                                        <!-- Redes Sociales -->
                                        <div class="card mb-4">
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
                                        <div class="card mb-4">
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
                                                        </label>
                                                        <button type="button" class="btn btn-outline-primary btn-sm" 
                                                                onclick="cargarTextoBase('terminos_condiciones')"
                                                                title="Cargar texto base para facilitar el llenado">
                                                            <i class="bi bi-magic me-1"></i>
                                                            Crear una base
                                                        </button>
                                                    </div>
                                                    <textarea class="form-control @error('terminos_condiciones') is-invalid @enderror" 
                                                            id="terminos_condiciones" 
                                                            name="terminos_condiciones" 
                                                            rows="6"
                                                            placeholder="Define los términos y condiciones de uso de tus servicios...">{{ old('terminos_condiciones', $empresa->terminos_condiciones ?? '') }}</textarea>
                                                    @error('terminos_condiciones')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <div class="form-text">
                                                        <i class="bi bi-info-circle me-1"></i>
                                                        Puedes usar formato de texto, listas, negritas y más para organizar tus términos y condiciones.
                                                        <br><small class="text-muted">💡 Tip: Usa el botón "crear una base" para obtener un texto inicial que puedes personalizar.</small>
                                                    </div>
                                                </div>

                                                <!-- Política de Privacidad -->
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <label for="politica_privacidad" class="form-label fw-bold">
                                                            <i class="bi bi-shield-check me-2"></i>Política de Privacidad
                                                        </label>
                                                        <button type="button" class="btn btn-outline-success btn-sm" 
                                                                onclick="cargarTextoBase('politica_privacidad')"
                                                                title="Cargar texto base para facilitar el llenado">
                                                            <i class="bi bi-magic me-1"></i>
                                                            Crear una base
                                                        </button>
                                                    </div>
                                                    <textarea class="form-control @error('politica_privacidad') is-invalid @enderror" 
                                                            id="politica_privacidad" 
                                                            name="politica_privacidad" 
                                                            rows="6"
                                                            placeholder="Define cómo manejas los datos personales de tus clientes...">{{ old('politica_privacidad', $empresa->politica_privacidad ?? '') }}</textarea>
                                                    @error('politica_privacidad')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <div class="form-text">
                                                        <i class="bi bi-info-circle me-1"></i>
                                                        Define cómo manejas los datos personales de tus clientes con formato profesional.
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
                                                    <textarea class="form-control @error('politica_cookies') is-invalid @enderror" 
                                                            id="politica_cookies" 
                                                            name="politica_cookies" 
                                                            rows="6"
                                                            placeholder="Explica el uso de cookies en tu sitio web...">{{ old('politica_cookies', $empresa->politica_cookies ?? '') }}</textarea>
                                                    @error('politica_cookies')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <div class="form-text">
                                                        <i class="bi bi-info-circle me-1"></i>
                                                        Explica el uso de cookies en tu sitio web con todas las opciones de formato disponibles.
                                                        <br><small class="text-muted">💡 Tip: Usa el botón "crear una base" para obtener un texto inicial que puedes personalizar.</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Cierre del Tab: Información Empresarial -->
                </div>
                <!-- Cierre de Tab Content -->
            </form>
            
            @if(!$profileComplete)
                </div> <!-- Cierre del overlay de bloqueo -->
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Estilos para los tabs */
    .nav-tabs .nav-link {
        color: #495057;
        border: 1px solid transparent;
        border-top-left-radius: 0.375rem;
        border-top-right-radius: 0.375rem;
        background-color: #f8f9fa;
        margin-bottom: -1px;
        transition: all 0.3s ease;
    }
    
    .nav-tabs .nav-link:hover {
        background-color: #e9ecef;
        border-color: #e9ecef #e9ecef #dee2e6;
    }
    
    .nav-tabs .nav-link.active {
        color: #0d6efd;
        background-color: #fff;
        border-color: #dee2e6 #dee2e6 #fff;
        font-weight: 500;
    }
    
    .tab-content {
        border: 1px solid #dee2e6;
        border-top: none;
        background-color: #fff;
        border-radius: 0 0 0.375rem 0.375rem;
        padding: 0;
    }
    
    .tab-pane {
        padding: 20px;
        min-height: 400px;
    }
    
    .tab-pane.active {
        display: block !important;
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
    
    .media-item {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
    }
    
    .media-item img {
        transition: transform 0.3s ease;
    }
    
    .media-item:hover img {
        transform: scale(1.05);
    }
    
    .media-item .delete-btn {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: rgba(220, 53, 69, 0.9);
        border: none;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .media-item:hover .delete-btn {
        opacity: 1;
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
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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
    
    // Validación del slug en tiempo real
    const slugInput = document.getElementById('slug');
    if (slugInput) {
        slugInput.addEventListener('input', function() {
            let value = this.value;
            
            // Convertir a minúsculas y reemplazar caracteres no válidos
            value = value.toLowerCase()
                        .replace(/[^a-z0-9\-]/g, '') // Solo letras, números y guiones
                        .replace(/--+/g, '-') // Evitar múltiples guiones consecutivos
                        .replace(/^-|-$/g, ''); // Eliminar guiones al inicio o final
            
            this.value = value;
            
            // Actualizar la vista previa de la URL
            const previewUrl = document.querySelector('.alert-info strong');
            if (previewUrl) {
                previewUrl.textContent = '{{ config('app.url') }}/' + value;
            }
        });
        
        // Validar al salir del campo
        slugInput.addEventListener('blur', function() {
            if (this.value.length > 0 && this.value.length < 3) {
                this.setCustomValidity('El slug debe tener al menos 3 caracteres');
            } else {
                this.setCustomValidity('');
            }
        });
    }
    
    // Inicializar tabs de Bootstrap - método simple y confiable
    const triggerTabList = document.querySelectorAll('#landingTabs button[data-bs-toggle="tab"]');
    
    
    // Usar el método nativo de Bootstrap sin interferencias
    triggerTabList.forEach(triggerEl => {
        triggerEl.addEventListener('shown.bs.tab', event => {
            
        });
    });
    
    // Verificar que los tab-panes existan
    const tabPanes = document.querySelectorAll('.tab-pane');
    
    tabPanes.forEach(pane => {
        
    });
    
    // Forzar mostrar el contenido del primer tab si hay problemas
    setTimeout(() => {
        const firstTabPane = document.querySelector('#contenido');
        const secondTabPane = document.querySelector('#empresa');
        if (firstTabPane && secondTabPane) {
            
            
        }
    }, 1000);
    
    // Proteger el aviso de construcción permanente
    const constructionNotice = document.querySelector('[data-construction-notice="permanent"]');
    if (constructionNotice) {
        // Prevenir que se cierre por cualquier evento
        constructionNotice.addEventListener('click', function(e) {
            // Solo permitir clicks en enlaces y botones específicos
            if (!e.target.matches('a, button, a *, button *')) {
                e.preventDefault();
                e.stopPropagation();
            }
        });
        
        // Prevenir que Bootstrap u otros scripts lo oculten
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && 
                    (mutation.attributeName === 'style' || mutation.attributeName === 'class')) {
                    const target = mutation.target;
                    if (target.hasAttribute('data-construction-notice') && 
                        target.getAttribute('data-construction-notice') === 'permanent') {
                        // Restaurar visibilidad si se intenta ocultar
                        target.style.display = '';
                        target.classList.remove('d-none', 'hidden');
                    }
                }
            });
        });
        
        observer.observe(constructionNotice, {
            attributes: true,
            attributeFilter: ['style', 'class']
        });
        
        // Asegurar que permanezca visible
        setInterval(function() {
            if (constructionNotice && constructionNotice.style.display === 'none') {
                constructionNotice.style.display = '';
            }
        }, 1000);
    }
});

// Previsualización del logo
function previewLogo(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('logo-preview');
    
    if (file) {
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
    // Verificar si estamos en estado de construcción
    @if($landing->exists && $estadoLanding === 'en_construccion')
        return; // No procesar archivos en construcción
    @endif
    
    Array.from(files).forEach(file => {
        if (file.type.startsWith('image/')) {
            uploadMedia(file);
        }
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
    
    fetch('{{ route("landing.media.subir") }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        loadingItem.remove();
        
        if (data.success) {
            addMediaToGallery(data.media);
        } else {
            Swal.fire({
                title: 'Error al subir imagen',
                text: data.message || 'Error desconocido',
                icon: 'error',
                confirmButtonText: 'Entendido'
            });
        }
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
        <div class="media-item border rounded p-3 text-center">
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
        <div class="media-item border rounded overflow-hidden">
            <img src="${media.url}" alt="${media.descripcion || 'Imagen'}" class="img-fluid w-100" style="height: 150px; object-fit: cover;">
            @if(!($landing->exists && $estadoLanding === 'en_construccion'))
                <button type="button" class="delete-btn btn" onclick="deleteMedia(${media.id})">
                    <i class="bi bi-trash"></i>
                </button>
            @endif
        </div>
    `;
    
    gallery.appendChild(col);
}

function deleteMedia(mediaId) {
    // Verificar si estamos en estado de construcción
    @if($landing->exists && $estadoLanding === 'en_construccion')
        alert('No puedes eliminar medios mientras tu landing está en construcción.');
        return;
    @endif
    
    if (!confirm('¿Estás seguro de que quieres eliminar esta imagen?')) {
        return;
    }
    
    fetch(`{{ url('landing/media/eliminar') }}/${mediaId}`, {
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
    fetch('{{ route("landing.media.obtener") }}')
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

// Validación adicional para perfil incompleto
@if(!$profileComplete)
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

// Activar tab de empresa si hay errores en campos empresariales
document.addEventListener('DOMContentLoaded', function() {
    const empresaErrors = document.querySelectorAll('#empresa .is-invalid');
    if (empresaErrors.length > 0) {
        const empresaTab = document.getElementById('empresa-tab');
        const empresaTabPane = document.getElementById('empresa');
        const contenidoTab = document.getElementById('contenido-tab');
        const contenidoTabPane = document.getElementById('contenido');
        
        if (empresaTab && empresaTabPane && contenidoTab && contenidoTabPane) {
            // Desactivar tab de contenido
            contenidoTab.classList.remove('active');
            contenidoTab.setAttribute('aria-selected', 'false');
            contenidoTabPane.classList.remove('show', 'active');
            
            // Activar tab de empresa
            empresaTab.classList.add('active');
            empresaTab.setAttribute('aria-selected', 'true');
            empresaTabPane.classList.add('show', 'active');
        }
    }
});

// Función para cargar texto base en documentos legales
function cargarTextoBase(tipoDocumento) {
    const textarea = document.getElementById(tipoDocumento);
    
    if (!textarea) {
        console.error('Textarea no encontrado para:', tipoDocumento);
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
    const currentContent = textarea.value.trim();
    if (currentContent.length > 10) {
        if (!confirm('Ya tienes contenido escrito. ¿Quieres reemplazarlo con el texto base?')) {
            return;
        }
    }
    
    // Cargar el texto base
    const textoBase = documentosLegalesBase[tipoDocumento];
    if (textoBase) {
        textarea.value = textoBase.trim();
        
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
        
        // Scroll al textarea
        textarea.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

// Función para publicar la landing page
function publishLanding() {
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
            form.action = '{{ route("landing.publicar") }}';
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

// Función para validar formulario antes de envío
function validarFormularioAntesDeEnvio() {
    const empresaNombre = document.getElementById('empresa_nombre')?.value?.trim() || '';
    const whatsapp = document.getElementById('whatsapp')?.value?.trim() || '';
    
    if (!empresaNombre || !whatsapp) {
        // Cambiar al tab de empresa si hay campos faltantes
        const empresaTab = document.getElementById('empresa-tab');
        const empresaTabPane = document.getElementById('empresa');
        
        if (empresaTab && empresaTabPane) {
            // Activar el tab de empresa
            const tabTrigger = new bootstrap.Tab(empresaTab);
            tabTrigger.show();
        }
        
        // Mostrar alerta
        Swal.fire({
            title: 'Campos requeridos faltantes',
            html: 'Para guardar la configuración necesitas completar:<br>' +
                  (!empresaNombre ? '• <strong>Nombre de la Empresa</strong><br>' : '') +
                  (!whatsapp ? '• <strong>WhatsApp</strong><br>' : ''),
            icon: 'warning',
            confirmButtonText: 'Entendido'
        });
        
        return false;
    }
    
    return true;
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
    const guardarBtn = document.querySelector('button[form="landing-form"]');
    
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
        
        if (debeDeshabilitarse) {
            publicarBtn.classList.add('disabled');
            publicarBtn.disabled = true;
            
            // Determinar el motivo específico del bloqueo
            if (estadoLanding === 'en_construccion') {
                publicarBtn.innerHTML = '<i class="bi bi-tools me-1"></i>En Construcción';
                publicarBtn.title = 'Tu landing ya está en construcción';
            } else if (estadoLanding === 'publicada') {
                publicarBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i>Ya Publicada';
                publicarBtn.title = 'Tu landing ya está publicada';
            } else if (!profileComplete) {
                publicarBtn.innerHTML = '<i class="bi bi-person-x me-1"></i>Perfil Incompleto';
                publicarBtn.title = 'Completa tu perfil para publicar';
            } else if (!camposCompletosPublicar) {
                publicarBtn.innerHTML = '<i class="bi bi-exclamation-triangle me-1"></i>Campos Incompletos';
                publicarBtn.title = 'Completa el nombre de la empresa y WhatsApp para publicar';
            }
        } else {
            publicarBtn.classList.remove('disabled');
            publicarBtn.disabled = false;
            publicarBtn.innerHTML = '<i class="bi bi-rocket me-1"></i>Publicar';
            publicarBtn.title = 'Tu landing está lista para publicar';
        }
    }
    
    // Validar campos para guardar
    if (guardarBtn) {
        const estadoLanding = '{{ $estadoLanding }}';
        const profileComplete = {{ $profileComplete ? 'true' : 'false' }};
        
        // Campos requeridos para guardar configuración completa
        const camposCompletosGuardar = empresaNombre && logo && colorPrincipal && colorSecundario && tipografia && estilo;
        
        const debeDeshabilitarseGuardar = (
            estadoLanding === 'en_construccion' || 
            !profileComplete || 
            !camposCompletosGuardar
        );
        
        if (debeDeshabilitarseGuardar) {
            guardarBtn.classList.add('disabled');
            guardarBtn.disabled = true;
            
            if (estadoLanding === 'en_construccion') {
                guardarBtn.title = 'No se puede modificar mientras está en construcción';
            } else if (!profileComplete) {
                guardarBtn.title = 'Completa tu perfil para continuar';
            } else if (!camposCompletosGuardar) {
                guardarBtn.title = 'Completa: logo, información, colores, fuente y estilo';
            }
        } else {
            guardarBtn.classList.remove('disabled');
            guardarBtn.disabled = false;
            guardarBtn.title = '';
        }
    }
}

// Agregar listeners para validación en tiempo real
document.addEventListener('DOMContentLoaded', function() {
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
    
    // Agregar validación al formulario antes del submit
    const landingForm = document.getElementById('landing-form');
    if (landingForm) {
        landingForm.addEventListener('submit', function(e) {
            if (!validarFormularioAntesDeEnvio()) {
                e.preventDefault();
            }
        });
    }
    
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
</script>
@endpush
@endsection