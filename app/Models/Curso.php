<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';

    protected $fillable = [
        'area_id',
        'nombre',
        'descripcion',
        'imagen',
        'estado'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function modulos()
{
    return $this->hasMany(Modulo::class);
}
public function certificados()
{
    return $this->hasMany(Certificado::class);
}
}