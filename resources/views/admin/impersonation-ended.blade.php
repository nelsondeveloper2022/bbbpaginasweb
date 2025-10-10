<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impersonación Finalizada</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }
        .container {
            text-align: center;
            padding: 2rem;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            max-width: 500px;
        }
        .icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        .message {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        .user-name {
            font-weight: bold;
            color: #ffd700;
            font-size: 1.1rem;
        }
        .description {
            opacity: 0.9;
            margin: 1.5rem 0;
            line-height: 1.6;
        }
        .actions {
            margin-top: 2rem;
        }
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            margin: 0.5rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        .btn-primary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .btn-primary:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: transparent;
            color: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        .countdown {
            font-size: 0.9rem;
            opacity: 0.7;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">✅</div>
        <div class="message">
            Impersonación Finalizada
        </div>
        <div class="user-name">{{ $userName }}</div>
        
        <div class="description">
            Has salido del dashboard del cliente.<br>
            Tu sesión de administrador sigue activa en la pestaña original.
        </div>
        
        <div class="actions">
            <a href="{{ $adminDashboardUrl }}" class="btn btn-primary" target="_blank">
                🔗 Abrir Panel de Admin
            </a>
            <button onclick="window.close()" class="btn btn-secondary">
                ❌ Cerrar esta ventana
            </button>
        </div>
        
        <div class="countdown" id="countdown">
            Esta ventana se cerrará automáticamente en <span id="seconds">10</span> segundos...
        </div>
    </div>

    <script>
        let seconds = 10;
        const countdownElement = document.getElementById('seconds');
        const countdownContainer = document.getElementById('countdown');
        
        const countdown = setInterval(() => {
            seconds--;
            countdownElement.textContent = seconds;
            
            if (seconds <= 0) {
                clearInterval(countdown);
                window.close();
            }
        }, 1000);
        
        // Pausar el countdown si el usuario interactúa con la página
        document.addEventListener('click', () => {
            clearInterval(countdown);
            countdownContainer.innerHTML = 'Countdown pausado - puedes cerrar manualmente esta ventana';
        });
        
        // Intentar enfocar la ventana padre si existe
        if (window.opener && !window.opener.closed) {
            try {
                window.opener.focus();
            } catch (e) {
                console.log('No se pudo enfocar la ventana padre');
            }
        }
    </script>
</body>
</html>