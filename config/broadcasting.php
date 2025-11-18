<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcaster
    |--------------------------------------------------------------------------
    |
    | This option controls the default broadcaster that will be used by the
    | framework when an event needs to be broadcast. You may set this to
    | any of the connections defined in the "connections" array below.
    |
    */

    'default' => env('BROADCAST_DRIVER', env('BROADCAST_CONNECTION', 'log')),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the broadcast connections that will be used
    | to broadcast events to other systems or over websockets. A default
    | configuration has been provided for each driver for convenience.
    |
    */

    'connections' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                // useTLS/encryption can be controlled by PUSHER_APP_FORCE_TLS/PUSHER_APP_ENCRYPTED
                'useTLS' => filter_var(env('PUSHER_APP_FORCE_TLS', env('PUSHER_APP_ENCRYPTED', false)), FILTER_VALIDATE_BOOLEAN),
                'encrypted' => filter_var(env('PUSHER_APP_ENCRYPTED', false), FILTER_VALIDATE_BOOLEAN),
                // allow overriding host/port/scheme for local echo servers (Soketi / laravel-echo-server)
                'host' => env('PUSHER_HOST', null),
                'port' => env('PUSHER_PORT', null),
                'scheme' => env('PUSHER_SCHEME', null),
                // If you need to disable TLS verification for local dev
                'curl_options' => [
                    CURLOPT_SSL_VERIFYPEER => false,
                ],
            ],
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

];
