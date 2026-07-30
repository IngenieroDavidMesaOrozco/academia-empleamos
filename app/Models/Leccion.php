<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leccion extends Model
{
    protected $table = 'lecciones';

    protected $fillable = [
        'modulo_id',
        'titulo',
        'descripcion',
        'video',
        'documento',
        'orden'
    ];

    public function modulo()
    {
        return $this->belongsTo(Modulo::class);
    }

    public function recursos()
    {
        return $this->hasMany(Recurso::class);
    }
}