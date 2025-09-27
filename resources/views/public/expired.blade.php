<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página No Disponible - {{ $empresa->nombre }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, rgb(225, 109, 34) 0%, rgb(195, 85, 25) 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .expired-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .expired-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            text-align: center;
            max-width: 500px;
            margin: 2rem;
        }
        
        .expired-icon {
            font-size: 4rem;
            color: rgb(225, 109, 34);
            margin-bottom: 1.5rem;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.7;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        .expired-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
        }
        
        .expired-subtitle {
            font-size: 1.25rem;
            color: rgb(225, 109, 34);
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        .expired-description {
            color: #666;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        
        .contact-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 2rem;
        }
        
        .contact-info h5 {
            color: #333;
            margin-bottom: 1rem;
        }
        
        .contact-info p {
            color: #666;
            margin: 0.5rem 0;
        }
        
        .contact-info a {
            color: rgb(225, 109, 34);
            text-decoration: none;
        }
        
        .contact
            color: #856404;
        }
        
        .renewal-notice strong {
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="expired-container">
        <div class="expired-card">
            <div class="expired-icon">
                <i class="bi bi-clock-history"></i>
            </div>
            
            <h1 class="expired-title">Página No Disponible</h1>
            <h2 class="expired-subtitle">{{ $empresa->nombre }}</h2>
            
            <p class="expired-description">
                Lo sentimos, la página web de esta empresa no está disponible temporalmente. 
                El servicio puede haber vencido y necesita renovación.
            </p>
            
            <div class="renewal-notice">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Nota:</strong> Si eres el propietario de este sitio, por favor renueva tu servicio para restaurar el acceso.
            </div>
            
            @if($empresa->email || $empresa->telefono)
            <div class="contact-info">
                <h5><i class="bi bi-telephone me-2"></i>Información de Contacto</h5>
                <p class="mb-2">Puedes contactar directamente con la empresa:</p>
                @if($empresa->email)
                    <p><strong>Email:</strong> <a href="mailto:{{ $empresa->email }}">{{ $empresa->email }}</a></p>
                @endif
                @if($empresa->telefono)
                    <p><strong>Teléfono:</strong> <a href="tel:{{ $empresa->telefono }}">{{ $empresa->telefono }}</a></p>
                @endif
                @if($empresa->direccion)
                    <p><strong>Dirección:</strong> {{ $empresa->direccion }}</p>
                @endif
            </div>
            @endif
        </div>
    </div>
</body>
</html>