<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';

    protected $fillable = [
        'numero_pedido',
        'nombre_cliente',
        'telefono_cliente',
        'email_cliente',
        'tipo_entrega',
        'fecha_retiro',        // ← nuevo
        'direccion_envio',
        'nota',
        'items_json',
        'subtotal',
        'costo_envio',
        'total',
        'estado',
    ];

    protected $casts = [
        'subtotal'     => 'float',
        'costo_envio'  => 'float',
        'total'        => 'float',
        'creado_en'    => 'datetime',
        'fecha_retiro' => 'date',   // ← cast a Carbon date
    ];

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null;

    // ── Estados ──────────────────────────────────────────

    const ESTADOS = [
        'pendiente'   => 'Pendiente',
        'confirmado'  => 'Confirmado',
        'en_proceso'  => 'En proceso',
        'listo'       => 'Listo para retirar',
        'entregado'   => 'Entregado',
        'cancelado'   => 'Cancelado',
    ];

    const ESTADO_BADGES = [
        'pendiente'   => 'badge-yellow',
        'confirmado'  => 'badge-blue',
        'en_proceso'  => 'badge-blue',
        'listo'       => 'badge-green',
        'entregado'   => 'badge-green',
        'cancelado'   => 'badge-red',
    ];

    // ── Scopes ───────────────────────────────────────────

    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeDeHoy($query)
    {
        return $query->whereDate('creado_en', today());
    }

    /**
     * Pedidos cuya fecha_retiro ya pasó (vencidos para borrar).
     * Se borran los que tengan fecha_retiro < hoy (es decir, ya pasó 1 día).
     */
    public function scopeVencidos($query)
    {
        return $query->whereNotNull('fecha_retiro')
                     ->whereDate('fecha_retiro', '<', today());
    }

    // ── Accessors ────────────────────────────────────────

    public function getItemsAttribute(): array
    {
        return json_decode($this->items_json, true) ?? [];
    }

    public function getEstadoLabelAttribute(): string
    {
        return self::ESTADOS[$this->estado] ?? $this->estado;
    }

    public function getEstadoBadgeAttribute(): string
    {
        return self::ESTADO_BADGES[$this->estado] ?? 'badge-gray';
    }

    public function getTotalFormateadoAttribute(): string
    {
        return '₡' . number_format($this->total, 0, ',', '.');
    }

    public function getFechaFormateadaAttribute(): string
    {
        return $this->creado_en?->format('d/m/Y H:i') ?? '—';
    }

    public function getFechaRetiroFormateadaAttribute(): string
    {
        return $this->fecha_retiro?->format('d/m/Y') ?? 'Sin fecha';
    }

    public function getEsEnvioAttribute(): bool
    {
        return $this->tipo_entrega === 'envio';
    }
}