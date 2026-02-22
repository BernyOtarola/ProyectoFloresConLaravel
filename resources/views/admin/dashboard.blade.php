@extends('layouts.admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="stat-grid">
    <div class="stat-card"><div class="icon">📦</div><div class="num">{{ $stats['totalPedidos'] }}</div><div class="label">Total pedidos</div></div>
    <div class="stat-card"><div class="icon">⏳</div><div class="num">{{ $stats['pedidosPendientes'] }}</div><div class="label">Pendientes</div></div>
    <div class="stat-card"><div class="icon">🌸</div><div class="num">{{ $stats['totalProductos'] }}</div><div class="label">Productos activos</div></div>
    <div class="stat-card"><div class="icon">📧</div><div class="num">{{ $stats['totalSuscriptores'] }}</div><div class="label">Suscriptores</div></div>
    <div class="stat-card"><div class="icon">💰</div><div class="num" style="font-size:1.5rem;">{{ formatPrice($stats['ventasHoy']) }}</div><div class="label">Ventas hoy</div></div>
</div>

<h2 class="section-title">Últimos pedidos</h2>
<div class="table-wrap">
    <table>
        <thead>
            <tr><th>Pedido</th><th>Cliente</th><th>Entrega</th><th>Total</th><th>Estado</th><th>Fecha</th><th></th></tr>
        </thead>
        <tbody>
            @forelse($ultimosPedidos as $p)
            @php
                $badges = ['pendiente'=>'badge-yellow','confirmado'=>'badge-blue','en_proceso'=>'badge-blue','listo'=>'badge-green','entregado'=>'badge-green','cancelado'=>'badge-red'];
                $labels = ['pendiente'=>'Pendiente','confirmado'=>'Confirmado','en_proceso'=>'En proceso','listo'=>'Listo','entregado'=>'Entregado','cancelado'=>'Cancelado'];
                $st = $p->estado;
            @endphp
            <tr>
                <td><strong>{{ $p->numero_pedido }}</strong></td>
                <td>{{ $p->nombre_cliente }}</td>
                <td>{{ $p->tipo_entrega === 'envio' ? '🚗 Domicilio' : '🏪 Retiro' }}</td>
                <td><strong>{{ formatPrice($p->total) }}</strong></td>
                <td><span class="badge {{ $badges[$st] ?? 'badge-gray' }}">{{ $labels[$st] ?? $st }}</span></td>
                <td style="color:var(--gris);font-size:0.85rem;">{{ \Carbon\Carbon::parse($p->creado_en)->format('d/m/Y H:i') }}</td>
                <td><a href="{{ route('admin.pedidos.detalle', $p->id) }}" class="btn btn-sm btn-outline">Ver</a></td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:var(--gris);padding:2rem;">No hay pedidos aún</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div style="margin-top:1rem;text-align:right;">
    <a href="{{ route('admin.pedidos.index') }}" class="btn btn-outline">Ver todos los pedidos →</a>
</div>
@endsection