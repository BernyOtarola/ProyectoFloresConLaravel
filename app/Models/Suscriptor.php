<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suscriptor extends Model
{
    protected $table = 'suscriptores';

    protected $fillable = [
        'nombre',
        'email',
        'password_hash',
        'activo',
    ];

    protected $casts = [
        'activo'      => 'boolean',
        'suscrito_en' => 'datetime',
    ];

    protected $hidden = [
        'password_hash',
    ];

    // Mapear created_at al campo suscrito_en de la tabla existente
    const CREATED_AT = 'suscrito_en';
    const UPDATED_AT = null;

    // ── Scopes ───────────────────────────────────────────────

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeConCuenta($query)
    {
        return $query->whereNotNull('password_hash');
    }

    // ── Accessors ────────────────────────────────────────────

    // ¿Tiene contraseña registrada?
    public function getTieneCuentaAttribute(): bool
    {
        return !empty($this->password_hash);
    }

    // Fecha formateada: 15/03/2025
    public function getFechaFormateadaAttribute(): string
    {
        return $this->suscrito_en?->format('d/m/Y') ?? '—';
    }
}