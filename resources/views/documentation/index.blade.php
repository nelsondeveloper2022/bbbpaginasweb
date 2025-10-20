@extends('layouts.dashboard')

@section('title', 'BBB Academy - Centro de Aprendizaje')
@section('description', 'Aprende a usar tu plataforma BBB paso a paso con guías visuales y sencillas')

@php
    $user = auth()->user();
    $planPermiteProductos = $user->plan && $user->plan->aplicaProductos;
@endphp

@push('styles')
<style>
    .academy-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        color: white;
        overflow: hidden;
        position: relative;
    }
    
    .academy-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="20" cy="20" r="1" fill="rgba(255,255,255,0.15)"/><circle cx="80" cy="30" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="30" cy="80" r="1" fill="rgba(255,255,255,0.2)"/></svg>') repeat;
        animation: float 20s infinite linear;
    }
    
    @keyframes float {
        0% { transform: translateX(0) translateY(0); }
        100% { transform: translateX(-50px) translateY(-50px); }
    }
    
    .academy-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }
    
    .academy-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }
    
    .academy-icon {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        position: relative;
        overflow: hidden;
    }
    
    .academy-icon::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
        animation: shimmer 3s infinite;
    }
    
    @keyframes shimmer {
        0%, 100% { transform: translateX(-100%) translateY(-100%); }
        50% { transform: translateX(100%) translateY(100%); }
    }
    
    .level-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .level-basic { background: linear-gradient(45deg, #28a745, #20c997); color: white; }
    .level-recommended { background: linear-gradient(45deg, #ffc107, #fd7e14); color: #212529; }
    .level-advanced { background: linear-gradient(45deg, #6f42c1, #e83e8c); color: white; }
    
    .progress-indicator {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: rgba(0,0,0,0.1);
    }
    
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #28a745, #20c997);
        transition: width 0.3s ease;
    }
    
    .quick-actions {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(32, 201, 151, 0.1));
        border-radius: 16px;
        border: 2px solid rgba(40, 167, 69, 0.2);
    }
    
    .feature-highlight {
        position: relative;
        overflow: hidden;
    }
    
    .feature-highlight::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: highlight 2s infinite;
    }
    
    @keyframes highlight {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    /* Responsive YouTube embeds */
    .yt-responsive { position: relative; padding-bottom: 56.25%; height: 0; }
    .yt-responsive iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0; }
    
    /* Mobile Optimizations */
    @media (max-width: 767px) {
        .academy-header {
            border-radius: 12px;
            padding: 1.5rem !important;
            margin-bottom: 2rem !important;
        }
        
        .academy-header h1 {
            font-size: 1.75rem !important;
        }
        
        .academy-header p {
            font-size: 0.9rem !important;
        }
        
        .academy-header .btn-lg {
            font-size: 0.9rem;
            padding: 0.75rem 1.5rem;
            width: 100%;
        }
        
        .academy-card {
            margin-bottom: 1.5rem;
        }
        
        .academy-card .card-body {
            padding: 1.25rem !important;
        }
        
        .academy-card h5 {
            font-size: 1.1rem;
        }
        
        .academy-card p {
            font-size: 0.875rem;
            line-height: 1.5;
        }
        
        .academy-icon {
            width: 60px;
            height: 60px;
            margin-bottom: 1rem;
        }
        
        .academy-icon i {
            font-size: 1.75rem !important;
        }
        
        .btn {
            min-height: 44px;
            font-size: 0.875rem;
        }
        
        .flex-fill {
            flex: 1 1 auto;
        }
        
        .level-badge {
            font-size: 0.65rem;
            padding: 0.2rem 0.5rem;
            top: 0.75rem;
            right: 0.75rem;
        }
        
        .d-flex.gap-2 .btn {
            width: 100%;
        }
        
        .quick-actions {
            padding: 1rem !important;
        }
    }
    
    @media (max-width: 575px) {
        .academy-header {
            padding: 1rem !important;
            margin-bottom: 1.5rem !important;
        }
        
        .academy-header h1 {
            font-size: 1.5rem !important;
        }
        
        .academy-header p {
            font-size: 0.85rem !important;
        }
        
        .academy-header .btn-lg {
            font-size: 0.85rem;
            padding: 0.65rem 1.25rem;
        }
        
        .academy-icon {
            width: 50px;
            height: 50px;
        }
        
        .academy-icon i {
            font-size: 1.5rem !important;
        }
        
        .academy-card .card-body {
            padding: 1rem !important;
        }
        
        .academy-card h5 {
            font-size: 1rem;
        }
        
        .badge {
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }
        
        .btn-sm {
            font-size: 0.75rem;
            padding: 0.5rem 0.75rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Academy Header -->
<div class="academy-header p-3 p-md-4 mb-4 mb-md-5">
    <div class="position-relative">
        <div class="row align-items-center">
            <div class="col-12 col-lg-8">
                <div class="d-flex align-items-center mb-3">
                    <div class="academy-icon bg-white bg-opacity-20 me-2 me-md-3 d-none d-sm-flex" style="width: 60px; height: 60px; border-radius: 15px; flex-shrink: 0;">
                        <i class="bi bi-mortarboard-fill fs-2"></i>
                    </div>
                    <div>
                        <h1 class="mb-1 fw-bold" style="font-size: clamp(1.5rem, 5vw, 2.5rem);">BBB Academy</h1>
                        <p class="mb-0 opacity-90" style="font-size: clamp(0.875rem, 3vw, 1.1rem);">Tu centro de aprendizaje paso a paso</p>
                    </div>
                </div>
                <p class="mb-3 mb-md-4 opacity-80" style="font-size: clamp(0.875rem, 2.5vw, 1.25rem); line-height: 1.5;">
                    Aprende a usar cada módulo de tu plataforma con guías visuales y sencillas. 
                    <strong>¡Todo pensado para principiantes!</strong>
                </p>
                <div class="d-flex flex-column flex-sm-row gap-2 gap-sm-3">
                    <a href="#empezar" class="btn btn-light btn-lg px-4 feature-highlight">
                        <i class="bi bi-play-circle me-2"></i>
                        Empezar ahora
                    </a>
                    <a href="https://wa.me/{{ config('app.support.mobile') }}?text=Hola%20vengo%20de%20BBB%20Academy%20y%20necesito%20ayuda" 
                       target="_blank" class="btn btn-outline-light btn-lg px-4">
                        <i class="bi bi-whatsapp me-2"></i>
                        Ayuda 24/7
                    </a>
                </div>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-flex justify-content-center align-items-center">
                <div class="academy-icon bg-white bg-opacity-20" style="width: 120px; height: 120px; border-radius: 30px;">
                    <i class="bi bi-rocket-takeoff" style="font-size: 3rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div id="empezar" class="quick-actions p-3 p-md-4 mb-4 mb-md-5">
    <div class="row align-items-center g-3">
        <div class="col-12 col-lg-8">
            <h3 class="text-success mb-2" style="font-size: clamp(1.25rem, 4vw, 1.75rem);">
                <i class="bi bi-lightning-charge me-2"></i>
                ¿Primera vez en BBB? ¡Perfecto!
            </h3>
            <p class="mb-3 text-muted" style="font-size: clamp(0.875rem, 2.5vw, 1rem);">Te recomendamos seguir estos pasos en orden para tener tu sitio web funcionando en minutos.</p>
            
            <!-- Desktop: horizontal flow -->
            <div class="d-none d-md-flex gap-2 flex-wrap align-items-center">
                <span class="badge bg-success">1. Configura tu Landing</span>
                <i class="bi bi-arrow-right text-success"></i>
                <span class="badge bg-info">2. Añade Productos</span>
                <i class="bi bi-arrow-right text-success"></i>
                <span class="badge bg-warning">3. Configura Pagos</span>
                <i class="bi bi-arrow-right text-success"></i>
                <span class="badge bg-primary">4. ¡Listo para vender!</span>
            </div>
            
            <!-- Mobile: vertical flow -->
            <div class="d-md-none">
                <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-success me-2">1. Configura tu Landing</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-arrow-down text-success me-2"></i>
                    <span class="badge bg-info me-2">2. Añade Productos</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-arrow-down text-success me-2"></i>
                    <span class="badge bg-warning me-2">3. Configura Pagos</span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="bi bi-arrow-down text-success me-2"></i>
                    <span class="badge bg-primary">4. ¡Listo para vender!</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4 text-center text-lg-end">
            <a href="{{ route('admin.landing.configurar') }}" class="btn btn-success btn-lg px-4 w-100 w-lg-auto">
                <i class="bi bi-rocket me-2"></i>
                ¡Empezar configuración!
            </a>
        </div>
    </div>
</div>

<!-- Video Tutoriales -->
<div id="tutoriales" class="mb-4 mb-md-5">
    <div class="card border-0" style="border-radius: 20px; box-shadow: 0 8px 25px rgba(0,0,0,0.08);">
        <div class="card-body p-3 p-md-4">
            <div class="row align-items-center g-3 mb-3">
                <div class="col-12 col-md-auto flex-grow-1">
                    <div class="d-flex align-items-center">
                        <div class="academy-icon me-2 me-md-3" style="background: linear-gradient(135deg, #ff4d4f, #ff9f43); width: 50px; height: 50px; border-radius: 12px;">
                            <i class="bi bi-youtube fs-4 text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold" style="font-size: clamp(1.1rem, 3vw, 1.5rem);">Video tutoriales</h4>
                            <small class="text-muted d-none d-sm-block">Aprende más rápido viendo los videos</small>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-auto">
                    <a href="{{ config('app.youtube.channel_url') }}" target="_blank" class="btn btn-danger w-100 w-md-auto">
                        <i class="bi bi-play-btn-fill me-1"></i>
                        Ver todos los videos
                    </a>
                </div>
            </div>

            @php
                $playlistId = config('app.youtube.playlist_id');
                $featuredVideo = config('app.youtube.featured_video_id');
                $videoIds = config('app.youtube.video_ids');
                $videosWithTitles = config('app.youtube.videos');
            @endphp

            @if(!empty($playlistId))
                <div class="yt-responsive rounded-3 overflow-hidden">
                    <iframe src="https://www.youtube.com/embed/videoseries?list={{ $playlistId }}"
                            title="BBB Páginas Web - Lista de reproducción"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                            referrerpolicy="strict-origin-when-cross-origin"></iframe>
                </div>
            @elseif(!empty($featuredVideo))
                <div class="yt-responsive rounded-3 overflow-hidden">
                    <iframe src="https://www.youtube.com/embed/{{ $featuredVideo }}"
                            title="BBB Páginas Web - Tutorial"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                            referrerpolicy="strict-origin-when-cross-origin"></iframe>
                </div>
            @elseif(!empty($videosWithTitles))
                <div class="row g-4">
                    @foreach(array_slice($videosWithTitles, 0, 4) as $video)
                        <div class="col-md-6">
                            <div class="yt-responsive rounded-3 overflow-hidden mb-2">
                                <iframe src="https://www.youtube.com/embed/{{ $video['id'] }}"
                                        title="{{ $video['title'] ?? 'BBB Páginas Web - Tutorial' }}"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen
                                        referrerpolicy="strict-origin-when-cross-origin"></iframe>
                            </div>
                            @if(!empty($video['title']))
                                <div class="small text-muted">
                                    <i class="bi bi-play-circle me-1"></i>{{ $video['title'] }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @elseif(!empty($videoIds))
                <div class="row g-3">
                    @foreach(array_slice($videoIds, 0, 4) as $vid)
                        <div class="col-md-6">
                            <div class="yt-responsive rounded-3 overflow-hidden">
                                <iframe src="https://www.youtube.com/embed/{{ $vid }}"
                                        title="BBB Páginas Web - Tutorial"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen
                                        referrerpolicy="strict-origin-when-cross-origin"></iframe>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-4 text-center bg-light rounded-3">
                    <p class="mb-2">Tenemos video tutoriales disponibles para ayudarte a empezar.</p>
                    <a href="{{ config('app.youtube.channel_url') }}" target="_blank" class="btn btn-danger">
                        <i class="bi bi-youtube me-1"></i>
                        Ir a nuestro canal
                    </a>
                </div>
            @endif
        </div>
    </div>
    
</div>

<!-- Academy Modules -->
<div class="row g-4 mb-5">
    <!-- Configura tu Landing -->
    <div class="col-lg-4 col-md-6">
        <div class="academy-card card h-100">
            <div class="level-badge level-recommended">Paso recomendado</div>
            <div class="card-body text-center p-4">
                <div class="academy-icon bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="bi bi-rocket-takeoff fs-1 text-white"></i>
                </div>
                <h5 class="card-title fw-bold mb-3">Configura tu Landing</h5>
                <p class="card-text text-muted mb-4">
                    Personaliza tu página web con colores, logo, textos y productos. 
                    <strong>¡Es súper fácil!</strong>
                </p>
                <div class="d-flex gap-2 mb-3">
                    <span class="badge bg-success">Nivel básico</span>
                    <span class="badge bg-info">5 min</span>
                </div>
                <div class="d-flex gap-2 mb-2">
                    <a href="{{ route('admin.documentation.landing-configuration-guide') }}" class="btn btn-outline-primary flex-fill">
                        <i class="bi bi-book me-2"></i>
                        Ver guía
                    </a>
                    <a href="{{ route('admin.landing.configurar') }}" class="btn btn-primary flex-fill">
                        <i class="bi bi-gear-fill me-2"></i>
                        Configurar
                    </a>
                </div>
                <small class="text-muted">
                    <i class="bi bi-check-circle-fill text-success me-1"></i>
                    Guía paso a paso incluida
                </small>
            </div>
            <div class="progress-indicator">
                <div class="progress-fill" style="width: 0%"></div>
            </div>
        </div>
    </div>

    <!-- Clientes -->
    @if($planPermiteProductos)
    <div class="col-lg-4 col-md-6">
        <div class="academy-card card h-100">
            <div class="level-badge level-basic">Nivel básico</div>
            <div class="card-body text-center p-4">
                <div class="academy-icon" style="background: linear-gradient(135deg, #28a745, #20c997);">
                    <i class="bi bi-people-fill fs-1 text-white"></i>
                </div>
                <h5 class="card-title fw-bold mb-3">Gestionar Clientes</h5>
                <p class="card-text text-muted mb-4">
                    Registra y organiza la información de tus clientes. 
                    <strong>Todo en un solo lugar.</strong>
                </p>
                <div class="d-flex gap-2 mb-3">
                    <span class="badge bg-success">Fácil</span>
                    <span class="badge bg-info">3 min</span>
                </div>
                <div class="d-flex gap-2 mb-2">
                    <a href="{{ route('admin.documentation.clients-guide') }}" class="btn btn-outline-success flex-fill">
                        <i class="bi bi-book me-2"></i>
                        Ver guía
                    </a>
                    <a href="{{ route('admin.clientes.index') }}" class="btn btn-success flex-fill">
                        <i class="bi bi-person-plus-fill me-2"></i>
                        Ver clientes
                    </a>
                </div>
                <small class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Registro rápido y sencillo
                </small>
            </div>
            <div class="progress-indicator">
                <div class="progress-fill" style="width: 0%"></div>
            </div>
        </div>
    </div>
    @endif

    <!-- Productos -->
    @if($planPermiteProductos)
    <div class="col-lg-4 col-md-6">
        <div class="academy-card card h-100">
            <div class="level-badge level-basic">Nivel básico</div>
            <div class="card-body text-center p-4">
                <div class="academy-icon" style="background: linear-gradient(135deg, #fd7e14, #ff6b35);">
                    <i class="bi bi-box-seam-fill fs-1 text-white"></i>
                </div>
                <h5 class="card-title fw-bold mb-3">Gestionar Productos</h5>
                <p class="card-text text-muted mb-4">
                    Crea tu catálogo con fotos, precios y descripciones. 
                    <strong>Vende lo que quieras.</strong>
                </p>
                <div class="d-flex gap-2 mb-3">
                    <span class="badge bg-warning">Importante</span>
                    <span class="badge bg-info">7 min</span>
                </div>
                <div class="d-flex gap-2 mb-2">
                    <a href="{{ route('admin.documentation.products-guide') }}" class="btn btn-outline-warning flex-fill">
                        <i class="bi bi-book me-2"></i>
                        Ver guía
                    </a>
                    <a href="{{ route('admin.productos.index') }}" class="btn btn-warning flex-fill">
                        <i class="bi bi-plus-circle-fill me-2"></i>
                        Mis productos
                    </a>
                </div>
                <small class="text-muted">
                    <i class="bi bi-camera me-1"></i>
                    Sube fotos fácilmente
                </small>
            </div>
            <div class="progress-indicator">
                <div class="progress-fill" style="width: 0%"></div>
            </div>
        </div>
    </div>
    @endif

    <!-- Ventas Online -->
        <!-- Ventas Online -->
    @if($planPermiteProductos)
    <div class="col-lg-4 col-md-6">
        <div class="academy-card card h-100">
            <div class="level-badge level-intermediate">Nivel intermedio</div>
            <div class="card-body text-center p-4">
                <div class="academy-icon" style="background: linear-gradient(135deg, #28a745, #20c997);">
                    <i class="bi bi-cart-check-fill fs-1 text-white"></i>
                </div>
                <h5 class="card-title fw-bold mb-3">Ventas Online</h5>
                <p class="card-text text-muted mb-4">
                    Configura tu tienda virtual y procesa pagos seguros. 
                    <strong>Vende 24/7 automáticamente.</strong>
                </p>
                <div class="d-flex gap-2 mb-3">
                    <span class="badge bg-success">Esencial</span>
                    <span class="badge bg-info">12 min</span>
                </div>
                <div class="d-flex gap-2 mb-2">
                    <a href="{{ route('admin.documentation.sales-guide') }}" class="btn btn-outline-success flex-fill">
                        <i class="bi bi-book me-2"></i>
                        Ver guía
                    </a>
                    <a href="{{ route('admin.ventas.index') }}" class="btn btn-success flex-fill">
                        <i class="bi bi-graph-up me-2"></i>
                        Ver ventas
                    </a>
                </div>
                <small class="text-muted">
                    <i class="bi bi-shield-check me-1"></i>
                    Pagos seguros con Wompi
                </small>
            </div>
            <div class="progress-indicator">
                <div class="progress-fill" style="width: 0%"></div>
            </div>
        </div>
    </div>
    @endif

    <!-- Configuración de Pagos -->
    @if($planPermiteProductos)
    <div class="col-lg-4 col-md-6">
        <div class="academy-card card h-100">
            <div class="level-badge level-recommended">Recomendado</div>
            <div class="card-body text-center p-4">
                <div class="academy-icon" style="background: linear-gradient(135deg, #dc3545, #c82333);">
                    <i class="bi bi-credit-card-2-back-fill fs-1 text-white"></i>
                </div>
                <h5 class="card-title fw-bold mb-3">Configurar Pagos</h5>
                <p class="card-text text-muted mb-4">
                    Conecta Wompi y recibe pagos automáticos. 
                    <strong>Cobra sin complicaciones.</strong>
                </p>
                <div class="d-flex gap-2 mb-3">
                    <span class="badge bg-danger">Esencial</span>
                    <span class="badge bg-info">8 min</span>
                </div>
                <div class="d-flex gap-2 mb-2">
                    <a href="{{ route('admin.documentation.payments-guide') }}" class="btn btn-outline-danger flex-fill">
                        <i class="bi bi-book me-2"></i>
                        Ver guía
                    </a>
                    <a href="{{ route('admin.pagos.index') }}" class="btn btn-danger flex-fill">
                        <i class="bi bi-wallet2 me-2"></i>
                        Configurar Wompi
                    </a>
                </div>
                <small class="text-muted">
                    <i class="bi bi-shield-check me-1"></i>
                    100% seguro y confiable
                </small>
            </div>
            <div class="progress-indicator">
                <div class="progress-fill" style="width: 0%"></div>
            </div>
        </div>
    </div>
    @endif

    <!-- Perfil y Empresa -->
    <div class="col-lg-4 col-md-6">
        <div class="academy-card card h-100">
            <div class="level-badge level-basic">Nivel básico</div>
            <div class="card-body text-center p-4">
                <div class="academy-icon" style="background: linear-gradient(135deg, #17a2b8, #138496);">
                    <i class="bi bi-building-gear fs-1 text-white"></i>
                </div>
                <h5 class="card-title fw-bold mb-3">Configurar Perfil</h5>
                <p class="card-text text-muted mb-4">
                    Actualiza tus datos personales y de empresa. 
                    <strong>Mantén todo al día.</strong>
                </p>
                <div class="d-flex gap-2 mb-3">
                    <span class="badge bg-info">Básico</span>
                    <span class="badge bg-secondary">4 min</span>
                </div>
                <div class="d-flex gap-2 mb-2">
                    <a href="{{ route('admin.documentation.profile-guide') }}" class="btn btn-outline-info flex-fill">
                        <i class="bi bi-book me-2"></i>
                        Ver guía
                    </a>
                    <a href="{{ route('admin.profile.edit') }}" class="btn btn-info flex-fill">
                        <i class="bi bi-person-gear me-2"></i>
                        Mi perfil
                    </a>
                </div>
                <small class="text-muted">
                    <i class="bi bi-pencil me-1"></i>
                    Edición rápida y fácil
                </small>
            </div>
            <div class="progress-indicator">
                <div class="progress-fill" style="width: 0%"></div>
            </div>
        </div>
    </div>

    <!-- Gestionar Plan -->
    <div class="col-lg-4 col-md-6">
        <div class="academy-card card h-100">
            <div class="level-badge level-advanced">Importante</div>
            <div class="card-body text-center p-4">
                <div class="academy-icon" style="background: linear-gradient(135deg, #ffc107, #fd7e14);">
                    <i class="bi bi-credit-card-2-front-fill fs-1 text-white"></i>
                </div>
                <h5 class="card-title fw-bold mb-3">Planes y Suscripciones</h5>
                <p class="card-text text-muted mb-4">
                    Ve tu plan actual, renueva o cambia a uno mejor. 
                    <strong>Siempre actualizado.</strong>
                </p>
                <div class="d-flex gap-2 mb-3">
                    <span class="badge bg-warning text-dark">Planes</span>
                    <span class="badge bg-info">5 min</span>
                </div>
                <div class="d-flex gap-2 mb-2">
                    <a href="{{ route('admin.documentation.plans-guide') }}" class="btn btn-outline-warning flex-fill">
                        <i class="bi bi-book me-2"></i>
                        Ver guía
                    </a>
                    <a href="{{ route('admin.plans.index') }}" class="btn btn-warning flex-fill">
                        <i class="bi bi-gem me-2"></i>
                        Mi plan
                    </a>
                </div>
                <small class="text-muted">
                    <i class="bi bi-arrow-clockwise me-1"></i>
                    Renovación automática
                </small>
            </div>
            <div class="progress-indicator">
                <div class="progress-fill" style="width: 0%"></div>
            </div>
        </div>
    </div>

    <!-- Preguntas Frecuentes -->
    <div class="col-lg-4 col-md-6">
        <div class="academy-card card h-100">
            <div class="level-badge level-basic">Ayuda</div>
            <div class="card-body text-center p-4">
                <div class="academy-icon" style="background: linear-gradient(135deg, #6c757d, #495057);">
                    <i class="bi bi-question-circle-fill fs-1 text-white"></i>
                </div>
                <h5 class="card-title fw-bold mb-3">Preguntas Frecuentes</h5>
                <p class="card-text text-muted mb-4">
                    Respuestas rápidas a las dudas más comunes. 
                    <strong>Resuelve todo aquí.</strong>
                </p>
                <div class="d-flex gap-2 mb-3">
                    <span class="badge bg-secondary">FAQ</span>
                    <span class="badge bg-info">2 min</span>
                </div>
                <a href="{{ route('admin.documentation.faq') }}" class="btn btn-secondary btn-lg w-100 mb-2">
                    <i class="bi bi-chat-square-dots me-2"></i>
                    Ver respuestas
                </a>
                <small class="text-muted">
                    <i class="bi bi-search me-1"></i>
                    Búsqueda rápida
                </small>
            </div>
            <div class="progress-indicator">
                <div class="progress-fill" style="width: 0%"></div>
            </div>
        </div>
    </div>
</div>

<!-- Tips y Recursos Adicionales -->
<div class="row g-4 mb-5">
    <div class="col-lg-8">
        <div class="card border-0" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1)); border-radius: 20px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-start">
                    <div class="academy-icon me-4" style="background: linear-gradient(135deg, #28a745, #20c997); width: 60px; height: 60px; border-radius: 15px;">
                        <i class="bi bi-lightbulb-fill fs-3 text-white"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h4 class="fw-bold mb-2">💡 Tips para el éxito</h4>
                        <p class="text-muted mb-3">Sigue estos consejos para sacar el máximo provecho de tu plataforma BBB:</p>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                    <div>
                                        <strong>Completa tu perfil primero</strong>
                                        <br><small class="text-muted">Los datos completos generan más confianza</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                    <div>
                                        <strong>Sube fotos de calidad</strong>
                                        <br><small class="text-muted">Las imágenes claras venden más</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                    <div>
                                        <strong>Personaliza tu landing</strong>
                                        <br><small class="text-muted">Usa tus colores y marca</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                    <div>
                                        <strong>Configura pagos temprano</strong>
                                        <br><small class="text-muted">No pierdas ventas por falta de esto</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100 border-0" style="background: linear-gradient(135deg, rgba(253, 126, 20, 0.1), rgba(255, 107, 53, 0.1)); border-radius: 20px;">
            <div class="card-body p-4 text-center d-flex flex-column justify-content-center">
                <div class="academy-icon mx-auto mb-3" style="background: linear-gradient(135deg, #fd7e14, #ff6b35); width: 60px; height: 60px; border-radius: 15px;">
                    <i class="bi bi-headset fs-3 text-white"></i>
                </div>
                <h5 class="fw-bold mb-2">¿Necesitas ayuda?</h5>
                <p class="text-muted mb-3">Nuestro equipo está aquí para ayudarte</p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="https://wa.me/{{ config('app.support.mobile') }}?text=Hola%20vengo%20de%20BBB%20Academy" 
                       target="_blank" class="btn btn-success btn-sm">
                        <i class="bi bi-whatsapp me-1"></i>
                        WhatsApp
                    </a>
                    <a href="{{ route('admin.documentation.faq') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-question-circle me-1"></i>
                        FAQ
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estado y Progreso de tu Cuenta -->
<div class="row">
    <div class="col-12">
        <div class="card border-0" style="border-radius: 20px; box-shadow: 0 8px 25px rgba(0,0,0,0.1);">
            <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa, #ffffff); border-radius: 20px 20px 0 0;">
                <div class="d-flex align-items-center">
                    <div class="academy-icon me-3" style="background: linear-gradient(135deg, #17a2b8, #138496); width: 50px; height: 50px; border-radius: 12px;">
                        <i class="bi bi-speedometer2 fs-4 text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold">Estado de tu Cuenta</h5>
                        <p class="mb-0 text-muted">Revisa tu progreso y configuración</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <!-- Progreso del Perfil -->
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-person-check fs-4 text-primary me-3"></i>
                            <h6 class="mb-0 fw-bold">Configuración del Perfil</h6>
                        </div>
                        
                        @if(auth()->user()->isEmailVerified())
                            <div class="d-flex align-items-center mb-2 p-2 rounded" style="background: rgba(40, 167, 69, 0.1);">
                                <i class="bi bi-check-circle-fill text-success me-3"></i>
                                <div>
                                    <strong>Email verificado</strong>
                                    <br><small class="text-muted">Tu cuenta está segura</small>
                                </div>
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-between mb-2 p-2 rounded" style="background: rgba(220, 53, 69, 0.1);">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-exclamation-triangle-fill text-danger me-3"></i>
                                    <div>
                                        <strong>Email sin verificar</strong>
                                        <br><small class="text-muted">Verifica para mayor seguridad</small>
                                    </div>
                                </div>
                                <a href="{{ route('admin.profile.edit') }}" class="btn btn-danger btn-sm">
                                    <i class="bi bi-shield-check me-1"></i>
                                    Verificar
                                </a>
                            </div>
                        @endif

                        @if(auth()->user()->hasCompleteProfile())
                            <div class="d-flex align-items-center mb-2 p-2 rounded" style="background: rgba(40, 167, 69, 0.1);">
                                <i class="bi bi-check-circle-fill text-success me-3"></i>
                                <div>
                                    <strong>Perfil completo</strong>
                                    <br><small class="text-muted">Toda tu información está actualizada</small>
                                </div>
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-between mb-2 p-2 rounded" style="background: rgba(255, 193, 7, 0.1);">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-exclamation-triangle-fill text-warning me-3"></i>
                                    <div>
                                        <strong>Perfil incompleto</strong>
                                        <br><small class="text-muted">Completa tu información</small>
                                    </div>
                                </div>
                                <a href="{{ route('admin.profile.edit') }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square me-1"></i>
                                    Completar
                                </a>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Estado del Plan -->
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-gem fs-4 text-warning me-3"></i>
                            <h6 class="mb-0 fw-bold">Plan y Suscripción</h6>
                        </div>
                        
                        <div class="d-flex align-items-center mb-2 p-2 rounded" style="background: rgba(255, 193, 7, 0.1);">
                            <i class="bi bi-star-fill text-warning me-3"></i>
                            <div>
                                <strong>{{ auth()->user()->plan->nombre ?? 'Sin plan activo' }}</strong>
                                <br><small class="text-muted">Tu plan actual</small>
                            </div>
                        </div>
                        
                        @if(auth()->user()->trial_ends_at)
                            @php
                                $daysLeft = intval(now()->diffInDays(auth()->user()->trial_ends_at, false));
                            @endphp
                            @if($daysLeft > 0)
                                <div class="d-flex align-items-center justify-content-between mb-2 p-2 rounded" style="background: rgba(23, 162, 184, 0.1);">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-clock-fill text-info me-3"></i>
                                        <div>
                                            <strong>{{ $daysLeft }} días restantes</strong>
                                            <br><small class="text-muted">Tu plan está activo</small>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.plans.index') }}" class="btn btn-info btn-sm">
                                        <i class="bi bi-arrow-clockwise me-1"></i>
                                        Renovar
                                    </a>
                                </div>
                            @else
                                <div class="d-flex align-items-center justify-content-between mb-2 p-2 rounded" style="background: rgba(220, 53, 69, 0.1);">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-exclamation-triangle-fill text-danger me-3"></i>
                                        <div>
                                            <strong>Plan expirado</strong>
                                            <br><small class="text-muted">Renueva para seguir usando BBB</small>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.plans.index') }}" class="btn btn-danger btn-sm">
                                        <i class="bi bi-credit-card me-1"></i>
                                        Renovar ahora
                                    </a>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
$(document).ready(function() {
    // Animación de las cards al cargar
    $('.academy-card').each(function(index) {
        $(this).css('opacity', '0').css('transform', 'translateY(30px)');
        $(this).delay(index * 100).animate({
            opacity: 1
        }, 500, function() {
            $(this).css('transform', 'translateY(0)');
        });
    });
    
    // Efecto hover mejorado para las cards
    $('.academy-card').hover(function() {
        $(this).find('.progress-fill').css('width', '100%');
        $(this).find('.academy-icon').addClass('animated-icon');
    }, function() {
        $(this).find('.progress-fill').css('width', '0%');
        $(this).find('.academy-icon').removeClass('animated-icon');
    });
    
    // Smooth scroll para el botón "Empezar ahora"
    $('a[href="#empezar"]').click(function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $('#empezar').offset().top - 100
        }, 800);
    });
    
    // Efecto de contador para badges de tiempo
    $('.badge:contains("min")').each(function() {
        let $this = $(this);
        let time = parseInt($this.text());
        let counter = 0;
        let interval = setInterval(function() {
            counter++;
            $this.text(counter + ' min');
            if (counter >= time) {
                clearInterval(interval);
            }
        }, 100);
    });
    
    // Tooltips para información adicional
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Notificación de bienvenida
    if (sessionStorage.getItem('academy_welcome') !== 'shown') {
        setTimeout(function() {
            Swal.fire({
                title: '🎉 ¡Bienvenido a BBB Academy!',
                text: 'Aquí encontrarás todo lo que necesitas para usar tu plataforma. ¿Por dónde quieres empezar?',
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Configurar mi Landing',
                cancelButtonText: 'Explorar primero',
                confirmButtonColor: '#667eea',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('admin.landing.configurar') }}";
                }
            });
            sessionStorage.setItem('academy_welcome', 'shown');
        }, 1000);
    }
});

// CSS adicionales para animaciones
const additionalCSS = `
    .animated-icon {
        transform: scale(1.1) rotate(5deg);
        transition: all 0.3s ease;
    }
    
    .academy-card .progress-fill {
        transition: width 0.5s ease;
    }
    
    .feature-highlight:hover::before {
        animation-duration: 1s;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    .level-badge {
        animation: pulse 2s infinite;
    }
    
    .academy-header {
        position: relative;
        overflow: hidden;
    }
    
    .quick-actions:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.2);
    }
`;

// Inyectar CSS adicional
const styleSheet = document.createElement("style");
styleSheet.innerText = additionalCSS;
document.head.appendChild(styleSheet);
</script>
@endpush

@endsection