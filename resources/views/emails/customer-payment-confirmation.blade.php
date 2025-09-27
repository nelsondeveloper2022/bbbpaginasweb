<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('plans.email.customer_payment_confirmation.title', [], $locale) }}</title>
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
        .success-banner {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 30px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .success-banner h2 {
            margin: 0 0 10px 0;
            font-size: 24px;
        }
        .success-banner p {
            margin: 0;
            font-size: 16px;
        }
        .plan-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }
        .plan-name {
            font-size: 20px;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 10px;
        }
        .plan-price {
            font-size: 18px;
            font-weight: bold;
            color: #495057;
        }
        .info-section {
            margin: 25px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .info-section h3 {
            color: #28a745;
            margin-top: 0;
            font-size: 18px;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 10px;
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
        .next-steps {
            background: #e3f2fd;
            border: 1px solid #90caf9;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .next-steps h3 {
            color: #1976d2;
            margin-top: 0;
        }
        .next-steps ol {
            margin: 10px 0;
            padding-left: 20px;
        }
        .next-steps li {
            margin: 8px 0;
            color: #424242;
        }
        .contact-info {
            background: #fff3e0;
            border: 1px solid #ffcc02;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .contact-info h3 {
            color: #f57c00;
            margin-top: 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            font-size: 12px;
            color: #6c757d;
        }
        .company-logo {
            text-align: center;
            margin: 20px 0;
        }
        .highlight {
            background: #fff59d;
            padding: 2px 6px;
            border-radius: 3px;
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
            .success-banner {
                padding: 20px;
            }
            .success-banner h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>{{ __('plans.email.customer_payment_confirmation.title', [], $locale) }}</h1>
            <p>{{ __('plans.email.customer_payment_confirmation.subtitle', [], $locale) }}</p>
        </div>

        <!-- Success Banner -->
        <div class="success-banner">
            <h2>{{ __('plans.email.customer_payment_confirmation.greeting', ['name' => $carrito->nombrecontacto], $locale) }}</h2>
            <p>{{ __('plans.email.customer_payment_confirmation.thanks', [], $locale) }}</p>
        </div>

        <!-- Plan Information -->
        <div class="plan-info">
            <div class="plan-name">{{ $plan->nombre }}</div>
            <div class="plan-price">
                @if($carrito->valorPagadoPesos > 0)
                    ${{ number_format($carrito->valorPagadoPesos, 0, ',', '.') }} COP
                @else
                    ${{ number_format($carrito->valorPagadoDolar, 2) }} USD
                @endif
            </div>
            @if($plan->descripcion)
            <p style="margin-top: 10px; color: #6c757d;">{{ $plan->descripcion }}</p>
            @endif
        </div>

        <!-- Payment Summary -->
        <div class="info-section">
            <h3>{{ __('plans.email.customer_payment_confirmation.payment_summary', [], $locale) }}</h3>
            <div class="info-row">
                <span class="info-label">{{ __('plans.email.customer_payment_confirmation.request_id', [], $locale) }}:</span>
                <span class="info-value">#{{ $carrito->idCarrito }}</span>
            </div>
            @if($carrito->wompi_transaction_id)
            <div class="info-row">
                <span class="info-label">{{ __('plans.email.customer_payment_confirmation.transaction_id', [], $locale) }}:</span>
                <span class="info-value">{{ $carrito->wompi_transaction_id }}</span>
            </div>
            @endif
            @if($carrito->payment_method)
            <div class="info-row">
                <span class="info-label">{{ __('plans.email.customer_payment_confirmation.payment_method', [], $locale) }}:</span>
                <span class="info-value">{{ ucfirst($carrito->payment_method) }}</span>
            </div>
            @endif
            <div class="info-row">
                <span class="info-label">{{ __('plans.email.customer_payment_confirmation.payment_date', [], $locale) }}:</span>
                <span class="info-value">{{ $carrito->fecha_pago ? $carrito->fecha_pago->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">{{ __('plans.email.customer_payment_confirmation.plan', [], $locale) }}:</span>
                <span class="info-value">{{ $plan->nombre }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">{{ __('plans.email.customer_payment_confirmation.website', [], $locale) }}:</span>
                <span class="info-value">{{ $carrito->sitioweb }}</span>
            </div>
        </div>

        <!-- Project Status -->
        <div class="info-section">
            <h3>{{ __('plans.email.customer_payment_confirmation.status_title', [], $locale) }}</h3>
            <p><strong class="highlight">{{ __('plans.email.customer_payment_confirmation.status_text', [], $locale) }}</strong></p>
            <p>{{ __('plans.email.customer_payment_confirmation.development_time', [], $locale) }}</p>
            <p>{{ __('plans.email.customer_payment_confirmation.contact_methods', ['phone' => $carrito->movil, 'email' => $carrito->email], $locale) }}</p>
        </div>

        <!-- Next Steps -->
        <div class="next-steps">
            <h3>{{ __('plans.email.customer_payment_confirmation.next_steps', [], $locale) }}</h3>
            <ol>
                <li>{{ __('plans.email.customer_payment_confirmation.step1', [], $locale) }}</li>
                <li>{{ __('plans.email.customer_payment_confirmation.step2', [], $locale) }}</li>
                <li>{{ __('plans.email.customer_payment_confirmation.step3', [], $locale) }}</li>
                <li>{{ __('plans.email.customer_payment_confirmation.step4', [], $locale) }}</li>
            </ol>
        </div>

        <!-- Contact Information -->
        <div class="contact-info">
            <h3>{{ __('plans.email.customer_payment_confirmation.questions_title', [], $locale) }}</h3>
            <p>{{ __('plans.email.customer_payment_confirmation.questions_text', [], $locale) }}</p>
            @if($empresa && $empresa->email)
            <p><strong>Email:</strong> {{ $empresa->email }}</p>
            @endif
            <p>{{ __('plans.email.customer_payment_confirmation.schedule', [], $locale) }}</p>
        </div>

        <!-- Footer Message -->
        <div style="text-align: center; margin: 30px 0; padding: 20px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border-radius: 8px;">
            <h3 style="margin: 0 0 10px 0;">{{ __('plans.email.customer_payment_confirmation.thanks_footer', [], $locale) }}</h3>
            <p style="margin: 0;">{{ __('plans.email.customer_payment_confirmation.excited', [], $locale) }}</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>{{ __('plans.email.customer_payment_confirmation.footer_text', [], $locale) }}</strong></p>
            <p>{{ __('plans.email.customer_payment_confirmation.auto_generated', ['date' => now()->format('d/m/Y H:i')], $locale) }}</p>
        </div>
    </div>
</body>
</html>