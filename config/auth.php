<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    | El guard por defecto es 'web' que apunta a los suscriptores (clientes).
    | Para admin se usa Auth::guard('admin') explícitamente.
    */

    'defaults' => [
        'guard'     => 'web',
        'passwords' => 'suscriptores',
    ],

    /*
    |--------------------------------------------------------------------------
    | Guards
    |--------------------------------------------------------------------------
    */

    'guards' => [
        // Clientes (tabla suscriptores)
        'web' => [
            'driver'   => 'session',
            'provider' => 'suscriptores',
        ],

        // Administradores (tabla admins)
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
    | Password Reset (no se usa en este proyecto pero Laravel lo requiere)
    |--------------------------------------------------------------------------
    */

    'passwords' => [
        'suscriptores' => [
            'provider' => 'suscriptores',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];