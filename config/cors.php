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
        'http://ecocity.info',
        'https://ecocity.info',
        'http://www.ecocity.info',
        'https://www.ecocity.info',
        'http://localhost:3000',      // Most common for Next.js
        'http://127.0.0.1:3000',
    ],

    'allowed_origins_patterns' => [
        '#^https?://(www\.)?ecocity\.info$#',  // ← catches all variants
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,    // ← Extremely important for auth cookies / Sanctum!
];
