<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CheckoutController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nombre'   => 'required|string|max:150',
            'telefono' => 'required|string|max:20',
            'tipo'     => 'required|in:retiro,envio',
            'carrito'  => 'required|array|min:1',
        ]);

        $tipo = $request->input('tipo');

        if ($tipo === 'envio') {
            $request->validate([
                'direccion' => 'required|string|max:500',
            ]);
        }

        $numero = 'BRI-' . strtoupper(substr(uniqid(), -6)) . '-' . date('Y');

        Pedido::create([
            'numero_pedido'    => $numero,
            'nombre_cliente'   => $request->input('nombre'),
            'telefono_cliente' => $request->input('telefono'),
            'email_cliente'    => $request->input('email'),
            'tipo_entrega'     => $tipo,
            'direccion_envio'  => $request->input('direccion'),
            'nota'             => $request->input('nota'),
            'items_json'       => json_encode($request->input('carrito'), JSON_UNESCAPED_UNICODE),
            'subtotal'         => (float) $request->input('subtotal', 0),
            'costo_envio'      => (float) $request->input('envio', 0),
            'total'            => (float) $request->input('total', 0),
            'estado'           => 'pendiente',
        ]);

        session()->forget('carrito');

        return response()->json([
            'success' => true,
            'numero'  => $numero,
        ]);
    }
}