<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Models\Suscriptor;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function index()
    {
        $totalSubs = Suscriptor::where('activo', true)->count();
        $historial = Newsletter::latest('enviado_en')->take(10)->get();

        return view('admin.newsletter.index', compact('totalSubs', 'historial'));
    }

    public function enviar(Request $request)
    {
        $request->validate([
            'asunto' => 'required|string|max:255',
            'mensaje' => 'required|string',
        ]);

        $suscriptores = Suscriptor::where('activo', true)->get();
        $totalEnviados = $suscriptores->count();


        foreach ($suscriptores as $s) {
            Mail::to($s->email)->queue(new NewsletterMail(
                $request->input('asunto'),
                $request->input('mensaje'),
                $s->nombre,
            ));
        }

        Newsletter::create([
            'asunto' => $request->input('asunto'),
            'mensaje' => $request->input('mensaje'),
            'enviado_a' => $totalEnviados,
            'enviado_en' => now(),
        ]);

        return redirect()->route('admin.newsletter.index')
            ->with('success', "Newsletter guardado para {$totalEnviados} suscriptores.");
    }
}