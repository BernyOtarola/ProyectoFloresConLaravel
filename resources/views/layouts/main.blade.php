<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('floristeria.nombre'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌺</text></svg>">
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --verde: #2A4A1E;
            --verde-claro: #4A7A35;
            --crema: #F8F5EE;
            --terracota: #C4714A;
            --rosa: #E8B4A0;
            --texto: #1C1C1C;
            --gris: #6B6B6B;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--crema);
            color: var(--texto);
            overflow-x: hidden;
        }

        .nav-logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--verde);
            text-decoration: none;
        }
        .nav-logo span { color: var(--terracota); font-style: italic; }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
            list-style: none;
        }
        .nav-links a {
            font-size: 0.875rem;
            color: var(--texto);
            text-decoration: none;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            transition: color 0.2s;
        }
        .nav-links a:hover { color: var(--verde); }

        .nav-btn-outline {
            padding: 8px 16px;
            border-radius: 100px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            border: 1.5px solid var(--verde);
            color: var(--verde);
            transition: all 0.2s;
            white-space: nowrap;
        }
        .nav-btn-outline:hover { background: var(--verde); color: white; }

        .nav-btn-ghost {
            padding: 8px 16px;
            border-radius: 100px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            border: 1.5px solid rgba(42, 74, 30, 0.25);
            color: var(--gris);
            transition: all 0.2s;
            white-space: nowrap;
            background: none;
            cursor: pointer;
        }
        .nav-btn-ghost:hover { border-color: var(--verde); color: var(--verde); }

        .nav-btn-admin {
            padding: 8px 16px;
            border-radius: 100px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            background: var(--rosa);
            color: var(--verde);
            transition: all 0.2s;
            white-space: nowrap;
        }
        .nav-btn-admin:hover { background: var(--terracota); color: white; }

        .nav-cart {
            position: relative;
            background: var(--verde);
            color: white;
            padding: 10px 18px;
            border-radius: 100px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .nav-cart:hover { background: var(--verde-claro); transform: translateY(-1px); }

        .cart-badge {
            background: var(--terracota);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 500;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            border: none;
            background: none;
        }
        .hamburger span {
            width: 24px;
            height: 2px;
            background: var(--verde);
            display: block;
            transition: all 0.3s;
        }

        /* ══════════════════════════════════════════
           FOOTER
           ══════════════════════════════════════════ */
        footer {
            background: #0F1E09;
            color: rgba(255, 255, 255, 0.6);
            padding: 4rem 5% 2rem;
            margin-top: 6rem;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 4rem;
            margin-bottom: 3rem;
        }
        .footer-brand .f-logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            font-weight: 600;
            color: white;
            text-decoration: none;
            display: block;
            margin-bottom: 1rem;
        }
        .footer-brand .f-logo span { color: var(--rosa); font-style: italic; }
        .footer-brand p { font-size: 0.9rem; line-height: 1.7; max-width: 300px; }

        /* ── Redes sociales ──────────────────────── */
        .footer-redes {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
            align-items: center;
        }
        .red-social {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            text-decoration: none;
            font-size: 1.1rem;
            transition: all 0.25s;
            color: rgba(255,255,255,0.6);
        }
        .red-social:hover {
            transform: translateY(-3px);
            background: rgba(255,255,255,0.15);
            border-color: rgba(255,255,255,0.3);
            color: white;
        }
        .red-social.facebook:hover  { background: #1877F2; border-color: #1877F2; }
        .red-social.instagram:hover { background: linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888); border-color: #e6683c; }
        .red-social.tiktok:hover    { background: #010101; border-color: #69C9D0; color: #69C9D0; }

        .footer-col h4 {
            color: white;
            font-size: 0.875rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
        }
        .footer-col a {
            display: block;
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            font-size: 0.9rem;
            margin-bottom: 0.6rem;
            transition: color 0.2s;
        }
        .footer-col a:hover { color: var(--rosa); }

        /* Redes en columna de contacto */
        .footer-col .red-link {
            display: flex;
            align-items: center;
            gap: 8px;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 0.9rem;
            margin-bottom: 0.6rem;
            transition: color 0.2s;
        }
        .footer-col .red-link:hover { color: var(--rosa); }
        .footer-col .red-link span { font-size: 1rem; }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .footer-bottom p { font-size: 0.8rem; }

        /* Redes en footer-bottom */
        .footer-bottom-redes {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        .footer-bottom-redes a {
            color: rgba(255,255,255,0.3);
            text-decoration: none;
            font-size: 0.8rem;
            transition: color 0.2s;
        }
        .footer-bottom-redes a:hover { color: var(--rosa); }

        .wa-float {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 999;
            background: #25D366;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            text-decoration: none;
            box-shadow: 0 8px 24px rgba(37, 211, 102, 0.4);
            transition: all 0.3s;
            animation: pulseWA 2.5s ease-in-out infinite;
        }
        .wa-float:hover { transform: scale(1.1); }
        @keyframes pulseWA {
            0%, 100% { box-shadow: 0 8px 24px rgba(37, 211, 102, 0.4), 0 0 0 0 rgba(37, 211, 102, 0.3); }
            70%       { box-shadow: 0 8px 24px rgba(37, 211, 102, 0.4), 0 0 0 12px rgba(37, 211, 102, 0); }
        }

        .toast {
            position: fixed;
            bottom: 6rem;
            left: 50%;
            transform: translateX(-50%) translateY(20px);
            background: var(--verde);
            color: white;
            padding: 12px 24px;
            border-radius: 100px;
            font-size: 0.9rem;
            opacity: 0;
            transition: all 0.3s;
            z-index: 9999;
            pointer-events: none;
        }
        .toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

        @media (max-width:900px) {
            .nav-links { display: none; }
            .nav-links.open {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 72px;
                left: 0; right: 0;
                background: var(--crema);
                border-bottom: 1px solid rgba(42, 74, 30, 0.1);
                padding: 1.5rem 5%;
                z-index: 99;
            }
            .hamburger { display: flex; }
        }

        @media (max-width:640px) {
            .nav-btn-outline,
            .nav-btn-ghost,
            .nav-btn-admin { font-size: 0; padding: 10px 13px; }
            .nav-btn-outline::before { content: '🌸'; font-size: 1rem; }
            .nav-btn-ghost::before   { content: '👤'; font-size: 1rem; }
            .nav-btn-admin::before   { content: '⚙️'; font-size: 1rem; }
            .footer-grid { grid-template-columns: 1fr; gap: 2rem; }
            .footer-bottom { flex-direction: column; align-items: flex-start; gap: 0.75rem; }
        }
    </style>
    @stack('css')
</head>

<body>

    @include('partials.nav')

    @if(session('success'))
        <div style="background:#d4edda;color:#155724;border:1px solid #c3e6cb;padding:12px 20px;font-size:0.875rem;text-align:center;">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')

    <footer>
        <div class="footer-grid">

            {{-- ── Columna marca + redes ── --}}
            <div class="footer-brand">
                <a href="{{ route('home') }}" class="f-logo">Floristería <span>Bribri</span></a>
                <p>Flores frescas y arreglos únicos para cada momento especial. Con amor desde Costa Rica 🌺</p>

                {{-- Íconos de redes sociales --}}
                <div class="footer-redes">
                    @if(config('floristeria.redes.facebook'))
                    <a href="{{ config('floristeria.redes.facebook') }}"
                       target="_blank" rel="noopener noreferrer"
                       class="red-social facebook"
                       title="Facebook">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    @endif

                    @if(config('floristeria.redes.instagram'))
                    <a href="{{ config('floristeria.redes.instagram') }}"
                       target="_blank" rel="noopener noreferrer"
                       class="red-social instagram"
                       title="Instagram">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                    </a>
                    @endif

                    @if(config('floristeria.redes.tiktok'))
                    <a href="{{ config('floristeria.redes.tiktok') }}"
                       target="_blank" rel="noopener noreferrer"
                       class="red-social tiktok"
                       title="TikTok">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>

            {{-- ── Columna tienda ── --}}
            <div class="footer-col">
                <h4>Tienda</h4>
                <a href="{{ route('catalogo') }}">Catálogo</a>
                <a href="{{ route('catalogo', ['categoria' => 1]) }}">Ramos</a>
                <a href="{{ route('catalogo', ['categoria' => 2]) }}">Arreglos</a>
                <a href="{{ route('catalogo', ['categoria' => 3]) }}">Plantas</a>
            </div>

            {{-- ── Columna contacto + redes ── --}}
            <div class="footer-col">
                <h4>Contacto</h4>
                <a href="https://wa.me/{{ config('floristeria.whatsapp') }}">📱 WhatsApp: +506 8463-0055</a>
                <a href="mailto:{{ config('floristeria.admin_email') }}">📧 {{ config('floristeria.admin_email') }}</a>
                <a href="{{ route('registro') }}">💌 Suscribirse a novedades</a>

                {{-- Redes sociales como links de texto --}}
                @if(config('floristeria.redes.facebook'))
                <a href="{{ config('floristeria.redes.facebook') }}"
                   target="_blank" rel="noopener noreferrer"
                   class="red-link">
                    <span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:middle;">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </span>
                    Facebook
                </a>
                @endif

                @if(config('floristeria.redes.instagram'))
                <a href="{{ config('floristeria.redes.instagram') }}"
                   target="_blank" rel="noopener noreferrer"
                   class="red-link">
                    <span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:middle;">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                    </span>
                    Instagram
                </a>
                @endif

                @if(config('floristeria.redes.tiktok'))
                <a href="{{ config('floristeria.redes.tiktok') }}"
                   target="_blank" rel="noopener noreferrer"
                   class="red-link">
                    <span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:middle;">
                            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                        </svg>
                    </span>
                    TikTok
                </a>
                @endif
            </div>

        </div>

        <div class="footer-bottom">
            <p>© {{ date('Y') }} Floristería Bribri. Todos los derechos reservados.</p>

            <div class="footer-bottom-redes">
                @if(config('floristeria.redes.facebook'))
                <a href="{{ config('floristeria.redes.facebook') }}" target="_blank" rel="noopener noreferrer">Facebook</a>
                @endif
                @if(config('floristeria.redes.instagram'))
                <a href="{{ config('floristeria.redes.instagram') }}" target="_blank" rel="noopener noreferrer">Instagram</a>
                @endif
                @if(config('floristeria.redes.tiktok'))
                <a href="{{ config('floristeria.redes.tiktok') }}" target="_blank" rel="noopener noreferrer">TikTok</a>
                @endif
            </div>

            <p>Hecho con 💚 en Costa Rica</p>
        </div>
    </footer>

    {{-- Botón flotante WhatsApp --}}
    <a href="https://wa.me/{{ config('floristeria.whatsapp') }}" target="_blank" class="wa-float">💬</a>

    {{-- Chatbot solo para no-admins --}}
    @if(!Auth::guard('admin')->check())
        @include('partials.chatbot')
    @endif

    <div class="toast" id="toast"></div>

    <script>
        function toggleMenu() {
            document.getElementById('navLinks').classList.toggle('open');
        }

        function showToast(msg) {
            const t = document.getElementById('toast');
            t.textContent = msg;
            t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), 2500);
        }

        @if(!Auth::guard('admin')->check() && !Auth::guard('web')->check())
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (nav) nav.style.boxShadow = window.scrollY > 50
                ? '0 4px 20px rgba(0,0,0,0.08)'
                : 'none';
        });
        @endif
    </script>
    @stack('js')
</body>

</html>