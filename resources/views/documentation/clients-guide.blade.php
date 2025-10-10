@extends('layouts.dashboard')

@section('title', 'Gestionar Clientes - BBB Academy')
@section('description', 'Aprende a registrar y organizar la información de tus clientes de forma fácil y profesional')

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
        background: linear-gradient(135deg, #28a745, #20c997);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
        margin: 0 auto 1rem;
    }
    
    .feature-box {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(32, 201, 151, 0.1));
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border-left: 4px solid #28a745;
    }
    
    .tip-box {
        background: linear-gradient(135deg, rgba(23, 162, 184, 0.1), rgba(19, 132, 150, 0.1));
        border-radius: 12px;
        padding: 1rem;
        border-left: 4px solid #17a2b8;
    }
    
    .warning-box {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(253, 126, 20, 0.1));
        border-radius: 12px;
        padding: 1rem;
        border-left: 4px solid #ffc107;
    }
    
    .client-card-example {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="content-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="dashboard-title">
                <i class="bi bi-people-fill me-3 text-success"></i>
                Gestionar Clientes
            </h1>
            <p class="text-muted mb-0">Organiza la información de tus clientes de forma profesional</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.documentation.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver a Academy
            </a>
            <a href="{{ route('admin.clientes.index') }}" class="btn btn-success">
                <i class="bi bi-people me-2"></i>
                Ver mis clientes
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
                    <i class="bi bi-info-circle-fill fs-3 text-success"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-2">¿Por qué gestionar tus clientes?</h4>
                    <p class="mb-2">Tener una base de datos organizada de tus clientes te ayuda a:</p>
                    <ul class="mb-0">
                        <li><strong>Crear ventas rápidamente</strong> - No tienes que escribir los datos cada vez</li>
                        <li><strong>Dar mejor servicio</strong> - Sabes el historial de cada cliente</li>
                        <li><strong>Hacer seguimiento</strong> - Puedes contactar clientes anteriores</li>
                        <li><strong>Generar reportes</strong> - Ve quién compra más y con qué frecuencia</li>
                        <li><strong>Verse profesional</strong> - Los datos organizados generan confianza</li>
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
                        <h5 class="fw-bold mb-3">Información esencial del cliente</h5>
                        <p class="text-muted mb-3">Estos son los datos mínimos que necesitas para crear un cliente:</p>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <h6><i class="bi bi-person text-success me-2"></i>Nombre completo</h6>
                                <p class="text-muted mb-0">Como aparece en su documento de identidad. Ejemplo: "María José García López"</p>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="bi bi-telephone text-success me-2"></i>Teléfono</h6>
                                <p class="text-muted mb-0">Número principal donde lo puedes contactar. Incluye código de país si es internacional.</p>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="bi bi-envelope text-success me-2"></i>Email (opcional)</h6>
                                <p class="text-muted mb-0">Para enviar confirmaciones de pedidos y promociones.</p>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="bi bi-card-text text-success me-2"></i>Documento (opcional)</h6>
                                <p class="text-muted mb-0">Cédula o RUT para facturación. Útil para reportes oficiales.</p>
                            </div>
                        </div>
                        
                        <div class="tip-box">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-lightbulb-fill text-info me-2 mt-1"></i>
                                <div>
                                    <strong>💡 Tip:</strong> El nombre y teléfono son obligatorios. El resto de información puedes añadirla después si la consigues.
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
                        <h6 class="fw-bold">Dirección</h6>
                    </div>
                    <div class="col-lg-10">
                        <h5 class="fw-bold mb-3">Información de ubicación</h5>
                        <p class="text-muted mb-3">Fundamental si haces entregas a domicilio o necesitas enviar productos:</p>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-12">
                                <h6><i class="bi bi-geo-alt text-success me-2"></i>Dirección completa</h6>
                                <p class="text-muted mb-2">Incluye todos los detalles necesarios para encontrar el lugar:</p>
                                <div class="bg-light p-3 rounded">
                                    <strong>Ejemplo completo:</strong><br>
                                    "Calle 45 #23-67, Apartamento 301, Edificio Torres del Norte, Barrio El Prado, Medellín, Antioquia. Punto de referencia: frente al supermercado Éxito"
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="bi bi-building text-success me-2"></i>Ciudad</h6>
                                <p class="text-muted mb-0">Ciudad principal donde vive el cliente</p>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="bi bi-signpost text-success me-2"></i>Barrio/Zona</h6>
                                <p class="text-muted mb-0">Para organizar rutas de entrega y calcular costos</p>
                            </div>
                        </div>
                        
                        <div class="warning-box">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-exclamation-triangle-fill text-warning me-2 mt-1"></i>
                                <div>
                                    <strong>⚠️ Importante:</strong> Si haces entregas, verifica siempre la dirección con el cliente antes de salir. Una dirección incorrecta puede costar tiempo y dinero.
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
                        <h6 class="fw-bold">Organización</h6>
                    </div>
                    <div class="col-lg-10">
                        <h5 class="fw-bold mb-3">Cómo organizar tu lista de clientes</h5>
                        <p class="text-muted mb-3">Una vez que tengas varios clientes, es importante mantenerlos organizados:</p>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="client-card-example">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="me-3">
                                            <div style="width: 40px; height: 40px; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-person text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">María García</h6>
                                            <small class="text-muted">Cliente frecuente</small>
                                        </div>
                                    </div>
                                    <p class="text-muted small mb-1"><i class="bi bi-telephone me-1"></i> +57 300 123 4567</p>
                                    <p class="text-muted small mb-1"><i class="bi bi-geo-alt me-1"></i> Medellín, El Prado</p>
                                    <p class="text-muted small mb-0"><i class="bi bi-cart me-1"></i> Última compra: hace 3 días</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="bi bi-search text-success me-2"></i>Búsqueda rápida</h6>
                                <p class="text-muted mb-2">Puedes buscar clientes por:</p>
                                <ul class="text-muted small">
                                    <li>Nombre completo o parcial</li>
                                    <li>Número de teléfono</li>
                                    <li>Ciudad o barrio</li>
                                    <li>Email</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="tip-box">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-lightbulb-fill text-info me-2 mt-1"></i>
                                <div>
                                    <strong>💡 Consejo:</strong> Cuando registres un cliente nuevo durante una venta, puedes guardar su información y crear la venta al mismo tiempo. ¡Es súper rápido!
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
                        <h6 class="fw-bold">Historial</h6>
                    </div>
                    <div class="col-lg-10">
                        <h5 class="fw-bold mb-3">Ver el historial de compras</h5>
                        <p class="text-muted mb-3">Cada cliente tiene un historial automático que te ayuda a dar mejor servicio:</p>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-12">
                                <h6><i class="bi bi-clock-history text-success me-2"></i>¿Qué puedes ver?</h6>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <ul class="text-muted">
                                            <li>Todas las compras que ha hecho</li>
                                            <li>Fecha de cada compra</li>
                                            <li>Productos que más compra</li>
                                            <li>Total gastado hasta ahora</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="text-muted">
                                            <li>Frecuencia de compra</li>
                                            <li>Método de pago preferido</li>
                                            <li>Dirección de entrega habitual</li>
                                            <li>Estado de pagos</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="feature-box bg-light border">
                            <h6><i class="bi bi-star text-warning me-2"></i>Ventajas del historial:</h6>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <p class="text-muted small mb-1">✅ <strong>Ventas más rápidas:</strong> "¿Lo mismo de siempre?"</p>
                                    <p class="text-muted small mb-1">✅ <strong>Mejor servicio:</strong> Conoces sus preferencias</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted small mb-1">✅ <strong>Ofertas personalizadas:</strong> Productos que le interesan</p>
                                    <p class="text-muted small mb-1">✅ <strong>Cobro eficiente:</strong> Sabes si debe algo</p>
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
                        <h6 class="fw-bold">Tips Avanzados</h6>
                    </div>
                    <div class="col-lg-10">
                        <h5 class="fw-bold mb-3">Consejos para sacar el máximo provecho</h5>
                        <p class="text-muted mb-3">Una vez que domines lo básico, estos tips te ayudarán a ser más eficiente:</p>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <h6><i class="bi bi-lightning text-warning me-2"></i>Registro rápido</h6>
                                    <p class="text-muted small mb-0">Durante una venta, si el cliente no está registrado, puedes crearlo directamente desde el formulario de venta. Los datos se guardan automáticamente.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <h6><i class="bi bi-phone text-info me-2"></i>WhatsApp directo</h6>
                                    <p class="text-muted small mb-0">Desde la lista de clientes puedes enviar mensajes directamente a WhatsApp con un clic. Perfecto para promociones o recordatorios.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <h6><i class="bi bi-pencil text-success me-2"></i>Actualización fácil</h6>
                                    <p class="text-muted small mb-0">Si un cliente se muda o cambia de teléfono, puedes editar su información desde su perfil. Los cambios se aplican a todas las ventas futuras.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <h6><i class="bi bi-shield-check text-primary me-2"></i>Datos seguros</h6>
                                    <p class="text-muted small mb-0">Toda la información está protegida y solo tu empresa puede verla. Cumplimos con las normas de protección de datos.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de acción -->
        <div class="text-center mb-4">
            <div class="d-flex gap-3 justify-content-center">
                <a href="{{ route('admin.clientes.create') }}" class="btn btn-success btn-lg px-4">
                    <i class="bi bi-person-plus me-2"></i>
                    Registrar mi primer cliente
                </a>
                <a href="{{ route('admin.clientes.index') }}" class="btn btn-outline-success btn-lg px-4">
                    <i class="bi bi-list me-2"></i>
                    Ver lista de clientes
                </a>
            </div>
            <p class="text-muted mt-2">Registrar un cliente toma menos de 2 minutos</p>
        </div>

        <!-- FAQ específico de clientes -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-question-circle me-2"></i>Preguntas frecuentes sobre clientes</h5>
            </div>
            <div class="card-body">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                ¿Puedo importar clientes de una lista de Excel?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Actualmente debes registrar los clientes uno por uno, pero es muy rápido. Estamos trabajando en una función de importación masiva para próximas versiones.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                ¿Qué pasa si registro mal los datos de un cliente?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Puedes editar cualquier información del cliente cuando quieras. Ve a la lista de clientes, busca el cliente y haz clic en "Editar". Los cambios no afectan las ventas ya realizadas.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                ¿Cuántos clientes puedo registrar?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                No hay límite en la cantidad de clientes que puedes registrar. Tu plan actual te permite registrar todos los clientes que necesites.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                ¿Los clientes pueden ver su información?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                No, esta información es privada de tu empresa. Los clientes no tienen acceso a tu sistema de gestión. Solo tú y los usuarios autorizados de tu empresa pueden ver estos datos.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection