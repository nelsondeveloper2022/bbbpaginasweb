@extends('layouts.dashboard')

@section('title', 'Configurar Landing Page')

@php
    $estadoLanding = $empresa->estado ?? 'sin_configurar';
    $isPublished = $estadoLanding === 'publicada';
    $isUnderConstruction = $estadoLanding === 'en_construccion';
    $disabledLanding = $isPublished ? 'disabled' : '';
@endphp

@section('content')
    <div class="content-header mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center mb-2">
                    <div class="header-icon bg-primary-gold bg-opacity-10 rounded-circle p-3 me-3">
                        <i class="bi bi-palette text-primary-gold fs-4"></i>
                    </div>
                    <div>
                        <h1 class="dashboard-title mb-0">Configuración de Landing Page</h1>
                        <p class="text-muted mb-0">Personaliza tu sitio web con herramientas avanzadas</p>
                    </div>
                </div>
                
                <!-- Status Badge with Progress -->
                <div class="d-flex align-items-center gap-3">
                    @if($isPublished)
                        <div class="status-badge status-published">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <span>Publicada</span>
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <small class="text-success">
                            <i class="bi bi-globe me-1"></i>
                            Disponible en línea
                        </small>
                    @elseif($isUnderConstruction)
                        <div class="status-badge status-construction">
                            <i class="bi bi-tools me-2"></i>
                            <span>En construcción</span>
                            <div class="status-indicator bg-warning"></div>
                        </div>
                        <small class="text-warning">
                            <i class="bi bi-clock me-1"></i>
                            Procesando cambios
                        </small>
                    @else
                        <div class="status-badge status-draft">
                            <i class="bi bi-file-earmark-text me-2"></i>
                            <span>Borrador</span>
                            <div class="status-indicator bg-secondary"></div>
                        </div>
                        <small class="text-muted">
                            <i class="bi bi-pencil me-1"></i>
                            Listo para configurar
                        </small>
                    @endif
                </div>
            </div>
            
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <div class="d-flex flex-column flex-lg-row gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.landing.preview') }}" class="btn btn-outline-primary-gold btn-action">
                        <i class="bi bi-eye me-2"></i>
                        Vista previa
                    </a>
                    @if($isPublished)
                        <a href="{{ $empresa->getLandingUrl() }}" target="_blank" class="btn btn-primary-gold btn-action">
                            <i class="bi bi-box-arrow-up-right me-2"></i>
                            Ver en vivo
                        </a>
                    @else
                        <button type="button" class="btn btn-success btn-action" id="publishBtn" 
                                {{ !$profileComplete ? 'disabled' : '' }}>
                            <i class="bi bi-upload me-2"></i>
                            Publicar
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(!$profileComplete)
        <div class="alert alert-enhanced alert-warning" role="alert">
            <div class="alert-content">
                <div class="alert-icon">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <div class="alert-body">
                    <h6 class="alert-title">Completa tu perfil para continuar</h6>
                    <p class="alert-text">Para configurar y publicar tu landing, debes completar los datos de tu empresa y verificar tu correo electrónico.</p>
                    @if(isset($profileCompletion))
                        <div class="progress-wrapper mt-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="progress-label">Progreso del perfil</span>
                                <span class="progress-value">{{ $profileCompletion }}%</span>
                            </div>
                            <div class="progress progress-enhanced">
                                <div class="progress-bar bg-warning" 
                                     role="progressbar" 
                                     style="width: {{ $profileCompletion }}%;"
                                     aria-valuenow="{{ $profileCompletion }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="alert-actions mt-3">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-person-gear me-1"></i>
                            Completar perfil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-12 col-xl-8">
            <div class="card card-enhanced shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="header-section">
                            <div class="d-flex align-items-center gap-3">
                                <div class="header-icon-sm bg-primary-gold bg-opacity-10 rounded-circle p-2">
                                    <i class="bi bi-sliders2-vertical text-primary-gold"></i>
                                </div>
                                <div>
                                    <h5 class="card-title mb-0">Configuración</h5>
                                    <small class="text-muted">Elige tu modo de trabajo preferido</small>
                                </div>
                            </div>
                        </div>
                        <div class="mode-selector">
                            <div class="btn-group shadow-sm" role="group" aria-label="Selector de modo" id="modeToggle">
                                <a href="{{ route('admin.landing.configurar', ['modo' => 'basico']) }}" 
                                   data-mode="basico" 
                                   class="btn btn-sm mode-toggle {{ $modo === 'avanzado' ? 'btn-outline-primary' : 'btn-primary-gold' }}">
                                    <i class="bi bi-lightning-charge me-1"></i>
                                    Básico
                                </a>
                                <a href="{{ route('admin.landing.configurar', ['modo' => 'avanzado']) }}" 
                                   data-mode="avanzado" 
                                   class="btn btn-sm mode-toggle {{ $modo === 'avanzado' ? 'btn-primary-gold' : 'btn-outline-primary' }}">
                                    <i class="bi bi-gear me-1"></i>
                                    Avanzado
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body pt-2">
                    <!-- Mode Description -->
                    <div class="mode-description mb-4">
                        <div id="basicDescription" class="description-card {{ $modo !== 'avanzado' ? 'd-block' : 'd-none' }}">
                            <div class="d-flex align-items-start gap-3">
                                <div class="description-icon bg-success bg-opacity-10 rounded-circle p-2">
                                    <i class="bi bi-lightning-charge text-success"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Modo Básico - Configuración Rápida</h6>
                                    <p class="text-muted mb-0 small">Perfecto para comenzar. Solo configura lo esencial: nombre, descripción, logo y colores básicos.</p>
                                </div>
                            </div>
                        </div>
                        <div id="advancedDescription" class="description-card {{ $modo === 'avanzado' ? 'd-block' : 'd-none' }}">
                            <div class="d-flex align-items-start gap-3">
                                <div class="description-icon bg-primary bg-opacity-10 rounded-circle p-2">
                                    <i class="bi bi-gear text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Modo Avanzado - Control Total</h6>
                                    <p class="text-muted mb-0 small">Configuración completa con todas las opciones: SEO, redes sociales, políticas, dominio personalizado y más.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Enhanced tabs --}}
                    <ul class="nav nav-tabs nav-tabs-enhanced" id="configTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $modo !== 'avanzado' ? 'active' : '' }}" 
                                    id="basico-tab" 
                                    data-bs-toggle="tab" 
                                    data-bs-target="#tabBasico" 
                                    type="button" 
                                    role="tab">
                                <i class="bi bi-lightning-charge me-2"></i>
                                Modo Básico
                                <span class="tab-badge bg-success">Recomendado</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $modo === 'avanzado' ? 'active' : '' }}" 
                                    id="avanzado-tab" 
                                    data-bs-toggle="tab" 
                                    data-bs-target="#tabAvanzado" 
                                    type="button" 
                                    role="tab">
                                <i class="bi bi-gear-wide-connected me-2"></i>
                                Modo Avanzado
                                <span class="tab-badge bg-primary">Pro</span>
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content tab-content-enhanced pt-4">
                        <div class="tab-pane fade {{ $modo !== 'avanzado' ? 'show active' : '' }}" id="tabBasico" role="tabpanel">
                            @include('admin.landing.partials._form_basico', compact('empresa', 'landing', 'tipografiaOptions', 'estiloOptions', 'disabledLanding', 'modo', 'isPublished'))
                        </div>
                        <div class="tab-pane fade {{ $modo === 'avanzado' ? 'show active' : '' }}" id="tabAvanzado" role="tabpanel">
                            @include('admin.landing.partials._form_avanzado', compact('empresa', 'landing', 'objetivoOptions', 'tipografiaOptions', 'estiloOptions', 'disabledLanding', 'modo', 'isPublished'))
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <!-- Enhanced Preview Card -->
            <div class="card card-enhanced shadow-sm sticky-top" style="top: 1rem;">
                <div class="card-header bg-transparent border-0">
                    <div class="d-flex align-items-center gap-2">
                        <div class="header-icon-sm bg-info bg-opacity-10 rounded-circle p-2">
                            <i class="bi bi-eye text-info"></i>
                        </div>
                        <h6 class="mb-0">Vista Previa en Tiempo Real</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div id="preview" class="preview-container rounded-3 p-4 position-relative overflow-hidden" 
                         style="background: linear-gradient(135deg, var(--color-primary, #0d6efd), #0a58ca); color: #fff; min-height: 280px;">
                        
                        <!-- Preview content -->
                        <div class="preview-content">
                            <div class="text-center mb-3">
                                <div class="logo-preview-container">
                                    <img id="previewLogo" 
                                         src="{{ $landing->logo_url ? asset('storage/'.$landing->logo_url) : '' }}" 
                                         alt="Logo" 
                                         class="img-fluid preview-logo" 
                                         style="max-height:70px; {{ $landing->logo_url ? '' : 'display:none;' }}" />
                                    <div id="logoPlaceholder" class="logo-placeholder {{ $landing->logo_url ? 'd-none' : '' }}">
                                        <i class="bi bi-image fs-2 opacity-50"></i>
                                        <small class="d-block opacity-75">Logo aquí</small>
                                    </div>
                                </div>
                            </div>
                            
                            <h4 id="previewTitulo" class="fw-bold mb-2 preview-title">
                                {{ old('titulo_principal', $landing->titulo_principal ?? ($empresa->nombre ?? 'Mi Empresa')) }}
                            </h4>
                            
                            <p id="previewSubtitulo" class="mb-3 opacity-75 preview-subtitle">
                                {{ old('subtitulo', $landing->subtitulo ?? 'Tu subtítulo aparecerá aquí') }}
                            </p>
                            
                            <div class="preview-description p-3 rounded-2" style="background-color: var(--color-secondary, rgba(255,255,255,.15));">
                                <small id="previewDescripcion" class="opacity-75">
                                    {{ old('descripcion', $landing->descripcion ?? 'La descripción de tu negocio se mostrará aquí...') }}
                                </small>
                            </div>
                        </div>
                        
                        <!-- Preview overlay for better visual feedback -->
                        <div class="preview-overlay position-absolute top-0 start-0 w-100 h-100" style="background: radial-gradient(circle at 50% 0%, rgba(255,255,255,0.1), transparent 70%); pointer-events: none;"></div>
                    </div>
                    
                    <!-- Color indicators -->
                    <div class="color-indicators mt-3 d-flex gap-2 flex-wrap">
                        <div class="color-indicator">
                            <span class="badge rounded-pill px-3 py-2" id="badgeColorPrincipal" 
                                  style="background-color: {{ old('color_principal', $landing->color_principal ?? '#0d6efd') }};">
                                <i class="bi bi-circle-fill me-1"></i>
                                Principal
                            </span>
                        </div>
                        <div class="color-indicator">
                            <span class="badge rounded-pill px-3 py-2 text-dark" id="badgeColorSecundario" 
                                  style="background-color: {{ old('color_secundario', $landing->color_secundario ?? '#6c757d') }};">
                                <i class="bi bi-circle-fill me-1"></i>
                                Secundario
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Tips Card -->
            <div class="card card-enhanced shadow-sm mt-4">
                <div class="card-header bg-transparent border-0">
                    <div class="d-flex align-items-center gap-2">
                        <div class="header-icon-sm bg-warning bg-opacity-10 rounded-circle p-2">
                            <i class="bi bi-lightbulb text-warning"></i>
                        </div>
                        <h6 class="mb-0">Consejos y Recomendaciones</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tips-container">
                        <div class="tip-item mb-3 p-3 bg-light rounded-2">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-check-circle-fill text-success mt-1"></i>
                                <div>
                                    <small class="fw-semibold d-block">Título efectivo</small>
                                    <small class="text-muted">Usa un título claro y directo que comunique el valor de tu negocio.</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tip-item mb-3 p-3 bg-light rounded-2">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-palette-fill text-primary mt-1"></i>
                                <div>
                                    <small class="fw-semibold d-block">Colores de marca</small>
                                    <small class="text-muted">Elige colores que reflejen la personalidad de tu marca y sean legibles.</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tip-item mb-3 p-3 bg-light rounded-2">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-image-fill text-info mt-1"></i>
                                <div>
                                    <small class="fw-semibold d-block">Logo optimizado</small>
                                    <small class="text-muted">Usa PNG o SVG con fondo transparente. Tamaño recomendado: 300x100px.</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tip-item p-3 bg-light rounded-2">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-phone-fill text-success mt-1"></i>
                                <div>
                                    <small class="fw-semibold d-block">Diseño responsivo</small>
                                    <small class="text-muted">Tu landing se verá perfecta en móviles, tablets y escritorio.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress indicator for advanced mode -->
            @if($modo === 'avanzado')
            <div class="card card-enhanced shadow-sm mt-4">
                <div class="card-header bg-transparent border-0">
                    <div class="d-flex align-items-center gap-2">
                        <div class="header-icon-sm bg-success bg-opacity-10 rounded-circle p-2">
                            <i class="bi bi-list-check text-success"></i>
                        </div>
                        <h6 class="mb-0">Progreso de Configuración</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="progress-section" id="configProgress">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted">Completado</small>
                            <small class="fw-semibold" id="progressPercentage">0%</small>
                        </div>
                        <div class="progress progress-enhanced mb-3">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 0%" id="progressBar"></div>
                        </div>
                        <div class="progress-items">
                            <div class="progress-item d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-circle text-muted" id="progress-empresa"></i>
                                <small class="text-muted">Información empresarial</small>
                            </div>
                            <div class="progress-item d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-circle text-muted" id="progress-objetivos"></i>
                                <small class="text-muted">Objetivos y audiencia</small>
                            </div>
                            <div class="progress-item d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-circle text-muted" id="progress-estilo"></i>
                                <small class="text-muted">Colores y estilo</small>
                            </div>
                            <div class="progress-item d-flex align-items-center gap-2">
                                <i class="bi bi-circle text-muted" id="progress-politicas"></i>
                                <small class="text-muted">Políticas y dominio</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

@push('styles')
<style>
    /* Enhanced Card Styles */
    .card-enhanced {
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .card-enhanced:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
        transform: translateY(-2px);
    }
    
    /* Header Icons */
    .header-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .header-icon-sm {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
        position: relative;
        overflow: hidden;
    }
    
    .status-published {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .status-construction {
        background: linear-gradient(135deg, #fff3cd, #ffeaa7);
        color: #856404;
        border: 1px solid #ffeaa7;
    }
    
    .status-draft {
        background: linear-gradient(135deg, #e2e3e5, #d6d8db);
        color: #495057;
        border: 1px solid #d6d8db;
    }
    
    .status-indicator {
        position: absolute;
        top: 0;
        right: 0;
        width: 4px;
        height: 100%;
        border-radius: 0 20px 20px 0;
    }
    
    /* Action Buttons */
    .btn-action {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .btn-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .btn-action::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn-action:hover::before {
        left: 100%;
    }
    
    /* Enhanced Alert */
    .alert-enhanced {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        position: relative;
    }
    
    .alert-enhanced::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--bs-warning);
    }
    
    .alert-content {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 0.5rem;
    }
    
    .alert-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(var(--bs-warning-rgb), 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--bs-warning);
        flex-shrink: 0;
    }
    
    .alert-title {
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--bs-dark);
    }
    
    .alert-text {
        margin-bottom: 0;
        color: var(--bs-secondary);
        line-height: 1.5;
    }
    
    /* Progress Enhancement */
    .progress-enhanced {
        height: 8px;
        border-radius: 10px;
        background-color: rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .progress-enhanced .progress-bar {
        border-radius: 10px;
        background: linear-gradient(90deg, var(--bs-warning), #ffd700);
        transition: width 0.6s ease;
        position: relative;
    }
    
    .progress-enhanced .progress-bar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, 
            transparent 35%, 
            rgba(255, 255, 255, 0.3) 35%, 
            rgba(255, 255, 255, 0.3) 65%, 
            transparent 65%);
        animation: progressShine 2s infinite;
    }
    
    @keyframes progressShine {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    
    .progress-wrapper {
        background: rgba(0, 0, 0, 0.02);
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .progress-label {
        font-weight: 500;
        color: var(--bs-dark);
    }
    
    .progress-value {
        font-weight: 600;
        color: var(--bs-warning);
    }
    
    /* Mode Selector */
    .mode-selector .btn-group {
        border-radius: 8px;
        overflow: hidden;
    }
    
    .mode-selector .btn {
        border: none;
        padding: 8px 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .mode-selector .btn i {
        transition: transform 0.3s ease;
    }
    
    .mode-selector .btn:hover i {
        transform: scale(1.1);
    }
    
    /* Mode Description */
    .mode-description {
        background: linear-gradient(135deg, rgba(240, 172, 33, 0.05), rgba(240, 172, 33, 0.02));
        border: 1px solid rgba(240, 172, 33, 0.1);
        border-radius: 10px;
        padding: 1rem;
        transition: all 0.3s ease;
    }
    
    .description-card {
        transition: all 0.3s ease;
    }
    
    .description-icon {
        width: 32px;
        height: 32px;
        flex-shrink: 0;
    }
    
    /* Enhanced Tabs */
    .nav-tabs-enhanced {
        border: none;
        background: rgba(0, 0, 0, 0.02);
        border-radius: 10px;
        padding: 4px;
        margin-bottom: 0;
    }
    
    .nav-tabs-enhanced .nav-link {
        border: none;
        border-radius: 8px;
        padding: 12px 20px;
        color: var(--bs-secondary);
        font-weight: 500;
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0;
    }
    
    .nav-tabs-enhanced .nav-link:hover {
        background: rgba(240, 172, 33, 0.1);
        color: var(--bs-dark);
        transform: translateY(-1px);
    }
    
    .nav-tabs-enhanced .nav-link.active {
        background: linear-gradient(135deg, #f0ac21, #e69a00);
        color: white;
        box-shadow: 0 4px 12px rgba(240, 172, 33, 0.3);
    }
    
    .tab-badge {
        font-size: 0.7rem;
        padding: 2px 8px;
        border-radius: 12px;
        margin-left: auto;
        font-weight: 600;
    }
    
    .tab-content-enhanced {
        background: white;
        border-radius: 0 0 12px 12px;
        min-height: 400px;
    }
    
    /* Preview Enhancements */
    .preview-container {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        border: 2px solid rgba(255, 255, 255, 0.1);
    }
    
    .preview-container:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }
    
    .logo-preview-container {
        position: relative;
        transition: all 0.3s ease;
    }
    
    .preview-logo {
        border-radius: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .logo-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 70px;
        border: 2px dashed rgba(255, 255, 255, 0.3);
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .preview-title, .preview-subtitle {
        transition: all 0.3s ease;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .preview-description {
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }
    
    /* Color Indicators */
    .color-indicators {
        animation: fadeInUp 0.6s ease;
    }
    
    .color-indicator .badge {
        transition: all 0.3s ease;
        border: 2px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
    }
    
    .color-indicator .badge:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    /* Tips Card */
    .tips-container .tip-item {
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .tips-container .tip-item:hover {
        background: rgba(240, 172, 33, 0.05) !important;
        transform: translateX(4px);
        border-color: rgba(240, 172, 33, 0.2);
    }
    
    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .card-enhanced {
        animation: fadeInUp 0.6s ease;
    }
    
    .card-enhanced:nth-child(2) {
        animation-delay: 0.1s;
    }
    
    .card-enhanced:nth-child(3) {
        animation-delay: 0.2s;
    }
    
    /* Responsive Improvements */
    @media (max-width: 768px) {
        .header-icon {
            width: 50px;
            height: 50px;
        }
        
        .status-badge {
            padding: 6px 12px;
            font-size: 0.8rem;
        }
        
        .btn-action {
            padding: 8px 16px;
            font-size: 0.9rem;
        }
        
        .mode-selector .btn {
            padding: 6px 12px;
            font-size: 0.85rem;
        }
        
        .nav-tabs-enhanced .nav-link {
            padding: 10px 16px;
            font-size: 0.9rem;
        }
        
        .preview-container {
            min-height: 220px !important;
        }
        
        .card-enhanced:hover {
            transform: none;
        }
        
        .preview-container:hover {
            transform: none;
        }
    }
    
    @media (max-width: 576px) {
        .content-header .row {
            text-align: center;
        }
        
        .content-header .col-lg-4 {
            margin-top: 1rem;
        }
        
        .mode-description {
            padding: 0.75rem;
        }
        
        .tip-item {
            padding: 0.75rem !important;
        }
    }
    
    /* Legacy styles for compatibility */
    #preview { transition: background .3s ease; }
    .img-thumb { width: 70px; height: 70px; object-fit: cover; border-radius: 8px; border: 1px solid #eee; }
    .form-section-title { font-weight: 700; color: #2c3e50; font-size: .95rem; }
    .note-muted { color: #6c757d; font-size: .85rem; }
    .required::after { content: ' *'; color: #dc3545; }
    .readonly-badge { font-size: .75rem; }
    .accordion-button:not(.collapsed) { background: rgba(240, 172, 33, .08); }
    .help-text { font-size: .85rem; color: #6c757d; }
    .field-disabled { opacity: .8; }
    .drop-zone { border: 2px dashed #ced4da; border-radius: 10px; padding: 16px; text-align: center; color: #6c757d; }
    .drop-zone.dragover { background: #f8f9fa; border-color: #0d6efd; color: #0d6efd; }
    .media-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(86px, 1fr)); gap: 10px; }
    .badge-muted { background: #f1f3f5; color: #495057; }
    .sticky-actions { position: sticky; bottom: 0; background: #fff; border-top: 1px solid #f0f0f0; padding-top: 1rem; }
    @media (max-width: 768px) { .sticky-actions { position: static; } }
    .cursor-not-allowed { cursor: not-allowed; }
    .cursor-help { cursor: help; }
    .form-check-input:disabled + label { opacity: .75; }
    .w-fit { width: fit-content; }
    .minw-160 { min-width: 160px; }
    .fw-600 { font-weight: 600; }
    .opacity-85 { opacity: .85; }
</style>
@endpush

@push('scripts')
<script>
    // --- Enhanced Mode Sync and Functionality ---
    function setUrlMode(mode){
        try {
            const url = new URL(window.location.href);
            url.searchParams.set('modo', mode);
            window.history.replaceState({}, '', url.toString());
        } catch(e) {}
    }

    function updateTopToggle(mode){
        const group = document.getElementById('modeToggle');
        if(!group) return;
        const basic = group.querySelector('[data-mode="basico"]');
        const adv = group.querySelector('[data-mode="avanzado"]');
        if(!basic || !adv) return;
        
        if(mode === 'avanzado'){
            adv.classList.remove('btn-outline-primary');
            adv.classList.add('btn-primary-gold');
            basic.classList.remove('btn-primary-gold');
            basic.classList.add('btn-outline-primary');
        } else {
            basic.classList.remove('btn-outline-primary');
            basic.classList.add('btn-primary-gold');
            adv.classList.remove('btn-primary-gold');
            adv.classList.add('btn-outline-primary');
        }
    }

    function updateModeDescription(mode) {
        const basic = document.getElementById('basicDescription');
        const advanced = document.getElementById('advancedDescription');
        
        if (mode === 'avanzado') {
            basic?.classList.add('d-none');
            basic?.classList.remove('d-block');
            advanced?.classList.remove('d-none');
            advanced?.classList.add('d-block');
        } else {
            advanced?.classList.add('d-none');
            advanced?.classList.remove('d-block');
            basic?.classList.remove('d-none');
            basic?.classList.add('d-block');
        }
    }

    function showTab(mode){
        try {
            const id = (mode === 'avanzado') ? 'avanzado-tab' : 'basico-tab';
            const el = document.getElementById(id);
            if(!el) return;
            const tab = new bootstrap.Tab(el);
            tab.show();
        } catch(e) {}
    }

    function bindModeSync(){
        const group = document.getElementById('modeToggle');
        if(group){
            group.querySelectorAll('.mode-toggle').forEach(a => {
                a.addEventListener('click', (e) => {
                    e.preventDefault();
                    const mode = a.getAttribute('data-mode') === 'avanzado' ? 'avanzado' : 'basico';
                    showTab(mode);
                    updateTopToggle(mode);
                    updateModeDescription(mode);
                    setUrlMode(mode);
                    
                    // Update progress tracking
                    if (mode === 'avanzado') {
                        setTimeout(updateProgressTracking, 100);
                    }
                });
            });
        }

        const tabs = document.getElementById('configTabs');
        if(tabs){
            tabs.addEventListener('shown.bs.tab', (event) => {
                const id = event.target?.id || '';
                const mode = id.includes('avanzado') ? 'avanzado' : 'basico';
                updateTopToggle(mode);
                updateModeDescription(mode);
                setUrlMode(mode);
                
                // Update progress tracking for advanced mode
                if (mode === 'avanzado') {
                    setTimeout(updateProgressTracking, 100);
                }
            });
        }
    }

    // --- Enhanced Progress Tracking for Advanced Mode ---
    function updateProgressTracking() {
        const form = document.querySelector('form.landing-form');
        if (!form) return;
        
        const sections = {
            empresa: ['empresa_nombre', 'empresa_email', 'empresa_movil', 'empresa_direccion'],
            objetivos: ['objetivo', 'titulo_principal', 'descripcion', 'descripcion_objetivo'],
            estilo: ['color_principal', 'color_secundario', 'tipografia', 'estilo'],
            politicas: ['terminos_condiciones', 'politica_privacidad']
        };
        
        let totalFields = 0;
        let completedFields = 0;
        const sectionProgress = {};
        
        Object.keys(sections).forEach(section => {
            const fields = sections[section];
            const sectionCompleted = fields.filter(fieldName => {
                const field = form.querySelector(`[name="${fieldName}"]`);
                return field && field.value.trim() !== '';
            }).length;
            
            sectionProgress[section] = sectionCompleted === fields.length;
            totalFields += fields.length;
            completedFields += sectionCompleted;
        });
        
        const percentage = totalFields > 0 ? Math.round((completedFields / totalFields) * 100) : 0;
        
        // Update progress bar
        const progressBar = document.getElementById('progressBar');
        const progressPercentage = document.getElementById('progressPercentage');
        
        if (progressBar && progressPercentage) {
            progressBar.style.width = percentage + '%';
            progressPercentage.textContent = percentage + '%';
            
            // Update progress bar color based on completion
            progressBar.className = 'progress-bar ' + (
                percentage >= 80 ? 'bg-success' :
                percentage >= 50 ? 'bg-warning' : 'bg-info'
            );
        }
        
        // Update section indicators
        Object.keys(sectionProgress).forEach(section => {
            const indicator = document.getElementById(`progress-${section}`);
            if (indicator) {
                indicator.className = sectionProgress[section] 
                    ? 'bi bi-check-circle-fill text-success'
                    : 'bi bi-circle text-muted';
            }
        });
    }

    // --- Enhanced Preview Functionality ---
    function applyPreview(){
        const root = document.getElementById('preview');
        const titulo = document.getElementById('previewTitulo');
        const subtitulo = document.getElementById('previewSubtitulo');
        const descripcion = document.getElementById('previewDescripcion');
        const colorPrincipal = document.querySelector('[name="color_principal"]');
        const colorSecundario = document.querySelector('[name="color_secundario"]');
        const tituloInput = document.querySelector('[name="titulo_principal"]');
        const subtituloInput = document.querySelector('[name="subtitulo"]');
        const descInput = document.querySelector('[name="descripcion"]');
        const badge1 = document.getElementById('badgeColorPrincipal');
        const badge2 = document.getElementById('badgeColorSecundario');
        
        // Animate preview updates
        root?.classList.add('preview-updating');
        setTimeout(() => root?.classList.remove('preview-updating'), 300);
        
        if(colorPrincipal){
            const cp = colorPrincipal.value || '#0d6efd';
            const cpSecondary = adjustColor(cp, -20); // Darker shade
            root.style.background = `linear-gradient(135deg, ${cp}, ${cpSecondary})`;
            badge1.style.backgroundColor = cp;
            root.style.setProperty('--color-primary', cp);
        }
        
        if(colorSecundario){
            const cs = colorSecundario.value || '#6c757d';
            root.style.setProperty('--color-secondary', cs);
            badge2.style.backgroundColor = cs;
        }
        
        if(tituloInput && titulo) {
            const newTitle = tituloInput.value || '{{ $empresa->nombre ?? 'Mi Empresa' }}';
            if (titulo.textContent !== newTitle) {
                titulo.style.opacity = '0.5';
                setTimeout(() => {
                    titulo.textContent = newTitle;
                    titulo.style.opacity = '1';
                }, 150);
            }
        }
        
        if(subtituloInput && subtitulo) {
            const newSubtitle = subtituloInput.value || 'Tu subtítulo aparecerá aquí';
            if (subtitulo.textContent !== newSubtitle) {
                subtitulo.style.opacity = '0.5';
                setTimeout(() => {
                    subtitulo.textContent = newSubtitle;
                    subtitulo.style.opacity = '1';
                }, 150);
            }
        }
        
        if(descInput && descripcion) {
            const newDesc = descInput.value || 'La descripción de tu negocio se mostrará aquí...';
            if (descripcion.textContent !== newDesc) {
                descripcion.style.opacity = '0.5';
                setTimeout(() => {
                    descripcion.textContent = newDesc;
                    descripcion.style.opacity = '1';
                }, 150);
            }
        }
    }
    
    // Helper function to adjust color brightness
    function adjustColor(color, amount) {
        const usePound = color[0] === '#';
        const col = usePound ? color.slice(1) : color;
        const num = parseInt(col, 16);
        let r = (num >> 16) + amount;
        let g = (num >> 8 & 0x00FF) + amount;
        let b = (num & 0x0000FF) + amount;
        r = r > 255 ? 255 : r < 0 ? 0 : r;
        g = g > 255 ? 255 : g < 0 ? 0 : g;
        b = b > 255 ? 255 : b < 0 ? 0 : b;
        return (usePound ? '#' : '') + (r << 16 | g << 8 | b).toString(16).padStart(6, '0');
    }

    // --- Enhanced Form Interactions ---
    function setupRealtime(){
        const form = document.querySelector('form.landing-form');
        if(!form) return;
        
        let updateTimeout;
        const events = ['input', 'change'];
        
        events.forEach(ev => form.addEventListener(ev, (e) => {
            saveFormToStorage(form);
            
            // Debounced preview updates
            clearTimeout(updateTimeout);
            updateTimeout = setTimeout(() => {
                applyPreview();
                updateProgressTracking();
            }, 150);
            
            // Show auto-save indicator
            showAutoSaveIndicator();
        }));

        // Enhanced logo preview
        const logoInput = form.querySelector('input[name="logo"]');
        if(logoInput){
            logoInput.addEventListener('change', (e) => {
                const file = e.target.files && e.target.files[0];
                if(file){
                    // Validate file size
                    if (file.size > 2 * 1024 * 1024) {
                        alert('El logo debe ser menor a 2MB');
                        logoInput.value = '';
                        return;
                    }
                    
                    const url = URL.createObjectURL(file);
                    const img = document.getElementById('previewLogo');
                    const placeholder = document.getElementById('logoPlaceholder');
                    
                    img.style.opacity = '0';
                    setTimeout(() => {
                        img.src = url;
                        img.style.display = 'block';
                        img.style.opacity = '1';
                        placeholder?.classList.add('d-none');
                    }, 150);
                    
                    // Clean up old URLs to prevent memory leaks
                    img.onload = () => URL.revokeObjectURL(url);
                }
            });
        }

        // Enhanced drop zone functionality
        const dz = document.querySelector('.drop-zone');
        const mediaInput = form.querySelector('input[name="media[]"]');
        if(dz && mediaInput){
            dz.addEventListener('dragover', (e) => { 
                e.preventDefault(); 
                dz.classList.add('dragover'); 
            });
            dz.addEventListener('dragleave', () => dz.classList.remove('dragover'));
            dz.addEventListener('drop', (e) => {
                e.preventDefault(); 
                dz.classList.remove('dragover');
                if(e.dataTransfer.files && e.dataTransfer.files.length){
                    // Validate file count and sizes
                    const files = Array.from(e.dataTransfer.files);
                    const validFiles = files.filter(file => {
                        return file.size <= 2 * 1024 * 1024 && file.type.startsWith('image/');
                    });
                    
                    if (validFiles.length !== files.length) {
                        alert('Algunos archivos son muy grandes o no son imágenes válidas');
                    }
                    
                    if (validFiles.length > 10) {
                        alert('Máximo 10 imágenes permitidas');
                        validFiles.splice(10);
                    }
                    
                    // Create new FileList with valid files
                    const dt = new DataTransfer();
                    validFiles.forEach(file => dt.items.add(file));
                    mediaInput.files = dt.files;
                    
                    // Show preview count
                    updateMediaPreview(validFiles.length);
                }
            });
            
            dz.addEventListener('click', () => mediaInput.click());
        }

        // Apply initial preview
        setTimeout(applyPreview, 50);
    }
    
    function updateMediaPreview(count) {
        const dz = document.querySelector('.drop-zone');
        if (dz && count > 0) {
            dz.innerHTML = `<i class="bi bi-images me-2"></i>${count} imagen${count > 1 ? 'es' : ''} seleccionada${count > 1 ? 's' : ''}`;
            dz.style.background = 'rgba(40, 167, 69, 0.1)';
            dz.style.borderColor = '#28a745';
            dz.style.color = '#28a745';
        }
    }
    
    function showAutoSaveIndicator() {
        const indicator = document.getElementById('autoSaveStatus');
        if (indicator) {
            indicator.style.display = 'block';
            setTimeout(() => {
                indicator.style.display = 'none';
            }, 2000);
        }
    }

    // --- Form Persistence ---
    const STORAGE_KEY = 'bbb_landing_config_form_{{ auth()->id() }}';
    const fromOld = {{ $errors->any() ? 'true' : 'false' }};

    function saveFormToStorage(form){
        try {
            const data = new FormData(form);
            const obj = {};
            data.forEach((v, k) => { 
                if(!k.includes('logo') && !k.includes('media') && !k.includes('_token')) 
                    obj[k] = v; 
            });
            localStorage.setItem(STORAGE_KEY, JSON.stringify(obj));
        } catch(e) {}
    }

    function loadFormFromStorage(form){
        try {
            const raw = localStorage.getItem(STORAGE_KEY);
            if(!raw) return;
            const obj = JSON.parse(raw);
            Object.entries(obj).forEach(([k,v]) => {
                const el = form.querySelector(`[name="${k}"]`);
                if(!el || (el.type === 'file')) return;
                if(el.type === 'checkbox' || el.type === 'radio'){
                    el.checked = (v === 'on' || v === '1' || v === true);
                } else {
                    el.value = v;
                }
            });
        } catch(e) {}
    }

    // --- Publish Button Enhancement ---
    function setupPublishButton() {
        const publishBtn = document.getElementById('publishBtn');
        if (publishBtn && !publishBtn.disabled) {
            publishBtn.addEventListener('click', (e) => {
                e.preventDefault();
                
                if (confirm('¿Estás seguro de que quieres publicar tu landing page? Esta acción hará que tu sitio esté disponible públicamente.')) {
                    publishBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Publicando...';
                    publishBtn.disabled = true;
                    
                    // Redirect to publish endpoint
                    window.location.href = '{{ route('admin.landing.publicar') }}';
                }
            });
        }
    }

    // --- Initialization ---
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('form.landing-form');
        if(form){
            if(!fromOld){
                loadFormFromStorage(form);
            }
            setupRealtime();
        }
        
        bindModeSync();
        setupPublishButton();
        
        // Initial progress tracking for advanced mode
        const currentMode = '{{ $modo }}';
        if (currentMode === 'avanzado') {
            setTimeout(updateProgressTracking, 200);
        }
        
        // Add smooth scroll to form sections
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });
</script>
@endpush

@endsection
