<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Pago - {{ $renovacion->reference ?? '#' . $renovacion->id }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            background: white;
        }
        
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .company-logo {
            height: 60px;
            max-width: 200px;
            object-fit: contain;
        }
        
        .receipt-header {
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .status-badge {
            font-size: 14px;
            font-weight: bold;
            padding: 8px 16px;
            border-radius: 6px;
            text-transform: uppercase;
        }
        
        .status-completed { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .status-pending { background-color: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }
        .status-failed { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .status-cancelled { background-color: #e2e3e5; color: #383d41; border: 1px solid #d6d8db; }
        .status-refunded { background-color: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        
        .alert-warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 12px 16px;
            border-radius: 6px;
            margin: 15px 0;
        }
        
        .table-borderless td,
        .table-borderless th {
            border: none;
        }
        
        .table-light {
            background-color: #f8f9fa;
        }
        
        .info-section {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .total-section {
            background-color: #e3f2fd;
            border: 2px solid #2196f3;
            border-radius: 6px;
            padding: 15px;
        }
        
        .footer-text {
            color: #6c757d;
            font-size: 12px;
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
        }
        
        /* Print styles */
        @media print {
            body { margin: 0; }
            .receipt-container { padding: 10px; }
            .no-print { display: none !important; }
        }
        
        @page {
            margin: 1cm;
            size: A4;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Header del recibo -->
        <div class="receipt-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB Logo" class="company-logo">
                    <div class="mt-3">
                        <h4 class="mb-1 fw-bold">BBB Páginas Web</h4>
                        <p class="text-muted mb-0">Sistema de Gestión de Páginas Web</p>
                        <small class="text-muted">Colombia</small>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <h5 class="text-primary mb-3">RECIBO DE PAGO</h5>
                    <p class="mb-2"><strong>Referencia:</strong> {{ $renovacion->reference ?? '#' . $renovacion->id }}</p>
                    <p class="mb-2"><strong>Fecha:</strong> {{ $renovacion->created_at->format('d/m/Y H:i') }}</p>
                    <div class="mb-2">
                        @php
                            $statusClasses = [
                                'completed' => 'status-completed',
                                'pending' => 'status-pending',
                                'failed' => 'status-failed',
                                'cancelled' => 'status-cancelled',
                                'refunded' => 'status-refunded'
                            ];
                            $statusClass = $statusClasses[$renovacion->status] ?? 'status-cancelled';
                        @endphp
                        <span class="status-badge {{ $statusClass }}">
                            {{ strtoupper($renovacion->status) }}
                        </span>
                    </div>
                    @if($renovacion->status !== 'completed')
                        <div class="alert-warning">
                            <small><i class="bi bi-exclamation-triangle me-1"></i><strong>Importante:</strong> Este recibo corresponde a un pago en estado {{ strtoupper($renovacion->status) }}</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Información del cliente y plan -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-primary fw-bold mb-3">INFORMACIÓN DEL CLIENTE</h6>
                <p class="mb-2"><strong>{{ $user->name }}</strong></p>
                <p class="mb-2">{{ $user->email }}</p>
                @if($user->empresa && $user->empresa->nombre)
                    <p class="mb-2"><strong>Empresa:</strong> {{ $user->empresa->nombre }}</p>
                @endif
                @if($user->movil)
                    <p class="mb-2"><strong>Teléfono:</strong> {{ $user->movil }}</p>
                @endif
                @if($user->empresa && $user->empresa->direccion)
                    <p class="mb-0"><strong>Dirección:</strong> {{ $user->empresa->direccion }}</p>
                @endif
            </div>
            <div class="col-md-6">
                <h6 class="text-primary fw-bold mb-3">DETALLES DEL PLAN</h6>
                <p class="mb-2"><strong>{{ $plan->nombre }}</strong></p>
                <p class="mb-2">{{ strip_tags($plan->descripcion) }}</p>
                @if($plan->dias > 0)
                    <p class="mb-2"><strong>Duración:</strong> {{ $plan->dias }} días</p>
                @else
                    <p class="mb-2"><strong>Tipo:</strong> Plan de por vida</p>
                @endif
                @if($renovacion->starts_at && $renovacion->expires_at)
                    <p class="mb-0">
                        <strong>Vigencia:</strong><br>
                        <small>Desde: {{ $renovacion->starts_at->format('d/m/Y') }}</small><br>
                        <small>Hasta: {{ $renovacion->expires_at->format('d/m/Y') }}</small>
                    </p>
                @endif
            </div>
        </div>

        <!-- Detalles del pago -->
        <div class="mb-4">
            <h6 class="text-primary fw-bold mb-3">DETALLE DEL PAGO</h6>
            <table class="table table-borderless">
                <thead class="table-light">
                    <tr>
                        <th>Descripción</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-end">Precio Unitario</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>{{ $plan->nombre }}</strong><br>
                            <small class="text-muted">
                                @if($plan->dias > 0)
                                    Suscripción por {{ $plan->dias }} días
                                @else
                                    Acceso de por vida
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

        <!-- Resumen de totales -->
        <div class="row">
            <div class="col-md-6 offset-md-6">
                <div class="total-section">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td><strong>Subtotal:</strong></td>
                                <td class="text-end">${{ number_format($renovacion->amount, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td><strong>IVA (0%):</strong></td>
                                <td class="text-end">$0</td>
                            </tr>
                            <tr style="font-size: 1.1em; font-weight: bold;">
                                <td><strong>TOTAL:</strong></td>
                                <td class="text-end"><strong>${{ number_format($renovacion->amount, 0, ',', '.') }} {{ $renovacion->currency ?? 'COP' }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Información adicional del pago -->
        <div class="info-section">
            <h6 class="text-primary fw-bold mb-3">INFORMACIÓN DEL PAGO</h6>
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-2"><strong>Método de pago:</strong> {{ $renovacion->payment_method ?? 'Tarjeta de crédito/débito' }}</p>
                    <p class="mb-2"><strong>ID de transacción:</strong> {{ $renovacion->transaction_id ?? 'Pendiente' }}</p>
                    @if($renovacion->notes)
                        <p class="mb-2"><strong>Notas:</strong> {{ $renovacion->notes }}</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <p class="mb-2"><strong>Gateway de pago:</strong> {{ ucfirst($renovacion->gateway ?? 'Wompi') }}</p>
                    <p class="mb-2"><strong>Moneda:</strong> {{ $renovacion->currency ?? 'COP' }}</p>
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
                        @endphp
                        <span class="status-badge {{ $statusClass }}" style="font-size: 12px; padding: 4px 8px;">{{ $statusLabel }}</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-text">
            <p class="mb-2">
                <strong>Este recibo fue generado automáticamente el {{ $fecha_descarga->format('d/m/Y H:i') }}</strong>
            </p>
            <p class="mb-2">
                Para soporte técnico, contáctanos a través de nuestros canales oficiales.
            </p>
            <p class="mb-0">
                <em>BBB Páginas Web - Tu socio digital confiable</em>
            </p>
        </div>

        <!-- Botones de acción (solo visible en pantalla) -->
        <div class="text-center mt-4 no-print">
            <button onclick="window.print()" class="btn btn-primary me-2">
                <i class="bi bi-printer me-1"></i>
                Imprimir
            </button>
            <button onclick="window.close()" class="btn btn-secondary">
                <i class="bi bi-x-circle me-1"></i>
                Cerrar
            </button>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-print functionality (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>