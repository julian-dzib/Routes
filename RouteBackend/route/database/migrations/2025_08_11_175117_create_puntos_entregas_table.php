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
        Schema::create('puntos_entregas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('IDPUNTOS_ENTREGA');
            //Definir el campo para la relación con rutas (Llave foriegn)
            $table->unsignedInteger("IDRUTAS");
            $table->string("DIRECCION");
            $table->unsignedInteger("ORDEN");
            $table->boolean("ENTREGADO")->default(false);
            $table->timestamps();

            //Establecer la relación con la tabla rutas
            $table->foreign('IDRUTAS')->references('IDRUTAS')->on('rutas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puntos_entregas');
    }
};
