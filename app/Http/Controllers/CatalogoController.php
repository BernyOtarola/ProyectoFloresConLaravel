<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    public function index(Request $request)
    {
        $catId    = $request->integer('categoria');
        $busqueda = $request->string('q')->trim()->toString();

        $productos = Producto::with('categoria')
            ->where('activo', true)
            ->when($catId,    fn($q) => $q->where('categoria_id', $catId))
            ->when($busqueda, fn($q) => $q->where(function ($q) use ($busqueda) {
                $q->where('nombre',      'like', "%{$busqueda}%")
                  ->orWhere('descripcion','like', "%{$busqueda}%");
            }))
            ->orderByDesc('destacado')
            ->latest()
            ->get();

        $categorias = Categoria::withCount(['productos' => fn($q) => $q->where('activo', true)])
                        ->get();

        $catActual = $catId
            ? $categorias->firstWhere('id', $catId)?->nombre
            : null;

        return view('catalogo.index', compact('productos', 'categorias', 'catId', 'busqueda', 'catActual'));
    }
}