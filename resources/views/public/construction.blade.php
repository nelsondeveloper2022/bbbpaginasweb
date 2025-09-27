<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>En Construcción - {{ $empresa->nombre }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, rgb(225, 109, 34) 0%, #d4771a 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .construction-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .construction-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            text-align: center;
            max-width: 500px;
            margin: 2rem;
        }
        
        .construction-icon {
            font-size: 4rem;
            color: rgb(225, 109, 34);
            margin-bottom: 1.5rem;
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }
        
        .construction-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
        }
        
        .construction-subtitle {
            font-size: 1.25rem;
            color: rgb(225, 109, 34);
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        .construction-description {
            color: #666;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        
        .progress-bar-container {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 0.5rem;
            margin: 2rem 0;
        }
        
        .progress-bar {
            height: 10px;
            background: linear-gradient(90deg, rgb(225, 109, 34), #d4771a);
            border-radius: 5px;
            animation: loading 3s ease-in-out infinite;
        }
        
        @keyframes loading {
            0% { width: 0%; }
            50% { width: 70%; }
            100% { width: 100%; }
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
        
        .coming-soon {
            font-size: 0.9rem;
            color: #999;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="construction-container">
        <div class="construction-card">
            <div class="construction-icon">
                <i class="bi bi-tools"></i>
            </div>
            
            <h1 class="construction-title">En Construcción</h1>
            <h2 class="construction-subtitle">{{ $empresa->nombre }}</h2>
            
            <p class="construction-description">
                Estamos trabajando en algo increíble para ti. Nuestra nueva página web estará disponible muy pronto 
                con una experiencia completamente renovada.
            </p>
            
            <div class="progress-bar-container">
                <div class="progress-bar"></div>
            </div>
            
            <div class="coming-soon">
                <i class="bi bi-clock me-1"></i>
                Próximamente disponible
            </div>
            
            @if($empresa->email || $empresa->telefono)
            <div class="contact-info">
                <h5><i class="bi bi-envelope me-2"></i>Mantente en contacto</h5>
                @if($empresa->email)
                    <p><strong>Email:</strong> {{ $empresa->email }}</p>
                @endif
                @if($empresa->telefono)
                    <p><strong>Teléfono:</strong> {{ $empresa->telefono }}</p>
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