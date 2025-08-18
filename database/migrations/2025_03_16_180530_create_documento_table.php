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
        Schema::create('documento', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->foreignId('rela_persona')->constrained('persona')->onDelete('restrict');
            $table->foreignId('rela_tipo_documento')->constrained('tipo_documento')->onDelete('restrict');
            $table->boolean('activo')->default(true);//estoy migrando al softdeletes
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documento');
    }
};
