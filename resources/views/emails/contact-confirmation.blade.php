<!DOCTYPE html>
<html lang="{{ $locale ?? 'es' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Contacto</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style>
        /* Reset styles */
        body, table, td, p, a, li, blockquote {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        /* Main styles */
        body {
            margin: 0 !important;
            padding: 0 !important;
            background-color: #f8f9fa !important;
            font-family: Arial, sans-serif !important;
        }
        
        .email-wrapper {
            background-color: #f8f9fa;
            padding: 20px 0;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }
        
        /* Header */
        .header-table {
            background-color: #d22e23;
            width: 100%;
        }
        
        .company-name {
            color: #ffffff !important;
            font-size: 28px !important;
            font-weight: bold !important;
            text-align: center !important;
            padding: 20px 20px 10px 20px !important;
            margin: 0 !important;
        }
        
        .header-title {
            color: #ffffff !important;
            font-size: 20px !important;
            font-weight: normal !important;
            text-align: center !important;
            padding: 0 20px 20px 20px !important;
            margin: 0 !important;
        }
        
        .badge {
            background-color: #f0ac21 !important;
            color: #2c3e50 !important;
            padding: 8px 16px !important;
            border-radius: 20px !important;
            font-size: 12px !important;
            font-weight: bold !important;
            text-align: center !important;
            margin: 15px auto 0 auto !important;
            display: inline-block !important;
        }
        
        /* Content */
        .content-table {
            width: 100%;
            padding: 30px;
        }
        
        .alert-box {
            background-color: #fff3cd !important;
            border: 2px solid #f0ac21 !important;
            border-radius: 8px !important;
            padding: 15px !important;
            margin-bottom: 20px !important;
            color: #2c3e50 !important;
        }
        
        .greeting {
            color: #d22e23 !important;
            font-size: 18px !important;
            font-weight: bold !important;
            margin: 20px 0 15px 0 !important;
        }
        
        .message-text {
            color: #333333 !important;
            font-size: 16px !important;
            line-height: 1.6 !important;
            margin: 15px 0 !important;
        }
        
        /* Info box */
        .info-box {
            background-color: #ffffff !important;
            border: 2px solid #f0ac21 !important;
            border-radius: 8px !important;
            padding: 20px !important;
            margin: 20px 0 !important;
        }
        
        .info-title {
            color: #d22e23 !important;
            font-size: 18px !important;
            font-weight: bold !important;
            margin: 0 0 15px 0 !important;
            border-bottom: 2px solid #f0ac21 !important;
            padding-bottom: 8px !important;
        }
        
        .info-row {
            margin: 10px 0 !important;
            padding: 8px 0 !important;
            border-bottom: 1px solid #f0f0f0 !important;
        }
        
        .info-label {
            color: #2c3e50 !important;
            font-weight: bold !important;
            display: inline-block !important;
            width: 130px !important;
            vertical-align: top !important;
        }
        
        .info-value {
            color: #333333 !important;
            display: inline-block !important;
        }
        
        /* Message box */
        .message-box {
            background-color: #ffffff !important;
            border: 2px solid #f0ac21 !important;
            border-radius: 8px !important;
            padding: 20px !important;
            margin: 20px 0 !important;
        }
        
        .message-title {
            color: #d22e23 !important;
            font-size: 16px !important;
            font-weight: bold !important;
            margin: 0 0 15px 0 !important;
        }
        
        .message-content {
            background-color: #f8f9fa !important;
            border-left: 4px solid #f0ac21 !important;
            padding: 15px !important;
            border-radius: 5px !important;
            color: #2c3e50 !important;
            font-style: italic !important;
        }
        
        /* Stats box */
        .stats-box {
            background-color: #d22e23 !important;
            color: #ffffff !important;
            padding: 20px !important;
            border-radius: 8px !important;
            text-align: center !important;
            margin: 20px 0 !important;
        }
        
        .stats-title {
            font-size: 16px !important;
            font-weight: bold !important;
            margin: 0 0 5px 0 !important;
        }
        
        .stats-text {
            font-size: 14px !important;
            margin: 0 !important;
        }
        
        /* Button */
        .button-table {
            text-align: center !important;
            margin: 25px 0 !important;
        }
        
        .cta-button {
            background-color: #d22e23 !important;
            color: #ffffff !important;
            padding: 15px 30px !important;
            text-decoration: none !important;
            border-radius: 25px !important;
            font-weight: bold !important;
            font-size: 16px !important;
            display: inline-block !important;
        }
        
        /* Tip box */
        .tip-box {
            background-color: #fff3cd !important;
            border: 2px solid #f0ac21 !important;
            border-radius: 8px !important;
            padding: 15px !important;
            margin: 20px 0 !important;
            color: #2c3e50 !important;
        }
        
        /* Footer */
        .footer-table {
            background-color: #2c3e50 !important;
            width: 100%;
            padding: 25px !important;
        }
        
        .footer-company {
            color: #f0ac21 !important;
            font-size: 16px !important;
            font-weight: bold !important;
            text-align: center !important;
            margin: 0 0 10px 0 !important;
        }
        
        .footer-text {
            color: #ecf0f1 !important;
            font-size: 14px !important;
            text-align: center !important;
            margin: 5px 0 !important;
        }
        
        .footer-small {
            color: #95a5a6 !important;
            font-size: 12px !important;
            text-align: center !important;
            margin: 15px 0 0 0 !important;
        }

        /* Mobile responsive */
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                margin: 0 !important;
            }
            .content-table {
                padding: 20px 15px !important;
            }
            .company-name {
                font-size: 24px !important;
            }
            .header-title {
                font-size: 18px !important;
            }
            .info-label {
                display: block !important;
                width: 100% !important;
                margin-bottom: 5px !important;
            }
            .info-value {
                display: block !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f8f9fa; font-family: Arial, sans-serif;")
    <!-- Gmail/Outlook compatible structure using tables -->
    <div class="email-wrapper">
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
            <tr>
                <td align="center">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" class="email-container" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden;">
                        
                        <!-- Header -->
                        <tr>
                            <td>
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" class="header-table">
                                    <tr>
                                        <td align="center" style="padding: 15px;">
                                            <div class="badge" style="background-color: #f0ac21; color: #2c3e50; padding: 8px 16px; border-radius: 20px; font-size: 12px; font-weight: bold; display: inline-block;">
                                                ✅ Confirmación Recibida
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="company-name" style="color: #ffffff; font-size: 28px; font-weight: bold; text-align: center; padding: 10px 20px; margin: 0;">
                                            {{ $empresa->nombre ?? 'Empresa' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="header-title" style="color: #ffffff; font-size: 20px; font-weight: normal; text-align: center; padding: 0 20px 20px 20px; margin: 0;">
                                            ¡Gracias por Contactarnos!
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <!-- Main Content -->
                        <tr>
                            <td>
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" class="content-table">
                                    <tr>
                                        <td style="padding: 30px;">
                                            
                                            <!-- Alert Box -->
                                            <div class="alert-box" style="background-color: #fff3cd; border: 2px solid #f0ac21; border-radius: 8px; padding: 15px; margin-bottom: 20px; color: #2c3e50;">
                                                <strong>✅ Tu mensaje ha sido recibido exitosamente</strong><br>
                                                Fecha y hora: {{ $contactDate }}
                                            </div>

                                            <!-- Greeting -->
                                            <div class="greeting" style="color: #d22e23; font-size: 18px; font-weight: bold; margin: 20px 0 15px 0;">
                                                ¡Hola {{ $customerName }}!
                                            </div>

                                            <!-- Message -->
                                            <div class="message-text" style="color: #333333; font-size: 16px; line-height: 1.6; margin: 15px 0;">
                                                Gracias por contactar con {{ $empresa->nombre ?? 'nuestra empresa' }}. Tu consulta es muy importante para nosotros y queremos asegurarte que hemos recibido toda la información correctamente.
                                            </div>

                                            <!-- Client Information -->
                                            <div class="info-box" style="background-color: #ffffff; border: 2px solid #f0ac21; border-radius: 8px; padding: 20px; margin: 20px 0;">
                                                <div class="info-title" style="color: #d22e23; font-size: 18px; font-weight: bold; margin: 0 0 15px 0; border-bottom: 2px solid #f0ac21; padding-bottom: 8px;">
                                                    Resumen de tu Consulta
                                                </div>
                                                
                                                <div class="info-row" style="margin: 10px 0; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                                                    <span class="info-label" style="color: #2c3e50; font-weight: bold; display: inline-block; width: 130px; vertical-align: top;">Nombre completo:</span>
                                                    <span class="info-value" style="color: #333333; display: inline-block;"><strong>{{ $customerName }}</strong></span>
                                                </div>
                                                
                                                <div class="info-row" style="margin: 10px 0; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                                                    <span class="info-label" style="color: #2c3e50; font-weight: bold; display: inline-block; width: 130px; vertical-align: top;">Email de contacto:</span>
                                                    <span class="info-value" style="color: #333333; display: inline-block;">{{ $customerEmail }}</span>
                                                </div>
                                                
                                                @if($customerPhone)
                                                <div class="info-row" style="margin: 10px 0; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                                                    <span class="info-label" style="color: #2c3e50; font-weight: bold; display: inline-block; width: 130px; vertical-align: top;">Teléfono:</span>
                                                    <span class="info-value" style="color: #333333; display: inline-block;">{{ $customerPhone }}</span>
                                                </div>
                                                @endif
                                                
                                                <div class="info-row" style="margin: 10px 0; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                                                    <span class="info-label" style="color: #2c3e50; font-weight: bold; display: inline-block; width: 130px; vertical-align: top;">País:</span>
                                                    <span class="info-value" style="color: #333333; display: inline-block;">{{ ucfirst($customerCountry) }}</span>
                                                </div>
                                                
                                                @if(!empty($customerPlan) && trim($customerPlan) !== '')
                                                <div class="info-row" style="margin: 10px 0; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                                                    <span class="info-label" style="color: #2c3e50; font-weight: bold; display: inline-block; width: 130px; vertical-align: top;">Plan de interés:</span>
                                                    <span class="info-value" style="color: #333333; display: inline-block;"><strong style="color: #d22e23;">{{ ucfirst($customerPlan) }}</strong></span>
                                                </div>
                                                @endif
                                            </div>

                                            <!-- Message Content -->
                                            <div class="message-box" style="background-color: #ffffff; border: 2px solid #f0ac21; border-radius: 8px; padding: 20px; margin: 20px 0;">
                                                <div class="message-title" style="color: #d22e23; font-size: 16px; font-weight: bold; margin: 0 0 15px 0;">
                                                    Tu Mensaje
                                                </div>
                                                <div class="message-content" style="background-color: #f8f9fa; border-left: 4px solid #f0ac21; padding: 15px; border-radius: 5px; color: #2c3e50; font-style: italic;">
                                                    {{ $customerMessage }}
                                                </div>
                                            </div>

                                            <!-- Stats Box -->
                                            <div class="stats-box" style="background-color: #d22e23; color: #ffffff; padding: 20px; border-radius: 8px; text-align: center; margin: 20px 0;">
                                                <div class="stats-title" style="font-size: 16px; font-weight: bold; margin: 0 0 5px 0;">
                                                    ¿Qué Pasa Ahora?
                                                </div>
                                                <div class="stats-text" style="font-size: 14px; margin: 0;">
                                                    Nuestro equipo revisará tu consulta y te responderemos en un plazo de 24-48 horas durante días hábiles
                                                </div>
                                            </div>

                                            <!-- Button -->
                                            <div class="button-table" style="text-align: center; margin: 25px 0;">
                                                <a href="{{ url('/') }}" class="cta-button" style="background-color: #d22e23; color: #ffffff; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; font-size: 16px; display: inline-block;">
                                                    Explorar Nuestros Servicios
                                                </a>
                                            </div>

                                            <!-- Tip Box -->
                                            <div class="tip-box" style="background-color: #fff3cd; border: 2px solid #f0ac21; border-radius: 8px; padding: 15px; margin: 20px 0; color: #2c3e50;">
                                                <strong>💡 Mientras tanto:</strong> 
                                                @if(!empty($customerPlan) && trim($customerPlan) !== '')
                                                    Puedes explorar más detalles sobre el plan {{ ucfirst($customerPlan) }} que te interesa visitando nuestro sitio web. También tenemos recursos adicionales que podrían ser útiles para tu decisión.
                                                @else
                                                    Te invitamos a explorar nuestro sitio web para conocer más sobre nuestros servicios y productos. Tenemos información detallada que podría interesarte.
                                                @endif
                                            </div>

                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <!-- Footer -->
                        <tr>
                            <td>
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" class="footer-table">
                                    <tr>
                                        <td style="padding: 25px; text-align: center; background-color: #2c3e50;">
                                            <div class="footer-company" style="color: #f0ac21; font-size: 16px; font-weight: bold; margin: 0 0 10px 0;">
                                                {{ $empresa->nombre ?? 'Empresa' }}
                                            </div>
                                            <div class="footer-text" style="color: #ecf0f1; font-size: 14px; margin: 5px 0;">
                                                Sistema automatizado de confirmaciones
                                            </div>
                                            
                                            @if($empresa->direccion)
                                            <div class="footer-text" style="color: #ecf0f1; font-size: 14px; margin: 5px 0;">
                                                📍 {{ $empresa->direccion }}
                                            </div>
                                            @endif
                                            
                                            @if($empresa->email)
                                            <div class="footer-text" style="color: #ecf0f1; font-size: 14px; margin: 5px 0;">
                                                📧 {{ $empresa->email }}
                                            </div>
                                            @endif
                                            
                                            @if($empresa->movil)
                                            <div class="footer-text" style="color: #ecf0f1; font-size: 14px; margin: 5px 0;">
                                                📱 {{ $empresa->movil }}
                                            </div>
                                            @endif
                                            
                                            <div class="footer-small" style="color: #95a5a6; font-size: 12px; margin: 15px 0 0 0;">
                                                Este es un mensaje automático de confirmación.<br>
                                                Para consultas urgentes, utiliza nuestros datos de contacto directo.
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>