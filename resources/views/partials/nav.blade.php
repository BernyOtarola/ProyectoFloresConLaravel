@php
    $cartCount     = getCartCount();
    $adminLogueado = Auth::guard('admin')->check();
    $userLogueado  = Auth::guard('web')->check();
    $adminNombre   = $adminLogueado ? Auth::guard('admin')->user()->nombre : null;
    $userNombre    = $userLogueado  ? Auth::guard('web')->user()->nombre   : null;
    $navSticky     = $adminLogueado || $userLogueado;

    $facebook  = config('floristeria.redes.facebook');
    $instagram = config('floristeria.redes.instagram');
    $tiktok    = config('floristeria.redes.tiktok');
    $hayRedes  = $facebook || $instagram || $tiktok;
@endphp

{{-- ═══════════════════════════════════════════════════════
     BARRA SUPERIOR (solo si está logueado)
     ═══════════════════════════════════════════════════════ --}}

@if($adminLogueado)
{{-- Barra admin --}}
<div style="
    background: var(--verde);
    color: rgba(255,255,255,0.9);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.8rem;
    padding: 0 5%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 38px;
    position: sticky;
    top: 0;
    z-index: 200;
">
    <span>🔐 Modo administrador — <strong>{{ $adminNombre }}</strong></span>
    <div style="display:flex;gap:1rem;align-items:center;">
        <a href="{{ route('admin.dashboard') }}"
           style="color:var(--rosa);text-decoration:none;font-weight:500;border:1px solid rgba(232,180,160,0.4);padding:4px 12px;border-radius:100px;transition:all 0.2s;">
            📊 Dashboard
        </a>
        <form method="POST" action="{{ route('logout.admin') }}" style="display:inline;">
            @csrf
            <button type="submit"
                style="background:none;border:none;cursor:pointer;color:rgba(255,255,255,0.5);font-family:'DM Sans',sans-serif;font-size:0.75rem;padding:0;">
                Cerrar sesión
            </button>
        </form>
    </div>
</div>

@elseif($userLogueado)
{{-- Barra cliente --}}
<div style="
    background: #F0EDE6;
    border-bottom: 1px solid rgba(42,74,30,0.1);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.8rem;
    padding: 0 5%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 36px;
    position: sticky;
    top: 0;
    z-index: 200;
">
    <span style="color:var(--gris);">
        🌸 Hola, <strong style="color:var(--verde);">{{ $userNombre }}</strong>
    </span>
    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit"
            style="background:none;border:none;cursor:pointer;color:var(--terracota);font-family:'DM Sans',sans-serif;font-size:0.75rem;padding:0;">
            Cerrar sesión
        </button>
    </form>
</div>

@else
{{-- Barra de redes sociales para invitados --}}
@if($hayRedes)
<div style="
    background: #0F1E09;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.78rem;
    padding: 0 5%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 36px;
    position: sticky;
    top: 0;
    z-index: 200;
">
    <span style="color:rgba(255,255,255,0.4);">🌺 {{ config('floristeria.slogan') }}</span>

    <div style="display:flex;align-items:center;gap:0.75rem;">
        @if($facebook)
        <a href="{{ $facebook }}" target="_blank" rel="noopener noreferrer"
           style="color:rgba(255,255,255,0.45);text-decoration:none;display:flex;align-items:center;gap:5px;font-size:0.75rem;transition:color 0.2s;"
           onmouseover="this.style.color='#1877F2'" onmouseout="this.style.color='rgba(255,255,255,0.45)'"
           title="Facebook">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
            <span style="display:none;" class="rs-label">Facebook</span>
        </a>
        @endif

        @if($instagram)
        <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer"
           style="color:rgba(255,255,255,0.45);text-decoration:none;display:flex;align-items:center;gap:5px;font-size:0.75rem;transition:color 0.2s;"
           onmouseover="this.style.color='#E1306C'" onmouseout="this.style.color='rgba(255,255,255,0.45)'"
           title="Instagram">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
            </svg>
            <span style="display:none;" class="rs-label">Instagram</span>
        </a>
        @endif

        @if($tiktok)
        <a href="{{ $tiktok }}" target="_blank" rel="noopener noreferrer"
           style="color:rgba(255,255,255,0.45);text-decoration:none;display:flex;align-items:center;gap:5px;font-size:0.75rem;transition:color 0.2s;"
           onmouseover="this.style.color='#69C9D0'" onmouseout="this.style.color='rgba(255,255,255,0.45)'"
           title="TikTok">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
            </svg>
            <span style="display:none;" class="rs-label">TikTok</span>
        </a>
        @endif
    </div>
</div>
@endif
@endif

{{-- ═══════════════════════════════════════════════════════
     NAVBAR PRINCIPAL
     ═══════════════════════════════════════════════════════ --}}
<nav id="navbar" style="
    width: 100%;
    z-index: 100;
    background: rgba(248,245,238,0.95);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(42,74,30,0.1);
    padding: 0 5%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 72px;
    transition: box-shadow 0.3s;
    @if($navSticky)
        position: sticky;
        top: {{ $adminLogueado ? '38px' : '36px' }};
    @elseif($hayRedes && !$adminLogueado && !$userLogueado)
        position: sticky;
        top: 36px;
    @else
        position: fixed;
        top: 0;
    @endif
">
    <a href="{{ route('home') }}" class="nav-logo">Floristería <span>Bribri</span></a>

    {{-- Menú de navegación principal --}}
    <ul class="nav-links" id="navLinks">
        <li><a href="{{ route('home') }}">Inicio</a></li>
        <li><a href="{{ route('catalogo') }}">Catálogo</a></li>
        <li><a href="{{ route('home') }}#entrega">Envíos</a></li>

        {{-- Redes sociales en menú móvil (solo visibles cuando el menú está abierto) --}}
        @if($hayRedes)
        <li style="padding-top:0.75rem;border-top:1px solid rgba(42,74,30,0.08);margin-top:0.5rem;display:none;" class="nav-redes-mobile">
            <div style="display:flex;gap:1rem;align-items:center;flex-wrap:wrap;">
                @if($facebook)
                <a href="{{ $facebook }}" target="_blank" rel="noopener noreferrer"
                   style="color:var(--gris);font-size:0.85rem;display:flex;align-items:center;gap:6px;text-decoration:none;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color:#1877F2">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Facebook
                </a>
                @endif
                @if($instagram)
                <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer"
                   style="color:var(--gris);font-size:0.85rem;display:flex;align-items:center;gap:6px;text-decoration:none;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color:#E1306C">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                    </svg>
                    Instagram
                </a>
                @endif
                @if($tiktok)
                <a href="{{ $tiktok }}" target="_blank" rel="noopener noreferrer"
                   style="color:var(--gris);font-size:0.85rem;display:flex;align-items:center;gap:6px;text-decoration:none;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color:#010101">
                        <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                    </svg>
                    TikTok
                </a>
                @endif
            </div>
        </li>
        @endif
    </ul>

    {{-- Botones de acción --}}
    <div style="display:flex;align-items:center;gap:0.75rem;">

        @if($adminLogueado)
            <a href="{{ route('admin.dashboard') }}" class="nav-btn-admin">⚙️ Admin</a>
            <form method="POST" action="{{ route('logout.admin') }}" style="display:inline;">
                @csrf
                <button type="submit" class="nav-btn-ghost">Cerrar sesión</button>
            </form>

        @elseif($userLogueado)
            <span style="font-size:0.85rem;color:var(--verde);font-weight:500;white-space:nowrap;max-width:160px;overflow:hidden;text-overflow:ellipsis;">
                👤 {{ $userNombre }}
            </span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="nav-btn-ghost">Cerrar sesión</button>
            </form>

        @else
            <a href="{{ route('registro') }}" class="nav-btn-outline">🌸 Suscribirme</a>
            <a href="{{ route('login') }}" class="nav-btn-ghost">👤 Iniciar sesión</a>
        @endif

        {{-- Carrito (siempre visible) --}}
        <a href="{{ route('carrito') }}" class="nav-cart">
            🛒
            @if($cartCount > 0)
                <span class="cart-badge">{{ $cartCount }}</span>
            @endif
        </a>

        <button class="hamburger" onclick="toggleMenu()">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

{{-- Spacer para cuando el nav es fixed --}}
@if(!$navSticky && !($hayRedes && !$adminLogueado && !$userLogueado))
    <div style="height:72px;"></div>
@elseif(!$navSticky && $hayRedes)
    <div style="height:72px;"></div>
@endif

{{-- Mostrar redes en menú móvil cuando se abre --}}
<style>
@media(max-width:900px) {
    .nav-redes-mobile { display: block !important; }
}
</style>