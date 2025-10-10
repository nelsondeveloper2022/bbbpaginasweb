@extends('layouts.dashboard')

@section('title', 'Preguntas Frecuentes - BBB Academy')
@section('description', 'Respuestas rápidas a las dudas más comunes sobre cómo usar tu plataforma BBB')

@push('styles')
<style>
    .faq-category {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
        overflow: hidden;
    }
    
    .category-header {
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
        border-bottom: 1px solid #e9ecef;
        padding: 1.5rem;
    }
    
    .category-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }
    
    .faq-item {
        border-bottom: 1px solid #f1f3f4;
    }
    
    .faq-item:last-child {
        border-bottom: none;
    }
    
    .faq-question {
        background: none;
        border: none;
        padding: 1.25rem 1.5rem;
        text-align: left;
        width: 100%;
        font-size: 1rem;
        font-weight: 500;
        color: #495057;
        transition: all 0.3s ease;
    }
    
    .faq-question:hover {
        background: rgba(102, 126, 234, 0.05);
        color: #667eea;
    }
    
    .faq-question[aria-expanded="true"] {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
        border-bottom: 1px solid rgba(102, 126, 234, 0.2);
    }
    
    .faq-answer {
        padding: 0 1.5rem 1.25rem;
        color: #6c757d;
        line-height: 1.6;
    }
    
    .highlight-box {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(32, 201, 151, 0.1));
        border-radius: 12px;
        padding: 1rem;
        margin: 1rem 0;
        border-left: 4px solid #28a745;
    }
    
    .search-highlight {
        background: rgba(255, 235, 59, 0.3);
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
    }
</style>
@endpush

@section('content')
<div class="content-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="dashboard-title">
                <i class="bi bi-chat-square-dots me-3 text-primary"></i>
                Preguntas Frecuentes
            </h1>
            <p class="text-muted mb-0">Respuestas rápidas a las dudas más comunes - ¡Resuelve todo aquí!</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.documentation.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver a Academy
            </a>
            <a href="https://wa.me/{{ config('app.support.mobile') }}?text=Hola%2C%20vengo%20del%20FAQ%20y%20tengo%20una%20pregunta%20específica" 
               target="_blank" class="btn btn-success">
                <i class="bi bi-whatsapp me-2"></i>
                Ayuda Personal
            </a>
        </div>
    </div>
</div>

<!-- Búsqueda rápida -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1)); border-radius: 16px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="category-icon me-3" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                        <i class="bi bi-search fs-4 text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold">¿Buscas algo específico?</h5>
                        <p class="mb-0 text-muted">Escribe palabras clave para encontrar respuestas rápidamente</p>
                    </div>
                </div>
                <div class="input-group">
                    <span class="input-group-text bg-white border-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-0" id="faqSearch" 
                           placeholder="Ejemplo: 'cambiar colores', 'subir logo', 'añadir productos'...">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Categorías de preguntas -->
<div class="row">
    <!-- Primeros pasos -->
    <div class="col-12">
        <div class="faq-category card">
            <div class="category-header">
                <div class="d-flex align-items-center">
                    <div class="category-icon" style="background: linear-gradient(135deg, #28a745, #20c997);">
                        <i class="bi bi-rocket-takeoff fs-4 text-white"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold">🚀 Primeros pasos</h4>
                        <p class="mb-0 text-muted">Todo lo que necesitas para empezar</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="faq-item">
                    <button class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq-start-1">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <span>¿Por dónde empiezo? Soy nuevo en esto</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </button>
                    <div id="faq-start-1" class="collapse">
                        <div class="faq-answer">
                            <p><strong>¡Perfecto! Te recomendamos este orden:</strong></p>
                            <ol>
                                <li><strong>Completa tu perfil</strong> - Ve a "Perfil y Empresa" y llena todos los datos</li>
                                <li><strong>Configura tu landing</strong> - Personaliza colores, logo y textos</li>
                                <li><strong>Añade productos</strong> - Crea tu catálogo con fotos y precios</li>
                                <li><strong>Configura pagos</strong> - Conecta Wompi para recibir pagos</li>
                                <li><strong>Registra tus primeros clientes</strong> - Organiza tus contactos</li>
                            </ol>
                            <div class="highlight-box">
                                <strong>💡 Consejo:</strong> Cada paso tiene una guía detallada en BBB Academy. ¡No te preocupes si algo no entiendes, todo es súper fácil!
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq-start-2">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <span>¿Cuánto tiempo toma configurar todo?</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </button>
                    <div id="faq-start-2" class="collapse">
                        <div class="faq-answer">
                            <p>Si tienes todo preparado, puedes tener tu sitio funcionando en <strong>menos de 30 minutos</strong>:</p>
                            <ul>
                                <li>Perfil de empresa: 5 minutos</li>
                                <li>Configurar landing: 10 minutos</li>
                                <li>Añadir 5-10 productos: 15 minutos</li>
                                <li>Configurar pagos: 5 minutos</li>
                            </ul>
                            <div class="highlight-box">
                                <strong>📝 Prepara antes:</strong> Logo, fotos de productos, descripción de tu empresa, datos de Wompi
                            </div>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq-start-3">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <span>¿Necesito conocimientos técnicos?</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </button>
                    <div id="faq-start-3" class="collapse">
                        <div class="faq-answer">
                            <p><strong>¡Para nada!</strong> BBB está diseñado para que cualquier persona pueda usarlo sin conocimientos técnicos.</p>
                            <p>Todo funciona con formularios sencillos, como llenar una aplicación de WhatsApp o Facebook. Solo tienes que:</p>
                            <ul>
                                <li>Escribir textos (como en Word)</li>
                                <li>Subir fotos (como en Instagram)</li>
                                <li>Elegir colores (con un selector visual)</li>
                                <li>Llenar formularios simples</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Configuración del sitio web -->
    <div class="col-12">
        <div class="faq-category card">
            <div class="category-header">
                <div class="d-flex align-items-center">
                    <div class="category-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                        <i class="bi bi-palette fs-4 text-white"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold">🎨 Configurar mi sitio web</h4>
                        <p class="mb-0 text-muted">Personalizar colores, logo y contenido</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="faq-item">
                    <button class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq-design-1">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <span>¿Cómo cambio los colores de mi sitio web?</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </button>
                    <div id="faq-design-1" class="collapse">
                        <div class="faq-answer">
                            <p>Es súper fácil:</p>
                            <ol>
                                <li>Ve a <strong>"Configura tu Landing"</strong> en el menú</li>
                                <li>Busca la sección <strong>"Colores de la marca"</strong></li>
                                <li>Haz clic en cada color y elige el que quieras</li>
                                <li>Ve la vista previa en tiempo real</li>
                                <li>Guarda los cambios</li>
                            </ol>
                            <div class="highlight-box">
                                <strong>💡 Tip:</strong> Si no sabes qué colores elegir, usa los colores de tu logo o busca "paletas de colores" en Google para inspirarte.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq-design-2">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <span>¿Qué formato debe tener mi logo?</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </button>
                    <div id="faq-design-2" class="collapse">
                        <div class="faq-answer">
                            <p><strong>Formatos aceptados:</strong></p>
                            <ul>
                                <li><strong>PNG</strong> - Recomendado (fondo transparente)</li>
                                <li><strong>JPG</strong> - Funciona bien (fondo blanco preferible)</li>
                                <li><strong>SVG</strong> - Excelente calidad</li>
                            </ul>
                            <p><strong>Tamaño recomendado:</strong></p>
                            <ul>
                                <li>Ancho: 200px a 400px</li>
                                <li>Alto: 80px a 200px</li>
                                <li>Peso máximo: 2MB</li>
                            </ul>
                            <div class="highlight-box">
                                <strong>¿No tienes logo?</strong> Puedes usar solo el nombre de tu empresa por ahora. Más adelante añades el logo cuando lo tengas.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq-design-3">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <span>¿Puedo ver cómo se ve mi sitio antes de publicarlo?</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </button>
                    <div id="faq-design-3" class="collapse">
                        <div class="faq-answer">
                            <p><strong>¡Sí, por supuesto!</strong> Tienes varias opciones:</p>
                            <ul>
                                <li><strong>Vista previa automática</strong> - Mientras configuras, ves los cambios en tiempo real</li>
                                <li><strong>Botón "Preview"</strong> - Te muestra exactamente cómo lo verán tus clientes</li>
                                <li><strong>Modo edición</strong> - Puedes hacer cambios y probar varias veces</li>
                            </ul>
                            <p>Solo cuando estés 100% satisfecho, presionas <strong>"Publicar"</strong> y tu sitio se hace público.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Productos y ventas -->
    <div class="col-12">
        <div class="faq-category card">
            <div class="category-header">
                <div class="d-flex align-items-center">
                    <div class="category-icon" style="background: linear-gradient(135deg, #fd7e14, #ff6b35);">
                        <i class="bi bi-box-seam fs-4 text-white"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold">📦 Productos y ventas</h4>
                        <p class="mb-0 text-muted">Gestionar catálogo y procesar pedidos</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="faq-item">
                    <button class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq-products-1">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <span>¿Cuántos productos puedo añadir?</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </button>
                    <div id="faq-products-1" class="collapse">
                        <div class="faq-answer">
                            <p><strong>¡Todos los que quieras!</strong> No hay límite en la cantidad de productos que puedes registrar.</p>
                            <p>Tu plan actual te permite:</p>
                            <ul>
                                <li>Productos ilimitados</li>
                                <li>Múltiples fotos por producto</li>
                                <li>Categorías para organizarlos</li>
                                <li>Descripciones detalladas</li>
                                <li>Precios y ofertas especiales</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq-products-2">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <span>¿Cómo subo fotos de mis productos?</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </button>
                    <div id="faq-products-2" class="collapse">
                        <div class="faq-answer">
                            <p><strong>Es muy sencillo:</strong></p>
                            <ol>
                                <li>Ve a <strong>"Productos"</strong> → <strong>"Añadir producto"</strong></li>
                                <li>Llena nombre, precio y descripción</li>
                                <li>Haz clic en <strong>"Subir fotos"</strong></li>
                                <li>Selecciona las fotos de tu celular o computador</li>
                                <li>El sistema las optimiza automáticamente</li>
                                <li>¡Listo!</li>
                            </ol>
                            <div class="highlight-box">
                                <strong>📸 Consejos para buenas fotos:</strong>
                                <ul>
                                    <li>Usa buena luz (natural es mejor)</li>
                                    <li>Fondo limpio y simple</li>
                                    <li>Muestra el producto desde varios ángulos</li>
                                    <li>Fotos claras y enfocadas</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq-products-3">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <span>¿Cómo registro una venta?</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </button>
                    <div id="faq-products-3" class="collapse">
                        <div class="faq-answer">
                            <p><strong>Súper fácil y rápido:</strong></p>
                            <ol>
                                <li>Ve a <strong>"Ventas Online"</strong> → <strong>"Nueva venta"</strong></li>
                                <li>Selecciona o crea el cliente</li>
                                <li>Añade productos (busca por nombre)</li>
                                <li>El sistema calcula el total automáticamente</li>
                                <li>Elige método de pago</li>
                                <li>¡Guarda la venta!</li>
                            </ol>
                            <p>El sistema genera automáticamente:</p>
                            <ul>
                                <li>Comprobante de venta</li>
                                <li>Historial del cliente</li>
                                <li>Reportes de ventas</li>
                                <li>Control de inventario</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagos -->
    <div class="col-12">
        <div class="faq-category card">
            <div class="category-header">
                <div class="d-flex align-items-center">
                    <div class="category-icon" style="background: linear-gradient(135deg, #dc3545, #c82333);">
                        <i class="bi bi-credit-card fs-4 text-white"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold">💳 Pagos y Wompi</h4>
                        <p class="mb-0 text-muted">Recibir pagos online de forma segura</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="faq-item">
                    <button class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq-payments-1">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <span>¿Qué es Wompi y para qué sirve?</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </button>
                    <div id="faq-payments-1" class="collapse">
                        <div class="faq-answer">
                            <p><strong>Wompi es una pasarela de pagos</strong> que te permite recibir pagos con tarjetas de crédito y débito directamente en tu sitio web.</p>
                            <p><strong>Con Wompi tus clientes pueden pagar:</strong></p>
                            <ul>
                                <li>Tarjetas de crédito (Visa, Mastercard, etc.)</li>
                                <li>Tarjetas débito</li>
                                <li>PSE (pagos desde bancos)</li>
                                <li>Nequi, Bancolombia a la Mano</li>
                            </ul>
                            <div class="highlight-box">
                                <strong>🔒 Seguridad:</strong> Wompi maneja todos los datos sensibles de las tarjetas. Tu sitio web nunca ve ni almacena información de tarjetas, ¡es totalmente seguro!
                            </div>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq-payments-2">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <span>¿Cómo me registro en Wompi?</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </button>
                    <div id="faq-payments-2" class="collapse">
                        <div class="faq-answer">
                            <p><strong>Proceso sencillo:</strong></p>
                            <ol>
                                <li>Ve a <a href="https://wompi.co" target="_blank">wompi.co</a> y crea tu cuenta</li>
                                <li>Completa la información de tu empresa</li>
                                <li>Sube los documentos requeridos (RUT, cédula, etc.)</li>
                                <li>Espera la aprobación (1-3 días hábiles)</li>
                                <li>¡Listo para recibir pagos!</li>
                            </ol>
                            <div class="highlight-box">
                                <strong>📄 Documentos necesarios:</strong> RUT, cédula del representante legal, certificación bancaria. Todo lo básico que ya tienes para tu negocio.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq-payments-3">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <span>¿Cuánto cobra Wompi por transacción?</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </button>
                    <div id="faq-payments-3" class="collapse">
                        <div class="faq-answer">
                            <p><strong>Tarifas competitivas de Wompi:</strong></p>
                            <ul>
                                <li><strong>Tarjetas crédito:</strong> 3.4% + $900 COP</li>
                                <li><strong>Tarjetas débito:</strong> 1.9% + $900 COP</li>
                                <li><strong>PSE:</strong> 1.9% + $900 COP</li>
                                <li><strong>Nequi:</strong> 1.9% + $900 COP</li>
                            </ul>
                            <p><strong>Ejemplo:</strong> Si vendes algo por $100.000 con tarjeta crédito, recibes $95.700 (descontando 3.4% + $900)</p>
                            <div class="highlight-box">
                                <strong>💰 Importante:</strong> No hay costos mensuales ni de mantenimiento. Solo pagas cuando recibes pagos. ¡Es un modelo justo!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Soporte y ayuda -->
    <div class="col-12">
        <div class="faq-category card">
            <div class="category-header">
                <div class="d-flex align-items-center">
                    <div class="category-icon" style="background: linear-gradient(135deg, #17a2b8, #138496);">
                        <i class="bi bi-headset fs-4 text-white"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold">🎧 Soporte y ayuda</h4>
                        <p class="mb-0 text-muted">Cuándo y cómo contactarnos</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="faq-item">
                    <button class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq-support-1">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <span>¿Cómo puedo contactar soporte?</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </button>
                    <div id="faq-support-1" class="collapse">
                        <div class="faq-answer">
                            <p><strong>Varias formas de contactarnos:</strong></p>
                            <ul>
                                <li><strong>WhatsApp:</strong> <a href="https://wa.me/{{ config('app.support.mobile') }}" target="_blank">{{ config('app.support.mobile') }}</a> (más rápido)</li>
                                <li><strong>Desde el sistema:</strong> Botón "Ayuda por WhatsApp" en el menú</li>
                                <li><strong>BBB Academy:</strong> Revisa las guías primero</li>
                                <li><strong>Este FAQ:</strong> Muchas respuestas están aquí</li>
                            </ul>
                            <div class="highlight-box">
                                <strong>🕐 Horarios de atención:</strong> Lunes a viernes de 8:00 AM a 6:00 PM. Sábados de 9:00 AM a 1:00 PM. Respondemos WhatsApp muy rápido.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq-support-2">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <span>¿Qué información debo enviar cuando pido ayuda?</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </button>
                    <div id="faq-support-2" class="collapse">
                        <div class="faq-answer">
                            <p><strong>Para ayudarte más rápido, comparte:</strong></p>
                            <ul>
                                <li><strong>Tu nombre y empresa</strong></li>
                                <li><strong>¿Qué intentabas hacer?</strong> (ej: "subir un producto")</li>
                                <li><strong>¿Qué pasó?</strong> (ej: "no me deja guardar")</li>
                                <li><strong>Pantallazos</strong> si es posible</li>
                                <li><strong>Desde qué dispositivo</strong> (celular, computador)</li>
                            </ul>
                            <div class="highlight-box">
                                <strong>📱 Tip:</strong> Los pantallazos nos ayudan muchísimo a entender el problema y darte una solución exacta.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq-support-3">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <span>¿Hacen capacitaciones personalizadas?</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </button>
                    <div id="faq-support-3" class="collapse">
                        <div class="faq-answer">
                            <p><strong>¡Sí, por supuesto!</strong> Ofrecemos:</p>
                            <ul>
                                <li><strong>Videollamada de configuración inicial</strong> - Te ayudamos a configurar todo paso a paso</li>
                                <li><strong>Capacitación de tu equipo</strong> - Si tienes empleados que van a usar el sistema</li>
                                <li><strong>Sesiones personalizadas</strong> - Para necesidades específicas de tu negocio</li>
                            </ul>
                            <p><strong>¿Cómo agendarla?</strong></p>
                            <p>Escríbenos por WhatsApp mencionando que quieres una capacitación personalizada. Coordinamos un horario que te funcione.</p>
                            <div class="highlight-box">
                                <strong>🎯 Resultado:</strong> Al final de la sesión tendrás tu sitio web completamente configurado y sabrás usar todas las funciones principales.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
    
    // Show/hide categories based on search results
    document.querySelectorAll('.faq-category').forEach(category => {
        const visibleItems = category.querySelectorAll('.faq-item:not([style*="none"])');
        if (visibleItems.length === 0) {
            category.style.display = 'none';
        } else {
            category.style.display = 'block';
        }
    });
});

// Auto-expand relevant sections when searching
$('#faqSearch').on('input', function() {
    const searchTerm = $(this).val().toLowerCase();
    
    if (searchTerm.length > 2) {
        // If there's a search term, expand matching items
        $('.faq-item').each(function() {
            const questionText = $(this).find('.faq-question span').text().toLowerCase();
            const answerText = $(this).find('.faq-answer').text().toLowerCase();
            
            if (questionText.includes(searchTerm) || answerText.includes(searchTerm)) {
                $(this).find('.collapse').addClass('show');
                $(this).find('.faq-question').attr('aria-expanded', 'true');
            }
        });
    } else {
        // If search is cleared, collapse all items
        $('.collapse').removeClass('show');
        $('.faq-question').attr('aria-expanded', 'false');
    }
});

// Enhanced search highlighting
function highlightSearchTerms(element, searchTerm) {
    if (!searchTerm || searchTerm.length < 2) {
        // Remove existing highlights
        element.innerHTML = element.innerHTML.replace(/<mark class="search-highlight">(.*?)<\/mark>/g, '$1');
        return;
    }
    
    const regex = new RegExp(`(${searchTerm})`, 'gi');
    element.innerHTML = element.innerHTML.replace(regex, '<mark class="search-highlight">$1</mark>');
}

// Smooth animations for expand/collapse
$('.faq-question').on('click', function() {
    const icon = $(this).find('.bi-chevron-down');
    const isExpanded = $(this).attr('aria-expanded') === 'true';
    
    if (isExpanded) {
        icon.css('transform', 'rotate(180deg)');
    } else {
        icon.css('transform', 'rotate(0deg)');
    }
});

// Initialize tooltips if any
$(document).ready(function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Add some nice animations on load
    $('.faq-category').each(function(index) {
        $(this).css('opacity', '0').css('transform', 'translateY(20px)');
        $(this).delay(index * 150).animate({
            opacity: 1
        }, 500, function() {
            $(this).css('transform', 'translateY(0)');
        });
    });
});
</script>
@endsection