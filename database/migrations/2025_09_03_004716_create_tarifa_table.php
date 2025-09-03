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
        Schema::create('tarifa', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->time('hora_desde');
            $table->time('hora_hasta');
            $table->decimal('precio', 10, 2);
            $table->string('observacion')->nullable();
            $table->foreignId('rela_sucursal')->constrained('sucursal')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarifas');
    }
};
