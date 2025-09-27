<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Wompi Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Wompi payment gateway integration
    |
    */

    'public_key' => env('WOMPI_PUBLIC_KEY', 'pub_prod_nho8fiou5t0oYUQK9gznpWbqQ1W2AQ5B'),
    'private_key' => env('WOMPI_PRIVATE_KEY', 'prv_prod_yZDrwZ1WqIKuSohbCGYbc1QiCYSmaeNJ'),
    'events_key' => env('WOMPI_EVENTS_KEY', 'prod_events_3u5olmPAIo8jyGPb2e80kLenaXDNowmT'),
    'integrity_key' => env('WOMPI_INTEGRITY_KEY', 'prod_integrity_5f6XO0QwG75UvFqGSOsfX2q6bnVODVnT'),
    
    'environment' => env('WOMPI_ENVIRONMENT', 'production'), // 'production' or 'sandbox'
    
    'api_url' => env('WOMPI_API_URL', 'https://production.wompi.co/v1'),
    'checkout_url' => env('WOMPI_CHECKOUT_URL', 'https://checkout.wompi.co'),
];