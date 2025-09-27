<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Pago Recibido - BBB Páginas Web</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #28a745;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 2rem;
            font-weight: bold;
            color: #d22e23;
        }
        .money-icon {
            font-size: 4rem;
            color: #28a745;
            margin: 20px 0;
        }
        .title {
            color: #28a745;
            font-size: 1.8rem;
            margin-bottom: 10px;
        }
        .subtitle {
            color: #6c757d;
            font-size: 1rem;
            margin-bottom: 30px;
        }
        .customer-info {
            background: linear-gradient(135deg, #d22e23, #f0ac21);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .customer-name {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .customer-email {
            opacity: 0.9;
            font-size: 1rem;
        }
        .payment-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-row:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 1.2rem;
            color: #28a745;
        }
        .detail-label {
            font-weight: 600;
            color: #495057;
        }
        .detail-value {
            color: #212529;
        }
        .plan-info {
            background: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }
        .plan-name {
            font-weight: bold;
            color: #d22e23;
            font-size: 1.1rem;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 0.9rem;
        }
        .stats-box {
            background: #28a745;
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
        }
        .amount-highlight {
            font-size: 2rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">BBB Páginas Web</div>
            <div class="money-icon">💰</div>
            <h1 class="title">Nuevo Pago Recibido</h1>
            <p class="subtitle">Un cliente ha completado su pago exitosamente</p>
        </div>

        <div class="content">
            <div class="stats-box">
                <div class="amount-highlight">${{ $amount }} COP</div>
                <div>Pago confirmado por Wompi</div>
            </div>

            <div class="customer-info">
                <div class="customer-name">{{ $user->name }}</div>
                <div class="customer-email">{{ $user->email }}</div>
                @if($user->empresa && $user->empresa->nombre)
                <div style="margin-top: 10px; opacity: 0.9;">
                    🏢 {{ $user->empresa->nombre }}
                </div>
                @endif
            </div>

            <div class="payment-details">
                <h3 style="margin-top: 0; color: #28a745;">Detalles del Pago</h3>
                
                <div class="detail-row">
                    <span class="detail-label">Referencia:</span>
                    <span class="detail-value">{{ $reference }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">ID Transacción:</span>
                    <span class="detail-value">{{ $transactionId }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Fecha y Hora:</span>
                    <span class="detail-value">{{ $paymentDate }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Método de Pago:</span>
                    <span class="detail-value">{{ $paymentMethod }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Estado:</span>
                    <span class="detail-value">✅ APROBADO</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Monto Total:</span>
                    <span class="detail-value">${{ $amount }} COP</span>
                </div>
            </div>

            <div class="plan-info">
                <div class="plan-name">Plan Adquirido: {{ $plan->nombre }}</div>
                <div style="margin-top: 8px; color: #6c757d;">
                    {{ strip_tags($plan->descripcion) }}
                </div>
                @if($plan->dias > 0)
                <div style="margin-top: 8px; color: #28a745; font-weight: 600;">
                    ⏱️ Duración: {{ $plan->dias }} días
                </div>
                @else
                <div style="margin-top: 8px; color: #28a745; font-weight: 600;">
                    ♾️ Plan permanente (one-time)
                </div>
                @endif
            </div>

            <h4 style="color: #d22e23;">Información del Cliente:</h4>
            <ul>
                <li><strong>ID Usuario:</strong> {{ $user->id }}</li>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Teléfono:</strong> {{ $user->telefono ?? 'No especificado' }}</li>
                <li><strong>País:</strong> {{ $user->pais ?? 'No especificado' }}</li>
                @if($user->empresa)
                <li><strong>Empresa:</strong> {{ $user->empresa->nombre ?? 'No especificada' }}</li>
                <li><strong>Slug:</strong> {{ $user->empresa->slug ?? 'No asignado' }}</li>
                @endif
            </ul>

            <h4 style="color: #d22e23;">Próximos pasos:</h4>
            <ul>
                <li>✅ El plan del cliente ya está activo</li>
                <li>📊 Puedes revisar el estado en el dashboard admin</li>
                <li>📧 El cliente recibió confirmación por email</li>
                <li>🎨 Puede configurar su landing page inmediatamente</li>
            </ul>
        </div>

        <div class="footer">
            <p><strong>Notificación automática de BBB Páginas Web</strong></p>
            <p>Este email se envía automáticamente cuando se confirma un pago.</p>
            <p>&copy; {{ date('Y') }} BBB Páginas Web - Sistema de Notificaciones</p>
        </div>
    </div>
</body>
</html>