@extends('layouts.dashboard')

@section('title', 'Ventas Online - BBB Academy')
@section('description', 'Aprende a registrar y gestionar tus ventas online, hacer seguimiento y generar reportes profesionales')

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
        background: linear-gradient(135deg, #6f42c1, #e83e8c);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
        margin: 0 auto 1rem;
    }
    
    .feature-box {
        background: linear-gradient(135deg, rgba(111, 66, 193, 0.1), rgba(232, 62, 140, 0.1));
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border-left: 4px solid #6f42c1;
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
    
    .success-box {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(32, 201, 151, 0.1));
        border-radius: 12px;
        padding: 1rem;
        border-left: 4px solid #28a745;
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
        background: rgba(111, 66, 193, 0.1);
        color: #6f42c1;
        text-decoration: none;
    }
    
    .progress-item.active {
        background: linear-gradient(135deg, rgba(111, 66, 193, 0.2), rgba(232, 62, 140, 0.2));
        color: #6f42c1;
        font-weight: 600;
    }
    
    .progress-item i {
        margin-right: 0.75rem;
        width: 20px;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="dashboard-title">
                <i class="bi bi-cart-check-fill me-3" style="color: #6f42c1;"></i>
                Ventas Online
            </h1>
            <p class="text-muted mb-0">Aprende a gestionar tus ventas y generar reportes profesionales</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.documentation.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver a Academy
            </a>
            <a href="{{ route('admin.ventas.index') }}" class="btn btn-purple" style="background: linear-gradient(135deg, #6f42c1, #e83e8c); border: none; color: white;">
                <i class="bi bi-cart-check me-2"></i>
                Ver mis ventas
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
                    <i class="bi bi-info-circle-fill fs-3" style="color: #6f42c1;"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-2">¿Por qué gestionar tus ventas online?</h4>
                    <p class="mb-3">Un control profesional de tus ventas te permite tomar mejores decisiones de negocio y brindar un servicio excepcional a tus clientes.</p>
                    <h5 class="fw-bold mb-3">¿Qué aprenderás en esta guía?</h5>
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Registrar ventas paso a paso
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Gestionar estados de pedidos
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Buscar clientes y productos
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Generar reportes de ventas
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Hacer seguimiento de ingresos
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Gestionar inventario automático
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="badge text-white mb-2" style="background: linear-gradient(135deg, #6f42c1, #e83e8c);">⏱️ 10 minutos</div>
                </div>
                <div class="col-md-6">
                    <div class="badge text-white" style="background: linear-gradient(135deg, #6f42c1, #e83e8c);">📚 Intermedio</div>
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
                <h4 class="text-center fw-bold mb-4">Acceder al Módulo de Ventas</h4>
                
                <p class="mb-3">Para empezar a gestionar tus ventas online:</p>
                
                <ol class="mb-4">
                    <li class="mb-2">En el menú lateral, busca la opción <strong>"Ventas Online"</strong></li>
                    <li class="mb-2">Haz clic para acceder al dashboard de ventas</li>
                    <li class="mb-2">Verás un resumen con:</li>
                    <ul class="mt-2">
                        <li>Total de ventas del mes</li>
                        <li>Pedidos pendientes</li>
                        <li>Productos más vendidos</li>
                        <li>Historial completo de transacciones</li>
                    </ul>
                </ol>

                <div class="tip-box">
                    <i class="bi bi-info-circle-fill text-info me-2"></i>
                    <strong>Tip:</strong> Las ventas automáticas desde tu tienda online aparecen automáticamente aquí. También puedes registrar ventas manuales.
                </div>
            </div>
        </div>

        <!-- Paso 2: Registrar una venta manual -->
        <div class="step-card card">
            <div class="card-body">
                <div class="step-number">2</div>
                <h4 class="text-center fw-bold mb-4">Registrar una Venta Manual</h4>
                
                <p class="mb-3">Si realizas una venta por fuera de tu tienda online (WhatsApp, llamada, etc.):</p>
                
                <ol class="mb-4">
                    <li class="mb-2">Haz clik en <strong>"+ Nueva Venta"</strong></li>
                    <li class="mb-2">El formulario incluye estos campos:</li>
                    <ul class="mt-2 mb-3">
                        <li><strong>Cliente:</strong> Busca o crea un cliente nuevo</li>
                        <li><strong>Productos:</strong> Añade los productos vendidos</li>
                        <li><strong>Cantidades:</strong> Especifica cuántos de cada producto</li>
                        <li><strong>Método de pago:</strong> Efectivo, transferencia, tarjeta, etc.</li>
                        <li><strong>Estado:</strong> Pendiente, confirmado, enviado, entregado</li>
                    </ul>
                    <li class="mb-2">Haz clik en <strong>"Guardar Venta"</strong></li>
                </ol>

                <div class="row">
                    <div class="col-md-6">
                        <div class="feature-box">
                            <h6 class="fw-bold mb-2">
                                <i class="bi bi-search text-purple me-2" style="color: #6f42c1;"></i>
                                Búsqueda Inteligente
                            </h6>
                            <p class="mb-0">Al escribir el nombre del cliente o producto, el sistema te muestra sugerencias automáticas para seleccionar rápidamente.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-box">
                            <h6 class="fw-bold mb-2">
                                <i class="bi bi-calculator text-purple me-2" style="color: #6f42c1;"></i>
                                Cálculo Automático
                            </h6>
                            <p class="mb-0">El total se calcula automáticamente multiplicando precio × cantidad para cada producto seleccionado.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paso 3: Gestionar estados de pedidos -->
        <div class="step-card card">
            <div class="card-body">
                <div class="step-number">3</div>
                <h4 class="text-center fw-bold mb-4">Gestionar Estados de Pedidos</h4>
                
                <p class="mb-3">Cada venta tiene un estado que puedes actualizar para llevar un control profesional:</p>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold">Estados Disponibles:</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <span class="status-badge bg-warning text-dark">Pendiente</span>
                                - Recién creada, esperando confirmación
                            </li>
                            <li class="mb-2">
                                <span class="status-badge bg-info text-white">Confirmada</span>
                                - Cliente confirmó el pedido
                            </li>
                            <li class="mb-2">
                                <span class="status-badge text-white" style="background: #6f42c1;">En proceso</span>
                                - Preparando el pedido
                            </li>
                            <li class="mb-2">
                                <span class="status-badge bg-primary text-white">Enviada</span>
                                - Pedido en camino al cliente
                            </li>
                            <li class="mb-2">
                                <span class="status-badge bg-success text-white">Entregada</span>
                                - Pedido completado exitosamente
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">Cómo Cambiar Estado:</h6>
                        <ol>
                            <li class="mb-2">Ve al listado de ventas</li>
                            <li class="mb-2">Busca la venta que quieres actualizar</li>
                            <li class="mb-2">Haz clic en <strong>"Cambiar Estado"</strong></li>
                            <li class="mb-2">Selecciona el nuevo estado</li>
                            <li class="mb-2">Confirma el cambio</li>
                        </ol>
                        
                        <div class="success-box">
                            <i class="bi bi-bell-fill text-success me-2"></i>
                            <strong>Automático:</strong> Al cambiar a "Confirmada", el stock se descuenta automáticamente.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paso 4: Reportes y análisis -->
        <div class="step-card card">
            <div class="card-body">
                <div class="step-number">4</div>
                <h4 class="text-center fw-bold mb-4">Reportes y Análisis de Ventas</h4>
                
                <p class="mb-3">El módulo de ventas te proporciona información valiosa para tu negocio:</p>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="feature-box text-center">
                            <i class="bi bi-graph-up-arrow fs-1 text-purple mb-2" style="color: #6f42c1;"></i>
                            <h6 class="fw-bold">Ingresos Totales</h6>
                            <p class="mb-0">Ve el total vendido por día, semana o mes</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-box text-center">
                            <i class="bi bi-trophy-fill fs-1 text-warning mb-2"></i>
                            <h6 class="fw-bold">Productos Top</h6>
                            <p class="mb-0">Identifica tus productos más vendidos</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-box text-center">
                            <i class="bi bi-people-fill fs-1 text-info mb-2"></i>
                            <h6 class="fw-bold">Mejores Clientes</h6>
                            <p class="mb-0">Descubre quiénes compran más</p>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold mt-4 mb-3">📊 Usar los Filtros:</h6>
                <ul class="mb-3">
                    <li><strong>Por fecha:</strong> Filtra ventas de hoy, esta semana, este mes o un rango personalizado</li>
                    <li><strong>Por estado:</strong> Ve solo pedidos pendientes, confirmados, etc.</li>
                    <li><strong>Por cliente:</strong> Busca todas las compras de un cliente específico</li>
                    <li><strong>Por producto:</strong> Ve todas las ventas de un producto particular</li>
                </ul>

                <div class="tip-box">
                    <i class="bi bi-lightbulb-fill text-info me-2"></i>
                    <strong>Consejo de negocio:</strong> Revisa estos reportes semanalmente para identificar tendencias y tomar mejores decisiones de inventario.
                </div>
            </div>
        </div>

        <!-- Paso 5: Integración con tienda online -->
        <div class="step-card card">
            <div class="card-body">
                <div class="step-number">5</div>
                <h4 class="text-center fw-bold mb-4">Integración con tu Tienda Online</h4>
                
                <p class="mb-3">Cuando tienes tu landing configurada con productos y pagos, las ventas fluyen automáticamente:</p>
                
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold">🛒 Ventas Automáticas</h6>
                        <ul class="mb-3">
                            <li>Los clientes compran desde tu landing</li>
                            <li>El pago se procesa automáticamente</li>
                            <li>La venta aparece aquí al instante</li>
                            <li>El stock se actualiza automáticamente</li>
                            <li>Recibes notificación por email</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">📱 Ventas por WhatsApp</h6>
                        <ul class="mb-3">
                            <li>Cliente te escribe por WhatsApp</li>
                            <li>Le envías el enlace de tu producto</li>
                            <li>Compra directamente desde el enlace</li>
                            <li>La venta se registra automáticamente</li>
                            <li>Puedes hacer seguimiento del pedido</li>
                        </ul>
                    </div>
                </div>

                <div class="warning-box">
                    <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                    <strong>Importante:</strong> Para que las ventas automáticas funcionen, debes tener configurados tus productos y la pasarela de pagos (Wompi).
                </div>

                <div class="success-box mt-3">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    <strong>¡Genial!</strong> Una vez configurado todo, puedes vender las 24 horas sin estar presente. Las ventas se registran automáticamente aquí.
                </div>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="d-flex gap-3 mb-4">
            <a href="{{ route('admin.ventas.create') }}" class="btn btn-lg flex-fill" style="background: linear-gradient(135deg, #6f42c1, #e83e8c); border: none; color: white;">
                <i class="bi bi-plus-circle-fill me-2"></i>
                Registrar Nueva Venta
            </a>
            <a href="{{ route('admin.ventas.index') }}" class="btn btn-outline-purple btn-lg flex-fill" style="border-color: #6f42c1; color: #6f42c1;">
                <i class="bi bi-list-ul me-2"></i>
                Ver Mis Ventas
            </a>
        </div>
    </div>

    <!-- Sidebar con progreso -->
    <div class="col-lg-4">
        <div class="progress-tracker">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-list-check text-purple me-2" style="color: #6f42c1;"></i>
                Progreso de la Guía
            </h6>
            <a href="#step1" class="progress-item">
                <i class="bi bi-1-circle"></i>
                Acceder al módulo
            </a>
            <a href="#step2" class="progress-item">
                <i class="bi bi-2-circle"></i>
                Registrar venta manual
            </a>
            <a href="#step3" class="progress-item">
                <i class="bi bi-3-circle"></i>
                Gestionar estados
            </a>
            <a href="#step4" class="progress-item">
                <i class="bi bi-4-circle"></i>
                Ver reportes
            </a>
            <a href="#step5" class="progress-item">
                <i class="bi bi-5-circle"></i>
                Integración automática
            </a>

            <hr>
            
            <div class="feature-box">
                <h6 class="fw-bold mb-2">
                    <i class="bi bi-rocket-takeoff text-purple me-2" style="color: #6f42c1;"></i>
                    Flujo Recomendado
                </h6>
                <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-success me-2">1</span>
                    <small>Configurar productos</small>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-warning me-2">2</span>
                    <small>Configurar pagos</small>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <span class="badge text-white me-2" style="background: #6f42c1;">3</span>
                    <small>¡Recibir ventas automáticas!</small>
                </div>
            </div>
            
            <h6 class="fw-bold mb-3 mt-4">
                <i class="bi bi-question-circle text-info me-2"></i>
                ¿Necesitas ayuda?
            </h6>
            <div class="d-flex gap-2">
                <a href="https://wa.me/{{ config('app.support.mobile') }}?text=Hola,%20necesito%20ayuda%20con%20ventas%20online" 
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