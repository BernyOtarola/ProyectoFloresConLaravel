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
        'created_at'  => 'datetime',
    ];

    // Usar created_at de Laravel como creado_en
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null; // sin updated_at

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

    // ── Scopes ───────────────────────────────────────────────

    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeDeHoy($query)
    {
        return $query->whereDate('creado_en', today());
    }

    // ── Accessors ────────────────────────────────────────────

    // Devuelve los items como array PHP (decodifica el JSON)
    public function getItemsAttribute(): array
    {
        return json_decode($this->items_json, true) ?? [];
    }

    // Etiqueta legible del estado
    public function getEstadoLabelAttribute(): string
    {
        return self::ESTADOS[$this->estado] ?? $this->estado;
    }

    // Clase CSS del badge según estado
    public function getEstadoBadgeAttribute(): string
    {
        return self::ESTADO_BADGES[$this->estado] ?? 'badge-gray';
    }

    // Total formateado
    public function getTotalFormateadoAttribute(): string
    {
        return '₡' . number_format($this->total, 0, ',', '.');
    }

    // Es envío a domicilio?
    public function getEsEnvioAttribute(): bool
    {
        return $this->tipo_entrega === 'envio';
    }
}