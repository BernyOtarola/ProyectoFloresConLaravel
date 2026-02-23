<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins';

    protected $fillable = [
        'nombre',
        'email',
        'password_hash',
    ];

    public $timestamps = false;

    protected $hidden = [
        'password_hash',
    ];

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

    public function scopeByEmail($query, string $email)
    {
        return $query->where('email', $email);
    }
}