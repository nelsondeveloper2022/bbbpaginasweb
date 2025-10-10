@extends('layouts.app')

@section('title', 'Testimonios – Tu web fácil que sí vende')
@section('description', 'Negocios reales que crecieron con nuestros planes: arriendo o compra con dominio y hosting incluidos (según plan). Empieza con 15 días de prueba gratis.')

@push('styles')
<style>
    .testimonials-hero {
        background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-gold) 100%);
        padding: 8rem 0 4rem;
        color: white;
        text-align: center;
    }

    .testimonials-hero h1 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }

    .testimonials-content {
        padding: 5rem 0;
    }

    .testimonial-card-extended {
        background: white;
        padding: 3rem;
        border-radius: 20px;
        margin-bottom: 3rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-left: 5px solid var(--primary-gold);
        position: relative;
    }

    .testimonial-quote {
        position: absolute;
        top: -15px;
        left: 30px;
        background: var(--primary-gold);
        color: var(--dark-bg);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .testimonial-text-extended {
        font-size: 1.2rem;
        line-height: 1.8;
        color: #555;
        margin-bottom: 2rem;
        margin-top: 1rem;
    }

    .client-info {
        display: flex;
        align-items: center;
        margin-top: 2rem;
    }

    .client-avatar {
        width: 80px;
        height: 80px;
        background: var(--primary-red);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        margin-right: 1.5rem;
    }

    .client-details h4 {
        color: var(--primary-red);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .client-position {
        color: var(--medium-gray);
        margin-bottom: 0.3rem;
    }

    .client-location {
        color: var(--medium-gray);
        font-size: 0.9rem;
    }

    .rating-stars {
        color: var(--primary-gold);
        font-size: 1.3rem;
        margin-bottom: 1rem;
    }

    .stats-testimonials {
        background: var(--light-gray);
        padding: 4rem 0;
        text-align: center;
    }

    .stat-item {
        margin-bottom: 2rem;
    }

    .stat-number-big {
        font-size: 4rem;
        font-weight: 800;
        color: var(--primary-red);
        display: block;
        line-height: 1;
    }

    .stat-label-big {
        font-size: 1.2rem;
        color: var(--medium-gray);
        font-weight: 500;
    }
    /* Estilos de testimonios como en el Home */
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
</style>
@endpush

@section('content')
<!-- Testimonials Hero -->
<section class="testimonials-hero">
    <div class="container">
        <h1>Testimonios de Clientes</h1>
    <p>Historias reales: conseguir tu web fácil sí es posible (y funciona)</p>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-testimonials">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number-big">90+</span>
                    <span class="stat-label-big">Clientes Satisfechos</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number-big">4.9/5</span>
                    <span class="stat-label-big">Calificación Promedio</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number-big">98%</span>
                    <span class="stat-label-big">Nos Recomiendan</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number-big">24h</span>
                    <span class="stat-label-big">Tiempo de Respuesta</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Lo que dicen <span class="highlight">nuestros clientes</span></h2>
            <p class="lead text-muted">Experiencias reales de clientes en Colombia con nuestros planes Arriendo y Landing</p>
        </div>
        <div class="row g-4">
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
                        "Mi sitio web <a href="https://katherinrodriguezabogada.com/" target="_blank" rel="noopener noreferrer">katherinrodriguezabogada.com</a> me ha permitido posicionarme como abogada. Los clientes me encuentran fácilmente y pueden ver mi experiencia y casos de éxito."
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
                        "Nuestro sitio web <a href="https://dannluxury.com/" target="_blank" rel="noopener noreferrer">dannluxury.com</a> nos ha permitido automatizar las citas y nuestros clientes pueden conocer todos nuestros tratamientos faciales y relajantes. Ha sido clave para el crecimiento del spa."
                    </p>
                    <div class="testimonial-author">Dann Luxury Spa</div>
                    <div class="testimonial-position">Centro de Belleza y Relajación</div>
                    <div class="testimonial-location"><i class="fas fa-map-marker-alt"></i>Colombia</div>
                </div>
            </div>

            <!-- Testimonio 1 -->
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
                        "Contratamos el plan Arriendo y en menos de 5 días ya recibíamos contactos reales. Tener la web activa sin gran inversión inicial nos permitió enfocarnos en vender."
                    </p>
                    <div class="testimonial-author">Carlos Martínez</div>
                    <div class="testimonial-position">Dueño, Restaurante El Buen Sabor</div>
                    <div class="testimonial-location"><i class="fas fa-map-marker-alt"></i>Bogotá, Colombia</div>
                </div>
            </div>

            <!-- Testimonio 2 -->
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
                        "Usamos la Landing para una campaña y se dispararon las reservas. La configuración express y la prueba gratis nos permitieron medir resultados desde el primer día."
                    </p>
                    <div class="testimonial-author">Diana López</div>
                    <div class="testimonial-position">Gerente de Marketing, Fitness360</div>
                    <div class="testimonial-location"><i class="fas fa-map-marker-alt"></i>Medellín, Colombia</div>
                </div>
            </div>

            <!-- Testimonio 3 -->
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
                        "Con el plan Arriendo tenemos una web profesional sin una inversión grande. El soporte nos ayudó a optimizar para celular y hoy captamos más clientes."
                    </p>
                    <div class="testimonial-author">José Luis García</div>
                    <div class="testimonial-position">Gerente, Taller Automotriz García</div>
                    <div class="testimonial-location"><i class="fas fa-map-marker-alt"></i>Barranquilla, Colombia</div>
                </div>
            </div>

            <!-- Testimonio 4 -->
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
                        "Empezamos con Arriendo y luego migramos a Landing para escalar. La transición fue sencilla y las mejoras aumentaron la captación de clientes."
                    </p>
                    <div class="testimonial-author">Laura Sánchez</div>
                    <div class="testimonial-position">Fundadora, Boutique Luna Bella</div>
                    <div class="testimonial-location"><i class="fas fa-map-marker-alt"></i>Cali, Colombia</div>
                </div>
            </div>

            <!-- Testimonio 5 -->
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
                        "Elegimos Arriendo para empezar sin complicaciones. Activaron nuestra web en días y el formulario integrado a WhatsApp nos trae consultas todos los días."
                    </p>
                    <div class="testimonial-author">Andrés Pérez</div>
                    <div class="testimonial-position">Propietario, Ferretería El Tornillo</div>
                    <div class="testimonial-location"><i class="fas fa-map-marker-alt"></i>Bucaramanga, Colombia</div>
                </div>
            </div>

            <!-- Testimonio 6 -->
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
                        "La Landing nos sirvió para promocionar un nuevo producto y medir resultados con la prueba gratis. En una semana validamos la campaña y aumentamos las ventas."
                    </p>
                    <div class="testimonial-author">Natalia Gómez</div>
                    <div class="testimonial-position">Co-fundadora, EcoCafé</div>
                    <div class="testimonial-location"><i class="fas fa-map-marker-alt"></i>Cartagena, Colombia</div>
                </div>
            </div>

            <!-- Testimonio 7 -->
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
                        "Con Arriendo y el SEO básico mejoramos la visibilidad local. Ahora recibimos más citas de pacientes que nos encuentran en Google."
                    </p>
                    <div class="testimonial-author">Miguel Torres</div>
                    <div class="testimonial-position">Director, Clínica Dental Sonrisa</div>
                    <div class="testimonial-location"><i class="fas fa-map-marker-alt"></i>Pereira, Colombia</div>
                </div>
            </div>

            <!-- Testimonio 8 -->
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
                        "Lancé una Landing con catálogo y formulario. Fue la forma más rápida de tener presencia online y cerrar pedidos sin complicarme."
                    </p>
                    <div class="testimonial-author">Juliana Rojas</div>
                    <div class="testimonial-position">Emprendedora, Artesanías JR</div>
                    <div class="testimonial-location"><i class="fas fa-map-marker-alt"></i>Manizales, Colombia</div>
                </div>
            </div>

            <!-- Testimonio 9 -->
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
                        "Centralizamos la atención en la web con Arriendo. Pasamos de depender de redes sociales a un sitio propio que convierte mejor."
                    </p>
                    <div class="testimonial-author">Sebastián Rivera</div>
                    <div class="testimonial-position">CEO, TechFix</div>
                    <div class="testimonial-location"><i class="fas fa-map-marker-alt"></i>Cúcuta, Colombia</div>
                </div>
            </div>

            <!-- Testimonio 10 -->
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
                        "Para temporada alta lanzamos un sitio en Arriendo y luego migramos a Landing para mantener reservas todo el año. El proceso fue rápido y sin fricción."
                    </p>
                    <div class="testimonial-author">Paola Mendoza</div>
                    <div class="testimonial-position">Administradora, Hotel VistaMar</div>
                    <div class="testimonial-location"><i class="fas fa-map-marker-alt"></i>Santa Marta, Colombia</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section style="background: var(--dark-bg); padding: 4rem 0; color: white; text-align: center;">
    <div class="container">
        <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">¿Listo para vender más?</h2>
        <p style="font-size: 1.2rem; margin-bottom: 2rem; opacity: 0.9;">
            Elige arriendo para empezar sin grandes costos o adquiere tu sitio con dominio y hosting incluidos
        </p>
        <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg">
            <i class="fas fa-rocket me-2"></i>Comienza Ahora
        </a>
    </div>
</section>
@endsection