@php
    $cartCount     = getCartCount();
    $adminLogueado = session('admin_id');
    $userLogueado  = session('user_id');
    $navSticky     = $adminLogueado || $userLogueado;
@endphp

@if($adminLogueado)
<div style="background:var(--verde);color:rgba(255,255,255,0.85);font-family:'DM Sans',sans-serif;font-size:0.8rem;padding:0 5%;display:flex;align-items:center;justify-content:space-between;height:38px;position:sticky;top:0;z-index:200;">
    <span>🔐 Viendo la tienda como <strong>Administrador</strong></span>
    <div style="display:flex;gap:1rem;align-items:center;">
        <a href="{{ route('admin.dashboard') }}" style="color:var(--rosa);text-decoration:none;font-weight:500;border:1px solid rgba(232,180,160,0.4);padding:4px 12px;border-radius:100px;">📊 Dashboard</a>
        <a href="{{ route('logout.admin') }}" style="color:rgba(255,255,255,0.5);text-decoration:none;font-size:0.75rem;">Cerrar sesión</a>
    </div>
</div>
@elseif($userLogueado)
<div style="background:#F0EDE6;border-bottom:1px solid rgba(42,74,30,0.1);font-family:'DM Sans',sans-serif;font-size:0.8rem;padding:0 5%;display:flex;align-items:center;justify-content:space-between;height:36px;position:sticky;top:0;z-index:200;">
    <span style="color:var(--gris);">🌸 Hola, <strong style="color:var(--verde);">{{ session('user_nombre') }}</strong></span>
    <a href="{{ route('logout') }}" style="color:var(--terracota);text-decoration:none;font-size:0.75rem;">Cerrar sesión</a>
</div>
@endif

<nav id="navbar" style="width:100%;z-index:100;background:rgba(248,245,238,0.95);backdrop-filter:blur(12px);border-bottom:1px solid rgba(42,74,30,0.1);padding:0 5%;display:flex;align-items:center;justify-content:space-between;height:72px;transition:box-shadow 0.3s;{{ $navSticky ? 'position:sticky;top:'.($adminLogueado ? '38px' : '36px').';' : 'position:fixed;top:0;' }}">

    <a href="{{ route('home') }}" class="nav-logo">Floristería <span>Bribri</span></a>

    <ul class="nav-links" id="navLinks">
        <li><a href="{{ route('home') }}">Inicio</a></li>
        <li><a href="{{ route('catalogo') }}">Catálogo</a></li>
        <li><a href="{{ route('home') }}#entrega">Envíos</a></li>
    </ul>

    <div style="display:flex;align-items:center;gap:0.75rem;">
        @if($adminLogueado)
            <a href="{{ route('admin.dashboard') }}" class="nav-btn-admin">⚙️ Admin</a>
        @elseif($userLogueado)
            <a href="{{ route('logout') }}" class="nav-btn-ghost">Cerrar sesión</a>
        @else
            <a href="{{ route('registro') }}" class="nav-btn-outline">🌸 Suscribirme</a>
            <a href="{{ route('login') }}" class="nav-btn-ghost">👤 Iniciar sesión</a>
        @endif

        <a href="{{ route('carrito') }}" class="nav-cart">
            🛒@if($cartCount > 0)<span class="cart-badge">{{ $cartCount }}</span>@endif
        </a>

        <button class="hamburger" onclick="toggleMenu()">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

@if(!$navSticky)<div style="height:72px;"></div>@endif