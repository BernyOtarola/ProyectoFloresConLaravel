<?php

namespace App\Http\Controllers;

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
        $accion = $request->input('accion');
        $carrito = session('carrito', []);

        switch ($accion) {

            case 'agregar':
                $id     = (int) $request->input('id');
                $nombre = strip_tags($request->input('nombre', ''));
                $precio = (float) $request->input('precio');
                $cant   = (int) $request->input('cantidad', 1);

                if ($id && $nombre && $precio > 0) {
                    if (isset($carrito[$id])) {
                        $carrito[$id]['cantidad'] += $cant;
                    } else {
                        $carrito[$id] = [
                            'id'       => $id,
                            'nombre'   => $nombre,
                            'precio'   => $precio,
                            'cantidad' => $cant,
                        ];
                    }
                }
                break;

            case 'actualizar':
                $id  = (int) $request->input('id');
                $qty = (int) $request->input('cantidad');
                if ($id && isset($carrito[$id])) {
                    if ($qty <= 0) unset($carrito[$id]);
                    else $carrito[$id]['cantidad'] = $qty;
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

    // ── Helpers privados ────────────────────────────────────

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