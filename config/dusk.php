<?php

return [
    'port' => env('DUSK_PORT', 9515),

    'port-serve' => env('DUSK_PORT_SERVE', 8000),

    'show-window' => env('DUSK_SHOW_WINDOW', false),

    'timeout' => [
        'connection' => env('DUSK_TIMEOUT_CONNECTION', 5000),
        'timeout' => env('DUSK_TIMEOUT_REQUEST', 20000),
    ]
];