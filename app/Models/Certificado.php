<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    protected $table = 'certificados';

    protected $fillable = [

        'usuario_id',

        'curso_id',

        'codigo',

        'fecha_emision'

    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}   