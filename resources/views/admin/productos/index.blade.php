@extends('layouts.admin')
@section('page-title', 'Productos')
@section('top-actions')
    <a href="{{ route('admin.productos.crear') }}" class="btn btn-primary">+ Agregar producto</a>
@endsection

@push('css')
<style>
    /* ── Vista tabla (desktop) ─────────────── */
    .prod-table-desktop { display:block; }
    .prod-cards-mobile  { display:none; }

    /* ── Vista tarjetas (móvil) ────────────── */
    .pm-card {
        background:white;border-radius:14px;padding:1rem;
        border:1px solid rgba(42,74,30,0.06);
        margin-bottom:1rem;
    }
    .pm-top { display:flex;align-items:center;gap:1rem;margin-bottom:0.75rem; }
    .pm-img { width:56px;height:56px;border-radius:10px;object-fit:cover;flex-shrink:0; }
    .pm-ph  { width:56px;height:56px;border-radius:10px;background:linear-gradient(135deg,#e8f5e0,#d4edca);display:flex;align-items:center;justify-content:center;font-size:1.8rem;flex-shrink:0; }
    .pm-info { min-width:0; }
    .pm-name { font-weight:600;color:var(--verde);font-size:0.95rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }
    .pm-cat  { font-size:0.78rem;color:var(--gris); }
    .pm-row  { display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.5rem; }
    .pm-stats { display:flex;gap:0.5rem;align-items:center;flex-wrap:wrap; }
    .pm-price { font-weight:600;color:var(--verde);font-size:1rem; }
    .pm-actions { display:flex;gap:0.5rem;flex-wrap:wrap;margin-top:0.75rem; }
    .pm-actions .btn { flex:1;justify-content:center;min-width:0; }

    @media(max-width:900px) {
        .prod-table-desktop { display:none; }
        .prod-cards-mobile  { display:block; }
    }
</style>
@endpush

@section('content')

{{-- ═══ DESKTOP: Tabla ═══ --}}
<div class="prod-table-desktop">
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Imagen</th><th>Nombre</th><th>Categoría</th><th>Precio</th><th>Stock</th><th>Estado</th><th>Acciones</th></tr>
            </thead>
            <tbody>
                @forelse($productos as $p)
                <tr>
                    <td>
                        @if($p->imagen)
                            <img src="{{ asset('storage/products/' . $p->imagen) }}" style="width:50px;height:50px;object-fit:cover;border-radius:8px;">
                        @else
                            <span style="font-size:2rem;">💐</span>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $p->nombre }}</strong>
                        @if($p->destacado)
                            <span class="badge badge-blue" style="margin-left:6px;">⭐ Destacado</span>
                        @endif
                    </td>
                    <td>{{ $p->categoria->nombre ?? '—' }}</td>
                    <td><strong>{{ formatPrice($p->precio) }}</strong></td>
                    <td>
                        @php $cls = $p->stock > 10 ? 'badge-green' : ($p->stock > 0 ? 'badge-yellow' : 'badge-red'); @endphp
                        <span class="badge {{ $cls }}">{{ $p->stock }}</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.productos.toggle', $p->id) }}" class="badge {{ $p->activo ? 'badge-green' : 'badge-gray' }}" style="text-decoration:none;cursor:pointer;">
                            {{ $p->activo ? 'Activo' : 'Inactivo' }}
                        </a>
                    </td>
                    <td style="white-space:nowrap;">
                        <a href="{{ route('admin.productos.editar', $p->id) }}" class="btn btn-sm btn-outline">Editar</a>
                        <form method="POST" action="{{ route('admin.productos.eliminar', $p->id) }}" style="display:inline;" onsubmit="return confirm('¿Eliminar este producto?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;color:var(--gris);padding:2rem;">No hay productos. <a href="{{ route('admin.productos.crear') }}">Agregar uno</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ═══ MÓVIL: Tarjetas ═══ --}}
<div class="prod-cards-mobile">
    @forelse($productos as $p)
    <div class="pm-card">
        <div class="pm-top">
            @if($p->imagen)
                <img src="{{ asset('storage/products/' . $p->imagen) }}" class="pm-img" alt="{{ $p->nombre }}">
            @else
                <div class="pm-ph">💐</div>
            @endif
            <div class="pm-info">
                <div class="pm-name">
                    {{ $p->nombre }}
                    @if($p->destacado) ⭐ @endif
                </div>
                <div class="pm-cat">{{ $p->categoria->nombre ?? 'Sin categoría' }}</div>
            </div>
        </div>
        <div class="pm-row">
            <span class="pm-price">{{ formatPrice($p->precio) }}</span>
            <div class="pm-stats">
                @php $cls = $p->stock > 10 ? 'badge-green' : ($p->stock > 0 ? 'badge-yellow' : 'badge-red'); @endphp
                <span class="badge {{ $cls }}">Stock: {{ $p->stock }}</span>
                <a href="{{ route('admin.productos.toggle', $p->id) }}" class="badge {{ $p->activo ? 'badge-green' : 'badge-gray' }}" style="text-decoration:none;">
                    {{ $p->activo ? 'Activo' : 'Inactivo' }}
                </a>
            </div>
        </div>
        <div class="pm-actions">
            <a href="{{ route('admin.productos.editar', $p->id) }}" class="btn btn-sm btn-outline">Editar</a>
            <form method="POST" action="{{ route('admin.productos.eliminar', $p->id) }}" style="flex:1;display:flex;" onsubmit="return confirm('¿Eliminar este producto?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger" style="flex:1;">Eliminar</button>
            </form>
        </div>
    </div>
    @empty
    <div style="text-align:center;color:var(--gris);padding:3rem;">
        <div style="font-size:3rem;margin-bottom:1rem;">🌱</div>
        <p>No hay productos. <a href="{{ route('admin.productos.crear') }}" style="color:var(--verde);">Agregar uno</a></p>
    </div>
    @endforelse
</div>

@endsection