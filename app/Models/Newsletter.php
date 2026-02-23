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

    const CREATED_AT = 'enviado_en';
    const UPDATED_AT = null;
}