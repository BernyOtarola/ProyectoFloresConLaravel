<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';

    protected $fillable = [
        'nombre',
        'email',
        'password_hash',
    ];

    // No usar timestamps de Laravel (created_at / updated_at)
    // la tabla tiene su propio creado_en
    public $timestamps = false;

    protected $hidden = [
        'password_hash',
    ];

    // ── Scopes ──────────────────────────────────────────────

    public function scopeByEmail($query, string $email)
    {
        return $query->where('email', $email);
    }
}