<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        /* ══════════════════════════════════════════════════
           FLORISTERÍA BRIBRI — Catálogo PDF v2
           ══════════════════════════════════════════════════
           Compatible con DomPDF (sin gradients, sin opacity,
           sin ::before/::after, sin overflow:hidden)
           ══════════════════════════════════════════════════ */

        @page {
            margin: 1.2cm 1.5cm 1.8cm;
            size: A4 portrait;

            @bottom-center {
                content: "Floristería Bribri  •  floristeriabribri.com";
                font-family: Helvetica, Arial, sans-serif;
                font-size: 7pt;
                color: #aaaaaa;
            }
            @bottom-right {
                content: counter(page);
                font-family: Helvetica, Arial, sans-serif;
                font-size: 7pt;
                color: #aaaaaa;
            }
        }

        @page :first {
            @bottom-center { content: ""; }
            @bottom-right  { content: ""; }
        }

        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1C1C1C;
            font-size: 9.5pt;
            line-height: 1.5;
            background: #FFFFFF;
        }

        /* ════════════════════════════════════════════
           PORTADA  (DomPDF-safe: sin gradient, sin opacity)
           ════════════════════════════════════════════ */
        .cover-page {
            page-break-after: always;
            background: #2A4A1E;
            color: white;
            /* Altura fija equivalente a una página A4 */
            min-height: 780pt;
            position: relative;
            text-align: center;
            padding: 0;
        }

        /* Banda decorativa superior en terracota */
        .cover-stripe-top {
            background: #C4714A;
            height: 6pt;
            width: 100%;
        }

        /* Banda decorativa inferior */
        .cover-stripe-bot {
            background: #C4714A;
            height: 3pt;
            width: 100%;
            margin-top: 14pt;
        }

        /* Bloque crema decorativo en esquina superior derecha */
        .cover-corner {
            position: absolute;
            top: 6pt; right: 0;
            width: 120pt; height: 120pt;
            background: rgba(232,180,160,0.07);
            border-bottom-left-radius: 120pt;
        }

        .cover-content {
            padding: 55pt 50pt 50pt;
            position: relative;
        }

        .cover-top-tag {
            font-size: 7.5pt;
            letter-spacing: 4pt;
            text-transform: uppercase;
            color: rgba(255,255,255,0.45);
            margin-bottom: 36pt;
        }

        .cover-flower {
            font-size: 50pt;
            margin-bottom: 14pt;
        }

        .cover-brand {
            font-size: 13pt;
            letter-spacing: 6pt;
            text-transform: uppercase;
            color: rgba(255,255,255,0.35);
            margin-bottom: 5pt;
        }

        .cover-title {
            font-size: 36pt;
            font-weight: 300;
            letter-spacing: 1pt;
            margin-bottom: 4pt;
            color: #ffffff;
        }
        .cover-title span {
            color: #E8B4A0;
            font-style: italic;
        }

        .cover-divider {
            width: 50pt;
            height: 1.5pt;
            background: #C4714A;
            margin: 16pt auto;
        }

        .cover-subtitle {
            font-size: 10pt;
            color: rgba(255,255,255,0.65);
            letter-spacing: 0.5pt;
            margin-bottom: 32pt;
            font-weight: 300;
        }

        /* Badge oval de catálogo */
        .cover-badge {
            display: inline-block;
            border: 1pt solid rgba(255,255,255,0.2);
            padding: 8pt 26pt;
            border-radius: 50pt;
            font-size: 9.5pt;
            letter-spacing: 1pt;
            margin-bottom: 36pt;
            color: rgba(255,255,255,0.85);
        }

        /* Grid de info de contacto en portada */
        .cover-info-grid table {
            width: 78%;
            margin: 0 auto;
            border-collapse: collapse;
        }
        .cover-info-grid td {
            padding: 6pt 12pt;
            text-align: center;
            font-size: 8.5pt;
            color: rgba(255,255,255,0.5);
            vertical-align: top;
        }
        .cover-info-grid .info-icon {
            font-size: 14pt;
            display: block;
            margin-bottom: 4pt;
            color: rgba(255,255,255,0.65);
        }
        .cover-info-grid .info-value {
            font-size: 8.5pt;
            color: rgba(255,255,255,0.8);
        }

        /* Sitio web en portada */
        .cover-website {
            margin-top: 28pt;
            font-size: 8pt;
            color: rgba(255,255,255,0.3);
            letter-spacing: 1pt;
        }

        .cover-date {
            margin-top: 8pt;
            font-size: 7.5pt;
            color: rgba(255,255,255,0.28);
            font-style: italic;
        }

        /* ════════════════════════════════════════════
           TABLA DE CONTENIDOS
           ════════════════════════════════════════════ */
        .toc-page {
            page-break-after: always;
            padding: 20pt 10pt;
        }

        .toc-header {
            border-bottom: 1.5pt solid #2A4A1E;
            padding-bottom: 10pt;
            margin-bottom: 18pt;
        }
        .toc-header-title {
            font-size: 18pt;
            font-weight: 300;
            color: #2A4A1E;
        }
        .toc-header-title span {
            color: #C4714A;
            font-style: italic;
        }
        .toc-header-sub {
            font-size: 8pt;
            color: #999;
            margin-top: 3pt;
        }

        .toc-table {
            width: 100%;
            border-collapse: collapse;
        }
        .toc-table td {
            padding: 9pt 8pt;
            vertical-align: middle;
            border-bottom: 0.5pt solid rgba(42,74,30,0.07);
        }
        .toc-num {
            width: 22pt;
            font-size: 8pt;
            color: #C4714A;
            font-weight: 700;
            text-align: center;
        }
        .toc-icon {
            width: 20pt;
            font-size: 13pt;
        }
        .toc-cat-name {
            font-size: 11pt;
            color: #2A4A1E;
            font-weight: 500;
        }
        .toc-cat-desc {
            font-size: 7.5pt;
            color: #999;
            margin-top: 1pt;
        }
        .toc-count {
            text-align: right;
            font-size: 7.5pt;
            color: #C4714A;
            white-space: nowrap;
        }
        .toc-dots {
            /* Puntos entre nombre y cantidad — simulado con borde */
            border-bottom: 1pt dotted rgba(42,74,30,0.15);
        }

        /* Resumen de totales en TOC */
        .toc-summary {
            margin-top: 20pt;
            background: #F8F5EE;
            border-radius: 8pt;
            padding: 14pt 18pt;
        }
        .toc-summary table {
            width: 100%;
            border-collapse: collapse;
        }
        .toc-summary td {
            padding: 4pt 10pt;
            font-size: 8.5pt;
            text-align: center;
            vertical-align: top;
        }
        .ts-num {
            font-size: 20pt;
            font-weight: 700;
            color: #2A4A1E;
            line-height: 1.1;
            display: block;
        }
        .ts-label {
            font-size: 6.5pt;
            text-transform: uppercase;
            letter-spacing: 1pt;
            color: #999;
        }
        .ts-divider {
            color: rgba(42,74,30,0.12);
            font-size: 18pt;
            vertical-align: middle;
        }

        /* ════════════════════════════════════════════
           ENCABEZADO DE CATEGORÍA
           ════════════════════════════════════════════ */
        .cat-section {
            margin-bottom: 18pt;
        }

        .cat-header-bar {
            background: #2A4A1E;
            color: white;
            padding: 14pt 18pt;
            border-radius: 10pt;
            margin-bottom: 14pt;
        }
        /* Acento terracota a la izquierda */
        .cat-header-inner {
            border-left: 3pt solid #C4714A;
            padding-left: 12pt;
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
        .cat-name strong { font-weight: 700; }
        .cat-desc {
            font-size: 8pt;
            color: rgba(255,255,255,0.6);
            font-style: italic;
            margin-top: 3pt;
        }
        .cat-count {
            font-size: 7pt;
            text-transform: uppercase;
            letter-spacing: 1.5pt;
            color: rgba(255,255,255,0.5);
            background: rgba(255,255,255,0.1);
            padding: 2pt 8pt;
            border-radius: 20pt;
            display: inline-block;
            margin-top: 5pt;
        }

        /* ════════════════════════════════════════════
           TARJETAS DE PRODUCTO
           ════════════════════════════════════════════ */
        .products-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 9pt;
        }
        .product-row {
            page-break-inside: avoid;
        }

        /* Tarjeta con acento izquierdo verde */
        .product-card {
            background: #FAFAF6;
            border: 0.5pt solid rgba(42,74,30,0.09);
            border-radius: 10pt;
            padding: 0;
        }
        .product-card-accent {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        /* Columna de acento de color */
        .p-accent-col {
            display: table-cell;
            width: 5pt;
            background: #2A4A1E;
            border-radius: 10pt 0 0 10pt;
            vertical-align: top;
        }
        .p-accent-col.destacado {
            background: #C4714A;
        }
        .p-body-col {
            display: table-cell;
            padding: 13pt 15pt;
            vertical-align: top;
        }

        .product-card-inner {
            width: 100%;
            border-collapse: collapse;
        }
        .product-card-inner td {
            vertical-align: middle;
            padding: 0;
        }

        /* Columna imagen */
        .p-img-col {
            width: 52pt;
            padding-right: 12pt;
            vertical-align: middle;
        }
        .p-img-col img {
            width: 48pt;
            height: 48pt;
            object-fit: cover;
            border-radius: 6pt;
            border: 0.5pt solid rgba(42,74,30,0.1);
        }
        .p-img-placeholder {
            width: 48pt;
            height: 48pt;
            border-radius: 6pt;
            background: #EEE9DF;
            text-align: center;
            vertical-align: middle;
            font-size: 20pt;
            line-height: 48pt;
            border: 0.5pt solid rgba(42,74,30,0.08);
        }

        .p-left { width: 58%; padding-right: 12pt; }
        .p-right { width: 30%; text-align: right; vertical-align: middle; }

        .p-name {
            font-size: 11.5pt;
            font-weight: 700;
            color: #2A4A1E;
            margin-bottom: 3pt;
        }
        .p-badge-dest {
            display: inline-block;
            background: #C4714A;
            color: white;
            font-size: 5.5pt;
            padding: 1.5pt 7pt;
            border-radius: 20pt;
            text-transform: uppercase;
            letter-spacing: 0.8pt;
            margin-left: 5pt;
            vertical-align: middle;
        }
        .p-badge-nuevo {
            display: inline-block;
            background: #4A7A35;
            color: white;
            font-size: 5.5pt;
            padding: 1.5pt 7pt;
            border-radius: 20pt;
            text-transform: uppercase;
            letter-spacing: 0.8pt;
            margin-left: 5pt;
            vertical-align: middle;
        }
        .p-desc {
            font-size: 8.5pt;
            color: #6B6B6B;
            line-height: 1.6;
            margin-top: 2pt;
        }
        .p-tags {
            margin-top: 7pt;
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

        /* Precio y stock */
        .p-price-box { text-align: right; }
        .p-price-label {
            font-size: 6.5pt;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.8pt;
            margin-bottom: 2pt;
        }
        .p-price {
            font-size: 17pt;
            font-weight: 700;
            color: #2A4A1E;
            line-height: 1.1;
        }
        .p-price-currency {
            font-size: 9.5pt;
            font-weight: 400;
            vertical-align: top;
            margin-top: 1pt;
        }
        .p-stock {
            font-size: 7pt;
            margin-top: 6pt;
            padding: 2pt 9pt;
            border-radius: 20pt;
            display: inline-block;
        }
        .stock-ok  { background: #E8F3E5; color: #3a7a26; }
        .stock-low { background: #FBF0E8; color: #C4714A; }
        .stock-out { background: #FDEAEA; color: #c0392b; }

        /* Número de producto (ID / SKU) */
        .p-sku {
            font-size: 6.5pt;
            color: #bbb;
            margin-top: 6pt;
        }

        /* ── Separador decorativo ─────────────────── */
        .section-divider {
            text-align: center;
            margin: 22pt 0 18pt;
            color: rgba(42,74,30,0.15);
            font-size: 9pt;
            letter-spacing: 6pt;
        }

        /* ════════════════════════════════════════════
           PÁGINA DE CONTACTO
           ════════════════════════════════════════════ */
        .contact-page {
            page-break-before: always;
            padding-top: 26pt;
        }

        .contact-hero {
            background: #2A4A1E;
            color: white;
            border-radius: 14pt;
            padding: 28pt 30pt;
            text-align: center;
            margin-bottom: 18pt;
            /* Banda terracota lateral izquierda */
            border-left: 6pt solid #C4714A;
        }
        .contact-emoji { font-size: 28pt; margin-bottom: 8pt; }
        .contact-title {
            font-size: 21pt;
            font-weight: 300;
            margin-bottom: 5pt;
        }
        .contact-title span { color: #E8B4A0; font-style: italic; }
        .contact-sub {
            font-size: 9pt;
            color: rgba(255,255,255,0.6);
        }

        /* Tarjetas de contacto (3 columnas) */
        .contact-cards {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10pt 0;
        }
        .contact-card {
            background: #F8F5EE;
            border-radius: 10pt;
            padding: 16pt 12pt;
            text-align: center;
            width: 33.33%;
            vertical-align: top;
            border-top: 3pt solid #2A4A1E;
        }
        .cc-icon { font-size: 18pt; margin-bottom: 5pt; }
        .cc-label {
            font-size: 6.5pt;
            text-transform: uppercase;
            letter-spacing: 1.5pt;
            color: #999;
            margin-bottom: 4pt;
        }
        .cc-value {
            font-size: 9.5pt;
            font-weight: 700;
            color: #2A4A1E;
        }
        .cc-extra {
            font-size: 7.5pt;
            color: #999;
            margin-top: 3pt;
        }

        /* Info extra */
        .extra-info {
            background: white;
            border: 0.5pt solid rgba(42,74,30,0.09);
            border-radius: 10pt;
            padding: 14pt 18pt;
            margin-top: 14pt;
        }
        .extra-info table { width: 100%; border-collapse: collapse; }
        .extra-info td {
            padding: 8pt 10pt;
            font-size: 8.5pt;
            vertical-align: middle;
            border-bottom: 0.5pt solid rgba(42,74,30,0.05);
        }
        .extra-info tr:last-child td { border-bottom: none; }
        .ei-icon { font-size: 12pt; width: 28pt; text-align: center; }
        .ei-label {
            color: #999;
            width: 80pt;
            font-size: 7.5pt;
            text-transform: uppercase;
            letter-spacing: 0.8pt;
        }
        .ei-value { color: #2A4A1E; font-weight: 600; }

        /* Frase final */
        .final-note {
            text-align: center;
            margin-top: 22pt;
            padding: 14pt;
            border-top: 0.5pt solid rgba(42,74,30,0.08);
        }
        .final-note .flower { font-size: 13pt; margin-bottom: 6pt; }
        .final-note p {
            font-size: 9pt;
            color: #2A4A1E;
            font-style: italic;
            font-weight: 300;
        }
        .final-note .copy {
            font-size: 7pt;
            color: #bbb;
            margin-top: 8pt;
        }

        /* ── Page break helper ────────────────────── */
        .page-break { page-break-before: always; }

        /* ════════════════════════════════════════════
           INTERACTIVIDAD — Links, Bookmarks, Anclas
           ════════════════════════════════════════════ */

        /* Links sin subrayado por defecto */
        a { color: inherit; text-decoration: none; }

        /* Link de WhatsApp clickeable */
        a.link-wa { color: #2A4A1E; font-weight: 700; text-decoration: underline; text-decoration-color: rgba(42,74,30,0.3); }

        /* Link del sitio web */
        a.link-web { color: #C4714A; text-decoration: underline; }

        /* Links del índice (TOC → sección de categoría) */
        a.toc-link { color: #2A4A1E; text-decoration: none; display: block; }

        /* Bookmarks de navegación para cada categoría (panel del visor PDF) */
        .cat-bookmark {
            -dompdf-bookmark-label: attr(data-cat);
            -dompdf-bookmark-level: 1;
        }

        /* Botones de acción en página de contacto */
        .btn-wa {
            display: inline-block;
            background: #25D366;
            color: white;
            padding: 8pt 22pt;
            border-radius: 50pt;
            font-size: 9pt;
            font-weight: 700;
            margin-top: 14pt;
            letter-spacing: 0.5pt;
        }
        .btn-web-cta {
            display: inline-block;
            background: #2A4A1E;
            color: white;
            padding: 8pt 22pt;
            border-radius: 50pt;
            font-size: 9pt;
            font-weight: 700;
            margin-top: 14pt;
            margin-left: 10pt;
            letter-spacing: 0.5pt;
        }

        /* Placeholder de imagen más elegante */
        .p-img-placeholder {
            width: 48pt;
            height: 48pt;
            border-radius: 6pt;
            background: #EEE9DF;
            text-align: center;
            line-height: 48pt;
            font-size: 22pt;
            border: 1pt dashed rgba(42,74,30,0.2);
        }
    </style>
</head>
<body>

    {{-- ═══════════════════════════════════════════
         PORTADA
         ═══════════════════════════════════════════ --}}
    <div class="cover-page">
        <div class="cover-stripe-top"></div>
        <div class="cover-corner"></div>

        <div class="cover-content">
            <div class="cover-top-tag">Costa Rica &nbsp;&bull;&nbsp; Bribri &nbsp;&bull;&nbsp; Talamanca</div>

            <div class="cover-flower">&#x1F33A;</div>

            <div class="cover-brand">F L O R I S T E R &Iacute; A</div>
            <div class="cover-title">Floristería <span>Bribri</span></div>

            <div class="cover-divider"></div>

            <div class="cover-subtitle">Flores frescas con amor desde Costa Rica</div>

            <div class="cover-badge">
                &#x1F4CB; &nbsp; Cat&aacute;logo {{ date('Y') }} &nbsp; &bull; &nbsp; {{ $totalProductos }} productos
            </div>

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

            <div class="cover-website">
                <a href="https://floristeriabribri.com" style="color:rgba(255,255,255,0.3); text-decoration:none;">
                    floristeriabribri.com
                </a>
            </div>
            <div class="cover-date">
                Actualizado &bull; {{ now()->translatedFormat('d \d\e F, Y') }}
            </div>
        </div>

        <div class="cover-stripe-bot"></div>
    </div>

    {{-- ═══════════════════════════════════════════
         TABLA DE CONTENIDOS
         ═══════════════════════════════════════════ --}}
    @php
        $icons = ['&#x1F339;','&#x1F490;','&#x1FAB4;','&#x1F48D;','&#x1F338;','&#x1F33A;','&#x1F33B;','&#x1F337;'];
        $totalStock = 0;
        $totalDestacados = 0;
        foreach($categorias as $cat) {
            foreach($cat->productos as $p) {
                $totalStock += $p->stock;
                if($p->destacado) $totalDestacados++;
            }
        }
    @endphp

    <div class="toc-page">
        <div class="toc-header">
            <div class="toc-header-title">Índice de <span>Categorías</span></div>
            <div class="toc-header-sub">Catálogo {{ date('Y') }} — {{ $categorias->count() }} categorías disponibles</div>
        </div>

        <table class="toc-table">
            @foreach($categorias as $catIndex => $cat)
            <tr>
                <td class="toc-num">{{ str_pad($catIndex + 1, 2, '0', STR_PAD_LEFT) }}</td>
                <td class="toc-icon">{!! $icons[$catIndex % count($icons)] !!}</td>
                <td>
                    {{-- Link interno hacia la sección de la categoría --}}
                    <a class="toc-link" href="#cat-{{ $cat->id }}">
                        <div class="toc-cat-name">{{ $cat->nombre }}</div>
                        @if($cat->descripcion)
                            <div class="toc-cat-desc">{{ $cat->descripcion }}</div>
                        @endif
                    </a>
                </td>
                <td class="toc-count">
                    <a class="toc-link" href="#cat-{{ $cat->id }}" style="color:#C4714A;">
                        {{ $cat->productos->count() }} producto{{ $cat->productos->count() !== 1 ? 's' : '' }}
                    </a>
                </td>
            </tr>
            @endforeach
        </table>

        {{-- Resumen de totales --}}
        <div class="toc-summary">
            <table>
                <tr>
                    <td>
                        <span class="ts-num">{{ $categorias->count() }}</span>
                        <span class="ts-label">Categorías</span>
                    </td>
                    <td class="ts-divider">|</td>
                    <td>
                        <span class="ts-num">{{ $totalProductos }}</span>
                        <span class="ts-label">Productos</span>
                    </td>
                    <td class="ts-divider">|</td>
                    <td>
                        <span class="ts-num">{{ $totalDestacados }}</span>
                        <span class="ts-label">Destacados</span>
                    </td>
                    <td class="ts-divider">|</td>
                    <td>
                        <span class="ts-num">{{ $totalStock }}</span>
                        <span class="ts-label">Uds. en stock</span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         CATÁLOGO POR CATEGORÍA
         ═══════════════════════════════════════════ --}}

    @foreach($categorias as $catIndex => $cat)
        @if($catIndex > 0 && $catIndex % 2 === 0)
            <div class="page-break"></div>
        @endif

        <div class="cat-section">
            {{-- Ancla interna para navegación desde el TOC --}}
            <a name="cat-{{ $cat->id }}"></a>

            <div class="cat-header-bar cat-bookmark" data-cat="{{ $cat->nombre }}">
                <div class="cat-header-inner">
                    <div class="cat-icon">{!! $icons[$catIndex % count($icons)] !!}</div>
                    <div class="cat-name"><strong>{{ $cat->nombre }}</strong></div>
                    @if($cat->descripcion)
                        <div class="cat-desc">{{ $cat->descripcion }}</div>
                    @endif
                    <div class="cat-count">
                        {{ str_pad($catIndex + 1, 2, '0', STR_PAD_LEFT) }} &nbsp;&bull;&nbsp;
                        {{ $cat->productos->count() }} producto{{ $cat->productos->count() !== 1 ? 's' : '' }}
                    </div>
                </div>
            </div>

            <table class="products-grid">
                @foreach($cat->productos as $p)
                @php
                    $esNuevo = isset($p->creado_en) && \Carbon\Carbon::parse($p->creado_en)->diffInDays(now()) <= 30;
                @endphp
                <tr class="product-row">
                    <td>
                        <div class="product-card">
                            <div class="product-card-accent">
                                {{-- Acento de color lateral --}}
                                <div class="p-accent-col {{ $p->destacado ? 'destacado' : '' }}"></div>
                                <div class="p-body-col">
                                    <table class="product-card-inner">
                                        <tr>
                                            {{-- Imagen del producto --}}
                                            @php
                                                $imgPath  = public_path('storage/' . $p->imagen);
                                                $tieneImg = !empty($p->imagen) && file_exists($imgPath);
                                            @endphp
                                            <td class="p-img-col">
                                                @if($tieneImg)
                                                    <img src="{{ $imgPath }}" alt="{{ $p->nombre }}">
                                                @else
                                                    <div class="p-img-placeholder">&#x1F33C;</div>
                                                @endif
                                            </td>

                                            {{-- Info del producto --}}
                                            <td class="p-left">
                                                <div class="p-name">
                                                    {{ $p->nombre }}
                                                    @if($p->destacado)
                                                        <span class="p-badge-dest">&#x2B50; Destacado</span>
                                                    @endif
                                                    @if($esNuevo)
                                                        <span class="p-badge-nuevo">&#x2728; Nuevo</span>
                                                    @endif
                                                </div>
                                                <div class="p-desc">{{ $p->descripcion ?: 'Producto de la m&aacute;s alta calidad.' }}</div>
                                                <div class="p-tags">
                                                    <span class="p-tag-cat">{{ $cat->nombre }}</span>
                                                </div>
                                                <div class="p-sku"># {{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</div>
                                            </td>

                                            {{-- Precio y stock --}}
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
                                                            <span class="p-stock stock-low">&#x26A0;&#xFE0F; {{ $p->stock }} ud{{ $p->stock !== 1 ? 's' : '' }}.</span>
                                                        @else
                                                            <span class="p-stock stock-out">&#x274C; Agotado</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
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

    {{-- ═══════════════════════════════════════════
         PÁGINA DE CONTACTO
         ═══════════════════════════════════════════ --}}
    <div class="contact-page">
        <div class="contact-hero">
            <div class="contact-emoji">&#x1F338;</div>
            <div class="contact-title">&iquest;Te gust&oacute; algo? <span>&iexcl;Ped&iacute; ya!</span></div>
            <div class="contact-sub">Hac&eacute; tu pedido por WhatsApp, visit&aacute; nuestra tienda o compr&aacute; en la web</div>
        </div>

        <table class="contact-cards">
            <tr>
                <td class="contact-card">
                    <div class="cc-icon">&#x1F4F1;</div>
                    <div class="cc-label">WhatsApp</div>
                    <div class="cc-value">
                        <a class="link-wa" href="https://wa.me/50684630055?text=Hola%2C%20vi%20el%20cat%C3%A1logo%20y%20quiero%20hacer%20un%20pedido">
                            +506 8463-0055
                        </a>
                    </div>
                    <div class="cc-extra">Toc&aacute; para chatear</div>
                </td>
                <td class="contact-card">
                    <div class="cc-icon">&#x1F4CD;</div>
                    <div class="cc-label">Ubicaci&oacute;n</div>
                    <div class="cc-value">
                        <a href="https://maps.google.com/?q=Bribri+Talamanca+Costa+Rica">Bribri, Talamanca</a>
                    </div>
                    <div class="cc-extra">Lim&oacute;n, Costa Rica</div>
                </td>
                <td class="contact-card">
                    <div class="cc-icon">&#x1F4E7;</div>
                    <div class="cc-label">Correo</div>
                    <div class="cc-value">
                        <a class="link-email" href="mailto:{{ config('floristeria.admin_email') }}" style="font-size:8pt;">
                            {{ config('floristeria.admin_email') }}
                        </a>
                    </div>
                    <div class="cc-extra">Consultas generales</div>
                </td>
            </tr>
        </table>

        {{-- Botones de acción principales --}}
        <div style="text-align:center; margin-top: 4pt;">
            <a class="btn-wa" href="https://wa.me/50684630055?text=Hola%2C%20vi%20el%20cat%C3%A1logo%20y%20quiero%20hacer%20un%20pedido">
                &#x1F4F1; &nbsp; Pedir por WhatsApp
            </a>
            <a class="btn-web-cta" href="https://floristeriabribri.com">
                &#x1F310; &nbsp; Ver tienda online
            </a>
        </div>

        <div class="extra-info">
            <table>
                <tr>
                    <td class="ei-icon">&#x1F552;</td>
                    <td class="ei-label">Horario</td>
                    <td class="ei-value">Lun &ndash; S&aacute;b: 8:00 am &ndash; 6:00 pm &nbsp;&bull;&nbsp; Dom: 9:00 am &ndash; 2:00 pm</td>
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
                <tr>
                    <td class="ei-icon">&#x1F310;</td>
                    <td class="ei-label">Web</td>
                    <td class="ei-value">
                        <a class="link-web" href="https://floristeriabribri.com">floristeriabribri.com</a>
                        &nbsp;&bull;&nbsp; Pedidos online 24/7
                    </td>
                </tr>
            </table>
        </div>

        <div class="final-note">
            <div class="flower">&#x1F33A; &#x1F33B; &#x1F337;</div>
            <p>&ldquo;Cada flor que entregamos lleva un pedacito de Bribri y mucho amor costarricense&rdquo;</p>
            <div class="copy">
                &copy; {{ date('Y') }} Floristería Bribri &nbsp;&bull;&nbsp; Todos los derechos reservados<br>
                Cat&aacute;logo generado el {{ now()->translatedFormat('d/m/Y') }} &nbsp;&bull;&nbsp;
                <a class="link-web" href="https://floristeriabribri.com">floristeriabribri.com</a>
            </div>
        </div>
    </div>

</body>
</html>