<?php

use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes / Scheduled Commands
|--------------------------------------------------------------------------
|
| En Laravel 12 el scheduler se define aquí en lugar de Kernel.php.
| El comando pedidos:limpiar corre todos los días a medianoche.
| Borra pedidos cuya fecha_retiro sea anterior a hoy.
|
*/

Schedule::command('pedidos:limpiar')
    ->dailyAt('00:01')          // 12:01 AM cada día
    ->withoutOverlapping()      // evita que se ejecute dos veces si tarda
    ->runInBackground();        // no bloquea otros jobs