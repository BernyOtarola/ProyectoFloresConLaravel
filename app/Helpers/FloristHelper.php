<?php

// ══════════════════════════════════════════════════════════
// Helpers globales — Floristería Bribri
// ══════════════════════════════════════════════════════════

if (!function_exists('formatPrice')) {
    /**
     * Formato de precio costarricense: ₡18.500
     */
    function formatPrice(float $precio): string
    {
        $m = config('floristeria.moneda');

        return $m['simbolo'] . number_format(
            $precio,
            $m['decimales'],
            $m['separador_dec'],
            $m['separador_mil']
        );
    }
}

if (!function_exists('generateOrderNumber')) {
    /**
     * Genera número de pedido: BRI-A1B2C3-2026
     */
    function generateOrderNumber(): string
    {
        $prefijo = config('floristeria.prefijo_pedido', 'BRI');

        return $prefijo . '-' . strtoupper(substr(uniqid(), -6)) . '-' . date('Y');
    }
}

if (!function_exists('whatsappLink')) {
    /**
     * Genera link de WhatsApp con mensaje opcional
     */
    function whatsappLink(string $mensaje = ''): string
    {
        $numero = config('floristeria.whatsapp');
        $url = "https://wa.me/{$numero}";

        if ($mensaje) {
            $url .= '?text=' . urlencode($mensaje);
        }

        return $url;
    }
}

if (!function_exists('estadoPedidoLabel')) {
    /**
     * Devuelve el label bonito del estado: "🟡 Pendiente"
     */
    function estadoPedidoLabel(string $estado): string
    {
        return config("floristeria.estados_pedido.{$estado}", $estado);
    }
}

if (!function_exists('costoEnvio')) {
    /**
     * Devuelve el costo de envío configurado
     */
    function costoEnvio(): float
    {
        return (float) config('floristeria.costo_envio', 3000);
    }
}

if (!function_exists('getCartCount')) {
    /**
     * Total de items en el carrito (sesión)
     */
    function getCartCount(): int
    {
        $carrito = session('carrito', []);

        return array_sum(array_column($carrito, 'cantidad'));
    }
}

if (!function_exists('getCartTotal')) {
    /**
     * Total en colones del carrito (sesión)
     */
    function getCartTotal(): float
    {
        $carrito = session('carrito', []);

        return array_sum(array_map(
            fn($item) => $item['precio'] * $item['cantidad'],
            $carrito
        ));
    }
}