<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $landing->descripcion }}">
    <meta name="keywords" content="especias naturales, condimentos, cocina, sabores, especias fénix, especias sin químicos, especias colombia">
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
    <link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $landing->tipografia ?? 'Open Sans') }}:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: {{ $landing->color_principal ?? '#e1d16b' }};
            --secondary-color: {{ $landing->color_secundario ?? '#ca822f' }};
            --font-family: '{{ $landing->tipografia ?? 'Open Sans' }}', sans-serif;
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
            background: rgba(225, 209, 107, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled {
            box-shadow: 0 5px 30px rgba(0,0,0,0.2);
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
            color: #333 !important;
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
            box-shadow: 0 5px 15px rgba(202, 130, 47, 0.3);
        }
        
        /* Hero Section */
        .hero-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, var(--primary-color) 0%, #f8f5dc 100%);
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ca822f" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,149.3C960,160,1056,160,1152,138.7C1248,117,1344,75,1392,53.3L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat center bottom;
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
            color: #333;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            color: var(--secondary-color);
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .hero-description {
            font-size: 1.1rem;
            color: #555;
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
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
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
            box-shadow: 0 10px 25px rgba(202, 130, 47, 0.3);
        }
        
        .btn-outline-custom {
            background: transparent;
            color: #333;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            border: 2px solid #333;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
        }
        
        .btn-outline-custom:hover {
            background: #333;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
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
            background: var(--secondary-color);
            color: white;
        }
        
        .problems-section .section-title {
            color: white;
        }
        
        .problems-section .section-title::after {
            background: var(--primary-color);
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
            color: var(--primary-color);
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
            box-shadow: 0 15px 40px rgba(202, 130, 47, 0.2);
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
            max-width: 100%;
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
            background: linear-gradient(135deg, rgba(202,130,47,0.8) 0%, rgba(225,209,107,0.8) 100%);
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
            background: rgba(202, 130, 47, 0.8);
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
            background: var(--secondary-color);
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
            background: linear-gradient(135deg, var(--primary-color) 0%, #d4c55a 100%);
            color: #333;
        }
        
        .community-section .section-title {
            color: #333;
        }
        
        .community-section .section-title::after {
            background: var(--secondary-color);
        }
        
        .testimonial-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .testimonial-card:hover {
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-5px);
        }
        
        .testimonial-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            border: 3px solid white;
            color: white;
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
            box-shadow: 0 5px 15px rgba(202, 130, 47, 0.3);
        }
        
        /* Footer */
        .footer {
            background: var(--secondary-color);
            color: white;
            padding: 60px 0 20px;
        }
        
        .footer-logo img {
            max-height: 60px;
            margin-bottom: 20px;
        }
        
        .footer h5 {
            color: var(--primary-color);
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
            color: var(--primary-color);
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
                max-width: 140px;
                height: auto;
                max-height: 45px;
                object-fit: contain;
            }
            
            section {
                padding: 50px 0;
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
        
        /* Modal Styles */
        .modal-content {
            border-radius: 15px;
        }
        
        .modal-header {
            background: var(--primary-color);
            color: #333;
            border-radius: 15px 15px 0 0;
        }
        
        .modal-header .btn-close {
            filter: invert(0);
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
    <nav class="navbar navbar-expand-lg">
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
                        <a class="btn btn-whatsapp-header" href="https://wa.me/57{{ $empresa->whatsapp ?? $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Estoy%20interesado%20en%20sus%20especias%20naturales%20y%20me%20gustaría%20recibir%20más%20información" target="_blank">
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
                                <i class="fas fa-pepper-hot me-2"></i>Ver Especias
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
                <p class="section-subtitle">Especias naturales que transforman tu cocina desde {{ $empresa->direccion }}</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="about-card">
                        <div class="about-icon">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <h3>Nuestra Misión</h3>
                        <p>{{ $landing->descripcion_objetivo }}</p>
                        <p class="mt-3">En <strong>{{ $empresa->nombre }}</strong>, creemos que cada plato merece un sabor único. Ofrecemos especias y condimentos 100% naturales, sin químicos ni conservantes, seleccionados con cuidado para que disfrutes la frescura y autenticidad en tu cocina.</p>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="about-card">
                        <div class="about-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>¿Para Quién Trabajamos?</h3>
                        <p><strong>Nuestra Audiencia:</strong></p>
                        <p>Amas de casa que buscan darle más sabor y creatividad a su cocina diaria, chefs y cocineros que necesitan ingredientes de calidad superior, y personas conscientes de la salud que prefieren productos naturales sin químicos.</p>
                        <p class="mt-3">Entendemos que cocinar es más que un hábito: es una experiencia que perdura en el recuerdo, y nuestras especias son el ingrediente secreto para lograrlo.</p>
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
                <p class="section-subtitle" style="color: #e0e0e0;">Estos son los problemas que enfrentas al buscar especias de calidad</p>
            </div>
            <div class="row g-4">
                @php
                    $problems = [
                        [
                            'icon' => 'fa-question-circle',
                            'title' => 'Especias sin Calidad Garantizada',
                            'description' => 'Dificultad para encontrar especias 100% naturales y de calidad. Muchos productos en el mercado tienen químicos, colorantes o mezclas poco claras.'
                        ],
                        [
                            'icon' => 'fa-shield-alt',
                            'title' => 'Poca Confianza en la Pureza',
                            'description' => 'Desconfianza al comprar especias sin saber si lo que recibes es fresco, puro o auténtico. No siempre sabes qué estás comprando.'
                        ],
                        [
                            'icon' => 'fa-search',
                            'title' => 'Falta de Variedad y Presentación',
                            'description' => 'En supermercados encuentras especias básicas, pero no siempre con la diversidad, empaque y frescura que buscas para tu cocina.'
                        ],
                        [
                            'icon' => 'fa-clock',
                            'title' => 'Pérdida de Tiempo Buscando',
                            'description' => 'Problemas de tiempo y comodidad. No quieres perder tiempo buscando en varios sitios, prefieres compras rápidas y entregas a domicilio.'
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
                <p class="section-subtitle">Descubre por qué {{ $empresa->nombre }} es la mejor opción para tu cocina</p>
            </div>
            <div class="row g-4">
                @php
                    $benefits = [
                        [
                            'icon' => 'fa-certificate',
                            'title' => 'Productos 100% Naturales',
                            'description' => 'Ofrecemos productos 100% naturales, sin químicos, garantizando calidad y pureza. Tu salud y sabor están protegidos con ingredientes legítimos.'
                        ],
                        [
                            'icon' => 'fa-shield',
                            'title' => 'Confianza y Transparencia',
                            'description' => 'Brindamos confianza y transparencia, con información clara sobre cada producto. Sabes exactamente qué estás comprando y consumiendo.'
                        ],
                        [
                            'icon' => 'fa-box',
                            'title' => 'Presentaciones Prácticas',
                            'description' => 'Presentaciones prácticas, atractivas y modernas que conservan la frescura. Empaques diseñados para mantener el aroma y sabor intactos.'
                        ],
                        [
                            'icon' => 'fa-shipping-fast',
                            'title' => 'Compra Fácil y Entrega Rápida',
                            'description' => 'Compra fácil y entrega a domicilio, ahorrando tiempo y esfuerzo. Recibe tus especias favoritas sin salir de casa.'
                        ],
                        [
                            'icon' => 'fa-heart',
                            'title' => 'Inspiración Culinaria',
                            'description' => 'Inspiramos a los clientes con sabores auténticos que transforman cualquier plato. Convierte lo cotidiano en extraordinario.'
                        ],
                        [
                            'icon' => 'fa-star',
                            'title' => 'Calidad Superior',
                            'description' => 'Especias seleccionadas con cuidado para garantizar la máxima calidad y frescura. Cada producto pasa por rigurosos controles de calidad.'
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
                <h2 class="section-title">Nuestras Especias Premium</h2>
                <p class="section-subtitle">Descubre la variedad de especias y condimentos naturales que tenemos para ti</p>
            </div>
            <div class="row g-4">
                @if($landing->media && $landing->media->count() > 0)
                    @foreach($landing->media as $index => $media)
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="gallery-item" data-bs-toggle="modal" data-bs-target="#galleryModal" data-image="{{ asset('storage/' . $media->url) }}" data-description="{{ $media->descripcion ?? 'Especias de ' . $empresa->nombre }}" data-index="{{ $index }}">
                            <img src="{{ asset('storage/' . $media->url) }}" alt="{{ $media->descripcion ?? 'Especias de ' . $empresa->nombre }}">
                            <div class="gallery-overlay">
                                <i class="fas fa-search-plus"></i>
                                <p style="margin-top: 10px; font-weight: 600;">{{ $media->descripcion ?? 'Ver imagen' }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    @for($i = 0; $i < 4; $i++)
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                        <div class="gallery-item" data-bs-toggle="modal" data-bs-target="#galleryModal" data-image="{{ asset('storage/' . $landing->logo_url) }}" data-description="Especias de {{ $empresa->nombre }}" data-index="{{ $i }}">
                            <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}">
                            <div class="gallery-overlay">
                                <i class="fas fa-search-plus"></i>
                                <p style="margin-top: 10px; font-weight: 600;">Ver imagen</p>
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
                <h2 class="section-title">Nuestra Comunidad de Sabores</h2>
                <p class="section-subtitle" style="color: #555;">{{ $landing->objetivo }} - Esto dicen nuestros clientes satisfechos</p>
            </div>
            <div class="row g-4">
                @php
                    $testimonials = [
                        [
                            'name' => 'María González',
                            'avatar' => '👩‍🍳',
                            'role' => 'Ama de Casa',
                            'comment' => 'Increíbles especias! Transformaron completamente mis comidas. Mis hijos ahora piden que cocine más seguido. La calidad es excelente y el aroma perdura.'
                        ],
                        [
                            'name' => 'Carlos Rodríguez',
                            'avatar' => '👨‍🍳',
                            'role' => 'Chef Profesional',
                            'comment' => 'Como chef, puedo confirmar que estas especias son de calidad superior. 100% naturales, frescas y con un sabor auténtico que mis clientes notan inmediatamente.'
                        ],
                        [
                            'name' => 'Ana Martínez',
                            'avatar' => '🍽️',
                            'role' => 'Food Blogger',
                            'comment' => 'Excelente servicio y productos. La entrega fue rápida y el empaque mantuvo todo fresco. Definitivamente recomiendo Especias Fénix para cualquier cocina.'
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
                        <p style="font-style: italic; margin-bottom: 20px; color: #333;">"{{ $testimonial['comment'] }}"</p>
                        <h5 style="margin-bottom: 5px; color: #333;">{{ $testimonial['name'] }}</h5>
                        <p style="color: #666; font-size: 0.9rem;">{{ $testimonial['role'] }}</p>
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
                <p class="section-subtitle">Estamos aquí para ayudarte a encontrar las especias perfectas para tu cocina</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up">
                    <div class="contact-card text-center">
                        <div class="contact-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="contact-info">
                            <h4>WhatsApp</h4>
                            <p>{{ $empresa->movil }}</p>
                            <a href="https://wa.me/57{{ $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Estoy%20interesado%20en%20sus%20especias%20naturales%20y%20me%20gustaría%20conocer%20más%20sobre%20sus%20productos" target="_blank" class="btn btn-sm btn-primary-custom mt-2">Enviar Mensaje</a>
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
                            <a href="https://www.google.com/maps/search/{{ urlencode($empresa->direccion) }}" target="_blank" class="btn btn-sm btn-primary-custom mt-2">Ver en Google Maps</a>
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
                    <a href="#gallery" class="footer-link">Productos</a>
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
                <p style="font-size: 0.9rem; color: #ccc;">Especias naturales que inspiran, sabores que perduran 🌿</p>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/57{{ $empresa->whatsapp ?? $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Estoy%20interesado%20en%20sus%20especias%20naturales%20y%20me%20gustaría%20recibir%20más%20información%20sobre%20productos%20disponibles" 
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

    <!-- Gallery Modal -->
    <div class="modal fade gallery-modal" id="galleryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="galleryModalTitle">Especias Premium</h5>
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
        console.log('%c🌿 Especias Fénix - Aromas que inspiran, sabores que perduran', 'color: #ca822f; font-size: 16px; font-weight: bold;');
    </script>
</body>
</html>
