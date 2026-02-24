<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CarritoController extends Controller
{
    // ── Vista principal del carrito ──────────────────────
    // Antes de renderizar, sincroniza precios y nombres
    // desde BD para que nunca muestre datos obsoletos.
    public function index()
    {
        $carritoOriginal     = session('carrito', []);
        $carritoSincronizado = $this->sincronizarCarrito($carritoOriginal);

        // Detectar si hubo algún cambio real (precio, nombre o item eliminado)
        $huboCambios = $this->detectarCambios($carritoOriginal, $carritoSincronizado);

        // Persistir el carrito ya sincronizado en sesión
        session(['carrito' => $carritoSincronizado]);

        // Flag flash para mostrar aviso en la vista
        if ($huboCambios) {
            session()->flash('carrito_sync_changed', true);
        }

        $carrito  = $carritoSincronizado;
        $subtotal = $this->calcularTotal($carrito);

        return view('carrito.index', compact('carrito', 'subtotal'));
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

                // Precio y disponibilidad siempre desde BD
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
                    // Actualizar cantidad Y refrescar precio/nombre desde BD
                    $carrito[$id]['cantidad'] = $nuevaCantidad;
                    $carrito[$id]['precio']   = $producto->precio;
                    $carrito[$id]['nombre']   = $producto->nombre;
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
                        $producto = Producto::where('id', $id)
                            ->where('activo', true)
                            ->first();

                        // Si el producto ya no existe o fue desactivado, quitarlo
                        if (!$producto) {
                            unset($carrito[$id]);
                            break;
                        }

                        // Respetar stock máximo
                        if ($producto->stock > 0 && $qty > $producto->stock) {
                            $qty = $producto->stock;
                        }

                        // Actualizar cantidad Y refrescar precio/nombre desde BD
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

    /**
     * Sincroniza el carrito de sesión con la BD:
     * - Elimina productos inactivos o eliminados
     * - Actualiza precio y nombre si cambiaron
     * - Ajusta cantidad si el stock bajó
     *
     * @param  array<int|string, array> $carrito
     * @return array<int|string, array>
     */
    private function sincronizarCarrito(array $carrito): array
    {
        if (empty($carrito)) {
            return [];
        }

        // Una sola consulta para todos los IDs del carrito
        $ids      = array_keys($carrito);
        $productos = Producto::whereIn('id', $ids)
            ->where('activo', true)
            ->get()
            ->keyBy('id');

        foreach ($carrito as $id => $item) {
            // Producto eliminado o desactivado → sacarlo del carrito
            if (!isset($productos[$id])) {
                unset($carrito[$id]);
                continue;
            }

            $producto = $productos[$id];

            // Actualizar precio si cambió
            if ((float) $carrito[$id]['precio'] !== (float) $producto->precio) {
                $carrito[$id]['precio'] = $producto->precio;
            }

            // Actualizar nombre si cambió
            if ($carrito[$id]['nombre'] !== $producto->nombre) {
                $carrito[$id]['nombre'] = $producto->nombre;
            }

            // Ajustar cantidad si el stock bajó y es menor a lo que hay en el carrito
            if ($producto->stock > 0 && $carrito[$id]['cantidad'] > $producto->stock) {
                $carrito[$id]['cantidad'] = $producto->stock;
            }
        }

        return $carrito;
    }

    /**
     * Detecta si el carrito sincronizado difiere del original.
     * Retorna true si hubo cualquier cambio (precio, nombre, cantidad ajustada o item eliminado).
     *
     * @param  array<int|string, array> $original
     * @param  array<int|string, array> $sincronizado
     */
    private function detectarCambios(array $original, array $sincronizado): bool
    {
        // Item eliminado (producto desactivado o borrado)
        if (count($original) !== count($sincronizado)) {
            return true;
        }

        foreach ($original as $id => $item) {
            // Ya sabemos que count es igual, pero puede que la key no exista
            if (!isset($sincronizado[$id])) {
                return true;
            }

            $nuevo = $sincronizado[$id];

            // Precio cambió
            if ((float) $item['precio'] !== (float) $nuevo['precio']) {
                return true;
            }

            // Nombre cambió
            if ($item['nombre'] !== $nuevo['nombre']) {
                return true;
            }

            // Cantidad fue ajustada por stock
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