<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('plans.email.customer_confirmation.title', [], $locale) }}</title>
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
        .header p {
            color: #666;
            margin: 10px 0 0 0;
            font-size: 16px;
        }
        .greeting {
            background: linear-gradient(135deg, #C8102E 0%, #DAA520 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
        }
        .greeting h2 {
            margin: 0 0 10px 0;
            font-size: 22px;
        }
        .plan-summary {
            background: #f8f9fa;
            border: 2px solid #DAA520;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .plan-name {
            font-size: 18px;
            font-weight: bold;
            color: #C8102E;
            margin-bottom: 10px;
        }
        .plan-price {
            font-size: 20px;
            font-weight: bold;
            color: #DAA520;
            margin-bottom: 15px;
        }
        .status-section {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            background: #ffc107;
            color: #212529;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            text-transform: uppercase;
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
        .next-steps {
            background: #e8f5e8;
            border: 1px solid #d4edda;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }
        .next-steps h3 {
            color: #155724;
            margin-top: 0;
            margin-bottom: 15px;
        }
        .step {
            margin: 10px 0;
            padding-left: 20px;
            position: relative;
            color: #155724;
        }
        .step::before {
            content: "✓";
            position: absolute;
            left: 0;
            font-weight: bold;
            color: #28a745;
        }
        .contact-info {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .contact-info h3 {
            color: #1976d2;
            margin-top: 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .highlight {
            background: #fff;
            border: 2px dashed #DAA520;
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
            text-align: center;
        }
        .highlight strong {
            color: #C8102E;
            font-size: 16px;
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
        .list-group {
            margin: 10px 0;
            padding: 0;
        }
        .list-group-item {
            border: none;
            padding: 8px 0;
            background: transparent !important;
            color: #666;
            display: flex;
            align-items: center;
            list-style: none;
        }
        .list-group-item i {
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
            <h1>{{ __('plans.email.customer_confirmation.title', [], $locale) }}</h1>
            <p>{{ __('plans.email.customer_confirmation.subtitle', [], $locale) }}</p>
        </div>

        <div class="greeting">
            <h2>{{ __('plans.email.customer_confirmation.greeting', ['name' => $carrito->nombrecontacto], $locale) }}</h2>
            <p>{{ __('plans.email.customer_confirmation.thanks', [], $locale) }}</p>
        </div>

        <div class="plan-summary">
            <div class="plan-name">📦 {{ $plan->nombre }}</div>
            <div class="plan-price">
                💰 Valor: 
                @if($carrito->valorPagadoPesos > 0)
                    ${{ number_format($carrito->valorPagadoPesos, 0, ',', '.') }} COP
                @else
                    ${{ number_format($carrito->valorPagadoDolar, 2) }} USD
                @endif
            </div>
            @if($plan->descripcion)
                <div style="margin: 0; color: #666;">{!! $plan->descripcion !!}</div>
            @endif
        </div>

        <div class="status-section">
            <h3 style="margin-top: 0; color: #856404;">📋 Estado de tu Solicitud</h3>
            <span class="status-badge">{{ $carrito->estado }}</span>
            <p style="margin: 10px 0 0 0; color: #856404;">
                Tu solicitud está siendo procesada por nuestro equipo
            </p>
        </div>

        <div class="info-section">
            <h3>📋 {{ __('plans.email.customer_confirmation.plan_summary', [], $locale) }}</h3>
            <div class="info-item">
                <span class="info-label">{{ __('plans.email.customer_confirmation.request_id', [], $locale) }}:</span>
                <span class="info-value">#{{ str_pad($carrito->idCarrito, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">{{ __('plans.email.customer_confirmation.date', [], $locale) }}:</span>
                <span class="info-value">{{ $carrito->created_at->format('d/m/Y H:i:s') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">{{ __('plans.email.customer_confirmation.plan', [], $locale) }}:</span>
                <span class="info-value">{{ $plan->nombre }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">{{ __('plans.email.customer_confirmation.website', [], $locale) }}:</span>
                <span class="info-value">{{ $carrito->sitioweb }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">{{ __('plans.email.customer_confirmation.email', [], $locale) }}:</span>
                <span class="info-value">{{ $carrito->email }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">{{ __('plans.email.customer_confirmation.phone', [], $locale) }}:</span>
                <span class="info-value">{{ $carrito->movil }}</span>
            </div>
        </div>

        @if($plan->caracteristicas)
        <div class="info-section">
            <h3>✨ {{ __('plans.email.customer_confirmation.includes_title', [], $locale) }}</h3>
            @foreach(explode(',', $plan->caracteristicas) as $caracteristica)
                @if(trim($caracteristica))
                    <div style="margin: 5px 0; color: #155724;">• {{ trim($caracteristica) }}</div>
                @endif
            @endforeach
        </div>
        @endif

        <div class="next-steps">
            <h3>🚀 {{ __('plans.email.customer_confirmation.next_steps', [], $locale) }}</h3>
            <div class="step">{{ __('plans.email.customer_confirmation.step1', [], $locale) }}</div>
            <div class="step">{{ __('plans.email.customer_confirmation.step2', [], $locale) }}</div>
            <div class="step">{{ __('plans.email.customer_confirmation.step3', [], $locale) }}</div>
            <div class="step">{{ __('plans.email.customer_confirmation.step4', [], $locale) }}</div>
        </div>

        <div class="highlight">
            <strong>⏱️ {{ __('plans.email.customer_confirmation.contact_time', [], $locale) }}</strong><br>
            <small>{{ __('plans.email.customer_confirmation.contact_methods', ['phone' => $carrito->movil, 'email' => $carrito->email], $locale) }}</small>
        </div>

        <div class="contact-info">
            <h3>📞 {{ __('plans.email.customer_confirmation.questions_title', [], $locale) }}</h3>
            <p>{{ __('plans.email.customer_confirmation.questions_text', [], $locale) }}</p>
            <p>
                <strong>{{ __('plans.email.customer_confirmation.email', [], $locale) }}:</strong> {{ $empresa->email ?? config('app.support.email') }}<br>
                @if($empresa->movil)
                <strong>{{ __('plans.email.customer_confirmation.phone', [], $locale) }}:</strong> {{ $empresa->movil }}<br>
                @endif
            </p>
            <p><small>{{ __('plans.email.customer_confirmation.schedule', [], $locale) }}</small></p>
        </div>

        <div class="footer">
            <p><strong>{{ __('plans.email.customer_confirmation.thanks_footer', [], $locale) }}</strong></p>
            <p>{{ __('plans.email.customer_confirmation.excited', [], $locale) }}</p>
            <p>{{ __('plans.email.customer_confirmation.auto_generated', ['date' => now()->format('d/m/Y H:i:s')], $locale) }}</p>
            <hr style="margin: 20px 0; border: none; border-top: 1px solid #eee;">
            <p style="font-size: 12px; color: #999;">
                {{ __('plans.email.customer_confirmation.footer_text', [], $locale) }}<br>
                {{ __('plans.email.customer_confirmation.ignore_text', [], $locale) }}
            </p>
        </div>
    </div>
</body>
</html>