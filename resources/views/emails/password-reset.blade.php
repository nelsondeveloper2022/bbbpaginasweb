<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restablecer contraseña - BBB Páginas Web</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
        }
        .email-wrapper {
            background-color: #f8f9fa;
            padding: 40px 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #d22e23 0%, #f0ac21 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .email-header img {
            max-width: 180px;
            height: auto;
            margin-bottom: 10px;
        }
        .email-header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .email-body {
            padding: 40px 30px;
        }
        .email-body h2 {
            color: #d22e23;
            font-size: 22px;
            margin-top: 0;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .email-body p {
            color: #555;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .btn-container {
            text-align: center;
            margin: 35px 0;
        }
        .btn {
            display: inline-block;
            padding: 16px 40px;
            background: linear-gradient(135deg, #d22e23 0%, #f0ac21 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 5px 15px rgba(210, 46, 35, 0.3);
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(210, 46, 35, 0.4);
        }
        .alternative-link {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
            border-left: 4px solid #f0ac21;
        }
        .alternative-link p {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #666;
        }
        .alternative-link a {
            color: #d22e23;
            word-break: break-all;
            font-size: 13px;
        }
        .security-notice {
            background-color: #fff3cd;
            border-left: 4px solid #f0ac21;
            padding: 15px;
            margin: 25px 0;
            border-radius: 6px;
        }
        .security-notice p {
            margin: 0;
            font-size: 14px;
            color: #856404;
        }
        .email-footer {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .email-footer p {
            margin: 5px 0;
            font-size: 14px;
            color: #ecf0f1;
        }
        .email-footer a {
            color: #f0ac21;
            text-decoration: none;
        }
        .email-footer .social-links {
            margin-top: 20px;
        }
        .email-footer .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #f0ac21;
            font-size: 20px;
        }
        @media only screen and (max-width: 600px) {
            .email-wrapper {
                padding: 20px 10px;
            }
            .email-body {
                padding: 30px 20px;
            }
            .btn {
                padding: 14px 30px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <!-- Header -->
            <div class="email-header">
                <img src="https://bbbpaginasweb.com/images/logo-bbb.png" alt="BBB Páginas Web">
                <h1>Restablecimiento de Contraseña</h1>
            </div>

            <!-- Body -->
            <div class="email-body">
                <h2>Hola, {{ $user->name ?? 'Usuario' }}!</h2>
                
                <p>Has solicitado restablecer tu contraseña para tu cuenta en BBB Páginas Web.</p>
                
                <p>Para crear una nueva contraseña, simplemente haz clic en el botón de abajo:</p>

                <div class="btn-container">
                    <a href="{{ $url }}" class="btn">Restablecer Mi Contraseña</a>
                </div>

                <div class="security-notice">
                    <p><strong>⏰ Este enlace expirará en 60 minutos</strong> por razones de seguridad.</p>
                </div>

                <div class="alternative-link">
                    <p><strong>¿El botón no funciona?</strong></p>
                    <p>Copia y pega el siguiente enlace en tu navegador:</p>
                    <a href="{{ $url }}">{{ $url }}</a>
                </div>

                <p style="margin-top: 30px; font-size: 15px; color: #666;">
                    Si <strong>no solicitaste</strong> este cambio de contraseña, puedes ignorar este correo de forma segura. Tu contraseña permanecerá sin cambios.
                </p>
            </div>

            <!-- Footer -->
            <div class="email-footer">
                <p><strong>Equipo BBB Páginas Web</strong></p>
                <p>Potenciamos tu negocio con páginas web profesionales</p>
                <p style="margin-top: 15px;">
                    <a href="https://bbbpaginasweb.com">www.bbbpaginasweb.com</a> | 
                    <a href="mailto:soporte@bbbpaginasweb.com">soporte@bbbpaginasweb.com</a>
                </p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
