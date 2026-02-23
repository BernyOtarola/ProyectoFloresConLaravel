@extends('layouts.admin')
@section('page-title', 'Newsletter')

@push('css')
<style>
    /* ── Layout principal ─────────────────── */
    .nl-grid {
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:2rem;
    }

    /* ── Tarjeta formulario ───────────────── */
    .nl-form-card {
        background:white;border-radius:16px;padding:2rem;
        border:1px solid rgba(42,74,30,0.06);
    }
    .nl-form-card h3 {
        font-family:'Cormorant Garamond',serif;
        font-size:1.4rem;color:var(--verde);margin-bottom:0.5rem;
    }
    .nl-sub-count {
        color:var(--gris);font-size:0.875rem;margin-bottom:1.5rem;
    }
    .nl-sub-count strong { color:var(--verde); }
    .nl-tip {
        margin-top:1rem;font-size:0.8rem;color:var(--gris);
    }

    /* ── Historial desktop (tabla) ─────────── */
    .nl-hist-table { display:block; }

    /* ── Historial móvil (tarjetas) ───────── */
    .nl-hist-cards { display:none; }
    .nh-card {
        background:white;border-radius:12px;padding:1rem;
        border:1px solid rgba(42,74,30,0.06);
        margin-bottom:0.75rem;
    }
    .nh-top {
        display:flex;align-items:flex-start;justify-content:space-between;
        gap:0.75rem;margin-bottom:0.5rem;
    }
    .nh-asunto {
        font-weight:600;color:var(--verde);font-size:0.9rem;
        flex:1;min-width:0;
        overflow:hidden;text-overflow:ellipsis;white-space:nowrap;
    }
    .nh-bottom {
        display:flex;align-items:center;justify-content:space-between;
        gap:0.5rem;flex-wrap:wrap;
    }
    .nh-fecha {
        font-size:0.78rem;color:var(--gris);
    }

    /* ── Responsive ───────────────────────── */
    @media(max-width:900px) {
        .nl-grid {
            grid-template-columns:1fr;
        }
    }

    @media(max-width:640px) {
        .nl-form-card {
            padding:1.25rem;
        }
        .nl-form-card h3 {
            font-size:1.2rem;
        }
        .nl-form-card .btn {
            width:100%;justify-content:center;
        }
        .nl-form-card textarea {
            height:130px !important;
        }

        /* tabla → tarjetas */
        .nl-hist-table { display:none; }
        .nl-hist-cards { display:block; }

        .section-title { font-size:1.15rem; }
    }
</style>
@endpush

@section('content')
<div class="nl-grid">

    {{-- ═══ FORMULARIO ═══ --}}
    <div class="nl-form-card">
        <h3>📨 Enviar newsletter</h3>
        <p class="nl-sub-count">Se enviará a <strong>{{ $totalSubs }}</strong> suscriptores activos.</p>
        <form method="POST" action="{{ route('admin.newsletter.enviar') }}">
            @csrf
            <div class="form-group">
                <label>Asunto *</label>
                <input type="text" name="asunto" placeholder="Ej: ¡Nuevas flores de temporada!" required>
            </div>
            <div class="form-group">
                <label>Mensaje *</label>
                <textarea name="mensaje" style="height:160px;" placeholder="Escribe el contenido del newsletter…" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar newsletter 📨</button>
        </form>
        <p class="nl-tip">💡 Requiere configurar Mail con SMTP para envío real.</p>
    </div>

    {{-- ═══ HISTORIAL ═══ --}}
    <div>
        <h2 class="section-title" style="margin-top:0;">Historial enviados</h2>

        {{-- Desktop: tabla --}}
        <div class="nl-hist-table">
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Asunto</th><th>Enviados a</th><th>Fecha</th></tr></thead>
                    <tbody>
                        @forelse($historial as $n)
                        <tr>
                            <td>{{ $n->asunto }}</td>
                            <td><span class="badge badge-blue">{{ $n->enviado_a }} personas</span></td>
                            <td style="color:var(--gris);font-size:0.83rem;">{{ \Carbon\Carbon::parse($n->enviado_en)->format('d/m/Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" style="text-align:center;color:var(--gris);padding:1.5rem;">Sin historial</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Móvil: tarjetas --}}
        <div class="nl-hist-cards">
            @forelse($historial as $n)
            <div class="nh-card">
                <div class="nh-top">
                    <span class="nh-asunto">📨 {{ $n->asunto }}</span>
                    <span class="badge badge-blue">{{ $n->enviado_a }}</span>
                </div>
                <div class="nh-bottom">
                    <span class="nh-fecha">📅 {{ \Carbon\Carbon::parse($n->enviado_en)->format('d/m/Y H:i') }}</span>
                    <span style="font-size:0.78rem;color:var(--gris);">{{ $n->enviado_a }} personas</span>
                </div>
            </div>
            @empty
            <div style="text-align:center;color:var(--gris);padding:2rem;">
                <div style="font-size:2.5rem;margin-bottom:0.75rem;">📭</div>
                <p>Sin historial de envíos</p>
            </div>
            @endforelse
        </div>
    </div>

</div>
@endsection