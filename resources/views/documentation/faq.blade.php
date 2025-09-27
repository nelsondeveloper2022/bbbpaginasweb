@extends('layouts.dashboard')

@section('title', 'Preguntas Frecuentes - BBB Páginas Web')
@section('description', 'Respuestas a las dudas más comunes sobre BBB Páginas Web')

@section('content')
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="dashboard-title">
                <i class="bi bi-question-circle me-3"></i>
                Preguntas Frecuentes
            </h1>
            <p class="text-muted mb-0">Respuestas a las dudas más comunes</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('documentation.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-2"></i>
                Volver
            </a>
            <a href="https://wa.me/{{ config('app.support.mobile') }}?text=Hola%2C%20tengo%20una%20pregunta%20sobre%20BBB%20Páginas%20Web" 
               target="_blank" class="btn btn-success btn-sm">
                <i class="bi bi-whatsapp me-2"></i>
                Hacer Pregunta
            </a>
        </div>
    </div>
</div>

<!-- Búsqueda rápida -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="search-box">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control" id="faqSearch" 
                               placeholder="Buscar en preguntas frecuentes...">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Categorías de preguntas -->
<div class="row">
    <div class="col-lg-3 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Categorías</h6>
            </div>
            <div class="list-group list-group-flush">
                <a href="#general" class="list-group-item list-group-item-action">
                    <i class="bi bi-info-circle me-2"></i>
                    General
                </a>
                <a href="#account" class="list-group-item list-group-item-action">
                    <i class="bi bi-person-circle me-2"></i>
                    Cuenta y Perfil
                </a>
                <a href="#publishing" class="list-group-item list-group-item-action">
                    <i class="bi bi-globe me-2"></i>
                    Publicación
                </a>
                <a href="#plans" class="list-group-item list-group-item-action">
                    <i class="bi bi-credit-card me-2"></i>
                    Planes y Pagos
                </a>
                <a href="#technical" class="list-group-item list-group-item-action">
                    <i class="bi bi-gear me-2"></i>
                    Técnico
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        <!-- General -->
        <div class="faq-section" id="general">
            <h4 class="mb-4">
                <i class="bi bi-info-circle text-primary me-2"></i>
                General
            </h4>
            
            <div class="accordion mb-5" id="generalAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#general1">
                            ¿Qué es BBB Páginas Web?
                        </button>
                    </h2>
                    <div id="general1" class="accordion-collapse collapse show" data-bs-parent="#generalAccordion">
                        <div class="accordion-body">
                            BBB Páginas Web es una plataforma que te permite crear y publicar sitios web profesionales 
                            de manera fácil y rápida, sin necesidad de conocimientos técnicos. Perfecta para empresas, 
                            emprendedores y profesionales que necesitan presencia online.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#general2">
                            ¿Necesito conocimientos técnicos?
                        </button>
                    </h2>
                    <div id="general2" class="accordion-collapse collapse" data-bs-parent="#generalAccordion">
                        <div class="accordion-body">
                            No, absolutamente no necesitas conocimientos técnicos. Nuestra plataforma está diseñada para 
                            ser intuitiva y fácil de usar. Solo necesitas completar tu información y nosotros nos encargamos 
                            del resto.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#general3">
                            ¿Cuánto tiempo toma crear mi sitio web?
                        </button>
                    </h2>
                    <div id="general3" class="accordion-collapse collapse" data-bs-parent="#generalAccordion">
                        <div class="accordion-body">
                            Con nuestra guía de inicio rápido, puedes tener tu sitio web publicado en tan solo 5-10 minutos. 
                            El tiempo puede variar según la cantidad de personalización que desees aplicar.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cuenta y Perfil -->
        <div class="faq-section" id="account">
            <h4 class="mb-4">
                <i class="bi bi-person-circle text-info me-2"></i>
                Cuenta y Perfil
            </h4>
            
            <div class="accordion mb-5" id="accountAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#account1">
                            ¿Por qué necesito verificar mi email?
                        </button>
                    </h2>
                    <div id="account1" class="accordion-collapse collapse" data-bs-parent="#accountAccordion">
                        <div class="accordion-body">
                            La verificación de email es obligatoria por seguridad. Nos asegura que eres el propietario 
                            real de la cuenta y nos permite enviarte notificaciones importantes sobre tu sitio web. 
                            Sin email verificado, no podrás publicar tu sitio.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#account2">
                            ¿Qué información necesito completar?
                        </button>
                    </h2>
                    <div id="account2" class="accordion-collapse collapse" data-bs-parent="#accountAccordion">
                        <div class="accordion-body">
                            Necesitas completar:
                            <ul class="mt-2">
                                <li>Tu nombre completo</li>
                                <li>Nombre de tu empresa</li>
                                <li>Email corporativo</li>
                                <li>Teléfono de contacto</li>
                                <li>Dirección de la empresa (opcional)</li>
                            </ul>
                            Esta información aparecerá en tu sitio web para que los clientes puedan contactarte.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#account3">
                            ¿Puedo cambiar mi información después?
                        </button>
                    </h2>
                    <div id="account3" class="accordion-collapse collapse" data-bs-parent="#accountAccordion">
                        <div class="accordion-body">
                            Sí, puedes actualizar tu información en cualquier momento desde tu perfil. Los cambios 
                            se reflejarán automáticamente en tu sitio web publicado.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Publicación -->
        <div class="faq-section" id="publishing">
            <h4 class="mb-4">
                <i class="bi bi-globe text-success me-2"></i>
                Publicación
            </h4>
            
            <div class="accordion mb-5" id="publishingAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#publishing1">
                            ¿Cómo funciona la URL de mi sitio web?
                        </button>
                    </h2>
                    <div id="publishing1" class="accordion-collapse collapse" data-bs-parent="#publishingAccordion">
                        <div class="accordion-body">
                            Tu sitio web tendrá una URL del tipo: <strong>bbbpaginasweb.com/{{ auth()->user()->empresa && auth()->user()->empresa->slug ? auth()->user()->empresa->slug : 'tuempresa' }}</strong>. 
                            El nombre se genera automáticamente basado en el nombre de tu empresa, eliminando 
                            espacios y caracteres especiales.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#publishing2">
                            ¿Mi sitio es compatible con móviles?
                        </button>
                    </h2>
                    <div id="publishing2" class="accordion-collapse collapse" data-bs-parent="#publishingAccordion">
                        <div class="accordion-body">
                            Sí, todos nuestros sitios web están optimizados para dispositivos móviles (responsive design). 
                            Se verán perfectamente en teléfonos, tablets y computadoras.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#publishing3">
                            ¿Qué incluye el certificado SSL?
                        </button>
                    </h2>
                    <div id="publishing3" class="accordion-collapse collapse" data-bs-parent="#publishingAccordion">
                        <div class="accordion-body">
                            Todos nuestros sitios incluyen certificado SSL gratuito, lo que significa que tu sitio 
                            tendrá el candado de seguridad (https://) y será considerado seguro por los navegadores 
                            y motores de búsqueda como Google.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Planes y Pagos -->
        <div class="faq-section" id="plans">
            <h4 class="mb-4">
                <i class="bi bi-credit-card text-warning me-2"></i>
                Planes y Pagos
            </h4>
            
            <div class="accordion mb-5" id="plansAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#plans1">
                            ¿Qué incluye el período de prueba?
                        </button>
                    </h2>
                    <div id="plans1" class="accordion-collapse collapse" data-bs-parent="#plansAccordion">
                        <div class="accordion-body">
                            El período de prueba te da acceso completo a la plataforma por 15 días. Puedes crear, 
                            personalizar y publicar tu sitio web. Al finalizar, necesitarás elegir un plan para 
                            mantener tu sitio online.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#plans2">
                            ¿Cómo funciona la renovación automática?
                        </button>
                    </h2>
                    <div id="plans2" class="accordion-collapse collapse" data-bs-parent="#plansAccordion">
                        <div class="accordion-body">
                            Los planes se renuevan automáticamente según la duración que elijas (mensual o anual). 
                            Te enviaremos recordatorios antes del vencimiento y puedes cancelar en cualquier momento 
                            desde tu panel de control.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#plans3">
                            ¿Qué pasa si no renuevo mi plan?
                        </button>
                    </h2>
                    <div id="plans3" class="accordion-collapse collapse" data-bs-parent="#plansAccordion">
                        <div class="accordion-body">
                            Si no renuevas tu plan, tu sitio web dejará de estar disponible online. Sin embargo, 
                            toda tu información y configuración se mantiene guardada. Puedes reactivar tu sitio 
                            en cualquier momento renovando tu plan.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Técnico -->
        <div class="faq-section" id="technical">
            <h4 class="mb-4">
                <i class="bi bi-gear text-secondary me-2"></i>
                Técnico
            </h4>
            
            <div class="accordion mb-5" id="technicalAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#technical1">
                            ¿Dónde están alojados los sitios web?
                        </button>
                    </h2>
                    <div id="technical1" class="accordion-collapse collapse" data-bs-parent="#technicalAccordion">
                        <div class="accordion-body">
                            Nuestros sitios web están alojados en servidores confiables con alta disponibilidad (99.9% uptime). 
                            Esto garantiza que tu sitio esté disponible prácticamente todo el tiempo.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#technical2">
                            ¿Hacen respaldos de mi sitio?
                        </button>
                    </h2>
                    <div id="technical2" class="accordion-collapse collapse" data-bs-parent="#technicalAccordion">
                        <div class="accordion-body">
                            Sí, realizamos respaldos automáticos diarios de todos los sitios web. Tu información 
                            está segura y protegida contra pérdidas accidentales.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#technical3">
                            ¿Qué navegadores son compatibles?
                        </button>
                    </h2>
                    <div id="technical3" class="accordion-collapse collapse" data-bs-parent="#technicalAccordion">
                        <div class="accordion-body">
                            Nuestros sitios web son compatibles con todos los navegadores modernos: Chrome, Firefox, 
                            Safari, Edge, y sus versiones móviles. También funcionan correctamente en navegadores 
                            más antiguos.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sección de contacto -->
<div class="row mt-5">
    <div class="col-12">
        <div class="card bg-primary text-white">
            <div class="card-body text-center py-4">
                <h5 class="mb-3">¿No encontraste tu respuesta?</h5>
                <p class="mb-3">Nuestro equipo de soporte está aquí para ayudarte</p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="https://wa.me/{{ config('app.support.mobile') }}?text=Hola%2C%20tengo%20una%20pregunta%20sobre%20BBB%20Páginas%20Web" 
                       target="_blank" class="btn btn-light">
                        <i class="bi bi-whatsapp me-2"></i>
                        WhatsApp
                    </a>
                    <a href="mailto:{{ config('app.support.email') }}" class="btn btn-outline-light">
                        <i class="bi bi-envelope me-2"></i>
                        Email
                    </a>
                    <a href="tel:+{{ config('app.support.mobile') }}" class="btn btn-outline-light">
                        <i class="bi bi-telephone me-2"></i>
                        Teléfono
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Búsqueda en tiempo real
document.getElementById('faqSearch').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const accordionItems = document.querySelectorAll('.accordion-item');
    
    accordionItems.forEach(item => {
        const button = item.querySelector('.accordion-button');
        const body = item.querySelector('.accordion-body');
        const buttonText = button.textContent.toLowerCase();
        const bodyText = body.textContent.toLowerCase();
        
        if (buttonText.includes(searchTerm) || bodyText.includes(searchTerm)) {
            item.style.display = 'block';
            if (searchTerm.length > 2) {
                // Highlight search terms
                highlightText(button, searchTerm);
                highlightText(body, searchTerm);
            }
        } else {
            item.style.display = 'none';
        }
    });
    
    // Show/hide sections based on results
    document.querySelectorAll('.faq-section').forEach(section => {
        const visibleItems = section.querySelectorAll('.accordion-item[style*="block"], .accordion-item:not([style])');
        section.style.display = visibleItems.length > 0 ? 'block' : 'none';
    });
});

// Smooth scroll for category links
document.querySelectorAll('a[href^="#"]').forEach(link => {
    link.addEventListener('click', function(e) {
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

function highlightText(element, searchTerm) {
    // Simple highlight function - in a real app you'd want something more robust
    const text = element.textContent;
    const regex = new RegExp(`(${searchTerm})`, 'gi');
    // This is a simplified version - you'd want to preserve HTML structure
}
</script>
@endsection