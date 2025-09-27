@extends('layouts.dashboard')

@section('title', 'Recibo de Pago')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="bi bi-receipt me-2"></i>
                            Recibo de Pago
                        </h4>
                        <button onclick="window.print()" class="btn btn-light btn-sm">
                            <i class="bi bi-printer me-1"></i>
                            Imprimir
                        </button>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <!-- Header del recibo -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB Logo" style="height: 60px;">
                            <div class="mt-2">
                                <h5 class="mb-1">BBB Páginas Web</h5>
                                <p class="text-muted mb-0">Sistema de Gestión de Páginas Web</p>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <h6 class="text-muted">RECIBO DE PAGO</h6>
                            <p class="mb-1"><strong>Referencia:</strong> {{ $renovacion->reference ?? '#' . $renovacion->id }}</p>
                            <p class="mb-1"><strong>Fecha:</strong> {{ $renovacion->created_at->format('d/m/Y H:i') }}</p>
                            <p class="mb-2">
                                @php
                                    $statusColors = [
                                        'completed' => 'success',
                                        'pending' => 'warning',
                                        'failed' => 'danger',
                                        'cancelled' => 'secondary',
                                        'refunded' => 'info'
                                    ];
                                    $statusColor = $statusColors[$renovacion->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $statusColor }} fs-6 px-3 py-2">
                                    {{ strtoupper($renovacion->status) }}
                                </span>
                            </p>
                            @if($renovacion->status !== 'completed')
                                <div class="alert alert-warning alert-sm mb-0">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    <small><strong>Importante:</strong> Este recibo corresponde a un pago en estado {{ strtoupper($renovacion->status) }}</small>
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <!-- Información del cliente -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">INFORMACIÓN DEL CLIENTE</h6>
                            <p class="mb-1"><strong>{{ $user->name }}</strong></p>
                            <p class="mb-1">{{ $user->email }}</p>
                            @if($user->empresa && $user->empresa->nombre)
                                <p class="mb-1">{{ $user->empresa->nombre }}</p>
                            @endif
                            @if($user->movil)
                                <p class="mb-0">Teléfono: {{ $user->movil }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">DETALLES DEL PLAN</h6>
                            <p class="mb-1"><strong>{{ $plan->nombre }}</strong></p>
                            <p class="mb-1">{{ strip_tags($plan->descripcion) }}</p>
                            @if($plan->dias > 0)
                                <p class="mb-1">Duración: {{ $plan->dias }} días</p>
                            @else
                                <p class="mb-1">Plan de por vida</p>
                            @endif
                            @if($renovacion->starts_at && $renovacion->expires_at)
                                <p class="mb-0">
                                    <small class="text-muted">
                                        Vigencia: {{ $renovacion->starts_at->format('d/m/Y') }} - {{ $renovacion->expires_at->format('d/m/Y') }}
                                    </small>
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Detalles del pago -->
                    <div class="table-responsive mb-4">
                        <table class="table table-borderless">
                            <thead class="table-light">
                                <tr>
                                    <th>Descripción</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-end">Precio</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <strong>{{ $plan->nombre }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            @if($plan->dias > 0)
                                                Plan por {{ $plan->dias }} días
                                            @else
                                                Plan de por vida
                                            @endif
                                        </small>
                                    </td>
                                    <td class="text-center">1</td>
                                    <td class="text-end">${{ number_format($renovacion->amount, 0, ',', '.') }}</td>
                                    <td class="text-end"><strong>${{ number_format($renovacion->amount, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Total -->
                    <div class="row">
                        <div class="col-md-6 offset-md-6">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td><strong>Subtotal:</strong></td>
                                            <td class="text-end">${{ number_format($renovacion->amount, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>IVA (0%):</strong></td>
                                            <td class="text-end">$0</td>
                                        </tr>
                                        <tr class="table-primary">
                                            <td><strong>TOTAL:</strong></td>
                                            <td class="text-end"><strong>${{ number_format($renovacion->amount, 0, ',', '.') }} {{ $renovacion->currency ?? 'COP' }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Información adicional -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="border rounded p-3 bg-light">
                                <h6 class="mb-2">Información del Pago</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Método de pago:</strong> {{ $renovacion->payment_method ?? 'Tarjeta de crédito/débito' }}</p>
                                        <p class="mb-1"><strong>ID de transacción:</strong> {{ $renovacion->transaction_id ?? 'Pendiente' }}</p>
                                        @if($renovacion->notes)
                                            <p class="mb-1"><strong>Notas:</strong> {{ $renovacion->notes }}</p>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Gateway:</strong> {{ ucfirst($renovacion->gateway ?? 'Wompi') }}</p>
                                        <p class="mb-1"><strong>Moneda:</strong> {{ $renovacion->currency ?? 'COP' }}</p>
                                        <p class="mb-0"><strong>Estado del pago:</strong> 
                                            @php
                                                $statusLabels = [
                                                    'completed' => 'Completado',
                                                    'pending' => 'Pendiente',
                                                    'failed' => 'Fallido',
                                                    'cancelled' => 'Cancelado',
                                                    'refunded' => 'Reembolsado'
                                                ];
                                                $statusLabel = $statusLabels[$renovacion->status] ?? ucfirst($renovacion->status);
                                                $statusColor = $statusColors[$renovacion->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $statusColor }}">{{ $statusLabel }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="mt-4 pt-3 border-top text-center text-muted">
                        <p class="mb-1">
                            <small>
                                Este recibo fue generado automáticamente el {{ $fecha_descarga->format('d/m/Y H:i') }}
                            </small>
                        </p>
                        <p class="mb-0">
                            <small>
                                Para soporte técnico, contáctanos a través de nuestro WhatsApp o correo electrónico.
                            </small>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="text-center mt-3">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver al Dashboard
                </a>
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="bi bi-printer me-1"></i>
                    Imprimir Recibo
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos para impresión */
@media print {
    /* Ocultar elementos innecesarios */
    .btn, .breadcrumb, .sidebar, .top-bar, .navbar, .header {
        display: none !important;
    }
    
    /* Ajustar contenedor principal */
    .main-content, .container-fluid {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
    }
    
    /* Eliminar bordes y sombras */
    .card {
        border: none !important;
        box-shadow: none !important;
        margin: 0 !important;
    }
    
    .card-header {
        background-color: #f8f9fa !important;
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
    }
    
    /* Asegurar que los colores se impriman */
    .badge, .alert, .bg-primary, .bg-success, .bg-warning, .bg-danger {
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
    }
    
    /* Ajustar fuentes para impresión */
    body {
        font-size: 12pt !important;
        line-height: 1.4 !important;
    }
    
    h1, h2, h3, h4, h5, h6 {
        color: #000 !important;
    }
    
    /* Evitar saltos de página en elementos importantes */
    .table, .card-body {
        page-break-inside: avoid;
    }
    
    /* Asegurar que las tablas se vean bien */
    .table {
        border-collapse: collapse !important;
    }
    
    .table th, .table td {
        border: 1px solid #dee2e6 !important;
        padding: 8px !important;
    }
    
    /* Mejorar legibilidad de badges */
    .badge {
        border: 1px solid #000 !important;
        padding: 4px 8px !important;
    }
}

/* Estilos generales mejorados */
.receipt-header {
    border-bottom: 2px solid #007bff;
    margin-bottom: 2rem;
}

.receipt-section {
    margin-bottom: 1.5rem;
}

.receipt-total {
    border-top: 2px solid #007bff;
    background-color: #f8f9fa;
    font-weight: bold;
}

.status-badge {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
}

/* Animación sutil para la carga */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.card {
    animation: fadeIn 0.3s ease-in;
}
</style>
@endsection