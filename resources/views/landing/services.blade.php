@extends('layouts.app')

@section('title', 'Servicios fáciles: arriendo o compra + prueba gratis 15 días')
@section('description', 'Todo para conseguir tu página web sin complicaciones: arriendo o compra, dominio y hosting incluidos (según plan) y 15 días de prueba gratuita para empezar hoy.')

@push('styles')
<style>
    .services-hero {
        background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-gold) 100%);
        padding: 8rem 0 4rem;
        color: white;
        text-align: center;
    }

    .services-hero h1 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }

    .services-content {
        padding: 5rem 0;
    }

    .service-detail-card {
        background: white;
        padding: 3rem;
        border-radius: 15px;
        margin-bottom: 3rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-top: 5px solid var(--primary-red);
        transition: all 0.3s ease;
    }

    .service-detail-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .service-header {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
    }

    .service-icon-large {
        width: 100px;
        height: 100px;
        background: var(--primary-red);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
        margin-right: 2rem;
        position: relative;
        overflow: hidden;
    }

    .service-icon-large img {
        width: 40px;
        height: auto;
        filter: brightness(0) invert(1);
        position: absolute;
        top: 20%;
        left: 50%;
        transform: translateX(-50%);
        opacity: 0.2;
    }

    .service-info h3 {
        font-size: 2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .service-subtitle {
        color: var(--medium-gray);
        font-size: 1.1rem;
    }

    .service-description {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--medium-gray);
        margin-bottom: 2rem;
    }

    .service-features {
        list-style: none;
        padding: 0;
    }

    .service-features li {
        padding: 0.5rem 0;
        color: var(--medium-gray);
        display: flex;
        align-items: center;
    }

    .service-features li i {
        color: var(--primary-gold);
        margin-right: 1rem;
        width: 20px;
    }

    .process-section {
        background: var(--light-gray);
        padding: 5rem 0;
    }

    .process-step {
        text-align: center;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .process-number {
        width: 80px;
        height: 80px;
        background: var(--primary-gold);
        color: var(--dark-bg);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 800;
        margin: 0 auto 1.5rem;
    }

    .process-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
    }

    .process-description {
        color: var(--medium-gray);
        line-height: 1.6;
    }
</style>
@endpush

@section('content')
<!-- Services Hero -->
<section class="services-hero">
    <div class="container">
    <h1>¿Necesitas una web sin enredos?</h1>
    <p>Arriendo o compra, según te convenga. En algunos planes: dominio y hosting incluidos. Además, <strong>15 días de prueba</strong>.</p>
    </div>
</section>

<!-- Services Content -->
<section class="services-content">
    <div class="container">
        <!-- Diseño Responsive -->
        <div class="service-detail-card">
            <div class="service-header">
                <div class="service-icon-large">
                    <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <div class="service-info">
                    <h3>Diseño Responsive</h3>
                    <p class="service-subtitle">Se ve perfecto en móvil, tablet y computador</p>
                </div>
            </div>
            <p class="service-description">
                Creamos experiencias rápidas, claras y enfocadas en conversión. Tus clientes te encuentran, entienden y te contactan.
            </p>
            <ul class="service-features">
                <li><i class="fas fa-check"></i>Diseño móvil optimizado</li>
                <li><i class="fas fa-check"></i>Interfaz intuitiva y moderna</li>
                <li><i class="fas fa-check"></i>Navegación fluida en todos los dispositivos</li>
                <li><i class="fas fa-check"></i>Tiempos de carga rápidos</li>
            </ul>
        </div>

        <!-- SEO Optimizado -->
        <div class="service-detail-card">
            <div class="service-header">
                <div class="service-icon-large">
                    <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB">
                    <i class="fas fa-search"></i>
                </div>
                <div class="service-info">
                    <h3>SEO Optimizado</h3>
                    <p class="service-subtitle">Mejora tu posición en Google y atrae más clientes</p>
                </div>
            </div>
            <p class="service-description">
                Estructura SEO-friendly, etiquetas optimizadas y velocidad superior para posicionar mejor y convertir más.
            </p>
            <ul class="service-features">
                <li><i class="fas fa-check"></i>Optimización de palabras clave</li>
                <li><i class="fas fa-check"></i>Meta tags optimizados</li>
                <li><i class="fas fa-check"></i>Estructura SEO friendly</li>
                <li><i class="fas fa-check"></i>Sitemap automático</li>
            </ul>
        </div>

        <!-- Seguridad SSL -->
        <div class="service-detail-card">
            <div class="service-header">
                <div class="service-icon-large">
                    <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="service-info">
                    <h3>Seguridad SSL</h3>
                    <p class="service-subtitle">Confianza y protección para tus usuarios</p>
                </div>
            </div>
            <p class="service-description">
                SSL incluido y buenas prácticas de seguridad para que tus clientes naveguen tranquilos.
            </p>
            <ul class="service-features">
                <li><i class="fas fa-check"></i>Certificado SSL incluido</li>
                <li><i class="fas fa-check"></i>Encriptación de datos</li>
                <li><i class="fas fa-check"></i>Protección contra malware</li>
                <li><i class="fas fa-check"></i>Respaldos automáticos</li>
            </ul>
        </div>

        <!-- Carga Rápida -->
        <div class="service-detail-card">
            <div class="service-header">
                <div class="service-icon-large">
                    <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB">
                    <i class="fas fa-rocket"></i>
                </div>
                <div class="service-info">
                    <h3>Carga Rápida</h3>
                    <p class="service-subtitle">Velocidad pensada para conversiones</p>
                </div>
            </div>
            <p class="service-description">
                La rapidez mejora el SEO y reduce el abandono. Optimizamos imágenes, caché y recursos.
            </p>
            <ul class="service-features">
                <li><i class="fas fa-check"></i>Optimización de imágenes</li>
                <li><i class="fas fa-check"></i>Caché inteligente</li>
                <li><i class="fas fa-check"></i>CDN incluido</li>
                <li><i class="fas fa-check"></i>Compresión de archivos</li>
            </ul>
        </div>

        <!-- Soporte Personalizado -->
        <div class="service-detail-card">
            <div class="service-header">
                <div class="service-icon-large">
                    <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB">
                    <i class="fas fa-headset"></i>
                </div>
                <div class="service-info">
                    <h3>Soporte Personalizado</h3>
                    <p class="service-subtitle">Te acompañamos en cada etapa</p>
                </div>
            </div>
            <p class="service-description">
                WhatsApp, email y llamadas. Configuramos, optimizamos y resolvemos rápido.
            </p>
            <ul class="service-features">
                <li><i class="fas fa-check"></i>Soporte técnico 24/7</li>
                <li><i class="fas fa-check"></i>Atención personalizada</li>
                <li><i class="fas fa-check"></i>Actualizaciones incluidas</li>
                <li><i class="fas fa-check"></i>Capacitación y consultoría</li>
            </ul>
        </div>

        <!-- Diseño Personalizado -->
        <div class="service-detail-card">
            <div class="service-header">
                <div class="service-icon-large">
                    <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB">
                    <i class="fas fa-paint-brush"></i>
                </div>
                <div class="service-info">
                    <h3>Diseño Personalizado</h3>
                    <p class="service-subtitle">Tu marca, tu estilo</p>
                </div>
            </div>
            <p class="service-description">
                Nos adaptamos a tu identidad visual y objetivos de negocio para que destaques y vendas más.
            </p>
            <ul class="service-features">
                <li><i class="fas fa-check"></i>Diseño 100% personalizado</li>
                <li><i class="fas fa-check"></i>Identidad visual única</li>
                <li><i class="fas fa-check"></i>Adaptado a tu marca</li>
                <li><i class="fas fa-check"></i>Diferenciación competitiva</li>
            </ul>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="process-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 3rem; color: #333;">
                    Nuestro <span style="color: var(--primary-gold);">Proceso</span>
                </h2>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="process-step">
                    <div class="process-number">1</div>
                    <h4 class="process-title">Consulta Inicial</h4>
                    <p class="process-description">
                        Analizamos tus necesidades y objetivos para crear la estrategia perfecta
                    </p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="process-step">
                    <div class="process-number">2</div>
                    <h4 class="process-title">Planificación</h4>
                    <p class="process-description">
                        Diseñamos la estructura y funcionalidades de tu sitio web
                    </p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="process-step">
                    <div class="process-number">3</div>
                    <h4 class="process-title">Desarrollo</h4>
                    <p class="process-description">
                        Creamos tu sitio web con las mejores tecnologías
                    </p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="process-step">
                    <div class="process-number">4</div>
                    <h4 class="process-title">Lanzamiento</h4>
                    <p class="process-description">
                        Publicamos tu sitio y te acompañamos en el crecimiento
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section style="background: var(--dark-bg); padding: 4rem 0; color: white; text-align: center;">
    <div class="container">
        <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">¿Listo para comenzar?</h2>
        <p style="font-size: 1.2rem; margin-bottom: 2rem; opacity: 0.9;">
            Contactanos hoy y hagamos realidad tu proyecto web
        </p>
        <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg">
            <i class="fas fa-rocket me-2"></i>Comenzar Ahora
        </a>
    </div>
</section>
@endsection