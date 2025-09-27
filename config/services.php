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
        // Para desarrollo local - usar llaves de test
        'public_key' => env('WOMPI_PUBLIC_KEY', env('APP_ENV') === 'production' ? 'pub_prod_nho8fiou5t0oYUQK9gznpWbqQ1W2AQ5B' : 'pub_test_G4oystOYhDgfOEwsRWY6lp9zKR9LWdM5'),
        'private_key' => env('WOMPI_PRIVATE_KEY', env('APP_ENV') === 'production' ? 'prv_prod_yZDrwZ1WqIKuSohbCGYbc1QiCYSmaeNJ' : 'prv_test_tAUQ6ggGDgtdrT8O4vZLVg0VJLEMPnLv'),
        'event_secret' => env('WOMPI_EVENT_SECRET', env('APP_ENV') === 'production' ? 'prod_events_3u5olmPAIo8jyGPb2e80kLenaXDNowmT' : 'test_events_zJW5hLhFxLGtEsq7gx3r4Qb4DVkFtMQ0'),
        'integrity_secret' => env('WOMPI_INTEGRITY_SECRET', env('APP_ENV') === 'production' ? 'prod_integrity_5f6XO0QwG75UvFqGSOsfX2q6bnVODVnT' : 'test_integrity_HWqvdnWcxoqJZuS5rS3sVl8CQl2w1jx8'),
        'environment' => env('WOMPI_ENVIRONMENT', env('APP_ENV') === 'production' ? 'prod' : 'test'),
        'webhook_url' => env('WOMPI_WEBHOOK_URL', env('APP_ENV') === 'production' ? 'https://bbbpaginasweb.com/api/payments/wompi/webhook' : 'https://webhook.site/your-test-url'),
    ],

];
