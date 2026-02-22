<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'categoria_id',
        'stock',
        'imagen',
        'destacado',
        'activo',
    ];

    protected $casts = [
        'precio'    => 'float',
        'stock'     => 'integer',
        'destacado' => 'boolean',
        'activo'    => 'boolean',
    ];

    // La tabla usa creado_en en vez de created_at / updated_at
    public $timestamps = false;

    // ── Relaciones ───────────────────────────────────────────

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    // ── Scopes ───────────────────────────────────────────────

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeDestacados($query)
    {
        return $query->where('activo', true)->where('destacado', true);
    }

    public function scopeDeCategoria($query, int $categoriaId)
    {
        return $query->where('categoria_id', $categoriaId);
    }

    public function scopeBusqueda($query, string $texto)
    {
        return $query->where(function ($q) use ($texto) {
            $q->where('nombre',      'like', "%{$texto}%")
              ->orWhere('descripcion','like', "%{$texto}%");
        });
    }

    // ── Accessors ────────────────────────────────────────────

    // Precio formateado: ₡18.500
    public function getPrecioFormateadoAttribute(): string
    {
        return '₡' . number_format($this->precio, 0, ',', '.');
    }

    // URL completa de la imagen (o null si no tiene)
    public function getImagenUrlAttribute(): ?string
    {
        if (!$this->imagen) return null;
        return Storage::disk('public')->url('products/' . $this->imagen);
    }

    // Badge de stock
    public function getStockEstadoAttribute(): string
    {
        if ($this->stock > 10) return 'disponible';
        if ($this->stock > 0)  return 'pocas-unidades';
        return 'agotado';
    }
}