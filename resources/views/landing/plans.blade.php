@extends('layouts.app')

@section('title', 'Planes y Precios – Arriendo o compra + Prueba gratis 15 días')
@section('description', 'Consigue tu página web sin complicaciones: arriendo desde $45.000 COP/trimestre o compra con dominio y hosting incluidos (1er año). Incluye 15 días de prueba gratuita.')

@push('styles')
<style>
    .plans-hero {
        background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-gold) 100%);
        padding: 8rem 0 4rem;
        color: white;
        text-align: center;
    }

    .plans-hero h1 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }

    .plans-hero p {
        font-size: 1.3rem;
        opacity: 0.9;
    }

    .plans-content {
        padding: 5rem 0;
        background: #f8f9fa;
    }

    /* Estilos para la sección de servicios */
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
<!-- Plans Hero -->
<section class="plans-hero">
    <div class="container">
    <h1>¿Qué plan te conviene hoy?</h1>
    <p>Arriendo para empezar sin grandes costos o compra con <strong>dominio y hosting incluidos (1er año)</strong>. Incluye <strong>15 días de prueba gratuita</strong>.</p>
    </div>
</section>

<!-- Plans Content -->
<section class="plans-content">
    <div class="container">
        <!-- Plans Grid Component -->
        @include('components.plans-grid')
    </div>
</section>

<!-- Services Content -->
<section class="services-content" id="servicios">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 2rem; color: #333;">
                    Nuestros <span style="color: var(--primary-gold);">Servicios</span>
                </h2>
                <p style="font-size: 1.2rem; color: var(--medium-gray);">
                    Soluciones digitales que te permiten arrancar de forma económica y crecer con una presencia online profesional.
                </p>
            </div>
        </div>

        <!-- Diseño Responsive -->
        <div class="cards-grid">
        <div class="service-detail-card">
            <div class="service-header">
                <div class="service-icon-large">
                    <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <div class="service-info">
                    <h3>Diseño Responsive</h3>
                    <p class="service-subtitle">Tu página accesible en cualquier dispositivo</p>
                </div>
            </div>
            <p class="service-description">
                El diseño adaptado a móviles asegura que más clientes puedan encontrarte y navegar sin problemas. Todas nuestras páginas están optimizadas para que la experiencia del usuario sea fluida y convierta visitas en oportunidades.
            </p>
            <ul class="service-features">
                <li><i class="fas fa-check"></i>Diseño optimizado para móvil</li>
                <li><i class="fas fa-check"></i>Interfaz intuitiva y moderna</li>
                <li><i class="fas fa-check"></i>Navegación fluida en todos los dispositivos</li>
                <li><i class="fas fa-check"></i>Cargas rápidas y estables</li>
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
                    <h3>Visibilidad en Google</h3>
                    <p class="service-subtitle">Haz que te encuentren fácilmente</p>
                </div>
            </div>
            <p class="service-description">
                Una web estructurada y con contenido optimizado mejora tu presencia en buscadores. Incluimos prácticas de SEO básico para que empieces a aparecer en búsquedas locales y conectes con clientes interesados en tus servicios.
            </p>
            <ul class="service-features">
                <li><i class="fas fa-check"></i>Optimización de palabras clave</li>
                <li><i class="fas fa-check"></i>Meta tags correctos</li>
                <li><i class="fas fa-check"></i>Estructura amigable para buscadores</li>
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
                    <h3>Seguridad y Confianza</h3>
                    <p class="service-subtitle">Protección de tu negocio y clientes</p>
                </div>
            </div>
            <p class="service-description">
                Todos los sitios cuentan con certificado SSL y respaldo constante. Así aseguras que la información esté protegida y transmites confianza a tus visitantes.
            </p>
            <ul class="service-features">
                <li><i class="fas fa-check"></i>Certificado SSL activo</li>
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
                    <h3>Velocidad y Rendimiento</h3>
                    <p class="service-subtitle">Menos abandonos, más resultados</p>
                </div>
            </div>
            <p class="service-description">
                Optimizamos tu página para que cargue en segundos, mejorando la experiencia de navegación y el posicionamiento en buscadores. Esto se traduce en más conversiones y menos clientes perdidos.
            </p>
            <ul class="service-features">
                <li><i class="fas fa-check"></i>Optimización de imágenes</li>
                <li><i class="fas fa-check"></i>Caché inteligente</li>
                <li><i class="fas fa-check"></i>Uso de CDN</li>
                <li><i class="fas fa-check"></i>Compresión de archivos</li>
            </ul>
        </div>

        <!-- Acompañamiento -->
        <div class="service-detail-card">
            <div class="service-header">
                <div class="service-icon-large">
                    <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB">
                    <i class="fas fa-headset"></i>
                </div>
                <div class="service-info">
                    <h3>Acompañamiento Estratégico</h3>
                    <p class="service-subtitle">No solo soporte, sino crecimiento</p>
                </div>
            </div>
            <p class="service-description">
                Te apoyamos más allá de lo técnico: revisamos métricas, ajustamos detalles y sugerimos mejoras para que tu sitio se convierta en una herramienta de ventas efectiva desde el primer día.
            </p>
            <ul class="service-features">
                <li><i class="fas fa-check"></i>Monitoreo de tráfico y rendimiento</li>
                <li><i class="fas fa-check"></i>Sugerencias de optimización periódicas</li>
                <li><i class="fas fa-check"></i>Asesoría estratégica digital</li>
                <li><i class="fas fa-check"></i>Mejoras basadas en resultados</li>
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
                    <p class="service-subtitle">Una imagen que vende</p>
                </div>
            </div>
            <p class="service-description">
                Adaptamos la web a tu identidad de marca, transmitiendo confianza y profesionalismo. Una presentación visual coherente es clave para destacar frente a la competencia.
            </p>
            <ul class="service-features">
                <li><i class="fas fa-check"></i>Diseño adaptado a tu marca</li>
                <li><i class="fas fa-check"></i>Identidad visual coherente</li>
                <li><i class="fas fa-check"></i>Aspecto profesional y atractivo</li>
                <li><i class="fas fa-check"></i>Diferenciación en tu sector</li>
            </ul>
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