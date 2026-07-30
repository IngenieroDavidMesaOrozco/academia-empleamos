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

    public function evaluacion()
{
    return $this->hasOne(Evaluacion::class);
}
}