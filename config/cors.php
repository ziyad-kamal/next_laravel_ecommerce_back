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
        'http://localhost:7777',      // Most common for Next.js
        'http://127.0.0.1:7777',
        'https://next.ecocity.info',
        'https://www.next.ecocity.info'
    ],

    'allowed_origins_patterns' => [
    '#^https?://([a-z0-9-]+\.)?ecocity\.info$#',  // matches any subdomain
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,    // ← Extremely important for auth cookies / Sanctum!
];
