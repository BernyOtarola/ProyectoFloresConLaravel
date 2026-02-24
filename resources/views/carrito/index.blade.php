@extends('layouts.main')
@section('title', 'Mi Carrito — Floristería Bribri')

@push('css')
<style>
.page-wrap { max-width:1100px;margin:3rem auto;padding:0 5%; }
.page-wrap > h1 { font-family:'Cormorant Garamond',serif;font-size:2.5rem;font-weight:300;color:var(--verde);margin-bottom:2rem; }
.cart-layout { display:grid;grid-template-columns:1fr 360px;gap:2.5rem; }

/* ── Aviso de precios actualizados ─────────────────── */
.alert-sync {
    background:#fff8e1;
    border:1px solid #ffe082;
    border-left:4px solid #f6a800;
    border-radius:12px;
    padding:14px 18px;
    margin-bottom:1.5rem;
    font-size:0.875rem;
    color:#7a5800;
    display:flex;
    align-items:flex-start;
    gap:10px;
}
.alert-sync .alert-icon { font-size:1.1rem;flex-shrink:0;margin-top:1px; }

.cart-item { background:white;border-radius:16px;padding:1.25rem;display:flex;align-items:center;gap:1.25rem;border:1px solid rgba(42,74,30,0.06);margin-bottom:1rem; }
.item-img { width:80px;height:80px;border-radius:12px;background:linear-gradient(135deg,#e8f5e0,#d4edca);display:flex;align-items:center;justify-content:center;font-size:2.5rem;flex-shrink:0;overflow:hidden; }
.item-img img { width:100%;height:100%;object-fit:cover; }
.item-info { flex:1; }
.item-name { font-family:'Cormorant Garamond',serif;font-size:1.15rem;font-weight:600;color:var(--verde); }
.item-price { font-size:0.85rem;color:var(--gris);margin-top:4px; }

/* Badge de precio actualizado */
.price-updated {
    display:inline-block;
    background:#fff3cd;
    color:#856404;
    font-size:0.7rem;
    font-weight:500;
    padding:2px 8px;
    border-radius:100px;
    margin-left:6px;
    vertical-align:middle;
    border:1px solid #ffe082;
}

.qty-row { display:flex;align-items:center;gap:10px;margin-top:10px; }
.qty-btn { width:30px;height:30px;border-radius:50%;border:1.5px solid var(--verde);background:none;cursor:pointer;font-size:1rem;color:var(--verde);display:flex;align-items:center;justify-content:center;transition:all 0.2s; }
.qty-btn:hover { background:var(--verde);color:white; }
.qty-val { font-size:1rem;font-weight:500;min-width:24px;text-align:center; }
.btn-del { margin-left:auto;background:none;border:none;cursor:pointer;color:#ccc;font-size:1.2rem;transition:color 0.2s; }
.btn-del:hover { color:var(--terracota); }
.item-sub { font-family:'Cormorant Garamond',serif;font-size:1.2rem;font-weight:600;color:var(--verde);min-width:80px;text-align:right; }

.empty { text-align:center;padding:5rem 2rem; }
.empty .icon { font-size:5rem;margin-bottom:1.5rem; }
.empty h2 { font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:300;color:var(--verde);margin-bottom:1rem; }

.summary { background:white;border-radius:20px;padding:2rem;border:1px solid rgba(42,74,30,0.06);height:fit-content;position:sticky;top:100px; }
.summary-title { font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-weight:600;color:var(--verde);margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:1px solid rgba(42,74,30,0.08); }
.summary-row { display:flex;justify-content:space-between;font-size:0.9rem;color:var(--gris);margin-bottom:0.75rem; }
.summary-total { display:flex;justify-content:space-between;font-family:'Cormorant Garamond',serif;font-size:1.4rem;font-weight:600;color:var(--verde);padding-top:1rem;border-top:1px solid rgba(42,74,30,0.08);margin-top:1rem; }
.envio-note { font-size:0.8rem;color:var(--gris);text-align:center;margin:0.75rem 0; }
.btn-checkout { width:100%;background:var(--verde);color:white;border:none;cursor:pointer;padding:16px;border-radius:100px;font-family:'DM Sans',sans-serif;font-size:1rem;font-weight:500;transition:all 0.2s;margin-top:1rem; }
.btn-checkout:hover { background:var(--verde-claro);transform:translateY(-2px);box-shadow:0 8px 24px rgba(42,74,30,0.2); }
.btn-seguir { display:block;text-align:center;color:var(--verde);font-size:0.875rem;margin-top:1rem;text-decoration:none; }

/* Modal */
.overlay { position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:999;display:none;align-items:center;justify-content:center;padding:1rem; }
.overlay.open { display:flex; }
.modal { background:white;border-radius:24px;padding:2.5rem;width:100%;max-width:560px;max-height:90vh;overflow-y:auto; }
.modal h2 { font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:300;color:var(--verde);margin-bottom:0.5rem; }
.modal .sub { color:var(--gris);font-size:0.9rem;margin-bottom:2rem; }
.tipo-grid { display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem; }
.tipo-btn { padding:1.25rem;border:2px solid rgba(42,74,30,0.15);border-radius:14px;cursor:pointer;text-align:center;background:none;width:100%;font-family:'DM Sans',sans-serif;transition:all 0.2s; }
.tipo-btn.active,.tipo-btn:hover { border-color:var(--verde);background:rgba(42,74,30,0.04); }
.tipo-icon { font-size:2rem;margin-bottom:6px; }
.tipo-label { font-size:0.9rem;font-weight:500;color:var(--verde); }
.tipo-sub { font-size:0.75rem;color:var(--gris);margin-top:2px; }
.fgroup { margin-bottom:1.2rem; }
.fgroup label { display:block;font-size:0.85rem;font-weight:500;margin-bottom:6px;color:var(--verde); }
.fgroup input,.fgroup textarea { width:100%;padding:12px 14px;border:1.5px solid rgba(42,74,30,0.15);border-radius:10px;font-family:'DM Sans',sans-serif;font-size:0.9rem;outline:none;background:var(--crema);transition:border 0.2s; }
.fgroup input:focus,.fgroup textarea:focus { border-color:var(--verde); }
.fgroup textarea { height:80px;resize:vertical; }
.fgroup .hint { font-size:0.78rem;color:var(--gris);margin-top:4px; }
.modal-total { background:var(--crema);border-radius:12px;padding:1.25rem;margin:1rem 0;display:flex;justify-content:space-between;align-items:center; }
.modal-total .lbl { font-size:0.9rem;color:var(--gris); }
.modal-total .amt { font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-weight:600;color:var(--verde); }
.btn-wa { width:100%;background:#25D366;color:white;border:none;cursor:pointer;padding:16px;border-radius:100px;font-family:'DM Sans',sans-serif;font-size:1rem;font-weight:500;display:flex;align-items:center;justify-content:center;gap:10px;transition:all 0.2s; }
.btn-wa:hover { background:#1ebe5a;transform:translateY(-2px); }
.btn-cancelar { display:block;text-align:center;color:var(--gris);font-size:0.875rem;margin-top:1rem;cursor:pointer; }
#envioFields { display:none; }

@media(max-width:768px){ .cart-layout{grid-template-columns:1fr} }
</style>
@endpush

@section('content')
<div class="page-wrap">
    <h1>Mi Carrito</h1>

    @if(empty($carrito))
    <div class="empty">
        <div class="icon">🌱</div>
        <h2>Tu carrito está vacío</h2>
        <p style="color:var(--gris);margin-bottom:2rem;">¡Explora nuestras flores y llena tu carrito de color!</p>
        <a href="{{ route('catalogo') }}" style="background:var(--verde);color:white;padding:14px 32px;border-radius:100px;text-decoration:none;">Ver catálogo de flores</a>
    </div>
    @else

    {{-- ── Aviso si algún precio o nombre fue actualizado ── --}}
    @php
        // Comparamos el carrito original (antes de sincronizar) con el actual.
        // El controlador ya sincronizó y persistió, así que si session('carrito_sync_warning')
        // fue seteado, mostramos el aviso. Lo usamos de forma diferente:
        // detectamos diferencias pasando los datos originales desde el controlador.
        // Como alternativa simple y efectiva, siempre mostramos el aviso
        // con un mensaje genérico suave que no alarma pero informa.
        // (Ver nota técnica abajo)
    @endphp

    @if(session('carrito_sync_changed'))
        <div class="alert-sync">
            <span class="alert-icon">ℹ️</span>
            <div>
                <strong>Algunos precios fueron actualizados</strong> — uno o más productos en tu carrito
                cambiaron de precio o de nombre desde la última vez que visitaste esta página.
                Los montos que ves ahora son los <strong>precios vigentes</strong>.
            </div>
        </div>
        {{-- Limpiar el flag después de mostrarlo --}}
        @php session()->forget('carrito_sync_changed'); @endphp
    @endif

    <div class="cart-layout">
        <div id="cartList">
            @foreach($carrito as $id => $item)
            <div class="cart-item" id="item-{{ $id }}">
                <div class="item-img">💐</div>
                <div class="item-info">
                    <div class="item-name">{{ $item['nombre'] }}</div>
                    <div class="item-price">
                        {{ formatPrice($item['precio']) }} c/u
                    </div>
                    <div class="qty-row">
                        <button class="qty-btn" onclick="cambiar({{ $id }},-1)">−</button>
                        <span class="qty-val" id="qty-{{ $id }}">{{ $item['cantidad'] }}</span>
                        <button class="qty-btn" onclick="cambiar({{ $id }},1)">+</button>
                    </div>
                </div>
                <div class="item-sub" id="sub-{{ $id }}">
                    {{ formatPrice($item['precio'] * $item['cantidad']) }}
                </div>
                <button class="btn-del" onclick="eliminar({{ $id }})">🗑️</button>
            </div>
            @endforeach
        </div>

        <div class="summary">
            <div class="summary-title">Resumen</div>
            <div class="summary-row">
                <span>Subtotal</span>
                <span id="sSubtotal">{{ formatPrice($subtotal) }}</span>
            </div>
            <div class="summary-row">
                <span>Envío</span>
                <span>Calcular al confirmar</span>
            </div>
            <div class="summary-total">
                <span>Estimado</span>
                <span id="sTotal">{{ formatPrice($subtotal) }}</span>
            </div>
            <p class="envio-note">Envío {{ formatPrice(config('floristeria.costo_envio')) }} — Retiro gratis</p>
            <button class="btn-checkout" onclick="document.getElementById('checkoutOverlay').classList.add('open')">
                Confirmar pedido
            </button>
            <a href="{{ route('catalogo') }}" class="btn-seguir">+ Agregar más flores</a>
        </div>
    </div>
    @endif
</div>

{{-- MODAL CHECKOUT --}}
<div class="overlay" id="checkoutOverlay">
    <div class="modal">
        <h2>Confirmar pedido</h2>
        <p class="sub">Completa tus datos y te enviamos la confirmación por WhatsApp.</p>

        <div class="tipo-grid">
            <button class="tipo-btn active" id="btnRetiro" onclick="setTipo('retiro')">
                <div class="tipo-icon">🏪</div>
                <div class="tipo-label">Retirar en local</div>
                <div class="tipo-sub">Sin costo adicional</div>
            </button>
            <button class="tipo-btn" id="btnEnvio" onclick="setTipo('envio')">
                <div class="tipo-icon">🚗</div>
                <div class="tipo-label">Envío a domicilio</div>
                <div class="tipo-sub">{{ formatPrice(config('floristeria.costo_envio')) }} adicionales</div>
            </button>
        </div>

        <div class="fgroup">
            <label>Nombre completo *</label>
            <input type="text" id="cNombre" placeholder="María González">
        </div>
        <div class="fgroup">
            <label>Teléfono WhatsApp *</label>
            <input type="tel" id="cTel" placeholder="88001234">
        </div>
        <div class="fgroup">
            <label>Correo (opcional)</label>
            <input type="email" id="cEmail" placeholder="tu@correo.com">
        </div>
        <div class="fgroup">
            <label>Fecha de retiro / entrega *</label>
            <input type="date" id="cFechaRetiro">
            <div class="hint">Indica el día en que pasarás a retirar o recibirás tu pedido.</div>
        </div>
        <div id="envioFields">
            <div class="fgroup">
                <label>Dirección de entrega *</label>
                <input type="text" id="cDir" placeholder="Provincia, cantón, señas...">
            </div>
        </div>
        <div class="fgroup">
            <label>Nota especial (opcional)</label>
            <textarea id="cNota" placeholder="Ej: Es para regalo, agregar tarjeta..."></textarea>
        </div>

        <div class="modal-total">
            <span class="lbl">Total a pagar</span>
            <span class="amt" id="modalTotal">{{ formatPrice($subtotal ?? 0) }}</span>
        </div>
        <button class="btn-wa" onclick="enviarPedido()">💬 Enviar pedido por WhatsApp</button>
        <span class="btn-cancelar" onclick="document.getElementById('checkoutOverlay').classList.remove('open')">Cancelar</span>
    </div>
</div>
@endsection

@push('js')
<script>
let tipoEntrega = 'retiro';

{{-- ── Datos desde PHP → JS, ya sincronizados desde BD ── --}}
{{-- base y cartData usan los precios del carrito ya sincronizado --}}
const base     = {{ $subtotal ?? 0 }};
const envCosto = {{ config('floristeria.costo_envio') }};

{{-- cartData lleva precios actualizados desde el servidor --}}
const cartData = @json(array_values(array_map(function($item) {
    return [
        'id'       => $item['id'],
        'nombre'   => $item['nombre'],
        'precio'   => $item['precio'],
        'cantidad' => $item['cantidad'],
    ];
}, $carrito ?? [])));

const csrfToken = '{{ csrf_token() }}';

// Fecha mínima = hoy
document.addEventListener('DOMContentLoaded', () => {
    const inputFecha = document.getElementById('cFechaRetiro');
    if (inputFecha) {
        const hoy = new Date().toISOString().split('T')[0];
        inputFecha.min   = hoy;
        inputFecha.value = hoy;
    }
});

function setTipo(t) {
    tipoEntrega = t;
    document.getElementById('btnRetiro').classList.toggle('active', t === 'retiro');
    document.getElementById('btnEnvio').classList.toggle('active',  t === 'envio');
    document.getElementById('envioFields').style.display = t === 'envio' ? 'block' : 'none';
    const tot = t === 'envio' ? base + envCosto : base;
    document.getElementById('modalTotal').textContent = formatColones(tot);
}

// ── Cambiar cantidad ─────────────────────────────────
function cambiar(id, delta) {
    const el = document.getElementById('qty-' + id);
    let q = parseInt(el.textContent) + delta;
    if (q < 1) { eliminar(id); return; }

    fetch('{{ route("api.carrito") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ accion: 'actualizar', id, cantidad: q })
    })
    .then(r => r.json())
    .then(d => {
        if (d.success) {
            el.textContent = q;
            // Actualizar subtotal del item con el precio que devuelve el servidor
            // (puede haber cambiado si el admin lo actualizó)
            const itemActualizado = d.item; // precio actualizado desde BD
            if (itemActualizado) {
                const precioActual = itemActualizado.precio;
                document.getElementById('sub-' + id).textContent = formatColones(precioActual * q);
            } else {
                // fallback: usar precio local
                const precio = cartData.find(i => i.id == id)?.precio || 0;
                document.getElementById('sub-' + id).textContent = formatColones(precio * q);
            }
            actualizarTotales(d.total);
        }
    });
}

// ── Eliminar item ────────────────────────────────────
function eliminar(id) {
    fetch('{{ route("api.carrito") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ accion: 'eliminar', id })
    })
    .then(r => r.json())
    .then(d => {
        document.getElementById('item-' + id)?.remove();
        actualizarTotales(d.total);
        if (d.count === 0) location.reload();
    });
}

// ── Actualizar totales en UI ─────────────────────────
function actualizarTotales(total) {
    const f = formatColones(total);
    document.getElementById('sSubtotal').textContent = f;
    document.getElementById('sTotal').textContent    = f;
}

// ── Formatear colones ────────────────────────────────
function formatColones(num) {
    return '₡' + Math.round(num).toLocaleString('es-CR');
}

// ── Enviar pedido por WhatsApp ───────────────────────
function enviarPedido() {
    const nombre      = document.getElementById('cNombre').value.trim();
    const tel         = document.getElementById('cTel').value.trim();
    const email       = document.getElementById('cEmail').value.trim();
    const nota        = document.getElementById('cNota').value.trim();
    const dir         = document.getElementById('cDir')?.value.trim() || '';
    const fechaRetiro = document.getElementById('cFechaRetiro').value;

    if (!nombre || !tel)  { alert('Completa nombre y teléfono'); return; }
    if (!fechaRetiro)     { alert('Selecciona la fecha de retiro o entrega'); return; }
    if (tipoEntrega === 'envio' && !dir) { alert('Ingresa tu dirección de entrega'); return; }

    const pedido = {
        nombre,
        telefono:     tel,
        email,
        nota,
        direccion:    dir,
        tipo:         tipoEntrega,
        fecha_retiro: fechaRetiro,
        // cartData ya tiene precios sincronizados desde BD (renderizados por PHP)
        carrito:      cartData,
        subtotal:     base,
        envio:        tipoEntrega === 'envio' ? envCosto : 0,
        total:        tipoEntrega === 'envio' ? base + envCosto : base,
    };

    fetch('{{ route("api.checkout") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify(pedido)
    })
    .then(r => r.json())
    .then(data => {

        if (!data.success) {
            alert(data.message || 'Error al procesar el pedido.');
            return;
        }

        // Fecha legible
        const fechaObj   = new Date(fechaRetiro + 'T12:00:00');
        const fechaTexto = fechaObj.toLocaleDateString('es-CR', {
            weekday: 'long', day: 'numeric', month: 'long'
        });

        let msg = '*NUEVO PEDIDO - Floristería Bribri*\n';
        msg += 'Pedido #' + (data.numero || 'N/A') + '\n\n';
        msg += '*Cliente:* '  + nombre + '\n';
        msg += '*Teléfono:* ' + tel    + '\n';
        if (email) msg += '*Email:* ' + email + '\n';
        msg += '\n*Entrega:* ' + (tipoEntrega === 'envio' ? 'Domicilio' : 'Retiro en local') + '\n';
        msg += '*Fecha:* '    + fechaTexto + '\n';
        if (tipoEntrega === 'envio') msg += '*Dirección:* ' + dir + '\n';
        msg += '\n*Productos:*\n';
        cartData.forEach(i => {
            msg += '- ' + i.nombre + ' x' + i.cantidad + ' = ' + formatColones(i.precio * i.cantidad) + '\n';
        });
        msg += '\n*Subtotal:* ' + formatColones(base) + '\n';
        if (tipoEntrega === 'envio') msg += '*Envío:* ' + formatColones(envCosto) + '\n';
        msg += '*TOTAL: ' + formatColones(pedido.total) + '*';
        if (nota) msg += '\n*Nota:* ' + nota;

        window.open(
            'https://wa.me/{{ config("floristeria.whatsapp") }}?text=' + encodeURIComponent(msg),
            '_blank'
        );

        // Limpiar carrito en sesión
        fetch('{{ route("api.carrito") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ accion: 'limpiar' })
        });

        setTimeout(() => { window.location.href = '{{ route("home") }}' }, 500);
    })
    .catch(() => {
        alert('Error de conexión. Intenta de nuevo.');
    });
}

// Cerrar modal al click fuera
document.getElementById('checkoutOverlay')?.addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('open');
});
</script>
@endpush