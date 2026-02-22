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
            'totalPedidos'      => Pedido::count(),
            'pedidosPendientes' => Pedido::where('estado', 'pendiente')->count(),
            'totalProductos'    => Producto::where('activo', true)->count(),
            'totalSuscriptores' => Suscriptor::where('activo', true)->count(),
            'ventasHoy'         => Pedido::whereDate('created_at', today())->sum('total'),
        ];

        $ultimosPedidos = Pedido::latest()->take(8)->get();

        return view('admin.dashboard', compact('stats', 'ultimosPedidos'));
    }
}