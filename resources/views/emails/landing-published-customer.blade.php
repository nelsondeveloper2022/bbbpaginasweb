<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Tu Landing Page está lista!</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .header {
            background: linear-gradient(135deg, #d22e23, #f0ac21);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: white;
            padding: 30px;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #d22e23, #f0ac21);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #d22e23;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
        .whatsapp-link {
            background: #25d366;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin: 10px 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🚀 ¡Tu Landing Page está lista!</h1>
        <p>{{ $empresa->nombre }}</p>
    </div>

    <div class="content">
        <p>Hola <strong>{{ $user->name }}</strong>,</p>

        <p>¡Excelentes noticias! Tu landing page ha sido completamente configurada y ya está <strong>publicada y activa</strong>.</p>

        <div class="info-box">
            <h3>🌐 Tu nueva página web:</h3>
            <p><strong>URL:</strong> <a href="{{ $landingUrl }}" target="_blank">{{ $landingUrl }}</a></p>
            <p><strong>Título:</strong> {{ $landing->titulo_principal }}</p>
            @if($landing->subtitulo)
                <p><strong>Subtítulo:</strong> {{ $landing->subtitulo }}</p>
            @endif
        </div>

        <div style="text-align: center;">
            <a href="{{ $landingUrl }}" class="cta-button" target="_blank">
                👁️ Ver mi Landing Page
            </a>
        </div>

        <h3>✨ ¿Qué puedes hacer ahora?</h3>
        <ul>
            <li><strong>Compartir tu URL</strong> en redes sociales y con tus contactos</li>
            <li><strong>Actualizar tu información empresarial</strong> cuando lo necesites</li>
            <li><strong>Agregar o cambiar tus redes sociales</strong> desde tu panel</li>
            <li><strong>Monitorear</strong> las visitas y contactos que recibas</li>
        </ul>

        <div class="info-box">
            <h4>📱 ¿Necesitas ayuda o tienes alguna pregunta?</h4>
            <p>Nuestro equipo está disponible para apoyarte:</p>
            <div style="text-align: center;">
                <a href="https://wa.me/{{ config('app.support.mobile') }}?text=Hola%2C%20mi%20landing%20page%20ya%20está%20publicada%20y%20tengo%20una%20consulta" class="whatsapp-link" target="_blank">
                    📱 Escribir por WhatsApp
                </a>
                <a href="mailto:{{ config('app.support.email') }}" class="whatsapp-link" style="background: #007bff;">
                    ✉️ Enviar Email
                </a>
            </div>
        </div>

        <h3>🎯 Próximos pasos recomendados:</h3>
        <ol>
            <li>Visita tu landing page y verifica que todo esté perfecto</li>
            <li>Comparte la URL con tus contactos y en redes sociales</li>
            <li>Considera adquirir tu propio dominio personalizado</li>
            <li>Explora nuestros planes premium para más funcionalidades</li>
        </ol>

        <p>¡Felicitaciones por dar este gran paso para tu negocio!</p>

        <p style="margin-top: 30px;">
            Saludos cordiales,<br>
            <strong>El equipo de BBB Páginas Web</strong>
        </p>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} BBB Páginas Web - Creamos tu presencia digital</p>
        <p>Si no puedes ver este email correctamente, <a href="{{ $landingUrl }}" target="_blank">haz clic aquí</a></p>
    </div>
</body>
</html>