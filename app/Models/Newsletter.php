<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $table = 'newsletters';

    protected $fillable = [
        'asunto',
        'mensaje',
        'enviado_a',
        'enviado_en',
    ];

    protected $casts = [
        'enviado_en' => 'datetime',
    ];

    // ── Sin CREATED_AT ni UPDATED_AT ────────────────────
    // La tabla solo tiene enviado_en que el controlador
    // asigna explícitamente con now(). Dejar que Eloquent
    // intente mapear created_at → enviado_en causaba que
    // el campo se escribiera dos veces en el INSERT.
    public $timestamps = false;
}