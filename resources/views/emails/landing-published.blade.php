<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Landing Page Publicada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #d22e23, #f0ac21);
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .info-section {
            background: white;
            padding: 20px;
            margin: 15px 0;
            border-radius: 8px;
            border-left: 4px solid #d22e23;
        }
        .url-highlight {
            background: #e8f5e8;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
            font-weight: bold;
            text-align: center;
        }
        .url-highlight a {
            color: #d22e23;
            text-decoration: none;
            font-size: 18px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            background: #f0ac21;
            color: white;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #f5f5f5;
            font-weight: bold;
        }
        .media-list {
            list-style: none;
            padding: 0;
        }
        .media-list li {
            background: #f8f9fa;
            padding: 8px 12px;
            margin: 5px 0;
            border-radius: 4px;
            border-left: 3px solid #d22e23;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🚀 Nueva Landing Page Publicada</h1>
        <p>Se ha publicado una nueva landing page y está en construcción</p>
    </div>
    
    <div class="content">
        <div class="info-section">
            <h2>Información de la Empresa</h2>
            <table>
                <tr>
                    <th>Nombre:</th>
                    <td>{{ $empresa->nombre }}</td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td>{{ $empresa->email }}</td>
                </tr>
                <tr>
                    <th>Teléfono:</th>
                    <td>{{ $empresa->movil ?? 'No proporcionado' }}</td>
                </tr>
                <tr>
                    <th>Dirección:</th>
                    <td>{{ $empresa->direccion ?? 'No proporcionada' }}</td>
                </tr>
                <tr>
                    <th>Slug:</th>
                    <td><code>{{ $empresa->slug }}</code></td>
                </tr>
                <tr>
                    <th>Estado:</th>
                    <td><span class="status-badge">{{ strtoupper($empresa->estado) }}</span></td>
                </tr>
            </table>
        </div>

        <div class="url-highlight">
            <p>URL de la Landing Page:</p>
            <a href="{{ $landingUrl }}" target="_blank">{{ $landingUrl }}</a>
        </div>

        <div class="info-section">
            <h2>Configuración de la Landing</h2>
            <table>
                <tr>
                    <th>Objetivo:</th>
                    <td>{{ $landing->objetivo ? ucwords(str_replace('_', ' ', $landing->objetivo)) : 'No especificado' }}</td>
                </tr>
                <tr>
                    <th>Título Principal:</th>
                    <td>{{ $landing->titulo_principal ?? 'No especificado' }}</td>
                </tr>
                <tr>
                    <th>Subtítulo:</th>
                    <td>{{ $landing->subtitulo ?? 'No especificado' }}</td>
                </tr>
                <tr>
                    <th>Descripción:</th>
                    <td>{{ $landing->descripcion ?? 'No especificada' }}</td>
                </tr>
                <tr>
                    <th>Estilo:</th>
                    <td>{{ $landing->estilo ? ucwords($landing->estilo) : 'No especificado' }}</td>
                </tr>
                <tr>
                    <th>Tipografía:</th>
                    <td>{{ $landing->tipografia ?? 'No especificada' }}</td>
                </tr>
                <tr>
                    <th>Color Principal:</th>
                    <td>
                        {{ $landing->color_principal ?? 'No especificado' }}
                        @if($landing->color_principal)
                            <span style="display: inline-block; width: 20px; height: 20px; background: {{ $landing->color_principal }}; border-radius: 3px; margin-left: 10px; vertical-align: middle;"></span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Color Secundario:</th>
                    <td>
                        {{ $landing->color_secundario ?? 'No especificado' }}
                        @if($landing->color_secundario)
                            <span style="display: inline-block; width: 20px; height: 20px; background: {{ $landing->color_secundario }}; border-radius: 3px; margin-left: 10px; vertical-align: middle;"></span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        @if($landing->descripcion_objetivo)
            <div class="info-section">
                <h3>Descripción del Objetivo</h3>
                <p>{{ $landing->descripcion_objetivo }}</p>
            </div>
        @endif

        @if($landing->audiencia_descripcion)
            <div class="info-section">
                <h3>Audiencia Objetivo</h3>
                <p>{{ $landing->audiencia_descripcion }}</p>
            </div>
        @endif

        @if($landing->audiencia_problemas)
            <div class="info-section">
                <h3>Problemas que Resuelve</h3>
                <p>{{ $landing->audiencia_problemas }}</p>
            </div>
        @endif

        @if($landing->audiencia_beneficios)
            <div class="info-section">
                <h3>Beneficios que Ofrece</h3>
                <p>{{ $landing->audiencia_beneficios }}</p>
            </div>
        @endif

        @if($landing->logo_url)
            <div class="info-section">
                <h3>Logo</h3>
                <p><strong>Archivo:</strong> {{ $landing->logo_url }}</p>
                <p><strong>URL:</strong> <a href="{{ asset('storage/' . $landing->logo_url) }}" target="_blank">Ver logo</a></p>
            </div>
        @endif

        @if($landing->media && $landing->media->count() > 0)
            <div class="info-section">
                <h3>Imágenes Adicionales ({{ $landing->media->count() }})</h3>
                <ul class="media-list">
                    @foreach($landing->media as $media)
                        <li>
                            <strong>{{ ucfirst($media->tipo) }}:</strong> {{ $media->url }}
                            @if($media->descripcion)
                                <br><small>{{ $media->descripcion }}</small>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($empresa->hasSocialMedia())
            <div class="info-section">
                <h3>Redes Sociales</h3>
                <table>
                    @if($empresa->facebook)
                        <tr>
                            <th>Facebook:</th>
                            <td><a href="{{ $empresa->facebook }}" target="_blank">{{ $empresa->facebook }}</a></td>
                        </tr>
                    @endif
                    @if($empresa->instagram)
                        <tr>
                            <th>Instagram:</th>
                            <td><a href="{{ $empresa->instagram }}" target="_blank">{{ $empresa->instagram }}</a></td>
                        </tr>
                    @endif
                    @if($empresa->linkedin)
                        <tr>
                            <th>LinkedIn:</th>
                            <td><a href="{{ $empresa->linkedin }}" target="_blank">{{ $empresa->linkedin }}</a></td>
                        </tr>
                    @endif
                    @if($empresa->twitter)
                        <tr>
                            <th>Twitter:</th>
                            <td><a href="{{ $empresa->twitter }}" target="_blank">{{ $empresa->twitter }}</a></td>
                        </tr>
                    @endif
                    @if($empresa->tiktok)
                        <tr>
                            <th>TikTok:</th>
                            <td><a href="{{ $empresa->tiktok }}" target="_blank">{{ $empresa->tiktok }}</a></td>
                        </tr>
                    @endif
                    @if($empresa->youtube)
                        <tr>
                            <th>YouTube:</th>
                            <td><a href="{{ $empresa->youtube }}" target="_blank">{{ $empresa->youtube }}</a></td>
                        </tr>
                    @endif
                    @if($empresa->whatsapp)
                        <tr>
                            <th>WhatsApp:</th>
                            <td><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $empresa->whatsapp) }}" target="_blank">{{ $empresa->whatsapp }}</a></td>
                        </tr>
                    @endif
                </table>
            </div>
        @endif

        <div class="info-section">
            <h3>📅 Próximos Pasos</h3>
            <p>Esta landing page estará disponible públicamente en un plazo de <strong>24 horas</strong>.</p>
            <p>Una vez completada la construcción, el estado cambiará automáticamente a "PUBLICADA".</p>
        </div>
    </div>
</body>
</html>