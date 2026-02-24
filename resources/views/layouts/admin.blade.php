<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', 'Admin') — Floristería Bribri</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌺</text></svg>">
    <style>
        :root { --verde:#2A4A1E;--verde-claro:#4A7A35;--crema:#F8F5EE;--terracota:#C4714A;--rosa:#E8B4A0;--texto:#1C1C1C;--gris:#6B6B6B;--sidebar-w:260px; }
        * { margin:0;padding:0;box-sizing:border-box; }
        body { font-family:'DM Sans',sans-serif;background:#F0EDE6;color:var(--texto);display:flex;min-height:100vh; }

        /* ══════════════════════════════════════════
           SIDEBAR
           ══════════════════════════════════════════ */
        .sidebar {
            width:var(--sidebar-w);flex-shrink:0;background:var(--verde);
            display:flex;flex-direction:column;
            position:fixed;top:0;left:0;bottom:0;overflow-y:auto;
            z-index:100;
            transition:transform 0.3s ease;
        }
        .sb-logo { padding:1.75rem 1.5rem;border-bottom:1px solid rgba(255,255,255,0.1); }
        .sb-logo .brand { font-family:'Cormorant Garamond',serif;font-size:1.4rem;font-weight:600;color:white; }
        .sb-logo .brand span { color:var(--rosa);font-style:italic; }
        .sb-logo .tag { font-size:0.7rem;letter-spacing:0.15em;text-transform:uppercase;color:rgba(255,255,255,0.4);margin-top:2px; }
        .sb-menu { padding:1.5rem 0;flex:1; }
        .sb-section { font-size:0.65rem;letter-spacing:0.15em;text-transform:uppercase;color:rgba(255,255,255,0.3);padding:0 1.5rem;margin:1rem 0 0.5rem; }
        .sb-link { display:flex;align-items:center;gap:10px;padding:10px 1.5rem;color:rgba(255,255,255,0.65);text-decoration:none;font-size:0.875rem;border-left:3px solid transparent;transition:all 0.2s; }
        .sb-link:hover { color:white;background:rgba(255,255,255,0.08);border-left-color:rgba(255,255,255,0.3); }
        .sb-link.active { color:white;background:rgba(255,255,255,0.12);border-left-color:var(--rosa); }
        .sb-footer { padding:1.5rem;border-top:1px solid rgba(255,255,255,0.1); }
        .sb-user { font-size:0.8rem;color:rgba(255,255,255,0.5);margin-bottom:0.75rem; }
        .sb-user strong { color:rgba(255,255,255,0.85);display:block; }
        .btn-logout { display:block;width:100%;background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.7);border:none;cursor:pointer;padding:9px;border-radius:8px;font-family:'DM Sans',sans-serif;font-size:0.85rem;text-align:center;text-decoration:none;transition:all 0.2s; }
        .btn-logout:hover { background:rgba(255,255,255,0.2);color:white; }

        /* Botón cerrar dentro del sidebar (solo móvil) */
        .sb-close {
            display:none;position:absolute;top:1.25rem;right:1.25rem;
            background:none;border:none;color:rgba(255,255,255,0.5);
            font-size:1.5rem;cursor:pointer;transition:color 0.2s;
            line-height:1;
        }
        .sb-close:hover { color:white; }

        /* Overlay detrás del sidebar (solo móvil) */
        .sidebar-overlay {
            display:none;position:fixed;inset:0;
            background:rgba(0,0,0,0.45);z-index:99;
            opacity:0;transition:opacity 0.3s ease;
        }
        .sidebar-overlay.show { display:block;opacity:1; }

        /* ══════════════════════════════════════════
           MAIN
           ══════════════════════════════════════════ */
        .main-content { margin-left:var(--sidebar-w);flex:1;display:flex;flex-direction:column;min-width:0; }
        .top-bar {
            background:white;padding:0 2rem;height:64px;
            display:flex;align-items:center;justify-content:space-between;
            border-bottom:1px solid rgba(42,74,30,0.06);
            position:sticky;top:0;z-index:10;
            gap:1rem;
        }
        .top-bar-left { display:flex;align-items:center;gap:1rem;min-width:0; }
        .page-title { font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-weight:600;color:var(--verde);white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }
        .top-actions { display:flex;gap:0.75rem;align-items:center;flex-shrink:0; }
        .content { padding:2rem;flex:1;min-width:0; }

        /* Hamburger (solo móvil) */
        .admin-hamburger {
            display:none;flex-direction:column;gap:5px;cursor:pointer;
            border:none;background:none;padding:4px;flex-shrink:0;
        }
        .admin-hamburger span { width:22px;height:2px;background:var(--verde);display:block;border-radius:2px;transition:all 0.3s; }

        /* ══════════════════════════════════════════
           BOTONES
           ══════════════════════════════════════════ */
        .btn { padding:9px 18px;border-radius:100px;font-family:'DM Sans',sans-serif;font-size:0.85rem;font-weight:500;cursor:pointer;transition:all 0.2s;text-decoration:none;border:none;display:inline-flex;align-items:center;gap:6px;white-space:nowrap; }
        .btn-primary { background:var(--verde);color:white; }
        .btn-primary:hover { background:var(--verde-claro); }
        .btn-outline { background:none;color:var(--verde);border:1.5px solid var(--verde); }
        .btn-outline:hover { background:var(--verde);color:white; }
        .btn-danger { background:#dc3545;color:white; }
        .btn-danger:hover { background:#c82333; }
        .btn-sm { padding:6px 14px;font-size:0.8rem; }

        /* ══════════════════════════════════════════
           CARDS / TABLAS
           ══════════════════════════════════════════ */
        .stat-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1.25rem;margin-bottom:2rem; }
        .stat-card { background:white;border-radius:16px;padding:1.5rem;border:1px solid rgba(42,74,30,0.06); }
        .stat-card .num { font-family:'Cormorant Garamond',serif;font-size:2.2rem;font-weight:600;color:var(--verde); }
        .stat-card .label { font-size:0.8rem;color:var(--gris);text-transform:uppercase;letter-spacing:0.08em;margin-top:4px; }
        .stat-card .icon { font-size:1.75rem;margin-bottom:0.75rem; }

        .table-wrap { background:white;border-radius:16px;overflow-x:auto;border:1px solid rgba(42,74,30,0.06);-webkit-overflow-scrolling:touch; }
        table { width:100%;border-collapse:collapse;min-width:600px; }
        th { background:#F8F5EE;font-size:0.75rem;letter-spacing:0.08em;text-transform:uppercase;color:var(--gris);padding:12px 16px;text-align:left;border-bottom:1px solid rgba(42,74,30,0.08);white-space:nowrap; }
        td { padding:12px 16px;border-bottom:1px solid rgba(42,74,30,0.04);font-size:0.875rem;vertical-align:middle; }
        tr:last-child td { border-bottom:none; }
        tr:hover td { background:rgba(42,74,30,0.02); }

        .badge { display:inline-block;padding:3px 10px;border-radius:100px;font-size:0.75rem;font-weight:500;white-space:nowrap; }
        .badge-green  { background:#d4edda;color:#155724; }
        .badge-yellow { background:#fff3cd;color:#856404; }
        .badge-red    { background:#f8d7da;color:#721c24; }
        .badge-blue   { background:#d1ecf1;color:#0c5460; }
        .badge-gray   { background:#e2e3e5;color:#383d41; }

        /* ══════════════════════════════════════════
           FORMULARIOS
           ══════════════════════════════════════════ */
        .form-card { background:white;border-radius:16px;padding:2rem;border:1px solid rgba(42,74,30,0.06);max-width:720px; }
        .form-grid { display:grid;grid-template-columns:1fr 1fr;gap:1.25rem; }
        .form-group { margin-bottom:1.25rem; }
        .form-group.full { grid-column:1/-1; }
        .form-group label { display:block;font-size:0.85rem;font-weight:500;color:var(--texto);margin-bottom:6px; }
        .form-group input,.form-group textarea,.form-group select { width:100%;padding:11px 14px;border:1.5px solid rgba(42,74,30,0.15);border-radius:10px;font-family:'DM Sans',sans-serif;font-size:0.9rem;outline:none;background:var(--crema);transition:border 0.2s; }
        .form-group input:focus,.form-group textarea:focus,.form-group select:focus { border-color:var(--verde);background:white; }
        .form-group textarea { height:100px;resize:vertical; }
        .form-check { display:flex;align-items:center;gap:8px;cursor:pointer;font-size:0.9rem; }
        .form-check input[type=checkbox] { width:auto; }

        .section-title { font-family:'Cormorant Garamond',serif;font-size:1.4rem;font-weight:400;color:var(--verde);margin:2rem 0 1rem; }

        .flash { padding:12px 16px;border-radius:10px;font-size:0.875rem;margin-bottom:1.5rem; }
        .flash-success { background:#d4edda;color:#155724;border:1px solid #c3e6cb; }
        .flash-error   { background:#f8d7da;color:#721c24;border:1px solid #f5c6cb; }

        /* ══════════════════════════════════════════
           RESPONSIVE
           ══════════════════════════════════════════ */
        @media (max-width:900px) {
            .sidebar {
                transform:translateX(-100%);
                width:280px;
                box-shadow:4px 0 30px rgba(0,0,0,0.2);
            }
            .sidebar.open { transform:translateX(0); }
            .sb-close { display:block; }
            .main-content { margin-left:0; }
            .admin-hamburger { display:flex; }
            .top-bar { padding:0 1.25rem; }
            .content { padding:1.25rem; }
        }

        @media (max-width:640px) {
            .form-grid { grid-template-columns:1fr; }
            .stat-grid { grid-template-columns:1fr 1fr; }
            .top-actions .btn { font-size:0;padding:9px 12px; }
            .top-actions .btn::before { font-size:0.9rem; }
            .page-title { font-size:1.2rem; }
            .content { padding:1rem; }
        }

        @media (max-width:420px) {
            .stat-grid { grid-template-columns:1fr; }
            .stat-card { padding:1.25rem; }
            .stat-card .num { font-size:1.8rem; }
        }
    </style>
    @stack('css')
</head>
<body>

<!-- OVERLAY (móvil) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- SIDEBAR -->
<aside class="sidebar" id="adminSidebar">
    <button class="sb-close" id="sidebarClose">✕</button>
    <div class="sb-logo">
        <div class="brand">Floristería <span>Bribri</span></div>
        <div class="tag">Panel Admin</div>
    </div>
    <nav class="sb-menu">
        <div class="sb-section">Principal</div>
        <a href="{{ route('admin.dashboard') }}"        class="sb-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><span>📊</span> Dashboard</a>
        <a href="{{ route('admin.pedidos.index') }}"     class="sb-link {{ request()->routeIs('admin.pedidos.*') ? 'active' : '' }}"><span>📦</span> Pedidos</a>
        <div class="sb-section">Catálogo</div>
        <a href="{{ route('admin.productos.index') }}"   class="sb-link {{ request()->routeIs('admin.productos.index') || request()->routeIs('admin.productos.editar') ? 'active' : '' }}"><span>🌸</span> Productos</a>
        <a href="{{ route('admin.productos.crear') }}"   class="sb-link {{ request()->routeIs('admin.productos.crear') ? 'active' : '' }}"><span>➕</span> Agregar Producto</a>
        <a href="{{ route('admin.categorias.index') }}"  class="sb-link {{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}"><span>🏷️</span> Categorías</a>
        <div class="sb-section">Clientes</div>
        <a href="{{ route('admin.suscriptores.index') }}" class="sb-link {{ request()->routeIs('admin.suscriptores.*') ? 'active' : '' }}"><span>📧</span> Suscriptores</a>
        <a href="{{ route('admin.newsletter.index') }}"  class="sb-link {{ request()->routeIs('admin.newsletter.*') ? 'active' : '' }}"><span>📨</span> Newsletter</a>
        <div class="sb-section">Tienda</div>
        <a href="{{ route('home') }}" class="sb-link"><span>🔗</span> Ver tienda</a>
    </nav>

    {{-- ↓ Auth::guard('admin') en lugar de session('admin_nombre') --}}
    <div class="sb-footer">
        <div class="sb-user">
            Sesión como
            <strong>{{ Auth::guard('admin')->user()->nombre }}</strong>
        </div>
        <a href="{{ route('logout.admin') }}" class="btn-logout">Cerrar sesión</a>
    </div>
</aside>

<!-- MAIN -->
<div class="main-content">
    <div class="top-bar">
        <div class="top-bar-left">
            <button class="admin-hamburger" id="adminHamburger">
                <span></span><span></span><span></span>
            </button>
            <div class="page-title">@yield('page-title', 'Dashboard')</div>
        </div>
        <div class="top-actions">@yield('top-actions')</div>
    </div>
    <div class="content">
        @if(session('success'))
            <div class="flash flash-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="flash flash-error">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="flash flash-error">{{ $errors->first() }}</div>
        @endif

        @yield('content')
    </div>
</div>

<script>
(function() {
    const sidebar   = document.getElementById('adminSidebar');
    const overlay   = document.getElementById('sidebarOverlay');
    const hamburger = document.getElementById('adminHamburger');
    const closeBtn  = document.getElementById('sidebarClose');

    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
        document.body.style.overflow = '';
    }

    hamburger.addEventListener('click', openSidebar);
    closeBtn.addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);

    sidebar.querySelectorAll('.sb-link').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 900) closeSidebar();
        });
    });
})();
</script>
@stack('js')
</body>
</html>