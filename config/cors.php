<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
        'broadcasting/auth',           // ← MUST include this!
        'login',
        'logout',
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'https://ecocity.info',
        'https://www.ecocity.info',
        'http://localhost:6000',      // Most common for Next.js
        'http://127.0.0.1:6000',
        'https://next.ecocity.info',
        'https://www.next.ecocity.info'
    ],

    'allowed_origins_patterns' => [
        '#^https?://(www\.)?ecocity\.info$#',  // ← catches all variants
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,    // ← Extremely important for auth cookies / Sanctum!
];
