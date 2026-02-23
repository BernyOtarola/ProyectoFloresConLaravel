<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        /* ══════════════════════════════════════════════════
           FLORISTERÍA BRIBRI — Catálogo PDF Premium
           ══════════════════════════════════════════════════ */

        @page {
            margin: 1.2cm 1.5cm;
            size: A4 portrait;
        }

        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1C1C1C;
            font-size: 9.5pt;
            line-height: 1.5;
            background: #FFFFFF;
        }

        /* ── Colores ──────────────────────────────── */
        .c-verde     { color:#2A4A1E; }
        .c-terracota { color:#C4714A; }
        .c-rosa      { color:#E8B4A0; }
        .c-gris      { color:#6B6B6B; }
        .bg-verde    { background:#2A4A1E; }
        .bg-crema    { background:#F8F5EE; }

        /* ════════════════════════════════════════════
           PORTADA
           ════════════════════════════════════════════ */
        .cover-page {
            page-break-after: always;
            position: relative;
            height: 100%;
            overflow: hidden;
        }

        .cover-bg {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(160deg, #2A4A1E 0%, #1a3312 40%, #2A4A1E 70%, #3d6a2c 100%);
        }

        /* Decoraciones de esquinas */
        .cover-deco-tl {
            position: absolute; top: 0; left: 0;
            width: 200pt; height: 200pt;
            border-bottom-right-radius: 100%;
            background: rgba(232,180,160,0.06);
        }
        .cover-deco-br {
            position: absolute; bottom: 0; right: 0;
            width: 250pt; height: 250pt;
            border-top-left-radius: 100%;
            background: rgba(196,113,74,0.05);
        }
        .cover-deco-line-top {
            position: absolute; top: 40pt; left: 40pt; right: 40pt;
            height: 0.5pt;
            background: rgba(255,255,255,0.08);
        }
        .cover-deco-line-bot {
            position: absolute; bottom: 40pt; left: 40pt; right: 40pt;
            height: 0.5pt;
            background: rgba(255,255,255,0.08);
        }

        .cover-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 80pt 50pt 60pt;
            color: white;
        }

        .cover-top-tag {
            font-size: 7.5pt;
            letter-spacing: 4pt;
            text-transform: uppercase;
            opacity: 0.5;
            margin-bottom: 40pt;
        }

        .cover-flower {
            font-size: 52pt;
            margin-bottom: 16pt;
            opacity: 0.9;
        }

        .cover-brand {
            font-size: 14pt;
            letter-spacing: 6pt;
            text-transform: uppercase;
            opacity: 0.4;
            margin-bottom: 6pt;
        }

        .cover-title {
            font-size: 38pt;
            font-weight: 300;
            letter-spacing: 1pt;
            margin-bottom: 4pt;
        }
        .cover-title span {
            color: #E8B4A0;
            font-style: italic;
        }

        .cover-divider {
            width: 50pt;
            height: 1.5pt;
            background: #C4714A;
            margin: 18pt auto;
        }

        .cover-subtitle {
            font-size: 10.5pt;
            opacity: 0.7;
            letter-spacing: 0.5pt;
            margin-bottom: 35pt;
            font-weight: 300;
        }

        .cover-badge {
            display: inline-block;
            border: 1pt solid rgba(255,255,255,0.2);
            padding: 8pt 24pt;
            border-radius: 50pt;
            font-size: 9.5pt;
            letter-spacing: 1pt;
            margin-bottom: 35pt;
        }

        .cover-info-grid {
            margin-top: 10pt;
        }
        .cover-info-grid table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
        }
        .cover-info-grid td {
            padding: 6pt 12pt;
            text-align: center;
            font-size: 8.5pt;
            opacity: 0.55;
            vertical-align: top;
        }
        .cover-info-grid .info-icon {
            font-size: 14pt;
            display: block;
            margin-bottom: 4pt;
            opacity: 0.7;
        }
        .cover-info-grid .info-value {
            font-size: 8.5pt;
            opacity: 1;
            color: rgba(255,255,255,0.8);
        }

        .cover-date {
            position: absolute;
            bottom: 55pt;
            left: 0; right: 0;
            text-align: center;
            font-size: 7.5pt;
            opacity: 0.35;
            letter-spacing: 0.5pt;
            font-style: italic;
        }

        /* ══════════════���═════════════════════════════
           PÁGINAS INTERIORES
           ════════════════════════════════════════════ */

        /* ── Encabezado de categoría ──────────────── */
        .cat-section {
            page-break-inside: avoid;
            margin-bottom: 18pt;
        }
        .cat-header-bar {
            background: #2A4A1E;
            color: white;
            padding: 14pt 18pt;
            border-radius: 10pt;
            margin-bottom: 14pt;
            position: relative;
            overflow: hidden;
        }
        .cat-header-bar::after {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 100pt; height: 100%;
            background: rgba(232,180,160,0.06);
            border-bottom-left-radius: 100%;
        }
        .cat-icon {
            font-size: 16pt;
            margin-bottom: 2pt;
        }
        .cat-name {
            font-size: 16pt;
            font-weight: 300;
            letter-spacing: 0.5pt;
        }
        .cat-name strong {
            font-weight: 600;
        }
        .cat-meta {
            display: flex;
            gap: 16pt;
            margin-top: 4pt;
        }
        .cat-desc {
            font-size: 8pt;
            opacity: 0.6;
            font-style: italic;
        }
        .cat-count {
            font-size: 7pt;
            text-transform: uppercase;
            letter-spacing: 1.5pt;
            opacity: 0.5;
            background: rgba(255,255,255,0.1);
            padding: 2pt 8pt;
            border-radius: 20pt;
            display: inline-block;
            margin-top: 4pt;
        }

        /* ── Tarjeta de producto ──────────────────── */
        .products-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8pt;
        }
        .product-row {
            page-break-inside: avoid;
        }
        .product-card {
            background: #FAFAF6;
            border: 0.5pt solid rgba(42,74,30,0.08);
            border-radius: 10pt;
            padding: 14pt 16pt;
        }
        .product-card-inner {
            width: 100%;
            border-collapse: collapse;
        }
        .product-card-inner td {
            vertical-align: middle;
            padding: 0;
        }

        .p-left { width: 62%; padding-right: 14pt; }
        .p-right { width: 38%; text-align: right; }

        .p-name {
            font-size: 11.5pt;
            font-weight: 600;
            color: #2A4A1E;
            margin-bottom: 3pt;
        }
        .p-badge-dest {
            display: inline-block;
            background: #C4714A;
            color: white;
            font-size: 6pt;
            padding: 2pt 7pt;
            border-radius: 20pt;
            text-transform: uppercase;
            letter-spacing: 0.8pt;
            margin-left: 4pt;
            vertical-align: middle;
        }
        .p-desc {
            font-size: 8.5pt;
            color: #6B6B6B;
            line-height: 1.6;
            margin-top: 2pt;
        }
        .p-tags {
            margin-top: 6pt;
        }
        .p-tag-cat {
            display: inline-block;
            font-size: 6.5pt;
            color: #C4714A;
            text-transform: uppercase;
            letter-spacing: 1pt;
            border: 0.5pt solid rgba(196,113,74,0.3);
            padding: 2pt 8pt;
            border-radius: 20pt;
        }

        .p-price-box {
            text-align: right;
        }
        .p-price-label {
            font-size: 6.5pt;
            color: #6B6B6B;
            text-transform: uppercase;
            letter-spacing: 0.8pt;
            margin-bottom: 2pt;
        }
        .p-price {
            font-size: 18pt;
            font-weight: 700;
            color: #2A4A1E;
            line-height: 1.1;
        }
        .p-price-currency {
            font-size: 10pt;
            font-weight: 400;
            vertical-align: top;
        }
        .p-stock {
            font-size: 7.5pt;
            margin-top: 5pt;
            padding: 2pt 10pt;
            border-radius: 20pt;
            display: inline-block;
        }
        .stock-ok  { background:rgba(74,122,53,0.1); color:#4A7A35; }
        .stock-low { background:rgba(196,113,74,0.1); color:#C4714A; }
        .stock-out { background:rgba(220,53,69,0.1);  color:#dc3545; }

        /* ── Separador decorativo ─────────────────── */
        .section-divider {
            text-align: center;
            margin: 24pt 0 20pt;
            color: rgba(42,74,30,0.15);
            font-size: 8pt;
            letter-spacing: 6pt;
        }

        /* ════════════════════════════════════════════
           PÁGINA DE CONTACTO (última)
           ════════════════════════════════════════════ */
        .contact-page {
            page-break-before: always;
            padding-top: 30pt;
        }

        .contact-hero {
            background: #2A4A1E;
            color: white;
            border-radius: 14pt;
            padding: 30pt;
            text-align: center;
            position: relative;
            overflow: hidden;
            margin-bottom: 20pt;
        }
        .contact-hero::before {
            content: '';
            position: absolute;
            top: -30pt; left: -30pt;
            width: 120pt; height: 120pt;
            border-radius: 50%;
            background: rgba(232,180,160,0.06);
        }
        .contact-hero::after {
            content: '';
            position: absolute;
            bottom: -40pt; right: -20pt;
            width: 150pt; height: 150pt;
            border-radius: 50%;
            background: rgba(196,113,74,0.04);
        }
        .contact-hero-inner {
            position: relative;
            z-index: 2;
        }
        .contact-emoji { font-size: 30pt; margin-bottom: 8pt; }
        .contact-title {
            font-size: 22pt;
            font-weight: 300;
            margin-bottom: 4pt;
        }
        .contact-title span { color:#E8B4A0; font-style:italic; }
        .contact-sub {
            font-size: 9pt;
            opacity: 0.6;
            margin-bottom: 0;
        }

        /* Tarjetas de contacto */
        .contact-cards {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10pt 0;
        }
        .contact-card {
            background: #F8F5EE;
            border-radius: 10pt;
            padding: 18pt 14pt;
            text-align: center;
            width: 33.33%;
            vertical-align: top;
        }
        .cc-icon { font-size: 20pt; margin-bottom: 6pt; }
        .cc-label {
            font-size: 6.5pt;
            text-transform: uppercase;
            letter-spacing: 1.5pt;
            color: #6B6B6B;
            margin-bottom: 4pt;
        }
        .cc-value {
            font-size: 9.5pt;
            font-weight: 600;
            color: #2A4A1E;
        }
        .cc-extra {
            font-size: 7.5pt;
            color: #6B6B6B;
            margin-top: 3pt;
        }

        /* Info extra */
        .extra-info {
            background: white;
            border: 0.5pt solid rgba(42,74,30,0.08);
            border-radius: 10pt;
            padding: 16pt 20pt;
            margin-top: 14pt;
        }
        .extra-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .extra-info td {
            padding: 8pt 10pt;
            font-size: 8.5pt;
            vertical-align: middle;
            border-bottom: 0.5pt solid rgba(42,74,30,0.05);
        }
        .extra-info tr:last-child td { border-bottom: none; }
        .ei-icon { font-size: 12pt; width: 28pt; text-align: center; }
        .ei-label { color:#6B6B6B; width:80pt; font-size:7.5pt; text-transform:uppercase; letter-spacing:0.8pt; }
        .ei-value { color:#2A4A1E; font-weight:500; }

        /* Frase final */
        .final-note {
            text-align: center;
            margin-top: 24pt;
            padding: 16pt;
            border-top: 0.5pt solid rgba(42,74,30,0.08);
        }
        .final-note .flower { font-size: 14pt; margin-bottom: 6pt; }
        .final-note p {
            font-size: 9pt;
            color: #2A4A1E;
            font-style: italic;
            font-weight: 300;
        }
        .final-note .copy {
            font-size: 7pt;
            color: #999;
            margin-top: 8pt;
            font-style: normal;
        }

        /* ── Page break helper ────────────────────── */
        .page-break { page-break-before: always; }
    </style>
</head>
<body>

    <!-- ═══════════════════════════════════════════
         PORTADA
         ═══════════════════════════════════════════ -->
    <div class="cover-page">
        <div class="cover-bg">
            <div class="cover-deco-tl"></div>
            <div class="cover-deco-br"></div>
            <div class="cover-deco-line-top"></div>
            <div class="cover-deco-line-bot"></div>
        </div>

        <div class="cover-content">
            <div class="cover-top-tag">Costa Rica &nbsp;&bull;&nbsp; Bribri &nbsp;&bull;&nbsp; Talamanca</div>

            <div class="cover-flower">🌺</div>

            <div class="cover-brand">F L O R I S T E R &Iacute; A</div>
            <div class="cover-title">Floristería <span>Bribri</span></div>

            <div class="cover-divider"></div>

            <div class="cover-subtitle">Flores frescas con amor desde Costa Rica</div>

            <div class="cover-badge">&#x1F4CB; &nbsp; Cat&aacute;logo {{ date('Y') }} &nbsp; &bull; &nbsp; {{ $totalProductos }} productos</div>

            <div class="cover-info-grid">
                <table>
                    <tr>
                        <td>
                            <span class="info-icon">&#x1F4F1;</span>
                            <span class="info-value">+506 8463-0055</span>
                        </td>
                        <td>
                            <span class="info-icon">&#x1F4CD;</span>
                            <span class="info-value">Bribri, Talamanca</span>
                        </td>
                        <td>
                            <span class="info-icon">&#x1F552;</span>
                            <span class="info-value">L-S 8am &ndash; 6pm</span>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="cover-date">
                Actualizado &bull; {{ now()->translatedFormat('d \d\e F, Y') }}
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════
         CATÁLOGO POR CATEGORÍA
         ═══════════════════════════════════════════ -->
    @php $icons = ['🌹','💐','🪴','💍','🌸','🌺','🌻','🌷']; @endphp

    @foreach($categorias as $catIndex => $cat)
        @if($catIndex > 0 && $catIndex % 2 === 0)
            <div class="page-break"></div>
        @endif

        <div class="cat-section">
            <div class="cat-header-bar">
                <div class="cat-icon">{{ $icons[$catIndex % count($icons)] }}</div>
                <div class="cat-name"><strong>{{ $cat->nombre }}</strong></div>
                @if($cat->descripcion)
                    <div class="cat-desc">{{ $cat->descripcion }}</div>
                @endif
                <div class="cat-count">{{ $cat->productos->count() }} producto{{ $cat->productos->count() !== 1 ? 's' : '' }}</div>
            </div>

            <table class="products-grid">
                @foreach($cat->productos as $p)
                <tr class="product-row">
                    <td>
                        <div class="product-card">
                            <table class="product-card-inner">
                                <tr>
                                    <td class="p-left">
                                        <div class="p-name">
                                            {{ $p->nombre }}
                                            @if($p->destacado)
                                                <span class="p-badge-dest">&#x2B50; Destacado</span>
                                            @endif
                                        </div>
                                        <div class="p-desc">{{ $p->descripcion ?: 'Producto de la más alta calidad.' }}</div>
                                        <div class="p-tags">
                                            <span class="p-tag-cat">{{ $cat->nombre }}</span>
                                        </div>
                                    </td>
                                    <td class="p-right">
                                        <div class="p-price-box">
                                            <div class="p-price-label">Precio</div>
                                            <div class="p-price">
                                                <span class="p-price-currency">&#x20A1;</span>{{ number_format($p->precio, 0, ',', '.') }}
                                            </div>
                                            <div>
                                                @if($p->stock > 10)
                                                    <span class="p-stock stock-ok">&#x2705; Disponible</span>
                                                @elseif($p->stock > 0)
                                                    <span class="p-stock stock-low">&#x26A0;&#xFE0F; Pocas unidades</span>
                                                @else
                                                    <span class="p-stock stock-out">&#x274C; Agotado</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>

        @if(!$loop->last)
            <div class="section-divider">&#x2022; &nbsp; &#x2022; &nbsp; &#x2022;</div>
        @endif
    @endforeach

    <!-- ═══════════════════════════════════════════
         PÁGINA DE CONTACTO
         ═══════════════════════════════════════════ -->
    <div class="contact-page">
        <div class="contact-hero">
            <div class="contact-hero-inner">
                <div class="contact-emoji">&#x1F338;</div>
                <div class="contact-title">&iquest;Te gust&oacute; algo? <span>&iexcl;Ped&iacute; ya!</span></div>
                <div class="contact-sub">Hac&eacute; tu pedido por WhatsApp, visit&aacute; nuestra tienda o compr&aacute; en la web</div>
            </div>
        </div>

        <table class="contact-cards">
            <tr>
                <td class="contact-card">
                    <div class="cc-icon">&#x1F4F1;</div>
                    <div class="cc-label">WhatsApp</div>
                    <div class="cc-value">+506 8463-0055</div>
                    <div class="cc-extra">Respond. inmediata</div>
                </td>
                <td class="contact-card">
                    <div class="cc-icon">&#x1F4CD;</div>
                    <div class="cc-label">Ubicaci&oacute;n</div>
                    <div class="cc-value">Bribri, Talamanca</div>
                    <div class="cc-extra">Lim&oacute;n, Costa Rica</div>
                </td>
                <td class="contact-card">
                    <div class="cc-icon">&#x1F4E7;</div>
                    <div class="cc-label">Correo</div>
                    <div class="cc-value" style="font-size:8pt;">{{ config('floristeria.admin_email') }}</div>
                    <div class="cc-extra">Consultas generales</div>
                </td>
            </tr>
        </table>

        <div class="extra-info">
            <table>
                <tr>
                    <td class="ei-icon">&#x1F552;</td>
                    <td class="ei-label">Horario</td>
                    <td class="ei-value">Lunes a S&aacute;bado: 8:00 am &ndash; 6:00 pm &nbsp;&bull;&nbsp; Domingos: 9:00 am &ndash; 2:00 pm</td>
                </tr>
                <tr>
                    <td class="ei-icon">&#x1F697;</td>
                    <td class="ei-label">Env&iacute;o</td>
                    <td class="ei-value">Domicilio: &#x20A1;3,000 &nbsp;&bull;&nbsp; Retiro en local: &iexcl;Gratis!</td>
                </tr>
                <tr>
                    <td class="ei-icon">&#x1F4B0;</td>
                    <td class="ei-label">Pago</td>
                    <td class="ei-value">Sinpe M&oacute;vil &nbsp;&bull;&nbsp; Transferencia &nbsp;&bull;&nbsp; Efectivo</td>
                </tr>
                <tr>
                    <td class="ei-icon">&#x2728;</td>
                    <td class="ei-label">Especial</td>
                    <td class="ei-value">Personalizamos arreglos para bodas, cumplea&ntilde;os y eventos</td>
                </tr>
            </table>
        </div>

        <div class="final-note">
            <div class="flower">&#x1F33A; &#x1F33B; &#x1F337;</div>
            <p>&ldquo;Cada flor que entregamos lleva un pedacito de Bribri y mucho amor costarricense&rdquo;</p>
            <div class="copy">
                &copy; {{ date('Y') }} Floristería Bribri &nbsp;&bull;&nbsp; Todos los derechos reservados
                <br>Catálogo generado el {{ now()->translatedFormat('d/m/Y') }} &nbsp;&bull;&nbsp; floristeriabribri.com
            </div>
        </div>
    </div>

</body>
</html>