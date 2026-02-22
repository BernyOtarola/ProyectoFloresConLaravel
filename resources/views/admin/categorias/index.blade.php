@extends('layouts.admin')
@section('page-title', 'Categorías')

@section('content')
<div style="display:grid;grid-template-columns:1fr 340px;gap:2rem;">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Nombre</th><th>Descripción</th><th>Productos</th><th>Acciones</th></tr></thead>
            <tbody>
                @forelse($categorias as $c)
                <tr>
                    <td><strong>{{ $c->nombre }}</strong></td>
                    <td style="color:var(--gris);font-size:0.875rem;">{{ $c->descripcion ?? '—' }}</td>
                    <td><span class="badge badge-blue">{{ $c->productos_count }} productos</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline" onclick="editar({{ $c->id }},'{{ addslashes($c->nombre) }}','{{ addslashes($c->descripcion ?? '') }}')">Editar</button>
                        <form method="POST" action="{{ route('admin.categorias.eliminar', $c->id) }}" style="display:inline;" onsubmit="return confirm('¿Eliminar categoría?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:var(--gris);padding:2rem;">Sin categorías todavía</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="form-card" style="max-width:100%;height:fit-content;">
        <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.3rem;color:var(--verde);margin-bottom:1.5rem;" id="formTitle">Nueva Categoría</h3>
        <form method="POST" action="{{ route('admin.categorias.guardar') }}">
            @csrf
            <input type="hidden" name="edit_id" id="editId" value="0">
            <div class="form-group">
                <label>Nombre *</label>
                <input type="text" name="nombre" id="catNombre" placeholder="Ej: Ramos" required>
            </div>
            <div class="form-group">
                <label>Descripción</label>
                <textarea name="descripcion" id="catDesc" placeholder="Descripción breve…"></textarea>
            </div>
            <div style="display:flex;gap:1rem;">
                <button type="submit" class="btn btn-primary" id="submitBtn">Guardar</button>
                <button type="button" class="btn btn-outline" onclick="resetForm()">Limpiar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
function editar(id, nombre, desc) {
    document.getElementById('editId').value = id;
    document.getElementById('catNombre').value = nombre;
    document.getElementById('catDesc').value = desc;
    document.getElementById('formTitle').textContent = 'Editar Categoría';
    document.getElementById('submitBtn').textContent = 'Actualizar';
    document.getElementById('catNombre').focus();
}
function resetForm() {
    document.getElementById('editId').value = '0';
    document.getElementById('catNombre').value = '';
    document.getElementById('catDesc').value = '';
    document.getElementById('formTitle').textContent = 'Nueva Categoría';
    document.getElementById('submitBtn').textContent = 'Guardar';
}
</script>
@endpush