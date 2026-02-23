<?php

namespace App\Console\Commands;

use App\Models\Pedido;
use Illuminate\Console\Command;

class EliminarPedidosVencidos extends Command
{
    protected $signature   = 'pedidos:limpiar';
    protected $description = 'Elimina todos los pedidos cuya fecha_retiro ya pasó (1 día posterior)';

    public function handle(): int
    {
        // Buscar pedidos con fecha_retiro anterior a hoy
        // Ejemplo: si fecha_retiro = 2026-02-23, se borra el 2026-02-24 o después
        $pedidos = Pedido::vencidos()->get();

        if ($pedidos->isEmpty()) {
            $this->info('No hay pedidos vencidos para eliminar.');
            return self::SUCCESS;
        }

        $total = $pedidos->count();

        foreach ($pedidos as $pedido) {
            $this->line("  → Eliminando #{$pedido->numero_pedido} (retiro: {$pedido->fecha_retiro_formateada})");
            $pedido->delete();
        }

        $this->info("✅ {$total} pedido(s) eliminado(s) correctamente.");
        return self::SUCCESS;
    }
}