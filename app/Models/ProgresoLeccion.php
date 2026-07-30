<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresoLeccion extends Model
{
    protected $table = 'progreso_lecciones';

    protected $fillable = [
        'usuario_id',
        'leccion_id',
        'completada',
        'fecha'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function leccion()
    {
        return $this->belongsTo(Leccion::class);
    }

    public function progreso()
{
    return $this->hasMany(ProgresoLeccion::class);
}
}