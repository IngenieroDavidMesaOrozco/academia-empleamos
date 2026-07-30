<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultadoEvaluacion extends Model
{
    protected $table = 'resultado_evaluaciones';

    protected $fillable = [
        'usuario_id',
        'evaluacion_id',
        'nota',
        'aprobado'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class);
    }
}