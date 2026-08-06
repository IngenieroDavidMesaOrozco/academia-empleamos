<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('progreso_lecciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('leccion_id')->constrained('lecciones')->onDelete('cascade');
            $table->boolean('completada')->default(true);
            $table->date('fecha');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('progreso_lecciones'); }
};