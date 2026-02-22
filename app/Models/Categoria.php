<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public $timestamps = false;

    // ── Relaciones ───────────────────────────────────────────

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'categoria_id');
    }

    public function productosActivos(): HasMany
    {
        return $this->hasMany(Producto::class, 'categoria_id')
                    ->where('activo', true);
    }

    // ── Scopes ───────────────────────────────────────────────

    public function scopeConTotalActivos($query)
    {
        return $query->withCount([
            'productos as total' => fn($q) => $q->where('activo', true)
        ]);
    }
}