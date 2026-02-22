<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', 'Admin') — Floristería Bribri</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root { --verde:#2A4A1E;--verde-claro:#4A7A35;--crema:#F8F5EE;--terracota:#C4714A;--rosa:#E8B4A0;--texto:#1C1C1C;--gris:#6B6B6B; }
        * { margin:0;padding:0;box-sizing:border-box; }
        body { font-family:'DM Sans',sans-serif;background:#F0EDE6;color:var(--texto);display:flex;min-height:100vh; }

        /* SIDEBAR */
        .sidebar { width:260px;flex-shrink:0;background:var(--verde);display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;overflow-y:auto; }
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

        /* MAIN */
        .main-content { margin-left:260px;flex:1;display:flex;flex-direction:column; }
        .top-bar { background:white;padding:0 2rem;height:64px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid rgba(42,74,30,0.06);position:sticky;top:0;z-index:10; }
        .page-title { font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-weight:600;color:var(--verde); }
        .top-actions { display:flex;gap:1rem;align-items:center; }
        .content { padding:2rem;flex:1; }

        /* Buttons */
        .btn { padding:9px 18px;border-radius:100px;font-family:'DM Sans',sans-serif;font-size:0.85rem;font-weight:500;cursor:pointer;transition:all 0.2s;text-decoration:none;border:none;display:inline-flex;align-items:center;gap:6px; }
        .btn-primary { background:var(--verde);color:white; }
        .btn-primary:hover { background:var(--verde-claro); }
        .btn-outline { background:none;color:var(--verde);border:1.5px solid var(--verde); }
        .btn-outline:hover { background:var(--verde);color:white; }
        .btn-danger { background:#dc3545;color:white; }
        .btn-danger:hover { background:#c82333; }
        .btn-sm { padding:6px 14px;font-size:0.8rem; }

        /* Cards / Tables */
        .stat-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1.25rem;margin-bottom:2rem; }
        .stat-card { background:white;border-radius:16px;padding:1.5rem;border:1px solid rgba(42,74,30,0.06); }
        .stat-card .num { font-family:'Cormorant Garamond',serif;font-size:2.2rem;font-weight:600;color:var(--verde); }
        .stat-card .label { font-size:0.8rem;color:var(--gris);text-transform:uppercase;letter-spacing:0.08em;margin-top:4px; }
        .stat-card .icon { font-size:1.75rem;margin-bottom:0.75rem; }

        .table-wrap { background:white;border-radius:16px;overflow:hidden;border:1px solid rgba(42,74,30,0.06); }
        table { width:100%;border-collapse:collapse; }
        th { background:#F8F5EE;font-size:0.75rem;letter-spacing:0.08em;text-transform:uppercase;color:var(--gris);padding:12px 16px;text-align:left;border-bottom:1px solid rgba(42,74,30,0.08); }
        td { padding:12px 16px;border-bottom:1px solid rgba(42,74,30,0.04);font-size:0.875rem;vertical-align:middle; }
        tr:last-child td { border-bottom:none; }
        tr:hover td { background:rgba(42,74,30,0.02); }

        .badge { display:inline-block;padding:3px 10px;border-radius:100px;font-size:0.75rem;font-weight:500; }
        .badge-green  { background:#d4edda;color:#155724; }
        .badge-yellow { background:#fff3cd;color:#856404; }
        .badge-red    { background:#f8d7da;color:#721c24; }
        .badge-blue   { background:#d1ecf1;color:#0c5460; }
        .badge-gray   { background:#e2e3e5;color:#383d41; }

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

        @media (max-width:768px) {
            .sidebar { display:none; }
            .main-content { margin-left:0; }
            .form-grid { grid-template-columns:1fr; }
            .stat-grid { grid-template-columns:1fr 1fr; }
        }
    </style>
    @stack('css')
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
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
        <a href="{{ route('home') }}" class="sb-link" target="_blank"><span>🔗</span> Ver tienda</a>
    </nav>
    <div class="sb-footer">
        <div class="sb-user">Sesión como<strong>{{ session('admin_nombre', '') }}</strong></div>
        <a href="{{ route('logout.admin') }}" class="btn-logout">Cerrar sesión</a>
    </div>
</aside>

<!-- MAIN -->
<div class="main-content">
    <div class="top-bar">
        <div class="page-title">@yield('page-title', 'Dashboard')</div>
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

@stack('js')
</body>
</html>