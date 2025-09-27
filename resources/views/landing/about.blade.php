@extends('layouts.app')

@section('title', 'Acerca de BBB – Tu web fácil: arriendo o compra + prueba gratis')
@section('description', 'Ayudamos a emprendedores y pymes a conseguir su página web sin complicaciones: arriendo accesible o compra con dominio y hosting (1er año) e incluye prueba gratuita de 15 días.')

@push('styles')
<style>
    .about-hero {
        background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-gold) 100%);
        padding: 8rem 0 4rem;
        color: white;
        text-align: center;
    }

    .about-hero h1 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }

    .about-hero p {
        font-size: 1.3rem;
        opacity: 0.9;
    }

    .about-content {
        padding: 5rem 0;
    }

    .about-section {
        margin-bottom: 4rem;
    }

    .about-section h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 2rem;
    }

    .about-section h2 .highlight {
        color: var(--primary-gold);
    }

    .about-text {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--medium-gray);
        margin-bottom: 2rem;
        text-align: justify;
        text-justify: inter-word;
    }

    .stats-section {
        background: var(--light-gray);
        padding: 4rem 0;
    }

    .stat-card {
        text-align: center;
        padding: 2rem;
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 800;
        color: var(--primary-red);
        display: block;
    }

    .stat-label {
        font-size: 1.1rem;
        color: var(--medium-gray);
        font-weight: 500;
    }

    .values-section {
        padding: 5rem 0;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 3rem;
        color: #333;
    }

    .section-title .highlight {
        color: var(--primary-gold);
    }

    .value-card {
        background: white;
        padding: 2.5rem;
        border-radius: 15px;
        text-align: center;
        height: 100%;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        border-top: 4px solid var(--primary-gold);
        margin-bottom: 2rem;
    }

    .value-icon {
        width: 80px;
        height: 80px;
        background: var(--primary-gold);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: var(--dark-bg);
        font-size: 1.8rem;
        position: relative;
        overflow: hidden;
    }

    .value-icon img {
        width: 25px;
        height: auto;
        filter: brightness(0) saturate(100%) invert(27%) sepia(51%) saturate(2878%) hue-rotate(190deg) brightness(79%) contrast(87%);
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0.3;
    }

    .value-title {
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #333;
    }

    .value-description {
        color: var(--medium-gray);
        line-height: 1.6;
        text-align: justify;
        text-justify: inter-word;
    }
</style>
@endpush

@section('content')
<!-- About Hero -->
<section class="about-hero">
    <div class="container">
    <h1>Acerca de Nosotros</h1>
    <p>Estamos aquí para ayudar a comerciantes y emprendedores a tener un espacio profesional en Internet: desde una <strong>landing rápida</strong> para campañas hasta sitios completos en <strong>arriendo</strong>. Prueba gratis disponible por 15 días.</p>
    </div>
</section>

<!-- About Content -->
<section class="about-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="about-section">
                    <h2>Nuestra <span class="highlight">Misión</span></h2>
                    <p class="about-text">
                        En BBB trabajamos para que comerciantes y emprendedores tengan un espacio en Internet que les permita vender y crecer. Entendemos las limitaciones de tiempo y presupuesto, por eso ofrecemos opciones prácticas: desde una <strong>landing</strong> para lanzar campañas inmediatas hasta el <strong>plan Arriendo</strong> para operar sin inversión inicial.
                    </p>
                    <p class="about-text">
                        Nuestro objetivo es claro: facilitar el acceso digital con sitios que cargan rápido, funcionan perfecto en móviles y están optimizados para convertir visitantes en clientes reales.
                    </p>
                </div>

                <div class="about-section">
                    <h2>¿Por qué <span class="highlight">elegirnos?</span></h2>
                    <p class="about-text">
                        Llevamos años acompañando a pequeñas empresas y emprendedores. Conocemos las mejores prácticas para convertir visitas en clientes y adaptamos cada proyecto a la realidad del comercio local.
                    </p>
                    <p class="about-text">
                        Nos encargamos de todo el proceso: diseño enfocado en ventas, configuración de la <strong>landing</strong>, SEO básico, seguridad y soporte continuo. Ofrecemos onboarding rápido para que puedas empezar a recibir contactos desde el primer día.
                    </p>

                    <div class="about-section">
                        <h2>Planes pensados para emprendedores</h2>
                        <p class="about-text">
                            <strong>Prueba gratuita (15 días):</strong> Lanza una landing o un sitio básico sin costo para validar tu idea y medir resultados. Ideal para campañas puntuales o para probar nuestra plataforma.
                        </p>
                        <p class="about-text">
                            <strong>Plan Landing:</strong> Configuración express para campañas publicitarias o promociones —entregamos una página optimizada para conversiones en menos de 5 días y te ayudamos a medir resultados.
                        </p>
                        <p class="about-text">
                            <strong>Plan Arriendo:</strong> Si prefieres empezar sin una inversión grande, nuestro plan Arriendo te permite tener un sitio completo, con soporte y actualizaciones periódicas.
                        </p>
                        <p class="about-text">
                            Si no sabes por dónde empezar, nuestro equipo te asesora para elegir la mejor opción según tu negocio y objetivos.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <span class="stat-number">80+</span>
                    <span class="stat-label">Webs Entregadas</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <span class="stat-number">60+</span>
                    <span class="stat-label">Clientes Atendidos</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <span class="stat-number">98%</span>
                    <span class="stat-label">Clientes Satisfechos</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <span class="stat-number">24/7</span>
                    <span class="stat-label">Soporte Técnico</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="values-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="section-title">Nuestros <span class="highlight">Valores</span></h2>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="value-card">
                    <div class="value-icon">
                        <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="value-title">Pasión</h3>
                    <p class="value-description">
                        Nos apasiona lo que hacemos y creemos firmemente en el poder transformador de nuestras soluciones para impulsar el éxito de nuestros clientes.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="value-card">
                    <div class="value-icon">
                        <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="value-title">Colaboración</h3>
                    <p class="value-description">
                        Creemos que el éxito se construye juntos. Trabajamos en estrecha colaboración con nuestros clientes para entender sus necesidades y superar sus expectativas.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="value-card">
                    <div class="value-icon">
                        <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="value-title">Excelencia</h3>
                    <p class="value-description">
                        La excelencia no es un acto, sino un hábito. Nos esforzamos constantemente por mejorar y ofrecer la mejor experiencia posible a nuestros usuarios.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section" style="background: var(--dark-bg); padding: 4rem 0; color: white; text-align: center;">
    <div class="container">
        <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">¿Listo para Impulsar tu Negocio?</h2>
        <p style="font-size: 1.2rem; margin-bottom: 2rem; opacity: 0.9;">
            Únete a cientos de empresas que ya están creciendo con BBB
        </p>
        <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg">
            <i class="fas fa-rocket me-2"></i>Comienza Hoy
        </a>
    </div>
</section>
@endsection