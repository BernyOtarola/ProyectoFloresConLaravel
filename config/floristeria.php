<?php

// ══════════════════════════════════════════════════════════
// FLORISTERÍA BRIBRI — Configuración del negocio
// ══════════════════════════════════════════════════════════
// Uso en código:   config('floristeria.nombre')
// Uso en Blade:    {{ config('floristeria.whatsapp') }}
// ══════════════════════════════════════════════════════════

return [

    // ── Identidad del negocio ─────────────────────────────
    'nombre'      => env('FLORISTERIA_NOMBRE', 'Floristería Bribri'),
    'slogan'      => env('FLORISTERIA_SLOGAN', 'Flores frescas con amor desde Costa Rica 🌺'),
    'admin_email' => env('FLORISTERIA_ADMIN_EMAIL', 'fannyaleman0312@gmail.com'),

    // ── WhatsApp ──────────────────────────────────────────
    'whatsapp' => env('FLORISTERIA_WHATSAPP', '50684630055'),

    // ── Envío ─────────────────────────────────────────────
    'costo_envio'       => env('FLORISTERIA_COSTO_ENVIO', 3000),
    'envio_gratis_desde' => env('FLORISTERIA_ENVIO_GRATIS_DESDE', 0), // 0 = nunca gratis

    // ── Moneda ────────────────────────────────────────────
    'moneda' => [
        'simbolo'       => '₡',
        'decimales'     => 0,
        'separador_dec' => ',',
        'separador_mil' => '.',
        'codigo'        => 'CRC', // ISO 4217 Colón costarricense
    ],

    // ── Pedidos ───────────────────────────────────────────
    'prefijo_pedido' => 'BRI',
    'estados_pedido' => [
        'pendiente'  => '🟡 Pendiente',
        'confirmado' => '🔵 Confirmado',
        'en_proceso' => '🟠 En proceso',
        'listo'      => '🟢 Listo',
        'entregado'  => '✅ Entregado',
        'cancelado'  => '🔴 Cancelado',
    ],

    // ── Productos ─────────────────────────────────────────
    'productos' => [
        'destacados_home'     => 6,   // Cuántos mostrar en el home
        'imagen_max_kb'       => 5120, // 5 MB
        'formatos_imagen'     => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
        'imagen_placeholder'  => '/images/no-image.png',
    ],

    // ── Redes sociales (opcionales) ───────────────────────
    'redes' => [
    'facebook'  => env('FLORISTERIA_FACEBOOK', ''),
    'instagram' => env('FLORISTERIA_INSTAGRAM', ''),
    'tiktok'    => env('FLORISTERIA_TIKTOK', ''),
],

    // ── Horario ───────────────────────────────���───────────
    'horario' => env('FLORISTERIA_HORARIO', 'Lunes a Sábado: 8:00am - 6:00pm'),

    // ── Dirección física ──────────────────────────────────
    'direccion' => env('FLORISTERIA_DIRECCION', 'San José, Costa Rica'),

    

];