@extends('layouts.app')

@section('title', 'Tu página web fácil y rápida – Arriendo o compra con prueba gratis 15 días')
@section('description', 'Consigue tu página web sin complicaciones: arriendo desde $45.000 COP trimestrales o compra con dominio y hosting incluidos (1er año). Prueba gratuita de 15 días, diseño moderno y enfoque en ventas.')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/contact-form.css') }}">
<style>
    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-gold) 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        padding-right: 2rem;
    }

    .hero-title {
        font-size: 4rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        line-height: 1.1;
        word-wrap: break-word;
        hyphens: auto;
    }

    .hero-title .highlight {
        color: var(--primary-gold);
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .hero-subtitle {
        font-size: 1.3rem;
        margin-bottom: 2rem;
        opacity: 0.95;
        font-weight: 400;
    }

    .hero-buttons {
        margin-top: 2rem;
    }

    .hero-buttons .btn {
        margin: 0.5rem;
        font-size: 1.1rem;
        padding: 15px 35px;
    }

    .hero-globe {
        position: absolute;
        right: 10%;
        top: 50%;
        transform: translateY(-50%);
        font-size: 15rem;
        opacity: 0.1;
        color: white;
    }

    /* Services Section */
    .services-section {
        padding: 5rem 0;
        background: var(--light-gray);
    }

    .section-title {
        font-size: 3rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 3rem;
        color: #333;
    }

    .section-title .highlight {
        color: var(--primary-gold);
    }

    .service-card {
        background: white;
        padding: 2.5rem 2rem;
        border-radius: 15px;
        text-align: center;
        height: 100%;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border-top: 4px solid var(--primary-red);
    }

    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }

    .service-icon {
        width: 80px;
        height: 80px;
        background: var(--primary-red);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: white;
        font-size: 1.8rem;
        position: relative;
        overflow: hidden;
    }

    .service-icon img {
        width: 25px;
        height: auto;
        filter: brightness(0) invert(1);
        position: absolute;
        top: 15%;
        left: 50%;
        transform: translateX(-50%);
        opacity: 0.3;
    }

    .service-icon i {
        position: relative;
        z-index: 2;
    }

    .service-title {
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #333;
    }

    .service-description {
        color: var(--medium-gray);
        line-height: 1.6;
    }

    /* Testimonials Section */
    .testimonials-section {
        padding: 5rem 0;
        background: white;
    }

    .testimonial-card {
        background: white;
        padding: 2.5rem;
        border-radius: 15px;
        height: 100%;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        border-left: 5px solid var(--primary-gold);
        position: relative;
    }

    .testimonial-stars {
        color: var(--primary-gold);
        font-size: 1.2rem;
        margin-bottom: 1rem;
    }

    .testimonial-text {
        font-style: italic;
        margin-bottom: 1.5rem;
        color: #555;
        font-size: 1.1rem;
        line-height: 1.6;
    }

    .testimonial-author {
        font-weight: 600;
        color: var(--primary-red);
        margin-bottom: 0.5rem;
    }

    .testimonial-position {
        color: var(--medium-gray);
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .testimonial-location {
        color: var(--medium-gray);
        font-size: 0.9rem;
    }

    .testimonial-location i {
        color: var(--primary-gold);
        margin-right: 5px;
    }

    /* Contact Section */
    .contact-section {
        padding: 5rem 0;
        background: var(--dark-bg);
        color: white;
    }

    .contact-title {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 600;
        margin-bottom: 3rem;
        color: white;
    }

    /* Responsive Design */
    
    /* For medium-large screens (1024px - 1400px) */
    @media (max-width: 1400px) and (min-width: 1025px) {
        .hero-content {
            padding-right: 3rem;
        }
        
        .hero-title {
            font-size: 3.2rem;
            line-height: 1.2;
            margin-bottom: 1.2rem;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
        }
        
        .hero-globe {
            font-size: 12rem;
            right: 5%;
        }
        
        .hero-buttons .btn {
            font-size: 1rem;
            padding: 12px 28px;
        }
        
        .container {
            max-width: 1200px;
        }
    }
    
    /* For medium screens (768px - 1024px) */
    @media (max-width: 1024px) and (min-width: 769px) {
        .hero-content {
            padding-right: 2rem;
        }
        
        .hero-title {
            font-size: 2.8rem;
            line-height: 1.3;
            margin-bottom: 1rem;
        }
        
        .hero-subtitle {
            font-size: 1.1rem;
            line-height: 1.4;
            margin-bottom: 1.3rem;
        }
        
        .hero-globe {
            font-size: 10rem;
            right: 2%;
        }
        
        .hero-buttons .btn {
            font-size: 0.95rem;
            padding: 10px 25px;
        }
        
        .col-lg-8 {
            flex: 0 0 70%;
            max-width: 70%;
        }
        
        .col-lg-4 {
            flex: 0 0 30%;
            max-width: 30%;
        }
    }
    
    /* For small screens (mobile) */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 1.1rem;
            line-height: 1.4;
        }
        
        .hero-globe {
            display: none;
        }
        
        .section-title {
            font-size: 2rem;
        }
        
        .hero-buttons .btn {
            font-size: 0.9rem;
            padding: 10px 20px;
            margin: 0.3rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section id="inicio" class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="hero-content">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB Páginas Web" style="height: 60px; width: auto; margin-right: 20px;">
                    </div>
                    <h1 class="hero-title">
                        ¿Aún no tienes tu <span class="highlight">página web profesional</span>?
                    </h1>
                    <p class="hero-subtitle">
                        Lánzate al mundo digital desde solo <strong>$45.000 COP/trimestre</strong> o adquiere tu sitio con <strong>dominio y hosting gratis el primer año</strong>.  
                        Empieza ahora con <strong>15 días de prueba gratuita</strong>.
                    </p>

                    <div class="hero-buttons">
                        <a href="{{ route('register') }}" class="btn btn-primary-custom">
                            <i class="fas fa-rocket me-2"></i>Empieza tu prueba gratis (15 días)
                        </a>
                        <a href="{{ route('plans') }}" class="btn btn-outline-custom">
                            Ver Planes y Precios
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 position-relative">
                <i class="fas fa-globe hero-globe"></i>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="servicios" class="services-section">
    <div class="container">
        <h2 class="section-title">
            Por qué tu negocio necesita una <span class="highlight">página web</span>
        </h2>
        
        <div class="row g-4">
            <!-- Presencia 24/7 -->
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="service-title">Presencia 24/7</h3>
                    <p class="service-description">
                        Una web trabaja por ti todo el día: atrae clientes, muestra servicios y cierra oportunidades aunque no estés disponible.
                    </p>
                </div>
            </div>

            <!-- Confianza y Seguridad -->
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="service-title">Confianza y Seguridad</h3>
                    <p class="service-description">
                        Con SSL, copias de seguridad y buenas prácticas, protegemos tu reputación online para que tus clientes se sientan seguros al comprar o pedir información.
                    </p>
                </div>
            </div>

            <!-- Genera Clientes -->
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <h3 class="service-title">Diseñada para convertir</h3>
                    <p class="service-description">
                        Estructuramos páginas con foco en conversiones: formularios visibles, llamadas a la acción claras y recorrido pensado para vender.
                    </p>
                </div>
            </div>

            <!-- Visibilidad en Google -->
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="service-title">Más visibilidad en Google</h3>
                    <p class="service-description">
                        Optimizamos estructura y contenido para que te encuentren cuando más importa: consultas locales y palabras clave relevantes para tu sector.
                    </p>
                </div>
            </div>

            <!-- Velocidad y Rendimiento -->
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3 class="service-title">Carga rápida y rendimiento</h3>
                    <p class="service-description">
                        Sitios ligeros y optimizados que reducen abandonos, mejoran la experiencia y ayudan al posicionamiento.
                    </p>
                </div>
            </div>

            <!-- Soporte y crecimiento -->
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="service-title">Soporte cercano y evolución</h3>
                    <p class="service-description">
                        Te acompañamos desde la puesta en marcha y ofrecemos ajustes, analítica y mejoras continuas para que la web siga aportando valor.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Plans Section -->
<section id="planes" class="plans-content">
    <div class="container">
        <h2 class="section-title">
            Planes pensados para <span class="highlight">crecer</span>
        </h2>
        
        <!-- Plans Grid Component -->
        @include('components.plans-grid')
    </div>
</section>

<!-- Testimonials Section -->
<section id="testimonios" class="testimonials-section">
    <div class="container">
        <h2 class="section-title">
            Lo que dicen <span class="highlight">nuestros clientes</span>
        </h2>
        
        <div class="row g-4">
            <!-- Testimonio 1 -->
            <!-- Testimonio Real 1 - Abogada -->
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">
                        "Mi sitio web me ha permitido posicionarme como abogada. Los clientes me encuentran fácilmente y pueden ver mi experiencia y casos de éxito."
                    </p>
                    <div class="testimonial-author">Katherine Rodríguez</div>
                    <div class="testimonial-position">Abogada Independiente</div>
                    <div class="testimonial-location"><i class="fas fa-map-marker-alt"></i>Colombia</div>
                </div>
            </div>

            <!-- Testimonio Real 2 - Spa -->
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">
                        "Con nuestro sitio web hemos automatizado las citas y nuestros clientes pueden conocer todos nuestros tratamientos faciales y relajantes. Ha sido clave para el crecimiento del spa."
                    </p>
                    <div class="testimonial-author">Dann Luxury Spa</div>
                    <div class="testimonial-position">Centro de Belleza y Relajación</div>
                    <div class="testimonial-location"><i class="fas fa-map-marker-alt"></i>Colombia</div>
                </div>
            </div>
            
            <!-- Testimonio 3 -->
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">
                        "Empezamos con una Landing y después pasamos al plan Arriendo para escalar. La migración fue sencilla y el soporte nos ayudó a ajustar la web para aumentar la captación de clientes."
                    </p>
                    <div class="testimonial-author">Ana López</div>
                    <div class="testimonial-position">Directora de Desarrollo, InnovaGroup</div>
                    <div class="testimonial-location">
                        <i class="fas fa-map-marker-alt"></i>Colombia
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contacto" class="contact-section">
    <div class="container">
        <h2 class="contact-title">
            ¿Listo para potenciar tu negocio?
        </h2>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @include('components.contact-form')
            </div>
        </div>
    </div>
</section>
@endsection