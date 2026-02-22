@extends('layouts.admin')
@section('page-title', $producto ? 'Editar Producto' : 'Agregar Producto')

@section('content')
<div class="form-card">
    <form method="POST"
          action="{{ $producto ? route('admin.productos.actualizar', $producto->id) : route('admin.productos.guardar') }}"
          enctype="multipart/form-data">
        @csrf
        @if($producto) @method('PUT') @endif

        <div class="form-grid">
            <div class="form-group full">
                <label>Nombre del producto *</label>
                <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre ?? '') }}" placeholder="Ej: Ramo de rosas rojas" required>
            </div>
            <div class="form-group full">
                <label>Descripción</label>
                <textarea name="descripcion" placeholder="Describe el arreglo floral…">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
            </div>
            <div class="form-group">
                <label>Precio (₡) *</label>
                <input type="number" name="precio" value="{{ old('precio', $producto->precio ?? '') }}" placeholder="12000" step="100" min="0" required>
            </div>
            <div class="form-group">
                <label>Stock</label>
                <input type="number" name="stock" value="{{ old('stock', $producto->stock ?? 0) }}" min="0">
            </div>
            <div class="form-group">
                <label>Categoría</label>
                <select name="categoria_id">
                    <option value="">Sin categoría</option>
                    @foreach($categorias as $c)
                    <option value="{{ $c->id }}" {{ old('categoria_id', $producto->categoria_id ?? '') == $c->id ? 'selected' : '' }}>
                        {{ $c->nombre }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Imagen</label>
                <input type="file" name="imagen" accept="image/*">
                @if(!empty($producto->imagen))
                    <img src="{{ asset('storage/products/' . $producto->imagen) }}" style="width:80px;height:80px;object-fit:cover;border-radius:8px;margin-top:8px;display:block;">
                @endif
            </div>
            <div class="form-group full" style="display:flex;gap:2rem;">
                <label class="form-check">
                    <input type="checkbox" name="destacado" value="1" {{ old('destacado', $producto->destacado ?? false) ? 'checked' : '' }}>
                    ⭐ Producto destacado
                </label>
                <label class="form-check">
                    <input type="checkbox" name="activo" value="1" {{ old('activo', $producto->activo ?? true) ? 'checked' : '' }}>
                    ✅ Activo (visible en tienda)
                </label>
            </div>
        </div>
        <div style="display:flex;gap:1rem;margin-top:0.5rem;">
            <button type="submit" class="btn btn-primary">{{ $producto ? 'Guardar cambios' : 'Crear producto' }}</button>
            <a href="{{ route('admin.productos.index') }}" class="btn btn-outline">Cancelar</a>
        </div>
    </form>
</div>
@endsection