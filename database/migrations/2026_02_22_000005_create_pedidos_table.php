<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numero_pedido', 30)->unique();
            $table->string('nombre_cliente', 150);
            $table->string('telefono_cliente', 20);
            $table->string('email_cliente', 150)->nullable();
            $table->enum('tipo_entrega', ['retiro', 'envio'])->default('retiro');
            $table->text('direccion_envio')->nullable();
            $table->text('nota')->nullable();
            $table->longText('items_json');
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('costo_envio', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->enum('estado', [
                'pendiente',
                'confirmado',
                'en_proceso',
                'listo',
                'entregado',
                'cancelado'
            ])->default('pendiente');
            $table->timestamp('creado_en')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};