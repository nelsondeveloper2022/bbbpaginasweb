<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $landing->descripcion }}">
    <meta name="keywords" content="videojuegos, consolas, gaming, tienda gamer, Giova Store">
    <title>{{ $landing->titulo_principal }} - {{ $empresa->nombre }}</title>

    <!-- Favicon / App Icons -->
    <link rel="icon" type="image/png" href="{{ asset('storage/' . $landing->logo_url) }}">
    <link rel="shortcut icon" href="{{ asset('storage/' . $landing->logo_url) }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/' . $landing->logo_url) }}">
    <meta name="theme-color" content="{{ $landing->color_principal }}">
    <meta property="og:image" content="{{ asset('storage/' . $landing->logo_url) }}">
    <meta property="og:title" content="{{ $landing->titulo_principal }} - {{ $empresa->nombre }}">
    <meta property="og:description" content="{{ $landing->descripcion }}">

    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- AOS Animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $landing->tipografia) }}:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: {{ $landing->color_principal }};
            --secondary-color: {{ $landing->color_secundario ?? '#28a745' }};
            --font-family: '{{ $landing->tipografia }}', sans-serif;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: var(--font-family);
            overflow-x: hidden;
            color: #333;
        }
        
        /* Navbar */
        .navbar {
            background: rgba(5, 5, 5, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled {
            box-shadow: 0 5px 30px rgba(0,0,0,0.2);
        }
        
        .navbar-brand img {
            max-height: 150px;
            transition: transform 0.3s ease;
        }
        
        .navbar-brand:hover img {
            transform: scale(1.05);
        }
        
        .nav-link {
            color: #fff !important;
            font-weight: 500;
            margin: 0 15px;
            position: relative;
            transition: color 0.3s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--secondary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after {
            width: 80%;
        }
        
        .btn-whatsapp-header {
            background: var(--secondary-color);
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid var(--secondary-color);
        }
        
        .btn-whatsapp-header:hover {
            background: transparent;
            color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 138, 0, 0.3);
        }
        
        /* Hero Section */
        .hero-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, var(--primary-color) 0%, #1a1a1a 100%);
            overflow: hidden;
            padding-top: 80px;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23258a00" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,149.3C960,160,1056,160,1152,138.7C1248,117,1344,75,1392,53.3L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat center bottom;
            background-size: cover;
            opacity: 0.3;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            color: var(--secondary-color);
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .hero-description {
            font-size: 1.1rem;
            color: #e0e0e0;
            margin-bottom: 40px;
            line-height: 1.8;
        }
        
        .hero-image {
            position: relative;
            animation: float 3s ease-in-out infinite;
        }
        
        .hero-image img {
            max-width: 100%;
            height: auto;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        /* Buttons */
        .btn-primary-custom {
            background: var(--secondary-color);
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            border: 2px solid var(--secondary-color);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
        }
        
        .btn-primary-custom:hover {
            background: transparent;
            color: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(37, 138, 0, 0.3);
        }
        
        .btn-outline-custom {
            background: transparent;
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            border: 2px solid white;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
        }
        
        .btn-outline-custom:hover {
            background: white;
            color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
        }
        
        /* Section Styles */
        section {
            padding: 80px 0;
            position: relative;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--primary-color);
            position: relative;
            display: inline-block;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--secondary-color);
            border-radius: 2px;
        }
        
        .section-subtitle {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 50px;
        }
        
        /* About Section */
        .about-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
        
        .about-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .about-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        .about-icon {
            font-size: 3rem;
            color: var(--secondary-color);
            margin-bottom: 20px;
        }
        
        /* Problems Section */
        .problems-section {
            background: var(--primary-color);
            color: white;
        }
        
        .problems-section .section-title {
            color: white;
        }
        
        .problems-section .section-title::after {
            background: var(--secondary-color);
        }
        
        .problem-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .problem-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-5px);
        }
        
        .problem-icon {
            font-size: 2.5rem;
            color: var(--secondary-color);
            margin-bottom: 15px;
        }
        
        /* Benefits Section */
        .benefits-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }
        
        .benefit-card {
            background: white;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 2px solid transparent;
            height: 100%;
            text-align: center;
        }
        
        .benefit-card:hover {
            border-color: var(--secondary-color);
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(37, 138, 0, 0.2);
        }
        
        .benefit-icon {
            font-size: 3rem;
            color: var(--secondary-color);
            margin-bottom: 20px;
        }
        
        /* Gallery Section */
        .gallery-section {
            background: #f8f9fa;
        }
        
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .gallery-item:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .gallery-item img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: all 0.3s ease;
        }
        
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        
        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(5,5,5,0.8) 0%, rgba(37,138,0,0.8) 100%);
            opacity: 0;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }
        
        .gallery-overlay i {
            color: white;
            font-size: 3rem;
        }
        
        /* Community Section */
        .community-section {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #1e7000 100%);
            color: white;
        }
        
        .community-section .section-title {
            color: white;
        }
        
        .community-section .section-title::after {
            background: white;
        }
        
        .testimonial-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .testimonial-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-5px);
        }
        
        .testimonial-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            border: 3px solid white;
        }
        
        .stars {
            color: #ffc107;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }
        
        /* Contact Section */
        .contact-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
        
        .contact-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        .contact-icon {
            font-size: 2.5rem;
            color: var(--secondary-color);
            margin-bottom: 15px;
        }
        
        .contact-info h4 {
            color: var(--primary-color);
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .social-link {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary-color);
            color: white;
            font-size: 1.5rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .social-link:hover {
            background: var(--secondary-color);
            transform: translateY(-5px) rotate(360deg);
            box-shadow: 0 5px 15px rgba(37, 138, 0, 0.3);
        }
        
        /* Footer */
        .footer {
            background: var(--primary-color);
            color: white;
            padding: 60px 0 20px;
        }
        
        .footer-logo img {
            max-height: 60px;
            margin-bottom: 20px;
        }
        
        .footer h5 {
            color: var(--secondary-color);
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .footer-link {
            color: #ccc;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }
        
        .footer-link:hover {
            color: var(--secondary-color);
            padding-left: 10px;
        }
        
        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            margin-top: 40px;
            text-align: center;
            color: #ccc;
        }
        
        /* Floating WhatsApp Button */
        .floating-whatsapp {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: #25D366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 20px rgba(37, 211, 102, 0.4);
            z-index: 1000;
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
        }
        
        .floating-whatsapp:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 30px rgba(37, 211, 102, 0.6);
        }
        
        .floating-whatsapp i {
            color: white;
            font-size: 2rem;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        /* Responsive */
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
            
            .navbar-brand img {
                max-height: 40px;
            }
            
            section {
                padding: 50px 0;
            }
        }
        
        /* Modal Styles */
        .modal-content {
            border-radius: 15px;
        }
        
        .modal-header {
            background: var(--primary-color);
            color: white;
            border-radius: 15px 15px 0 0;
        }
        
        .modal-header .btn-close {
            filter: invert(1);
        }
        
        .modal-body {
            padding: 30px;
            max-height: 60vh;
        }
        
        /* Scroll to top button */
        .scroll-top {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 45px;
            height: 45px;
            background: var(--secondary-color);
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 999;
        }
        
        .scroll-top:hover {
            background: var(--primary-color);
            transform: translateY(-5px);
        }
        
        .scroll-top i {
            color: white;
            font-size: 1.2rem;
        }
        
        .scroll-top.show {
            display: flex;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#home">
                <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#benefits">Beneficios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#gallery">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contacto</a>
                    </li>
                    @if(isset($productosActivos) && $productosActivos > 0)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('public.tienda', $empresa->slug) }}" target="_blank" style="color: var(--secondary-color) !important; font-weight: 600;">
                                <i class="fas fa-shopping-cart me-2"></i>Tienda Virtual
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="btn btn-whatsapp-header" href="https://wa.me/57{{ $empresa->whatsapp ?? $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Estoy%20interesado%20en%20sus%20productos%20gaming%20y%20me%20gustaría%20recibir%20más%20información" target="_blank">
                            <i class="fab fa-whatsapp me-2"></i>WhatsApp
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="hero-content">
                        <h1 class="hero-title animate__animated animate__fadeInUp">
                            {{ $landing->titulo_principal }}
                        </h1>
                        <p class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s">
                            {{ $landing->subtitulo }}
                        </p>
                        <p class="hero-description animate__animated animate__fadeInUp animate__delay-2s">
                            {{ $landing->descripcion }}
                        </p>
                        <div class="animate__animated animate__fadeInUp animate__delay-3s">
                            <a href="#contact" class="btn-primary-custom">
                                <i class="fas fa-gamepad me-2"></i>Ver Productos
                            </a>
                            <a href="#about" class="btn-outline-custom">
                                <i class="fas fa-info-circle me-2"></i>Conocer Más
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="hero-image">
                        @if($landing->media && $landing->media->count() > 0)
                            @php $mediaRandom = $landing->media->random(); @endphp
                            <img src="{{ asset('storage/' . $mediaRandom->url) }}" alt="{{ $mediaRandom->descripcion ?? $empresa->nombre }}" class="img-fluid">
                        @else
                            <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}" class="img-fluid">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Sobre Nosotros</h2>
                <p class="section-subtitle">Tu tienda gaming de confianza en {{ $empresa->direccion }}</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="about-card">
                        <div class="about-icon">
                            <i class="fas fa-gamepad"></i>
                        </div>
                        <h3>Nuestra Misión</h3>
                        <p>{{ $landing->descripcion_objetivo }}</p>
                        <p class="mt-3">En <strong>{{ $empresa->nombre }}</strong>, somos más que una tienda: somos tu comunidad gamer. Ofrecemos los mejores videojuegos, consolas y accesorios con precios competitivos y la garantía de calidad que mereces.</p>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="about-card">
                        <div class="about-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>¿Para Quién Trabajamos?</h3>
                        <p><strong>Nuestra Comunidad Gamer:</strong></p>
                        <p>Jóvenes de 15 a 35 años apasionados por los videojuegos, adultos que buscan entretenimiento digital de calidad, padres que quieren lo mejor para sus hijos gamers, y entusiastas que buscan estar al día con las últimas novedades del mercado.</p>
                        <p class="mt-3">Entendemos las necesidades de cada tipo de gamer: desde el casual hasta el profesional, desde el retro hasta el más innovador.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Problems Section -->
    <section id="problems" class="problems-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">¿Te Suena Familiar?</h2>
                <p class="section-subtitle" style="color: #e0e0e0;">Estos son los problemas que todo gamer ha vivido</p>
            </div>
            <div class="row g-4">
                @php
                    $problems = [
                        [
                            'icon' => 'fa-search-dollar',
                            'title' => 'Precios Inflados',
                            'description' => 'Difícil encontrar videojuegos originales a buen precio sin sacrificar calidad o garantía.'
                        ],
                        [
                            'icon' => 'fa-shield-alt',
                            'title' => 'Productos Falsificados',
                            'description' => 'Desconfianza al comprar en tiendas no especializadas que venden copias o productos sin garantía.'
                        ],
                        [
                            'icon' => 'fa-question-circle',
                            'title' => 'Falta de Asesoría Gaming',
                            'description' => 'No encuentras ayuda especializada para elegir juegos o accesorios según tu consola y preferencias.'
                        ],
                        [
                            'icon' => 'fa-clock',
                            'title' => 'Entregas Lentas',
                            'description' => 'Tiempos de entrega largos en tiendas internacionales. Pierdes el hype de los últimos lanzamientos.'
                        ]
                    ];
                @endphp
                
                @foreach($problems as $index => $problem)
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="problem-card">
                        <div class="problem-icon">
                            <i class="fas {{ $problem['icon'] }}"></i>
                        </div>
                        <h4>{{ $problem['title'] }}</h4>
                        <p>{{ $problem['description'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="benefits-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">¡Tenemos la Solución!</h2>
                <p class="section-subtitle">Descubre por qué {{ $empresa->nombre }} es la mejor opción</p>
            </div>
            <div class="row g-4">
                @php
                    $benefits = [
                        [
                            'icon' => 'fa-certificate',
                            'title' => 'Videojuegos Originales Garantizados',
                            'description' => 'Acceso rápido a videojuegos 100% originales y garantizados. Tu inversión está protegida con productos legítimos.'
                        ],
                        [
                            'icon' => 'fa-rocket',
                            'title' => 'Lanzamientos desde el Día 1',
                            'description' => 'Novedades y preventas disponibles desde el día de lanzamiento. Sé el primero en jugar los últimos hits.'
                        ],
                        [
                            'icon' => 'fa-tags',
                            'title' => 'Precios Competitivos',
                            'description' => 'Precios competitivos y promociones exclusivas para nuestra comunidad. El mejor valor del mercado.'
                        ],
                        [
                            'icon' => 'fa-shipping-fast',
                            'title' => 'Entrega Rápida Nacional',
                            'description' => 'Entrega rápida y soporte al cliente especializado en gaming. Sin esperas innecesarias.'
                        ],
                        [
                            'icon' => 'fa-headset',
                            'title' => 'Soporte Gaming Especializado',
                            'description' => 'Atención al cliente por gamers para gamers. Entendemos tu pasión y necesidades específicas.'
                        ],
                        [
                            'icon' => 'fa-user-check',
                            'title' => 'Asesoría Gaming Personalizada',
                            'description' => 'Asesoría personalizada según la consola o tipo de juego que prefieras. Encuentra tu match perfecto.'
                        ]
                    ];
                @endphp
                
                @foreach($benefits as $index => $benefit)
                <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="{{ $index * 100 }}">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas {{ $benefit['icon'] }}"></i>
                        </div>
                        <h4>{{ $benefit['title'] }}</h4>
                        <p>{{ $benefit['description'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="gallery-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Nuestra Colección Gaming</h2>
                <p class="section-subtitle">Descubre los mejores videojuegos, consolas y accesorios</p>
            </div>
            <div class="row g-4">
                @if($landing->media && $landing->media->count() > 0)
                    @foreach($landing->media as $index => $media)
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="gallery-item">
                            <img src="{{ asset('storage/' . $media->url) }}" alt="{{ $media->descripcion ?? 'Imagen de ' . $empresa->nombre }}">
                            <div class="gallery-overlay">
                                <i class="fas fa-search-plus"></i>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    @for($i = 0; $i < 4; $i++)
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                        <div class="gallery-item">
                            <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}">
                            <div class="gallery-overlay">
                                <i class="fas fa-search-plus"></i>
                            </div>
                        </div>
                    </div>
                    @endfor
                @endif
            </div>
        </div>
    </section>

    <!-- Community Section -->
    <section id="community" class="community-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Nuestra Comunidad Gamer</h2>
                <p class="section-subtitle" style="color: #e0e0e0;">{{ $landing->objetivo }} - Esto dicen nuestros clientes</p>
            </div>
            <div class="row g-4">
                @php
                    $testimonials = [
                        [
                            'name' => 'Carlos Gamer',
                            'avatar' => '🎮',
                            'role' => 'Pro Player PS5',
                            'comment' => 'Increíble servicio! Pedí mi PlayStation 5 y llegó al día siguiente. 100% original y a excelente precio. Giova Store es mi tienda de confianza.'
                        ],
                        [
                            'name' => 'María Switch',
                            'avatar' => '🕹️',
                            'role' => 'Nintendo Fan',
                            'comment' => 'La mejor tienda de videojuegos! Siempre tienen los últimos lanzamientos y el precio más justo del mercado. Excelente atención.'
                        ],
                        [
                            'name' => 'Andrés Collector',
                            'avatar' => '🎯',
                            'role' => 'Gaming Streamer',
                            'comment' => 'Excelente atención al cliente. Me ayudaron a elegir los mejores accesorios para mi setup gaming. Son expertos en lo que hacen.'
                        ]
                    ];
                @endphp
                
                @foreach($testimonials as $index => $testimonial)
                <div class="col-lg-4 col-md-6" data-aos="flip-left" data-aos-delay="{{ $index * 100 }}">
                    <div class="testimonial-card">
                        <div class="testimonial-avatar">
                            {{ $testimonial['avatar'] }}
                        </div>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p style="font-style: italic; margin-bottom: 20px;">"{{ $testimonial['comment'] }}"</p>
                        <h5 style="margin-bottom: 5px;">{{ $testimonial['name'] }}</h5>
                        <p style="color: #e0e0e0; font-size: 0.9rem;">{{ $testimonial['role'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Contáctanos</h2>
                <p class="section-subtitle">Estamos aquí para ayudarte a encontrar el producto gaming perfecto</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up">
                    <div class="contact-card text-center">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-info">
                            <h4>Teléfono</h4>
                            <p>{{ $empresa->movil }}</p>
                            <a href="tel:{{ $empresa->movil }}" class="btn btn-sm btn-primary-custom mt-2">Llamar</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="contact-card text-center">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-info">
                            <h4>Email</h4>
                            <p>{{ $empresa->email }}</p>
                            <a href="mailto:{{ $empresa->email }}" class="btn btn-sm btn-primary-custom mt-2">Enviar Email</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="contact-card text-center">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-info">
                            <h4>Dirección</h4>
                            <p>{{ $empresa->direccion }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5" data-aos="fade-up">
                <h3 class="mb-4">Síguenos en Redes Sociales</h3>
                <div class="social-links">
                    @if($empresa->facebook)
                    <a href="{{ $empresa->facebook }}" target="_blank" class="social-link">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    @endif
                    @if($empresa->instagram)
                    <a href="{{ $empresa->instagram }}" target="_blank" class="social-link">
                        <i class="fab fa-instagram"></i>
                    </a>
                    @endif
                    @if($empresa->twitter)
                    <a href="{{ $empresa->twitter }}" target="_blank" class="social-link">
                        <i class="fab fa-twitter"></i>
                    </a>
                    @endif
                    @if($empresa->linkedin)
                    <a href="{{ $empresa->linkedin }}" target="_blank" class="social-link">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    @endif
                    @if($empresa->youtube)
                    <a href="{{ $empresa->youtube }}" target="_blank" class="social-link">
                        <i class="fab fa-youtube"></i>
                    </a>
                    @endif
                    @if($empresa->tiktok)
                    <a href="{{ $empresa->tiktok }}" target="_blank" class="social-link">
                        <i class="fab fa-tiktok"></i>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4" data-aos="fade-up">
                    <div class="footer-logo">
                        <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}">
                    </div>
                    <p>{{ $landing->descripcion }}</p>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <h5>Enlaces Rápidos</h5>
                    <a href="#home" class="footer-link">Inicio</a>
                    <a href="#about" class="footer-link">Nosotros</a>
                    <a href="#benefits" class="footer-link">Beneficios</a>
                    <a href="#gallery" class="footer-link">Galería</a>
                    <a href="#contact" class="footer-link">Contacto</a>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <h5>Legal</h5>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalTerminos" class="footer-link">
                        Términos y Condiciones
                    </a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalPrivacidad" class="footer-link">
                        Política de Privacidad
                    </a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalCookies" class="footer-link">
                        Política de Cookies
                    </a>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; {{ date('Y') }} {{ $empresa->nombre }}. Todos los derechos reservados.</p>
                <p style="font-size: 0.9rem; color: #999;">Desarrollado con ❤️ para gamers</p>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/57{{ $empresa->whatsapp ?? $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Estoy%20interesado%20en%20sus%20videojuegos%20y%20me%20gustaría%20recibir%20más%20información%20sobre%20productos%20disponibles" 
       target="_blank" 
       class="floating-whatsapp"
       title="Chatea con nosotros por WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Scroll to Top Button -->
    <div class="scroll-top" id="scrollTop">
        <i class="fas fa-arrow-up"></i>
    </div>

    <!-- Modal Términos y Condiciones -->
    <div class="modal fade" id="modalTerminos" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-file-contract me-2"></i>Términos y Condiciones</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if($empresa->terminos_condiciones)
                        {!! $empresa->terminos_condiciones !!}
                    @else
                        <p>Los términos y condiciones se encuentran en proceso de actualización. Por favor, contáctanos para más información.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Política de Privacidad -->
    <div class="modal fade" id="modalPrivacidad" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-shield me-2"></i>Política de Privacidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if($empresa->politica_privacidad)
                        {!! $empresa->politica_privacidad !!}
                    @else
                        <p>La política de privacidad se encuentra en proceso de actualización. Por favor, contáctanos para más información.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Política de Cookies -->
    <div class="modal fade" id="modalCookies" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-cookie-bite me-2"></i>Política de Cookies</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if($empresa->politica_cookies)
                        {!! $empresa->politica_cookies !!}
                    @else
                        <p>La política de cookies se encuentra en proceso de actualización. Por favor, contáctanos para más información.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
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

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Close mobile menu if open
                    const navbarCollapse = document.querySelector('.navbar-collapse');
                    if (navbarCollapse.classList.contains('show')) {
                        navbarCollapse.classList.remove('show');
                    }
                }
            });
        });

        // Scroll to top button
        const scrollTopBtn = document.getElementById('scrollTop');
        
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                scrollTopBtn.classList.add('show');
            } else {
                scrollTopBtn.classList.remove('show');
            }
        });

        scrollTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Add hover effect to gallery items
        document.querySelectorAll('.gallery-item').forEach(item => {
            item.addEventListener('click', function() {
                // You can add lightbox functionality here
                console.log('Gallery item clicked');
            });
        });

        // Animate numbers (for future stats section)
        function animateValue(element, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                element.innerHTML = Math.floor(progress * (end - start) + start);
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        // Active nav link on scroll
        window.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('section');
            const navLinks = document.querySelectorAll('.nav-link');
            
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= sectionTop - 200) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        });

        // Add parallax effect to hero section
        window.addEventListener('scroll', function() {
            const heroSection = document.querySelector('.hero-section');
            const scrolled = window.pageYOffset;
            if (heroSection) {
                heroSection.style.transform = 'translateY(' + scrolled * 0.5 + 'px)';
            }
        });

        // Console message
        console.log('%c🎮 Giova Store - Desarrollado con ❤️ para gamers', 'color: #258a00; font-size: 16px; font-weight: bold;');
    </script>
</body>
</html>
