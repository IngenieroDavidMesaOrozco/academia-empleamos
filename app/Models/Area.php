<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Curso;

class Area extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'video',
        'archivo_diapositivas'
    ];

    public function cursos()
{
    return $this->hasMany(Curso::class);
}
}