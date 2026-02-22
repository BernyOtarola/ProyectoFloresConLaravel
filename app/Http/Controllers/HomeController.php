<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;

class HomeController extends Controller
{
    public function index()
    {
        $productos = Producto::with('categoria')
            ->where('activo', true)
            ->where('destacado', true)
            ->latest()
            ->take(6)
            ->get();

        $categorias = Categoria::withCount(['productos' => fn($q) => $q->where('activo', true)])
            ->get();

        return view('home.index', compact('productos', 'categorias'));
    }
}