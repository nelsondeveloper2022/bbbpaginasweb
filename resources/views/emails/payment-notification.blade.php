<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('plans.email.payment_notification.title', [], $locale) }}</title>
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
            border-bottom: 3px solid #28a745;
        }
        .header h1 {
            color: #28a745;
            margin: 0;
            font-size: 24px;
        }
        .payment-confirmed {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
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
        .payment-amount {
            font-size: 24px;
            font-weight: bold;
        }
        .info-section {
            margin: 25px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #28a745;
        }
        .info-section h3 {
            color: #28a745;
            margin-top: 0;
            font-size: 18px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: bold;
            color: #495057;
        }
        .info-value {
            color: #6c757d;
        }
        .alert {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            font-size: 12px;
            color: #6c757d;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 10px 5px;
        }
        .plan-features {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .plan-features ul {
            margin: 0;
            padding-left: 20px;
        }
        .plan-features li {
            margin: 5px 0;
        }
        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }
            .container {
                padding: 20px;
            }
            .info-row {
                flex-direction: column;
            }
            .info-label {
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>{{ __('plans.email.payment_notification.title', [], $locale) }}</h1>
            <p>{{ __('plans.email.payment_notification.subtitle', [], $locale) }}</p>
        </div>

        <!-- Payment Confirmation -->
        <div class="payment-confirmed">
            <div class="plan-name">{{ $plan->nombre }}</div>
            <div class="payment-amount">
                @if($carrito->valorPagadoPesos > 0)
                    ${{ number_format($carrito->valorPagadoPesos, 0, ',', '.') }} COP
                @else
                    ${{ number_format($carrito->valorPagadoDolar, 2) }} USD
                @endif
            </div>
        </div>

        <!-- Success Alert -->
        <div class="alert alert-success">
            <strong>{{ __('plans.email.payment_notification.action_required', [], $locale) }}</strong><br>
            {{ __('plans.email.payment_notification.start_project', [], $locale) }}
        </div>

        <!-- Client Information -->
        <div class="info-section">
            <h3>{{ __('plans.email.payment_notification.client_info', [], $locale) }}</h3>
            <div class="info-row">
                <span class="info-label">{{ __('plans.email.payment_notification.name', [], $locale) }}:</span>
                <span class="info-value">{{ $carrito->nombrecontacto }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">{{ __('plans.email.payment_notification.email', [], $locale) }}:</span>
                <span class="info-value">{{ $carrito->email }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">{{ __('plans.email.payment_notification.phone', [], $locale) }}:</span>
                <span class="info-value">{{ $carrito->movil }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">{{ __('plans.email.payment_notification.website', [], $locale) }}:</span>
                <span class="info-value">{{ $carrito->sitioweb }}</span>
            </div>
        </div>

        <!-- Payment Details -->
        <div class="info-section">
            <h3>{{ __('plans.email.payment_notification.payment_details', [], $locale) }}</h3>
            <div class="info-row">
                <span class="info-label">{{ __('plans.email.payment_notification.request_id', [], $locale) }}:</span>
                <span class="info-value">#{{ $carrito->idCarrito }}</span>
            </div>
            @if($carrito->wompi_transaction_id)
            <div class="info-row">
                <span class="info-label">{{ __('plans.email.payment_notification.transaction_id', [], $locale) }}:</span>
                <span class="info-value">{{ $carrito->wompi_transaction_id }}</span>
            </div>
            @endif
            @if($carrito->payment_method)
            <div class="info-row">
                <span class="info-label">{{ __('plans.email.payment_notification.payment_method', [], $locale) }}:</span>
                <span class="info-value">{{ ucfirst($carrito->payment_method) }}</span>
            </div>
            @endif
            <div class="info-row">
                <span class="info-label">{{ __('plans.email.payment_notification.payment_date', [], $locale) }}:</span>
                <span class="info-value">{{ $carrito->fecha_pago ? $carrito->fecha_pago->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">{{ __('plans.email.payment_notification.status', [], $locale) }}:</span>
                <span class="info-value">{{ __('plans.email.payment_notification.paid', [], $locale) }}</span>
            </div>
        </div>

        <!-- Plan Details -->
        <div class="info-section">
            <h3>{{ __('plans.email.payment_notification.plan', [], $locale) }}: {{ $plan->nombre }}</h3>
            <div class="info-row">
                <span class="info-label">{{ __('plans.email.payment_notification.description', [], $locale) }}:</span>
                <span class="info-value">{{ $plan->descripcion }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">{{ __('plans.email.payment_notification.currency', [], $locale) }}:</span>
                <span class="info-value">
                    @if($carrito->valorPagadoPesos > 0)
                        {{ __('plans.email.payment_notification.pesos', [], $locale) }}
                    @else
                        {{ __('plans.email.payment_notification.dollars', [], $locale) }}
                    @endif
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">{{ __('plans.email.payment_notification.value', [], $locale) }}:</span>
                <span class="info-value">
                    @if($carrito->valorPagadoPesos > 0)
                        ${{ number_format($carrito->valorPagadoPesos, 0, ',', '.') }} COP
                    @else
                        ${{ number_format($carrito->valorPagadoDolar, 2) }} USD
                    @endif
                </span>
            </div>
        </div>

        <!-- Company Information -->
        @if($empresa)
        <div class="info-section">
            <h3>{{ __('plans.email.payment_notification.company', [], $locale) }}</h3>
            <div class="info-row">
                <span class="info-label">{{ __('plans.email.payment_notification.name', [], $locale) }}:</span>
                <span class="info-value">{{ $empresa->nombre }}</span>
            </div>
            @if($empresa->email)
            <div class="info-row">
                <span class="info-label">{{ __('plans.email.payment_notification.email', [], $locale) }}:</span>
                <span class="info-value">{{ $empresa->email }}</span>
            </div>
            @endif
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>{{ __('plans.email.payment_notification.auto_generated', ['date' => now()->format('d/m/Y H:i')], $locale) }}</p>
            <p>{{ __('plans.email.payment_notification.no_reply', [], $locale) }}</p>
        </div>
    </div>
</body>
</html>