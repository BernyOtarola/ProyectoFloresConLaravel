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
            ->latest()
            ->get();

        return view('admin.productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.productos.form', [
            'producto'   => null,
            'categorias' => $categorias,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validar($request);
        $data['imagen'] = $this->subirImagen($request, null);

        Producto::create($data);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.productos.form', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        $data = $this->validar($request);
        $data['imagen'] = $this->subirImagen($request, $producto->imagen);

        $producto->update($data);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto actualizado.');
    }

    public function toggle(Producto $producto)
    {
        $producto->update(['activo' => !$producto->activo]);

        return redirect()->route('admin.productos.index');
    }

    public function destroy(Producto $producto)
    {
        // Borrar imagen si existe
        if ($producto->imagen) {
            Storage::disk('public')->delete('products/' . $producto->imagen);
        }

        $producto->delete();

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto eliminado.');
    }

    // ── Helpers privados ────────────────────────────────────

    private function validar(Request $request): array
    {
        $request->validate([
            'nombre'       => 'required|string|max:150',
            'descripcion'  => 'nullable|string',
            'precio'       => 'required|numeric|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
            'stock'        => 'required|integer|min:0',
            'imagen'       => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);

        return [
            'nombre'       => trim($request->input('nombre')),
            'descripcion'  => trim($request->input('descripcion', '')),
            'precio'       => (float) $request->input('precio'),
            'categoria_id' => $request->input('categoria_id') ?: null,
            'stock'        => (int) $request->input('stock'),
            'destacado'    => $request->boolean('destacado'),
            'activo'       => $request->boolean('activo'),
        ];
    }

    private function subirImagen(Request $request, ?string $imagenActual): ?string
    {
        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            // Borrar imagen anterior
            if ($imagenActual) {
                Storage::disk('public')->delete('products/' . $imagenActual);
            }
            // Guardar nueva imagen en storage/app/public/products/
            $path = $request->file('imagen')->store('products', 'public');
            return basename($path);
        }

        return $imagenActual;
    }
}
