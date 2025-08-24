<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('modulos', function (Blueprint $table) {
            $table->id();
            $table->string('name');       // Ej: Ventas, Compras
            $table->string('slug')->nullable(); // Ej: ventas, compras (para rutas/menu)
            $table->string('icon')->nullable(); // opcional, icono para el menú
            $table->integer('orden')->default(0); // orden de aparición en el menú
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modulos');
    }
};
