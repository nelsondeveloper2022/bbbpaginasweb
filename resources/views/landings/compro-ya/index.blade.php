<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $landing->descripcion }}">
    <meta name="keywords" content="venta productos varios, compras online, productos variados, compro ya, compras rápidas">
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
    <link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $landing->tipografia ?? 'Inter') }}:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: {{ $landing->color_principal ?? '#007bff' }};
            --secondary-color: {{ $landing->color_secundario ?? '#6c757d' }};
            --font-family: '{{ $landing->tipografia ?? 'Inter' }}', sans-serif;
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
            background: rgba(0, 123, 255, 0.95) !important;
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
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
        }
        
        /* Hero Section */
        .hero-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, var(--primary-color) 0%, #e3f2fd 100%);
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%236c757d" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,149.3C960,160,1056,160,1152,138.7C1248,117,1344,75,1392,53.3L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat center bottom;
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
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            color: #f8f9fa;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .hero-description {
            font-size: 1.1rem;
            color: #e9ecef;
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
            background: #fff;
            color: var(--primary-color);
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            border: 2px solid #fff;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
        }
        
        .btn-primary-custom:hover {
            background: transparent;
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.3);
        }
        
        .btn-outline-custom {
            background: transparent;
            color: #fff;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            border: 2px solid #fff;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
        }
        
        .btn-outline-custom:hover {
            background: #fff;
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
            color: var(--primary-color);
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
            border-color: var(--primary-color);
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 123, 255, 0.2);
        }
        
        .benefit-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }
        
        /* Products Section */
        .products-section {
            background: #f8f9fa;
        }
        
        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        .product-image {
            height: 200px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }
        
        .product-content {
            padding: 20px;
        }
        
        .product-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 10px;
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
            background: linear-gradient(135deg, rgba(0,123,255,0.8) 0%, rgba(108,117,125,0.8) 100%);
            opacity: 0;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        
        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }
        
        .gallery-overlay i {
            color: white;
            font-size: 3rem;
            margin-bottom: 10px;
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
            background: rgba(0, 123, 255, 0.8);
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
            color: var(--primary-color);
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
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
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
        
        /* Scroll to top button */
        .scroll-top {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 45px;
            height: 45px;
            background: var(--primary-color);
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 999;
        }
        
        .scroll-top:hover {
            background: var(--secondary-color);
            transform: translateY(-5px);
        }
        
        .scroll-top i {
            color: white;
            font-size: 1.2rem;
        }
        
        .scroll-top.show {
            display: flex;
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
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#home">
                @if($landing->logo_url)
                    <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}">
                @else
                    <span style="color: white; font-weight: bold; font-size: 1.5rem;">{{ $landing->titulo_principal }}</span>
                @endif
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
                        <a class="nav-link" href="#gallery">Galería</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#products">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contacto</a>
                    </li>
                    @if(isset($productosActivos) && $productosActivos > 0)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('public.tienda', $empresa->slug) }}" target="_blank" style="color: #fff !important; font-weight: 600;">
                                <i class="fas fa-shopping-cart me-2"></i>Tienda Virtual
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="btn btn-whatsapp-header" href="https://wa.me/57{{ $empresa->whatsapp ?? $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Estoy%20interesado%20en%20sus%20productos%20y%20me%20gustaría%20recibir%20más%20información" target="_blank">
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
                            {{ $landing->descripcion }}. Encuentra todo lo que necesitas en un solo lugar con entregas rápidas y productos de calidad.
                        </p>
                        <div class="animate__animated animate__fadeInUp animate__delay-3s">
                            <a href="#products" class="btn-primary-custom">
                                <i class="fas fa-shopping-bag me-2"></i>Ver Productos
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
                        @elseif($landing->logo_url)
                            <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}" class="img-fluid">
                        @else
                            <div style="background: rgba(255,255,255,0.1); padding: 80px; border-radius: 20px; text-align: center;">
                                <i class="fas fa-shopping-cart" style="font-size: 6rem; color: white; opacity: 0.7;"></i>
                                <h3 style="color: white; margin-top: 20px;">{{ $landing->titulo_principal }}</h3>
                            </div>
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
                <p class="section-subtitle">Tu aliado confiable para compras rápidas y productos de calidad desde {{ $empresa->direccion }}</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="about-card">
                        <div class="about-icon">
                            <i class="fas fa-target"></i>
                        </div>
                        <h3>Nuestra Misión</h3>
                        <p>En <strong>{{ $empresa->nombre }}</strong>, nos dedicamos a facilitarte las compras del día a día. Ofrecemos una amplia variedad de productos de alta calidad con entrega rápida y servicio personalizado.</p>
                        <p class="mt-3">Creemos que comprar debe ser fácil, rápido y conveniente. Por eso trabajamos incansablemente para brindarte la mejor experiencia de compra, con productos variados que satisfacen todas tus necesidades.</p>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="about-card">
                        <div class="about-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>¿Para Quién Trabajamos?</h3>
                        <p><strong>Nuestros Clientes:</strong></p>
                        <p>Familias que buscan practicidad en sus compras diarias, profesionales ocupados que valoran el tiempo, personas que prefieren la comodidad de comprar desde casa, y todos aquellos que buscan productos de calidad a precios justos.</p>
                        <p class="mt-3">Entendemos tu rutina y sabemos que tu tiempo es valioso. Por eso, simplificamos tus compras para que puedas enfocarte en lo que realmente importa.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Problems Section -->
    <section id="problems" class="problems-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">¿Te Resulta Familiar?</h2>
                <p class="section-subtitle" style="color: #e0e0e0;">Estos son los desafíos que enfrentas al hacer compras</p>
            </div>
            <div class="row g-4">
                @php
                    $problems = [
                        [
                            'icon' => 'fa-clock',
                            'title' => 'Falta de Tiempo',
                            'description' => 'No tienes tiempo para ir de tienda en tienda buscando los productos que necesitas. Tu agenda está llena y necesitas soluciones rápidas.'
                        ],
                        [
                            'icon' => 'fa-car',
                            'title' => 'Problemas de Transporte',
                            'description' => 'Dificultades para trasladarte a los centros comerciales o cargar con las compras. El tráfico y el estacionamiento son un problema.'
                        ],
                        [
                            'icon' => 'fa-search',
                            'title' => 'Variedad Limitada',
                            'description' => 'No encuentras todos los productos que necesitas en un solo lugar. Tienes que visitar múltiples tiendas para completar tu lista.'
                        ],
                        [
                            'icon' => 'fa-money-bill',
                            'title' => 'Precios Elevados',
                            'description' => 'Los precios en tiendas físicas suelen ser más altos y no siempre encuentras ofertas o promociones atractivas.'
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
                <p class="section-subtitle">Descubre por qué {{ $empresa->nombre }} es tu mejor opción para compras inteligentes</p>
            </div>
            <div class="row g-4">
                @php
                    $benefits = [
                        [
                            'icon' => 'fa-shipping-fast',
                            'title' => 'Entrega Rápida',
                            'description' => 'Recibe tus productos en tiempo récord. Entregas el mismo día o en 24 horas máximo, directamente en tu hogar u oficina.'
                        ],
                        [
                            'icon' => 'fa-thumbs-up',
                            'title' => 'Calidad Garantizada',
                            'description' => 'Todos nuestros productos pasan por rigurosos controles de calidad. Si no estás satisfecho, te devolvemos tu dinero.'
                        ],
                        [
                            'icon' => 'fa-tag',
                            'title' => 'Precios Competitivos',
                            'description' => 'Ofertas exclusivas y precios justos todos los días. Ahorra tiempo y dinero comprando con nosotros.'
                        ],
                        [
                            'icon' => 'fa-mobile-alt',
                            'title' => 'Compra Fácil',
                            'description' => 'Proceso de compra simple y rápido. Solo unos clics y listo. Pago seguro y múltiples métodos de pago disponibles.'
                        ],
                        [
                            'icon' => 'fa-headset',
                            'title' => 'Atención 24/7',
                            'description' => 'Servicio al cliente disponible cuando lo necesites. Resolvemos tus dudas y problemas de forma inmediata.'
                        ],
                        [
                            'icon' => 'fa-star',
                            'title' => 'Experiencia Única',
                            'description' => 'Miles de clientes satisfechos respaldan nuestro servicio. Una experiencia de compra que supera tus expectativas.'
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
                <h2 class="section-title">Galería de Productos</h2>
                <p class="section-subtitle">Conoce algunos de nuestros productos más populares</p>
            </div>
            <div class="row g-4">
                @if($landing->media && $landing->media->count() > 0)
                    @foreach($landing->media as $index => $media)
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="gallery-item" data-bs-toggle="modal" data-bs-target="#galleryModal" data-image="{{ asset('storage/' . $media->url) }}" data-description="{{ $media->descripcion ?? 'Producto de ' . $empresa->nombre }}" data-index="{{ $index }}">
                            <img src="{{ asset('storage/' . $media->url) }}" alt="{{ $media->descripcion ?? 'Producto de ' . $empresa->nombre }}">
                            <div class="gallery-overlay">
                                <i class="fas fa-search-plus"></i>
                                <p style="margin-top: 10px; font-weight: 600; color: white;">{{ $media->descripcion ?? 'Ver imagen' }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    @for($i = 0; $i < 8; $i++)
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                        <div class="gallery-item" data-bs-toggle="modal" data-bs-target="#galleryModal" data-image="{{ asset('storage/' . $landing->logo_url) }}" data-description="Productos de {{ $empresa->nombre }}" data-index="{{ $i }}">
                            @if($landing->logo_url)
                                <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}">
                            @else
                                <div style="width: 100%; height: 300px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); display: flex; align-items: center; justify-content: center; flex-direction: column; color: white;">
                                    <i class="fas fa-shopping-bag" style="font-size: 3rem; margin-bottom: 10px;"></i>
                                    <span style="font-weight: 600;">Producto {{ $i + 1 }}</span>
                                </div>
                            @endif
                            <div class="gallery-overlay">
                                <i class="fas fa-search-plus"></i>
                                <p style="margin-top: 10px; font-weight: 600; color: white;">Ver imagen</p>
                            </div>
                        </div>
                    </div>
                    @endfor
                @endif
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="products-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Categorías de Productos</h2>
                <p class="section-subtitle">Amplia variedad de productos para satisfacer todas tus necesidades</p>
            </div>
            <div class="row g-4">
                @php
                    $categories = [
                        [
                            'icon' => 'fa-shopping-basket',
                            'title' => 'Hogar y Limpieza',
                            'description' => 'Productos de limpieza, artículos para el hogar, detergentes, jabones y todo lo necesario para mantener tu casa impecable.'
                        ],
                        [
                            'icon' => 'fa-utensils',
                            'title' => 'Alimentos y Bebidas',
                            'description' => 'Alimentos frescos, productos de despensa, bebidas, snacks y todo para tu cocina y alimentación diaria.'
                        ],
                        [
                            'icon' => 'fa-heartbeat',
                            'title' => 'Salud y Cuidado Personal',
                            'description' => 'Productos de higiene personal, medicamentos básicos, vitaminas y artículos para el cuidado de tu salud.'
                        ],
                        [
                            'icon' => 'fa-laptop',
                            'title' => 'Tecnología',
                            'description' => 'Dispositivos electrónicos, accesorios tecnológicos, cables, cargadores y gadgets útiles para tu día a día.'
                        ],
                        [
                            'icon' => 'fa-tshirt',
                            'title' => 'Ropa y Accesorios',
                            'description' => 'Prendas de vestir para toda la familia, calzado, accesorios de moda y artículos de temporada.'
                        ],
                        [
                            'icon' => 'fa-gamepad',
                            'title' => 'Entretenimiento',
                            'description' => 'Juegos, juguetes, libros, artículos deportivos y todo lo necesario para tu tiempo libre y diversión.'
                        ]
                    ];
                @endphp
                
                @foreach($categories as $index => $category)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="product-card">
                        <div class="product-image">
                            <i class="fas {{ $category['icon'] }}"></i>
                        </div>
                        <div class="product-content">
                            <h4 class="product-title">{{ $category['title'] }}</h4>
                            <p>{{ $category['description'] }}</p>
                        </div>
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
                <p class="section-subtitle">Estamos aquí para ayudarte. ¡Haz tu pedido ahora!</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up">
                    <div class="contact-card text-center">
                        <div class="contact-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="contact-info">
                            <h4>WhatsApp</h4>
                            <p>{{ $empresa->movil ?? $empresa->whatsapp }}</p>
                            <a href="https://wa.me/57{{ $empresa->movil ?? $empresa->whatsapp }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Estoy%20interesado%20en%20sus%20productos%20y%20me%20gustaría%20hacer%20un%20pedido" target="_blank" class="btn btn-sm btn-primary-custom mt-2">Hacer Pedido</a>
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
                            <h4>Ubicación</h4>
                            <p>{{ $empresa->direccion }}</p>
                            <a href="https://www.google.com/maps/search/{{ urlencode($empresa->direccion) }}" target="_blank" class="btn btn-sm btn-primary-custom mt-2">Ver Mapa</a>
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
                        @if($landing->logo_url)
                            <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}">
                        @else
                            <h4 style="color: var(--primary-color);">{{ $landing->titulo_principal }}</h4>
                        @endif
                    </div>
                    <p>{{ $landing->descripcion }}</p>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <h5>Enlaces Rápidos</h5>
                    <a href="#home" class="footer-link">Inicio</a>
                    <a href="#about" class="footer-link">Nosotros</a>
                    <a href="#benefits" class="footer-link">Beneficios</a>
                    <a href="#gallery" class="footer-link">Galería</a>
                    <a href="#products" class="footer-link">Productos</a>
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
                <p style="font-size: 0.9rem; color: #ccc;">{{ $landing->titulo_principal }} - Tu tienda de confianza 🛒</p>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/57{{ $empresa->whatsapp ?? $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Estoy%20interesado%20en%20hacer%20un%20pedido.%20¿Podrían%20ayudarme%20con%20la%20información%20de%20productos%20disponibles?" 
       target="_blank" 
       class="floating-whatsapp"
       title="¡Haz tu pedido por WhatsApp!">
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
                    <h5 class="modal-title" id="galleryModalTitle">Productos</h5>
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
        if (galleryPrev) galleryPrev.addEventListener('click', showPreviousImage);
        if (galleryNext) galleryNext.addEventListener('click', showNextImage);

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (galleryModal && galleryModal.classList.contains('show')) {
                if (e.key === 'ArrowLeft') {
                    showPreviousImage();
                } else if (e.key === 'ArrowRight') {
                    showNextImage();
                } else if (e.key === 'Escape') {
                    const modal = bootstrap.Modal.getInstance(galleryModal);
                    if (modal) modal.hide();
                }
            }
        });

        // Prevent image dragging
        if (galleryModalImage) {
            galleryModalImage.addEventListener('dragstart', function(e) {
                e.preventDefault();
            });
        }

        // Console message
        console.log('%c🛒 Compro Ya - Tu tienda de confianza para compras rápidas', 'color: #007bff; font-size: 16px; font-weight: bold;');
    </script>
</body>
</html>
