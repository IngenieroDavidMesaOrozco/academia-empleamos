<?php

namespace App\Models;
use Spatie\Permission\Traits\HasRoles;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
   use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
  protected $fillable = [
    'password_temporal', 
    'password_expires_at', 
    'vio_video_bienvenida',
    'name',
    'email',
    'email_verified_at',
    'password',
    'username',
    'perfil',
    'soporte_it',
        'activo', // <-- Agregado aquí

];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $casts = [
        'password_temporal' => 'boolean', 
        'password_expires_at' => 'datetime', 
        'vio_video_bienvenida' => 'boolean',
    'soporte_it' => 'boolean',
        'activo' => 'boolean', // <-- También casteado como booleano
            'last_password_change' => 'datetime',


];


    //CONVERTIR INFORMACION A MAYUSCULA
    public function setAttribute($key, $value)
{
    // Lista de atributos que deseas transformar a mayúscula
    $camposEnMayuscula = ['name', 'username', 'perfil'];

    if (in_array($key, $camposEnMayuscula) && is_string($value)) {
        $value = strtoupper($value);
    }

    return parent::setAttribute($key, $value);
}


public function progresoLecciones()
{
    return $this->hasMany(ProgresoLeccion::class);
}
public function certificados()
{
    return $this->hasMany(\App\Models\Certificado::class);
}
}
