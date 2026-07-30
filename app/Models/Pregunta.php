<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = 'preguntas';

    protected $fillable = [
        'evaluacion_id',
        'pregunta'
    ];

    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class);
    }

    public function opciones()
    {
        return $this->hasMany(Opcion::class);
    }

    
}