<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application, which will be used when the
    | framework needs to place the application's name in a notification or
    | other UI elements where an application name needs to be displayed.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | the application so that it's available within Artisan commands.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. The timezone
    | is set to "America/Bogota" for Colombian timezone.
    |
    */

    'timezone' => 'America/Bogota',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by Laravel's translation / localization methods. This option can be
    | set to any locale for which you plan to have translation strings.
    |
    */

    'locale' => env('APP_LOCALE', 'es'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'es_ES'),

    /*
    |--------------------------------------------------------------------------
    | Available Locales
    |--------------------------------------------------------------------------
    |
    | List all of the languages that your application supports.
    |
    */

    'available_locales' => [
        'es' => 'Español',
        'en' => 'English',
    ],

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is utilized by Laravel's encryption services and should be set
    | to a random, 32 character string to ensure that all encrypted values
    | are secure. You should do this prior to deploying the application.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

    /*
    |--------------------------------------------------------------------------
    | BBB Contact Information
    |--------------------------------------------------------------------------
    |
    | Contact information for support and customer service.
    |
    */

    'support' => [
        'mobile' => env('MOVIL_SOPORTE_CONTACTO', '573189696117'),
        'email' => env('EMAIL_SOPORTE_CONTACTO', 'info@bbbpaginasweb.com'),
        'whatsapp' => env('MOVIL_SOPORTE_CONTACTO', '573189696117'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Google reCAPTCHA Enterprise Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Google reCAPTCHA Enterprise v3 integration.
    |
    */

    'recaptcha' => [
        'site_key' => env('RECAPTCHA_ENTERPRISE_SITE_KEY'),
        'api_key' => env('RECAPTCHA_ENTERPRISE_API_KEY'),
        'project_id' => env('RECAPTCHA_ENTERPRISE_PROJECT_ID'),
        'verify_url' => 'https://recaptchaenterprise.googleapis.com/v1/projects/' . env('RECAPTCHA_ENTERPRISE_PROJECT_ID') . '/assessments',
    ],

    /*
    |--------------------------------------------------------------------------
    | BBB Academy - YouTube Configuration
    |--------------------------------------------------------------------------
    |
    | Configure how YouTube resources are displayed in the documentation
    | section. You can set a channel URL, a playlist ID to embed, a featured
    | video, or provide up to 4 specific video IDs (comma separated) for a
    | grid. All values are optional and safe defaults are provided.
    |
    */

    'youtube' => [
        // Public channel URL or handle
        'channel_url' => env('YOUTUBE_CHANNEL_URL', 'https://www.youtube.com/@bbbpaginasweb'),

        // Optional: Playlist ID to embed (e.g., PLxxxxxxxx)
        'playlist_id' => env('YOUTUBE_PLAYLIST_ID', null),

        // Optional: Featured video to show large if no playlist is set
        'featured_video_id' => env('YOUTUBE_FEATURED_VIDEO_ID', null),

        // Optional: Predefined videos with titles (used for grid rendering)
        'videos' => [
            [
                'id' => 'z7x4Uy-64WQ',
                'title' => 'Registro en bbbpaginasweb y configuración de página web 😏🤓',
            ],
            [
                'id' => 'nFUMu5PCuWo',
                'title' => 'Configurar clientes',
            ],
            [
                'id' => 'e1uICSyKM1E',
                'title' => 'Como crear productos',
            ],
            [
                'id' => '2kwRjrp0UHY',
                'title' => 'Integración pasarela de pago Wompi😁 y ventas',
            ],
        ],

        // Optional: Comma-separated list of video IDs to render as a grid
        // Example: YOUTUBE_VIDEO_IDS="dQw4w9WgXcQ,VIDEO2ID,VIDEO3ID,VIDEO4ID"
        'video_ids' => array_values(array_filter(array_map('trim', explode(',', (string) env('YOUTUBE_VIDEO_IDS', ''))))),
    ],

];
