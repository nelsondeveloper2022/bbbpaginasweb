<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller as BaseController;

class WhatsAppController extends BaseController
{
    private $phoneNumberId;
    private $accessToken;
    private $businessAccountId;
    private $appId;
    private $apiBaseUrl;
    private $requestTimeout;

    public function __construct()
    {
        // Aplicar middleware de administrador a todos los métodos
        $this->middleware(['auth', 'admin']);
        
        $this->phoneNumberId = config('whatsapp.phone_number_id');
        $this->accessToken = config('whatsapp.access_token');
        $this->businessAccountId = config('whatsapp.business_account_id');
        $this->appId = config('whatsapp.app_id');
        $this->apiBaseUrl = config('whatsapp.api_base_url');
        $this->requestTimeout = config('whatsapp.request_timeout');
    }

    /**
     * Obtener todas las plantillas de mensajes disponibles
     */
    public function getTemplates()
    {
        try {
            $url = "{$this->apiBaseUrl}/{$this->businessAccountId}/message_templates";
            
            $response = Http::timeout($this->requestTimeout)
                ->withHeaders([
                    'Authorization' => "Bearer {$this->accessToken}",
                ])->get($url, [
                    'fields' => 'name,status,category,components,language'
                ]);

            if ($response->successful()) {
                $templates = $response->json()['data'] ?? [];
                
                // Filtrar solo las plantillas aprobadas
                $approvedTemplates = array_filter($templates, function($template) {
                    return $template['status'] === 'APPROVED';
                });

                return response()->json([
                    'success' => true,
                    'templates' => array_values($approvedTemplates)
                ]);
            } else {
                Log::error('Error al obtener plantillas de WhatsApp', [
                    'response' => $response->json(),
                    'status' => $response->status()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Error al obtener las plantillas de WhatsApp'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Excepción al obtener plantillas de WhatsApp', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    /**
     * Obtener detalles de una plantilla específica
     */
    public function getTemplateDetails($templateName)
    {
        try {
            $url = "{$this->apiBaseUrl}/{$this->businessAccountId}/message_templates";
            
            $response = Http::timeout($this->requestTimeout)
                ->withHeaders([
                    'Authorization' => "Bearer {$this->accessToken}",
                ])->get($url, [
                    'name' => $templateName,
                    'fields' => 'name,status,category,components,language'
                ]);

            if ($response->successful()) {
                $templates = $response->json()['data'] ?? [];
                
                if (!empty($templates)) {
                    return response()->json([
                        'success' => true,
                        'template' => $templates[0]
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Plantilla no encontrada'
                    ], 404);
                }
            } else {
                Log::error('Error al obtener detalles de plantilla', [
                    'template_name' => $templateName,
                    'response' => $response->json()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Error al obtener los detalles de la plantilla'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Excepción al obtener detalles de plantilla', [
                'template_name' => $templateName,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    /**
     * Enviar mensaje usando una plantilla
     */
    public function sendTemplate(Request $request)
    {
        $request->validate([
            'to' => 'required|string',
            'template_name' => 'required|string',
            'language' => 'nullable|string',
            'parameters' => 'nullable|array'
        ]);

        // Establecer idioma por defecto si no se proporciona
        $language = $request->input('language', 'es');

        // Log para debug
        Log::info('Datos recibidos en sendTemplate', [
            'to' => $request->to,
            'template_name' => $request->template_name,
            'language' => $language,
            'parameters' => $request->parameters,
            'all_request' => $request->all()
        ]);

        try {
            $url = "{$this->apiBaseUrl}/{$this->phoneNumberId}/messages";
            
            $messageData = [
                'messaging_product' => 'whatsapp',
                'to' => $request->to,
                'type' => 'template',
                'template' => [
                    'name' => $request->template_name,
                    'language' => [
                        'code' => $language
                    ]
                ]
            ];

            // Agregar parámetros si existen
            if ($request->has('parameters') && !empty($request->parameters)) {
                $components = [];
                
                // Parámetros del cuerpo del mensaje
                if (isset($request->parameters['body']) && !empty($request->parameters['body'])) {
                    $bodyParams = [];
                    
                    // Para las plantillas de BBB, usar nombres de parámetros específicos
                    if ($request->template_name === 'completar_datos_landing') {
                        $paramNames = ['nombre_cliente', 'enlace_formulario'];
                        foreach ($request->parameters['body'] as $index => $param) {
                            $bodyParams[] = [
                                'type' => 'text',
                                'text' => $param,
                                'parameter_name' => $paramNames[$index] ?? 'param_' . ($index + 1)
                            ];
                        }
                    } elseif ($request->template_name === 'recordatorio_renovacion_landing') {
                        $paramNames = ['nombre_cliente', 'nombre_pagina', 'dias_restantes', 'enlace_panel'];
                        foreach ($request->parameters['body'] as $index => $param) {
                            $bodyParams[] = [
                                'type' => 'text',
                                'text' => $param,
                                'parameter_name' => $paramNames[$index] ?? 'param_' . ($index + 1)
                            ];
                        }
                    } elseif ($request->template_name === 'retroalimentacion_experiencia_bbb') {
                        $paramNames = ['nombre_cliente', 'nombre_pagina', 'enlace_formulario'];
                        foreach ($request->parameters['body'] as $index => $param) {
                            $bodyParams[] = [
                                'type' => 'text',
                                'text' => $param,
                                'parameter_name' => $paramNames[$index] ?? 'param_' . ($index + 1)
                            ];
                        }
                    } else {
                        // Para otras plantillas, usar nombres genéricos
                        foreach ($request->parameters['body'] as $index => $param) {
                            $bodyParams[] = [
                                'type' => 'text',
                                'text' => $param,
                                'parameter_name' => 'param_' . ($index + 1)
                            ];
                        }
                    }
                    
                    $components[] = [
                        'type' => 'body',
                        'parameters' => $bodyParams
                    ];
                    
                    Log::info('Parámetros del body agregados con nombres', [
                        'body_params' => $bodyParams,
                        'template' => $request->template_name
                    ]);
                }

                // Parámetros del encabezado
                if (isset($request->parameters['header']) && !empty($request->parameters['header'])) {
                    $headerParams = [];
                    foreach ($request->parameters['header'] as $index => $param) {
                        $headerParams[] = [
                            'type' => 'text',
                            'text' => $param,
                            'parameter_name' => 'header_param_' . ($index + 1)
                        ];
                    }
                    
                    $components[] = [
                        'type' => 'header',
                        'parameters' => $headerParams
                    ];
                    
                    Log::info('Parámetros del header agregados con nombres', [
                        'header_params' => $headerParams
                    ]);
                }

                if (!empty($components)) {
                    $messageData['template']['components'] = $components;
                }
            }
            
            // Agregar imagen del encabezado para las plantillas de BBB
            if (in_array($request->template_name, ['completar_datos_landing', 'recordatorio_renovacion_landing', 'retroalimentacion_experiencia_bbb'])) {
                if (!isset($messageData['template']['components'])) {
                    $messageData['template']['components'] = [];
                }
                
                // Agregar componente header con imagen al inicio
                array_unshift($messageData['template']['components'], [
                    'type' => 'header',
                    'parameters' => [
                        [
                            'type' => 'image',
                            'image' => [
                                'link' => 'https://bbbpaginasweb.com/images/logo-bbb.png'
                            ]
                        ]
                    ]
                ]);
                
                Log::info('Header con imagen BBB agregado', [
                    'template' => $request->template_name,
                    'image_url' => 'https://bbbpaginasweb.com/images/logo-bbb.png'
                ]);
            }
            
            // Log del mensaje completo que se va a enviar
            Log::info('Mensaje completo a enviar a WhatsApp', [
                'url' => $url,
                'message_data' => $messageData,
                'json_payload' => json_encode($messageData, JSON_PRETTY_PRINT)
            ]);

            $response = Http::timeout($this->requestTimeout)
                ->withHeaders([
                    'Authorization' => "Bearer {$this->accessToken}",
                    'Content-Type' => 'application/json',
                ])->post($url, $messageData);

            if ($response->successful()) {
                $result = $response->json();
                
                if (config('whatsapp.log_messages')) {
                    Log::info('Mensaje de WhatsApp enviado exitosamente', [
                        'to' => $request->to,
                        'template' => $request->template_name,
                        'message_id' => $result['messages'][0]['id'] ?? null
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Mensaje enviado exitosamente',
                    'data' => $result
                ]);
            } else {
                $responseData = $response->json();
                $errorMessage = 'Error al enviar el mensaje';
                
                // Extraer mensaje específico de error de WhatsApp
                if (isset($responseData['error']['message'])) {
                    $whatsappError = $responseData['error']['message'];
                    
                    // Traducir errores comunes de WhatsApp
                    if (strpos($whatsappError, 'Hello World templates can only be sent from the Public Test Numbers') !== false) {
                        $errorMessage = 'La plantilla "Hello World" solo puede enviarse desde números de prueba. Selecciona una plantilla aprobada para producción.';
                    } elseif (strpos($whatsappError, 'Template does not exist') !== false) {
                        $errorMessage = 'La plantilla seleccionada no existe o no está aprobada.';
                    } elseif (strpos($whatsappError, 'Invalid phone number') !== false) {
                        $errorMessage = 'El número de teléfono no es válido.';
                    } elseif (strpos($whatsappError, 'Template not approved') !== false) {
                        $errorMessage = 'La plantilla no está aprobada para uso en producción.';
                    } elseif (strpos($whatsappError, 'Number of parameters does not match') !== false) {
                        // Extraer detalles del error de parámetros
                        $details = '';
                        if (isset($responseData['error']['error_data']['details'])) {
                            $details = $responseData['error']['error_data']['details'];
                        }
                        $errorMessage = 'El número de parámetros no coincide con los esperados por la plantilla. ' . $details;
                    } else {
                        $errorMessage = 'Error de WhatsApp: ' . $whatsappError;
                    }
                }

                Log::error('Error al enviar mensaje de WhatsApp', [
                    'to' => $request->to,
                    'template' => $request->template_name,
                    'response' => $responseData,
                    'status' => $response->status()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                    'debug' => config('app.debug') ? $responseData : null
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('Excepción al enviar mensaje de WhatsApp', [
                'to' => $request->to,
                'template' => $request->template_name,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $errorMessage = 'Error interno del servidor';
            
            // Proporcionar mensajes más específicos según el tipo de error
            if (strpos($e->getMessage(), 'Connection') !== false) {
                $errorMessage = 'Error de conexión con WhatsApp. Verifica tu conexión a internet.';
            } elseif (strpos($e->getMessage(), 'timeout') !== false) {
                $errorMessage = 'Tiempo de espera agotado. Intenta nuevamente.';
            } elseif (strpos($e->getMessage(), 'Unauthorized') !== false) {
                $errorMessage = 'Token de acceso inválido. Contacta al administrador.';
            }

            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ], 500);
        }
    }

    /**
     * Obtener datos completos del usuario para auto-llenar parámetros
     */
    public function getUserData($userId)
    {
        try {
            $user = \App\Models\User::with(['empresa', 'plan'])->findOrFail($userId);
            
            // Calcular días restantes
            $diasRestantes = 0;
            if ($user->subscription_ends_at) {
                $diasRestantes = (int) now()->diffInDays($user->subscription_ends_at, false);
                if ($diasRestantes < 0) {
                    $diasRestantes = 0;
                }
            }
            
            // Obtener nombre de la página (intentar de varias fuentes)
            $nombrePagina = 'tu página web';
            if (isset($user->empresa->nombre)) {
                $nombrePagina = $user->empresa->nombre;
            } elseif ($user->empresa_nombre) {
                $nombrePagina = $user->empresa_nombre;
            }
            
            // Intentar obtener la landing page si existe la relación
            try {
                if (method_exists($user, 'landing') && $user->landing) {
                    $nombrePagina = $user->landing->nombre ?? $nombrePagina;
                }
            } catch (\Exception $e) {
                // Si no existe la relación, usamos el nombre de empresa
            }
            
            $userData = [
                'id' => $user->id,
                // Datos del cliente
                'nombre' => $user->name ?? '',
                'nombre_cliente' => $user->name ?? '',
                'nombre_corto' => !empty($user->name) ? (explode(' ', $user->name)[0] ?? $user->name) : '',
                'email' => $user->email ?? '',
                'telefono' => $user->movil ?? '',
                // Datos de la empresa
                'empresa_nombre' => $user->empresa_nombre ?? ($user->empresa->nombre ?? ''),
                'empresa_email' => $user->empresa_email ?? ($user->empresa->email ?? ''),
                // Datos de la landing page
                'nombre_pagina' => $nombrePagina,
                // Datos de suscripción
                'plan_nombre' => $user->plan->nombre ?? 'Sin plan',
                'fecha_vencimiento' => $user->subscription_ends_at ? $user->subscription_ends_at->format('d/m/Y') : '',
                'dias_restantes' => $diasRestantes,
                'estado_suscripcion' => $this->getSubscriptionStatus($user),
                // URLs del sistema
                'enlace_formulario' => 'https://bbbpaginasweb.com/admin/landing/configurar',
                'enlace_panel' => 'https://bbbpaginasweb.com/login',
                'url_login' => 'https://bbbpaginasweb.com/login',
            ];
            
            return response()->json([
                'success' => true,
                'data' => $userData
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener datos del usuario para WhatsApp', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener datos del usuario: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtener estado de la suscripción del usuario
     */
    private function getSubscriptionStatus($user)
    {
        if (!$user->subscription_ends_at) {
            return 'Sin suscripción';
        }
        
        $daysRemaining = now()->diffInDays($user->subscription_ends_at, false);
        
        if ($daysRemaining < 0) {
            return 'Vencida';
        } elseif ($daysRemaining <= 7) {
            return 'Por vencer';
        } else {
            return 'Activa';
        }
    }

    /**
     * Mostrar el modal de WhatsApp para un usuario específico
     */
    public function showModal($userId)
    {
        // Aquí podrías obtener información adicional del usuario si es necesario
        // Por ejemplo, su número de teléfono si está guardado en la base de datos
        
        return response()->json([
            'success' => true,
            'user_id' => $userId
        ]);
    }
}