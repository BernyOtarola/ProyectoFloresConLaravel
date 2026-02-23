@extends('layouts.admin')
@section('page-title', 'Pedidos')

@section('content')
<div class="table-wrap">
    <table>
        <thead>
            <tr><th>N° Pedido</th><th>Cliente</th><th>Teléfono</th><th>Entrega</th><th>Total</th><th>Estado</th><th>Fecha</th><th></th></tr>
        </thead>
        <tbody>
            @forelse($pedidos as $p)
            <tr>
                <td><strong>{{ $p->numero_pedido }}</strong></td>
                <td>{{ $p->nombre_cliente }}</td>
                <td>
                    <a href="https://wa.me/506{{ $p->telefono_cliente }}" target="_blank" style="color:var(--verde);">
                        📱 {{ $p->telefono_cliente }}
                    </a>
                </td>
                {{-- #9: accessor del modelo --}}
                <td>{{ $p->es_envio ? '🚗 Domicilio' : '🏪 Retiro' }}</td>
                <td><strong>{{ $p->total_formateado }}</strong></td>
                <td><span class="badge {{ $p->estado_badge }}">{{ $p->estado_label }}</span></td>
                {{-- #8: accessor en lugar de Carbon::parse() --}}
                <td style="color:var(--gris);font-size:0.83rem;">{{ $p->fecha_formateada }}</td>
                <td><a href="{{ route('admin.pedidos.detalle', $p->id) }}" class="btn btn-sm btn-outline">Ver detalle</a></td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:var(--gris);padding:2rem;">Sin pedidos todavía</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- #11: paginación --}}
@if($pedidos->hasPages())
<div style="margin-top:1.25rem;display:flex;justify-content:center;">
    {{ $pedidos->links() }}
</div>
@endif

@endsection