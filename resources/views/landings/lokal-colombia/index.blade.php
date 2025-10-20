<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $landing->descripcion }}">
    <title>{{ $landing->titulo_principal }} - {{ $empresa->nombre }}</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --color-principal: {{ $landing->color_principal }};
            --color-secundario: {{ $landing->color_secundario ?? '#ec910b' }};
            --tipografia: {{ $landing->tipografia ?? "'Poppins', sans-serif" }};
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: var(--tipografia);
            color: #333;
            overflow-x: hidden;
        }
        
        /* Navbar */
        .navbar-custom {
            background: var(--color-principal);
            box-shadow: 0 2px 20px rgba(0,0,0,0.3);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }
        
        .navbar-custom.scrolled {
            padding: 0.5rem 0;
            box-shadow: 0 4px 30px rgba(0,0,0,0.4);
        }
        
        .navbar-brand img {
            height: 50px;
            transition: all 0.3s ease;
        }
        
        .navbar-custom.scrolled .navbar-brand img {
            height: 40px;
        }
        
        .nav-link {
            color: white !important;
            font-weight: 500;
            margin: 0 1rem;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--color-secundario);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover:after {
            width: 80%;
        }
        
        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.5);
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.85%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--color-principal) 0%, #1a2332 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 100px 0 80px;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.1;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 2rem;
            opacity: 0.95;
        }
        
        .hero-description {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 2.5rem;
            opacity: 0.9;
        }
        
        .btn-primary-custom {
            background: var(--color-secundario);
            border: none;
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(236, 145, 11, 0.3);
        }
        
        .btn-primary-custom:hover {
            background: #d68009;
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(236, 145, 11, 0.4);
        }
        
        .btn-outline-custom {
            border: 2px solid white;
            color: white;
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            background: transparent;
        }
        
        .btn-outline-custom:hover {
            background: white;
            color: var(--color-principal);
            transform: translateY(-3px);
        }
        
        .hero-image {
            position: relative;
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .hero-image img {
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 500px;
        }
        
        /* Section Styles */
        section {
            padding: 80px 0;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--color-principal);
            position: relative;
            display: inline-block;
        }
        
        .section-title.text-white {
            color: white !important;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--color-secundario);
            border-radius: 2px;
        }
        
        .section-subtitle {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 3rem;
        }
        
        /* About Section */
        .about-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }
        
        .about-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
            border: 2px solid transparent;
        }
        
        .about-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(236, 145, 11, 0.2);
            border-color: var(--color-secundario);
        }
        
        .about-icon {
            font-size: 3rem;
            color: var(--color-secundario);
            margin-bottom: 1.5rem;
        }
        
        /* Problems Section */
        .problems-section {
            background: linear-gradient(135deg, var(--color-principal) 0%, #0a0f1a 100%);
            color: white;
        }
        
        .problem-item {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--color-secundario);
            transition: all 0.3s ease;
        }
        
        .problem-item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(10px);
        }
        
        .problem-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        /* Benefits Section */
        .benefits-section {
            background: white;
        }
        
        .benefit-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            border-radius: 20px;
            padding: 2.5rem;
            text-align: center;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
            border: 2px solid transparent;
        }
        
        .benefit-card:hover {
            border-color: var(--color-secundario);
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(236, 145, 11, 0.2);
        }
        
        .benefit-icon {
            width: 80px;
            height: 80px;
            background: var(--color-secundario);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }
        
        /* Gallery Section */
        .gallery-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }
        
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .gallery-item:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
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
            background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.7) 100%);
            opacity: 0;
            transition: all 0.3s ease;
            display: flex;
            align-items: flex-end;
            padding: 1.5rem;
        }
        
        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }
        
        /* Testimonials Section */
        .testimonials-section {
            background: linear-gradient(135deg, var(--color-principal) 0%, #1a2332 100%);
            color: white;
        }
        
        .testimonial-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .testimonial-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-10px);
        }
        
        .testimonial-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--color-secundario);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1.5rem;
            border: 4px solid rgba(255, 255, 255, 0.3);
        }
        
        .stars {
            color: var(--color-secundario);
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }
        
        /* Contact Section */
        .contact-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }
        
        .contact-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        
        .contact-info {
            background: var(--color-principal);
            color: white;
            border-radius: 20px;
            padding: 3rem;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .contact-icon {
            width: 50px;
            height: 50px;
            background: var(--color-secundario);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1.5rem;
            font-size: 1.5rem;
        }
        
        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: var(--color-secundario);
            color: white;
            border-radius: 50%;
            margin-right: 1rem;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            transform: translateY(-5px) rotate(360deg);
            background: white;
            color: var(--color-secundario);
        }
        
        /* Footer */
        .footer {
            background: var(--color-principal);
            color: white;
            padding: 3rem 0 1rem;
        }
        
        .footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer a:hover {
            color: var(--color-secundario);
        }
        
        /* WhatsApp Floating Button */
        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: #25D366;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            box-shadow: 0 5px 20px rgba(37, 211, 102, 0.5);
            z-index: 1000;
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
        }
        
        .whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 0 10px 30px rgba(37, 211, 102, 0.7);
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        /* Modal Customization */
        .modal-content {
            border-radius: 20px;
            border: none;
        }
        
        .modal-header {
            background: var(--color-principal);
            color: white;
            border-radius: 20px 20px 0 0;
            border: none;
        }
        
        .modal-header .btn-close {
            filter: invert(1);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .navbar-brand img {
                height: 40px;
            }
        }
    </style>
</head>
<body>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#hero">
                <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#hero">Inicio</a>
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
                        <a class="nav-link" href="#contact">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary-custom ms-3" href="https://wa.me/57{{ $empresa->whatsapp }}?text=Hola,%20quiero%20registrar%20mi%20negocio%20en%20Lokal%20Colombia" target="_blank">
                            <i class="bi bi-whatsapp me-2"></i>Registrar Negocio
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section id="hero" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content" data-aos="fade-right">
                    <h1 class="hero-title">{{ $landing->titulo_principal }}</h1>
                    <p class="hero-subtitle">{{ $landing->subtitulo }}</p>
                    <p class="hero-description">{{ $landing->descripcion }}</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="https://wa.me/57{{ $empresa->whatsapp }}?text=Hola,%20quiero%20registrar%20mi%20negocio%20en%20Lokal%20Colombia" class="btn btn-primary-custom" target="_blank">
                            <i class="bi bi-whatsapp me-2"></i>Registrar Gratis
                        </a>
                        <a href="#about" class="btn btn-outline-custom">
                            Conocer Más
                        </a>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                    <div class="hero-image text-center">
                        @if($landing->media && $landing->media->count() > 0)
                            <img src="{{ asset('storage/' . $landing->media->first()->url) }}" alt="{{ $empresa->nombre }}" class="img-fluid">
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
                <h2 class="section-title">¿Qué es {{ $empresa->nombre }}?</h2>
                <p class="section-subtitle">{{ $landing->descripcion_objetivo }}</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="about-card">
                        <div class="about-icon">
                            <i class="bi bi-rocket-takeoff"></i>
                        </div>
                        <h3 class="h4 mb-3">Nuestra Misión</h3>
                        <p>Impulsar el crecimiento de los negocios locales mediante herramientas digitales accesibles y efectivas que conecten emprendedores con más clientes.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="about-card">
                        <div class="about-icon">
                            <i class="bi bi-eye"></i>
                        </div>
                        <h3 class="h4 mb-3">Nuestra Visión</h3>
                        <p>Ser la plataforma líder en Colombia para la digitalización y visibilidad de negocios locales, fortaleciendo la economía regional.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="about-card">
                        <div class="about-icon">
                            <i class="bi bi-heart"></i>
                        </div>
                        <h3 class="h4 mb-3">Nuestros Valores</h3>
                        <p>Compromiso con el emprendimiento, transparencia, innovación constante y apoyo genuino al desarrollo económico local.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Problems Section -->
    <section id="problems" class="problems-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title text-white">¿Qué Problemas Resolvemos?</h2>
                <p class="section-subtitle text-white">Entendemos los desafíos de los negocios locales</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    @php
                        $problems = explode('.', $landing->audiencia_problemas);
                        $problemIcons = ['bi-exclamation-triangle', 'bi-graph-down', 'bi-search', 'bi-code-slash'];
                    @endphp
                    @foreach($problems as $index => $problem)
                        @if(trim($problem))
                            <div class="problem-item" data-aos="fade-right" data-aos-delay="{{ $index * 100 }}">
                                <div class="d-flex align-items-start">
                                    <div class="problem-icon me-3">
                                        <i class="bi {{ $problemIcons[$index % 4] }}"></i>
                                    </div>
                                    <div>
                                        <h4>{{ trim($problem) }}.</h4>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    
    <!-- Benefits Section -->
    <section id="benefits" class="benefits-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Beneficios de Unirte</h2>
                <p class="section-subtitle">Todo lo que tu negocio necesita para crecer</p>
            </div>
            <div class="row g-4">
                @php
                    $benefits = explode('.', $landing->audiencia_beneficios);
                    $benefitIcons = ['bi-check-circle-fill', 'bi-speedometer2', 'bi-globe', 'bi-tools', 'bi-people'];
                @endphp
                @foreach($benefits as $index => $benefit)
                    @if(trim($benefit))
                        <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="{{ $index * 100 }}">
                            <div class="benefit-card">
                                <div class="benefit-icon">
                                    <i class="bi {{ $benefitIcons[$index % 5] }}"></i>
                                </div>
                                <h4 class="mb-3">{{ trim($benefit) }}</h4>
                                <p class="text-muted">Potencia tu negocio con herramientas profesionales sin complicaciones técnicas.</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
    
    <!-- Gallery Section -->
    <section id="gallery" class="gallery-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Nuestra Galería</h2>
                <p class="section-subtitle">Conoce más sobre nosotros</p>
            </div>
            <div class="row g-4">
                @if($landing->media && $landing->media->count() > 0)
                    @foreach($landing->media as $index => $media)
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <div class="gallery-item">
                                <img src="{{ asset('storage/' . $media->url) }}" alt="{{ $media->descripcion ?? 'Imagen de ' . $empresa->nombre }}">
                                <div class="gallery-overlay">
                                    <p class="text-white mb-0">{{ $media->descripcion ?? $empresa->nombre }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- Agregar logo como tercera imagen -->
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="gallery-item">
                            <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}">
                            <div class="gallery-overlay">
                                <p class="text-white mb-0">{{ $empresa->nombre }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-12 text-center">
                        <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}" class="img-fluid" style="max-width: 400px;">
                    </div>
                @endif
            </div>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title text-white">Lo Que Dicen Nuestros Clientes</h2>
                <p class="section-subtitle text-white">{{ $landing->objetivo }}</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-card">
                        <div class="testimonial-avatar">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="stars mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="mb-4">"Registrar mi tienda en Lokal Colombia fue lo mejor que pude hacer. En solo una semana empecé a recibir más clientes. ¡100% recomendado!"</p>
                        <h5 class="mb-1">María Rodríguez</h5>
                        <p class="small opacity-75">Tienda de Ropa - Bogotá</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card">
                        <div class="testimonial-avatar">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="stars mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="mb-4">"Gracias a Lokal Colombia mi restaurante ahora tiene presencia en Google. Los clientes nos encuentran fácilmente y las ventas han aumentado."</p>
                        <h5 class="mb-1">Carlos Gómez</h5>
                        <p class="small opacity-75">Restaurante - Medellín</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-card">
                        <div class="testimonial-avatar">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="stars mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="mb-4">"Excelente plataforma para emprendedores. El proceso es súper fácil y el soporte es increíble. Mi negocio ahora es más visible."</p>
                        <h5 class="mb-1">Laura Martínez</h5>
                        <p class="small opacity-75">Servicios de Belleza - Cali</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Contáctanos</h2>
                <p class="section-subtitle">Estamos aquí para ayudarte a hacer crecer tu negocio</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="contact-info">
                        <h3 class="mb-4">Información de Contacto</h3>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Dirección</h5>
                                <p class="mb-0">{{ $empresa->direccion }}</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Teléfono</h5>
                                <p class="mb-0">{{ $empresa->movil }}</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Email</h5>
                                <p class="mb-0">{{ $empresa->email }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h5 class="mb-3">Síguenos en Redes Sociales</h5>
                            <div class="social-links">
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
                                @if($empresa->whatsapp)
                                    <a href="https://wa.me/57{{ $empresa->whatsapp }}" target="_blank" title="WhatsApp">
                                        <i class="bi bi-whatsapp"></i>
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="contact-card">
                        <h3 class="mb-4">Registra Tu Negocio</h3>
                        <p class="mb-4">Completa el formulario y en breve nos pondremos en contacto contigo para ayudarte a registrar tu negocio.</p>
                        <div class="text-center">
                            <a href="https://wa.me/57{{ $empresa->whatsapp }}?text=Hola,%20quiero%20registrar%20mi%20negocio%20en%20Lokal%20Colombia.%20Mi%20nombre%20es:%20" class="btn btn-primary-custom btn-lg" target="_blank">
                                <i class="bi bi-whatsapp me-2"></i>Contactar por WhatsApp
                            </a>
                            <p class="mt-4 text-muted">
                                <i class="bi bi-shield-check me-2"></i>
                                Tus datos están protegidos y seguros
                            </p>
                        </div>
                        <div class="mt-4 p-4 bg-light rounded">
                            <h5 class="mb-3">
                                <i class="bi bi-clock me-2" style="color: var(--color-secundario);"></i>
                                Horario de Atención
                            </h5>
                            <p class="mb-2"><strong>Lunes a Viernes:</strong> 8:00 AM - 6:00 PM</p>
                            <p class="mb-0"><strong>Sábados:</strong> 9:00 AM - 1:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}" style="height: 60px;" class="mb-3">
                    <p class="mb-3">{{ $landing->descripcion_objetivo }}</p>
                    <div class="social-links">
                        @if($empresa->facebook)
                            <a href="{{ $empresa->facebook }}" target="_blank">
                                <i class="bi bi-facebook"></i>
                            </a>
                        @endif
                        @if($empresa->instagram)
                            <a href="{{ $empresa->instagram }}" target="_blank">
                                <i class="bi bi-instagram"></i>
                            </a>
                        @endif
                        @if($empresa->whatsapp)
                            <a href="https://wa.me/57{{ $empresa->whatsapp }}" target="_blank">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="mb-3">Enlaces</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#hero">Inicio</a></li>
                        <li class="mb-2"><a href="#about">Nosotros</a></li>
                        <li class="mb-2"><a href="#benefits">Beneficios</a></li>
                        <li class="mb-2"><a href="#contact">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-3">Legal</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" data-bs-toggle="modal" data-bs-target="#modalTerminos">Términos y Condiciones</a></li>
                        <li class="mb-2"><a href="#" data-bs-toggle="modal" data-bs-target="#modalPrivacidad">Política de Privacidad</a></li>
                        <li class="mb-2"><a href="#" data-bs-toggle="modal" data-bs-target="#modalCookies">Política de Cookies</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-3">Contacto</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-geo-alt me-2"></i>{{ $empresa->direccion }}
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-telephone me-2"></i>{{ $empresa->movil }}
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-envelope me-2"></i>{{ $empresa->email }}
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} {{ $empresa->nombre }}. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
    
    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/57{{ $empresa->whatsapp }}?text=Hola,%20necesito%20información%20sobre%20Lokal%20Colombia" class="whatsapp-float" target="_blank" title="Contáctanos por WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>
    
    <!-- Modal Términos y Condiciones -->
    <div class="modal fade" id="modalTerminos" tabindex="-1" aria-labelledby="modalTerminosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTerminosLabel">Términos y Condiciones</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($empresa->terminos_condiciones)
                        {!! $empresa->terminos_condiciones !!}
                    @else
                        <p>Los términos y condiciones están en proceso de actualización. Por favor, contáctanos para más información.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Política de Privacidad -->
    <div class="modal fade" id="modalPrivacidad" tabindex="-1" aria-labelledby="modalPrivacidadLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPrivacidadLabel">Política de Privacidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($empresa->politica_privacidad)
                        {!! $empresa->politica_privacidad !!}
                    @else
                        <p>La política de privacidad está en proceso de actualización. Por favor, contáctanos para más información.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Política de Cookies -->
    <div class="modal fade" id="modalCookies" tabindex="-1" aria-labelledby="modalCookiesLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCookiesLabel">Política de Cookies</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($empresa->politica_cookies)
                        {!! $empresa->politica_cookies !!}
                    @else
                        <p>La política de cookies está en proceso de actualización. Por favor, contáctanos para más información.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation -->
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
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Smooth scroll for anchor links
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
        
        // Close mobile menu on link click
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                const navbarCollapse = document.querySelector('.navbar-collapse');
                if (navbarCollapse.classList.contains('show')) {
                    bootstrap.Collapse.getInstance(navbarCollapse).hide();
                }
            });
        });
    </script>
</body>
</html>
