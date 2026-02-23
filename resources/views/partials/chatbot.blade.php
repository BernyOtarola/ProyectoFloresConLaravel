{{-- ══════════════════════════════════════════════════════════
     CHATBOT HÍBRIDO — Floristería Bribri 🌸
     Botones predefinidos + campo libre + redirect WhatsApp
     ══════════════════════════════════════════════════════════ --}}

<style>
/* ── Botón flotante ──────────────────────────────────────── */
.chatbot-toggle {
    position:fixed;bottom:6rem;right:2rem;z-index:1000;
    width:60px;height:60px;border-radius:50%;border:none;cursor:pointer;
    background:var(--verde);color:white;font-size:1.6rem;
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 8px 24px rgba(42,74,30,0.35);
    transition:all 0.3s;animation:pulseBot 2.5s ease-in-out infinite;
}
.chatbot-toggle:hover { transform:scale(1.1);background:var(--verde-claro); }
.chatbot-toggle.open { animation:none;background:var(--terracota); }
@keyframes pulseBot {
    0%,100% { box-shadow:0 8px 24px rgba(42,74,30,0.35),0 0 0 0 rgba(42,74,30,0.2); }
    70%     { box-shadow:0 8px 24px rgba(42,74,30,0.35),0 0 0 12px rgba(42,74,30,0); }
}

/* ── Ventana del chat ────────────────────────────────────── */
.chatbot-window {
    position:fixed;bottom:10.5rem;right:2rem;z-index:1000;
    width:380px;max-height:520px;
    background:white;border-radius:24px;
    box-shadow:0 20px 60px rgba(0,0,0,0.15);
    display:none;flex-direction:column;
    overflow:hidden;border:1px solid rgba(42,74,30,0.08);
    animation:chatIn 0.3s ease;
}
.chatbot-window.open { display:flex; }
@keyframes chatIn { from { opacity:0;transform:translateY(20px) scale(0.95); } to { opacity:1;transform:translateY(0) scale(1); } }

/* ── Header ──────────────────────────────────────────────── */
.cb-header {
    background:var(--verde);color:white;padding:1.25rem 1.5rem;
    display:flex;align-items:center;gap:12px;
}
.cb-avatar {
    width:40px;height:40px;border-radius:50%;
    background:rgba(255,255,255,0.15);
    display:flex;align-items:center;justify-content:center;font-size:1.3rem;
}
.cb-header-info h4 { font-family:'Cormorant Garamond',serif;font-size:1.1rem;font-weight:600; }
.cb-header-info span { font-size:0.75rem;opacity:0.7; }
.cb-close {
    margin-left:auto;background:none;border:none;color:white;
    font-size:1.4rem;cursor:pointer;opacity:0.7;transition:opacity 0.2s;
}
.cb-close:hover { opacity:1; }

/* ── Mensajes ────────────────────────────────────────────── */
.cb-messages {
    flex:1;overflow-y:auto;padding:1.25rem;
    display:flex;flex-direction:column;gap:0.75rem;
    max-height:320px;min-height:200px;
    scrollbar-width:thin;scrollbar-color:rgba(42,74,30,0.15) transparent;
}
.cb-msg {
    max-width:85%;padding:0.75rem 1rem;border-radius:16px;
    font-size:0.875rem;line-height:1.5;
    animation:msgIn 0.3s ease;
}
@keyframes msgIn { from { opacity:0;transform:translateY(8px); } to { opacity:1;transform:translateY(0); } }

.cb-msg.bot {
    align-self:flex-start;
    background:var(--crema);color:var(--texto);
    border-bottom-left-radius:4px;
}
.cb-msg.user {
    align-self:flex-end;
    background:var(--verde);color:white;
    border-bottom-right-radius:4px;
}
.cb-msg.bot a { color:var(--verde);font-weight:500;text-decoration:none; }
.cb-msg.bot a:hover { text-decoration:underline; }

/* ── Opciones (botones) ──────────────────────────────────── */
.cb-options {
    display:flex;flex-wrap:wrap;gap:6px;margin-top:6px;
}
.cb-opt {
    background:white;color:var(--verde);
    border:1.5px solid rgba(42,74,30,0.2);
    padding:6px 14px;border-radius:100px;
    font-family:'DM Sans',sans-serif;font-size:0.8rem;font-weight:500;
    cursor:pointer;transition:all 0.2s;
}
.cb-opt:hover { background:var(--verde);color:white;border-color:var(--verde); }

/* ── Typing indicator ────────────────────────────────────── */
.cb-typing { display:flex;gap:4px;padding:0.75rem 1rem;align-self:flex-start; }
.cb-typing span {
    width:8px;height:8px;border-radius:50%;background:rgba(42,74,30,0.25);
    animation:typing 1.2s ease-in-out infinite;
}
.cb-typing span:nth-child(2) { animation-delay:0.2s; }
.cb-typing span:nth-child(3) { animation-delay:0.4s; }
@keyframes typing { 0%,100%{opacity:0.3;transform:translateY(0)}50%{opacity:1;transform:translateY(-4px)} }

/* ── Input ───────────────────────────────────────────────── */
.cb-input-wrap {
    display:flex;gap:8px;padding:1rem 1.25rem;
    border-top:1px solid rgba(42,74,30,0.08);
    background:white;
}
.cb-input {
    flex:1;padding:10px 16px;border-radius:100px;
    border:1.5px solid rgba(42,74,30,0.12);
    font-family:'DM Sans',sans-serif;font-size:0.85rem;
    outline:none;transition:border-color 0.2s;
}
.cb-input:focus { border-color:var(--verde); }
.cb-input::placeholder { color:var(--gris); }
.cb-send {
    background:var(--verde);color:white;border:none;
    width:40px;height:40px;border-radius:50%;
    cursor:pointer;font-size:1.1rem;
    display:flex;align-items:center;justify-content:center;
    transition:all 0.2s;flex-shrink:0;
}
.cb-send:hover { background:var(--verde-claro);transform:scale(1.05); }

/* ── Responsive ──────────────────────────────────────────── */
@media(max-width:480px){
    .chatbot-window { right:0.75rem;left:0.75rem;width:auto;bottom:9.5rem;max-height:65vh; }
}
</style>

{{-- Botón flotante del chatbot --}}
<button class="chatbot-toggle" id="chatbotToggle" title="¿Necesitas ayuda?">🌸</button>

{{-- Ventana del chat --}}
<div class="chatbot-window" id="chatbotWindow">
    <div class="cb-header">
        <div class="cb-avatar">🌺</div>
        <div class="cb-header-info">
            <h4>Floristería Bribri</h4>
            <span>Siempre lista para ayudarte 🌿</span>
        </div>
        <button class="cb-close" id="chatbotClose">✕</button>
    </div>
    <div class="cb-messages" id="chatMessages"></div>
    <div class="cb-input-wrap">
        <input type="text" class="cb-input" id="chatInput" placeholder="Escribe tu pregunta..." autocomplete="off">
        <button class="cb-send" id="chatSend">➤</button>
    </div>
</div>

<script>
(function() {
    // ── Elementos ────────────────────────────────────────
    const toggle   = document.getElementById('chatbotToggle');
    const win      = document.getElementById('chatbotWindow');
    const closeBtn = document.getElementById('chatbotClose');
    const messages = document.getElementById('chatMessages');
    const input    = document.getElementById('chatInput');
    const sendBtn  = document.getElementById('chatSend');
    let started = false;

    // ── Base de conocimiento (FAQ) ──────────────────────
    const faq = [
        {
            keys: ['horario','hora','abierto','abierta','abren','cierran','atienden','horarios'],
            answer: '🕐 <strong>Nuestro horario:</strong><br>Lunes a Sábado: 8:00 am — 6:00 pm<br>Domingos: 9:00 am — 2:00 pm'
        },
        {
            keys: ['envío','envio','domicilio','llevan','entregan','entrega','delivery','costo envío','costo envio'],
            answer: '🚗 <strong>Envío a domicilio:</strong> ₡3,000<br>Coordinamos por WhatsApp la hora y lugar.<br>🏪 <strong>Retiro en local:</strong> ¡Gratis!'
        },
        {
            keys: ['ubicación','ubicacion','dirección','direccion','donde','dónde','local','tienda','mapa'],
            answer: '📍 <strong>Estamos en Bribri, Talamanca, Limón.</strong><br><a href="https://maps.app.goo.gl/LibtXFayE1mNFFhL6" target="_blank">🗺️ Ver en Google Maps</a>'
        },
        {
            keys: ['pago','pagar','sinpe','transferencia','efectivo','tarjeta','forma de pago'],
            answer: '💰 <strong>Formas de pago:</strong><br>• Sinpe Móvil<br>• Transferencia bancaria<br>• Efectivo al retirar<br>Coordinamos el pago por WhatsApp 📱'
        },
        {
            keys: ['catálogo','catalogo','productos','flores','ramos','arreglos','plantas','que tienen','qué tienen'],
            answer: '🌸 Tenemos ramos, arreglos florales, plantas, flores para eventos y más.<br><a href="{{ route("catalogo") }}">Ver catálogo completo →</a>'
        },
        {
            keys: ['precio','precios','cuánto','cuanto','cuesta','valor','rango'],
            answer: '💐 Nuestros precios van desde <strong>₡12,000</strong> hasta <strong>₡35,000+</strong> dependiendo del arreglo.<br><a href="{{ route("catalogo") }}">Ver precios en el catálogo →</a>'
        },
        {
            keys: ['pedido','pedir','ordenar','orden','como pido','cómo pido','comprar','compra'],
            answer: '🛒 <strong>¡Es muy fácil!</strong><br>1. Elegí tus flores en el <a href="{{ route("catalogo") }}">catálogo</a><br>2. Agregalas al carrito<br>3. Confirmá tu pedido<br>4. Te contactamos por WhatsApp 💬'
        },
        {
            keys: ['whatsapp','contacto','teléfono','telefono','llamar','mensaje','escribir'],
            answer: '📱 <strong>WhatsApp:</strong> +506 8463-0055<br><a href="https://wa.me/{{ config("floristeria.whatsapp") }}" target="_blank">💬 Escribinos directo →</a>'
        },
        {
            keys: ['personalizar','personalizado','especial','custom','medida','dedicatoria','tarjeta'],
            answer: '✨ <strong>¡Sí!</strong> Podemos personalizar tu arreglo con tarjeta dedicatoria, colores específicos o pedidos especiales.<br>Contanos tu idea por <a href="https://wa.me/{{ config("floristeria.whatsapp") }}" target="_blank">WhatsApp</a> 💬'
        },
        {
            keys: ['evento','boda','matrimonio','cumpleaños','cumpleanos','aniversario','funeral'],
            answer: '💍 Hacemos arreglos para <strong>bodas, cumpleaños, aniversarios y eventos especiales</strong>.<br>Para pedidos grandes coordinamos por <a href="https://wa.me/{{ config("floristeria.whatsapp") }}" target="_blank">WhatsApp</a> 🌸'
        },
        {
            keys: ['hola','buenas','hey','hi','hello','buen día','buenas tardes','buenas noches'],
            answer: '¡Hola! 🌺 Bienvenid@ a Floristería Bribri. ¿En qué te puedo ayudar hoy?'
        },
        {
            keys: ['gracias','thanks','genial','perfecto','listo','ok','vale','chao','adiós','adios','bye'],
            answer: '¡Con mucho gusto! 🌸 Si necesitás algo más, aquí estoy. ¡Que tengás un lindo día! 💚'
        },
    ];

    // ── Opciones rápidas ────────────────────────────────
    const quickOptions = [
        { label: '🌸 Ver catálogo',    action: 'catalogo' },
        { label: '🚗 Envíos',          action: 'envio' },
        { label: '💰 Formas de pago',  action: 'pago' },
        { label: '📍 Ubicación',       action: 'ubicacion' },
        { label: '🕐 Horarios',        action: 'horario' },
        { label: '📱 WhatsApp',        action: 'whatsapp' },
    ];

    // ── Funciones de mensajes ───────────────────────────
    function addMsg(text, type = 'bot') {
        const div = document.createElement('div');
        div.className = `cb-msg ${type}`;
        div.innerHTML = text;
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
    }

    function addOptions(opts) {
        const wrap = document.createElement('div');
        wrap.className = 'cb-options';
        opts.forEach(o => {
            const btn = document.createElement('button');
            btn.className = 'cb-opt';
            btn.textContent = o.label;
            btn.onclick = () => handleOption(o);
            wrap.appendChild(btn);
        });
        messages.appendChild(wrap);
        messages.scrollTop = messages.scrollHeight;
    }

    function showTyping() {
        const t = document.createElement('div');
        t.className = 'cb-typing';
        t.id = 'cbTyping';
        t.innerHTML = '<span></span><span></span><span></span>';
        messages.appendChild(t);
        messages.scrollTop = messages.scrollHeight;
    }

    function hideTyping() {
        document.getElementById('cbTyping')?.remove();
    }

    function botReply(text, showOpts = true) {
        showTyping();
        setTimeout(() => {
            hideTyping();
            addMsg(text, 'bot');
            if (showOpts) {
                setTimeout(() => {
                    addMsg('¿Te puedo ayudar con algo más?', 'bot');
                    addOptions([
                        ...quickOptions.slice(0, 4),
                        { label: '💬 Hablar por WhatsApp', action: 'whatsapp_direct' }
                    ]);
                }, 400);
            }
        }, 600 + Math.random() * 400);
    }

    // ── Buscar respuesta ────────────────────────────────
    function findAnswer(text) {
        const lower = text.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
        for (const item of faq) {
            for (const key of item.keys) {
                const normalKey = key.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
                if (lower.includes(normalKey)) {
                    return item.answer;
                }
            }
        }
        return null;
    }

    // ── Manejar opción rápida ───────────────────────────
    function handleOption(opt) {
        // Eliminar botones anteriores
        messages.querySelectorAll('.cb-options').forEach(el => el.remove());

        if (opt.action === 'whatsapp_direct') {
            addMsg('Hablar por WhatsApp', 'user');
            botReply('¡Perfecto! Te redirijo a nuestro WhatsApp para atención personalizada 💬', false);
            setTimeout(() => {
                window.open('https://wa.me/{{ config("floristeria.whatsapp") }}?text=' +
                    encodeURIComponent('¡Hola! 🌺 Vengo del chatbot de la web y necesito ayuda.'), '_blank');
            }, 1200);
            return;
        }

        if (opt.action === 'catalogo') {
            addMsg('Ver catálogo', 'user');
            botReply('🌸 ¡Con gusto! Te llevo al catálogo.<br><a href="{{ route("catalogo") }}">Ver catálogo completo →</a>', true);
            return;
        }

        // Buscar en FAQ por la acción
        addMsg(opt.label.replace(/^[^\s]+\s/, ''), 'user');
        const answer = findAnswer(opt.action);
        if (answer) {
            botReply(answer);
        }
    }

    // ── Manejar texto libre ─────────────────────────────
    function handleUserInput() {
        const text = input.value.trim();
        if (!text) return;

        // Eliminar botones anteriores
        messages.querySelectorAll('.cb-options').forEach(el => el.remove());

        addMsg(text, 'user');
        input.value = '';

        const answer = findAnswer(text);
        if (answer) {
            botReply(answer);
        } else {
            // No encontró — ofrecer WhatsApp
            botReply(
                '🤔 No estoy segura de entender tu pregunta, pero no te preocupes.<br>' +
                'Podés <a href="https://wa.me/{{ config("floristeria.whatsapp") }}?text=' +
                encodeURIComponent('Hola! Tengo una consulta: ' + text) +
                '" target="_blank"><strong>escribirnos por WhatsApp</strong></a> y te ayudamos personalmente 💬',
                true
            );
        }
    }

    // ── Mensaje de bienvenida ───────────────────────────
    function startChat() {
        if (started) return;
        started = true;
        addMsg('¡Hola! 🌺 Soy la asistente de <strong>Floristería Bribri</strong>.<br>¿En qué puedo ayudarte hoy?', 'bot');
        setTimeout(() => {
            addMsg('Elegí una opción o escribí tu pregunta:', 'bot');
            addOptions(quickOptions);
        }, 500);
    }

    // ── Eventos ─────────────────────────────────────────
    toggle.addEventListener('click', () => {
        const isOpen = win.classList.toggle('open');
        toggle.classList.toggle('open', isOpen);
        toggle.textContent = isOpen ? '✕' : '🌸';
        if (isOpen) {
            startChat();
            setTimeout(() => input.focus(), 300);
        }
    });

    closeBtn.addEventListener('click', () => {
        win.classList.remove('open');
        toggle.classList.remove('open');
        toggle.textContent = '🌸';
    });

    sendBtn.addEventListener('click', handleUserInput);
    input.addEventListener('keydown', e => {
        if (e.key === 'Enter') handleUserInput();
    });
})();
</script>