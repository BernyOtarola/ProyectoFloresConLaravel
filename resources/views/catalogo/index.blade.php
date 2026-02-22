@extends('layouts.main')
@section('title', 'Catálogo — Floristería Bribri')

@push('css')
<style>
.page-header { background:var(--verde);padding:3.5rem 5%;color:white; }
.page-header h1 { font-family:'Cormorant Garamond',serif;font-size:2.8rem;font-weight:300; }
.page-header h1 em { font-style:italic;color:var(--rosa); }
.breadcrumb { font-size:0.85rem;opacity:0.6;margin-bottom:0.75rem; }
.breadcrumb a { color:white;text-decoration:none; }

.cat-layout { display:grid;grid-template-columns:250px 1fr;gap:2.5rem;padding:2.5rem 5%;max-width:1400px;margin:0 auto; }

.sb-section-title { font-family:'Cormorant Garamond',serif;font-size:1.05rem;font-weight:600;color:var(--verde);margin-bottom:1rem;padding-bottom:0.75rem;border-bottom:1px solid rgba(42,74,30,0.08); }
.sb-card { background:white;border-radius:14px;padding:1.25rem;margin-bottom:1.25rem;border:1px solid rgba(42,74,30,0.06); }
.search-wrap { position:relative; }
.search-wrap input { width:100%;padding:10px 36px 10px 14px;border:1.5px solid rgba(42,74,30,0.15);border-radius:10px;font-family:'DM Sans',sans-serif;font-size:0.875rem;outline:none;background:var(--crema); }
.search-wrap input:focus { border-color:var(--verde); }
.search-wrap button { position:absolute;right:10px;top:50%;transform:translateY(-50%);border:none;background:none;cursor:pointer;color:var(--gris); }
.cat-link { display:block;padding:7px 10px;border-radius:8px;font-size:0.875rem;color:var(--texto);text-decoration:none;transition:all 0.2s;margin-bottom:2px; }
.cat-link:hover,.cat-link.active { background:var(--verde);color:white; }

.toolbar { display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem; }
.result-count { font-size:0.9rem;color:var(--gris); }
.clear-link { font-size:0.85rem;color:var(--terracota);text-decoration:none; }

.prod-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:1.5rem; }
.prod-card { background:white;border-radius:20px;overflow:hidden;border:1px solid rgba(42,74,30,0.06);transition:all 0.3s; }
.prod-card:hover { transform:translateY(-6px);box-shadow:0 20px 40px rgba(42,74,30,0.1); }
.prod-img { height:200px;background:linear-gradient(135deg,#e8f5e0,#d4edca);display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden; }
.prod-img img { width:100%;height:100%;object-fit:cover; }
.prod-ph { font-size:4.5rem; }
.prod-badge { position:absolute;top:10px;left:10px;background:var(--terracota);color:white;font-size:0.68rem;padding:3px 9px;border-radius:100px;font-weight:500; }
.prod-body { padding:1.25rem; }
.prod-cat { font-size:0.72rem;color:var(--terracota);text-transform:uppercase;letter-spacing:0.1em; }
.prod-name { font-family:'Cormorant Garamond',serif;font-size:1.2rem;font-weight:600;color:var(--verde);margin:4px 0; }
.prod-desc { font-size:0.83rem;color:var(--gris);line-height:1.6;margin-bottom:1rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden; }
.prod-foot { display:flex;align-items:center;justify-content:space-between; }
.prod-price { font-family:'Cormorant Garamond',serif;font-size:1.3rem;font-weight:600;color:var(--verde); }
.btn-add { background:var(--verde);color:white;border:none;cursor:pointer;padding:9px 16px;border-radius:100px;font-family:'DM Sans',sans-serif;font-size:0.82rem;font-weight:500;transition:all 0.2s; }
.btn-add:hover { background:var(--verde-claro);transform:scale(1.05); }
.btn-add.ok { background:var(--terracota); }

.empty { text-align:center;padding:4rem;color:var(--gris); }
.empty .icon { font-size:4rem;margin-bottom:1rem; }

@media(max-width:768px){ .cat-layout{grid-template-columns:1fr} .cat-sidebar{display:none} }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="breadcrumb"><a href="{{ route('home') }}">Inicio</a> → {{ $catActual ?: 'Catálogo' }}</div>
    <h1>{!! $catActual ? e($catActual) : 'Nuestro <em>Catálogo</em>' !!}</h1>
</div>

<div class="cat-layout">
    {{-- SIDEBAR --}}
    <aside class="cat-sidebar">
        <div class="sb-card">
            <div class="sb-section-title">🔍 Buscar</div>
            <form method="GET" action="{{ route('catalogo') }}" class="search-wrap">
                @if($catId)
                    <input type="hidden" name="categoria" value="{{ $catId }}">
                @endif
                <input type="text" name="q" placeholder="Buscar flores…" value="{{ $busqueda }}">
                <button type="submit">🔍</button>
            </form>
        </div>
        <div class="sb-card">
            <div class="sb-section-title">🌸 Categorías</div>
            <a href="{{ route('catalogo') }}" class="cat-link {{ !$catId ? 'active' : '' }}">Todas las flores</a>
            @foreach($categorias as $c)
            <a href="{{ route('catalogo', ['categoria' => $c->id]) }}" class="cat-link {{ $catId == $c->id ? 'active' : '' }}">
                {{ $c->nombre }}
            </a>
            @endforeach
        </div>
    </aside>

    {{-- PRODUCTOS --}}
    <div>
        <div class="toolbar">
            <span class="result-count">{{ count($productos) }} productos{!! $busqueda ? ' para "'.e($busqueda).'"' : '' !!}</span>
            @if($busqueda || $catId)
            <a href="{{ route('catalogo') }}" class="clear-link">✕ Limpiar filtros</a>
            @endif
        </div>

        @if(count($productos) === 0)
        <div class="empty">
            <div class="icon">🌱</div>
            <h3>No encontramos resultados</h3>
            <p>Intenta otra búsqueda o explora todas nuestras flores.</p>
            <a href="{{ route('catalogo') }}" style="display:inline-block;margin-top:1.5rem;background:var(--verde);color:white;padding:12px 24px;border-radius:100px;text-decoration:none;">Ver todo</a>
        </div>
        @else
        <div class="prod-grid">
            @foreach($productos as $p)
            <div class="prod-card">
                <div class="prod-img">
                    @if($p->imagen)
                        <img src="{{ asset('storage/products/' . $p->imagen) }}" alt="{{ $p->nombre }}">
                    @else
                        <div class="prod-ph">💐</div>
                    @endif
                    @if($p->destacado)
                        <div class="prod-badge">Destacado</div>
                    @endif
                </div>
                <div class="prod-body">
                    <div class="prod-cat">{{ $p->categoria->nombre ?? 'Flores' }}</div>
                    <div class="prod-name">{{ $p->nombre }}</div>
                    <div class="prod-desc">{{ $p->descripcion }}</div>
                    <div class="prod-foot">
                        <div class="prod-price">{{ formatPrice($p->precio) }}</div>
                        <button class="btn-add" onclick="addCart({{ $p->id }},'{{ e($p->nombre) }}',{{ $p->precio }},this)">+ Agregar</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection

@push('js')
<script>
function addCart(id, nombre, precio, btn) {
    fetch('{{ route("api.carrito") }}', {
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
        body:JSON.stringify({accion:'agregar', id, nombre, precio})
    }).then(r=>r.json()).then(d=>{
        if(d.success){
            btn.textContent='✓'; btn.classList.add('ok');
            setTimeout(()=>{ btn.textContent='+ Agregar'; btn.classList.remove('ok'); },1500);
            showToast('✓ '+nombre+' agregado');
            const b=document.querySelector('.cart-badge');
            if(b) b.textContent=d.count;
            else { const c=document.querySelector('.nav-cart'); const s=document.createElement('span'); s.className='cart-badge'; s.textContent=d.count; c.appendChild(s); }
        }
    });
}
</script>
@endpush