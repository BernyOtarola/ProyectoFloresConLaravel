<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        // ── #11: paginación en lugar de get() ────────────
        $pedidos = Pedido::latest('creado_en')->paginate(20);

        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function detalle($id)
    {
        $pedido = Pedido::findOrFail($id);

        // $pedido->items ya viene del accessor getItemsAttribute()
        return view('admin.pedidos.detalle', compact('pedido'));
    }

    public function cambiarEstado(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        $request->validate([
            'estado' => 'required|in:' . implode(',', array_keys(Pedido::ESTADOS)),
        ]);

        $pedido->update(['estado' => $request->input('estado')]);

        return redirect()->route('admin.pedidos.detalle', $pedido->id)
            ->with('success', 'Estado actualizado.');
    }
}