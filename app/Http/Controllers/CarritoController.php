<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito  = session('carrito', []);
        $subtotal = $this->calcularTotal($carrito);

        return view('carrito.index', compact('carrito', 'subtotal'));
    }

    public function api(Request $request): JsonResponse
    {
        $accion  = $request->input('accion');
        $carrito = session('carrito', []);

        switch ($accion) {

            case 'agregar':
                $id   = (int) $request->input('id');
                $cant = max(1, (int) $request->input('cantidad', 1));

                // ── #6: verificar contra BD antes de agregar ──
                $producto = Producto::where('id', $id)
                    ->where('activo', true)
                    ->first();

                if (!$producto) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Producto no disponible.',
                        'count'   => $this->calcularCantidad($carrito),
                        'total'   => $this->calcularTotal($carrito),
                    ]);
                }

                $enCarrito    = $carrito[$id]['cantidad'] ?? 0;
                $nuevaCantidad = $enCarrito + $cant;

                // No permitir agregar más de lo que hay en stock
                if ($producto->stock > 0 && $nuevaCantidad > $producto->stock) {
                    return response()->json([
                        'success' => false,
                        'message' => "Solo hay {$producto->stock} unidades disponibles de \"{$producto->nombre}\".",
                        'count'   => $this->calcularCantidad($carrito),
                        'total'   => $this->calcularTotal($carrito),
                    ]);
                }

                if (isset($carrito[$id])) {
                    $carrito[$id]['cantidad'] = $nuevaCantidad;
                } else {
                    // Precio y nombre siempre desde BD, nunca del request
                    $carrito[$id] = [
                        'id'       => $id,
                        'nombre'   => $producto->nombre,
                        'precio'   => $producto->precio,
                        'cantidad' => $cant,
                    ];
                }
                break;

            case 'actualizar':
                $id  = (int) $request->input('id');
                $qty = (int) $request->input('cantidad');

                if ($id && isset($carrito[$id])) {
                    if ($qty <= 0) {
                        unset($carrito[$id]);
                    } else {
                        // ── #6: verificar stock al actualizar cantidad también ──
                        $producto = Producto::find($id);
                        if ($producto && $producto->stock > 0 && $qty > $producto->stock) {
                            $qty = $producto->stock;
                        }
                        $carrito[$id]['cantidad'] = $qty;
                    }
                }
                break;

            case 'eliminar':
                $id = (int) $request->input('id');
                unset($carrito[$id]);
                break;

            case 'limpiar':
                $carrito = [];
                break;
        }

        session(['carrito' => $carrito]);

        return response()->json([
            'success' => true,
            'count'   => $this->calcularCantidad($carrito),
            'total'   => $this->calcularTotal($carrito),
        ]);
    }

    // ── Helpers privados ────────────────────────────────

    private function calcularTotal(array $carrito): float
    {
        return array_sum(array_map(
            fn($item) => $item['precio'] * $item['cantidad'],
            $carrito
        ));
    }

    private function calcularCantidad(array $carrito): int
    {
        return array_sum(array_column($carrito, 'cantidad'));
    }
}