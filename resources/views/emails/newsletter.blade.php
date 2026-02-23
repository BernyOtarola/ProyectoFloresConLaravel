<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0;padding:0;background:#F8F5EE;font-family:'Helvetica Neue',Arial,sans-serif;">
    <div style="max-width:600px;margin:0 auto;background:white;border-radius:16px;overflow:hidden;margin-top:2rem;margin-bottom:2rem;box-shadow:0 4px 20px rgba(0,0,0,0.08);">

        {{-- Header --}}
        <div style="background:#2A4A1E;padding:2rem;text-align:center;">
            <h1 style="color:white;font-size:1.8rem;margin:0;font-weight:300;">
                Floristería <span style="color:#E8B4A0;font-style:italic;">Bribri</span>
            </h1>
            <p style="color:rgba(255,255,255,0.6);font-size:0.85rem;margin:0.5rem 0 0;">🌺 Flores frescas desde Costa Rica</p>
        </div>

        {{-- Cuerpo --}}
        <div style="padding:2.5rem 2rem;">
            <p style="color:#6B6B6B;font-size:0.95rem;margin-bottom:1.5rem;">
                ¡Hola <strong style="color:#2A4A1E;">{{ $nombreSuscriptor }}</strong>! 🌸
            </p>

            <div style="color:#1C1C1C;font-size:0.95rem;line-height:1.7;">
                {!! nl2br(e($mensaje)) !!}
            </div>

            {{-- Botón catálogo --}}
            <div style="text-align:center;margin:2rem 0;">
                <a href="{{ route('catalogo') }}"
                   style="background:#2A4A1E;color:white;padding:14px 32px;border-radius:100px;text-decoration:none;font-size:0.9rem;font-weight:500;display:inline-block;">
                    Ver catálogo →
                </a>
            </div>
        </div>

        {{-- Footer --}}
        <div style="background:#F8F5EE;padding:1.5rem 2rem;text-align:center;border-top:1px solid rgba(42,74,30,0.08);">
            <p style="color:#6B6B6B;font-size:0.8rem;margin:0;">
                📍 Bribri, Talamanca, Costa Rica &nbsp;•&nbsp;
                <a href="https://wa.me/{{ config('floristeria.whatsapp') }}" style="color:#2A4A1E;text-decoration:none;">WhatsApp: +506 8463-0055</a>
            </p>
            <p style="color:#999;font-size:0.75rem;margin:0.75rem 0 0;">
                Recibís este correo porque te suscribiste a Floristería Bribri 💚
            </p>
        </div>
    </div>
</body>
</html>