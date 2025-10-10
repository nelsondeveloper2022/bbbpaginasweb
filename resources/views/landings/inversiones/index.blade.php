<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landing->titulo_principal }} - {{ $empresa->nombre }}</title>
    <meta name="description" content="{{ $landing->descripcion }}">

    <link rel="icon" type="image/png" href="{{ asset('storage/' . $landing->logo_url) }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/' . $landing->logo_url) }}">
    <link rel="shortcut icon" href="{{ asset('storage/' . $landing->logo_url) }}">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <style>
        :root {
            --primary-color: {{ $landing->color_principal ?? '#00ffff' }};
            --secondary-color: #ff00ff;
            --font-family: {{ $landing->tipografia ?? 'Arial' }}, sans-serif;
        }
        
        * {
            font-family: var(--font-family);
        }
        
        body {
            overflow-x: hidden;
        }
        
        /* Header */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 2px solid var(--primary-color);
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled {
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand img {
            height: 50px;
            transition: transform 0.3s ease;
        }
        
        .navbar-brand:hover img {
            transform: scale(1.05);
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
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
        
        .hero h1 {
            font-size: 4rem;
            font-weight: 900;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            margin-bottom: 1.5rem;
        }
        
        .hero h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 1rem;
        }
        
        .hero p {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
        }
        
        /* Buttons */
        .btn-primary-custom {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 15px 40px;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 50px;
            color: #000;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            color: #000;
        }
        
        .btn-whatsapp {
            background: #25D366;
            color: white;
        }
        
        .btn-whatsapp:hover {
            background: #128C7E;
            color: white;
        }
        
        /* Sections */
        .section {
            padding: 80px 0;
        }
        
        .section-title {
            font-size: 3rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 3rem;
            text-align: center;
            position: relative;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border-radius: 2px;
        }
        
        /* Cards */
        .card-custom {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .card-custom:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }
        
        .card-header-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: #000;
            font-weight: 600;
            padding: 20px;
        }
        
        /* Problems & Benefits */
        .problem-item, .benefit-item {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border-left: 5px solid var(--primary-color);
        }
        
        .problem-item:hover, .benefit-item:hover {
            transform: translateX(10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        
        .problem-item i, .benefit-item i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        
        /* Gallery */
        .gallery-item {
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .gallery-item:hover {
            transform: scale(1.05);
        }
        
        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: all 0.3s ease;
        }
        
        .gallery-item:hover img {
            filter: brightness(1.1);
        }
        
        /* Contact */
        .contact-item {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: 2px solid transparent;
        }
        
        .contact-item:hover {
            border-color: var(--primary-color);
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .contact-item i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }
        
        /* Footer */
        .footer {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: white;
            padding: 60px 0 30px;
        }
        
        .footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer a:hover {
            color: var(--primary-color);
        }
        
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            margin: 0 10px;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: var(--primary-color);
            color: #000;
            transform: translateY(-3px);
        }
        
        /* Animations */
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 { font-size: 2.5rem; }
            .hero h2 { font-size: 1.8rem; }
            .hero p { font-size: 1.1rem; }
            .section-title { font-size: 2.2rem; }
            .btn-primary-custom { padding: 12px 30px; font-size: 1rem; }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#home">
                <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}" class="animate__animated animate__fadeIn">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">Nosotros</a></li>
                    <li class="nav-item"><a class="nav-link" href="#benefits">Beneficios</a></li>
                    <li class="nav-item"><a class="nav-link" href="#gallery">Galería</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contacto</a></li>
                </ul>
                
                @if($empresa->whatsapp)
                <a href="https://wa.me/{{ $empresa->whatsapp }}" class="btn btn-whatsapp ms-3" target="_blank">
                    <i class="bi bi-whatsapp"></i> WhatsApp
                </a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="hero-content" data-aos="fade-right">
                        <h1 class="animate__animated animate__fadeInDown">{{ $landing->titulo_principal }}</h1>
                        <h2 class="animate__animated animate__fadeInLeft animate__delay-1s">{{ $landing->subtitulo }}</h2>
                        <p class="animate__animated animate__fadeInUp animate__delay-2s">{{ $landing->descripcion }}</p>
                        
                        <div class="d-flex flex-wrap gap-3 mt-4">
                            @if($empresa->whatsapp)
                            <a href="https://wa.me/{{ $empresa->whatsapp }}" class="btn btn-primary-custom animate__animated animate__pulse animate__infinite" target="_blank">
                                <i class="bi bi-whatsapp"></i> ¡Participar Ahora!
                            </a>
                            @endif
                            
                            <a href="#about" class="btn btn-outline-light btn-lg">
                                <i class="bi bi-info-circle"></i> Conocer Más
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="text-center" data-aos="fade-left">
                        <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}" class="img-fluid floating" style="max-width: 300px; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.3));">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section bg-light">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Sobre Nosotros</h2>
            
            <div class="row">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="card card-custom h-100">
                        <div class="card-header card-header-custom">
                            <h3><i class="bi bi-target"></i> Nuestro Objetivo</h3>
                        </div>
                        <div class="card-body">
                            <p class="lead">{{ $landing->descripcion_objetivo }}</p>
                            <p>En <strong>{{ $empresa->nombre }}</strong>, nos dedicamos a crear oportunidades únicas para que nuestros participantes puedan ganar increíbles premios en efectivo.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="card card-custom h-100">
                        <div class="card-header card-header-custom">
                            <h3><i class="bi bi-building"></i> Nuestra Empresa</h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="bi bi-envelope text-primary me-2"></i> <strong>Email:</strong> {{ $empresa->email }}</li>
                                <li class="mb-2"><i class="bi bi-geo-alt text-primary me-2"></i> <strong>Dirección:</strong> {{ $empresa->direccion }}</li>
                                @if($empresa->movil)
                                <li class="mb-2"><i class="bi bi-phone text-primary me-2"></i> <strong>Teléfono:</strong> {{ $empresa->movil }}</li>
                                @endif
                            </ul>
                            <p class="mt-3">Somos una empresa confiable y transparente, comprometida con la satisfacción de nuestros participantes.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Problems Section -->
    @if($landing->audiencia_problemas)
    <section class="section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">¿Por Qué Participar?</h2>
            
            <div class="row">
                <div class="col-12" data-aos="fade-up">
                    <div class="problem-item">
                        <i class="bi bi-exclamation-triangle"></i>
                        <h4>La Situación Actual</h4>
                        <p>{{ $landing->audiencia_problemas }}</p>
                        <p>Sabemos que encontrar oportunidades reales para ganar dinero extra puede ser difícil. Por eso hemos creado este sorteo especial con premios garantizados.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Benefits Section -->
    <section id="benefits" class="section bg-light">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Beneficios de Participar</h2>
            
            <div class="row">
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="benefit-item text-center">
                        <i class="bi bi-cash-coin"></i>
                        <h4>Premios en Efectivo</h4>
                        <p>Gana hasta 5 millones de pesos en efectivo. Premios reales y garantizados para nuestros ganadores.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="benefit-item text-center">
                        <i class="bi bi-shield-check"></i>
                        <h4>100% Confiable</h4>
                        <p>Sorteo oficial y transparente. Todos los procesos son auditados y verificados por terceros.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="benefit-item text-center">
                        <i class="bi bi-clock"></i>
                        <h4>Proceso Rápido</h4>
                        <p>Participación simple y rápida. En pocos minutos puedes estar participando por increíbles premios.</p>
                    </div>
                </div>
            </div>
            
            @if($landing->audiencia_beneficios)
            <div class="row mt-5">
                <div class="col-12" data-aos="fade-up">
                    <div class="card card-custom">
                        <div class="card-header card-header-custom text-center">
                            <h3><i class="bi bi-star"></i> Beneficios Adicionales</h3>
                        </div>
                        <div class="card-body">
                            <p class="lead text-center">{{ $landing->audiencia_beneficios }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>

    <!-- Community Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Nuestra Comunidad</h2>
            
            <div class="row">
                <div class="col-12 text-center mb-5" data-aos="fade-up">
                    <p class="lead">{{ $landing->objetivo }}</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card card-custom">
                        <div class="card-body text-center">
                            <i class="bi bi-person-circle display-4 text-primary mb-3"></i>
                            <h5>María González</h5>
                            <p class="text-muted">"Increíble experiencia, gané 2 millones y el proceso fue súper transparente. ¡Recomendado al 100%!"</p>
                            <div class="text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card card-custom">
                        <div class="card-body text-center">
                            <i class="bi bi-person-circle display-4 text-primary mb-3"></i>
                            <h5>Carlos Rodríguez</h5>
                            <p class="text-muted">"Participé con mis amigos y todos quedamos impresionados con la seriedad del sorteo. ¡Volveremos a participar!"</p>
                            <div class="text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card card-custom">
                        <div class="card-body text-center">
                            <i class="bi bi-person-circle display-4 text-primary mb-3"></i>
                            <h5>Ana Martínez</h5>
                            <p class="text-muted">"El mejor sorteo en el que he participado. Proceso claro, premios reales y excelente atención al cliente."</p>
                            <div class="text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="section bg-light">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Galería</h2>
            
            <div class="row">
                @if($landing->media && $landing->media->count() > 0)
                    @foreach($landing->media->take(6) as $index => $media)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                        <div class="gallery-item">
                            <img src="{{ asset('storage/' . $media->url) }}" alt="{{ $media->descripcion ?? 'Imagen de ' . $empresa->nombre }}" class="img-fluid">
                        </div>
                    </div>
                    @endforeach
                @else
                    @for($i = 1; $i <= 6; $i++)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                        <div class="gallery-item">
                            <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}" class="img-fluid">
                        </div>
                    </div>
                    @endfor
                @endif
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Contáctanos</h2>
            
            <div class="row">
                @if($empresa->whatsapp)
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="contact-item">
                        <i class="bi bi-whatsapp"></i>
                        <h4>WhatsApp</h4>
                        <p>Chatea con nosotros directamente</p>
                        <a href="https://wa.me/{{ $empresa->whatsapp }}" class="btn btn-whatsapp" target="_blank">
                            <i class="bi bi-whatsapp"></i> Chatear
                        </a>
                    </div>
                </div>
                @endif
                
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="contact-item">
                        <i class="bi bi-envelope"></i>
                        <h4>Email</h4>
                        <p>{{ $empresa->email }}</p>
                        <a href="mailto:{{ $empresa->email }}" class="btn btn-primary-custom">
                            <i class="bi bi-envelope"></i> Escribir
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="contact-item">
                        <i class="bi bi-geo-alt"></i>
                        <h4>Ubicación</h4>
                        <p>{{ $empresa->direccion }}</p>
                        @if($empresa->movil)
                        <p><i class="bi bi-phone"></i> {{ $empresa->movil }}</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Social Media -->
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <h3 class="mb-4" data-aos="fade-up">Síguenos en Redes Sociales</h3>
                    <div class="social-icons" data-aos="fade-up" data-aos-delay="200">
                        @if($empresa->facebook)
                        <a href="{{ $empresa->facebook }}" target="_blank" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        @endif
                        
                        @if($empresa->instagram)
                        <a href="{{ $empresa->instagram }}" target="_blank" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        @endif
                        
                        @if($empresa->tiktok)
                        <a href="{{ $empresa->tiktok }}" target="_blank" title="TikTok">
                            <i class="bi bi-tiktok"></i>
                        </a>
                        @endif
                        
                        @if($empresa->linkedin)
                        <a href="{{ $empresa->linkedin }}" target="_blank" title="LinkedIn">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        @endif
                        
                        @if($empresa->youtube)
                        <a href="{{ $empresa->youtube }}" target="_blank" title="YouTube">
                            <i class="bi bi-youtube"></i>
                        </a>
                        @endif
                        
                        @if($empresa->twitter)
                        <a href="{{ $empresa->twitter }}" target="_blank" title="Twitter">
                            <i class="bi bi-twitter"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}" style="height: 60px;" class="mb-3">
                    <p>{{ $empresa->nombre }} - {{ $landing->descripcion }}</p>
                    <div class="social-icons">
                        @if($empresa->facebook)
                        <a href="{{ $empresa->facebook }}" target="_blank"><i class="bi bi-facebook"></i></a>
                        @endif
                        @if($empresa->instagram)
                        <a href="{{ $empresa->instagram }}" target="_blank"><i class="bi bi-instagram"></i></a>
                        @endif
                        @if($empresa->whatsapp)
                        <a href="https://wa.me/{{ $empresa->whatsapp }}" target="_blank"><i class="bi bi-whatsapp"></i></a>
                        @endif
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <h5>Contacto</h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-envelope me-2"></i> {{ $empresa->email }}</li>
                        <li><i class="bi bi-geo-alt me-2"></i> {{ $empresa->direccion }}</li>
                        @if($empresa->movil)
                        <li><i class="bi bi-phone me-2"></i> {{ $empresa->movil }}</li>
                        @endif
                    </ul>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <h5>Enlaces Legales</h5>
                    <ul class="list-unstyled">
                        @if($empresa->terminos_condiciones)
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalTerminos">Términos y Condiciones</a></li>
                        @endif
                        @if($empresa->politica_privacidad)
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalPrivacidad">Política de Privacidad</a></li>
                        @endif
                        @if($empresa->politica_cookies)
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalCookies">Política de Cookies</a></li>
                        @endif
                    </ul>
                </div>
            </div>
            
            <hr class="my-4">
            <div class="row">
                <div class="col-12 text-center">
                    <p>&copy; {{ date('Y') }} {{ $empresa->nombre }}. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modals -->
    @if($empresa->terminos_condiciones)
    <div class="modal fade" id="modalTerminos" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Términos y Condiciones</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {!! $empresa->terminos_condiciones !!}
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($empresa->politica_privacidad)
    <div class="modal fade" id="modalPrivacidad" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Política de Privacidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {!! $empresa->politica_privacidad !!}
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($empresa->politica_cookies)
    <div class="modal fade" id="modalCookies" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Política de Cookies</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {!! $empresa->politica_cookies !!}
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scrolling
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

        // Add some interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            // Add pulse animation to CTA buttons
            const ctaButtons = document.querySelectorAll('.btn-primary-custom');
            ctaButtons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.classList.add('animate__pulse');
                });
                button.addEventListener('mouseleave', function() {
                    this.classList.remove('animate__pulse');
                });
            });

            // Add click tracking for WhatsApp buttons
            const whatsappButtons = document.querySelectorAll('a[href*="wa.me"]');
            whatsappButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // You can add analytics tracking here
                    console.log('WhatsApp button clicked');
                });
            });
        });
    </script>
</body>
</html>