<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('floristeria.nombre'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

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

        .nav-logo span {
            color: var(--terracota);
            font-style: italic;
        }

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

        .nav-links a:hover {
            color: var(--verde);
        }

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

        .nav-btn-outline:hover {
            background: var(--verde);
            color: white;
        }

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
        }

        .nav-btn-ghost:hover {
            border-color: var(--verde);
            color: var(--verde);
        }

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

        .nav-btn-admin:hover {
            background: var(--terracota);
            color: white;
        }

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

        .nav-cart:hover {
            background: var(--verde-claro);
            transform: translateY(-1px);
        }

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

        .footer-brand .f-logo span {
            color: var(--rosa);
            font-style: italic;
        }

        .footer-brand p {
            font-size: 0.9rem;
            line-height: 1.7;
            max-width: 300px;
        }

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

        .footer-col a:hover {
            color: var(--rosa);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-bottom p {
            font-size: 0.8rem;
        }

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

        .wa-float:hover {
            transform: scale(1.1);
        }

        @keyframes pulseWA {

            0%,
            100% {
                box-shadow: 0 8px 24px rgba(37, 211, 102, 0.4), 0 0 0 0 rgba(37, 211, 102, 0.3);
            }

            70% {
                box-shadow: 0 8px 24px rgba(37, 211, 102, 0.4), 0 0 0 12px rgba(37, 211, 102, 0);
            }
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

        .toast.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        @media (max-width:900px) {
            .nav-links {
                display: none;
            }

            .nav-links.open {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 72px;
                left: 0;
                right: 0;
                background: var(--crema);
                border-bottom: 1px solid rgba(42, 74, 30, 0.1);
                padding: 1.5rem 5%;
                z-index: 99;
            }

            .hamburger {
                display: flex;
            }
        }

        @media (max-width:640px) {

            .nav-btn-outline,
            .nav-btn-ghost,
            .nav-btn-admin {
                font-size: 0;
                padding: 10px 13px;
            }

            .nav-btn-outline::before {
                content: '🌸';
                font-size: 1rem;
            }

            .nav-btn-ghost::before {
                content: '👤';
                font-size: 1rem;
            }

            .nav-btn-admin::before {
                content: '⚙️';
                font-size: 1rem;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
        }
    </style>
    @stack('css')
</head>

<body>

    @include('partials.nav')

    @yield('content')

    <footer>
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="{{ route('home') }}" class="f-logo">Floristería <span>Bribri</span></a>
                <p>Flores frescas y arreglos únicos para cada momento especial. Con amor desde Costa Rica 🌺</p>
            </div>
            <div class="footer-col">
                <h4>Tienda</h4>
                <a href="{{ route('catalogo') }}">Catálogo</a>
                <a href="{{ route('catalogo', ['categoria' => 1]) }}">Ramos</a>
                <a href="{{ route('catalogo', ['categoria' => 2]) }}">Arreglos</a>
                <a href="{{ route('catalogo', ['categoria' => 3]) }}">Plantas</a>
            </div>
            <div class="footer-col">
                <h4>Contacto</h4>
                <a href="https://wa.me/{{ config('floristeria.whatsapp') }}">WhatsApp: +506 8463-0055</a>
                <a href="mailto:{{ config('floristeria.admin_email') }}">{{ config('floristeria.admin_email') }}</a>
                <a href="{{ route('registro') }}">Suscribirse a novedades</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© {{ date('Y') }} Floristería Bribri. Todos los derechos reservados.</p>
            <p>Hecho con 💚 en Costa Rica</p>
        </div>
    </footer>

    {{-- Botón flotante WhatsApp --}}
    <a href="https://wa.me/{{ config('floristeria.whatsapp') }}" target="_blank" class="wa-float">💬</a>

    {{-- Chatbot --}}
    @if(!session('admin_id'))
        @include('partials.chatbot')
    @endif
    <div class="toast" id="toast"></div>

    <script>
        function toggleMenu() { document.getElementById('navLinks').classList.toggle('open'); }
        function showToast(msg) {
            const t = document.getElementById('toast');
            t.textContent = msg; t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), 2500);
        }
        @if(!session('admin_id') && !session('user_id'))
            window.addEventListener('scroll', () => {
                const nav = document.getElementById('navbar');
                if (nav) nav.style.boxShadow = window.scrollY > 50 ? '0 4px 20px rgba(0,0,0,0.08)' : 'none';
            });
        @endif
    </script>
    @stack('js')
</body>

</html>