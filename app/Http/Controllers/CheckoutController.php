<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CheckoutController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nombre'        => 'required|string|max:150',
            'telefono'      => 'required|string|max:20',
            'tipo'          => 'required|in:retiro,envio',
            'fecha_retiro'  => 'required|date|after_or_equal:today',  // ← obligatoria
            'carrito'       => 'required|array|min:1',
        ]);

        if ($request->input('tipo') === 'envio') {
            $request->validate([
                'direccion' => 'required|string|max:500',
            ]);
        }

        // Sanear inputs de texto
        $nombre       = strip_tags(trim($request->input('nombre')));
        $telefono     = preg_replace('/[^0-9\-\+\s\(\)]/', '', $request->input('telefono'));
        $email        = filter_var(trim($request->input('email', '')), FILTER_SANITIZE_EMAIL) ?: null;
        $direccion    = strip_tags(trim($request->input('direccion', '')));
        $nota         = strip_tags(trim($request->input('nota', '')));
        $fechaRetiro  = $request->input('fecha_retiro');   // ya validada como date

        // Recalcular totales desde BD (nunca confiar en el cliente)
        $itemsValidados = [];
        $subtotalReal   = 0.0;

        foreach ($request->input('carrito') as $item) {
            $id = (int) ($item['id'] ?? 0);
            if (!$id) continue;

            $producto = Producto::where('id', $id)->where('activo', true)->first();
            if (!$producto) continue;

            $cantidad = max(1, (int) ($item['cantidad'] ?? 1));
            if ($producto->stock > 0) {
                $cantidad = min($cantidad, $producto->stock);
            }

            $itemsValidados[] = [
                'id'       => $producto->id,
                'nombre'   => $producto->nombre,
                'precio'   => $producto->precio,
                'cantidad' => $cantidad,
            ];
            $subtotalReal += $producto->precio * $cantidad;
        }

        if (empty($itemsValidados)) {
            return response()->json([
                'success' => false,
                'message' => 'No hay productos válidos en el carrito.',
            ], 422);
        }

        $tipo       = $request->input('tipo');
        $costoEnvio = $tipo === 'envio' ? (float) config('floristeria.costo_envio', 3000) : 0.0;
        $total      = $subtotalReal + $costoEnvio;
        $numero     = 'BRI-' . strtoupper(substr(uniqid(), -6)) . '-' . date('Y');

        $pedido = Pedido::create([
            'numero_pedido'    => $numero,
            'nombre_cliente'   => $nombre,
            'telefono_cliente' => $telefono,
            'email_cliente'    => $email,
            'tipo_entrega'     => $tipo,
            'fecha_retiro'     => $fechaRetiro,      // ← guardar la fecha
            'direccion_envio'  => $direccion ?: null,
            'nota'             => $nota ?: null,
            'items_json'       => json_encode($itemsValidados, JSON_UNESCAPED_UNICODE),
            'subtotal'         => $subtotalReal,
            'costo_envio'      => $costoEnvio,
            'total'            => $total,
            'estado'           => 'pendiente',
        ]);

        // Descontar stock
        foreach ($itemsValidados as $item) {
            Producto::where('id', $item['id'])
                ->where('stock', '>', 0)
                ->decrement('stock', $item['cantidad']);
        }

        session()->forget('carrito');

        return response()->json([
            'success' => true,
            'numero'  => $numero,
        ]);
    }
}