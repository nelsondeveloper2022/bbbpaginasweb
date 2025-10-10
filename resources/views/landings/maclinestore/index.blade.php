<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $landing->descripcion }}">
    <meta name="keywords" content="accesorios apple, mac, iphone, ipad, magic keyboard, magic mouse, apple store, macline">
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
            --secondary-color: {{ $landing->color_secundario ?? '#202226' }};
            --font-family: '{{ $landing->tipografia }}', sans-serif;
            --apple-white: #fafafa;
            --apple-gray: #f5f5f7;
            --apple-dark: #1d1d1f;
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
            background: var(--apple-white);
        }
        
        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }
        
        .navbar.scrolled {
            box-shadow: 0 5px 30px rgba(0,0,0,0.15);
        }
        
        .navbar-brand img {
            max-width: 180px;
            height: auto;
            max-height: 60px;
            object-fit: contain;
            transition: transform 0.3s ease;
        }
        
        .navbar-brand:hover img {
            transform: scale(1.05);
        }
        
        .nav-link {
            color: var(--apple-dark) !important;
            font-weight: 500;
            margin: 0 15px;
            position: relative;
            transition: color 0.3s ease;
            font-size: 0.95rem;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
            border-radius: 1px;
        }
        
        .nav-link:hover::after {
            width: 80%;
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
        }
        
        .btn-whatsapp-header {
            background: var(--primary-color);
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid var(--primary-color);
            font-size: 0.9rem;
        }
        
        .btn-whatsapp-header:hover {
            background: transparent;
            color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(42, 102, 255, 0.3);
        }
        
        /* Hero Section */
        .hero-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, var(--apple-white) 0%, var(--apple-gray) 100%);
            overflow: hidden;
            padding-top: 100px;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: -50%;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent 0%, rgba(42, 102, 255, 0.03) 50%, transparent 100%);
            transform: rotate(-15deg);
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--apple-dark);
            margin-bottom: 20px;
            line-height: 1.1;
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .hero-description {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 40px;
            line-height: 1.8;
        }
        
        .hero-image {
            position: relative;
            animation: float 6s ease-in-out infinite;
        }
        
        .hero-image img {
            max-width: 100%;
            height: auto;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        /* Buttons */
        .btn-primary-custom {
            background: var(--primary-color);
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            border: 2px solid var(--primary-color);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
        }
        
        .btn-primary-custom:hover {
            background: transparent;
            color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(42, 102, 255, 0.3);
        }
        
        .btn-outline-custom {
            background: transparent;
            color: var(--apple-dark);
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            border: 2px solid var(--apple-dark);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
        }
        
        .btn-outline-custom:hover {
            background: var(--apple-dark);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(29, 29, 31, 0.3);
        }
        
        /* Sections */
        .section {
            padding: 100px 0;
            position: relative;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--apple-dark);
            margin-bottom: 20px;
            text-align: center;
        }
        
        .section-subtitle {
            font-size: 1.2rem;
            color: #666;
            text-align: center;
            margin-bottom: 60px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* About Section */
        .about-section {
            background: white;
        }
        
        .about-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .about-card:hover {
            transform: translateY(-5px);
        }
        
        .about-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), #4285f4);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            color: white;
            font-size: 2rem;
        }
        
        /* Problems Section */
        .problems-section {
            background: var(--apple-gray);
        }
        
        .problem-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .problem-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }
        
        .problem-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #ff6b6b, #ff5252);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            color: white;
            font-size: 2rem;
        }
        
        /* Benefits Section */
        .benefits-section {
            background: white;
        }
        
        .benefit-card {
            background: linear-gradient(135deg, var(--primary-color), #4285f4);
            color: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            border: none;
        }
        
        .benefit-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 60px rgba(42, 102, 255, 0.3);
        }
        
        .benefit-icon {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 2rem;
            backdrop-filter: blur(10px);
        }
        
        /* Gallery Section */
        .gallery-section {
            background: var(--apple-gray);
        }
        
        .gallery-item {
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            background: white;
            position: relative;
            cursor: pointer;
        }
        
        .gallery-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 70px rgba(0,0,0,0.2);
        }
        
        .gallery-item img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: transform 0.3s ease;
            max-width: 100%;
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
            background: rgba(42, 102, 255, 0.9);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }
        
        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }
        
        .gallery-overlay i {
            font-size: 3rem;
            margin-bottom: 15px;
            animation: pulse 2s infinite;
        }
        
        .gallery-overlay p {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
            text-align: center;
            padding: 0 20px;
        }
        
        /* Gallery Modal */
        .gallery-modal .modal-dialog {
            max-width: 90vw;
            margin: 30px auto;
        }
        
        .gallery-modal .modal-dialog .modal-content {
            overflow: hidden;
        }
        
        .gallery-modal .modal-content {
            background: transparent;
            border: none;
            box-shadow: none;
        }
        
        .gallery-modal .modal-header {
            background: rgba(0,0,0,0.8);
            border: none;
            border-radius: 0;
            padding: 15px 20px;
        }
        
        .gallery-modal .modal-body {
            padding: 0;
            position: relative;
            background: rgba(0,0,0,0.9);
            border-radius: 0 0 10px 10px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 300px;
        }
        
        .gallery-modal .modal-image {
            width: 100%;
            max-width: 100%;
            max-height: 70vh;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }
        
        .gallery-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(42, 102, 255, 0.8);
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1001;
        }
        
        .gallery-nav-btn:hover {
            background: var(--primary-color);
            transform: translateY(-50%) scale(1.1);
        }
        
        .gallery-nav-btn.prev {
            left: 20px;
        }
        
        .gallery-nav-btn.next {
            right: 20px;
        }
        
        .gallery-counter {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            z-index: 1001;
        }
        
        /* Community Section */
        .community-section {
            background: white;
        }
        
        .testimonial-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            text-align: center;
            margin-bottom: 30px;
            border: 1px solid rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        
        .testimonial-card:hover {
            transform: translateY(-5px);
        }
        
        .testimonial-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, var(--primary-color), #4285f4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: bold;
        }
        
        .stars {
            color: #ffc107;
            font-size: 1.2rem;
            margin-bottom: 20px;
        }
        
        /* Contact Section */
        .contact-section {
            background: var(--apple-dark);
            color: white;
        }
        
        .contact-card {
            background: rgba(255,255,255,0.1);
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            margin-bottom: 30px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
            transition: transform 0.3s ease;
        }
        
        .contact-card:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.15);
        }
        
        .contact-icon {
            width: 80px;
            height: 80px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 2rem;
        }
        
        /* Footer */
        .footer {
            background: #000;
            color: white;
            padding: 60px 0 30px;
        }
        
        .footer-logo img {
            max-height: 60px;
            margin-bottom: 20px;
        }
        
        .social-links a {
            display: inline-block;
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            text-align: center;
            line-height: 50px;
            color: white;
            margin: 0 10px;
            transition: all 0.3s ease;
            font-size: 1.2rem;
        }
        
        .social-links a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }
        
        .footer-link {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-link:hover {
            color: var(--primary-color);
        }
        
        /* Modals */
        .modal-content {
            border-radius: 20px;
            border: none;
        }
        
        .modal-header {
            background: var(--primary-color);
            color: white;
            border-radius: 20px 20px 0 0;
        }
        
        .modal-body {
            padding: 30px;
        }
        
        /* WhatsApp Floating Button */
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 1000;
            animation: pulse 2s infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }
        
        .whatsapp-float:hover {
            color: #FFF;
            background-color: #20ba5a;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(37, 211, 102, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
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
            
            .section {
                padding: 60px 0;
            }
            
            .navbar-brand img {
                max-width: 140px;
                height: auto;
                max-height: 45px;
                object-fit: contain;
            }
            
            .gallery-modal .modal-dialog {
                max-width: 95vw;
                margin: 15px auto;
            }
            
            .gallery-modal .modal-image {
                max-height: 60vh;
            }
            
            .gallery-nav-btn {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
            
            .gallery-nav-btn.prev {
                left: 10px;
            }
            
            .gallery-nav-btn.next {
                right: 10px;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
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
                        <a class="nav-link" href="#problems">Problemas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#benefits">Beneficios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#gallery">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#community">Comunidad</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contacto</a>
                    </li>
                    @if(isset($productosActivos) && $productosActivos > 0)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('public.tienda', $empresa->slug) }}" target="_blank" style="color: var(--primary-color) !important; font-weight: 600;">
                                <i class="fas fa-shopping-cart me-2"></i>Tienda Virtual
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="btn btn-whatsapp-header" href="https://wa.me/57{{ $empresa->whatsapp ?? $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Estoy%20interesado%20en%20sus%20accesorios%20Apple%20y%20me%20gustaría%20recibir%20más%20información" target="_blank">
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
                        <h1 class="hero-title animate__animated animate__fadeInUp">{{ $landing->titulo_principal }}</h1>
                        <h2 class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s">{{ $landing->subtitulo }}</h2>
                        <p class="hero-description animate__animated animate__fadeInUp animate__delay-2s">{{ $landing->descripcion }}</p>
                        <div class="animate__animated animate__fadeInUp animate__delay-3s">
                            <a href="#about" class="btn-primary-custom">
                                <i class="fas fa-rocket me-2"></i>Descubre Más
                            </a>
                            <a href="https://wa.me/57{{ $empresa->whatsapp ?? $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Estoy%20interesado%20en%20sus%20accesorios%20Apple" target="_blank" class="btn-outline-custom">
                                <i class="fab fa-whatsapp me-2"></i>Contactar
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="hero-image">
                        @if($landing->media && $landing->media->count() > 0)
                            <img src="{{ asset('storage/' . $landing->media->first()->url) }}" alt="{{ $landing->media->first()->descripcion ?? 'Accesorios Apple - ' . $empresa->nombre }}" class="animate__animated animate__fadeIn animate__delay-1s">
                        @else
                            <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}" class="animate__animated animate__fadeIn animate__delay-1s">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section about-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6" data-aos="fade-right">
                    <h2 class="section-title text-start">Sobre {{ $empresa->nombre }}</h2>
                    <p class="section-subtitle text-start">{{ $landing->descripcion_objetivo }}</p>
                    <div class="about-card">
                        <div class="about-icon">
                            <i class="fab fa-apple"></i>
                        </div>
                        <h4>Especialistas en Apple</h4>
                        <p>En <strong>{{ $empresa->nombre }}</strong>, somos más que una tienda: somos especialistas apasionados del ecosistema Apple. Ofrecemos accesorios originales, auténticos y de la más alta calidad para complementar tu experiencia con Mac, iPhone e iPad.</p>
                        <p class="mt-3">Ubicados en <strong>{{ $empresa->direccion }}</strong>, brindamos asesoría personalizada y productos que potencian el rendimiento y la estética de tus dispositivos Apple favoritos.</p>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    @if($landing->media && $landing->media->count() > 1)
                        <img src="{{ asset('storage/' . $landing->media->skip(1)->first()->url) }}" alt="Sobre {{ $empresa->nombre }}" class="img-fluid rounded-4 shadow-lg">
                    @else
                        <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="Sobre {{ $empresa->nombre }}" class="img-fluid rounded-4 shadow-lg">
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Problems Section -->
    <section id="problems" class="section problems-section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Problemas que Resolvemos</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Entendemos las dificultades que enfrentan los usuarios de Apple</p>
            
            <div class="row">
                @php
                    $problems = [
                        [
                            'icon' => 'fas fa-exclamation-triangle',
                            'title' => 'Productos No Originales',
                            'description' => 'Dificultad para encontrar accesorios originales y compatibles con productos Apple. Riesgo de adquirir productos falsificados.'
                        ],
                        [
                            'icon' => 'fas fa-question-circle',
                            'title' => 'Falta de Asesoría',
                            'description' => 'Falta de asesoría especializada sobre qué periféricos mejoran el rendimiento y la comodidad de tu setup Apple.'
                        ],
                        [
                            'icon' => 'fas fa-clock',
                            'title' => 'Disponibilidad Limitada',
                            'description' => 'Escasez de opciones con disponibilidad inmediata y garantía. Tiempos de espera largos para productos especializados.'
                        ],
                        [
                            'icon' => 'fas fa-shield-alt',
                            'title' => 'Sin Garantía',
                            'description' => 'Comprar sin garantía adecuada o soporte técnico especializado para productos de alta gama.'
                        ]
                    ];
                @endphp
                
                @foreach($problems as $index => $problem)
                    <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="problem-card">
                            <div class="problem-icon">
                                <i class="{{ $problem['icon'] }}"></i>
                            </div>
                            <h5>{{ $problem['title'] }}</h5>
                            <p>{{ $problem['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="section benefits-section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Beneficios Exclusivos</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $landing->audiencia_beneficios }}</p>
            
            <div class="row">
                @php
                    $benefits = [
                        [
                            'icon' => 'fas fa-certificate',
                            'title' => '100% Originales',
                            'description' => 'Productos completamente originales y compatibles con Apple. Garantía de autenticidad en cada compra.'
                        ],
                        [
                            'icon' => 'fas fa-palette',
                            'title' => 'Diseño Premium',
                            'description' => 'Diseños premium que mantienen la estética y funcionalidad del ecosistema Apple en perfecta armonía.'
                        ],
                        [
                            'icon' => 'fas fa-headset',
                            'title' => 'Soporte Especializado',
                            'description' => 'Garantía y soporte personalizado para cada compra. Asesoría de expertos en productos Apple.'
                        ],
                        [
                            'icon' => 'fas fa-shipping-fast',
                            'title' => 'Envíos Rápidos',
                            'description' => 'Envíos rápidos y atención confiable desde una tienda especializada. Experiencia fluida de compra.'
                        ]
                    ];
                @endphp
                
                @foreach($benefits as $index => $benefit)
                    <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="benefit-card">
                            <div class="benefit-icon">
                                <i class="{{ $benefit['icon'] }}"></i>
                            </div>
                            <h5>{{ $benefit['title'] }}</h5>
                            <p>{{ $benefit['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="section gallery-section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Nuestros Productos</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Descubre nuestra selección exclusiva de accesorios Apple</p>
            
            <div class="row">
                @if($landing->media && $landing->media->count() > 0)
                    @foreach($landing->media as $index => $media)
                        <div class="col-lg-6 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <div class="gallery-item" data-bs-toggle="modal" data-bs-target="#galleryModal" data-image="{{ asset('storage/' . $media->url) }}" data-description="{{ $media->descripcion ?? 'Producto Apple - ' . $empresa->nombre }}" data-index="{{ $index }}">
                                <img src="{{ asset('storage/' . $media->url) }}" alt="{{ $media->descripcion ?? 'Producto Apple - ' . $empresa->nombre }}">
                                <div class="gallery-overlay">
                                    <i class="fas fa-search-plus"></i>
                                    <p>{{ $media->descripcion ?? 'Ver imagen' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    @for($i = 0; $i < 4; $i++)
                        <div class="col-lg-6 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                            <div class="gallery-item" data-bs-toggle="modal" data-bs-target="#galleryModal" data-image="{{ asset('storage/' . $landing->logo_url) }}" data-description="Producto {{ $i + 1 }} - {{ $empresa->nombre }}" data-index="{{ $i }}">
                                <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="Producto {{ $i + 1 }} - {{ $empresa->nombre }}">
                                <div class="gallery-overlay">
                                    <i class="fas fa-search-plus"></i>
                                    <p>Ver imagen</p>
                                </div>
                            </div>
                        </div>
                    @endfor
                @endif
            </div>
            
            @if(isset($productosActivos) && $productosActivos > 0)
                <div class="text-center mt-5" data-aos="fade-up">
                    <a href="{{ route('public.tienda', $empresa->slug) }}" target="_blank" class="btn-primary-custom">
                        <i class="fas fa-shopping-cart me-2"></i>Ver Tienda Completa
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Community Section -->
    <section id="community" class="section community-section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Comunidad MacLine</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $landing->objetivo }}</p>
            
            <div class="row">
                @php
                    $testimonials = [
                        [
                            'name' => 'Carlos M.',
                            'avatar' => 'C',
                            'profession' => 'Diseñador Gráfico',
                            'comment' => 'Increíble calidad! Compré el Magic Keyboard para mi MacBook Pro y la experiencia es simplemente perfecta. 100% original y llegó súper rápido. MacLine Store es mi tienda de confianza para accesorios Apple.',
                            'rating' => 5
                        ],
                        [
                            'name' => 'Ana L.',
                            'avatar' => 'A',
                            'profession' => 'Desarrolladora iOS',
                            'comment' => 'El mejor lugar para comprar accesorios Apple en Bogotá! Tienen productos originales, excelente atención y precios justos. Mi Magic Mouse funciona a la perfección con mi iMac.',
                            'rating' => 5
                        ],
                        [
                            'name' => 'Miguel R.',
                            'avatar' => 'M',
                            'profession' => 'Estudiante Universitario',
                            'comment' => 'Servicio excepcional! Me ayudaron a elegir los audífonos perfectos para mi iPhone. Son originales, con excelente calidad de sonido y el precio fue muy competitivo.',
                            'rating' => 5
                        ]
                    ];
                @endphp
                
                @foreach($testimonials as $index => $testimonial)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="testimonial-card">
                            <div class="testimonial-avatar">{{ $testimonial['avatar'] }}</div>
                            <div class="stars">
                                @for($i = 0; $i < $testimonial['rating']; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                            </div>
                            <p>"{{ $testimonial['comment'] }}"</p>
                            <strong>{{ $testimonial['name'] }}</strong><br>
                            <small class="text-muted">{{ $testimonial['profession'] }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section contact-section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Contáctanos</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Estamos aquí para ayudarte con tus necesidades Apple</p>
            
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <h5>WhatsApp</h5>
                        <p>{{ $empresa->whatsapp ?? $empresa->movil }}</p>
                        <a href="https://wa.me/57{{ $empresa->whatsapp ?? $empresa->movil }}" target="_blank" class="btn btn-outline-light btn-sm">Enviar Mensaje</a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h5>Email</h5>
                        <p>{{ $empresa->email }}</p>
                        <a href="mailto:{{ $empresa->email }}" class="btn btn-outline-light btn-sm">Enviar Email</a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <h5>WhatsApp</h5>
                        <p>{{ $empresa->movil }}</p>
                        <a href="https://wa.me/57{{ $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Estoy%20interesado%20en%20sus%20productos%20y%20me%20gustaría%20recibir%20más%20información" target="_blank" class="btn btn-outline-light btn-sm">Enviar Mensaje</a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h5>Ubicación</h5>
                        <p>{{ $empresa->direccion }}</p>
                        <a href="https://www.google.com/maps/search/{{ urlencode($empresa->direccion) }}" target="_blank" class="btn btn-outline-light btn-sm">Ver en Google Maps</a>
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
                    <div class="footer-logo">
                        <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}">
                    </div>
                    <p>Especialistas en accesorios Apple. Calidad, diseño y autenticidad para potenciar tu experiencia con el ecosistema Apple.</p>
                    <div class="social-links">
                        @if($empresa->facebook)
                            <a href="{{ $empresa->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if($empresa->instagram)
                            <a href="{{ $empresa->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if($empresa->whatsapp ?? $empresa->movil)
                            <a href="https://wa.me/57{{ $empresa->whatsapp ?? $empresa->movil }}" target="_blank"><i class="fab fa-whatsapp"></i></a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Enlaces</h5>
                    <ul class="list-unstyled">
                        <li><a href="#home" class="footer-link">Inicio</a></li>
                        <li><a href="#about" class="footer-link">Nosotros</a></li>
                        <li><a href="#benefits" class="footer-link">Beneficios</a></li>
                        <li><a href="#gallery" class="footer-link">Productos</a></li>
                        <li><a href="#contact" class="footer-link">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Contacto</h5>
                    <ul class="list-unstyled">
                        <li>
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <a href="https://www.google.com/maps/search/{{ urlencode($empresa->direccion) }}" target="_blank" class="footer-link">{{ $empresa->direccion }}</a>
                        </li>
                        <li>
                            <i class="fab fa-whatsapp me-2"></i>
                            <a href="https://wa.me/57{{ $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Estoy%20interesado%20en%20sus%20productos" target="_blank" class="footer-link">{{ $empresa->movil }}</a>
                        </li>
                        <li>
                            <i class="fas fa-envelope me-2"></i>
                            <a href="mailto:{{ $empresa->email }}" class="footer-link">{{ $empresa->email }}</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Legal</h5>
                    <ul class="list-unstyled">
                        @if($empresa->terminos_condiciones)
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalTerminos" class="footer-link">Términos y Condiciones</a></li>
                        @endif
                        @if($empresa->politica_privacidad)
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalPrivacidad" class="footer-link">Política de Privacidad</a></li>
                        @endif
                        @if($empresa->politica_cookies)
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalCookies" class="footer-link">Política de Cookies</a></li>
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

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/57{{ $empresa->whatsapp ?? $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Estoy%20interesado%20en%20sus%20accesorios%20Apple%20y%20me%20gustaría%20recibir%20más%20información" 
       class="whatsapp-float" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

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

    <!-- Gallery Modal -->
    <div class="modal fade gallery-modal" id="galleryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="galleryModalTitle">Producto Apple</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="galleryModalImage" src="" alt="" class="modal-image">
                    <button class="gallery-nav-btn prev" id="galleryPrev">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="gallery-nav-btn next" id="galleryNext">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <div class="gallery-counter">
                        <span id="galleryCounter">1 / 1</span>
                    </div>
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

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offsetTop = target.offsetTop - 80;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Auto-collapse navbar on mobile after click
        document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                const navbar = document.querySelector('.navbar-collapse');
                if (navbar.classList.contains('show')) {
                    const bsCollapse = new bootstrap.Collapse(navbar);
                    bsCollapse.hide();
                }
            });
        });

        // Gallery Lightbox functionality
        let galleryImages = [];
        let currentImageIndex = 0;

        // Collect all gallery images
        document.querySelectorAll('.gallery-item').forEach((item, index) => {
            const imageSrc = item.getAttribute('data-image');
            const description = item.getAttribute('data-description');
            galleryImages.push({
                src: imageSrc,
                description: description
            });
        });

        // Gallery modal event listeners
        const galleryModal = document.getElementById('galleryModal');
        const galleryModalImage = document.getElementById('galleryModalImage');
        const galleryModalTitle = document.getElementById('galleryModalTitle');
        const galleryCounter = document.getElementById('galleryCounter');
        const galleryPrev = document.getElementById('galleryPrev');
        const galleryNext = document.getElementById('galleryNext');

        // Open gallery modal
        document.querySelectorAll('.gallery-item').forEach((item, index) => {
            item.addEventListener('click', function() {
                currentImageIndex = parseInt(this.getAttribute('data-index'));
                showGalleryImage(currentImageIndex);
            });
        });

        // Navigation functions
        function showGalleryImage(index) {
            if (galleryImages.length === 0) return;
            
            const image = galleryImages[index];
            galleryModalImage.src = image.src;
            galleryModalImage.alt = image.description;
            galleryModalTitle.textContent = image.description;
            galleryCounter.textContent = `${index + 1} / ${galleryImages.length}`;
            
            // Show/hide navigation buttons
            galleryPrev.style.display = galleryImages.length > 1 ? 'block' : 'none';
            galleryNext.style.display = galleryImages.length > 1 ? 'block' : 'none';
        }

        function showPreviousImage() {
            currentImageIndex = currentImageIndex > 0 ? currentImageIndex - 1 : galleryImages.length - 1;
            showGalleryImage(currentImageIndex);
        }

        function showNextImage() {
            currentImageIndex = currentImageIndex < galleryImages.length - 1 ? currentImageIndex + 1 : 0;
            showGalleryImage(currentImageIndex);
        }

        // Navigation event listeners
        galleryPrev.addEventListener('click', showPreviousImage);
        galleryNext.addEventListener('click', showNextImage);

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (galleryModal.classList.contains('show')) {
                if (e.key === 'ArrowLeft') {
                    showPreviousImage();
                } else if (e.key === 'ArrowRight') {
                    showNextImage();
                } else if (e.key === 'Escape') {
                    const modal = bootstrap.Modal.getInstance(galleryModal);
                    modal.hide();
                }
            }
        });

        // Prevent image dragging
        galleryModalImage.addEventListener('dragstart', function(e) {
            e.preventDefault();
        });
    </script>
</body>
</html>
