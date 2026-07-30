<?php
// app/Models/Parametro.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    protected $table = 'parametros';
    public $timestamps = false;

    protected $fillable = ['tiempo_para_cambio_contraseña'];


        //CONVERTIR INFORMACION A MAYUSCULA
    public function setAttribute($key, $value)
{
    // Lista de atributos que deseas transformar a mayúscula
    $camposEnMayuscula = ['tiempo_para_cambio_contraseña'];

    if (in_array($key, $camposEnMayuscula) && is_string($value)) {
        $value = strtoupper($value);
    }

    return parent::setAttribute($key, $value);
}
}
