@extends('admin.layout')

@section('title', 'Gestión de Usuarios')
@section('page-title', 'Gestión de Usuarios')

@push('styles')
<style>
    .param-suggestions {
        max-height: 400px;
        overflow-y: auto;
    }
    
    .param-suggestions .dropdown-item {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
    }
    
    .param-suggestions .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #198754;
    }
    
    .param-suggestions .dropdown-header {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .template-param {
        font-family: monospace;
    }
</style>
@endpush

@section('content')
<div class="admin-card">
    <div class="admin-card-header d-flex justify-content-between align-items-center">
        <span>
            <i class="fas fa-users me-2"></i>
            Lista de Usuarios
        </span>
        <span class="badge bg-light text-dark">{{ $users->total() }} usuarios</span>
    </div>
    <div class="card-body p-0">
        <!-- Filtros -->
        <div class="p-4 border-bottom">
            <form method="GET" action="{{ route('admin.users') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Buscar por nombre, email o empresa..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="admin" {{ request('status') == 'admin' ? 'selected' : '' }}>Administradores</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Activos</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expirados</option>
                        <option value="with_landing" {{ request('status') == 'with_landing' ? 'selected' : '' }}>Con Landing</option>
                        <option value="without_landing" {{ request('status') == 'without_landing' ? 'selected' : '' }}>Sin Landing</option>
                        <option value="not_configured" {{ request('status') == 'not_configured' ? 'selected' : '' }}>Sin Configurar</option>
                        <option value="construction" {{ request('status') == 'construction' ? 'selected' : '' }}>En Construcción</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Publicadas</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-admin-primary w-100">
                        <i class="fas fa-search me-1"></i>
                        Filtrar
                    </button>
                </div>
                <div class="col-md-3 text-end">
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>
                            Limpiar
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tabla de usuarios -->
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-admin mb-0">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Empresa</th>
                            <th>Plan</th>
                            <th>Estado</th>
                            <th>Landing</th>
                            <th>URL/Estado</th>
                            <th>Días Restantes</th>
                            <th>Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            @if($user->is_admin)
                                                <i class="fas fa-user-shield text-primary"></i>
                                            @else
                                                <i class="fas fa-user text-muted"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($user->empresa)
                                        <div>
                                            <strong>{{ $user->empresa->nombre }}</strong><br>
                                            <small class="text-muted">{{ $user->empresa->email }}</small>
                                        </div>
                                    @else
                                        <div>
                                            <strong>{{ $user->empresa_nombre ?? 'No especificada' }}</strong><br>
                                            <small class="text-muted">{{ $user->empresa_email ?? 'No especificado' }}</small>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($user->plan)
                                        <span class="badge bg-info">{{ $user->plan->nombre }}</span>
                                    @else
                                        <span class="text-muted">Sin plan</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $status = $user->subscription_status;
                                        $statusClass = '';
                                        switch($status) {
                                            case 'Administrador':
                                                $statusClass = 'status-admin';
                                                break;
                                            case 'Activa':
                                                $statusClass = 'status-active';
                                                break;
                                            case 'Trial':
                                                $statusClass = 'status-trial';
                                                break;
                                            case 'Expirada':
                                                $statusClass = 'status-expired';
                                                break;
                                        }
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">{{ $status }}</span>
                                </td>
                                <td>
                                    @if($user->landings_count > 0)
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-globe text-success me-2"></i>
                                            <div>
                                                <small class="fw-bold">{{ $user->landings_count }} landing(s)</small><br>
                                                @php
                                                    $empresaEstado = $user->empresa->estado ?? null;
                                                @endphp
                                                @if($empresaEstado == 'en_construccion')
                                                    <span class="badge bg-warning text-dark">En Construcción</span>
                                                @elseif($empresaEstado == 'publicada')
                                                    <span class="badge bg-success">Publicada</span>
                                                @elseif($empresaEstado == 'sin_configurar' || is_null($empresaEstado))
                                                    <span class="badge bg-secondary">Sin Configurar</span>
                                                @else
                                                    <span class="badge bg-info">{{ ucfirst($empresaEstado) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-minus"></i> Sin landing
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->landings_count > 0 && $user->empresa)
                                        @php
                                            $slug = $user->empresa->slug ?: 'empresa-' . $user->empresa->idEmpresa;
                                            $landingUrl = config('app.url') . '/' . $slug;
                                        @endphp
                                        @if($user->empresa->estado === 'publicada')
                                            <a href="{{ $landingUrl }}" target="_blank" class="btn btn-sm btn-success" title="Ver Landing Publicada">
                                                <i class="fas fa-external-link-alt me-1"></i>
                                                Ver Landing
                                            </a>
                                        @elseif($user->empresa->estado === 'en_construccion')
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-tools me-1"></i>
                                                En Construcción
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Sin Configurar</span>
                                        @endif
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-minus"></i> Sin Landing
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->days_remaining !== null)
                                        <span class="fw-bold {{ $user->days_remaining <= 7 ? 'text-danger' : ($user->days_remaining <= 30 ? 'text-warning' : 'text-success') }}">
                                            {{ $user->days_remaining }} días
                                        </span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $user->created_at->format('d/m/Y') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.user-detail', $user->id) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($user->canBeImpersonated())
                                            <a target="_blank" href="{{ route('admin.impersonate', $user->id) }}" 
                                               class="btn btn-sm btn-outline-info" 
                                               title="Ver dashboard del cliente">
                                                <i class="fas fa-user-check"></i>
                                            </a>
                                        @endif

                                        <button type="button" 
                                                class="btn btn-sm btn-outline-success whatsapp-btn" 
                                                title="Enviar mensaje de WhatsApp"
                                                data-user-id="{{ $user->id }}"
                                                data-user-name="{{ $user->name }}"
                                                data-user-email="{{ $user->email }}"
                                                data-user-phone="{{ $user->movil }}"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#whatsappModal">
                                            <i class="fab fa-whatsapp"></i>
                                        </button>
                                        
                                        @if($user->landings_count > 0 && $user->empresa && $user->empresa->estado === 'en_construccion')
                                            <form method="POST" 
                                                  action="{{ route('admin.publish-landing', $user->id) }}" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Está seguro de publicar esta landing page? Se enviará un email al cliente.')">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-sm btn-success publish-button" 
                                                        title="Publicar Landing">
                                                    <i class="fas fa-rocket"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($users->hasPages())
                <div class="p-4 border-top">
                    {{ $users->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-users text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-muted">No se encontraron usuarios</h5>
                <p class="text-muted">
                    @if(request()->hasAny(['search', 'status']))
                        No hay usuarios que coincidan con los filtros aplicados.
                    @else
                        No hay usuarios registrados en el sistema.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>

<!-- Modal de WhatsApp -->
<div class="modal fade whatsapp-modal" id="whatsappModal" tabindex="-1" aria-labelledby="whatsappModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="whatsappModalLabel">
                    <i class="fab fa-whatsapp text-success me-2"></i>
                    Enviar mensaje de WhatsApp
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Información del usuario -->
                <div class="alert alert-info" id="userInfo" style="display: none;">
                    <h6>Enviando mensaje a:</h6>
                    <div id="userDetails"></div>
                </div>

                <!-- Número de teléfono -->
                <div class="mb-3">
                    <label for="phoneNumber" class="form-label">
                        <i class="fas fa-phone me-1"></i>
                        Número de teléfono (incluir código de país)
                    </label>
                    <input type="text" 
                           class="form-control" 
                           id="phoneNumber" 
                           placeholder="Ej: +573001234567"
                           required>
                    <div class="form-text">
                        <i class="fas fa-info-circle me-1"></i>
                        Se detectará automáticamente el número del usuario. Por defecto se usa +57 (Colombia)
                    </div>
                </div>

                <!-- Selección de plantilla -->
                <div class="mb-3">
                    <label for="templateSelect" class="form-label">
                        <i class="fas fa-file-alt me-1"></i>
                        Seleccionar plantilla
                    </label>
                    <select class="form-select" id="templateSelect" required>
                        <option value="">Cargando plantillas...</option>
                    </select>
                    <div class="form-text">Seleccione una plantilla aprobada para enviar</div>
                </div>

                <!-- Vista previa de la plantilla -->
                <div id="templatePreview" class="mb-3" style="display: none;">
                    <h6>Vista previa:</h6>
                    <div class="template-preview">
                        <div id="previewContent"></div>
                    </div>
                </div>

                <!-- Parámetros dinámicos -->
                <div id="templateParameters" style="display: none;">
                    <h6>Personalizar mensaje:</h6>
                    <div id="parametersContainer"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Cancelar
                </button>
                <button type="button" class="btn btn-success" id="sendTemplateBtn" disabled>
                    <i class="fab fa-whatsapp me-1"></i>
                    Enviar mensaje
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    let templates = [];
    let selectedTemplate = null;
    let currentUserId = null;
    let currentUserData = {}; // Almacenar datos del usuario actual

    // Cargar plantillas al abrir el modal
    $('#whatsappModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        currentUserId = button.data('userId');
        var userName = button.data('userName');
        var userEmail = button.data('userEmail');
        var userPhone = button.data('userPhone');
        
        // Guardar datos del usuario en objeto global
        currentUserData = {
            id: currentUserId,
            name: userName,
            firstName: userName.split(' ')[0] || '',
            fullName: userName,
            email: userEmail,
            phone: userPhone
        };
        
        // Mostrar información del usuario
        $('#userDetails').html(`
            <strong>${userName}</strong><br>
            <small class="text-muted">${userEmail}</small>
        `);
        $('#userInfo').show();

        // Prellenar número de teléfono
        var phoneNumber = '';
        if (userPhone != '') {
            phoneNumber = '+57' + userPhone;
        } else {
            phoneNumber = '+57';
        }
        $('#phoneNumber').val(phoneNumber);
        
        // Cargar datos completos del usuario
        loadUserData(currentUserId);
        
        // Cargar plantillas
        loadTemplates();
    });

    // Limpiar modal al cerrarlo
    $('#whatsappModal').on('hidden.bs.modal', function () {
        resetModal();
    });

    // Manejar cambio de plantilla
    $('#templateSelect').on('change', function() {
        var templateName = $(this).val();
        if (templateName) {
            loadTemplateDetails(templateName);
        } else {
            hideTemplatePreview();
        }
    });

    // Manejar envío de plantilla
    $('#sendTemplateBtn').on('click', function() {
        sendTemplate();
    });

    // Validar y formatear número de teléfono
    $('#phoneNumber').on('input', function() {
        let value = $(this).val();
        
        // Formatear automáticamente
        if (value && !value.startsWith('+')) {
            // Si el usuario borra el +57, lo agregamos de vuelta
            $(this).val('+57' + value.replace(/[^\d]/g, ''));
        }
        
        validateForm();
    });

    function loadUserData(userId) {
        $.get(`/admin/whatsapp/user-data/${userId}`)
            .done(function(response) {
                if (response.success && response.data) {
                    // Extender currentUserData con todos los datos del servidor
                    Object.assign(currentUserData, response.data);
                    console.log('Datos del usuario cargados:', currentUserData);
                } else {
                    console.error('Error al cargar datos del usuario:', response.message || 'Respuesta inválida');
                    // Mantener datos básicos del usuario
                    console.warn('Usando datos básicos del usuario');
                }
            })
            .fail(function(xhr) {
                console.error('Error al obtener datos del usuario:', xhr);
                let errorMsg = 'Error desconocido';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                } else if (xhr.statusText) {
                    errorMsg = xhr.statusText;
                }
                console.error('Detalles del error:', errorMsg);
                // Continuar con datos básicos disponibles
            });
    }

    function loadTemplates() {
        $('#templateSelect').html('<option value="">Cargando plantillas...</option>');
        $('#sendTemplateBtn').prop('disabled', true);
        
        $.get('{{ route("admin.whatsapp.templates") }}')
            .done(function(response) {
                if (response.success) {
                    templates = response.templates;
                    populateTemplateSelect();
                } else {
                    showError('Error al cargar las plantillas: ' + response.message);
                }
            })
            .fail(function(xhr) {
                showError('Error al conectar con WhatsApp Business API');
                console.error('Error:', xhr.responseJSON);
            });
    }

    function populateTemplateSelect() {
        var $select = $('#templateSelect');
        $select.html('<option value="">Seleccione una plantilla...</option>');
        
        templates.forEach(function(template) {
            $select.append(`<option value="${template.name}">${template.name} (${template.language})</option>`);
        });
    }

    function loadTemplateDetails(templateName) {
        $('#templatePreview').hide();
        $('#templateParameters').hide();
        
        selectedTemplate = templates.find(t => t.name === templateName);
        
        if (selectedTemplate) {
            showTemplatePreview(selectedTemplate);
        }
        
        validateForm();
    }

    function showTemplatePreview(template) {
        let previewHtml = `
            <div class="mb-2">
                <strong>Plantilla:</strong> ${template.name}<br>
                <strong>Idioma:</strong> ${template.language}<br>
                <strong>Categoría:</strong> ${template.category}
            </div>
        `;

        let parametersHtml = '';
        let hasParameters = false;

        // Procesar componentes de la plantilla
        if (template.components) {
            template.components.forEach(function(component, compIndex) {
                if (component.type === 'HEADER') {
                    previewHtml += `<div class="fw-bold mb-2">${component.text || '[ENCABEZADO]'}</div>`;
                    
                    if (component.parameters) {
                        hasParameters = true;
                        parametersHtml += `<div class="mb-3">
                            <label class="form-label"><strong>Parámetros del encabezado:</strong></label>`;
                        
                        component.parameters.forEach(function(param, paramIndex) {
                            parametersHtml += `
                                <input type="text" 
                                       class="form-control parameter-input mb-2 template-param" 
                                       data-component="header" 
                                       data-index="${paramIndex}"
                                       placeholder="Parámetro ${paramIndex + 1} del encabezado">`;
                        });
                        parametersHtml += '</div>';
                    }
                } else if (component.type === 'BODY') {
                    let bodyText = component.text || '[CUERPO DEL MENSAJE]';
                    
                    // Detectar placeholders tanto numéricos como con nombres descriptivos
                    let placeholders = bodyText.match(/\{\{[^\}]+\}\}/g) || [];
                    
                    if (placeholders.length > 0) {
                        hasParameters = true;
                        parametersHtml += '<div class="mb-3"><label class="form-label"><strong>Parámetros del mensaje:</strong></label>';
                        
                        placeholders.forEach(function(placeholder, i) {
                            // Extraer el nombre del placeholder sin las llaves
                            let placeholderName = placeholder.replace(/\{\{|\}\}/g, '');
                            let friendlyName = placeholderName.replace(/_/g, ' ');
                            friendlyName = friendlyName.charAt(0).toUpperCase() + friendlyName.slice(1);
                            
                            parametersHtml += '<div class="mb-3">';
                            parametersHtml += '<label class="form-label">' + friendlyName + ':</label>';
                            parametersHtml += '<div class="input-group">';
                            parametersHtml += '<input type="text" class="form-control parameter-input template-param" data-component="body" data-index="' + i + '" data-placeholder="' + placeholderName + '" placeholder="Escriba o seleccione una opción">';
                            parametersHtml += '<button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Sugerencias automáticas">';
                            parametersHtml += '<i class="fas fa-magic"></i>';
                            parametersHtml += '</button>';
                            parametersHtml += '<ul class="dropdown-menu dropdown-menu-end param-suggestions">';
                            parametersHtml += '<li><h6 class="dropdown-header">Datos del cliente</h6></li>';
                            parametersHtml += '<li><a class="dropdown-item param-option" href="#" data-value="@{{nombre@}}">Nombre completo</a></li>';
                            parametersHtml += '<li><a class="dropdown-item param-option" href="#" data-value="@{{email@}}">Email</a></li>';
                            parametersHtml += '<li><hr class="dropdown-divider"></li>';
                            parametersHtml += '<li><h6 class="dropdown-header">Empresa y Landing</h6></li>';
                            parametersHtml += '<li><a class="dropdown-item param-option" href="#" data-value="@{{empresa_nombre@}}">Nombre de la empresa</a></li>';
                            parametersHtml += '<li><a class="dropdown-item param-option" href="#" data-value="@{{empresa_email@}}">Email de la empresa</a></li>';
                            parametersHtml += '<li><hr class="dropdown-divider"></li>';
                            parametersHtml += '<li><h6 class="dropdown-header">Suscripción</h6></li>';
                            parametersHtml += '<li><a class="dropdown-item param-option" href="#" data-value="@{{plan_nombre@}}">Plan actual</a></li>';
                            parametersHtml += '<li><a class="dropdown-item param-option" href="#" data-value="@{{fecha_vencimiento@}}">Fecha de vencimiento</a></li>';
                            parametersHtml += '<li><a class="dropdown-item param-option" href="#" data-value="@{{dias_restantes@}}">Días restantes</a></li>';
                            parametersHtml += '<li><a class="dropdown-item param-option" href="#" data-value="@{{estado_suscripcion@}}">Estado de suscripción</a></li>';
                            parametersHtml += '<li><hr class="dropdown-divider"></li>';
                            parametersHtml += '<li><h6 class="dropdown-header">Enlaces</h6></li>';
                            parametersHtml += '<li><a class="dropdown-item param-option" href="#" data-value="@{{enlace_formulario@}}">Enlace al formulario</a></li>';
                            parametersHtml += '<li><a class="dropdown-item param-option" href="#" data-value="@{{enlace_panel@}}">Enlace al panel</a></li>';
                            parametersHtml += '</ul>';
                            parametersHtml += '</div>';
                            parametersHtml += '<small class="text-muted param-help">Escriba manualmente o seleccione una variable del menú</small>';
                            parametersHtml += '</div>';
                        });
                        parametersHtml += '</div>';
                    }
                    
                    previewHtml += `<div class="mb-2">${bodyText}</div>`;
                } else if (component.type === 'FOOTER') {
                    previewHtml += `<div class="small text-muted">${component.text || '[PIE]'}</div>`;
                }
            });
        }

        $('#previewContent').html(previewHtml);
        $('#templatePreview').show();

        if (hasParameters) {
            $('#parametersContainer').html(parametersHtml);
            $('#templateParameters').show();
            
            // Agregar event listeners para actualizar la vista previa
            $('.template-param').on('input', function() {
                // Si el usuario escribe manualmente, quitar el estilo de variable auto-insertada
                let $this = $(this);
                if ($this.hasClass('text-success')) {
                    $this.removeClass('text-success fw-bold');
                    $this.removeAttr('data-original-variable');
                    
                    // Restaurar texto de ayuda
                    let $helpText = $this.closest('.input-group').parent().find('.param-help');
                    if ($helpText.length > 0) {
                        $helpText.html('Escriba manualmente o seleccione una variable del menú');
                        $helpText.removeClass('text-success').addClass('text-muted');
                    }
                }
                
                updatePreviewWithParameters();
                validateForm();
            });
            
            // Manejar clic en opciones de parámetros
            $(document).on('click', '.param-option', function(e) {
                e.preventDefault();
                let variableName = $(this).data('value');
                let $inputGroup = $(this).closest('.input-group');
                let $input = $inputGroup.find('.template-param');
                let $helpText = $inputGroup.parent().find('.param-help');
                
                // Reemplazar la variable con el valor real
                let realValue = replaceUserVariables(variableName);
                
                // Mostrar el valor real en el input
                $input.val(realValue);
                
                // Agregar un indicador visual de que se usó una variable
                $input.attr('data-original-variable', variableName);
                $input.addClass('text-success fw-bold');
                
                // Actualizar el texto de ayuda para mostrar qué se insertó
                if ($helpText.length > 0) {
                    let variableLabel = variableName.replace(/@\{\{|\@\}\}/g, '').replace(/_/g, ' ');
                    $helpText.html('<i class="fas fa-check-circle text-success"></i> Valor insertado: <strong>' + realValue + '</strong>');
                    $helpText.removeClass('text-muted').addClass('text-success');
                }
                
                updatePreviewWithParameters();
                validateForm();
            });
        } else {
            $('#templateParameters').hide();
        }

        validateForm();
    }

    function updatePreviewWithParameters() {
        if (!selectedTemplate) return;

        let previewHtml = `
            <div class="mb-2">
                <strong>Plantilla:</strong> ${selectedTemplate.name}<br>
                <strong>Idioma:</strong> ${selectedTemplate.language}<br>
                <strong>Categoría:</strong> ${selectedTemplate.category}
            </div>
        `;

        selectedTemplate.components.forEach(function(component) {
            if (component.type === 'HEADER') {
                let headerText = component.text || '[ENCABEZADO]';
                
                // Reemplazar parámetros del header
                $('input[data-component="header"]').each(function(index) {
                    let value = $(this).val() || '@{{' + (index + 1) + '@}}';
                    // Reemplazar variables con valores reales para la vista previa
                    value = replaceUserVariables(value);
                    headerText = headerText.replace('@{{' + (index + 1) + '@}}', value);
                });
                
                previewHtml += '<div class="fw-bold mb-2">' + headerText + '</div>';
            } else if (component.type === 'BODY') {
                let bodyText = component.text || '[CUERPO DEL MENSAJE]';
                
                // Reemplazar parámetros del body
                $('input[data-component="body"]').each(function(index) {
                    let value = $(this).val() || '@{{' + (index + 1) + '@}}';
                    // Reemplazar variables con valores reales para la vista previa
                    value = replaceUserVariables(value);
                    bodyText = bodyText.replace('@{{' + (index + 1) + '@}}', value);
                });
                
                previewHtml += '<div class="mb-2">' + bodyText + '</div>';
            } else if (component.type === 'FOOTER') {
                previewHtml += '<div class="small text-muted">' + (component.text || '[PIE]') + '</div>';
            }
        });

        $('#previewContent').html(previewHtml);
    }

    function validateForm() {
        let isValid = true;
        
        // Validar número de teléfono
        let phone = $('#phoneNumber').val().trim();
        if (!phone || phone.length < 10) {
            isValid = false;
        }
        
        // Validar plantilla seleccionada
        if (!selectedTemplate) {
            isValid = false;
        }
        
        // Validar parámetros requeridos solo si hay campos de parámetros visibles
        let requiredParams = $('.template-param:visible');
        if (requiredParams.length > 0) {
            requiredParams.each(function() {
                // El campo debe tener al menos algún valor
                if (!$(this).val() || $(this).val().trim() === '') {
                    isValid = false;
                    return false; // break del each
                }
            });
        }
        
        $('#sendTemplateBtn').prop('disabled', !isValid);
        return isValid;
    }

    function replaceUserVariables(text) {
        if (!text) return text;
        if (!currentUserData || typeof currentUserData !== 'object') {
            console.warn('currentUserData no está disponible o no es válido');
            return text;
        }
        
        // Función auxiliar para obtener valor seguro
        const safeValue = (value) => {
            if (value === null || value === undefined) return '';
            if (typeof value === 'number') return value.toString();
            return String(value);
        };
        
        // Mapeo de variables a valores reales
        const variables = {
            // Datos del cliente
            '@{{nombre@}}': safeValue(currentUserData.nombre || currentUserData.fullName),
            '@{{nombre_cliente@}}': safeValue(currentUserData.nombre_cliente || currentUserData.nombre || currentUserData.fullName),
            '@{{nombre_corto@}}': safeValue(currentUserData.nombre_corto || currentUserData.firstName),
            '@{{email@}}': safeValue(currentUserData.email),
            '@{{telefono@}}': safeValue(currentUserData.telefono || currentUserData.phone),
            // Datos de empresa y página
            '@{{empresa_nombre@}}': safeValue(currentUserData.empresa_nombre),
            '@{{nombre_pagina@}}': safeValue(currentUserData.nombre_pagina || currentUserData.empresa_nombre || 'tu página web'),
            '@{{empresa_email@}}': safeValue(currentUserData.empresa_email),
            // Datos de suscripción
            '@{{plan_nombre@}}': safeValue(currentUserData.plan_nombre),
            '@{{fecha_vencimiento@}}': safeValue(currentUserData.fecha_vencimiento),
            '@{{dias_restantes@}}': safeValue(currentUserData.dias_restantes),
            '@{{estado_suscripcion@}}': safeValue(currentUserData.estado_suscripcion),
            // Enlaces
            '@{{enlace_formulario@}}': safeValue(currentUserData.enlace_formulario || 'https://bbbpaginasweb.com/admin/landing/configurar'),
            '@{{enlace_panel@}}': safeValue(currentUserData.enlace_panel || 'https://bbbpaginasweb.com/login'),
            '@{{url_login@}}': safeValue(currentUserData.url_login || 'https://bbbpaginasweb.com/login')
        };
        
        // Reemplazar todas las variables
        let result = text;
        try {
            for (const [variable, value] of Object.entries(variables)) {
                result = result.replace(new RegExp(escapeRegExp(variable), 'g'), value);
            }
        } catch (error) {
            console.error('Error al reemplazar variables:', error);
            return text;
        }
        
        return result;
    }
    
    function escapeRegExp(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    function sendTemplate() {
        let phone = $('#phoneNumber').val().trim();
        // Limpiar el número: mantener solo números y el signo +
        phone = phone.replace(/[^\d+]/g, '');
        
        // Si no empieza con +, agregar +57
        if (!phone.startsWith('+')) {
            phone = '+57' + phone;
        }
        
        // Remover el + para el envío (WhatsApp API requiere solo números)
        phone = phone.replace('+', '');
        
        let parameters = {
            body: [],
            header: []
        };
        
        // Recopilar parámetros del body y reemplazar variables
        $('input[data-component="body"]').each(function() {
            let value = $(this).val().trim();
            if (value) {
                // Reemplazar variables con datos reales del usuario
                value = replaceUserVariables(value);
                parameters.body.push(value);
            }
        });
        
        // Recopilar parámetros del header
        $('input[data-component="header"]').each(function() {
            let value = $(this).val().trim();
            if (value) {
                // Reemplazar variables con datos reales del usuario
                value = replaceUserVariables(value);
                parameters.header.push(value);
            }
        });
        
        // Remover arrays vacíos
        if (parameters.body.length === 0) {
            delete parameters.body;
        }
        if (parameters.header.length === 0) {
            delete parameters.header;
        }
        
        let requestData = {
            to: phone,
            template_name: selectedTemplate.name,
            language: selectedTemplate.language,
            _token: '{{ csrf_token() }}'
        };
        
        // Solo agregar parameters si tiene contenido
        if (Object.keys(parameters).length > 0) {
            requestData.parameters = parameters;
        }
        
        // Mostrar loading
        $('#sendTemplateBtn').html('<i class="fas fa-spinner fa-spin me-1"></i>Enviando...').prop('disabled', true);
        
        $.post('{{ route("admin.whatsapp.send.template") }}', requestData)
            .done(function(response) {
                if (response.success) {
                    showSuccess('Mensaje enviado exitosamente');
                    $('#whatsappModal').modal('hide');
                } else {
                    let errorMsg = response.message || 'Error al enviar mensaje';
                    if (response.debug) {
                        console.error('Debug info:', response.debug);
                    }
                    showError(errorMsg);
                }
            })
            .fail(function(xhr) {
                let errorMsg = 'Error al enviar el mensaje';
                
                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    if (xhr.responseJSON.debug) {
                        console.error('Debug info:', xhr.responseJSON.debug);
                    }
                    if (xhr.responseJSON.errors) {
                        console.error('Validation errors:', xhr.responseJSON.errors);
                        // Mostrar errores de validación
                        let validationErrors = Object.values(xhr.responseJSON.errors).flat();
                        if (validationErrors.length > 0) {
                            errorMsg = validationErrors.join('. ');
                        }
                    }
                }
                
                showError(errorMsg);
            })
            .always(function() {
                $('#sendTemplateBtn').html('<i class="fab fa-whatsapp me-1"></i>Enviar mensaje').prop('disabled', false);
            });
    }

    function hideTemplatePreview() {
        $('#templatePreview').hide();
        $('#templateParameters').hide();
        selectedTemplate = null;
        validateForm();
    }

    function resetModal() {
        $('#phoneNumber').val('+57');
        $('#templateSelect').html('<option value="">Seleccione una plantilla...</option>');
        $('#userInfo').hide();
        hideTemplatePreview();
        selectedTemplate = null;
        currentUserId = null;
        $('#sendTemplateBtn').prop('disabled', true);
    }

    function showSuccess(message) {
        // Crear notificación de éxito con mejor estilo
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: message,
                timer: 3000,
                showConfirmButton: false
            });
        } else {
            // Fallback a alert mejorado
            alert('✅ Éxito: ' + message);
        }
    }

    function showError(message) {
        // Crear notificación de error con mejor estilo
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#d33'
            });
        } else {
            // Fallback con alert más detallado
            alert('❌ Error: ' + message);
        }
    }
});
</script>
@endpush

@endsection