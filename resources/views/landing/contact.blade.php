@extends('layouts.app')

@section('title', 'Contacto – Consigue tu web fácil (arriendo o compra)')
@section('description', 'Hablemos de tu página web: arriendo desde $45.000 COP/trimestre o compra con dominio y hosting (1er año) incluidos. Empieza con 15 días de prueba gratuita.')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/contact-form.css') }}">
<style>
    .contact-hero {
        background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-gold) 100%);
        padding: 8rem 0 4rem;
        color: white;
        text-align: center;
    }

    .contact-hero h1 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }

    .contact-content {
        padding: 5rem 0;
    }

    .contact-info-card {
        background: white;
        padding: 3rem;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-top: 5px solid var(--primary-gold);
        height: 100%;
    }

    .contact-method {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: var(--light-gray);
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .contact-method:hover {
        background: var(--primary-gold);
        color: var(--dark-bg);
        transform: translateY(-3px);
    }

    .contact-method i {
        font-size: 2rem;
        margin-right: 1.5rem;
        color: var(--primary-red);
        width: 50px;
        text-align: center;
    }

    .contact-method:hover i {
        color: var(--dark-bg);
    }

    .contact-method-info h4 {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .contact-method:hover .contact-method-info h4 {
        color: var(--dark-bg);
    }

    .contact-method-info p {
        margin: 0;
        color: var(--medium-gray);
    }

    .contact-method-info p a {
        color: var(--primary-red);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .contact-method-info p a:hover {
        color: var(--primary-gold);
        text-decoration: underline;
    }

    .contact-method:hover .contact-method-info p {
        color: var(--dark-bg);
        opacity: 0.8;
    }

    .office-info {
        background: var(--light-gray);
        padding: 4rem 0;
    }

    .office-card {
        background: white;
        padding: 2.5rem;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }

    .office-card:hover {
        transform: translateY(-5px);
    }

    .office-flag {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .office-country {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--primary-red);
        margin-bottom: 1rem;
    }

    .office-details {
        color: var(--medium-gray);
        line-height: 1.6;
    }
</style>
@endpush

@section('content')
<!-- Contact Hero -->
<section class="contact-hero">
    <div class="container">
    <h1>¿Listo para tu web fácil y rápida?</h1>
    <p>Te ayudamos a elegir arriendo o compra y a empezar con <strong>15 días de prueba</strong></p>
    </div>
</section>

<!-- Contact Content -->
<section class="contact-content">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="row">
            <!-- Contact Information -->
            <div class="col-lg-4 mb-4">
                <div class="contact-info-card">
                    <h3 style="color: var(--primary-red); margin-bottom: 2rem; font-weight: 600;">
                        Información de Contacto
                    </h3>
                    
                    <!-- Email -->
                    <div class="contact-method">
                        <i class="fas fa-envelope"></i>
                        <div class="contact-method-info">
                            <h4>Email</h4>
                            <p style="font-size: 13px;">
                                <a href="mailto:info@bbb.es" id="contact-empresa-email">
                                    info@bbb.es
                                </a>
                            </p>
                        </div>
                    </div>

                    <!-- WhatsApp -->
                    <div class="contact-method">
                        <i class="fab fa-whatsapp"></i>
                        <div class="contact-method-info">
                            <h4>WhatsApp</h4>
                            <p>
                                <a
                                    href="https://wa.me/{{ config('app.support.mobile') }}?text=Hola, estoy interesado en los servicios de BBB"
                                    target="_blank"
                                    id="contact-empresa-movil"
                                >
                                    +34 600 123 456
                                </a>
                            </p>
                        </div>
                    </div>

                    <!-- Horarios -->
                    <div class="contact-method">
                        <i class="fas fa-clock"></i>
                        <div class="contact-method-info">
                            <h4>Horarios de Atención</h4>
                            <p>Lunes a Viernes: 9:00 - 18:00</p>
                        </div>
                    </div>

                    <!-- Tiempo de Respuesta -->
                    <div class="contact-method">
                        <i class="fas fa-reply"></i>
                        <div class="contact-method-info">
                            <h4>Tiempo de Respuesta</h4>
                            <p>Menos de 24 horas</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-8">
                <div class="contact-form-extended">
                    <h3 style="color: var(--primary-red); margin-bottom: 2rem; font-weight: 600;">
                        Cuéntanos sobre tu proyecto
                    </h3>
                    
                    @include('components.contact-form')
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Office Information -->
{{-- <section class="office-info">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 3rem; color: #333;">
                    Presencia <span style="color: var(--primary-gold);">Internacional</span>
                </h2>
                <p style="font-size: 1.1rem; color: var(--medium-gray); margin-bottom: 3rem;">
                    Atendemos clientes en múltiples países con soporte local
                </p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="office-card">
                    <div class="office-flag">🇨🇴</div>
                    <h4 class="office-country">Colombia</h4>
                    <div class="office-details">
                        <p><strong>Bogotá, Medellín, Cali</strong></p>
                        <p>Soporte local en español</p>
                        <p>Horario: GMT-5</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="office-card">
                    <div class="office-flag">🇲🇽</div>
                    <h4 class="office-country">México</h4>
                    <div class="office-details">
                        <p><strong>Ciudad de México, Guadalajara</strong></p>
                        <p>Atención personalizada</p>
                        <p>Horario: GMT-6</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="office-card">
                    <div class="office-flag">🇪🇸</div>
                    <h4 class="office-country">España</h4>
                    <div class="office-details">
                        <p><strong>Madrid, Barcelona, Valencia</strong></p>
                        <p>Cobertura europea</p>
                        <p>Horario: GMT+1</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section style="padding: 4rem 0; background: white;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h3 style="text-align: center; font-size: 2rem; margin-bottom: 3rem; color: #333;">
                    Preguntas <span style="color: var(--primary-gold);">Frecuentes</span>
                </h3>
                
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item mb-3" style="border: 1px solid #e9ecef; border-radius: 10px;">
                        <h2 class="accordion-header">
                            <button class="accordion-button" style="border-radius: 10px;" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                ¿Cuánto tiempo toma crear mi página web?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                El tiempo depende del tipo de proyecto. Una página básica toma entre 7-10 días, 
                                mientras que proyectos más complejos pueden tomar 2-4 semanas. Te daremos un 
                                cronograma detallado después de nuestra consulta inicial.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item mb-3" style="border: 1px solid #e9ecef; border-radius: 10px;">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" style="border-radius: 10px;" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                ¿Incluyen el hosting y dominio?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Sí, incluimos hosting profesional por el primer año y te ayudamos con la 
                                configuración del dominio. También ofrecemos opciones de renovación anual 
                                a precios preferenciales.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item mb-3" style="border: 1px solid #e9ecef; border-radius: 10px;">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" style="border-radius: 10px;" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                ¿Puedo hacer cambios después del lanzamiento?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                ¡Por supuesto! Incluimos capacitación para que puedas hacer cambios básicos, 
                                y nuestro equipo está disponible para modificaciones más complejas. 
                                También ofrecemos planes de mantenimiento mensual.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}
@endsection