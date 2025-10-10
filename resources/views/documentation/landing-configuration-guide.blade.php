@extends('layouts.dashboard')

@section('title', 'Configura tu Landing - BBB Academy')
@section('description', 'Aprende paso a paso cómo personalizar tu página web con BBB')

@push('styles')
<style>
    .step-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        margin-bottom: 2rem;
    }
    
    .step-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .step-number {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
        margin: 0 auto 1rem;
    }
    
    .feature-box {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border-left: 4px solid #667eea;
    }
    
    .tip-box {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(32, 201, 151, 0.1));
        border-radius: 12px;
        padding: 1rem;
        border-left: 4px solid #28a745;
    }
    
    .warning-box {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(253, 126, 20, 0.1));
        border-radius: 12px;
        padding: 1rem;
        border-left: 4px solid #ffc107;
    }
    
    .screenshot-placeholder {
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        margin: 1rem 0;
    }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="content-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="dashboard-title">
                <i class="bi bi-rocket-takeoff me-3 text-primary"></i>
                Configura tu Landing Page
            </h1>
            <p class="text-muted mb-0">Personaliza tu sitio web paso a paso - ¡Es más fácil de lo que piensas!</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.documentation.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver a Academy
            </a>
            <a href="{{ route('admin.landing.configurar') }}" class="btn btn-primary">
                <i class="bi bi-gear me-2"></i>
                Ir a Configuración
            </a>
        </div>
    </div>
</div>

<!-- Introducción -->
<div class="row mb-4">
    <div class="col-12">
        <div class="feature-box">
            <div class="d-flex align-items-start">
                <div class="me-3">
                    <i class="bi bi-info-circle-fill fs-3 text-primary"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-2">¿Qué vas a aprender?</h4>
                    <p class="mb-2">Tu Landing Page es la cara de tu negocio en internet. Aquí aprenderás a:</p>
                    <ul class="mb-0">
                        <li><strong>Personalizar colores</strong> - Usa los colores de tu marca</li>
                        <li><strong>Subir tu logo</strong> - Dale identidad a tu sitio</li>
                        <li><strong>Escribir textos atractivos</strong> - Convence a tus visitantes</li>
                        <li><strong>Añadir productos</strong> - Muestra lo que vendes</li>
                        <li><strong>Configurar contacto</strong> - Que te encuentren fácilmente</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pasos -->
<div class="row">
    <div class="col-12">
        <!-- Paso 1 -->
        <div class="step-card card">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-2 text-center">
                        <div class="step-number">1</div>
                        <h6 class="fw-bold">Datos Básicos</h6>
                    </div>
                    <div class="col-lg-10">
                        <h5 class="fw-bold mb-3">Configura la información de tu empresa</h5>
                        <p class="text-muted mb-3">Este es el primer paso y el más importante. La información que pongas aquí aparecerá en toda tu página web.</p>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <h6><i class="bi bi-building text-primary me-2"></i>Nombre de la empresa</h6>
                                <p class="text-muted mb-0">Este será el título principal de tu sitio web. Usa el nombre comercial que tus clientes conocen.</p>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="bi bi-chat-text text-primary me-2"></i>Slogan o descripción</h6>
                                <p class="text-muted mb-0">Una frase corta que describa qué haces. Ejemplo: "Los mejores productos para tu hogar"</p>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="bi bi-telephone text-primary me-2"></i>Teléfono de contacto</h6>
                                <p class="text-muted mb-0">El número donde te pueden llamar. Se mostrará con formato bonito automáticamente.</p>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="bi bi-envelope text-primary me-2"></i>Email de contacto</h6>
                                <p class="text-muted mb-0">Tu email profesional. Los clientes podrán escribirte directamente desde tu web.</p>
                            </div>
                        </div>
                        
                        <div class="tip-box">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-lightbulb-fill text-success me-2 mt-1"></i>
                                <div>
                                    <strong>💡 Tip profesional:</strong> Usa datos reales y actualizados. Los clientes verifican esta información antes de comprar.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paso 2 -->
        <div class="step-card card">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-2 text-center">
                        <div class="step-number">2</div>
                        <h6 class="fw-bold">Colores</h6>
                    </div>
                    <div class="col-lg-10">
                        <h5 class="fw-bold mb-3">Personaliza los colores de tu marca</h5>
                        <p class="text-muted mb-3">Los colores son súper importantes para que tu sitio se vea profesional y reconocible.</p>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="text-center p-3 border rounded">
                                    <div class="mb-2" style="width: 60px; height: 60px; background: #007bff; border-radius: 50%; margin: 0 auto;"></div>
                                    <h6>Color Principal</h6>
                                    <p class="text-muted small mb-0">Para botones y títulos importantes</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-center p-3 border rounded">
                                    <div class="mb-2" style="width: 60px; height: 60px; background: #28a745; border-radius: 50%; margin: 0 auto;"></div>
                                    <h6>Color Secundario</h6>
                                    <p class="text-muted small mb-0">Para acentos y detalles</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="warning-box">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-exclamation-triangle-fill text-warning me-2 mt-1"></i>
                                <div>
                                    <strong>⚠️ Importante:</strong> Elige colores que contrasten bien. Si no tienes colores de marca definidos, te sugerimos combinaciones que funcionan bien.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paso 3 -->
        <div class="step-card card">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-2 text-center">
                        <div class="step-number">3</div>
                        <h6 class="fw-bold">Logo</h6>
                    </div>
                    <div class="col-lg-10">
                        <h5 class="fw-bold mb-3">Sube el logo de tu empresa</h5>
                        <p class="text-muted mb-3">Tu logo es lo primero que ven los visitantes. Debe verse bien y profesional.</p>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <h6><i class="bi bi-image text-primary me-2"></i>Formatos recomendados</h6>
                                <ul class="text-muted">
                                    <li>PNG (con fondo transparente) - <strong>Recomendado</strong></li>
                                    <li>JPG (con fondo blanco)</li>
                                    <li>SVG (vectorial) - Mejor calidad</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="bi bi-aspect-ratio text-primary me-2"></i>Tamaño ideal</h6>
                                <ul class="text-muted">
                                    <li>Ancho: entre 200px y 400px</li>
                                    <li>Alto: entre 80px y 200px</li>
                                    <li>Peso: máximo 2MB</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="tip-box">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-lightbulb-fill text-success me-2 mt-1"></i>
                                <div>
                                    <strong>💡 ¿No tienes logo?</strong> No te preocupes, puedes usar solo el nombre de tu empresa por ahora. Más adelante puedes añadir un logo profesional.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paso 4 -->
        <div class="step-card card">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-2 text-center">
                        <div class="step-number">4</div>
                        <h6 class="fw-bold">Contenido</h6>
                    </div>
                    <div class="col-lg-10">
                        <h5 class="fw-bold mb-3">Escribe textos que vendan</h5>
                        <p class="text-muted mb-3">Los textos de tu página deben convencer a los visitantes de que compren contigo.</p>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <h6><i class="bi bi-megaphone text-primary me-2"></i>Título principal (Hero)</h6>
                                <p class="text-muted">Una frase que capture la atención inmediatamente. Ejemplos:</p>
                                <div class="bg-light p-3 rounded">
                                    <ul class="mb-0 text-muted">
                                        <li>"Los mejores productos para tu hogar, con envío gratis"</li>
                                        <li>"Comida casera con el sabor de siempre, ahora a domicilio"</li>
                                        <li>"Repara tu celular en 30 minutos, garantía de 6 meses"</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-12">
                                <h6><i class="bi bi-card-text text-primary me-2"></i>Descripción de tu negocio</h6>
                                <p class="text-muted">2-3 párrafos que expliquen qué haces, por qué eres diferente y qué beneficios ofreces.</p>
                            </div>
                        </div>
                        
                        <div class="tip-box">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-lightbulb-fill text-success me-2 mt-1"></i>
                                <div>
                                    <strong>💡 Fórmula que funciona:</strong> Problema + Solución + Beneficio. Ejemplo: "¿Cansado de comida rápida? (problema) Nosotros preparamos comidas caseras nutritivas (solución) y te las llevamos calentitas a tu casa (beneficio)."
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paso 5 -->
        <div class="step-card card">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-2 text-center">
                        <div class="step-number">5</div>
                        <h6 class="fw-bold">Redes Sociales</h6>
                    </div>
                    <div class="col-lg-10">
                        <h5 class="fw-bold mb-3">Conecta tus redes sociales</h5>
                        <p class="text-muted mb-3">Las redes sociales dan confianza y permiten que los clientes te sigan.</p>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6 col-lg-3">
                                <div class="text-center p-3 border rounded">
                                    <i class="bi bi-facebook fs-2 text-primary mb-2"></i>
                                    <h6>Facebook</h6>
                                    <p class="text-muted small mb-0">Página de empresa</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="text-center p-3 border rounded">
                                    <i class="bi bi-instagram fs-2 text-danger mb-2"></i>
                                    <h6>Instagram</h6>
                                    <p class="text-muted small mb-0">Perfil de negocio</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="text-center p-3 border rounded">
                                    <i class="bi bi-whatsapp fs-2 text-success mb-2"></i>
                                    <h6>WhatsApp</h6>
                                    <p class="text-muted small mb-0">Número de contacto</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="text-center p-3 border rounded">
                                    <i class="bi bi-tiktok fs-2 text-dark mb-2"></i>
                                    <h6>TikTok</h6>
                                    <p class="text-muted small mb-0">Perfil opcional</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="warning-box">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-exclamation-triangle-fill text-warning me-2 mt-1"></i>
                                <div>
                                    <strong>⚠️ Importante:</strong> Solo añade las redes sociales que realmente usas y mantienes actualizadas. Es mejor tener pocas pero activas.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de acción -->
        <div class="text-center mb-4">
            <a href="{{ route('admin.landing.configurar') }}" class="btn btn-primary btn-lg px-5">
                <i class="bi bi-rocket me-2"></i>
                ¡Comenzar a configurar ahora!
            </a>
            <p class="text-muted mt-2">Todo el proceso toma menos de 10 minutos</p>
        </div>

        <!-- FAQ rápido -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-question-circle me-2"></i>Preguntas frecuentes</h5>
            </div>
            <div class="card-body">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                ¿Puedo cambiar los datos después?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Sí, puedes cambiar cualquier información cuando quieras. Los cambios se reflejan inmediatamente en tu sitio web.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                ¿Qué pasa si me equivoco en algo?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                No te preocupes, puedes editar todo las veces que quieras. También tienes una vista previa para ver cómo se ve antes de publicar.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                ¿Necesito conocimientos técnicos?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Para nada. Nuestro sistema es súper fácil de usar. Solo tienes que llenar formularios y nosotros creamos tu sitio web automáticamente.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection