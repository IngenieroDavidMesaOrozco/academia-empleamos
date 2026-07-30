<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    protected $table = 'evaluaciones';

    protected $fillable = [

    'modulo_id',

    'titulo',

    'descripcion',

    'puntaje_aprobacion',

    'tiempo',

    'estado'

];


    public function preguntas()
    {
        return $this->hasMany(Pregunta::class);
    }

    public function modulo()
    {
        return $this->belongsTo(Modulo::class);
    }
}