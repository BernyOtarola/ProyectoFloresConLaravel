@extends('layouts.admin')
@section('page-title', 'Newsletter')

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;">
    <div class="form-card" style="max-width:100%;">
        <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.4rem;color:var(--verde);margin-bottom:0.5rem;">📨 Enviar newsletter</h3>
        <p style="color:var(--gris);font-size:0.875rem;margin-bottom:1.5rem;">Se enviará a <strong>{{ $totalSubs }}</strong> suscriptores activos.</p>
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
        <p style="margin-top:1rem;font-size:0.8rem;color:var(--gris);">💡 Requiere configurar Mail con SMTP para envío real.</p>
    </div>

    <div>
        <h2 class="section-title" style="margin-top:0;">Historial enviados</h2>
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
</div>
@endsection