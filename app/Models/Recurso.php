<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    protected $table = 'recursos';

    protected $fillable = [
        'leccion_id',
        'nombre',
        'tipo',
        'archivo'
    ];

    public function leccion()
    {
        return $this->belongsTo(Leccion::class);
    }
}