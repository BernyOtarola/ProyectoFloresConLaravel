<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CarritoController extends Controller
{
    // ── Vista principal del carrito ──────────────────────
    public function index()
    {
        $carritoOriginal     = session('carrito', []);
        $carritoSincronizado = $this->sincronizarCarrito($carritoOriginal);

        $huboCambios = $this->detectarCambios($carritoOriginal, $carritoSincronizado);

        session(['carrito' => $carritoSincronizado]);

        if ($huboCambios) {
            session()->flash('carrito_sync_changed', true);
        }

        $carrito  = $carritoSincronizado;
        $subtotal = $this->calcularTotal($carrito);

        // ── Preparar cartData para JS (evita ParseError en Blade) ──
        $cartData = array_values(array_map(fn($item) => [
            'id'       => $item['id'],
            'nombre'   => $item['nombre'],
            'precio'   => $item['precio'],
            'cantidad' => $item['cantidad'],
        ], $carrito));

        return view('carrito.index', compact('carrito', 'subtotal', 'cartData'));
    }

    // ── API AJAX ─────────────────────────────────────────
    public function api(Request $request): JsonResponse
    {
        $accion  = $request->input('accion');
        $carrito = session('carrito', []);

        switch ($accion) {

            case 'agregar':
                $id   = (int) $request->input('id');
                $cant = max(1, (int) $request->input('cantidad', 1));

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

                $enCarrito     = $carrito[$id]['cantidad'] ?? 0;
                $nuevaCantidad = $enCarrito + $cant;

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
                    $carrito[$id]['precio']   = $producto->precio;
                    $carrito[$id]['nombre']   = $producto->nombre;
                } else {
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
                        $producto = Producto::where('id', $id)
                            ->where('activo', true)
                            ->first();

                        if (!$producto) {
                            unset($carrito[$id]);
                            break;
                        }

                        if ($producto->stock > 0 && $qty > $producto->stock) {
                            $qty = $producto->stock;
                        }

                        $carrito[$id]['cantidad'] = $qty;
                        $carrito[$id]['precio']   = $producto->precio;
                        $carrito[$id]['nombre']   = $producto->nombre;
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

    private function sincronizarCarrito(array $carrito): array
    {
        if (empty($carrito)) {
            return [];
        }

        $ids      = array_keys($carrito);
        $productos = Producto::whereIn('id', $ids)
            ->where('activo', true)
            ->get()
            ->keyBy('id');

        foreach ($carrito as $id => $item) {
            if (!isset($productos[$id])) {
                unset($carrito[$id]);
                continue;
            }

            $producto = $productos[$id];

            if ((float) $carrito[$id]['precio'] !== (float) $producto->precio) {
                $carrito[$id]['precio'] = $producto->precio;
            }

            if ($carrito[$id]['nombre'] !== $producto->nombre) {
                $carrito[$id]['nombre'] = $producto->nombre;
            }

            if ($producto->stock > 0 && $carrito[$id]['cantidad'] > $producto->stock) {
                $carrito[$id]['cantidad'] = $producto->stock;
            }
        }

        return $carrito;
    }

    private function detectarCambios(array $original, array $sincronizado): bool
    {
        if (count($original) !== count($sincronizado)) {
            return true;
        }

        foreach ($original as $id => $item) {
            if (!isset($sincronizado[$id])) {
                return true;
            }

            $nuevo = $sincronizado[$id];

            if ((float) $item['precio'] !== (float) $nuevo['precio']) {
                return true;
            }

            if ($item['nombre'] !== $nuevo['nombre']) {
                return true;
            }

            if ((int) $item['cantidad'] !== (int) $nuevo['cantidad']) {
                return true;
            }
        }

        return false;
    }

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