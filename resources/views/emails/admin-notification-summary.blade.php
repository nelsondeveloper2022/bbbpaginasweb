<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de Notificaciones de Expiración - BBB Páginas Web</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
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
        
        .admin-icon {
            font-size: 3rem;
            color: #f0ac21;
            margin: 15px 0;
        }
        
        .title {
            color: #d22e23;
            font-size: 1.8rem;
            margin-bottom: 10px;
        }
        
        .subtitle {
            color: #6c757d;
            font-size: 1rem;
            margin-bottom: 20px;
        }
        
        .stats-summary {
            background: linear-gradient(135deg, #d22e23, #f0ac21);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            display: block;
        }
        
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .expiring-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #f0ac21;
        }
        
        .expiring-section.urgent {
            border-left-color: #d22e23;
            background: #fff5f5;
        }
        
        .expiring-section h3 {
            color: #d22e23;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }
        
        .account-item {
            background: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-left: 3px solid #f0ac21;
        }
        
        .account-item.urgent {
            border-left-color: #d22e23;
        }
        
        .account-name {
            font-weight: bold;
            color: #d22e23;
            font-size: 1.1rem;
        }
        
        .account-details {
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 5px;
        }
        
        .account-details strong {
            color: #495057;
        }
        
        .license-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: bold;
            margin-left: 10px;
        }
        
        .license-badge.trial {
            background: #fff3cd;
            color: #856404;
        }
        
        .license-badge.subscription {
            background: #d1ecf1;
            color: #0c5460;
        }
            margin: 20px 0;
        }
        
        .stat-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            border-left: 4px solid #007bff;
        }
        
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #495057;
            font-size: 14px;
        }
        
        .table-container {
            margin: 30px 0;
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        th {
            background: #007bff;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #e9ecef;
        }
        
        tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        tr:hover {
            background: #e3f2fd;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .badge-trial {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-subscription {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-5-days {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .badge-3-days {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-1-day {
            background: #f8d7da;
            color: #721c24;
        }
        
        .section-title {
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin: 30px 0 20px 0;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .footer h4 {
            color: #d22e23;
            margin-bottom: 10px;
        }
        
        .contact-info {
            margin: 15px 0;
        }
        
        .contact-info a {
            color: #d22e23;
            text-decoration: none;
        }
        
        .contact-info a:hover {
            color: #f0ac21;
        }
        
        .empty-section {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            font-style: italic;
        }
        
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            
            .container {
                padding: 20px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .account-item {
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">BBB Páginas Web</div>
            <div class="admin-icon">📊</div>
            <h1 class="title">Resumen de Notificaciones de Expiración</h1>
            <p class="subtitle">Procesamiento automático del {{ $summary['process_time'] }}</p>
        </div>

        <!-- Stats Summary -->
        <div class="stats-summary">
            <h2 style="margin-bottom: 15px;">📈 Resumen Ejecutivo</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-number">{{ $summary['total'] }}</span>
                    <span class="stat-label">Total Notificaciones</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $summary['stats']['total_5_days'] }}</span>
                    <span class="stat-label">5 Días</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $summary['stats']['total_3_days'] }}</span>
                    <span class="stat-label">3 Días</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $summary['stats']['total_1_day'] }}</span>
                    <span class="stat-label">1 Día</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $summary['stats']['trial_accounts'] }}</span>
                    <span class="stat-label">Trials</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $summary['stats']['subscription_accounts'] }}</span>
                    <span class="stat-label">Suscripciones</span>
                </div>
            </div>
        </div>

        @if($summary['total'] == 0)
            <div class="empty-section">
                <h3>✅ Sin Notificaciones Pendientes</h3>
                <p>Todos los usuarios tienen licencias vigentes por más de 5 días.</p>
            </div>
        @else
            <!-- Cuentas que vencen en 1 día -->
            @if(!empty($summary['accounts_expiring']['1_day']))
            <div class="expiring-section urgent">
                <h3>🚨 Cuentas a vencer en 1 día ({{ $summary['stats']['total_1_day'] }})</h3>
                @foreach($summary['accounts_expiring']['1_day'] as $account)
                    <div class="account-item urgent">
                        <div class="account-name">{{ $account['name'] }}</div>
                        <div class="account-details">
                            <strong>Email:</strong> {{ $account['email'] }} | 
                            <strong>Empresa:</strong> {{ $account['empresa'] }} | 
                            <strong>Plan:</strong> {{ $account['plan'] }}
                            <span class="license-badge {{ $account['license_type'] }}">
                                {{ $account['license_type'] === 'trial' ? 'TRIAL' : 'SUSCRIPCIÓN' }}
                            </span>
                            <br><strong>Expira:</strong> {{ \Carbon\Carbon::parse($account['expiration_date'])->format('d/m/Y H:i') }}
                        </div>
                    </div>
                @endforeach
            </div>
            @endif

            <!-- Cuentas que vencen en 3 días -->
            @if(!empty($summary['accounts_expiring']['3_days']))
            <div class="expiring-section">
                <h3>⚠️ Cuentas a vencer en 3 días ({{ $summary['stats']['total_3_days'] }})</h3>
                @foreach($summary['accounts_expiring']['3_days'] as $account)
                    <div class="account-item">
                        <div class="account-name">{{ $account['name'] }}</div>
                        <div class="account-details">
                            <strong>Email:</strong> {{ $account['email'] }} | 
                            <strong>Empresa:</strong> {{ $account['empresa'] }} | 
                            <strong>Plan:</strong> {{ $account['plan'] }}
                            <span class="license-badge {{ $account['license_type'] }}">
                                {{ $account['license_type'] === 'trial' ? 'TRIAL' : 'SUSCRIPCIÓN' }}
                            </span>
                            <br><strong>Expira:</strong> {{ \Carbon\Carbon::parse($account['expiration_date'])->format('d/m/Y H:i') }}
                        </div>
                    </div>
                @endforeach
            </div>
            @endif

            <!-- Cuentas que vencen en 5 días -->
            @if(!empty($summary['accounts_expiring']['5_days']))
            <div class="expiring-section">
                <h3>📅 Cuentas a vencer en 5 días ({{ $summary['stats']['total_5_days'] }})</h3>
                @foreach($summary['accounts_expiring']['5_days'] as $account)
                    <div class="account-item">
                        <div class="account-name">{{ $account['name'] }}</div>
                        <div class="account-details">
                            <strong>Email:</strong> {{ $account['email'] }} | 
                            <strong>Empresa:</strong> {{ $account['empresa'] }} | 
                            <strong>Plan:</strong> {{ $account['plan'] }}
                            <span class="license-badge {{ $account['license_type'] }}">
                                {{ $account['license_type'] === 'trial' ? 'TRIAL' : 'SUSCRIPCIÓN' }}
                            </span>
                            <br><strong>Expira:</strong> {{ \Carbon\Carbon::parse($account['expiration_date'])->format('d/m/Y H:i') }}
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
        @endif

        <!-- Footer -->
        <div class="footer">
            <h4>BBB Páginas Web</h4>
            <p>Sistema Automático de Notificaciones de Expiración</p>
            
            <div class="contact-info">
                <p>📧 <a href="mailto:{{ $supportEmail ?? env('EMAIL_SOPORTE_CONTACTO') }}">{{ $supportEmail ?? env('EMAIL_SOPORTE_CONTACTO') }}</a></p>
                <p>🔗 <a href="{{ $appUrl ?? config('app.url') }}">Panel Administrativo</a></p>
            </div>
            
            <p style="font-size: 11px; color: #adb5bd; margin-top: 15px;">
                Este correo se genera automáticamente cuando se procesan notificaciones de expiración.<br>
                © {{ date('Y') }} BBB Páginas Web. Todos los derechos reservados.
            </p>
        </div>
    </div>
</body>
</html>