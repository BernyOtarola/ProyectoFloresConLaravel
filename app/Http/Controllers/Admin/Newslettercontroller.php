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
        $enviados = 0;
        $errores  = 0;

        foreach ($suscriptores as $sub) {
            try {
                Mail::to($sub->email)->send(
                    new NewsletterMail(
                        $request->input('asunto'),
                        $request->input('mensaje'),
                        $sub->nombre
                    )
                );
                $enviados++;
            } catch (\Exception $e) {
                $errores++;
            }
        }

        // Guardar registro del newsletter enviado
        Newsletter::create([
            'asunto'     => $request->input('asunto'),
            'mensaje'    => $request->input('mensaje'),
            'enviado_a'  => $enviados,
            'enviado_en' => now(),
        ]);

        $msg = "✅ Newsletter enviado a {$enviados} suscriptores.";
        if ($errores > 0) {
            $msg .= " ⚠️ {$errores} no pudieron ser enviados.";
        }

        return redirect()->route('admin.newsletter.index')
            ->with('success', $msg);
    }
}