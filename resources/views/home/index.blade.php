@extends('layouts.main')
@section('title', 'Floristería Bribri — Flores con Alma')

@push('css')
    <style>
        .hero {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            position: relative;
            overflow: hidden;
        }

        .hero-left {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 100px 6% 80px;
            z-index: 2;
        }

        .hero-tag {
            font-size: 0.75rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--terracota);
            font-weight: 500;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .hero-tag::before {
            content: '';
            width: 40px;
            height: 1px;
            background: var(--terracota);
        }

        .hero h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(3rem, 5vw, 5.5rem);
            font-weight: 300;
            line-height: 1.05;
            color: var(--verde);
            margin-bottom: 1.5rem;
        }

        .hero h1 em {
            font-style: italic;
            color: var(--terracota);
        }

        .hero-desc {
            font-size: 1.05rem;
            color: var(--gris);
            line-height: 1.7;
            max-width: 440px;
            margin-bottom: 2.5rem;
        }

        .hero-btns {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: var(--verde);
            color: white;
            padding: 14px 32px;
            border-radius: 100px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
            border: 2px solid var(--verde);
        }

        /* Mapa */
        .map-section {
            padding: 6rem 5%;
        }

        .map-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2.5rem;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 4px 30px rgba(42, 74, 30, 0.08);
            border: 1px solid rgba(42, 74, 30, 0.08);
        }

        .map-info {
            padding: 3.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 1.5rem;
        }

        .map-info h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--verde);
        }

        .map-detail {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 0.9rem;
            color: var(--gris);
            line-height: 1.6;
        }

        .map-detail span {
            font-size: 1.3rem;
        }

        .map-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--verde);
            color: white;
            padding: 12px 24px;
            border-radius: 100px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
            margin-top: 0.5rem;
            align-self: flex-start;
        }

        .map-link:hover {
            background: var(--verde-claro);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(42, 74, 30, 0.2);
        }

        .map-embed {
            min-height: 350px;
        }

        .map-embed iframe {
            width: 100%;
            height: 100%;
            min-height: 350px;
            border: none;
        }

        @media(max-width:768px) {
            .map-grid {
                grid-template-columns: 1fr;
            }

            .map-embed iframe {
                min-height: 280px;
            }

            .map-info {
                padding: 2rem;
            }
        }

        .btn-primary:hover {
            background: var(--verde-claro);
            border-color: var(--verde-claro);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(42, 74, 30, 0.2);
        }

        .btn-sec {
            background: transparent;
            color: var(--verde);
            padding: 14px 32px;
            border-radius: 100px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            border: 2px solid var(--verde);
            transition: all 0.2s;
        }

        .btn-sec:hover {
            background: var(--verde);
            color: white;
            transform: translateY(-2px);
        }

        .hero-right {
            background: var(--verde);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 1rem;
        }

        .hero-flor {
            font-size: 8rem;
            animation: flotar 4s ease-in-out infinite;
            filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.3));
        }

        @keyframes flotar {

            0%,
            100% {
                transform: translateY(0) rotate(-3deg)
            }

            50% {
                transform: translateY(-20px) rotate(3deg)
            }
        }

        .hero-pattern {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 20% 20%, rgba(184, 147, 90, 0.15) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(196, 113, 74, 0.1) 0%, transparent 50%);
        }

        .stats-bar {
            background: var(--verde);
            color: white;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            text-align: center;
        }

        .stat {
            padding: 2rem;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat:last-child {
            border-right: none;
        }

        .stat-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.5rem;
            font-weight: 300;
            color: var(--rosa);
            display: block;
        }

        .stat-label {
            font-size: 0.8rem;
            opacity: 0.7;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        section {
            padding: 6rem 5%;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-tag {
            font-size: 0.75rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--terracota);
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .section-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2rem, 3vw, 3rem);
            font-weight: 300;
            color: var(--verde);
            line-height: 1.2;
        }

        .section-title em {
            font-style: italic;
        }

        .section-sub {
            color: var(--gris);
            font-size: 1rem;
            margin-top: 0.75rem;
        }

        .cat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
            gap: 1.5rem;
        }

        .cat-card {
            background: white;
            border-radius: 16px;
            padding: 2rem 1.5rem;
            text-align: center;
            text-decoration: none;
            color: var(--texto);
            border: 1px solid rgba(42, 74, 30, 0.08);
            transition: all 0.3s;
        }

        .cat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(42, 74, 30, 0.1);
            border-color: var(--verde);
        }

        .cat-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .cat-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--verde);
        }

        .cat-count {
            font-size: 0.8rem;
            color: var(--gris);
            margin-top: 4px;
        }

        .prod-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }

        .prod-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(42, 74, 30, 0.06);
            transition: all 0.35s;
        }

        .prod-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 24px 48px rgba(42, 74, 30, 0.12);
        }

        .prod-img {
            height: 240px;
            background: linear-gradient(135deg, #e8f5e0, #d4edca);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .prod-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .prod-ph {
            font-size: 5rem;
        }

        .prod-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: var(--terracota);
            color: white;
            font-size: 0.7rem;
            font-weight: 500;
            padding: 4px 10px;
            border-radius: 100px;
            text-transform: uppercase;
        }

        .prod-body {
            padding: 1.5rem;
        }

        .prod-cat {
            font-size: 0.75rem;
            color: var(--terracota);
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .prod-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--verde);
            margin: 4px 0;
        }

        .prod-desc {
            font-size: 0.875rem;
            color: var(--gris);
            line-height: 1.6;
            margin-bottom: 1.2rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .prod-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .prod-price {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--verde);
        }

        .btn-agregar {
            background: var(--verde);
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px 18px;
            border-radius: 100px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-agregar:hover {
            background: var(--verde-claro);
            transform: scale(1.05);
        }

        .btn-agregar.ok {
            background: var(--terracota);
        }

        .entrega-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 4px 30px rgba(42, 74, 30, 0.08);
            border: 1px solid rgba(42, 74, 30, 0.08);
        }

        .entrega-item {
            padding: 3.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 1rem;
        }

        .entrega-item:first-child {
            border-right: 1px solid rgba(42, 74, 30, 0.08);
        }

        .entrega-icon {
            font-size: 3rem;
        }

        .entrega-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--verde);
        }

        .entrega-desc {
            font-size: 0.9rem;
            color: var(--gris);
            line-height: 1.6;
        }

        .nl-box {
            background: var(--verde);
            border-radius: 32px;
            padding: 5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            margin: 0 5% 6rem;
        }

        .nl-box::before {
            content: '🌸';
            position: absolute;
            top: -20px;
            left: 5%;
            font-size: 8rem;
            opacity: 0.08;
        }

        .nl-box::after {
            content: '🌿';
            position: absolute;
            bottom: -20px;
            right: 5%;
            font-size: 8rem;
            opacity: 0.08;
        }

        .nl-box h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.5rem;
            font-weight: 300;
            color: white;
            margin-bottom: 1rem;
        }

        .nl-box p {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 2rem;
        }

        .nl-form {
            display: flex;
            gap: 1rem;
            max-width: 480px;
            margin: 0 auto;
        }

        .nl-form input {
            flex: 1;
            padding: 14px 20px;
            border-radius: 100px;
            border: none;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            outline: none;
        }

        .nl-form input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .nl-form button {
            background: var(--terracota);
            color: white;
            border: none;
            cursor: pointer;
            padding: 14px 28px;
            border-radius: 100px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .nl-form button:hover {
            background: #d4784f;
            transform: translateY(-2px);
        }

        #nlMsg {
            margin-top: 1rem;
            color: rgba(255, 255, 255, 0.85);
            display: none;
        }

        @media(max-width:768px) {
            .hero {
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .hero-right {
                display: none;
            }

            .hero-left {
                padding: 100px 5% 60px;
            }

            .stats-bar {
                grid-template-columns: 1fr;
            }

            .stat {
                border-right: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .entrega-grid {
                grid-template-columns: 1fr;
            }

            .entrega-item:first-child {
                border-right: none;
                border-bottom: 1px solid rgba(42, 74, 30, 0.08);
            }

            .nl-box {
                padding: 3rem 1.5rem;
                margin: 0 5% 4rem;
            }

            .nl-form {
                flex-direction: column;
            }

            section {
                padding: 4rem 5%;
            }
        }
    </style>
@endpush

@section('content')
    <section class="hero">
        <div class="hero-left">
            <div class="hero-tag">Flores frescas • Costa Rica</div>
            <h1>Flores que<br>hablan por <em>ti</em></h1>
            <p class="hero-desc">Desde Bribri al mundo, llevamos la belleza de las flores tropicales directamente a tus
                manos. Arreglos únicos para cada momento especial.</p>
            <div class="hero-btns">
                <a href="{{ route('catalogo') }}" class="btn-primary">Ver Catálogo</a>
                <a href="#entrega" class="btn-sec">¿Cómo recibir?</a>
            </div>
        </div>
        <div class="hero-right">
            <div class="hero-pattern"></div>
            <div class="hero-flor">💐</div>
            <p style="color:rgba(255,255,255,0.4);font-size:0.85rem;">Flores de temporada</p>
        </div>
    </section>

    <div class="stats-bar">
        <div class="stat"><span class="stat-num">500+</span><span class="stat-label">Clientes felices</span></div>
        <div class="stat"><span class="stat-num">100%</span><span class="stat-label">Flores frescas</span></div>
        <div class="stat"><span class="stat-num">24h</span><span class="stat-label">Entrega express</span></div>
    </div>

    <section>
        <div class="section-header">
            <div class="section-tag">Explora por categoría</div>
            <h2 class="section-title">Encuentra la flor <em>perfecta</em></h2>
            <p class="section-sub">Una variedad increíble para cada ocasión</p>
        </div>
        <div class="cat-grid">
            @php $icons = ['🌹', '💐', '🪴', '💍', '🌸', '🌺', '🌻', '🌷']; @endphp
            @foreach($categorias as $i => $cat)
                <a href="{{ route('catalogo', ['categoria' => $cat->id]) }}" class="cat-card">
                    <div class="cat-icon">{{ $icons[$i % count($icons)] }}</div>
                    <div class="cat-name">{{ $cat->nombre }}</div>
                    <div class="cat-count">{{ $cat->productos_count }} productos</div>
                </a>
            @endforeach
        </div>
    </section>

    <section style="background:white;margin:0 -5%;padding:6rem 5%;">
        <div class="section-header">
            <div class="section-tag">Lo más pedido</div>
            <h2 class="section-title">Flores <em>destacadas</em></h2>
            <p class="section-sub">Selección especial de nuestros arreglos más populares</p>
        </div>
        <div class="prod-grid">
            @foreach($productos as $p)
                <div class="prod-card">
                    <div class="prod-img">
                        @if($p->imagen)
                            <img src="{{ asset('storage/products/' . $p->imagen) }}" alt="{{ $p->nombre }}">
                        @else
                            <div class="prod-ph">💐</div>
                        @endif
                        <div class="prod-badge">Destacado</div>
                    </div>
                    <div class="prod-body">
                        <div class="prod-cat">{{ $p->categoria->nombre ?? 'Flores' }}</div>
                        <div class="prod-name">{{ $p->nombre }}</div>
                        <div class="prod-desc">{{ $p->descripcion }}</div>
                        <div class="prod-footer">
                            <div class="prod-price">{{ formatPrice($p->precio) }}</div>
                            <button class="btn-agregar"
                                onclick="addCart({{ $p->id }},'{{ e($p->nombre) }}',{{ $p->precio }},this)">+ Agregar</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div style="text-align:center;margin-top:3rem;">
            <a href="{{ route('catalogo') }}" class="btn-primary">Ver todo el catálogo →</a>
        </div>
    </section>

    <section id="entrega">
        <div class="section-header">
            <div class="section-tag">Opciones de entrega</div>
            <h2 class="section-title">¿Cómo quieres <em>recibirlas</em>?</h2>
        </div>
        <div class="entrega-grid">
            <div class="entrega-item">
                <div class="entrega-icon">🚗</div>
                <div class="entrega-title">Envío a domicilio</div>
                <div class="entrega-desc">Te llevamos las flores directamente a tu puerta. Costo:
                    <strong>{{ formatPrice(config('floristeria.costo_envio')) }}</strong>. Coordinamos por WhatsApp.
                </div>
            </div>
            <div class="entrega-item">
                <div class="entrega-icon">🏪</div>
                <div class="entrega-title">Retirar en el local</div>
                <div class="entrega-desc">¡Sin costo adicional! Ven a recoger tu pedido. Te avisamos por WhatsApp cuando
                    esté listo.</div>
            </div>
        </div>
    </section>

    <section class="map-section" id="ubicacion">
        <div class="section-header">
            <div class="section-tag">Nuestra ubicación</div>
            <h2 class="section-title">Encuéntranos en <em>Bribri</em></h2>
        </div>
        <div class="map-grid">
            <div class="map-info">
                <h3>📍 Floristería Bribri</h3>
                <div class="map-detail">
                    <span>🏠</span>
                    <div>Bribri, Talamanca<br>Limón, Costa Rica</div>
                </div>
                <div class="map-detail">
                    <span>🕐</span>
                    <div>Lunes a Sábado: 8:00 am — 6:00 pm<br>Domingos: 9:00 am — 2:00 pm</div>
                </div>
                <div class="map-detail">
                    <span>📱</span>
                    <div>WhatsApp: <a href="https://wa.me/{{ config('floristeria.whatsapp') }}"
                            style="color:var(--verde);text-decoration:none;font-weight:500;">+506 8463-0055</a></div>
                </div>
                <div class="map-detail">
                    <span>📧</span>
                    <div><a href="mailto:{{ config('floristeria.admin_email') }}"
                            style="color:var(--verde);text-decoration:none;">{{ config('floristeria.admin_email') }}</a>
                    </div>
                </div>
                <a href="https://maps.app.goo.gl/LibtXFayE1mNFFhL6" target="_blank" class="map-link">
                    🗺️ Abrir en Google Maps
                </a>
            </div>
            <div class="map-embed">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3929.5!2d-82.717!3d9.634!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOcKwMzgnMDIuNCJOIDgywrA0MycwMS4yIlc!5e0!3m2!1ses!4v1700000000000"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>


@endsection

@push('js')
    <script>
        function addCart(id, nombre, precio, btn) {
            fetch('{{ route("api.carrito") }}', {
                method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ accion: 'agregar', id, nombre, precio })
            }).then(r => r.json()).then(d => {
                if (d.success) {
                    btn.textContent = '✓ Agregado'; btn.classList.add('ok');
                    setTimeout(() => { btn.textContent = '+ Agregar'; btn.classList.remove('ok'); }, 1500);
                    showToast('✓ ' + nombre + ' agregado');
                    const b = document.querySelector('.cart-badge');
                    if (b) b.textContent = d.count;
                    else { const c = document.querySelector('.nav-cart'); const s = document.createElement('span'); s.className = 'cart-badge'; s.textContent = d.count; c.appendChild(s); }
                }
            });
        }
        function suscribir() {
            const nombre = document.getElementById('nlNombre').value.trim();
            const email = document.getElementById('nlEmail').value.trim();
            const msg = document.getElementById('nlMsg');
            const form = document.getElementById('nlForm');

            if (!nombre || !email) {
                showToast('Completa nombre y correo');
                return;
            }

            // Deshabilitar botón mientras se envía
            const btn = form.querySelector('button');
            btn.disabled = true;
            btn.textContent = 'Enviando...';

            fetch('{{ route("api.suscribir") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ nombre, email })
            })
                .then(r => r.json())
                .then(d => {
                    if (d.success) {
                        msg.style.display = 'block';
                        msg.textContent = d.message;
                        form.style.display = 'none';
                        showToast('✓ Suscripción exitosa');
                    }
                })
                .catch(() => {
                    showToast('Error al suscribir, intenta de nuevo');
                    btn.disabled = false;
                    btn.textContent = 'Suscribirme 🌸';
                });
        }
        const nombre = document.getElementById('nlNombre').value.trim();
        const email = document.getElementById('nlEmail').value.trim();
        const msg = document.getElementById('nlMsg');
        const form = document.getElementById('nlForm');

        if (!nombre || !email) {
            showToast('Completa nombre y correo');
            return;
        }

        // Deshabilitar botón mientras se envía
        const btn = form.querySelector('button');
        btn.disabled = true;
        btn.textContent = 'Enviando...';

        fetch('{{ route("api.suscribir") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ nombre, email })
        })
            .then(r => r.json())
            .then(d => {
                if (d.success) {
                    msg.style.display = 'block';
                    msg.textContent = d.message;
                    form.style.display = 'none';
                    showToast('✓ Suscripción exitosa');
                }
            })
            .catch(() => {
                showToast('Error al suscribir, intenta de nuevo');
                btn.disabled = false;
                btn.textContent = 'Suscribirme 🌸';
            });
                }
    </script>
@endpush