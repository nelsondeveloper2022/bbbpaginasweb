<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landing->titulo_principal ?? 'Vista Previa' }} - Landing Page</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    @if($landing->tipografia)
        <link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $landing->tipografia) }}:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @endif
    
    <style>
        :root {
            --color-primary: {{ $landing->color_principal ?: '#007bff' }};
            --color-secondary: {{ $landing->color_secundario ?: '#6c757d' }};
            --font-family: {{ $landing->tipografia ? "'".$landing->tipografia."', " : '' }}system-ui, -apple-system, sans-serif;
        }
        
        body {
            font-family: var(--font-family);
            line-height: 1.6;
        }
        
        .btn-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }
        
        .btn-primary:hover {
            background-color: color-mix(in srgb, var(--color-primary) 85%, black);
            border-color: color-mix(in srgb, var(--color-primary) 85%, black);
        }
        
        .text-primary {
            color: var(--color-primary) !important;
        }
        
        .bg-primary {
            background-color: var(--color-primary) !important;
        }
        
        .text-secondary {
            color: var(--color-secondary) !important;
        }
        
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--color-primary) 0%, color-mix(in srgb, var(--color-primary) 80%, black) 100%);
        }
        
        .hero-content {
            color: white;
        }
        
        .logo-container {
            max-width: 200px;
            margin-bottom: 2rem;
        }
        
        .preview-badge {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.875rem;
        }
        
        .feature-card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }
        
        .media-gallery img {
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        @media (max-width: 768px) {
            .hero-section {
                min-height: 80vh;
            }
            
            .preview-badge {
                top: 10px;
                right: 10px;
                font-size: 0.8rem;
                padding: 6px 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Badge de Preview -->
    <div class="preview-badge">
        <i class="bi bi-eye me-1"></i>
        Vista Previa
    </div>

    <!-- Hero Section -->
    <section class="hero-section d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        @if($landing->logo_url)
                            <div class="logo-container">
                                <img src="{{ $landing->logo_full_url }}" alt="Logo" class="img-fluid">
                            </div>
                        @endif
                        
                        @if($landing->titulo_principal)
                            <h1 class="display-4 fw-bold mb-4">{{ $landing->titulo_principal }}</h1>
                        @endif
                        
                        @if($landing->subtitulo)
                            <h2 class="h4 mb-4 opacity-90">{{ $landing->subtitulo }}</h2>
                        @endif
                        
                        @if($landing->descripcion)
                            <p class="lead mb-5 opacity-90">{{ $landing->descripcion }}</p>
                        @endif
                        
                        <div class="d-flex flex-column flex-sm-row gap-3">
                            <button class="btn btn-light btn-lg px-4">
                                @switch($landing->objetivo)
                                    @case('vender_producto')
                                        <i class="bi bi-cart-plus me-2"></i>Comprar Ahora
                                        @break
                                    @case('captar_leads')
                                        <i class="bi bi-envelope me-2"></i>Obtener Información
                                        @break
                                    @case('reservas')
                                        <i class="bi bi-calendar-check me-2"></i>Hacer Reserva
                                        @break
                                    @case('descargas')
                                        <i class="bi bi-download me-2"></i>Descargar Gratis
                                        @break
                                    @default
                                        <i class="bi bi-arrow-right me-2"></i>Comenzar
                                @endswitch
                            </button>
                            <button class="btn btn-outline-light btn-lg px-4">
                                <i class="bi bi-play-circle me-2"></i>Ver Demo
                            </button>
                        </div>
                    </div>
                </div>
                
                @if($landing->images->count() > 0)
                    <div class="col-lg-6">
                        <div class="text-center">
                            <img src="{{ $landing->images->first()->full_url }}" 
                                 alt="Imagen principal" 
                                 class="img-fluid rounded shadow-lg"
                                 style="max-height: 400px;">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Features Section -->
    @if($landing->audiencia_problemas || $landing->audiencia_beneficios)
        <section class="py-5">
            <div class="container">
                <div class="row">
                    @if($landing->audiencia_problemas)
                        <div class="col-lg-6 mb-4">
                            <div class="card feature-card h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-danger bg-opacity-10 rounded-circle p-3 me-3">
                                            <i class="bi bi-exclamation-triangle text-danger"></i>
                                        </div>
                                        <h3 class="h5 mb-0">Problemas que Resolvemos</h3>
                                    </div>
                                    <p class="text-muted mb-0">{{ $landing->audiencia_problemas }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if($landing->audiencia_beneficios)
                        <div class="col-lg-6 mb-4">
                            <div class="card feature-card h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                            <i class="bi bi-check-circle text-success"></i>
                                        </div>
                                        <h3 class="h5 mb-0">Beneficios que Obtienes</h3>
                                    </div>
                                    <p class="text-muted mb-0">{{ $landing->audiencia_beneficios }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    <!-- Gallery Section -->
    @if($landing->images->count() > 1)
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="h3 mb-3">Galería</h2>
                    <p class="text-muted">Explora nuestro trabajo</p>
                </div>
                
                <div class="row g-4">
                    @foreach($landing->images->skip(1) as $image)
                        <div class="col-md-6 col-lg-4">
                            <div class="media-gallery">
                                <img src="{{ $image->full_url }}" 
                                     alt="{{ $image->descripcion ?: 'Imagen de galería' }}" 
                                     class="img-fluid w-100"
                                     style="height: 250px; object-fit: cover;">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- CTA Section -->
    <section class="py-5" style="background-color: var(--color-primary);">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <div class="text-white">
                        <h2 class="h3 mb-3">¿Listo para Comenzar?</h2>
                        @if($landing->descripcion_objetivo)
                            <p class="mb-4 opacity-90">{{ $landing->descripcion_objetivo }}</p>
                        @endif
                        <button class="btn btn-light btn-lg px-5">
                            @switch($landing->objetivo)
                                @case('vender_producto')
                                    <i class="bi bi-cart-plus me-2"></i>Comprar Ahora
                                    @break
                                @case('captar_leads')
                                    <i class="bi bi-envelope me-2"></i>Contáctanos
                                    @break
                                @case('reservas')
                                    <i class="bi bi-calendar-check me-2"></i>Reservar
                                    @break
                                @case('descargas')
                                    <i class="bi bi-download me-2"></i>Descargar
                                    @break
                                @default
                                    <i class="bi bi-arrow-right me-2"></i>Empezar
                            @endswitch
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    @if($landing->logo_url)
                        <img src="{{ $landing->logo_full_url }}" alt="Logo" style="max-height: 40px;" class="mb-2">
                    @endif
                    <p class="mb-0 text-muted">
                        @if($landing->audiencia_descripcion)
                            Dirigido a: {{ $landing->audiencia_descripcion }}
                        @else
                            © {{ date('Y') }} Todos los derechos reservados.
                        @endif
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted">
                        Estilo: {{ $landing->estilo ? ucfirst($landing->estilo) : 'Personalizado' }}
                        @if($landing->tipografia)
                            | Fuente: {{ $landing->tipografia }}
                        @endif
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        
        // Simple animations on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.feature-card, .media-gallery img').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });
    </script>
</body>
</html>