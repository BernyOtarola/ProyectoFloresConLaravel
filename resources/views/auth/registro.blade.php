@extends('layouts.main')
@section('title', 'Crear cuenta — Floristería Bribri')

@push('css')
<style>
.auth-wrap { min-height:calc(100vh - 72px);display:flex;align-items:center;justify-content:center;padding:3rem 5%; }
.auth-card { background:white;border-radius:28px;padding:3rem;width:100%;max-width:500px;border:1px solid rgba(42,74,30,0.06);box-shadow:0 20px 60px rgba(42,74,30,0.08); }
.auth-icon { font-size:3rem;text-align:center;margin-bottom:1.25rem; }
.auth-card h1 { font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:300;color:var(--verde);text-align:center;margin-bottom:0.4rem; }
.auth-card h1 em { font-style:italic; }
.auth-card .sub { color:var(--gris);font-size:0.9rem;text-align:center;margin-bottom:2rem; }
.perks { display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;margin-bottom:1.75rem; }
.perk { background:var(--crema);border-radius:10px;padding:0.875rem;text-align:center; }
.perk-icon { font-size:1.3rem;margin-bottom:4px; }
.perk-text { font-size:0.78rem;color:var(--gris);line-height:1.4; }
.form-group { margin-bottom:1.2rem; }
.form-group label { display:block;font-size:0.85rem;font-weight:500;margin-bottom:6px; }
.form-group input { width:100%;padding:13px 16px;border:1.5px solid rgba(42,74,30,0.15);border-radius:12px;font-family:'DM Sans',sans-serif;font-size:0.9rem;outline:none;background:var(--crema);transition:border 0.2s; }
.form-group input:focus { border-color:var(--verde);background:white; }
.pw-wrap { position:relative; }
.pw-wrap input { padding-right:44px; }
.pw-toggle { position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;font-size:1rem;color:var(--gris); }
.hint { font-size:0.78rem;color:var(--gris);margin-top:4px; }
.btn-submit { width:100%;background:var(--verde);color:white;border:none;cursor:pointer;padding:14px;border-radius:100px;font-family:'DM Sans',sans-serif;font-size:1rem;font-weight:500;transition:all 0.2s;margin-top:0.5rem; }
.btn-submit:hover { background:var(--verde-claro);transform:translateY(-2px); }
.alert-error   { background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;padding:12px 16px;border-radius:10px;font-size:0.875rem;margin-bottom:1.5rem;text-align:center; }
.alert-success { background:#d4edda;color:#155724;border:1px solid #c3e6cb;padding:12px 16px;border-radius:10px;font-size:0.875rem;margin-bottom:1.5rem;text-align:center; }
.divider { border:none;border-top:1px solid rgba(42,74,30,0.08);margin:1.5rem 0; }
.auth-links { display:flex;flex-direction:column;gap:0.6rem;align-items:center; }
.auth-links a { color:var(--gris);font-size:0.875rem;text-decoration:none; }
.auth-links a:hover { color:var(--verde); }
.auth-links a.main-link { color:var(--verde);font-weight:500; }
</style>
@endpush

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-icon">🌺</div>
        <h1>Crear <em>cuenta</em></h1>
        <p class="sub">Suscríbete y recibe novedades, ofertas y tips florales.</p>

        @if($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if(session('success'))
        <div style="text-align:center;display:flex;flex-direction:column;gap:1rem;">
            <a href="{{ route('home') }}" style="background:var(--verde);color:white;padding:13px 32px;border-radius:100px;text-decoration:none;font-size:0.95rem;font-weight:500;">Ir a la tienda →</a>
        </div>
        @else

        <div class="perks">
            <div class="perk"><div class="perk-icon">🌸</div><div class="perk-text">Novedades de temporada</div></div>
            <div class="perk"><div class="perk-icon">🎁</div><div class="perk-text">Ofertas exclusivas</div></div>
            <div class="perk"><div class="perk-icon">💚</div><div class="perk-text">Tips florales</div></div>
            <div class="perk"><div class="perk-icon">✂️</div><div class="perk-text">Sin spam</div></div>
        </div>

        <form method="POST" action="{{ route('registro') }}">
            @csrf
            <div class="form-group">
                <label>Tu nombre *</label>
                <input type="text" name="nombre" placeholder="María González" autofocus required>
            </div>
            <div class="form-group">
                <label>Correo electrónico *</label>
                <input type="email" name="email" placeholder="tucorreo@ejemplo.com" required>
            </div>
            <div class="form-group">
                <label>Contraseña *</label>
                <div class="pw-wrap">
                    <input type="password" name="password" id="pw1" placeholder="Mínimo 6 caracteres" required>
                    <button type="button" class="pw-toggle" onclick="togglePw('pw1',this)">👁️</button>
                </div>
                <div class="hint">Mínimo 6 caracteres</div>
            </div>
            <div class="form-group">
                <label>Repetir contraseña *</label>
                <div class="pw-wrap">
                    <input type="password" name="password_confirmation" id="pw2" placeholder="Repite tu contraseña" required>
                    <button type="button" class="pw-toggle" onclick="togglePw('pw2',this)">👁️</button>
                </div>
            </div>
            <button type="submit" class="btn-submit">🌺 Crear mi cuenta</button>
        </form>

        <hr class="divider">
        <div class="auth-links">
            <a href="{{ route('login') }}" class="main-link">👤 ¿Ya tenés cuenta? Iniciá sesión</a>
            <a href="{{ route('home') }}">← Volver a la tienda</a>
        </div>
        @endif
    </div>
</div>
@endsection

@push('js')
<script>
function togglePw(id, btn) {
    const inp = document.getElementById(id);
    inp.type = inp.type === 'password' ? 'text' : 'password';
    btn.textContent = inp.type === 'password' ? '👁️' : '🙈';
}
</script>
@endpush