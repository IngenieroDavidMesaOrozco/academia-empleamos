<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    protected $table = 'evaluaciones';

    protected $fillable = [
        'modulo_id',
        'leccion_id', // <--- ESTA LÍNEA ES LA QUE FALTABA
        'titulo',
        'descripcion',
        'puntaje_aprobacion',
        'tiempo',
        'estado',
        'archivo_pdf'
    ];

    public function preguntas()
    {
        return $this->hasMany(Pregunta::class);
    }

    public function modulo()
    {
        return $this->belongsTo(Modulo::class);
    }

    public function leccion()
    {
        return $this->belongsTo(Leccion::class);
    }
}