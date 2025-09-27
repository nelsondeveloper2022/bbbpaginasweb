<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica tu email - BBB</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, rgb(225, 109, 34) 0%, rgb(195, 89, 14) 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 40px 30px;
        }
        .content h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .verify-button {
            display: inline-block;
            background: linear-gradient(135deg, rgb(225, 109, 34) 0%, rgb(195, 89, 14) 100%);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
            transition: transform 0.2s;
            box-shadow: 0 4px 15px rgba(225, 109, 34, 0.3);
        }
        .verify-button:hover {
            transform: translateY(-2px);
            text-decoration: none;
            color: white;
            box-shadow: 0 6px 20px rgba(225, 109, 34, 0.4);
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid rgb(225, 109, 34);
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .token-info {
            background: rgba(225, 109, 34, 0.1);
            border: 1px solid rgba(225, 109, 34, 0.3);
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 ¡Bienvenido a BBB!</h1>
        </div>
        
        <div class="content">
            <h2>Hola {{ $user->name }},</h2>
            
            <p>Gracias por registrarte en <strong>BBB</strong>. Para completar tu registro y poder publicar tu sitio web, necesitamos verificar tu dirección de correo electrónico.</p>
            
            <div class="info-box">
                <strong>¿Por qué necesitas verificar tu email?</strong><br>
                La verificación nos ayuda a mantener tu cuenta segura y te permite acceder a todas las funcionalidades de BBB, incluyendo la publicación de tu sitio web.
            </div>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $verificationUrl }}" class="verify-button">
                    ✅ Verificar mi Email
                </a>
            </div>
            
            <p>Si el botón no funciona, también puedes copiar y pegar el siguiente enlace en tu navegador:</p>
            
            <div class="token-info">
                {{ $verificationUrl }}
            </div>
            
            <div class="info-box">
                <strong>⚠️ Importante:</strong><br>
                • Este enlace expirará en 24 horas<br>
                • Solo puedes usar este enlace una vez<br>
                • Si no verificas tu email, no podrás publicar tu sitio web
            </div>
            
            <p>Si no solicitaste esta verificación, puedes ignorar este correo de forma segura.</p>
            
            <p>¡Gracias por elegir BBB para tu presencia digital!</p>
            
            <p><strong>El equipo de BBB</strong></p>
        </div>
        
        <div class="footer">
            <p>Este es un email automático, por favor no respondas a este mensaje.</p>
            <p>Si tienes alguna pregunta, contacta nuestro equipo de soporte.</p>
            <p>&copy; {{ date('Y') }} BBB - Todos los derechos reservados</p>
        </div>
    </div>
</body>
</html>