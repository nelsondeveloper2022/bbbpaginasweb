@extends('layouts.dashboard')

@section('title', 'Gestionar Productos - BBB Academy')
@section('description', 'Aprende a crear y administrar tu catálogo de productos con fotos, precios y descripciones atractivas')

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
        background: linear-gradient(135deg, #fd7e14, #ff6b35);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
        margin: 0 auto 1rem;
    }
    
    .feature-box {
        background: linear-gradient(135deg, rgba(253, 126, 20, 0.1), rgba(255, 107, 53, 0.1));
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border-left: 4px solid #fd7e14;
    }
    
    .tip-box {
        background: linear-gradient(135deg, rgba(23, 162, 184, 0.1), rgba(19, 132, 150, 0.1));
        border-radius: 12px;
        padding: 1rem;
        border-left: 4px solid #17a2b8;
    }
    
    .warning-box {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(200, 35, 51, 0.1));
        border-radius: 12px;
        padding: 1rem;
        border-left: 4px solid #dc3545;
    }
    
    .code-box {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
        border: 1px solid #e9ecef;
        font-family: 'Courier New', monospace;
    }
    
    .progress-tracker {
        position: sticky;
        top: 100px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        padding: 1.5rem;
    }
    
    .progress-item {
        display: flex;
        align-items: center;
        padding: 0.5rem 0;
        color: #6c757d;
        text-decoration: none;
        border-radius: 8px;
        padding-left: 1rem;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .progress-item:hover {
        background: rgba(253, 126, 20, 0.1);
        color: #fd7e14;
        text-decoration: none;
    }
    
    .progress-item.active {
        background: linear-gradient(135deg, rgba(253, 126, 20, 0.2), rgba(255, 107, 53, 0.2));
        color: #fd7e14;
        font-weight: 600;
    }
    
    .progress-item i {
        margin-right: 0.75rem;
        width: 20px;
    }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="dashboard-title">
                <i class="bi bi-box-seam-fill me-3 text-warning"></i>
                Gestionar Productos
            </h1>
            <p class="text-muted mb-0">Aprende a crear y administrar tu catálogo de productos paso a paso</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.documentation.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver a Academy
            </a>
            <a href="{{ route('admin.productos.index') }}" class="btn btn-warning">
                <i class="bi bi-box-seam me-2"></i>
                Ver mis productos
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Contenido principal -->
    <div class="col-lg-8">
        
<!-- Introducción -->
<div class="row mb-4">
    <div class="col-12">
        <div class="feature-box">
            <div class="d-flex align-items-start">
                <div class="me-3">
                    <i class="bi bi-info-circle-fill fs-3 text-warning"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-2">¿Por qué gestionar tus productos?</h4>
                    <p class="mb-3">Un catálogo bien organizado con productos atractivos es la clave para aumentar tus ventas online.</p>
                    <h5 class="fw-bold mb-3">¿Qué aprenderás en esta guía?</h5>
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Crear productos desde cero
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Subir y optimizar imágenes
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Configurar precios y stock
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Escribir descripciones atractivas
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Organizar tu catálogo
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Editar y actualizar productos
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="badge bg-warning text-dark mb-2">⏱️ 7 minutos</div>
                </div>
                <div class="col-md-6">
                    <div class="badge bg-success">📚 Nivel básico</div>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Paso 1: Acceder al módulo -->
        <div class="step-card card">
            <div class="card-body">
                <div class="step-number">1</div>
                <h4 class="text-center fw-bold mb-4">Acceder al Módulo de Productos</h4>
                
                <p class="mb-3">Para empezar a gestionar tus productos, dirígete al módulo correspondiente:</p>
                
                <ol class="mb-4">
                    <li class="mb-2">En el menú lateral, busca la opción <strong>"Productos"</strong></li>
                    <li class="mb-2">Haz clic para acceder al listado de productos</li>
                    <li class="mb-2">Verás una tabla con todos tus productos actuales (vacía si es la primera vez)</li>
                </ol>

                <div class="tip-box">
                    <i class="bi bi-info-circle-fill text-info me-2"></i>
                    <strong>Tip:</strong> También puedes acceder desde el botón "Mis productos" en esta misma guía.
                </div>
            </div>
        </div>

        <!-- Paso 2: Crear un nuevo producto -->
        <div class="step-card card">
            <div class="card-body">
                <div class="step-number">2</div>
                <h4 class="text-center fw-bold mb-4">Crear un Nuevo Producto</h4>
                
                <p class="mb-3">Una vez en el módulo de productos, sigue estos pasos:</p>
                
                <ol class="mb-4">
                    <li class="mb-2">Haz clic en el botón <strong>"+ Nuevo Producto"</strong></li>
                    <li class="mb-2">Se abrirá un formulario con los siguientes campos principales:</li>
                    <ul class="mt-2 mb-3">
                        <li><strong>Nombre del producto:</strong> Título claro y descriptivo</li>
                        <li><strong>Descripción:</strong> Detalles del producto</li>
                        <li><strong>Precio:</strong> Valor de venta</li>
                        <li><strong>Stock:</strong> Cantidad disponible</li>
                        <li><strong>Imágenes:</strong> Fotos del producto</li>
                    </ul>
                </ol>

                <div class="feature-box">
                    <h6 class="fw-bold mb-2">
                        <i class="bi bi-camera-fill text-warning me-2"></i>
                        Consejos para las imágenes:
                    </h6>
                    <ul class="mb-0">
                        <li>Usa fotos con buena iluminación</li>
                        <li>Tamaño recomendado: 800x800 pixels</li>
                        <li>Formatos admitidos: JPG, PNG, WEBP</li>
                        <li>Máximo 5 imágenes por producto</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Paso 3: Completar información del producto -->
        <div class="step-card card">
            <div class="card-body">
                <div class="step-number">3</div>
                <h4 class="text-center fw-bold mb-4">Completar la Información</h4>
                
                <p class="mb-3">Llena cada campo con información atractiva y precisa:</p>
                
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold">📝 Nombre del Producto</h6>
                        <ul class="mb-3">
                            <li>Sé descriptivo y específico</li>
                            <li>Incluye características principales</li>
                            <li>Evita palabras innecesarias</li>
                        </ul>
                        <div class="code-box mb-3">
                            <strong>Ejemplo:</strong><br>
                            ❌ "Producto bonito"<br>
                            ✅ "Camiseta Polo Azul Talla M"
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">💰 Precio</h6>
                        <ul class="mb-3">
                            <li>Incluye solo números</li>
                            <li>No escribas el símbolo "$"</li>
                            <li>Usa punto para decimales</li>
                        </ul>
                        <div class="code-box mb-3">
                            <strong>Ejemplo:</strong><br>
                            ❌ "$25,000"<br>
                            ✅ "25000" o "25000.50"
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold">📋 Descripción del Producto</h6>
                <p>Escribe una descripción que venda tu producto:</p>
                <ul class="mb-3">
                    <li>Menciona beneficios, no solo características</li>
                    <li>Usa viñetas para información clave</li>
                    <li>Incluye materiales, tallas, colores disponibles</li>
                    <li>Añade información de cuidado o garantía</li>
                </ul>

                <div class="tip-box">
                    <i class="bi bi-lightbulb-fill text-info me-2"></i>
                    <strong>Tip:</strong> Una buena descripción puede aumentar tus ventas hasta un 30%.
                </div>
            </div>
        </div>

        <!-- Paso 4: Gestionar el catálogo -->
        <div class="step-card card">
            <div class="card-body">
                <div class="step-number">4</div>
                <h4 class="text-center fw-bold mb-4">Gestionar tu Catálogo</h4>
                
                <p class="mb-3">Una vez creados tus productos, puedes administrarlos fácilmente:</p>
                
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold">✏️ Editar Productos</h6>
                        <ul class="mb-3">
                            <li>Haz clic en el ícono de editar (lápiz)</li>
                            <li>Modifica cualquier información</li>
                            <li>Añade o quita imágenes</li>
                            <li>Actualiza precios y stock</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">👁️ Ver Detalles</h6>
                        <ul class="mb-3">
                            <li>Haz clic en el ícono del ojo</li>
                            <li>Ve cómo se muestra tu producto</li>
                            <li>Revisa que todo se vea bien</li>
                            <li>Comparte el enlace si es necesario</li>
                        </ul>
                    </div>
                </div>

                <div class="warning-box">
                    <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                    <strong>Importante:</strong> Al eliminar un producto, se quitará de tu tienda online automáticamente. Esta acción no se puede deshacer.
                </div>
            </div>
        </div>

        <!-- Paso 5: Optimización y mejores prácticas -->
        <div class="step-card card">
            <div class="card-body">
                <div class="step-number">5</div>
                <h4 class="text-center fw-bold mb-4">Optimización y Mejores Prácticas</h4>
                
                <div class="row">
                    <div class="col-12">
                        <h6 class="fw-bold mb-3">🚀 Tips para Aumentar Ventas:</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="feature-box">
                                    <h6 class="fw-bold">📸 Imágenes de Calidad</h6>
                                    <ul class="mb-0">
                                        <li>Usa múltiples ángulos</li>
                                        <li>Muestra el producto en uso</li>
                                        <li>Fondo limpio y neutro</li>
                                        <li>Buena iluminación natural</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-box">
                                    <h6 class="fw-bold">💡 Descripciones Efectivas</h6>
                                    <ul class="mb-0">
                                        <li>Escribe para tu cliente ideal</li>
                                        <li>Resuelve sus dudas principales</li>
                                        <li>Usa palabras que generen emoción</li>
                                        <li>Incluye llamadas a la acción</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tip-box mt-3">
                    <i class="bi bi-graph-up-arrow text-info me-2"></i>
                    <strong>Dato importante:</strong> Los productos con 3 o más imágenes de calidad tienen 40% más probabilidades de ser comprados.
                </div>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="d-flex gap-3 mb-4">
            <a href="{{ route('admin.productos.create') }}" class="btn btn-warning btn-lg flex-fill">
                <i class="bi bi-plus-circle-fill me-2"></i>
                Crear Mi Primer Producto
            </a>
            <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-warning btn-lg flex-fill">
                <i class="bi bi-list-ul me-2"></i>
                Ver Mis Productos
            </a>
        </div>
    </div>

    <!-- Sidebar con progreso -->
    <div class="col-lg-4">
        <div class="progress-tracker">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-list-check text-warning me-2"></i>
                Progreso de la Guía
            </h6>
            <a href="#step1" class="progress-item">
                <i class="bi bi-1-circle"></i>
                Acceder al módulo
            </a>
            <a href="#step2" class="progress-item">
                <i class="bi bi-2-circle"></i>
                Crear nuevo producto
            </a>
            <a href="#step3" class="progress-item">
                <i class="bi bi-3-circle"></i>
                Completar información
            </a>
            <a href="#step4" class="progress-item">
                <i class="bi bi-4-circle"></i>
                Gestionar catálogo
            </a>
            <a href="#step5" class="progress-item">
                <i class="bi bi-5-circle"></i>
                Optimizar productos
            </a>

            <hr>
            
            <h6 class="fw-bold mb-3">
                <i class="bi bi-question-circle text-info me-2"></i>
                ¿Necesitas ayuda?
            </h6>
            <div class="d-flex gap-2">
                <a href="https://wa.me/{{ config('app.support.mobile') }}?text=Hola,%20necesito%20ayuda%20con%20productos" 
                   target="_blank" class="btn btn-success btn-sm flex-fill">
                    <i class="bi bi-whatsapp me-1"></i>
                    WhatsApp
                </a>
                <a href="{{ route('admin.documentation.faq') }}" class="btn btn-outline-info btn-sm flex-fill">
                    <i class="bi bi-chat-square-dots me-1"></i>
                    FAQ
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Auto scroll y highlight de secciones
    $('.progress-item').click(function(e) {
        e.preventDefault();
        $('.progress-item').removeClass('active');
        $(this).addClass('active');
        
        let target = $(this).attr('href');
        let stepNumber = target.replace('#step', '');
        let stepCard = $('.step-card').eq(stepNumber - 1);
        
        if (stepCard.length) {
            $('html, body').animate({
                scrollTop: stepCard.offset().top - 100
            }, 800);
        }
    });

    // Highlight automático según scroll
    $(window).scroll(function() {
        let scrollPos = $(window).scrollTop() + 150;
        
        $('.step-card').each(function(index) {
            let top = $(this).offset().top;
            let bottom = top + $(this).outerHeight();
            
            if (scrollPos >= top && scrollPos <= bottom) {
                $('.progress-item').removeClass('active');
                $('.progress-item').eq(index).addClass('active');
            }
        });
    });

    // Animación de entrada para las cards
    $('.step-card').each(function(index) {
        $(this).css({
            'opacity': '0',
            'transform': 'translateY(50px)'
        }).delay(index * 200).animate({
            'opacity': '1'
        }, 600, function() {
            $(this).css('transform', 'translateY(0)');
        });
    });
});
</script>
@endpush

@endsection