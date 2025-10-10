<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'wompi' => [
        // Configuración de producción para Wompi
        'public_key' => env('WOMPI_PUBLIC_KEY', 'pub_prod_nho8fiou5t0oYUQK9gznpWbqQ1W2AQ5B'),
        'private_key' => env('WOMPI_PRIVATE_KEY', 'prv_prod_yZDrwZ1WqIKuSohbCGYbc1QiCYSmaeNJ'),
        'event_secret' => env('WOMPI_EVENTS_KEY', 'prod_events_3u5olmPAIo8jyGPb2e80kLenaXDNowmT'),
        'integrity_secret' => env('WOMPI_INTEGRITY_KEY', 'prod_integrity_5f6XO0QwG75UvFqGSOsfX2q6bnVODVnT'),
        'environment' => env('WOMPI_ENVIRONMENT', 'production'),
        'webhook_url' => env('WOMPI_WEBHOOK_URL', 'https://bbbpaginasweb.com/api/payments/wompi/webhook'),
    ],

];
