@extends('layouts.main')
@section('title', 'Iniciar sesión')

@push('css')
<style>
.auth-wrap { min-height:calc(100vh - 72px);display:flex;align-items:center;justify-content:center;padding:3rem 5%; }
.auth-card { background:white;border-radius:28px;padding:3rem;width:100%;max-width:440px;border:1px solid rgba(42,74,30,0.06);box-shadow:0 20px 60px rgba(42,74,30,0.08); }
.auth-icon { font-size:3rem;text-align:center;margin-bottom:1.25rem; }
.auth-card h1 { font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:300;color:var(--verde);text-align:center;margin-bottom:0.4rem; }
.auth-card .sub { color:var(--gris);font-size:0.9rem;text-align:center;margin-bottom:2rem; }
.form-group { margin-bottom:1.2rem; }
.form-group label { display:block;font-size:0.85rem;font-weight:500;margin-bottom:6px; }
.form-group input { width:100%;padding:13px 16px;border:1.5px solid rgba(42,74,30,0.15);border-radius:12px;font-family:'DM Sans',sans-serif;font-size:0.9rem;outline:none;background:var(--crema);transition:border 0.2s; }
.form-group input:focus { border-color:var(--verde);background:white; }
.pw-wrap { position:relative; }
.pw-wrap input { padding-right:44px; }
.pw-toggle { position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;font-size:1rem;color:var(--gris); }
.btn-submit { width:100%;background:var(--verde);color:white;border:none;cursor:pointer;padding:14px;border-radius:100px;font-family:'DM Sans',sans-serif;font-size:1rem;font-weight:500;transition:all 0.2s;margin-top:0.5rem; }
.btn-submit:hover { background:var(--verde-claro);transform:translateY(-2px);box-shadow:0 8px 24px rgba(42,74,30,0.2); }
.alert-error { background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;padding:12px 16px;border-radius:10px;font-size:0.875rem;margin-bottom:1.5rem;text-align:center; }
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
        <div class="auth-icon">🌸</div>
        <h1>Bienvenida de vuelta</h1>
        <p class="sub">Ingresa con tu cuenta de suscriptora o como administradora</p>

        @if($errors->any())
        <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label>Correo electrónico</label>
                <input type="email" name="email" placeholder="tucorreo@ejemplo.com" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="form-group">
                <label>Contraseña</label>
                <div class="pw-wrap">
                    <input type="password" name="password" id="pw" placeholder="••••••••" required>
                    <button type="button" class="pw-toggle" onclick="togglePw()">👁️</button>
                </div>
            </div>
            <button type="submit" class="btn-submit">Iniciar sesión →</button>
        </form>

        <hr class="divider">
        <div class="auth-links">
            <a href="{{ route('registro') }}" class="main-link">🌺 ¿No tenés cuenta? Regístrate gratis</a>
            <a href="{{ route('home') }}">← Volver a la tienda</a>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
function togglePw() {
    const inp = document.getElementById('pw');
    const btn = inp.nextElementSibling;
    inp.type = inp.type === 'password' ? 'text' : 'password';
    btn.textContent = inp.type === 'password' ? '👁️' : '🙈';
}
</script>
@endpush