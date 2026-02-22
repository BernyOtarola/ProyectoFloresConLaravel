<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Suscriptor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $productos = Producto::with('categoria')
            ->where('activo', true)
            ->where('destacado', true)
            ->latest('creado_en')
            ->take(6)
            ->get();

        $categorias = Categoria::withCount(['productos' => fn($q) => $q->where('activo', true)])
            ->get();

        return view('home.index', compact('productos', 'categorias'));
    }

    public function suscribir(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'email'  => 'required|email|max:150',
        ]);

        Suscriptor::firstOrCreate(
            ['email' => $request->input('email')],
            [
                'nombre' => trim($request->input('nombre')),
                'activo' => true,
            ]
        );

        return response()->json(['success' => true]);
    }
}