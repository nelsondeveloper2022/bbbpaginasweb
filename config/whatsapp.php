<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WhatsApp Business API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuración para la integración con WhatsApp Business API
    |
    */

    // ID del número de teléfono de WhatsApp Business
    'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID', '829957880204214'),

    // Token permanente de acceso
    'access_token' => env('WHATSAPP_ACCESS_TOKEN', 'EAAJN0jczJVYBPrQoIwy4AFteJ59SkIYxyDNrDmZCEAK8XO0JTPlPOS3Sb4vg8yEAs9ZCYvX5SZCanaiKZAolK4D3rDqBWYWGySq0sSgalDZA8nZCUfxS6NubJYxZBEiZCWumqgZC8SYpMewSPqahrEPV8PbjvdkGxdeSn2my1BMKvAF2XaxiL5X8xaaVuBnklZCAZDZD'),

    // ID de la cuenta de WhatsApp Business
    'business_account_id' => env('WHATSAPP_BUSINESS_ACCOUNT_ID', '1489092885549950'),

    // ID de la aplicación
    'app_id' => env('WHATSAPP_APP_ID', '648515217990998'),

    // URL base de la API de WhatsApp
    'api_base_url' => env('WHATSAPP_API_BASE_URL', 'https://graph.facebook.com/v18.0'),

    // Configuraciones adicionales
    'webhook_verify_token' => env('WHATSAPP_WEBHOOK_VERIFY_TOKEN', null),
    'webhook_secret' => env('WHATSAPP_WEBHOOK_SECRET', null),

    // Configuración de timeout para requests HTTP
    'request_timeout' => env('WHATSAPP_REQUEST_TIMEOUT', 30),

    // Log de mensajes enviados (true/false)
    'log_messages' => env('WHATSAPP_LOG_MESSAGES', true),
];