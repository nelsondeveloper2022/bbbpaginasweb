<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landing->titulo_principal ?? $empresa->nombre }} - En toda la geografía de la información</title>
    <meta name="description" content="{{ $landing->descripcion ?? 'Maparadio - Tu fuente de información confiable en Cartagena' }}">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . ($landing->logo_url ?? 'logo.png')) }}">

    <style>
        :root {
            --primary-color: {{ $landing->color_principal ?? '#007bff' }};
            --secondary-color: {{ $landing->color_secundario ?? '#ff0000' }};
            --font-family: {{ $landing->tipografia ?? 'Poppins' }}, sans-serif;
            --gradient-primary: linear-gradient(135deg, var(--primary-color), #0056b3);
            --gradient-secondary: linear-gradient(135deg, var(--secondary-color), #cc0000);
        }

        * {
            font-family: var(--font-family);
        }

        body {
            overflow-x: hidden;
        }

        .navbar {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98) !important;
            box-shadow: 0 2px 30px rgba(0, 0, 0, 0.15);
        }

        .navbar-brand img {
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover img {
            transform: scale(1.05);
        }

        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4);
        }

        .btn-secondary {
            background: var(--gradient-secondary);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 0, 0, 0.3);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 0, 0, 0.4);
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #0056b3 100%);
            min-height: 100vh;
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="rgba(255,255,255,0.1)" points="0,1000 1000,0 1000,1000"/></svg>');
            background-size: cover;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            margin-bottom: 1.5rem;
        }

        .hero-subtitle {
            font-size: 1.4rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            font-weight: 300;
        }

        .floating-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin: 2rem 0;
            transition: transform 0.3s ease;
        }

        .floating-card:hover {
            transform: translateY(-10px);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--gradient-primary);
            border-radius: 2px;
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin: 0 auto 1.5rem;
            transition: transform 0.3s ease;
        }

        .feature-icon:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin: 1rem 0;
            border-left: 5px solid var(--primary-color);
        }

        .gallery-item {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .gallery-item:hover {
            transform: scale(1.05);
        }

        .contact-info {
            background: var(--gradient-primary);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin: 1rem 0;
        }

        .social-links a {
            display: inline-block;
            width: 50px;
            height: 50px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 50px;
            margin: 0 10px;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
        }

        .footer {
            background: #1a1a1a;
            color: white;
            padding: 3rem 0 1rem;
        }

        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background: #25d366;
            color: white;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            animation: pulse 2s infinite;
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
        }

        .parallax {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#home">
                <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}" height="50" class="d-inline-block align-text-top">
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
                </ul>
                
                <div class="d-flex ms-3">
                    @if($empresa->whatsapp)
                        <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $empresa->whatsapp) }}" 
                           class="btn btn-primary" target="_blank">
                            <i class="bi bi-whatsapp"></i> WhatsApp
                        </a>
                    @else
                        <a href="mailto:{{ $empresa->email }}" class="btn btn-primary">
                            <i class="bi bi-envelope"></i> Contáctanos
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="hero-content">
                        <h1 class="hero-title">{{ $landing->titulo_principal ?? $empresa->nombre }}</h1>
                        <p class="hero-subtitle">
                            {{ $landing->subtitulo ?? 'En toda la geografía de la información' }}
                        </p>
                        <p class="text-white mb-4" style="font-size: 1.1rem;">
                            Descubre la emisora que conecta a Cartagena con información veraz, entretenimiento de calidad 
                            y contenido que realmente importa. Únete a nuestra comunidad y mantente siempre informado 
                            de lo que acontece en tu ciudad y región.
                        </p>
                        
                        <div class="d-flex flex-wrap gap-3">
                            @if($empresa->whatsapp)
                                <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $empresa->whatsapp) }}" 
                                   class="btn btn-secondary btn-lg" target="_blank">
                                    <i class="bi bi-whatsapp"></i> Suscríbete Ahora
                                </a>
                            @else
                                <a href="mailto:{{ $empresa->email }}" class="btn btn-secondary btn-lg">
                                    <i class="bi bi-envelope"></i> Suscríbete Ahora
                                </a>
                            @endif
                            
                            <a href="#about" class="btn btn-outline-light btn-lg">
                                <i class="bi bi-play-circle"></i> Escúchanos en Vivo
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="text-center">
                        @if($landing->media && $landing->media->count() > 0)
                            <img src="{{ asset('storage/' . $landing->media->first()->url) }}" 
                                 alt="{{ $empresa->nombre }}" class="img-fluid rounded-4 shadow-lg" 
                                 style="max-height: 400px; object-fit: cover;">
                        @else
                            <img src="{{ asset('storage/' . ($landing->logo_url ?? 'logo.png')) }}" 
                                 alt="{{ $empresa->nombre }}" class="img-fluid rounded-4 shadow-lg" 
                                 style="max-height: 400px; object-fit: contain;">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Sobre Nosotros</h2>
                    <p class="lead">Conectando a Cartagena con información de calidad</p>
                </div>
            </div>
            
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="floating-card">
                        <h3 class="h4 mb-3 text-primary">
                            <i class="bi bi-broadcast"></i> Nuestra Misión
                        </h3>
                        <p class="mb-4">
                            En Maparadio nos dedicamos a ser el puente de información más confiable entre 
                            los acontecimientos de Cartagena y nuestra audiencia. Nuestro compromiso es 
                            llevar contenido relevante, veraz y entretenido que enriquezca la vida de 
                            nuestra comunidad radial.
                        </p>
                        
                        <p class="mb-4">
                            Con una perspectiva amplia que abarca "toda la geografía de la información", 
                            nos especializamos en conectar a personas de 18 a 65 años que valoran el 
                            contenido radial de calidad y buscan mantenerse informados sobre su ciudad 
                            y región.
                        </p>
                        
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="text-primary">
                                    <i class="bi bi-people-fill" style="font-size: 2rem;"></i>
                                    <h5 class="mt-2">5K+</h5>
                                    <small>Oyentes</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-primary">
                                    <i class="bi bi-clock-fill" style="font-size: 2rem;"></i>
                                    <h5 class="mt-2">24/7</h5>
                                    <small>Al Aire</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-primary">
                                    <i class="bi bi-award-fill" style="font-size: 2rem;"></i>
                                    <h5 class="mt-2">100%</h5>
                                    <small>Confiable</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6" data-aos="fade-left">
                    @if($landing->media && $landing->media->count() > 1)
                        <div class="gallery-item">
                            <img src="{{ asset('storage/' . $landing->media->skip(1)->first()->url) }}" 
                                 alt="Maparadio Studio" class="img-fluid w-100" 
                                 style="height: 400px; object-fit: cover;">
                        </div>
                    @else
                        <div class="text-center p-5 bg-primary text-white rounded-4">
                            <i class="bi bi-radio" style="font-size: 5rem; opacity: 0.5;"></i>
                            <h3 class="mt-3">Maparadio</h3>
                            <p>En toda la geografía de la información</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Problems Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">¿Te Suena Familiar?</h2>
                    <p class="lead">Los desafíos que enfrentan los amantes de la radio hoy</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="floating-card text-center">
                        <div class="feature-icon bg-danger">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <h4>Información Poco Confiable</h4>
                        <p>
                            ¿Cansado de noticias sin verificar o contenido que no refleja la realidad 
                            de tu ciudad? La desinformación está en todas partes.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="floating-card text-center">
                        <div class="feature-icon bg-warning">
                            <i class="bi bi-broadcast-pin"></i>
                        </div>
                        <h4>Falta de Conexión Local</h4>
                        <p>
                            Muchas emisoras han perdido ese toque personal y local que realmente 
                            conecta con la comunidad cartagenera.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="floating-card text-center">
                        <div class="feature-icon bg-info">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <h4>Contenido Desactualizado</h4>
                        <p>
                            ¿Te ha pasado que cuando necesitas información importante sobre tu ciudad, 
                            no encuentras una fuente actualizada y confiable?
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">¿Por Qué Elegir Maparadio?</h2>
                    <p class="lead">Los beneficios que solo nosotros te podemos ofrecer</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6 mb-4" data-aos="fade-right">
                    <div class="floating-card">
                        <div class="row align-items-center">
                            <div class="col-3">
                                <div class="feature-icon">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                            </div>
                            <div class="col-9">
                                <h4>Información 100% Verificada</h4>
                                <p class="mb-0">
                                    Cada noticia, cada dato, cada información que compartimos pasa por 
                                    nuestro riguroso proceso de verificación. Tu confianza es nuestro 
                                    mayor tesoro.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4" data-aos="fade-left">
                    <div class="floating-card">
                        <div class="row align-items-center">
                            <div class="col-3">
                                <div class="feature-icon">
                                    <i class="bi bi-heart"></i>
                                </div>
                            </div>
                            <div class="col-9">
                                <h4>Conexión Genuina con Cartagena</h4>
                                <p class="mb-0">
                                    Conocemos cada rincón de nuestra ciudad. Hablamos tu mismo idioma 
                                    y entendemos lo que realmente te importa como cartagenero.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4" data-aos="fade-right" data-aos-delay="100">
                    <div class="floating-card">
                        <div class="row align-items-center">
                            <div class="col-3">
                                <div class="feature-icon">
                                    <i class="bi bi-lightning"></i>
                                </div>
                            </div>
                            <div class="col-9">
                                <h4>Actualización en Tiempo Real</h4>
                                <p class="mb-0">
                                    Mantente al día con lo que pasa en tu ciudad. Información fresca, 
                                    relevante y actualizada minuto a minuto.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4" data-aos="fade-left" data-aos-delay="100">
                    <div class="floating-card">
                        <div class="row align-items-center">
                            <div class="col-3">
                                <div class="feature-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                            </div>
                            <div class="col-9">
                                <h4>Comunidad Activa y Participativa</h4>
                                <p class="mb-0">
                                    Únete a miles de cartageneros que ya forman parte de nuestra familia. 
                                    Tu voz importa y queremos escucharla.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Community/Testimonials Section -->
    <section class="py-5" style="background: var(--gradient-primary);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title text-white">Lo Que Dice Nuestra Comunidad</h2>
                    <p class="lead text-white opacity-75">Testimonios reales de oyentes satisfechos</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-card">
                        <div class="mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="mb-3">
                            "Gracias a Maparadio estoy siempre informado de lo que pasa en Cartagena. 
                            Su información es confiable y me mantiene conectado con mi ciudad."
                        </p>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded-circle p-2 me-3">
                                <i class="bi bi-person-fill text-white"></i>
                            </div>
                            <div>
                                <strong>Carlos Mendoza</strong>
                                <small class="d-block text-muted">Comerciante - Getsemaní</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card">
                        <div class="mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="mb-3">
                            "Es mi emisora favorita. Me acompaña durante todo el día y siempre encuentro 
                            contenido interesante que realmente me conecta con mi comunidad."
                        </p>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded-circle p-2 me-3">
                                <i class="bi bi-person-fill text-white"></i>
                            </div>
                            <div>
                                <strong>María Elena Ruiz</strong>
                                <small class="d-block text-muted">Ama de casa - Bocagrande</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-card">
                        <div class="mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="mb-3">
                            "Por fin una emisora que entiende lo que necesitamos los cartageneros. 
                            Información local, veraz y contenido que realmente vale la pena escuchar."
                        </p>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded-circle p-2 me-3">
                                <i class="bi bi-person-fill text-white"></i>
                            </div>
                            <div>
                                <strong>Jorge Arrieta</strong>
                                <small class="d-block text-muted">Profesional - El Laguito</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Nuestra Galería</h2>
                    <p class="lead">Momentos que capturan la esencia de Maparadio</p>
                </div>
            </div>
            
            <div class="row">
                @if($landing->media && $landing->media->count() > 0)
                    @foreach($landing->media->take(6) as $index => $media)
                        <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                            <div class="gallery-item">
                                <img src="{{ asset('storage/' . $media->url) }}" 
                                     alt="Maparadio Gallery {{ $index + 1 }}" 
                                     class="img-fluid w-100" 
                                     style="height: 250px; object-fit: cover;"
                                     data-bs-toggle="modal" 
                                     data-bs-target="#galleryModal{{ $index }}">
                            </div>
                        </div>
                        
                        <!-- Gallery Modal -->
                        <div class="modal fade" id="galleryModal{{ $index }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Maparadio - Imagen {{ $index + 1 }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ asset('storage/' . $media->url) }}" 
                                             alt="Maparadio Gallery {{ $index + 1 }}" 
                                             class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    @for($i = 1; $i <= 6; $i++)
                        <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                            <div class="gallery-item">
                                <div class="d-flex align-items-center justify-content-center bg-primary text-white" 
                                     style="height: 250px;">
                                    <div class="text-center">
                                        <i class="bi bi-radio" style="font-size: 3rem; opacity: 0.5;"></i>
                                        <p class="mt-2 mb-0">Maparadio</p>
                                        <small>Imagen {{ $i }}</small>
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
    <section id="contact" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Contáctanos</h2>
                    <p class="lead">¿Listo para ser parte de nuestra comunidad?</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="row">
                        <div class="col-lg-12 mb-4" data-aos="fade-right">
                            <div class="contact-info">
                                <h4 class="mb-4">
                                    <i class="bi bi-geo-alt-fill"></i> Información de Contacto
                                </h4>
                                
                                <div class="mb-3">
                                    <strong><i class="bi bi-envelope-fill"></i> Email:</strong><br>
                                    <a href="mailto:{{ $empresa->email }}" class="text-white">
                                        {{ $empresa->email }}
                                    </a>
                                </div>
                                
                                @if($empresa->movil)
                                <div class="mb-3">
                                    <strong><i class="bi bi-telephone-fill"></i> Teléfono:</strong><br>
                                    <a href="tel:{{ $empresa->movil }}" class="text-white">
                                        {{ $empresa->movil }}
                                    </a>
                                </div>
                                @endif
                                
                                @if($empresa->direccion)
                                <div class="mb-3">
                                    <strong><i class="bi bi-house-fill"></i> Dirección:</strong><br>
                                    {{ $empresa->direccion }}
                                </div>
                                @endif
                                
                                @if($empresa->whatsapp)
                                <div class="mb-3">
                                    <strong><i class="bi bi-whatsapp"></i> WhatsApp:</strong><br>
                                    <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $empresa->whatsapp) }}" 
                                       class="text-white" target="_blank">
                                        {{ $empresa->whatsapp }}
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4" data-aos="fade-up">
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . ($landing->logo_url ?? 'logo.png')) }}" 
                             alt="{{ $empresa->nombre }}" height="60" class="mb-3">
                    </div>
                    <p class="mb-3">
                        {{ $empresa->nombre }} - En toda la geografía de la información. 
                        Tu fuente confiable de noticias e información en Cartagena.
                    </p>
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
                        @if($empresa->twitter)
                            <a href="{{ $empresa->twitter }}" target="_blank">
                                <i class="bi bi-twitter"></i>
                            </a>
                        @endif
                        @if($empresa->youtube)
                            <a href="{{ $empresa->youtube }}" target="_blank">
                                <i class="bi bi-youtube"></i>
                            </a>
                        @endif
                        @if($empresa->linkedin)
                            <a href="{{ $empresa->linkedin }}" target="_blank">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        @endif
                        @if($empresa->tiktok)
                            <a href="{{ $empresa->tiktok }}" target="_blank">
                                <i class="bi bi-tiktok"></i>
                            </a>
                        @endif
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <h5 class="mb-3">Enlaces Rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a href="#home" class="text-light text-decoration-none">Inicio</a></li>
                        <li><a href="#about" class="text-light text-decoration-none">Nosotros</a></li>
                        <li><a href="#benefits" class="text-light text-decoration-none">Beneficios</a></li>
                        <li><a href="#gallery" class="text-light text-decoration-none">Galería</a></li>
                        <li><a href="#contact" class="text-light text-decoration-none">Contacto</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <h5 class="mb-3">Información Legal</h5>
                    <ul class="list-unstyled">
                        @if($empresa->terminos_condiciones)
                            <li>
                                <a href="#" class="text-light text-decoration-none" 
                                   data-bs-toggle="modal" data-bs-target="#terminosModal">
                                    Términos y Condiciones
                                </a>
                            </li>
                        @endif
                        @if($empresa->politica_privacidad)
                            <li>
                                <a href="#" class="text-light text-decoration-none" 
                                   data-bs-toggle="modal" data-bs-target="#privacidadModal">
                                    Política de Privacidad
                                </a>
                            </li>
                        @endif
                        @if($empresa->politica_cookies)
                            <li>
                                <a href="#" class="text-light text-decoration-none" 
                                   data-bs-toggle="modal" data-bs-target="#cookiesModal">
                                    Política de Cookies
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            
            <hr class="my-4 bg-light">
            
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <p class="mb-0">&copy; {{ date('Y') }} {{ $empresa->nombre }}. Todos los derechos reservados.</p>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <p class="mb-0">Desarrollado con ❤️ para la comunidad cartagenera</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float Button -->
    @if($empresa->whatsapp)
        <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $empresa->whatsapp) }}?text=Hola, me interesa conocer más sobre Maparadio" 
           class="whatsapp-float" target="_blank" title="Contáctanos por WhatsApp">
            <i class="bi bi-whatsapp"></i>
        </a>
    @endif

    <!-- Legal Modals -->
    @if($empresa->terminos_condiciones)
        <div class="modal fade" id="terminosModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Términos y Condiciones</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                        {!! $empresa->terminos_condiciones !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($empresa->politica_privacidad)
        <div class="modal fade" id="privacidadModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Política de Privacidad</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                        {!! $empresa->politica_privacidad !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($empresa->politica_cookies)
        <div class="modal fade" id="cookiesModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Política de Cookies</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                        {!! $empresa->politica_cookies !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation JS -->
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
            const navbar = document.getElementById('mainNav');
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
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

        // Dynamic color application
        document.documentElement.style.setProperty('--primary-color', '{{ $landing->color_principal ?? "#007bff" }}');
        document.documentElement.style.setProperty('--secondary-color', '{{ $landing->color_secundario ?? "#ff0000" }}');

        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Animate buttons on hover
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Add floating animation to cards
            const cards = document.querySelectorAll('.floating-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.animation = `float 3s ease-in-out infinite ${index * 0.5}s`;
                }, index * 200);
            });
        });

        // CSS for floating animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-5px); }
            }
            
            .floating-card {
                transition: all 0.3s ease;
            }
            
            .floating-card:hover {
                transform: translateY(-10px) !important;
                box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15) !important;
            }
        `;
        document.head.appendChild(style);

        // Add loading animation
        window.addEventListener('load', function() {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease';
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });
    </script>
</body>
</html>
