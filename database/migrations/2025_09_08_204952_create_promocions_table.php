<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promociones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complejo_id')->constrained('complejo')->onDelete('cascade');
            $table->foreignId('membresia_id')->nullable()->constrained()->onDelete('cascade');

            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->enum('tipo_descuento', ['porcentaje', 'monto_fijo']);
            $table->decimal('valor_descuento', 10, 2);

            $table->date('fecha_inicio');
            $table->date('fecha_fin');

            $table->boolean('activo')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promociones');
    }
};
