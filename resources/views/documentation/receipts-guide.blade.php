@extends('layouts.dashboard')

@section('title', 'Recibos y Pagos - Documentación')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="dashboard-title">
                        <i class="bi bi-receipt me-3 text-info"></i>
                        Recibos y Pagos
                    </h1>
                    <p class="text-muted mb-0">Aprende a gestionar y descargar tus recibos de pago</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.documentation.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>
                        Volver a Academy
                    </a>
                    <a href="{{ route('admin.plans.index') }}" class="btn btn-info">
                        <i class="bi bi-receipt me-2"></i>
                        Ver recibos
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Contenido principal -->
                <div class="col-lg-8">
                    <!-- Sección: ¿Qué son los recibos? -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="mb-0">
                                <i class="bi bi-info-circle me-2 text-info"></i>
                                ¿Qué son los recibos de pago?
                            </h4>
                        </div>
                        <div class="card-body">
                            <p class="lead">Los recibos de pago son documentos que confirman las transacciones realizadas en tu cuenta de BBB Páginas Web.</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-success mb-3">
                                        <i class="bi bi-check-circle me-2"></i>Incluyen:
                                    </h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="bi bi-arrow-right text-primary me-2"></i>Información completa del cliente</li>
                                        <li class="mb-2"><i class="bi bi-arrow-right text-primary me-2"></i>Detalles del plan contratado</li>
                                        <li class="mb-2"><i class="bi bi-arrow-right text-primary me-2"></i>Fecha y monto del pago</li>
                                        <li class="mb-2"><i class="bi bi-arrow-right text-primary me-2"></i>Estado del pago</li>
                                        <li class="mb-2"><i class="bi bi-arrow-right text-primary me-2"></i>Referencia de transacción</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-warning mb-3">
                                        <i class="bi bi-exclamation-triangle me-2"></i>Estados posibles:
                                    </h6>
                                    <div class="mb-2">
                                        <span class="badge bg-success me-2">COMPLETED</span>
                                        <small>Pago exitoso y confirmado</small>
                                    </div>
                                    <div class="mb-2">
                                        <span class="badge bg-warning me-2">PENDING</span>
                                        <small>Pago en proceso de verificación</small>
                                    </div>
                                    <div class="mb-2">
                                        <span class="badge bg-danger me-2">FAILED</span>
                                        <small>Pago falló o fue rechazado</small>
                                    </div>
                                    <div class="mb-2">
                                        <span class="badge bg-secondary me-2">CANCELLED</span>
                                        <small>Pago cancelado por el usuario</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección: Cómo descargar recibos -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="mb-0">
                                <i class="bi bi-download me-2 text-success"></i>
                                Cómo descargar tu último recibo
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="bi bi-lightbulb me-2"></i>
                                <strong>Importante:</strong> Solo se pueden descargar recibos si tienes al menos un pago registrado en tu cuenta.
                            </div>

                            <h5 class="mb-3">Método 1: Desde el menú de usuario</h5>
                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <ol class="list-group list-group-numbered">
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">Accede al menú de usuario</div>
                                                Haz clic en tu avatar en la esquina superior derecha
                                            </div>
                                            <span class="badge bg-primary rounded-pill">1</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">Busca "Descargar Último Recibo"</div>
                                                Se mostrará con un ícono de recibo <i class="bi bi-receipt"></i>
                                            </div>
                                            <span class="badge bg-primary rounded-pill">2</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">Haz clic para descargar</div>
                                                Se abrirá una nueva ventana con tu recibo
                                            </div>
                                            <span class="badge bg-primary rounded-pill">3</span>
                                        </li>
                                    </ol>
                                </div>
                                <div class="col-md-4">
                                    <div class="bg-light p-3 rounded">
                                        <h6 class="text-muted mb-2">Vista previa del menú:</h6>
                                        <div class="card">
                                            <div class="card-body p-2">
                                                <div class="dropdown-item-text small">
                                                    <i class="bi bi-person-gear"></i> Mi Perfil
                                                </div>
                                                <div class="dropdown-item-text small">
                                                    <i class="bi bi-credit-card-2-front"></i> Mi Plan
                                                </div>
                                                <div class="dropdown-item-text small text-primary">
                                                    <i class="bi bi-receipt"></i> <strong>Descargar Último Recibo</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mb-3">Método 2: Desde gestión de planes</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <ol class="list-group list-group-numbered">
                                        <li class="list-group-item">
                                            <strong>Ve a "Gestionar Plan"</strong> desde el menú lateral
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Abre el modal "Mi Plan"</strong> haciendo clic en el botón correspondiente
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Busca el botón "Descargar Recibo"</strong> en la sección de información del último pago
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección: Estados de pago -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="mb-0">
                                <i class="bi bi-shield-check me-2 text-primary"></i>
                                Estados de pago y qué significan
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card border-success mb-3">
                                        <div class="card-header bg-success text-white">
                                            <i class="bi bi-check-circle me-2"></i>COMPLETED
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Pago completado exitosamente</strong></p>
                                            <ul class="small">
                                                <li>Tu plan está activo</li>
                                                <li>El recibo es válido como comprobante</li>
                                                <li>No requiere acciones adicionales</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-warning mb-3">
                                        <div class="card-header bg-warning text-dark">
                                            <i class="bi bi-hourglass-split me-2"></i>PENDING
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Pago en proceso de verificación</strong></p>
                                            <ul class="small">
                                                <li>El pago está siendo procesado</li>
                                                <li>Puede tomar algunos minutos</li>
                                                <li>Recibirás confirmación por email</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-danger mb-3">
                                        <div class="card-header bg-danger text-white">
                                            <i class="bi bi-x-circle me-2"></i>FAILED
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Pago falló o fue rechazado</strong></p>
                                            <ul class="small">
                                                <li>La transacción no se completó</li>
                                                <li>Intenta nuevamente</li>
                                                <li>Verifica tus datos de pago</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-secondary mb-3">
                                        <div class="card-header bg-secondary text-white">
                                            <i class="bi bi-dash-circle me-2"></i>CANCELLED
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Pago cancelado</strong></p>
                                            <ul class="small">
                                                <li>Cancelado por el usuario</li>
                                                <li>No se realizó el cobro</li>
                                                <li>Puedes intentar de nuevo</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>Atención:</strong> Los recibos con estado diferente a "COMPLETED" son informativos. Solo los pagos completados son válidos como comprobante oficial de pago.
                            </div>
                        </div>
                    </div>

                    <!-- Sección: Problemas comunes -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="mb-0">
                                <i class="bi bi-question-circle me-2 text-warning"></i>
                                Problemas comunes y soluciones
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="accordion" id="problemsAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#problem1">
                                            No aparece la opción "Descargar Último Recibo"
                                        </button>
                                    </h2>
                                    <div id="problem1" class="accordion-collapse collapse show" data-bs-parent="#problemsAccordion">
                                        <div class="accordion-body">
                                            <p><strong>Posibles causas:</strong></p>
                                            <ul>
                                                <li>No tienes pagos registrados en tu cuenta</li>
                                                <li>Tu cuenta no tiene renovaciones creadas</li>
                                            </ul>
                                            <p><strong>Solución:</strong></p>
                                            <p>Realiza al menos un pago o renueva tu plan para que aparezca esta opción.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#problem2">
                                            El navegador bloquea la ventana del recibo
                                        </button>
                                    </h2>
                                    <div id="problem2" class="accordion-collapse collapse" data-bs-parent="#problemsAccordion">
                                        <div class="accordion-body">
                                            <p><strong>Síntoma:</strong> Al hacer clic en descargar, no se abre nada.</p>
                                            <p><strong>Causa:</strong> Tu navegador está bloqueando ventanas emergentes.</p>
                                            <p><strong>Solución:</strong></p>
                                            <ol>
                                                <li>El sistema te mostrará una alerta con opción "Abrir Recibo"</li>
                                                <li>Haz clic en "Abrir Recibo" para continuar</li>
                                                <li>O permite ventanas emergentes para este sitio</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#problem3">
                                            El recibo muestra estado "PENDING" o "FAILED"
                                        </button>
                                    </h2>
                                    <div id="problem3" class="accordion-collapse collapse" data-bs-parent="#problemsAccordion">
                                        <div class="accordion-body">
                                            <p><strong>¿Es normal?</strong> Sí, el sistema te permite descargar recibos en cualquier estado para tu referencia.</p>
                                            <p><strong>Advertencia:</strong> El sistema te mostrará una alerta explicando el estado antes de descargar.</p>
                                            <p><strong>Recomendación:</strong></p>
                                            <ul>
                                                <li>Para PENDING: Espera unos minutos y verifica si cambia a COMPLETED</li>
                                                <li>Para FAILED: Intenta realizar el pago nuevamente</li>
                                                <li>Solo los recibos COMPLETED son válidos como comprobante oficial</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar con información adicional -->
                <div class="col-lg-4">
                    <!-- Acciones rápidas -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-lightning me-2 text-warning"></i>
                                Acciones Rápidas
                            </h5>
                        </div>
                        <div class="card-body">
                            @php
                                $userLastRenovacion = auth()->user()->renovaciones()->latest()->first();
                            @endphp
                            @if($userLastRenovacion)
                                <button class="btn btn-primary w-100 mb-3" onclick="downloadInvoice('{{ $userLastRenovacion->id }}')">
                                    <i class="bi bi-download me-2"></i>
                                    Descargar Mi Último Recibo
                                    @if($userLastRenovacion->status !== 'completed')
                                        <small class="d-block text-light">(Estado: {{ ucfirst($userLastRenovacion->status) }})</small>
                                    @endif
                                </button>
                            @else
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <small>No tienes recibos disponibles aún. Realiza tu primer pago para generar recibos.</small>
                                </div>
                            @endif
                            
                            <a href="{{ route('admin.plans.index') }}" class="btn btn-outline-primary w-100 mb-2">
                                <i class="bi bi-credit-card me-2"></i>
                                Ver Mis Planes
                            </a>
                            
                            <a href="{{ route('admin.profile.edit') }}" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-person-gear me-2"></i>
                                Histórico de Pagos
                            </a>
                        </div>
                    </div>

                    <!-- Información de contacto -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-headset me-2 text-info"></i>
                                ¿Necesitas ayuda?
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="small text-muted mb-3">Si tienes problemas con tus recibos o pagos, contáctanos:</p>
                            
                            @php
                                $empresaSlug = auth()->user()->empresa?->slug ?? 'sin-empresa';
                                $whatsappMessage = "Hola, tengo una consulta sobre mis recibos de pago. Mi empresa es: " . $empresaSlug;
                            @endphp
                            <a href="https://wa.me/{{ config('app.support.mobile') }}?text={{ urlencode($whatsappMessage) }}" 
                               target="_blank" 
                               class="btn btn-success w-100 mb-2">
                                <i class="bi bi-whatsapp me-2"></i>
                                Ayuda por WhatsApp
                            </a>
                            
                            <p class="small text-muted mt-3">
                                <i class="bi bi-clock me-1"></i>
                                Atención: Lunes a Viernes, 8:00 AM - 6:00 PM
                            </p>
                        </div>
                    </div>

                    <!-- Tips útiles -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-lightbulb me-2 text-success"></i>
                                Tips Útiles
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-check-circle text-success"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Guarda tus recibos</h6>
                                    <p class="small text-muted mb-0">Descarga y guarda tus recibos para tus registros contables.</p>
                                </div>
                            </div>
                            
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-printer text-primary"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Imprime si necesitas</h6>
                                    <p class="small text-muted mb-0">Los recibos están optimizados para impresión en papel tamaño carta.</p>
                                </div>
                            </div>
                            
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-shield-check text-info"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Verifica el estado</h6>
                                    <p class="small text-muted mb-0">Siempre revisa que el estado sea "COMPLETED" para comprobantes oficiales.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection