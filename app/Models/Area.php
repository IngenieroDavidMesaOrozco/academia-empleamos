<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $table = 'areas';

    protected $fillable = [
        'nombre',
        'foto_lider', // <-- ESTO ES LO QUE PERMITE GUARDAR LA FOTO
    ];

    public function cursos()
    {
        return $this->hasMany(Curso::class, 'area_id');
    }

    /** URL de la foto del lider (o null si no hay foto o el archivo no existe). */
    public function getFotoLiderUrlAttribute(): ?string
    {
        return Curso::resolverImagen($this->foto_lider);
    }
}