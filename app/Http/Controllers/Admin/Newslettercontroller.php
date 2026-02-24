<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewsletterMail;
use App\Models\Newsletter;
use App\Models\Suscriptor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
            'asunto'  => 'required|string|max:255',
            'mensaje' => 'required|string',
        ]);

        $suscriptores = Suscriptor::where('activo', true)->get();

        foreach ($suscriptores as $sub) {
            // FIX #7: Mail::queue en lugar de Mail::send
            // No bloquea el request; el queue worker procesa en background
            Mail::to($sub->email)->queue(
                new NewsletterMail(
                    $request->input('asunto'),
                    $request->input('mensaje'),
                    $sub->nombre
                )
            );
        }

        Newsletter::create([
            'asunto'     => $request->input('asunto'),
            'mensaje'    => $request->input('mensaje'),
            'enviado_a'  => $suscriptores->count(),
            'enviado_en' => now(),
        ]);

        return redirect()->route('admin.newsletter.index')
            ->with('success', "✅ Newsletter encolado para {$suscriptores->count()} suscriptores.");
    }
}