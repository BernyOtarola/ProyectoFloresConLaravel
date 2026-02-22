@extends('layouts.admin')
@section('page-title', 'Productos')
@section('top-actions')
    <a href="{{ route('admin.productos.crear') }}" class="btn btn-primary">+ Agregar producto</a>
@endsection

@section('content')
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
@endsection