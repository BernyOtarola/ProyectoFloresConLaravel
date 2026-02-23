<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::withCount(['productos' => fn($q) => $q->where('activo', true)])
            ->orderBy('nombre')
            ->get();

        return view('admin.categorias.index', compact('categorias'));
    }

    public function guardar(Request $request)          // ← era store()
    {
        $request->validate([
            'nombre'      => 'required|string|max:100',
            'descripcion' => 'nullable|string',
        ]);

        $id = $request->input('id');

        if ($id) {
            // Editar existente
            $categoria = Categoria::findOrFail($id);
            $categoria->update([
                'nombre'      => trim($request->input('nombre')),
                'descripcion' => trim($request->input('descripcion', '')),
            ]);

            return redirect()->route('admin.categorias.index')
                ->with('success', 'Categoría actualizada.');
        }

        // Crear nueva
        Categoria::create([
            'nombre'      => trim($request->input('nombre')),
            'descripcion' => trim($request->input('descripcion', '')),
        ]);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría creada.');
    }

    public function eliminar($id)                      // ← era destroy()
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría eliminada.');
    }
}