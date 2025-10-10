@extends('layouts.dashboard')

@section('title', 'Configurar Pagos - BBB Academy')
@section('description', 'Aprende a configurar Wompi y recibir pagos automáticos de forma segura y confiable en tu tienda online')

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
        background: linear-gradient(135deg, #dc3545, #c82333);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
        margin: 0 auto 1rem;
    }
    
    .feature-box {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(200, 35, 51, 0.1));
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border-left: 4px solid #dc3545;
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
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        text-decoration: none;
    }
    
    .progress-item.active {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.2), rgba(200, 35, 51, 0.2));
        color: #dc3545;
        font-weight: 600;
    }
    
    .progress-item i {
        margin-right: 0.75rem;
        width: 20px;
    }

    .wompi-logo {
        background: linear-gradient(135deg, #6c5ce7, #a29bfe);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        display: inline-block;
        font-weight: bold;
    }

    .security-feature {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(32, 201, 151, 0.1));
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 2px solid rgba(40, 167, 69, 0.2);
    }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="dashboard-title">
                <i class="bi bi-credit-card-2-back-fill me-3 text-danger"></i>
                Configurar Pagos con Wompi
            </h1>
            <p class="text-muted mb-0">Aprende a configurar pagos seguros y automáticos para tu tienda online</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.documentation.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Volver a Academy
            </a>
            <a href="{{ route('admin.pagos.index') }}" class="btn btn-danger">
                <i class="bi bi-credit-card me-2"></i>
                Configurar pagos
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
                    <i class="bi bi-info-circle-fill fs-3 text-danger"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-2">¿Por qué configurar pagos online?</h4>
                    <p class="mb-3">Sin pagos configurados, tus clientes no podrán completar compras. Wompi te permite recibir pagos seguros las 24 horas del día.</p>
                    <h5 class="fw-bold mb-3">¿Qué aprenderás en esta guía?</h5>
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Qué es Wompi y por qué usarlo
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Crear cuenta en Wompi
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Obtener credenciales API
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Configurar Wompi en BBB
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Probar pagos de prueba
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Activar pagos en producción
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="badge bg-danger mb-2">⏱️ 8 minutos</div>
                </div>
                <div class="col-md-6">
                    <div class="badge bg-warning text-dark">🔐 Esencial</div>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- ¿Qué es Wompi? -->
        <div class="step-card card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="wompi-logo d-inline-block">
                        <i class="bi bi-credit-card-2-front-fill me-2"></i>
                        WOMPI
                    </div>
                </div>
                <h4 class="text-center fw-bold mb-4">¿Qué es Wompi y por qué es perfecto para ti?</h4>
                
                <p class="mb-3">Wompi es la pasarela de pagos más popular de Colombia, diseñada especialmente para pequeños y medianos negocios como el tuyo.</p>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="security-feature">
                            <h6 class="fw-bold mb-2">
                                <i class="bi bi-shield-fill-check text-success me-2"></i>
                                100% Seguro
                            </h6>
                            <ul class="mb-0">
                                <li>Certificado PCI DSS</li>
                                <li>Encriptación de datos</li>
                                <li>Protección antifraude</li>
                                <li>Cumple normativas bancarias</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="security-feature">
                            <h6 class="fw-bold mb-2">
                                <i class="bi bi-lightning-charge-fill text-warning me-2"></i>
                                Súper Fácil
                            </h6>
                            <ul class="mb-0">
                                <li>Integración en 5 minutos</li>
                                <li>No necesitas conocimientos técnicos</li>
                                <li>Interfaz simple e intuitiva</li>
                                <li>Soporte en español 24/7</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4 text-center">
                        <div class="feature-box">
                            <i class="bi bi-credit-card fs-1 text-primary mb-2"></i>
                            <h6 class="fw-bold">Tarjetas</h6>
                            <small>Visa, Mastercard, American Express</small>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="feature-box">
                            <i class="bi bi-phone fs-1 text-success mb-2"></i>
                            <h6 class="fw-bold">PSE</h6>
                            <small>Débito directo desde el banco</small>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="feature-box">
                            <i class="bi bi-wallet2 fs-1 text-info mb-2"></i>
                            <h6 class="fw-bold">Nequi</h6>
                            <small>Pago desde la app móvil</small>
                        </div>
                    </div>
                </div>

                <div class="tip-box mt-3">
                    <i class="bi bi-info-circle-fill text-info me-2"></i>
                    <strong>¿Cuánto cuesta?</strong> Wompi cobra solo una pequeña comisión por transacción exitosa (no por transacciones fallidas). Sin mensualidades ni costos ocultos.
                </div>
            </div>
        </div>

        <!-- Paso 1: Crear cuenta en Wompi -->
        <div class="step-card card">
            <div class="card-body">
                <div class="step-number">1</div>
                <h4 class="text-center fw-bold mb-4">Crear tu Cuenta en Wompi</h4>
                
                <p class="mb-3">Primero necesitas registrarte en Wompi para obtener tus credenciales:</p>
                
                <ol class="mb-4">
                    <li class="mb-2">Ve a <a href="https://wompi.co" target="_blank" class="fw-bold">wompi.co</a></li>
                    <li class="mb-2">Haz clic en <strong>"Regístrate gratis"</strong></li>
                    <li class="mb-2">Completa el formulario con tu información:</li>
                    <ul class="mt-2 mb-3">
                        <li><strong>Nombre completo</strong></li>
                        <li><strong>Email</strong> (usa el mismo de tu cuenta BBB)</li>
                        <li><strong>Teléfono</strong></li>
                        <li><strong>Tipo de negocio</strong></li>
                        <li><strong>Información de la empresa</strong></li>
                    </ul>
                    <li class="mb-2">Verifica tu email</li>
                    <li class="mb-2">Completa el proceso de verificación de identidad</li>
                </ol>

                <div class="warning-box">
                    <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                    <strong>Importante:</strong> El proceso de verificación puede tomar de 1 a 3 días hábiles. Mientras tanto, puedes usar el modo de pruebas.
                </div>

                <div class="success-box mt-3">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    <strong>¡Perfecto!</strong> Una vez aprobada tu cuenta, podrás recibir pagos reales de tus clientes.
                </div>
            </div>
        </div>

        <!-- Paso 2: Obtener credenciales -->
        <div class="step-card card">
            <div class="card-body">
                <div class="step-number">2</div>
                <h4 class="text-center fw-bold mb-4">Obtener tus Credenciales de API</h4>
                
                <p class="mb-3">Las credenciales son como las "llaves" que permiten conectar Wompi con tu tienda BBB:</p>
                
                <ol class="mb-4">
                    <li class="mb-2">Inicia sesión en tu dashboard de Wompi</li>
                    <li class="mb-2">Ve a la sección <strong>"Configuración"</strong> o <strong>"API"</strong></li>
                    <li class="mb-2">Busca las siguientes credenciales:</li>
                    <ul class="mt-2 mb-3">
                        <li><strong>Public Key (Clave Pública):</strong> Empieza con "pub_"</li>
                        <li><strong>Private Key (Clave Privada):</strong> Empieza con "prv_"</li>
                        <li><strong>Integrity Secret:</strong> Para verificar webhooks</li>
                    </ul>
                    <li class="mb-2">Copia cada credencial en un lugar seguro</li>
                </ol>

                <div class="row">
                    <div class="col-md-6">
                        <div class="code-box">
                            <strong>Ejemplo de Public Key:</strong><br>
                            <code>pub_stagtest_G8LfGt...</code>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="code-box">
                            <strong>Ejemplo de Private Key:</strong><br>
                            <code>prv_stagtest_bN5Rf2...</code>
                        </div>
                    </div>
                </div>

                <div class="tip-box mt-3">
                    <i class="bi bi-lightbulb-fill text-info me-2"></i>
                    <strong>Consejo:</strong> Wompi te da credenciales de "test" (prueba) y "prod" (producción). Empieza siempre con las de prueba para hacer tests.
                </div>
            </div>
        </div>

        <!-- Paso 3: Configurar en BBB -->
        <div class="step-card card">
            <div class="card-body">
                <div class="step-number">3</div>
                <h4 class="text-center fw-bold mb-4">Configurar Wompi en BBB</h4>
                
                <p class="mb-3">Ahora vamos a conectar tu cuenta Wompi con tu tienda BBB:</p>
                
                <ol class="mb-4">
                    <li class="mb-2">En BBB, ve al módulo <strong>"Configuración de Pagos"</strong></li>
                    <li class="mb-2">Busca la sección <strong>"Wompi"</strong></li>
                    <li class="mb-2">Completa los siguientes campos:</li>
                    <ul class="mt-2 mb-3">
                        <li><strong>Public Key:</strong> Pega tu clave pública</li>
                        <li><strong>Private Key:</strong> Pega tu clave privada</li>
                        <li><strong>Integrity Secret:</strong> Pega tu secret</li>
                        <li><strong>Modo:</strong> Selecciona "Test" o "Producción"</li>
                    </ul>
                    <li class="mb-2">Haz clic en <strong>"Guardar Configuración"</strong></li>
                    <li class="mb-2">Activa Wompi con el interruptor</li>
                </ol>

                <div class="warning-box">
                    <i class="bi bi-shield-exclamation text-warning me-2"></i>
                    <strong>Seguridad:</strong> Nunca compartas tus claves privadas. Guárdalas solo en BBB y en un lugar seguro como respaldo.
                </div>
            </div>
        </div>

        <!-- Paso 4: Probar pagos -->
        <div class="step-card card">
            <div class="card-body">
                <div class="step-number">4</div>
                <h4 class="text-center fw-bold mb-4">Probar tus Pagos (Modo Test)</h4>
                
                <p class="mb-3">Antes de recibir pagos reales, es importante probar que todo funcione correctamente:</p>
                
                <ol class="mb-4">
                    <li class="mb-2">Asegúrate de estar en modo <strong>"Test"</strong></li>
                    <li class="mb-2">Ve a tu tienda online (tu landing)</li>
                    <li class="mb-2">Añade un producto al carrito</li>
                    <li class="mb-2">Procede al checkout</li>
                    <li class="mb-2">Usa estas tarjetas de prueba:</li>
                </ol>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="code-box">
                            <strong>Tarjeta de Prueba (Exitosa):</strong><br>
                            <strong>Número:</strong> 4242 4242 4242 4242<br>
                            <strong>CVV:</strong> 123<br>
                            <strong>Vencimiento:</strong> 12/25<br>
                            <strong>Resultado:</strong> ✅ Pago exitoso
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="code-box">
                            <strong>Tarjeta de Prueba (Fallida):</strong><br>
                            <strong>Número:</strong> 4000 0000 0000 0002<br>
                            <strong>CVV:</strong> 123<br>
                            <strong>Vencimiento:</strong> 12/25<br>
                            <strong>Resultado:</strong> ❌ Pago rechazado
                        </div>
                    </div>
                </div>

                <div class="success-box">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    <strong>¡Excelente!</strong> Si el pago de prueba funciona, verás la transacción en tu módulo de ventas y recibirás un email de confirmación.
                </div>
            </div>
        </div>

        <!-- Paso 5: Activar producción -->
        <div class="step-card card">
            <div class="card-body">
                <div class="step-number">5</div>
                <h4 class="text-center fw-bold mb-4">Activar Pagos en Producción</h4>
                
                <p class="mb-3">Una vez que Wompi apruebe tu cuenta y hayas probado todo, activa los pagos reales:</p>
                
                <ol class="mb-4">
                    <li class="mb-2">Espera la aprobación de Wompi (1-3 días hábiles)</li>
                    <li class="mb-2">En Wompi, obtén tus credenciales de <strong>"Producción"</strong></li>
                    <li class="mb-2">En BBB, actualiza la configuración:</li>
                    <ul class="mt-2 mb-3">
                        <li>Cambia las claves por las de producción</li>
                        <li>Cambia el modo a <strong>"Producción"</strong></li>
                        <li>Guarda los cambios</li>
                    </ul>
                    <li class="mb-2">¡Haz una compra real para verificar!</li>
                </ol>

                <div class="feature-box">
                    <h6 class="fw-bold mb-2">
                        <i class="bi bi-rocket-takeoff text-danger me-2"></i>
                        ¡Ya estás listo para vender!
                    </h6>
                    <p class="mb-2">Con Wompi configurado, tus clientes podrán:</p>
                    <ul class="mb-0">
                        <li>Comprar 24/7 desde tu tienda online</li>
                        <li>Pagar con tarjeta, PSE o Nequi</li>
                        <li>Recibir confirmación inmediata</li>
                        <li>Tu inventario se actualiza automáticamente</li>
                        <li>Recibes notificaciones de cada venta</li>
                    </ul>
                </div>

                <div class="tip-box">
                    <i class="bi bi-graph-up-arrow text-info me-2"></i>
                    <strong>Dato interesante:</strong> Los negocios que aceptan pagos online venden en promedio 3x más que los que solo aceptan efectivo.
                </div>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="d-flex gap-3 mb-4">
            <a href="{{ route('admin.pagos.index') }}" class="btn btn-danger btn-lg flex-fill">
                <i class="bi bi-gear-fill me-2"></i>
                Configurar Wompi Ahora
            </a>
            <a href="https://wompi.co" target="_blank" class="btn btn-outline-danger btn-lg flex-fill">
                <i class="bi bi-box-arrow-up-right me-2"></i>
                Registrarse en Wompi
            </a>
        </div>
    </div>

    <!-- Sidebar con progreso -->
    <div class="col-lg-4">
        <div class="progress-tracker">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-list-check text-danger me-2"></i>
                Progreso de la Guía
            </h6>
            <a href="#step1" class="progress-item">
                <i class="bi bi-1-circle"></i>
                Crear cuenta Wompi
            </a>
            <a href="#step2" class="progress-item">
                <i class="bi bi-2-circle"></i>
                Obtener credenciales
            </a>
            <a href="#step3" class="progress-item">
                <i class="bi bi-3-circle"></i>
                Configurar en BBB
            </a>
            <a href="#step4" class="progress-item">
                <i class="bi bi-4-circle"></i>
                Probar pagos
            </a>
            <a href="#step5" class="progress-item">
                <i class="bi bi-5-circle"></i>
                Activar producción
            </a>

            <hr>
            
            <div class="feature-box">
                <h6 class="fw-bold mb-2">
                    <i class="bi bi-shield-check text-success me-2"></i>
                    Beneficios de Wompi
                </h6>
                <ul class="mb-0 small">
                    <li>🔒 Pagos 100% seguros</li>
                    <li>⚡ Confirmación instantánea</li>
                    <li>📱 Compatible con móviles</li>
                    <li>💰 Sin costos fijos mensuales</li>
                    <li>🇨🇴 Empresa colombiana</li>
                    <li>📞 Soporte en español</li>
                </ul>
            </div>
            
            <div class="warning-box">
                <h6 class="fw-bold mb-2">
                    <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                    Importante
                </h6>
                <p class="mb-0 small">Sin pagos configurados, tus clientes no podrán completar compras desde tu tienda online. ¡Es esencial!</p>
            </div>
            
            <h6 class="fw-bold mb-3 mt-4">
                <i class="bi bi-question-circle text-info me-2"></i>
                ¿Necesitas ayuda?
            </h6>
            <div class="d-flex gap-2">
                <a href="https://wa.me/{{ config('app.support.mobile') }}?text=Hola,%20necesito%20ayuda%20con%20Wompi" 
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

    // Copiar credenciales al hacer clic
    $('.code-box code').click(function() {
        navigator.clipboard.writeText($(this).text()).then(function() {
            Swal.fire({
                title: '¡Copiado!',
                text: 'El código se copió al portapapeles',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            });
        });
    });
});
</script>
@endpush

@endsection