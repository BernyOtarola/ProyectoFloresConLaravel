<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Suscriptor;

class SuscriptorController extends Controller
{
    public function index()
    {
        $suscriptores = Suscriptor::where('activo', true)
            ->latest('suscrito_en')
            ->get();

        return view('admin.suscriptores.index', compact('suscriptores'));
    }

    public function destroy(Suscriptor $suscriptor)
    {
        $suscriptor->delete();

        return redirect()->route('admin.suscriptores.index')
            ->with('success', 'Suscriptor eliminado.');
    }

    public function exportar()
    {
        $suscriptores = Suscriptor::where('activo', true)
            ->latest('suscrito_en')
            ->get();

        $filename = 'suscriptores_bribri_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($suscriptores) {
            $handle = fopen('php://output', 'w');

            // BOM para que Excel abra bien el UTF-8
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, ['Nombre', 'Email', 'Tiene cuenta', 'Fecha']);

            foreach ($suscriptores as $s) {
                fputcsv($handle, [
                    $s->nombre,
                    $s->email,
                    $s->password_hash ? 'Sí' : 'No',
                    $s->suscrito_en?->format('d/m/Y') ?? '',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}