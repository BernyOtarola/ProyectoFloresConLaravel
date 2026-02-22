<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::latest()->get();

        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function show(Pedido $pedido)
    {
        $items = json_decode($pedido->items_json, true) ?? [];

        return view('admin.pedidos.detalle', compact('pedido', 'items'));
    }

    public function updateEstado(Request $request, Pedido $pedido)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,confirmado,en_proceso,listo,entregado,cancelado',
        ]);

        $pedido->update(['estado' => $request->input('estado')]);

        return redirect()->route('admin.pedidos.show', $pedido)
            ->with('success', 'Estado actualizado.');
    }
}