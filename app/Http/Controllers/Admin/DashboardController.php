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
            <tr>
                <td><strong>{{ $p->numero_pedido }}</strong></td>
                <td>{{ $p->nombre_cliente }}</td>
                <td>{{ $p->es_envio ? '🚗 Domicilio' : '🏪 Retiro' }}</td>
                <td><strong>{{ $p->total_formateado }}</strong></td>
                {{-- #9: accessor del modelo en lugar del array @php local --}}
                <td><span class="badge {{ $p->estado_badge }}">{{ $p->estado_label }}</span></td>
                {{-- #8: accessor en lugar de \Carbon\Carbon::parse() --}}
                <td style="color:var(--gris);font-size:0.85rem;">{{ $p->fecha_formateada }}</td>
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