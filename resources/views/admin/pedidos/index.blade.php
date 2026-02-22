@extends('layouts.admin')
@section('page-title', 'Pedidos')

@section('content')
@php
    $badges = ['pendiente'=>'badge-yellow','confirmado'=>'badge-blue','en_proceso'=>'badge-blue','listo'=>'badge-green','entregado'=>'badge-green','cancelado'=>'badge-red'];
    $labels = ['pendiente'=>'Pendiente','confirmado'=>'Confirmado','en_proceso'=>'En proceso','listo'=>'Listo','entregado'=>'Entregado','cancelado'=>'Cancelado'];
@endphp

<div class="table-wrap">
    <table>
        <thead>
            <tr><th>N° Pedido</th><th>Cliente</th><th>Teléfono</th><th>Entrega</th><th>Total</th><th>Estado</th><th>Fecha</th><th></th></tr>
        </thead>
        <tbody>
            @forelse($pedidos as $p)
            @php $st = $p->estado; @endphp
            <tr>
                <td><strong>{{ $p->numero_pedido }}</strong></td>
                <td>{{ $p->nombre_cliente }}</td>
                <td><a href="https://wa.me/506{{ $p->telefono_cliente }}" target="_blank" style="color:var(--verde);">📱 {{ $p->telefono_cliente }}</a></td>
                <td>{{ $p->tipo_entrega === 'envio' ? '🚗 Domicilio' : '🏪 Retiro' }}</td>
                <td><strong>{{ formatPrice($p->total) }}</strong></td>
                <td><span class="badge {{ $badges[$st] ?? 'badge-gray' }}">{{ $labels[$st] ?? $st }}</span></td>
                <td style="color:var(--gris);font-size:0.83rem;">{{ \Carbon\Carbon::parse($p->creado_en)->format('d/m/Y H:i') }}</td>
                <td><a href="{{ route('admin.pedidos.detalle', $p->id) }}" class="btn btn-sm btn-outline">Ver detalle</a></td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:var(--gris);padding:2rem;">Sin pedidos todavía</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection