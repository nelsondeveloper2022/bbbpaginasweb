<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landing->titulo_principal }} - {{ $empresa->nombre }}</title>
    <meta name="description" content="{{ $landing->descripcion }}">
    <meta name="keywords" content="historia, exploración, aventuras, {{ $empresa->nombre }}, comunidad">
    <meta name="author" content="{{ $empresa->nombre }}">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $landing->titulo_principal }} - {{ $empresa->nombre }}">
    <meta property="og:description" content="{{ $landing->descripcion }}">
    @if($landing->logo_url)
    <meta property="og:image" content="{{ asset('storage/' . $landing->logo_url) }}">
    @endif
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $landing->titulo_principal }} - {{ $empresa->nombre }}">
    <meta name="twitter:description" content="{{ $landing->descripcion }}">
    @if($landing->logo_url)
    <meta name="twitter:image" content="{{ asset('storage/' . $landing->logo_url) }}">
    @endif
    
    <!-- Favicon -->
    @if($landing->logo_url)
    <link rel="icon" type="image/png" href="{{ asset('storage/' . $landing->logo_url) }}">
    @endif
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $landing->tipografia ?? 'Arial') }}:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: {{ $landing->color_principal ?? '#6c9d86' }};
            --secondary-color: {{ $landing->color_secundario ?? '#e8dbb6' }};
            --font-family: '{{ $landing->tipografia ?? 'Arial' }}', sans-serif;
        }
        
        * {
            font-family: var(--font-family);
        }
        
        body {
            line-height: 1.6;
            color: #333;
        }
        
        .primary-color {
            color: var(--primary-color);
        }
        
        .secondary-color {
            color: var(--secondary-color);
        }
        
        .bg-primary-custom {
            background-color: var(--primary-color);
        }
        
        .bg-secondary-custom {
            background-color: var(--secondary-color);
        }
        
        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            color: #333;
            transform: translateY(-2px);
        }
        
        .btn-secondary-custom {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            color: #333;
            transition: all 0.3s ease;
        }
        
        .btn-secondary-custom:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }
        
        .navbar-brand img {
            max-height: 50px;
            width: auto;
        }
        
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="rgba(255,255,255,0.1)" points="0,0 1000,300 1000,1000 0,700"/></svg>');
            background-size: cover;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            font-weight: 400;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .hero-description {
            font-size: 1.2rem;
            margin-bottom: 2.5rem;
            opacity: 0.8;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 3rem;
            position: relative;
            text-align: center;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--primary-color);
        }
        
        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .card-custom:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }
        
        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            position: relative;
        }
        
        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: -10px;
            left: 20px;
            font-size: 4rem;
            color: var(--primary-color);
            line-height: 1;
        }
        
        .gallery-item {
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            margin-bottom: 2rem;
        }
        
        .gallery-item img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .gallery-item:hover img {
            transform: scale(1.05);
        }
        
        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.7));
            display: flex;
            align-items: flex-end;
            padding: 1.5rem;
            color: white;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }
        
        .contact-info {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .social-links a {
            display: inline-block;
            width: 50px;
            height: 50px;
            background: var(--primary-color);
            color: white;
            text-align: center;
            line-height: 50px;
            border-radius: 50%;
            margin: 0 10px;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .social-links a:hover {
            background: var(--secondary-color);
            color: #333;
            transform: translateY(-5px);
        }
        
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            color: white;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 1000;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }
        
        .whatsapp-float:hover {
            background-color: #20ba55;
            color: white;
            transform: scale(1.1);
        }
        
        .stats-section {
            background: var(--primary-color);
            color: white;
            padding: 4rem 0;
        }
        
        .stat-item {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            display: block;
        }
        
        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .whatsapp-float {
                width: 50px;
                height: 50px;
                bottom: 20px;
                right: 20px;
                font-size: 24px;
            }
        }
        
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }
        
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container">
            @if($landing->logo_url)
            <a class="navbar-brand" href="#hero">
                <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}" loading="lazy">
            </a>
            @endif
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#hero">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Acerca</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#benefits">Beneficios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#community">Comunidad</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#gallery">Galería</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contacto</a>
                    </li>
                    @if($empresa->whatsapp)
                    <li class="nav-item">
                        <a class="btn btn-primary-custom ms-2" href="https://wa.me/57{{ $empresa->whatsapp }}" target="_blank">
                            <i class="fab fa-whatsapp"></i> Únete Ahora
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content text-white" data-aos="fade-right">
                        <h1 class="hero-title">{{ $landing->titulo_principal }}</h1>
                        <h2 class="hero-subtitle">{{ $landing->subtitulo }}</h2>
                        <p class="hero-description">{{ $landing->descripcion }}</p>
                        
                        <div class="d-flex flex-wrap gap-3">
                            @if($empresa->whatsapp)
                            <a href="https://wa.me/57{{ $empresa->whatsapp }}" class="btn btn-secondary-custom btn-lg" target="_blank">
                                <i class="fab fa-whatsapp"></i> Únete a la Comunidad
                            </a>
                            @endif
                            <a href="#about" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-compass"></i> Descubre Más
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center" data-aos="fade-left">
                        @if($landing->media && $landing->media->count() > 0)
                            <img src="{{ asset('storage/' . $landing->media->first()->url) }}" 
                                 alt="{{ $landing->media->first()->descripcion ?? 'Imagen de ' . $empresa->nombre }}" 
                                 class="img-fluid rounded-3 shadow-lg"
                                 loading="lazy">
                        @elseif($landing->logo_url)
                            <img src="{{ asset('storage/' . $landing->logo_url) }}" 
                                 alt="{{ $empresa->nombre }}" 
                                 class="img-fluid rounded-3 shadow-lg"
                                 loading="lazy">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title primary-color" data-aos="fade-up">Nuestra Misión</h2>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    @if($landing->logo_url)
                    <img src="{{ asset('storage/' . $landing->logo_url) }}" 
                         alt="{{ $empresa->nombre }}" 
                         class="img-fluid rounded-3 shadow-lg mb-4"
                         loading="lazy">
                    @endif
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="ps-lg-4">
                        <h3 class="mb-4 primary-color">{{ $landing->objetivo }}</h3>
                        <p class="lead mb-4">{{ $landing->descripcion_objetivo }}</p>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <i class="fas fa-map-marked-alt primary-color me-2"></i>
                                    <strong>Ubicación:</strong> {{ $empresa->direccion }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <i class="fas fa-envelope primary-color me-2"></i>
                                    <strong>Contacto:</strong> {{ $empresa->email }}
                                </div>
                            </div>
                        </div>
                        
                        @if($empresa->whatsapp)
                        <a href="https://wa.me/57{{ $empresa->whatsapp }}" class="btn btn-primary-custom" target="_blank">
                            <i class="fab fa-whatsapp"></i> Contáctanos
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Problems Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title primary-color" data-aos="fade-up">¿Te Identificas con Estos Desafíos?</h2>
                </div>
            </div>
            <div class="row">
                @php
                $problems = [
                    [
                        'icon' => 'fas fa-users-slash',
                        'title' => 'Falta de Comunidad',
                        'description' => 'No encuentras un espacio dedicado donde puedas interactuar profundamente con otros apasionados por la historia y la exploración.'
                    ],
                    [
                        'icon' => 'fas fa-puzzle-piece',
                        'title' => 'Información Dispersa',
                        'description' => 'Tienes dificultades para encontrar contenido curado y conversaciones significativas sobre rutas históricas y destinos relevantes.'
                    ],
                    [
                        'icon' => 'fas fa-heart-broken',
                        'title' => 'Sensación de Aislamiento',
                        'description' => 'Te sientes solo en tus pasiones, sin una red de apoyo para compartir y discutir temas que realmente te interesan.'
                    ],
                    [
                        'icon' => 'fas fa-lightbulb',
                        'title' => 'Inspiración Limitada',
                        'description' => 'Necesitas nuevas ideas, rutas y perspectivas para tus propias aventuras o proyectos de investigación personal.'
                    ]
                ];
                @endphp
                
                @foreach($problems as $index => $problem)
                <div class="col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="card-custom h-100 p-4">
                        <div class="feature-icon">
                            <i class="{{ $problem['icon'] }}"></i>
                        </div>
                        <h4 class="text-center mb-3 primary-color">{{ $problem['title'] }}</h4>
                        <p class="text-center text-muted">{{ $problem['description'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title primary-color" data-aos="fade-up">Beneficios que Obtienes</h2>
                </div>
            </div>
            <div class="row">
                @php
                $benefits = [
                    [
                        'icon' => 'fas fa-globe-americas',
                        'title' => 'Conexión Auténtica',
                        'description' => 'Únete a una red global de personas con intereses similares en historia, exploración y aventura.'
                    ],
                    [
                        'icon' => 'fas fa-crown',
                        'title' => 'Contenido Exclusivo',
                        'description' => 'Accede a artículos, discusiones, mapas interactivos y recursos que profundizan en el legado de exploradores.'
                    ],
                    [
                        'icon' => 'fas fa-comments',
                        'title' => 'Participación Activa',
                        'description' => 'Participa en foros, debates, desafíos temáticos y eventos virtuales exclusivos para miembros.'
                    ],
                    [
                        'icon' => 'fas fa-rocket',
                        'title' => 'Inspiración Constante',
                        'description' => 'Descubre nuevas rutas de viaje, destinos históricos y formas de vivir el espíritu de la exploración.'
                    ],
                    [
                        'icon' => 'fas fa-graduation-cap',
                        'title' => 'Desarrollo Personal',
                        'description' => 'Amplía tus conocimientos históricos y geográficos, perfecciona tus habilidades como cronista moderno.'
                    ],
                    [
                        'icon' => 'fas fa-heart',
                        'title' => 'Sentido de Pertenencia',
                        'description' => 'Forma parte de una comunidad que valora la curiosidad, el aprendizaje y el deseo de descubrir.'
                    ]
                ];
                @endphp
                
                @foreach($benefits as $index => $benefit)
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="card-custom h-100 p-4 text-center">
                        <div class="feature-icon">
                            <i class="{{ $benefit['icon'] }}"></i>
                        </div>
                        <h4 class="mb-3 primary-color">{{ $benefit['title'] }}</h4>
                        <p class="text-muted">{{ $benefit['description'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6" data-aos="fade-up">
                    <div class="stat-item">
                        <span class="stat-number" data-count="500">0</span>
                        <span class="stat-label">Exploradores Activos</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-item">
                        <span class="stat-number" data-count="150">0</span>
                        <span class="stat-label">Rutas Documentadas</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-item">
                        <span class="stat-number" data-count="25">0</span>
                        <span class="stat-label">Países Explorados</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-item">
                        <span class="stat-number" data-count="1000">0</span>
                        <span class="stat-label">Historias Compartidas</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Community Section -->
    <section id="community" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title primary-color" data-aos="fade-up">Lo Que Dicen Nuestros Exploradores</h2>
                </div>
            </div>
            <div class="row">
                @php
                $testimonials = [
                    [
                        'name' => 'María González',
                        'role' => 'Historiadora y Viajera',
                        'text' => 'Esta comunidad ha transformado mi forma de viajar. Ahora cada destino tiene una historia profunda que descubrir y compartir.',
                        'rating' => 5
                    ],
                    [
                        'name' => 'Carlos Rodríguez',
                        'role' => 'Fotógrafo de Aventuras',
                        'text' => 'He encontrado inspiración constante y conexiones auténticas. Las rutas recomendadas han sido extraordinarias.',
                        'rating' => 5
                    ],
                    [
                        'name' => 'Ana Martínez',
                        'role' => 'Escritora y Exploradora',
                        'text' => 'Finalmente un espacio donde puedo compartir mis pasiones sin sentirme sola. La comunidad es increíblemente enriquecedora.',
                        'rating' => 5
                    ]
                ];
                @endphp
                
                @foreach($testimonials as $index => $testimonial)
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="testimonial-card">
                        <div class="mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $testimonial['rating'] ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </div>
                        <p class="mb-4">{{ $testimonial['text'] }}</p>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary-custom d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 primary-color">{{ $testimonial['name'] }}</h6>
                                <small class="text-muted">{{ $testimonial['role'] }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title primary-color" data-aos="fade-up">Galería de Aventuras</h2>
                </div>
            </div>
            <div class="row">
                @if($landing->media && $landing->media->count() > 0)
                    @foreach($landing->media as $index => $media)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="gallery-item">
                            <img src="{{ asset('storage/' . $media->url) }}" 
                                 alt="{{ $media->descripcion ?? 'Aventura ' . ($index + 1) }}" 
                                 loading="lazy">
                            <div class="gallery-overlay">
                                <div>
                                    <h5>{{ $media->descripcion ?? 'Aventura ' . ($index + 1) }}</h5>
                                    <p class="mb-0">Descubre nuevos horizontes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Fallback con logo si no hay imágenes adicionales -->
                    @for($i = 1; $i <= 6; $i++)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ ($i-1) * 100 }}">
                        <div class="gallery-item">
                            @if($landing->logo_url)
                            <img src="{{ asset('storage/' . $landing->logo_url) }}" 
                                 alt="Aventura {{ $i }}" 
                                 loading="lazy">
                            @endif
                            <div class="gallery-overlay">
                                <div>
                                    <h5>Aventura {{ $i }}</h5>
                                    <p class="mb-0">Próximamente más contenido</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor
                @endif
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title primary-color" data-aos="fade-up">Únete a Nuestra Comunidad</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="contact-info text-center" data-aos="fade-up">
                        @if($landing->logo_url)
                        <img src="{{ asset('storage/' . $landing->logo_url) }}" 
                             alt="{{ $empresa->nombre }}" 
                             class="mb-4" 
                             style="max-height: 100px;"
                             loading="lazy">
                        @endif
                        
                        <h3 class="mb-4 primary-color">{{ $empresa->nombre }}</h3>
                        <p class="lead mb-4">{{ $landing->descripcion }}</p>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <i class="fas fa-envelope primary-color me-2"></i>
                                    <a href="mailto:{{ $empresa->email }}" class="text-decoration-none">{{ $empresa->email }}</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <i class="fas fa-map-marker-alt primary-color me-2"></i>
                                    <span>{{ $empresa->direccion }}</span>
                                </div>
                            </div>
                        </div>
                        
                        @if($empresa->whatsapp)
                        <div class="mb-4">
                            <a href="https://wa.me/57{{ $empresa->whatsapp }}" class="btn btn-primary-custom btn-lg" target="_blank">
                                <i class="fab fa-whatsapp"></i> Únete Ahora por WhatsApp
                            </a>
                        </div>
                        @endif
                        
                        <!-- Social Links -->
                        <div class="social-links">
                            @if($empresa->facebook)
                            <a href="{{ $empresa->facebook }}" target="_blank" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            @endif
                            @if($empresa->instagram)
                            <a href="{{ $empresa->instagram }}" target="_blank" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            @endif
                            @if($empresa->linkedin)
                            <a href="{{ $empresa->linkedin }}" target="_blank" title="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            @endif
                            @if($empresa->twitter)
                            <a href="{{ $empresa->twitter }}" target="_blank" title="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            @endif
                            @if($empresa->tiktok)
                            <a href="{{ $empresa->tiktok }}" target="_blank" title="TikTok">
                                <i class="fab fa-tiktok"></i>
                            </a>
                            @endif
                            @if($empresa->youtube)
                            <a href="{{ $empresa->youtube }}" target="_blank" title="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        @if($landing->logo_url)
                        <img src="{{ asset('storage/' . $landing->logo_url) }}" 
                             alt="{{ $empresa->nombre }}" 
                             style="max-height: 40px;" 
                             class="me-3"
                             loading="lazy">
                        @endif
                        <div>
                            <h6 class="mb-0">{{ $empresa->nombre }}</h6>
                            <small class="text-muted">{{ $landing->descripcion }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; {{ date('Y') }} {{ $empresa->nombre }}. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float Button -->
    @if($empresa->whatsapp)
    <a href="https://wa.me/57{{ $empresa->whatsapp }}" class="whatsapp-float" target="_blank" title="Contáctanos por WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offsetTop = target.offsetTop - 70;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Counter animation for stats
        function animateCounters() {
            const counters = document.querySelectorAll('.stat-number');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-count'));
                const duration = 2000;
                const step = target / (duration / 16);
                let current = 0;
                
                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        counter.textContent = target.toLocaleString();
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current).toLocaleString();
                    }
                }, 16);
            });
        }
        
        // Intersection Observer for stats animation
        const statsSection = document.querySelector('.stats-section');
        if (statsSection) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounters();
                        observer.unobserve(entry.target);
                    }
                });
            });
            observer.observe(statsSection);
        }
        
        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-lg');
            } else {
                navbar.classList.remove('shadow-lg');
            }
        });
        
        // Parallax effect for hero section
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.hero-section');
            if (parallax) {
                const speed = scrolled * 0.5;
                parallax.style.transform = `translateY(${speed}px)`;
            }
        });
        
        // Form validation and enhancement (if needed in future)
        document.addEventListener('DOMContentLoaded', function() {
            // Add any additional JavaScript functionality here
            console.log('{{ $empresa->nombre }} - Landing Page Loaded Successfully');
        });
    </script>
</body>
</html>
