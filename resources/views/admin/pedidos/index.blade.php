@extends('layouts.admin')
@section('page-title', 'Pedidos')

@section('content')
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>N° Pedido</th>
                <th>Cliente</th>
                <th>Teléfono</th>
                <th>Entrega</th>
                {{-- FIX #5: columna fecha retiro --}}
                <th>📅 Fecha retiro</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Creado</th>
                <th></th>
            </tr>
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
                <td>{{ $p->es_envio ? '🚗 Domicilio' : '🏪 Retiro' }}</td>
                {{-- FIX #5: mostrar fecha_retiro con badge de alerta si es hoy --}}
                <td>
                    @if($p->fecha_retiro)
                        @php
                            $esHoy   = $p->fecha_retiro->isToday();
                            $vencido = $p->fecha_retiro->isPast() && !$esHoy;
                        @endphp
                        <span class="badge {{ $esHoy ? 'badge-yellow' : ($vencido ? 'badge-red' : 'badge-blue') }}">
                            {{ $p->fecha_retiro_formateada }}
                            @if($esHoy) ⚠️ Hoy @endif
                        </span>
                    @else
                        <span style="color:var(--gris);font-size:0.83rem;">—</span>
                    @endif
                </td>
                <td><strong>{{ $p->total_formateado }}</strong></td>
                <td><span class="badge {{ $p->estado_badge }}">{{ $p->estado_label }}</span></td>
                <td style="color:var(--gris);font-size:0.83rem;">{{ $p->fecha_formateada }}</td>
                <td><a href="{{ route('admin.pedidos.detalle', $p->id) }}" class="btn btn-sm btn-outline">Ver detalle</a></td>
            </tr>
            @empty
            <tr><td colspan="9" style="text-align:center;color:var(--gris);padding:2rem;">Sin pedidos todavía</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($pedidos->hasPages())
<div style="margin-top:1.25rem;display:flex;justify-content:center;">
    {{ $pedidos->links() }}
</div>
@endif

@endsection