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
        Schema::create('rutas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('IDRUTAS');
            $table->string('NOMBRE', 100);
            $table->date("FECHA");
            //Definir el campo para la relación con choferes (Llave foriegn)
            $table->unsignedInteger("IDCHOFER");
            $table->timestamps();

            //Establcer la relación con la tabla choferes
            $table->foreign('IDCHOFER')->references('IDCHOFER')->on('choferes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rutas');
    }
};
