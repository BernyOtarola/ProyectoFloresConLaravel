<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('categoria')
            ->orderByDesc('destacado')
            ->latest('creado_en')
            ->get();

        return view('admin.productos.index', compact('productos'));
    }

    public function crear()                          // ← era create()
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.productos.form', [
            'producto'   => null,
            'categorias' => $categorias,
        ]);
    }

    public function guardar(Request $request)        // ← era store()
    {
        $data = $this->validar($request);
        $data['imagen'] = $this->subirImagen($request, null);

        Producto::create($data);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    public function editar($id)                      // ← era edit(Producto $producto)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.productos.form', compact('producto', 'categorias'));
    }

    public function actualizar(Request $request, $id) // ← era update()
    {
        $producto = Producto::findOrFail($id);
        $data = $this->validar($request);
        $data['imagen'] = $this->subirImagen($request, $producto->imagen);

        $producto->update($data);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto actualizado.');
    }

    public function toggle($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->update(['activo' => !$producto->activo]);

        return redirect()->route('admin.productos.index')
            ->with('success', $producto->activo ? 'Producto activado.' : 'Producto desactivado.');
    }

    public function eliminar($id)                    // ← era destroy()
    {
        $producto = Producto::findOrFail($id);

        if ($producto->imagen) {
            Storage::disk('public')->delete('products/' . $producto->imagen);
        }

        $producto->delete();

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto eliminado.');
    }

    // ── Helpers privados ─────────────────────────────────

    private function validar(Request $request): array
    {
        $data = $request->validate([
            'nombre'       => 'required|string|max:200',
            'descripcion'  => 'nullable|string',
            'precio'       => 'required|numeric|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
            'stock'        => 'nullable|integer|min:0',
        ]);

        $data['destacado'] = $request->has('destacado') ? 1 : 0;
        $data['activo']    = $request->has('activo') ? 1 : 0;
        $data['stock']     = $data['stock'] ?? 0;

        return $data;
    }

    private function subirImagen(Request $request, ?string $imagenActual): ?string
    {
        if ($request->hasFile('imagen')) {
            if ($imagenActual) {
                Storage::disk('public')->delete('products/' . $imagenActual);
            }

            $file = $request->file('imagen');
            $nombre = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('products', $nombre, 'public');

            return $nombre;
        }

        return $imagenActual;
    }
}