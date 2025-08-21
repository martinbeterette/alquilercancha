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
        Schema::create('reserva', function (Blueprint $table) {
            $table->id();
            $table->string('observacion')->nullable();
            $table->date('fecha');
            $table->time('hora_desde');
            $table->time('hora_hasta');
            $table->decimal('precio', 10, 2)->nullable();
            $table->enum('estado', ['Confirmada', 'Pendiente', 'Cancelada','Completada'])->default('Pendiente');
            $table->enum('metodo_pago', ['Efectivo', 'Tarjeta', 'Transferencia', 'Pendiente'])->default('Pendiente');
            $table->enum('tipo_reserva', ['Interna', 'Externa'])->default('Interna');
            $table->text('cancelacion_motivo')->nullable();
            $table->integer('creado_por')->nullable();
            $table->foreignId('rela_persona')->constrained('persona')->onDelete('restrict');
            $table->foreignId('rela_zona')->constrained('zona')->onDelete('restrict');
            // $table->foreignId('rela_estado_reserva')->constrained('estado_reserva')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserva');
    }
};
