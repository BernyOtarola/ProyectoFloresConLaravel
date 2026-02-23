<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Suscriptor extends Authenticatable
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

    const CREATED_AT = 'suscrito_en';
    const UPDATED_AT = null;

    // ── Autenticación ────────────────────────────────────
    // Indica a Laravel qué columna contiene la contraseña
    public function getAuthPasswordName(): string
    {
        return 'password_hash';
    }

    // Sin columna remember_token en la tabla → desactivar
    public function getRememberTokenName(): string
    {
        return '';
    }

    // ── Scopes ───────────────────────────────────────────

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeConCuenta($query)
    {
        return $query->whereNotNull('password_hash');
    }

    // ── Accessors ────────────────────────────────────────

    public function getTieneCuentaAttribute(): bool
    {
        return !empty($this->password_hash);
    }

    public function getFechaFormateadaAttribute(): string
    {
        return $this->suscrito_en?->format('d/m/Y') ?? '—';
    }
}