<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    | 'web'   → suscriptores con cuenta (clientes de la tienda)
    | 'admin' → administradoras del panel
    */

    'defaults' => [
        'guard'     => 'web',
        'passwords' => 'suscriptores',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */

    'guards' => [

        // Clientes / suscriptoras
        'web' => [
            'driver'   => 'session',
            'provider' => 'suscriptores',
        ],

        // Administradoras del panel
        'admin' => [
            'driver'   => 'session',
            'provider' => 'admins',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        'suscriptores' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Suscriptor::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Admin::class,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    */

    'passwords' => [

        'suscriptores' => [
            'provider' => 'suscriptores',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],

        'admins' => [
            'provider' => 'admins',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],

    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];