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
        'direccion_envio',
        'nota',
        'items_json',
        'subtotal',
        'costo_envio',
        'total',
        'estado',
    ];

    protected $casts = [
        'subtotal'    => 'float',
        'costo_envio' => 'float',
        'total'       => 'float',
        'creado_en'   => 'datetime',   // ← cast correcto al nombre real de la columna
    ];

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null;

    // Estados válidos
    const ESTADOS = [
        'pendiente'   => 'Pendiente',
        'confirmado'  => 'Confirmado',
        'en_proceso'  => 'En proceso',
        'listo'       => 'Listo para retirar',
        'entregado'   => 'Entregado',
        'cancelado'   => 'Cancelado',
    ];

    // Colores para badges en la vista
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

    // ── Accessors ────────────────────────────────────────

    // Items como array PHP
    public function getItemsAttribute(): array
    {
        return json_decode($this->items_json, true) ?? [];
    }

    // Etiqueta legible del estado: "En proceso"
    public function getEstadoLabelAttribute(): string
    {
        return self::ESTADOS[$this->estado] ?? $this->estado;
    }

    // Clase CSS del badge: "badge-blue"
    public function getEstadoBadgeAttribute(): string
    {
        return self::ESTADO_BADGES[$this->estado] ?? 'badge-gray';
    }

    // Total formateado: ₡18.500
    public function getTotalFormateadoAttribute(): string
    {
        return '₡' . number_format($this->total, 0, ',', '.');
    }

    // Fecha legible: "22/02/2026 14:35"    ← #8: reemplaza Carbon::parse() en vistas
    public function getFechaFormateadaAttribute(): string
    {
        return $this->creado_en?->format('d/m/Y H:i') ?? '—';
    }

    // ¿Es envío a domicilio?
    public function getEsEnvioAttribute(): bool
    {
        return $this->tipo_entrega === 'envio';
    }
}