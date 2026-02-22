<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suscriptores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->string('email', 150)->unique();
            $table->string('password_hash', 255)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamp('suscrito_en')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suscriptores');
    }
};