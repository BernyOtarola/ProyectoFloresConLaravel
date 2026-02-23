<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Barryvdh\DomPDF\Facade\Pdf;
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
            ->latest('creado_en')
            ->get();

        $categorias = Categoria::withCount(['productos' => fn($q) => $q->where('activo', true)])
                        ->get();

        $catActual = $catId
            ? $categorias->firstWhere('id', $catId)?->nombre
            : null;

        return view('catalogo.index', compact('productos', 'categorias', 'catId', 'busqueda', 'catActual'));
    }

    public function pdf()
    {
        $categorias = Categoria::with(['productos' => function ($q) {
            $q->where('activo', true)->orderByDesc('destacado')->orderBy('nombre');
        }])->get()->filter(fn($c) => $c->productos->count() > 0);

        $totalProductos = Producto::where('activo', true)->count();

        $pdf = Pdf::loadView('catalogo.pdf', compact('categorias', 'totalProductos'))
            ->setPaper('a4', 'portrait')
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', 'sans-serif');

        return $pdf->download('Catalogo-Floristeria-Bribri-' . date('Y-m') . '.pdf');
    }
}