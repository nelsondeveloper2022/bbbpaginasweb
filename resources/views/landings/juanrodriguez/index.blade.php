<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landing->titulo_principal }} - {{ $empresa->nombre }}</title>
    <meta name="description" content="{{ $landing->descripcion }}">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: {{ $landing->color_principal ?? '#6c9d86' }};
            --secondary-color: #e8dbb6;
            --accent-color: #2c5530;
            --text-dark: #333;
            --text-light: #666;
            --bg-light: #f8f9fa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: '{{ $landing->tipografia ?? 'Inter' }}', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Header Styles */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .navbar-brand img {
            height: 50px;
            width: auto;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover img {
            transform: scale(1.05);
        }

        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: var(--primary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(108, 157, 134, 0.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 157, 134, 0.4);
            color: white;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 150px 0 100px;
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 200"><path d="M0,100 C150,200 350,0 500,100 C650,200 850,0 1000,100 V200 H0 V100 Z" fill="rgba(255,255,255,0.1)"/></svg>');
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
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #fff, var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }

        .hero-description {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.8;
        }

        /* Sections */
        .section-padding {
            padding: 100px 0;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-dark);
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 2px;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: var(--text-light);
            margin-bottom: 3rem;
        }

        /* Cards */
        .card-custom {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
        }

        .card-custom:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }

        .card-custom .card-body {
            padding: 2rem;
        }

        .card-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: white;
            font-size: 2rem;
        }

        /* Gallery */
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            margin-bottom: 2rem;
            cursor: pointer;
        }

        .gallery-item img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: transform 0.5s ease;
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
            background: linear-gradient(135deg, rgba(108, 157, 134, 0.8), rgba(44, 85, 48, 0.8));
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        /* Testimonials */
        .testimonial-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 4rem;
            color: var(--primary-color);
            font-family: 'Playfair Display', serif;
        }

        .testimonial-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: 700;
        }

        /* Contact Section */
        .contact-section {
            background: var(--bg-light);
        }

        .contact-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            text-align: center;
            height: 100%;
        }

        .contact-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 1.5rem;
        }

        /* Footer */
        .footer {
            background: var(--text-dark);
            color: white;
            padding: 60px 0 30px;
        }

        .footer-logo {
            height: 60px;
            margin-bottom: 1rem;
        }

        .social-links a {
            display: inline-block;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border-radius: 50%;
            text-align: center;
            line-height: 50px;
            color: white;
            margin: 0 10px 10px 0;
            transition: all 0.3s ease;
            font-size: 1.2rem;
        }

        .social-links a:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(108, 157, 134, 0.4);
            color: white;
        }

        .footer-links a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary-color);
        }

        /* WhatsApp Float Button */
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background: #25d366;
            color: white;
            border-radius: 50%;
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
            background: #128c7e;
            transform: scale(1.1);
            color: white;
        }

        /* Responsive Design */
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
            
            .section-padding {
                padding: 60px 0;
            }
            
            .hero-section {
                padding: 120px 0 80px;
            }
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 20px;
            border: none;
        }

        .modal-header {
            border-bottom: 1px solid #e9ecef;
            background: var(--bg-light);
        }

        .modal-title {
            color: var(--primary-color);
            font-weight: 700;
        }

        /* Animation Classes */
        .fade-in-up {
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="#home">
                <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Acerca de</a>
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
                    @if(isset($productosActivos) && $productosActivos > 0)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('public.tienda', $empresa->slug) }}" target="_blank" style="color: var(--secondary-color) !important; font-weight: 600;">
                                <i class="fas fa-shopping-cart me-2"></i>Tienda Virtual
                            </a>
                        </li>
                    @endif
                </ul>
                <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $empresa->whatsapp) }}" class="btn btn-primary-custom ms-3" target="_blank">
                    <i class="fab fa-whatsapp me-2"></i>¡Únete Ahora!
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content" data-aos="fade-right">
                        <h1 class="hero-title">{{ $landing->titulo_principal }}</h1>
                        <h2 class="hero-subtitle">{{ $landing->subtitulo }}</h2>
                        <p class="hero-description">{{ $landing->descripcion }}</p>
                        <div class="hero-buttons">
                            <a href="#community" class="btn btn-primary-custom me-3">
                                <i class="fas fa-users me-2"></i>Únete a la Comunidad
                            </a>
                            <a href="#about" class="btn btn-outline-light">
                                <i class="fas fa-compass me-2"></i>Descubre Más
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center" data-aos="fade-left">
                        @if($landing->media && $landing->media->count() > 0)
                            <img src="{{ asset('storage/' . $landing->media->first()->url) }}" 
                                 alt="{{ $landing->media->first()->descripcion ?? 'Imagen de ' . $empresa->nombre }}" 
                                 class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
                        @else
                            <img src="{{ asset('storage/' . $landing->logo_url) }}" 
                                 alt="{{ $empresa->nombre }}" 
                                 class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="section-title" data-aos="fade-up">Nuestro Propósito</h2>
                    <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                        Conectando exploradores modernos con el espíritu de la aventura
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="about-content">
                        <h3 class="mb-4">Nuestra Misión</h3>
                        <p class="mb-4">{{ $landing->descripcion_objetivo }}</p>
                        
                        <div class="company-info">
                            <h4 class="mb-3">Información de Contacto</h4>
                            <div class="contact-info-item mb-2">
                                <i class="fas fa-envelope me-3 text-primary"></i>
                                <strong>Email:</strong> {{ $empresa->email }}
                            </div>
                            @if($empresa->movil)
                            <div class="contact-info-item mb-2">
                                <i class="fas fa-phone me-3 text-primary"></i>
                                <strong>Teléfono:</strong> {{ $empresa->movil }}
                            </div>
                            @endif
                            <div class="contact-info-item mb-2">
                                <i class="fas fa-map-marker-alt me-3 text-primary"></i>
                                <strong>Ubicación:</strong> {{ $empresa->direccion }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card-custom text-center">
                                <div class="card-body">
                                    <div class="card-icon mx-auto">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <h5>Comunidad Global</h5>
                                    <p>Únete a exploradores de todo el mundo</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card-custom text-center">
                                <div class="card-body">
                                    <div class="card-icon mx-auto">
                                        <i class="fas fa-compass"></i>
                                    </div>
                                    <h5>Rutas Históricas</h5>
                                    <p>Descubre caminos llenos de historia</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card-custom text-center">
                                <div class="card-body">
                                    <div class="card-icon mx-auto">
                                        <i class="fas fa-book-open"></i>
                                    </div>
                                    <h5>Contenido Exclusivo</h5>
                                    <p>Accede a recursos únicos y curados</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card-custom text-center">
                                <div class="card-body">
                                    <div class="card-icon mx-auto">
                                        <i class="fas fa-medal"></i>
                                    </div>
                                    <h5>Desafíos Temáticos</h5>
                                    <p>Participa en aventuras programadas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Problems Section -->
    <section class="section-padding" style="background: var(--bg-light);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="section-title" data-aos="fade-up">¿Te Identificas con Esto?</h2>
                    <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                        Problemas comunes que enfrentan los amantes de la historia y la exploración
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="problems-content" data-aos="fade-up">
                        <div class="text-center mb-5">
                            <i class="fas fa-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
                        </div>
                        <div class="problems-text">
                            <p class="lead text-center mb-4">{{ $landing->audiencia_problemas }}</p>
                        </div>
                        
                        <div class="row mt-5">
                            <div class="col-md-4 mb-4">
                                <div class="problem-item text-center">
                                    <div class="problem-icon mb-3">
                                        <i class="fas fa-search text-danger" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <h5>Información Dispersa</h5>
                                    <p>Difícil encontrar contenido curado sobre rutas históricas</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="problem-item text-center">
                                    <div class="problem-icon mb-3">
                                        <i class="fas fa-user-friends text-warning" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <h5>Falta de Comunidad</h5>
                                    <p>No hay espacios para compartir la pasión por la exploración</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="problem-item text-center">
                                    <div class="problem-icon mb-3">
                                        <i class="fas fa-lightbulb text-info" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <h5>Falta de Inspiración</h5>
                                    <p>Necesidad de nuevas ideas para aventuras temáticas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="section-title" data-aos="fade-up">La Solución que Buscabas</h2>
                    <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                        Descubre todos los beneficios de unirte a nuestra comunidad
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="benefits-content" data-aos="fade-up">
                        <div class="text-center mb-5">
                            <i class="fas fa-trophy text-success" style="font-size: 4rem;"></i>
                        </div>
                        <div class="benefits-text mb-5">
                            <p class="lead text-center">{{ $landing->audiencia_beneficios }}</p>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="benefit-item d-flex">
                                    <div class="benefit-icon me-3">
                                        <i class="fas fa-globe text-success" style="font-size: 2rem;"></i>
                                    </div>
                                    <div>
                                        <h5>Conexión Global</h5>
                                        <p>Red mundial de personas con intereses similares en historia y aventura</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="benefit-item d-flex">
                                    <div class="benefit-icon me-3">
                                        <i class="fas fa-star text-success" style="font-size: 2rem;"></i>
                                    </div>
                                    <div>
                                        <h5>Contenido Exclusivo</h5>
                                        <p>Acceso a recursos únicos, mapas interactivos y material curado</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="benefit-item d-flex">
                                    <div class="benefit-icon me-3">
                                        <i class="fas fa-hands-helping text-success" style="font-size: 2rem;"></i>
                                    </div>
                                    <div>
                                        <h5>Participación Activa</h5>
                                        <p>Foros, debates y eventos virtuales exclusivos para miembros</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="benefit-item d-flex">
                                    <div class="benefit-icon me-3">
                                        <i class="fas fa-heart text-success" style="font-size: 2rem;"></i>
                                    </div>
                                    <div>
                                        <h5>Sentido de Pertenencia</h5>
                                        <p>Forma parte de una comunidad que valora la curiosidad y el aprendizaje</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Community Section -->
    <section id="community" class="section-padding" style="background: var(--bg-light);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="section-title" data-aos="fade-up">Nuestra Comunidad</h2>
                    <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                        Lo que dicen nuestros exploradores
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="community-objective mb-5" data-aos="fade-up">
                        <div class="text-center">
                            <h3 class="mb-4">{{ $landing->objetivo }}</h3>
                            <p class="lead">{{ $landing->descripcion_objetivo }}</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="testimonial-card">
                                <div class="testimonial-avatar">
                                    MR
                                </div>
                                <h5>María Rodríguez</h5>
                                <p class="text-muted mb-3">Exploradora Cultural</p>
                                <p><em>Encontré mi tribu aquí. Las rutas históricas que hemos descubierto juntos han enriquecido mis viajes de manera increíble.</em></p>
                                <div class="stars">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="testimonial-card">
                                <div class="testimonial-avatar">
                                    CL
                                </div>
                                <h5>Carlos López</h5>
                                <p class="text-muted mb-3">Historiador Amateur</p>
                                <p><em>El contenido exclusivo y los debates en los foros han ampliado mis conocimientos más de lo que imaginé posible.</em></p>
                                <div class="stars">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="testimonial-card">
                                <div class="testimonial-avatar">
                                    AP
                                </div>
                                <h5>Ana Pérez</h5>
                                <p class="text-muted mb-3">Fotógrafa de Viajes</p>
                                <p><em>Los desafíos temáticos me inspiraron a documentar historias increíbles. Mi portfolio creció exponencialmente.</em></p>
                                <div class="stars">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="section-title" data-aos="fade-up">Galería de Aventuras</h2>
                    <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                        Momentos capturados en nuestras exploraciones
                    </p>
                </div>
            </div>
            <div class="row">
                @if($landing->media && $landing->media->count() > 0)
                    @foreach($landing->media as $index => $media)
                        <div class="col-lg-{{ $index == 0 ? '8' : '4' }} col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <div class="gallery-item">
                                <img src="{{ asset('storage/' . $media->url) }}" alt="{{ $media->descripcion ?? 'Imagen de ' . $empresa->nombre }}">
                                <div class="gallery-overlay">
                                    <span>{{ $media->descripcion ?? 'Aventura ' . ($index + 1) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    <!-- Imágenes adicionales con el logo si hay espacio -->
                    @for($i = $landing->media->count(); $i < 6; $i++)
                        <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                            <div class="gallery-item">
                                <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}">
                                <div class="gallery-overlay">
                                    <span>Explora con {{ $empresa->nombre }}</span>
                                </div>
                            </div>
                        </div>
                    @endfor
                @else
                    <!-- Si no hay media, mostrar el logo en múltiples posiciones -->
                    @for($i = 0; $i < 6; $i++)
                        <div class="col-lg-{{ $i == 0 ? '8' : '4' }} col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                            <div class="gallery-item">
                                <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}">
                                <div class="gallery-overlay">
                                    <span>{{ $empresa->nombre }} - Aventura {{ $i + 1 }}</span>
                                </div>
                            </div>
                        </div>
                    @endfor
                @endif
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section-padding contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="section-title" data-aos="fade-up">Contáctanos</h2>
                    <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                        ¿Listo para comenzar tu aventura? ¡Hablemos!
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h5>Email</h5>
                        <p class="mb-0">{{ $empresa->email }}</p>
                        <a href="mailto:{{ $empresa->email }}" class="btn btn-primary-custom btn-sm mt-3">
                            Enviar Email
                        </a>
                    </div>
                </div>
                
                @if($empresa->movil)
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h5>Teléfono</h5>
                        <p class="mb-0">{{ $empresa->movil }}</p>
                        <a href="tel:{{ $empresa->movil }}" class="btn btn-primary-custom btn-sm mt-3">
                            Llamar Ahora
                        </a>
                    </div>
                </div>
                @endif
                
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <h5>WhatsApp</h5>
                        <p class="mb-0">{{ $empresa->whatsapp }}</p>
                        <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $empresa->whatsapp) }}" target="_blank" class="btn btn-primary-custom btn-sm mt-3">
                            Chat Directo
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-12 mt-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h5>Ubicación</h5>
                        <p class="mb-0">{{ $empresa->direccion }}</p>
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
                    <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}" class="footer-logo">
                    <p class="mt-3">{{ $landing->descripcion }}</p>
                    <div class="social-links">
                        @if($empresa->facebook)
                            <a href="{{ $empresa->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if($empresa->instagram)
                            <a href="{{ $empresa->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if($empresa->twitter)
                            <a href="{{ $empresa->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a>
                        @endif
                        @if($empresa->linkedin)
                            <a href="{{ $empresa->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        @endif
                        @if($empresa->youtube)
                            <a href="{{ $empresa->youtube }}" target="_blank"><i class="fab fa-youtube"></i></a>
                        @endif
                        @if($empresa->tiktok)
                            <a href="{{ $empresa->tiktok }}" target="_blank"><i class="fab fa-tiktok"></i></a>
                        @endif
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <h5 class="mb-3">Enlaces Rápidos</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="#home">Inicio</a></li>
                        <li><a href="#about">Acerca de</a></li>
                        <li><a href="#community">Comunidad</a></li>
                        <li><a href="#gallery">Galería</a></li>
                        <li><a href="#contact">Contacto</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <h5 class="mb-3">Información Legal</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalTerminos">Términos y Condiciones</a></li>
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalPrivacidad">Política de Privacidad</a></li>
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalCookies">Política de Cookies</a></li>
                    </ul>
                    
                    <div class="mt-4">
                        <h6>Contacto</h6>
                        <p class="mb-1">{{ $empresa->email }}</p>
                        <p class="mb-0">{{ $empresa->direccion }}</p>
                    </div>
                </div>
            </div>
            
            <hr class="my-4" style="border-color: #444;">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; {{ date('Y') }} {{ $empresa->nombre }}. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">Creado con ❤️ para exploradores modernos</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float Button -->
    <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $empresa->whatsapp) }}" target="_blank" class="whatsapp-float">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Modales Legales -->
    
    <!-- Modal Términos -->
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

    <!-- Modal Política de Privacidad -->
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

    <!-- Modal Política de Cookies -->
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
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                navbar.style.boxShadow = '0 2px 30px rgba(0,0,0,0.15)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
            }
        });

        // Smooth scrolling for navigation links
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

        // Gallery lightbox effect (simple version)
        document.querySelectorAll('.gallery-item').forEach(item => {
            item.addEventListener('click', function() {
                const img = this.querySelector('img');
                if (img) {
                    // Create a simple modal effect
                    const overlay = document.createElement('div');
                    overlay.className = 'position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center';
                    overlay.style.backgroundColor = 'rgba(0,0,0,0.9)';
                    overlay.style.zIndex = '9999';
                    overlay.style.cursor = 'pointer';
                    
                    const modalImg = document.createElement('img');
                    modalImg.src = img.src;
                    modalImg.alt = img.alt;
                    modalImg.className = 'img-fluid';
                    modalImg.style.maxWidth = '90%';
                    modalImg.style.maxHeight = '90%';
                    modalImg.style.objectFit = 'contain';
                    
                    overlay.appendChild(modalImg);
                    document.body.appendChild(overlay);
                    
                    overlay.addEventListener('click', function() {
                        document.body.removeChild(overlay);
                    });
                }
            });
        });

        // Add loading animation to buttons
        document.querySelectorAll('.btn-primary-custom').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (this.href && this.href.includes('wa.me')) {
                    // Don't prevent WhatsApp links
                    return;
                }
                
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Conectando...';
                this.disabled = true;
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 2000);
            });
        });

        // Add parallax effect to hero section
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const hero = document.querySelector('.hero-section');
            if (hero) {
                hero.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });

        // Counter animation for statistics (if needed)
        function animateCounter(element, target, duration = 2000) {
            let start = 0;
            const increment = target / (duration / 16);
            
            const timer = setInterval(function() {
                start += increment;
                element.textContent = Math.floor(start);
                
                if (start >= target) {
                    element.textContent = target;
                    clearInterval(timer);
                }
            }, 16);
        }

        // Intersection Observer for counters
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target.querySelector('.counter');
                    if (counter && !counter.classList.contains('animated')) {
                        const target = parseInt(counter.dataset.target);
                        animateCounter(counter, target);
                        counter.classList.add('animated');
                    }
                }
            });
        });

        // Observe counter elements
        document.querySelectorAll('.counter-section').forEach(section => {
            observer.observe(section);
        });
    </script>
</body>
</html>
