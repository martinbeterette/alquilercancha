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
        Schema::create('zona', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->foreignId('rela_tipo_deporte')->constrained('tipo_deporte')->onDelete('restrict');
            $table->foreignId('rela_superficie')->constrained('superficie')->onDelete('restrict');
            $table->foreignId('rela_tipo_zona')->constrained('tipo_zona')->onDelete('restrict');
            $table->foreignId('rela_estado_zona')->constrained('estado_zona')->onDelete('restrict');
            $table->foreignId('rela_sucursal')->constrained('sucursal');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zona');
    }
};
