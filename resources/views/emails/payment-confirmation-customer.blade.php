<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Confirmado - BBB Páginas Web</title>
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
            border-bottom: 3px solid #d22e23;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 2rem;
            font-weight: bold;
            color: #d22e23;
        }
        .success-icon {
            font-size: 4rem;
            color: #28a745;
            margin: 20px 0;
        }
        .title {
            color: #d22e23;
            font-size: 1.8rem;
            margin-bottom: 10px;
        }
        .subtitle {
            color: #6c757d;
            font-size: 1rem;
            margin-bottom: 30px;
        }
        .payment-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #f0ac21;
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
            font-size: 1.1rem;
            color: #d22e23;
        }
        .detail-label {
            font-weight: 600;
            color: #495057;
        }
        .detail-value {
            color: #212529;
        }
        .plan-info {
            background: linear-gradient(135deg, #d22e23, #f0ac21);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
        }
        .plan-name {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 0.9rem;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #f0ac21;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 10px 0;
        }
        .btn:hover {
            background: #e09a1d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">BBB Páginas Web</div>
            <div class="success-icon">✅</div>
            <h1 class="title">¡Pago Confirmado!</h1>
            <p class="subtitle">Tu pago ha sido procesado exitosamente</p>
        </div>

        <div class="content">
            <p>Hola <strong>{{ $user->name }}</strong>,</p>
            
            <p>¡Excelente noticia! Hemos recibido y confirmado tu pago. Tu plan ya está activo y puedes comenzar a disfrutar de todos los beneficios.</p>

            <div class="plan-info">
                <div class="plan-name">{{ $plan->nombre }}</div>
                <p>{{ strip_tags($plan->descripcion) }}</p>
            </div>

            <div class="payment-details">
                <h3 style="margin-top: 0; color: #d22e23;">Detalles del Pago</h3>
                
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
                    <span class="detail-label">Plan Adquirido:</span>
                    <span class="detail-value">{{ $plan->nombre }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Monto Pagado:</span>
                    <span class="detail-value">${{ $amount }} COP</span>
                </div>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('dashboard') }}" class="btn">Acceder a mi Dashboard</a>
            </div>

            <p><strong>¿Qué sigue ahora?</strong></p>
            <ul>
                <li>✅ Tu plan está activo inmediatamente</li>
                <li>🎨 Puedes configurar tu landing page desde el dashboard</li>
                <li>🚀 Una vez configurada, podrás publicar tu sitio web</li>
                <li>📞 Si tienes dudas, nuestro soporte está disponible</li>
            </ul>

            <p>Si tienes alguna pregunta o necesitas ayuda, no dudes en contactarnos:</p>
            <ul>
                <li>📧 Email: <a href="mailto:{{ config('app.support.email') }}">{{ config('app.support.email') }}</a></li>
                <li>💬 WhatsApp: <a href="https://wa.me/{{ config('app.support.mobile') }}">+{{ substr(config('app.support.mobile'), 0, 2) }} {{ substr(config('app.support.mobile'), 2, 3) }} {{ substr(config('app.support.mobile'), 5, 3) }} {{ substr(config('app.support.mobile'), 8) }}</a></li>
            </ul>
        </div>

        <div class="footer">
            <p><strong>¡Gracias por confiar en BBB Páginas Web!</strong></p>
            <p>Este es un email automático, por favor no respondas a este mensaje.</p>
            <p>&copy; {{ date('Y') }} BBB Páginas Web. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>