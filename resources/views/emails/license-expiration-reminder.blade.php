<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recordatorio de Expiración de Licencia</title>
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
        
        .warning-icon {
            font-size: 4rem;
            color: #f0ac21;
            margin: 20px 0;
        }
        
        .urgent-icon {
            font-size: 4rem;
            color: #d22e23;
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
        
        .alert-banner {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #f0ac21;
        }
        
        .alert-banner.urgent {
            background: #fff5f5;
            border-left-color: #d22e23;
        }
        
        .alert-banner.warning {
            background: #fffbf0;
            border-left-color: #f0ac21;
        }
        
        .user-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #f0ac21;
        }
        
        .user-info h3 {
            color: #d22e23;
            margin-bottom: 15px;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        
        .detail-value {
            color: #212529;
        }
        
        .expiration-warning {
            text-align: center;
            padding: 25px;
            margin: 20px 0;
            border-radius: 8px;
            background: linear-gradient(135deg, #d22e23, #f0ac21);
            color: white;
        }
        
        .days-remaining {
            font-size: 48px;
            font-weight: bold;
            margin: 10px 0;
            color: white;
        }
        
        .days-remaining.urgent {
            color: white;
        }
        
        .days-remaining.warning {
            color: white;
        }
        
        .days-remaining.info {
            color: white;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #f0ac21;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            margin: 15px 0;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            background: #d22e23;
            color: white;
        }
        
        .btn-primary {
            background: #d22e23;
        }
        
        .btn-primary:hover {
            background: #f0ac21;
        }
        
        .renewal-steps {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #f0ac21;
        }
        
        .renewal-steps h4 {
            color: #d22e23;
            margin-bottom: 15px;
        }
        
        .step {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px;
            background: white;
            border-radius: 5px;
        }
        
        .step-number {
            background: #d22e23;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .contact-info {
            margin: 20px 0;
        }
        
        .contact-item {
            display: inline-block;
            margin: 0 15px;
            color: #6c757d;
        }
        
        .contact-item a {
            color: #d22e23;
            text-decoration: none;
        }
        
        .contact-item a:hover {
            color: #f0ac21;
        }
        
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #dee2e6, transparent);
            margin: 30px 0;
        }
        
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            
            .container {
                padding: 20px;
            }
            
            .header {
                padding: 15px;
            }
            
            .title {
                font-size: 1.5rem;
            }
            
            .days-remaining {
                font-size: 36px;
            }
            
            .contact-item {
                display: block;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">BBB Páginas Web</div>
            @if($daysRemaining <= 1)
                <div class="urgent-icon">⚠️</div>
            @else
                <div class="warning-icon">�</div>
            @endif
            <h1 class="title">Recordatorio de Expiración</h1>
            <p class="subtitle">Tu licencia está próxima a vencer</p>
        </div>

        <!-- Alert Banner -->
        <div class="alert-banner {{ $daysRemaining <= 1 ? 'urgent' : 'warning' }}">
            <strong>
                @if($daysRemaining == 0)
                    ⚠️ Tu licencia expira HOY
                @elseif($daysRemaining == 1)
                    ⚠️ Tu licencia expira MAÑANA
                @else
                    📅 Tu licencia expira en {{ $daysRemaining }} días
                @endif
            </strong>
        </div>

        <h2>Hola {{ $user->name }},</h2>
        
        <p>Te escribimos para recordarte que tu {{ $licenseType === 'trial' ? 'período de prueba' : 'suscripción' }} está próxima a vencer.</p>

        <!-- User Information -->
        <div class="user-info">
            <h3>📋 Información de tu Licencia</h3>
            <div class="detail-row">
                <span class="detail-label">Usuario:</span>
                <span class="detail-value">{{ $user->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Email:</span>
                <span class="detail-value">{{ $user->email }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Empresa:</span>
                <span class="detail-value">{{ $user->empresa?->nombre ?? $user->empresa_nombre ?? 'No especificada' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Plan Actual:</span>
                <span class="detail-value">{{ $user->plan?->nombre ?? 'Plan Free' }}</span>
                </div>
            <div class="detail-row">
                <span class="detail-label">Fecha de Expiración:</span>
                <span class="detail-value">{{ $expirationDate?->format('d/m/Y H:i') ?? 'No definida' }}</span>
            </div>
        </div>

        <!-- Expiration Warning -->
        <div class="expiration-warning">
            <div class="days-remaining">
                {{ $daysRemaining }}
            </div>
            <p><strong>
                @if($daysRemaining == 0)
                    día restante (¡EXPIRA HOY!)
                @elseif($daysRemaining == 1)
                    día restante (¡EXPIRA MAÑANA!)
                @else
                    días restantes
                @endif
            </strong></p>
        </div>

        <!-- Call to Action -->
        <div style="text-align: center;">
            <h3>💳 Renueva tu Licencia Ahora</h3>
            <p>No pierdas el acceso a tu sitio web y todas las funcionalidades de BBB Páginas Web.</p>
            
            <a href="{{ $adminLoginUrl }}" class="btn btn-primary">
                🔐 Renovar Licencia
            </a>
            
            <p><small>Haz clic en el botón para acceder al panel y renovar tu plan</small></p>
        </div>

            <!-- Renewal Steps -->
            <div class="renewal-steps">
                <h4>📝 Pasos para Renovar</h4>
                
                <div class="step">
                    <div class="step-number">1</div>
                    <div>
                        <strong>Inicia Sesión</strong><br>
                        Accede a <a href="{{ $adminLoginUrl }}">{{ $adminLoginUrl }}</a> con tu email y contraseña
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">2</div>
                    <div>
                        <strong>Ve a Mi Plan</strong><br>
                        En el dashboard, busca la sección "Gestión de Mi Plan"
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">3</div>
                    <div>
                        <strong>Selecciona tu Plan</strong><br>
                        Elige el plan que mejor se adapte a tus necesidades
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">4</div>
                    <div>
                        <strong>Realiza el Pago</strong><br>
                        Completa el proceso de pago de forma segura con Wompi
                    </div>
                </div>
            </div>

            @if($daysRemaining <= 1)
            <div class="alert-banner urgent">
                <strong>⚠️ ATENCIÓN:</strong> Si no renuevas antes de la fecha de expiración, perderás el acceso a tu sitio web y todas las funcionalidades de la plataforma.
            </div>
            @endif

            <div style="text-align: center; margin-top: 30px;">
                <p><strong>¿Necesitas ayuda?</strong></p>
                <p>Nuestro equipo está aquí para asistirte en el proceso de renovación.</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <h4 style="color: #d22e23;">BBB Páginas Web</h4>
            <p>Creando presencia digital profesional para tu empresa</p>
            
            <div class="contact-info">
                <div class="contact-item">
                    📧 <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a>
                </div>
                <div class="contact-item">
                    📱 <a href="https://wa.me/{{ $supportWhatsApp }}">+{{ $supportWhatsApp }}</a>
                </div>
                <div class="contact-item">
                    🌐 <a href="{{ config('app.url') }}">{{ config('app.url') }}</a>
                </div>
            </div>
            
            <p style="font-size: 12px; color: #6c757d;">
                Este correo fue enviado automáticamente el {{ $currentDate }} (horario de Colombia).<br>
                No respondas a este email. Para soporte, contacta a {{ $supportEmail }}
            </p>
            
            <p style="font-size: 11px; color: #adb5bd; margin-top: 20px;">
                © {{ date('Y') }} BBB Páginas Web. Todos los derechos reservados.
            </p>
        </div>
    </div>
</body>
</html>