<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Suscriptor;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

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

    /**
     * API: Suscribir desde el formulario del home (AJAX)
     */
    public function suscribir(Request $request): JsonResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email'  => 'required|email|max:150',
        ]);

        $nombre = trim($request->input('nombre'));
        $email  = strtolower(trim($request->input('email')));

        // Si ya existe, solo reactivar si estaba inactivo
        $suscriptor = Suscriptor::where('email', $email)->first();

        if ($suscriptor) {
            if (!$suscriptor->activo) {
                $suscriptor->update(['activo' => true, 'nombre' => $nombre]);
            }

            return response()->json([
                'success' => true,
                'message' => "¡Ya estabas suscrita, {$nombre}! Te seguiremos enviando novedades 🌺",
            ]);
        }

        // Crear nuevo suscriptor (sin contraseña, solo newsletter)
        Suscriptor::create([
            'nombre' => $nombre,
            'email'  => $email,
            'activo' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => "¡Gracias {$nombre}! Te mantendremos al tanto 🌺",
        ]);
    }
}