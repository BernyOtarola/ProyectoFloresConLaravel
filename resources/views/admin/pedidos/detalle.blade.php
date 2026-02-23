@extends('layouts.admin')
@section('page-title', 'Pedido ' . $pedido->numero_pedido)
@section('top-actions')
    <a href="{{ route('admin.pedidos.index') }}" class="btn btn-outline">← Volver</a>
@endsection

@push('css')
<style>
    .pedido-grid { display:grid;grid-template-columns:1fr 340px;gap:2rem; }
    @media(max-width:900px){ .pedido-grid{grid-template-columns:1fr;} }
</style>
@endpush

@section('content')
@php
    $badges = ['pendiente'=>'badge-yellow','confirmado'=>'badge-blue','en_proceso'=>'badge-blue','listo'=>'badge-green','entregado'=>'badge-green','cancelado'=>'badge-red'];
    $labels = ['pendiente'=>'Pendiente','confirmado'=>'Confirmado','en_proceso'=>'En proceso','listo'=>'Listo para retirar','entregado'=>'Entregado','cancelado'=>'Cancelado'];
    $st = $pedido->estado;
@endphp

<div class="pedido-grid">
    <div>
        <div class="form-card" style="max-width:100%;">
            <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.4rem;color:var(--verde);margin-bottom:1.5rem;">📦 Detalle del pedido</h3>
            <table style="width:100%;border-collapse:collapse;">
                <tr><td style="padding:8px 0;color:var(--gris);font-size:0.85rem;width:120px;">N° Pedido</td><td><strong>{{ $pedido->numero_pedido }}</strong></td></tr>
                <tr><td style="padding:8px 0;color:var(--gris);font-size:0.85rem;">Estado</td><td><span class="badge {{ $badges[$st] ?? 'badge-gray' }}">{{ $labels[$st] ?? $st }}</span></td></tr>
                <tr><td style="padding:8px 0;color:var(--gris);font-size:0.85rem;">Fecha</td><td>{{ \Carbon\Carbon::parse($pedido->creado_en)->format('d/m/Y H:i') }}</td></tr>
            </table>

            <hr style="border:none;border-top:1px solid rgba(42,74,30,0.08);margin:1.5rem 0;">

            <h4 style="color:var(--verde);margin-bottom:1rem;">👤 Datos del cliente</h4>
            <table style="width:100%;border-collapse:collapse;">
                <tr><td style="padding:6px 0;color:var(--gris);font-size:0.85rem;width:120px;">Nombre</td><td>{{ $pedido->nombre_cliente }}</td></tr>
                <tr><td style="padding:6px 0;color:var(--gris);font-size:0.85rem;">Teléfono</td>
                    <td><a href="https://wa.me/506{{ $pedido->telefono_cliente }}" target="_blank" style="color:var(--verde);">📱 {{ $pedido->telefono_cliente }}</a></td></tr>
                @if($pedido->email_cliente)
                <tr><td style="padding:6px 0;color:var(--gris);font-size:0.85rem;">Email</td><td style="word-break:break-all;">{{ $pedido->email_cliente }}</td></tr>
                @endif
                <tr><td style="padding:6px 0;color:var(--gris);font-size:0.85rem;">Entrega</td><td>{{ $pedido->tipo_entrega === 'envio' ? '🚗 Domicilio' : '🏪 Retiro en local' }}</td></tr>
                @if($pedido->direccion_envio)
                <tr><td style="padding:6px 0;color:var(--gris);font-size:0.85rem;">Dirección</td><td>{{ $pedido->direccion_envio }}</td></tr>
                @endif
                @if($pedido->nota)
                <tr><td style="padding:6px 0;color:var(--gris);font-size:0.85rem;">Nota</td><td style="font-style:italic;">{{ $pedido->nota }}</td></tr>
                @endif
            </table>

            <hr style="border:none;border-top:1px solid rgba(42,74,30,0.08);margin:1.5rem 0;">

            <h4 style="color:var(--verde);margin-bottom:1rem;">🛒 Productos</h4>
            <table style="width:100%;border-collapse:collapse;">
                @foreach($pedido->items as $item)
                <tr style="border-bottom:1px solid rgba(42,74,30,0.06);">
                    <td style="padding:10px 0;">💐 {{ $item['nombre'] }}</td>
                    <td style="color:var(--gris);text-align:center;">x{{ (int)$item['cantidad'] }}</td>
                    <td style="font-weight:500;text-align:right;">{{ formatPrice($item['precio'] * $item['cantidad']) }}</td>
                </tr>
                @endforeach
                <tr><td colspan="2" style="padding:10px 0;color:var(--gris);">Subtotal</td><td style="text-align:right;">{{ formatPrice($pedido->subtotal) }}</td></tr>
                @if($pedido->costo_envio > 0)
                <tr><td colspan="2" style="color:var(--gris);">Envío</td><td style="text-align:right;">{{ formatPrice($pedido->costo_envio) }}</td></tr>
                @endif
                <tr><td colspan="2" style="padding:10px 0;font-weight:600;color:var(--verde);">TOTAL</td><td style="text-align:right;font-family:'Cormorant Garamond',serif;font-size:1.3rem;font-weight:600;color:var(--verde);">{{ formatPrice($pedido->total) }}</td></tr>
            </table>
        </div>
    </div>

    <div>
        <div class="form-card" style="max-width:100%;">
            <h4 style="color:var(--verde);margin-bottom:1.25rem;">🔄 Actualizar estado</h4>
            <form method="POST" action="{{ route('admin.pedidos.estado', $pedido->id) }}">
                @csrf @method('PATCH')
                <div class="form-group">
                    <select name="estado">
                        @foreach($labels as $val => $lbl)
                        <option value="{{ $val }}" {{ $st === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;">Guardar estado</button>
            </form>

            <hr style="border:none;border-top:1px solid rgba(42,74,30,0.08);margin:1.5rem 0;">

            <a href="https://wa.me/506{{ $pedido->telefono_cliente }}" target="_blank" class="btn" style="width:100%;background:#25D366;color:white;justify-content:center;">
                💬 Contactar por WhatsApp
            </a>
        </div>
    </div>
</div>
@endsection