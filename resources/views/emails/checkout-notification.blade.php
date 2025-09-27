<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('plans.email.checkout_notification.title', [], $locale) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #C8102E;
        }
        .header h1 {
            color: #C8102E;
            margin: 0;
            font-size: 24px;
        }
        .plan-info {
            background: linear-gradient(135deg, #C8102E 0%, #DAA520 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .plan-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .plan-price {
            font-size: 24px;
            font-weight: bold;
        }
        .info-section {
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 6px;
            border-left: 4px solid #DAA520;
        }
        .info-section h3 {
            color: #C8102E;
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .info-item {
            margin: 8px 0;
            display: flex;
            flex-wrap: wrap;
        }
        .info-label {
            font-weight: bold;
            min-width: 120px;
            color: #555;
        }
        .info-value {
            color: #333;
            flex: 1;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            background: #ffc107;
            color: #212529;
            border-radius: 4px;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .highlights {
            background: #e8f5e8;
            border: 1px solid #d4edda;
            border-radius: 6px;
            padding: 15px;
            margin: 15px 0;
        }
        .highlights h4 {
            color: #155724;
            margin-top: 0;
            margin-bottom: 10px;
        }
        .highlight-item {
            margin: 5px 0;
            color: #155724;
        }
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            .container {
                padding: 20px;
            }
            .info-item {
                flex-direction: column;
            }
            .info-label {
                min-width: auto;
                margin-bottom: 2px;
            }
        }
        /* Estilos para listas HTML del plan */
        .info-value .list-group {
            margin: 10px 0;
            padding: 0;
        }
        .info-value .list-group-item {
            border: none;
            padding: 8px 0;
            background: transparent !important;
            color: #333;
            display: flex;
            align-items: center;
            list-style: none;
        }
        .info-value .list-group-item i {
            color: #DAA520;
            margin-right: 10px;
            width: 16px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ __('plans.email.checkout_notification.title', [], $locale) }}</h1>
            <p>{{ __('plans.email.checkout_notification.subtitle', [], $locale) }}</p>
        </div>

        <div class="plan-info">
            <div class="plan-name">{{ $plan->nombre }}</div>
            <div class="plan-price">
                @if($carrito->valorPagadoPesos > 0)
                    ${{ number_format($carrito->valorPagadoPesos, 0, ',', '.') }} COP
                @else
                    ${{ number_format($carrito->valorPagadoDolar, 2) }} USD
                @endif
            </div>
            <div style="margin-top: 10px;">
                <span class="status-badge">{{ strtoupper($carrito->estado) }}</span>
            </div>
        </div>

        <div class="info-section">
            <h3>📋 {{ __('plans.email.checkout_notification.client_info', [], $locale) }}</h3>
            <div class="info-item">
                <span class="info-label">{{ __('plans.email.checkout_notification.name', [], $locale) }}:</span>
                <span class="info-value">{{ $carrito->nombrecontacto }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">{{ __('plans.email.checkout_notification.email', [], $locale) }}:</span>
                <span class="info-value">{{ $carrito->email }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">{{ __('plans.email.checkout_notification.phone', [], $locale) }}:</span>
                <span class="info-value">{{ $carrito->movil }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">{{ __('plans.email.checkout_notification.website', [], $locale) }}:</span>
                <span class="info-value">{{ $carrito->sitioweb }}</span>
            </div>
        </div>

        <div class="info-section">
            <h3>💼 {{ __('plans.email.checkout_notification.plan_details', [], $locale) }}</h3>
            <div class="info-item">
                <span class="info-label">{{ __('plans.email.checkout_notification.plan', [], $locale) }}:</span>
                <span class="info-value">{{ $plan->nombre }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">{{ __('plans.email.checkout_notification.description', [], $locale) }}:</span>
                <div class="info-value">{!! $plan->descripcion !!}</div>
            </div>
            <div class="info-item">
                <span class="info-label">{{ __('plans.email.checkout_notification.currency', [], $locale) }}:</span>
                <span class="info-value">
                    @if($carrito->valorPagadoPesos > 0)
                        {{ __('plans.email.checkout_notification.pesos', [], $locale) }}
                    @else
                        {{ __('plans.email.checkout_notification.dollars', [], $locale) }}
                    @endif
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">{{ __('plans.email.checkout_notification.value', [], $locale) }}:</span>
                <span class="info-value">
                    @if($carrito->valorPagadoPesos > 0)
                        ${{ number_format($carrito->valorPagadoPesos, 0, ',', '.') }} COP
                    @else
                        ${{ number_format($carrito->valorPagadoDolar, 2) }} USD
                    @endif
                </span>
            </div>
        </div>

        @if($plan->caracteristicas)
        <div class="highlights">
            <h4>✨ Características del Plan</h4>
            @foreach(explode(',', $plan->caracteristicas) as $caracteristica)
                @if(trim($caracteristica))
                    <div class="highlight-item">• {{ trim($caracteristica) }}</div>
                @endif
            @endforeach
        </div>
        @endif

        <div class="info-section">
            <h3>📊 Información Administrativa</h3>
            <div class="info-item">
                <span class="info-label">ID Solicitud:</span>
                <span class="info-value">#{{ str_pad($carrito->idCarrito, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Fecha:</span>
                <span class="info-value">{{ $carrito->created_at->format('d/m/Y H:i:s') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Estado:</span>
                <span class="info-value">{{ ucfirst($carrito->estado) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Empresa:</span>
                <span class="info-value">{{ $empresa->nombre }}</span>
            </div>
        </div>

        <div class="footer">
            <p><strong>¡Acción requerida!</strong></p>
            <p>Contacta al cliente lo antes posible para coordinar el pago y comenzar el desarrollo del proyecto.</p>
            <p>Este correo fue generado automáticamente el {{ now()->format('d/m/Y H:i:s') }}</p>
            <hr style="margin: 20px 0; border: none; border-top: 1px solid #eee;">
            <p style="font-size: 12px; color: #999;">
                BBB Páginas Web - Sistema de Gestión de Solicitudes<br>
                No respondas a este correo, es generado automáticamente.
            </p>
        </div>
    </div>
</body>
</html>