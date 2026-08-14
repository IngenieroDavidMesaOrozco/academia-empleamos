<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = 'modulos';

    protected $fillable = [
        'curso_id',
        'nombre',
        'descripcion',
        'orden'
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function lecciones()
    {
        return $this->hasMany(Leccion::class);
    }

    // Compatibilidad total (singular y plural) para evitar errores en relaciones
    public function evaluacion()
    {
        return $this->hasOne(Evaluacion::class, 'modulo_id');
    }

    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'modulo_id');
    }
}