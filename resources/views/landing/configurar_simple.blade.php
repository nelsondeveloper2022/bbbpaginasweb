@extends('layouts.dashboard')

@section('title', 'Configurar Landing Page')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="bi bi-gear me-2"></i>
                        Configurar Landing Page
                    </h1>
                    <p class="text-muted mb-0">Configura tu página de aterrizaje de forma simple y rápida</p>
                </div>
                <div>
                    @if(($empresa->estado ?? 'nuevo') === 'en_construccion')
                        <button type="submit" form="landing-form" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>
                            Guardar
                        </button>
                    @elseif(($empresa->estado ?? 'nuevo') === 'publicada')
                        <button type="submit" form="landing-form" class="btn btn-warning">
                            <i class="bi bi-arrow-clockwise me-1"></i>
                            Actualizar
                        </button>
                    @else
                        <button type="submit" form="landing-form" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>
                            Guardar Configuración
                        </button>
                    @endif
                </div>
            </div>

            @if($estadoLanding === 'en_construccion')
                <!-- Alerta de landing en construcción -->
                <div class="alert alert-warning border-0 shadow-sm mb-4">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-tools me-3 fs-4"></i>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Landing en construcción 🔧</h6>
                            <p class="mb-2"><strong>Formulario bloqueado:</strong> Tu landing está en construcción y no se puede editar.</p>
                            <div class="d-flex gap-2 mt-2">
                                {{-- <button type="button" class="btn btn-warning btn-sm" onclick="publicarLanding()">
                                    <i class="bi bi-rocket-takeoff me-1"></i>
                                    Publicar para Editar
                                </button> --}}
                                <a href="{{ route('admin.landing.preview') }}" class="btn btn-outline-warning btn-sm" target="_blank">
                                    <i class="bi bi-eye me-1"></i>
                                    Vista Previa
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($estadoLanding === 'publicada')
                <!-- Alerta de landing publicada -->
                <div class="alert alert-success border-0 shadow-sm mb-4">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle me-3 fs-4"></i>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">¡Tu landing page está publicada! 🎉</h6>
                            <p class="mb-2">Puedes modificar: imágenes, colores, redes sociales, WhatsApp y teléfono.</p>
                                                                        <small class="text-success">
                                <i class="bi bi-link-45deg me-1"></i>
                                <strong>URL:</strong> 
                                @if($empresa->slug ?? false)
                                    <a href="{{ url($empresa->slug) }}" target="_blank" class="text-success text-decoration-none fw-bold">
                                        {{ url($empresa->slug) }}
                                        <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 0.8rem;"></i>
                                    </a>
                                @else
                                    Generándose...
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
            @elseif(($empresa->estado ?? 'nuevo') === 'en_construccion')
                <!-- Alerta de landing en construcción -->
                <div class="alert alert-warning border-0 shadow-sm mb-4">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-tools me-3 fs-4"></i>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Landing en construcción 🔧</h6>
                            <p class="mb-2">Tu landing está guardada. Podrás publicarla cuando esté lista.</p>
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Completa todos los campos y luego publícala para que esté disponible.
                            </small>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Overlay de bloqueo para estado en construcción -->
            {{-- @if($estadoLanding === 'en_construccion')
                <div class="form-blocked-overlay">
            @endif --}}

            <!-- Formulario Principal -->
            <form id="landing-form" action="{{ route('admin.landing.guardar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="modo_formulario" value="basico">

                <div class="row g-4">
                    <!-- Información Básica -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-building me-2"></i>
                                    Información Básica
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            Nombre de la Empresa <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('empresa_nombre') is-invalid @enderror" 
                                               name="empresa_nombre"
                                               value="{{ old('empresa_nombre', $empresa->nombre ?? auth()->user()->empresa_nombre ?? '') }}"
                                               placeholder="Mi Empresa"
                                               {{ $estadoLanding === 'en_construccion' ? 'readonly' : '' }}
                                               {{ $estadoLanding === 'publicada' ? 'readonly' : 'required' }}>
                                        @error('empresa_nombre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            WhatsApp <span class="text-danger">*</span>
                                        </label>
                                        <input type="tel" 
                                               class="form-control @error('whatsapp') is-invalid @enderror" 
                                               name="whatsapp"
                                               value="{{ old('whatsapp', $empresa->whatsapp ?? '') }}"
                                               placeholder="+57 300 123 4567">
                                        @error('whatsapp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-12">
                                        <label class="form-label fw-bold">
                                            Título Principal <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('titulo_principal') is-invalid @enderror" 
                                               name="titulo_principal"
                                               value="{{ old('titulo_principal', $landing->titulo_principal ?? '') }}"
                                               placeholder="Ej. Crea tu página web profesional en minutos"
                                               {{ $estadoLanding === 'en_construccion' ? 'readonly' : '' }}
                                               {{ $estadoLanding === 'publicada' ? 'readonly' : 'required' }}>
                                        @error('titulo_principal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            Teléfono para Llamadas
                                        </label>
                                        <input type="tel" 
                                               class="form-control @error('movil') is-invalid @enderror" 
                                               name="movil"
                                               value="{{ old('movil', $empresa->movil ?? '') }}"
                                               placeholder="+57 1 234 5678">
                                        @error('movil')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Número de teléfono fijo o móvil para llamadas directas</small>
                                    </div>
                                    
                                    <div class="col-12">
                                        <label class="form-label fw-bold">
                                            Descripción del Negocio <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                                  name="descripcion" 
                                                  rows="3" 
                                                  placeholder="Describe tu negocio, productos o servicios de manera atractiva..."
                                                  {{ $estadoLanding === 'en_construccion' ? 'readonly' : '' }}
                                                  {{ $estadoLanding === 'publicada' ? 'readonly' : 'required' }}>{{ old('descripcion', $landing->descripcion ?? '') }}</textarea>
                                        @error('descripcion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Logo de la Empresa -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-image me-2"></i>
                                    Logo de la Empresa
                                    @if($estadoLanding === 'publicada')
                                        <span class="badge bg-success ms-2">Editable</span>
                                    @endif
                                </h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="logo-preview mb-3" id="logo-preview">
                                    @if($landing->logo_url ?? false)
                                        <img src="{{ Storage::url($landing->logo_url) }}" alt="Logo actual" class="img-fluid rounded" style="max-height: 150px;">
                                    @else
                                        <div class="logo-placeholder bg-light border-2 border-dashed border-secondary rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                            <div class="text-center">
                                                <i class="bi bi-image display-4 text-muted"></i>
                                                <p class="text-muted mt-2 mb-0">Sube tu logo aquí</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <input type="file" 
                                       class="form-control @error('logo') is-invalid @enderror" 
                                       name="logo"
                                       accept="image/*" 
                                       onchange="previewLogo(event)">
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Recomendado: PNG transparente, 300x100px</small>
                            </div>
                        </div>
                    </div>

                    <!-- Imágenes Adicionales -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-images me-2"></i>
                                    Imágenes Adicionales
                                    @if($landing->exists && $landing->estado === 'publicada')
                                        <span class="badge bg-success ms-2">Editable</span>
                                    @endif
                                </h5>
                            </div>
                            <div class="card-body">
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
                                           name="media[]"
                                           class="d-none" 
                                           multiple 
                                           accept="image/*" 
                                           onchange="handleFileSelect(event)">
                                </div>
                                <div id="media-gallery" class="row g-2 mt-3">
                                    <!-- Mostrar imágenes existentes -->
                                    @if(isset($existingMedia) && is_object($existingMedia) && method_exists($existingMedia, 'count') && $existingMedia->count() > 0)
                                        @foreach($existingMedia as $media)
                                            <div class="col-md-3 col-sm-4 col-6">
                                                <div class="media-item position-relative">
                                                    <img src="{{ Storage::url($media->url) }}" 
                                                         alt="{{ $media->description ?? 'Imagen' }}" 
                                                         class="img-fluid rounded shadow-sm" 
                                                         style="height: 120px; width: 100%; object-fit: cover;">
                                                    @if($estadoLanding !== 'en_construccion')
                                                        <button type="button" 
                                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1" 
                                                                onclick="removeExistingImage(this, {{ $media->idMedia }})" 
                                                                title="Eliminar">
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    <!-- Las nuevas imágenes se mostrarán aquí dinámicamente -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Redes Sociales -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-share me-2"></i>
                                    Redes Sociales
                                    @if($estadoLanding === 'publicada')
                                        <span class="badge bg-success ms-2">Editable</span>
                                    @endif
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">
                                            <i class="bi bi-facebook text-primary me-1"></i>
                                            Facebook
                                        </label>
                                        <input type="url" 
                                               class="form-control @error('facebook') is-invalid @enderror" 
                                               name="facebook"
                                               value="{{ old('facebook', $empresa->facebook ?? '') }}"
                                               placeholder="https://facebook.com/tuempresa">
                                        @error('facebook')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label class="form-label">
                                            <i class="bi bi-instagram text-danger me-1"></i>
                                            Instagram
                                        </label>
                                        <input type="url" 
                                               class="form-control @error('instagram') is-invalid @enderror" 
                                               name="instagram"
                                               value="{{ old('instagram', $empresa->instagram ?? '') }}"
                                               placeholder="https://instagram.com/tuempresa">
                                        @error('instagram')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label class="form-label">
                                            <i class="bi bi-twitter text-info me-1"></i>
                                            Twitter/X
                                        </label>
                                        <input type="url" 
                                               class="form-control @error('twitter') is-invalid @enderror" 
                                               name="twitter"
                                               value="{{ old('twitter', $empresa->twitter ?? '') }}"
                                               placeholder="https://twitter.com/tuempresa">
                                        @error('twitter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Colores del Branding -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-palette me-2"></i>
                                    Colores del Branding
                                    @if($estadoLanding === 'publicada')
                                        <span class="badge bg-success ms-2">Editable</span>
                                    @endif
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Color Principal</label>
                                        <div class="input-group">
                                            <input type="color" 
                                                   class="form-control form-control-color" 
                                                   id="color_principal" 
                                                   name="color_principal"
                                                   value="{{ old('color_principal', $landing->color_principal ?? '#007bff') }}">
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="color_principal_text"
                                                   value="{{ old('color_principal', $landing->color_principal ?? '#007bff') }}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Color Secundario</label>
                                        <div class="input-group">
                                            <input type="color" 
                                                   class="form-control form-control-color" 
                                                   id="color_secundario" 
                                                   name="color_secundario"
                                                   value="{{ old('color_secundario', $landing->color_secundario ?? '#6c757d') }}">
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="color_secundario_text"
                                                   value="{{ old('color_secundario', $landing->color_secundario ?? '#6c757d') }}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Vista Previa</label>
                                        <div class="color-preview-sample rounded" 
                                             id="color-preview-sample" 
                                             style="height: 50px; background: linear-gradient(135deg, {{ old('color_principal', $landing->color_principal ?? '#007bff') }}, {{ old('color_secundario', $landing->color_secundario ?? '#6c757d') }});">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($landing->exists && $landing->estado === 'publicada')
                        <!-- Campos bloqueados después de publicar -->
                        <div class="col-12">
                            <div class="card border-warning">
                                <div class="card-header bg-warning bg-opacity-10">
                                    <h5 class="mb-0">
                                        <i class="bi bi-lock me-2"></i>
                                        Campos Bloqueados Después de Publicar
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info mb-3">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Estos campos no se pueden modificar después de la publicación para mantener la consistencia de tu landing.
                                    </div>
                                    
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label text-muted">Subtítulo</label>
                                            <input type="text" class="form-control" value="{{ $landing->subtitulo ?? 'No configurado' }}" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Botón de envío -->
                    <div class="col-12">
                        <div class="text-center">
                            @if($estadoLanding === 'publicada' || $estadoLanding === 'en_construccion')
                                <button type="submit" class="btn btn-warning btn-lg">
                                    <i class="bi bi-arrow-clockwise me-2"></i>
                                    Actualizar Landing Page
                                </button>
                            @else
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-save me-2"></i>
                                    Guardar
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
            
            <!-- Cerrar overlay de bloqueo -->
            {{-- @if($estadoLanding === 'en_construccion')
                </div> <!-- .form-blocked-overlay -->
            @endif --}}
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
// Preview del logo
function previewLogo(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('logo-preview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Logo preview" class="img-fluid rounded" style="max-height: 150px;">`;
        };
        reader.readAsDataURL(file);
    }
}

// Manejo de colores
function initializeColorPickers() {
    const colorPrincipal = document.getElementById('color_principal');
    const colorPrincipalText = document.getElementById('color_principal_text');
    const colorSecundario = document.getElementById('color_secundario');
    const colorSecundarioText = document.getElementById('color_secundario_text');
    const preview = document.getElementById('color-preview-sample');
    
    if (colorPrincipal && colorPrincipalText) {
        colorPrincipal.addEventListener('input', function() {
            colorPrincipalText.value = this.value;
            updateColorPreview();
        });
    }
    
    if (colorSecundario && colorSecundarioText) {
        colorSecundario.addEventListener('input', function() {
            colorSecundarioText.value = this.value;
            updateColorPreview();
        });
    }
    
    function updateColorPreview() {
        if (preview && colorPrincipal && colorSecundario) {
            preview.style.background = `linear-gradient(135deg, ${colorPrincipal.value}, ${colorSecundario.value})`;
        }
    }
}

// Manejo de archivos multimedia
function handleDrop(e) {
    e.preventDefault();
    e.stopPropagation();
    
    const zone = document.getElementById('media-upload-zone');
    zone.classList.remove('drag-over');
    
    const files = e.dataTransfer.files;
    handleFiles(files);
}

function handleDragOver(e) {
    e.preventDefault();
    e.stopPropagation();
    
    const zone = document.getElementById('media-upload-zone');
    zone.classList.add('drag-over');
}

function handleDragLeave(e) {
    e.preventDefault();
    e.stopPropagation();
    
    const zone = document.getElementById('media-upload-zone');
    zone.classList.remove('drag-over');
}

function handleFileSelect(e) {
    const files = e.target.files;
    handleFiles(files);
}

function handleFiles(files) {
    const gallery = document.getElementById('media-gallery');
    
    Array.from(files).forEach(file => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-md-3 col-sm-4 col-6';
                col.innerHTML = `
                    <div class="media-item position-relative">
                        <img src="${e.target.result}" alt="${file.name}" class="img-fluid rounded shadow-sm" style="height: 120px; width: 100%; object-fit: cover;">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1" onclick="removeImage(this)" title="Eliminar">
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

function removeImage(button) {
    const col = button.closest('.col-md-3');
    if (col) {
        col.remove();
    }
}

// Función para eliminar imágenes existentes de la base de datos
function removeExistingImage(button, mediaId) {
    if (confirm('¿Estás seguro de que quieres eliminar esta imagen?')) {
        // Hacer petición AJAX para eliminar la imagen del servidor
        fetch(`{{ url('admin/landing/media') }}/${mediaId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Eliminar el elemento del DOM
                const col = button.closest('.col-md-3');
                if (col) {
                    col.remove();
                }
            } else {
                alert('Error al eliminar la imagen: ' + (data.message || 'Error desconocido'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar la imagen');
        });
    }
}

// Inicializar cuando carga la página
document.addEventListener('DOMContentLoaded', function() {
    initializeColorPickers();
});

// Función para publicar la landing page desde estado en construcción
function publicarLanding() {
    if (confirm('¿Estás seguro de que quieres publicar tu landing page? Una vez publicada, solo podrás editar ciertos campos.')) {
        // Crear formulario temporal para enviar solicitud de publicación
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.landing.publicar") }}'; // Necesitaremos crear esta ruta
        
        // Token CSRF
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Agregar al DOM y enviar
        document.body.appendChild(form);
        form.submit();
    }
}

// Aplicar estilos a campos editables cuando está publicada
document.addEventListener('DOMContentLoaded', function() {
    const estadoLanding = '{{ $estadoLanding }}';
    
    if (estadoLanding === 'publicada') {
        // Resaltar campos editables
        const editableFields = ['whatsapp', 'movil', 'facebook', 'instagram', 'twitter', 'color_principal', 'color_secundario'];
        
        editableFields.forEach(fieldName => {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (field && !field.hasAttribute('readonly') && !field.hasAttribute('disabled')) {
                field.classList.add('editable-field');
                
                // Agregar badge si es un campo de color o social
                if (fieldName.includes('color') || ['facebook', 'instagram', 'twitter'].includes(fieldName)) {
                    const badge = document.createElement('span');
                    badge.className = 'badge bg-success editable-badge';
                    badge.textContent = 'Editable';
                    field.parentElement.style.position = 'relative';
                    field.parentElement.appendChild(badge);
                }
            }
        });
        
        // Logo siempre editable
        const logoInput = document.querySelector('[name="logo"]');
        if (logoInput) {
            logoInput.parentElement.style.position = 'relative';
            const badge = document.createElement('span');
            badge.className = 'badge bg-success editable-badge';
            badge.textContent = 'Editable';
            logoInput.parentElement.appendChild(badge);
        }
    }
    
    initializeColorPickers();
});
</script>

<!-- Estilos CSS -->
<style>

input[readonly],
textarea[readonly] {
    background-color: #f0f0f0;   /* gris claro */
    color: #555;                 /* texto gris oscuro */
    border: 1px solid #ccc;      /* borde suave */
    cursor: not-allowed;         /* cursor de "no permitido" */
    opacity: 0.8;                /* leve transparencia */
}
.form-control-color {
    width: 50px !important;
    height: 38px !important;
    padding: 4px !important;
}

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

.color-preview-sample {
    border: 2px solid #dee2e6;
}

.card-header h5 {
    color: #495057;
}

.badge.bg-success {
    background-color: #198754 !important;
}

.badge.bg-warning {
    background-color: #ffc107 !important;
    color: #000 !important;
}

/* Sistema de bloqueo de formulario */
.form-blocked-overlay {
    position: relative;
    pointer-events: none;
    opacity: 0.7;
}

.form-blocked-overlay::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: repeating-linear-gradient(
        45deg,
        rgba(255, 193, 7, 0.1),
        rgba(255, 193, 7, 0.1) 10px,
        transparent 10px,
        transparent 20px
    );
    z-index: 1;
    pointer-events: none;
    border-radius: 0.375rem;
}

.form-blocked-overlay .card {
    background-color: #f8f9fa;
    border-color: #dee2e6;
}

.form-blocked-overlay .form-control:disabled,
.form-blocked-overlay .form-control[readonly] {
    background-color: #e9ecef;
    opacity: 0.8;
    cursor: not-allowed;
}

.form-blocked-overlay .btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Estilos para campos editables cuando está publicada */
.editable-field {
    border-color: #28a745 !important;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
}

.editable-badge {
    position: absolute;
    top: -8px;
    right: 10px;
    font-size: 0.7rem;
    z-index: 10;
}
</style>
@endsection