@extends('layouts.admin')
@section('page-title', 'Suscriptores')
@section('top-actions')
    <a href="{{ route('admin.suscriptores.exportar') }}" class="btn btn-outline">⬇️ Exportar CSV</a>
@endsection

@section('content')
<div class="table-wrap">
    <table>
        <thead><tr><th>Nombre</th><th>Email</th><th>Cuenta</th><th>Fecha</th><th></th></tr></thead>
        <tbody>
            @forelse($suscriptores as $s)
            <tr>
                <td>{{ $s->nombre }}</td>
                <td>{{ $s->email }}</td>
                <td><span class="badge {{ $s->password_hash ? 'badge-green' : 'badge-gray' }}">{{ $s->password_hash ? 'Con cuenta' : 'Solo suscrito' }}</span></td>
                <td style="color:var(--gris);font-size:0.83rem;">{{ \Carbon\Carbon::parse($s->suscrito_en)->format('d/m/Y') }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.suscriptores.eliminar', $s->id) }}" onsubmit="return confirm('¿Eliminar suscriptor?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:var(--gris);padding:2rem;">Sin suscriptores todavía</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection