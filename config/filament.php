<?php

return [
    'path' => 'admin',
    'middleware' => [
        'web',
        'auth',
    ],
    'auth' => [
        'guard' => 'web',
    ],
    'resources' => [
        // Resource Filament akan otomatis terdaftar di sini
    ],
    'pages' => [
        // Custom pages
    ],
    'widgets' => [
        // Custom widgets
    ],
    'navigation' => [
        // Custom navigation
    ],
]; 