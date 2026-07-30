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
    Schema::create('areas', function (Blueprint $table) {

        $table->id();

        $table->string("nombre",100);//Aqui es donde se montaran todas las areas o capacitaciones 

        $table->text('descripcion')->nullable();// Aqui tenemos la informacion de las areas 

        $table->boolean('estado')->default(true);//Esta es la opcion en donde puedo activar y desactivar para que los aspirantes vean la informarcion 

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
};
