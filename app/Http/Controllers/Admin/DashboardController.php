<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Suscriptor;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalPedidos'       => Pedido::count(),
            'pedidosPendientes'  => Pedido::where('estado', 'pendiente')->count(),
            'totalProductos'     => Producto::where('activo', true)->count(),
            'totalSuscriptores'  => Suscriptor::where('activo', true)->count(),
            'ventasHoy'          => Pedido::whereDate('creado_en', today())
                                        ->whereNotIn('estado', ['cancelado'])
                                        ->sum('total'),
        ];

        $ultimosPedidos = Pedido::latest('creado_en')->take(10)->get();

        return view('admin.dashboard', compact('stats', 'ultimosPedidos'));
    }
}