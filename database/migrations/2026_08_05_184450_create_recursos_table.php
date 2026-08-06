<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('recursos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leccion_id')->constrained('lecciones')->onDelete('cascade');
            $table->string('nombre');
            $table->string('tipo')->nullable();
            $table->string('archivo');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('recursos'); }
};