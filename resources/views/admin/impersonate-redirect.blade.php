<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abriendo Dashboard del Cliente...</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .container {
            text-align: center;
            padding: 2rem;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .message {
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }
        .user-name {
            font-weight: bold;
            color: #ffd700;
        }
        .close-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            cursor: pointer;
            margin-top: 1rem;
            transition: all 0.3s ease;
        }
        .close-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="spinner"></div>
        <div class="message">
            🔍 Abriendo Dashboard del Cliente
        </div>
        <div class="user-name">{{ $userName }}</div>
        <p style="opacity: 0.8; font-size: 0.9rem;">
            Se abrirá una nueva ventana con el dashboard del cliente.<br>
            Tu sesión de administrador permanecerá activa en esta pestaña.
        </p>
        <button class="close-btn" onclick="window.close()">
            Cerrar esta ventana
        </button>
    </div>

    <script>
        // Abrir nueva ventana con el dashboard del cliente
        const newWindow = window.open(
            '{{ $url }}', 
            'client_dashboard_{{ Str::random(8) }}',
            'width=1200,height=800,scrollbars=yes,resizable=yes,toolbar=no,menubar=no,location=no'
        );

        // Si la ventana se abrió correctamente
        if (newWindow) {
            // Opcional: cerrar esta ventana después de un breve delay
            setTimeout(() => {
                // Solo cerrar si el usuario no ha interactuado
                if (confirm('¿Deseas cerrar esta ventana? El dashboard del cliente ya se abrió en una nueva ventana.')) {
                    window.close();
                }
            }, 3000);
            
            // Cambiar el mensaje
            document.querySelector('.message').innerHTML = '✅ Dashboard del Cliente Abierto';
            document.querySelector('.spinner').style.display = 'none';
        } else {
            // Si no se pudo abrir la ventana (popup blocker)
            document.querySelector('.message').innerHTML = '⚠️ No se pudo abrir la ventana automáticamente';
            document.querySelector('.spinner').style.display = 'none';
            
            // Mostrar enlace manual
            const container = document.querySelector('.container');
            container.innerHTML += `
                <p style="margin-top: 1rem;">
                    Tu navegador bloqueó la ventana emergente.<br>
                    <a href="{{ $url }}" target="_blank" style="color: #ffd700; text-decoration: underline;">
                        Haz clic aquí para abrir el dashboard manualmente
                    </a>
                </p>
            `;
        }

        // Detectar cuando se cierra la ventana del cliente
        if (newWindow) {
            const checkClosed = setInterval(() => {
                if (newWindow.closed) {
                    clearInterval(checkClosed);
                    // Opcional: mostrar mensaje de confirmación
                    console.log('La ventana del cliente se cerró');
                }
            }, 1000);
        }
    </script>
</body>
</html>