<!DOCTYPE html>
<html lang="{{ $locale ?? 'es' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('plans.email.contact_notification.subject', ['customer' => $customerName], $locale ?? 'es') }}</title>
    <style>
        :root {
            --primary-red: #d22e23;
            --primary-gold: #f0ac21;
            --dark-bg: #2c3e50;
            --light-gray: #f8f9fa;
            --medium-gray: #6c757d;
            --white: #ffffff;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', 'Arial', sans-serif;
            background-color: var(--light-gray);
            color: #333;
        }
        .email-container {
            max-width: 650px;
            margin: 0 auto;
            background-color: var(--white);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(210, 46, 35, 0.15);
        }
        .header {
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-gold) 100%);
            color: white;
            padding: 35px 20px;
            text-align: center;
        }
        .company-name {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 1px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 400;
            opacity: 0.95;
            letter-spacing: 0.5px;
        }
        .urgent-badge {
            background: linear-gradient(135deg, var(--primary-red), #c41e3a);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 15px;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(210, 46, 35, 0.3);
        }
        .content {
            padding: 30px;
        }
        .alert-info {
            background: linear-gradient(135deg, rgba(240, 172, 33, 0.1), rgba(210, 46, 35, 0.05));
            border: 2px solid rgba(240, 172, 33, 0.3);
            color: var(--dark-bg);
            padding: 18px;
            border-radius: 10px;
            margin-bottom: 25px;
        }
        .client-info {
            background-color: var(--white);
            border: 2px solid rgba(240, 172, 33, 0.2);
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            box-shadow: 0 4px 15px rgba(210, 46, 35, 0.08);
        }
        .client-info h3 {
            color: var(--primary-red);
            margin-top: 0;
            margin-bottom: 18px;
            font-size: 20px;
            border-bottom: 3px solid var(--primary-gold);
            padding-bottom: 10px;
            font-weight: 700;
        }
        .info-row {
            display: flex;
            margin-bottom: 15px;
            border-bottom: 1px solid rgba(240, 172, 33, 0.2);
            padding-bottom: 10px;
        }
        .info-label {
            font-weight: 600;
            min-width: 130px;
            color: var(--dark-bg);
        }
        .info-value {
            flex: 1;
            color: #333;
        }
        .info-value a {
            color: var(--primary-red);
            text-decoration: none;
            font-weight: 500;
        }
        .info-value a:hover {
            color: var(--primary-gold);
            text-decoration: underline;
        }
        .message-box {
            background-color: var(--white);
            border: 2px solid var(--primary-gold);
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            box-shadow: 0 4px 15px rgba(240, 172, 33, 0.1);
        }
        .message-box h4 {
            color: var(--primary-red);
            margin-top: 0;
            margin-bottom: 18px;
            font-weight: 700;
            font-size: 18px;
        }
        .message-content {
            line-height: 1.6;
            font-style: italic;
            color: var(--dark-bg);
            background: linear-gradient(135deg, rgba(240, 172, 33, 0.08), rgba(210, 46, 35, 0.05));
            padding: 18px;
            border-radius: 8px;
            border-left: 4px solid var(--primary-gold);
        }
        .action-buttons {
            text-align: center;
            margin: 25px 0;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            margin: 8px 12px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-gold) 100%);
            color: white;
            box-shadow: 0 8px 25px rgba(210, 46, 35, 0.3);
        }
        .btn-success {
            background: linear-gradient(135deg, var(--primary-gold) 0%, #e09a1d 100%);
            color: var(--dark-bg);
            box-shadow: 0 8px 25px rgba(240, 172, 33, 0.3);
        }
        .btn:hover {
            transform: translateY(-3px);
            text-decoration: none;
            color: white;
        }
        .btn-success:hover {
            color: var(--dark-bg);
        }
        .footer {
            background: linear-gradient(135deg, var(--dark-bg) 0%, #34495e 100%);
            padding: 25px;
            text-align: center;
            color: #ecf0f1;
            font-size: 14px;
            border-top: 3px solid var(--primary-gold);
        }
        .company-footer {
            font-weight: 700;
            color: var(--primary-gold);
            margin-bottom: 8px;
            font-size: 16px;
        }
        .priority-high {
            color: var(--primary-red);
            font-weight: 700;
            background: rgba(210, 46, 35, 0.1);
            padding: 2px 8px;
            border-radius: 12px;
        }
        .stats-box {
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-gold) 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            margin: 25px 0;
            box-shadow: 0 8px 25px rgba(210, 46, 35, 0.2);
        }
        .tip-box {
            background: linear-gradient(135deg, rgba(240, 172, 33, 0.1), rgba(240, 172, 33, 0.05));
            border: 2px solid rgba(240, 172, 33, 0.3);
            padding: 18px;
            border-radius: 10px;
            margin-top: 25px;
            color: var(--dark-bg);
        }
        @media (max-width: 600px) {
            .content {
                padding: 20px 15px;
            }
            .info-row {
                flex-direction: column;
            }
            .info-label {
                margin-bottom: 5px;
            }
            .company-name {
                font-size: 20px;
            }
            .header h1 {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="urgent-badge">Nuevo Contacto</div>
            <div class="company-name">{{ $empresa->nombre ?? 'Empresa' }}</div>
            <h1>Notificación de Nuevo Contacto</h1>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="alert-info">
                <strong>📩 Nuevo mensaje recibido</strong><br>
                Fecha y hora: {{ $contactDate }}
            </div>

            <!-- Client Information -->
            <div class="client-info">
                <h3>Información del Cliente</h3>
                
                <div class="info-row">
                    <div class="info-label">Nombre completo:</div>
                    <div class="info-value"><strong>{{ $customerName }}</strong></div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">
                        <a href="mailto:{{ $customerEmail }}">{{ $customerEmail }}</a>
                    </div>
                </div>
                
                @if($customerPhone)
                <div class="info-row">
                    <div class="info-label">Teléfono:</div>
                    <div class="info-value">
                        <a href="tel:{{ $customerPhone }}">{{ $customerPhone }}</a>
                    </div>
                </div>
                @endif
                
                <div class="info-row">
                    <div class="info-label">País:</div>
                    <div class="info-value">{{ ucfirst($customerCountry) }}</div>
                </div>
                
                @if(!empty($customerPlan) && trim($customerPlan) !== '')
                <div class="info-row">
                    <div class="info-label">Plan de interés:</div>
                    <div class="info-value"><span class="priority-high">{{ ucfirst($customerPlan) }}</span></div>
                </div>
                @endif
            </div>

            <!-- Message Content -->
            <div class="message-box">
                <h4>Mensaje del Cliente</h4>
                <div class="message-content">
                    {{ $customerMessage }}
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="mailto:{{ $customerEmail }}?subject=Re: Contacto - {{ $empresa->nombre ?? 'Empresa' }}" class="btn btn-primary">
                    Responder por Email
                </a>
                @if($customerPhone)
                <a href="tel:{{ $customerPhone }}" class="btn btn-success">
                    Llamar Cliente
                </a>
                @endif
            </div>

            <!-- Quick Stats -->
            <div class="stats-box">
                <strong>Tiempo de Respuesta Recomendado</strong><br>
                <small>Responder dentro de las próximas 2 horas aumenta las conversiones en un 60%</small>
            </div>

            <div class="tip-box">
                <strong>💡 Consejo:</strong> 
                @if(!empty($customerPlan) && trim($customerPlan) !== '')
                    El cliente está interesado en el plan {{ ucfirst($customerPlan) }} desde {{ ucfirst($customerCountry) }}. Personaliza tu respuesta mencionando los beneficios específicos para su ubicación.
                @else
                    El cliente contacta desde {{ ucfirst($customerCountry) }}. Personaliza tu respuesta considerando su ubicación geográfica.
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="company-footer">{{ $empresa->nombre ?? 'Empresa' }}</div>
            <div>Sistema automatizado de notificaciones</div>
            @if($empresa->email)
            <div style="margin-top: 10px;">
                <small>Enviado a: {{ $empresa->email }}</small>
            </div>
            @endif
        </div>
    </div>
</body>
</html>