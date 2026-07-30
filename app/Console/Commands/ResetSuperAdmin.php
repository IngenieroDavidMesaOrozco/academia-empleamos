<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetSuperAdmin extends Command
{
    protected $signature = 'app:reset-superadmin';

    protected $description = 'Elimina todos los usuarios y crea un único SuperAdmin';

    public function handle()
    {
        $this->info('Eliminando relaciones de roles...');

        DB::table('model_has_roles')->delete();
        DB::table('model_has_permissions')->delete();

        $this->info('Eliminando usuarios...');

        User::query()->delete();

        $role = Role::firstOrCreate([
            'name' => 'SuperAdmin'
        ]);

        $user = User::create([
            'name' => 'DAVID MESA',
            'email' => 'admin@system.com',
            'username' => 'ADMIN',
            'password' => Hash::make('Admin1234'),
            'activo' => true,
            'password_temporal' => false,
            'vio_video_bienvenida' => true,
        ]);

        $user->assignRole($role);

        $this->info('===================================');
        $this->info('SuperAdmin creado correctamente');
        $this->info('Usuario: ADMIN');
        $this->info('Correo: admin@system.com');
        $this->info('Contraseña: Admin1234');
        $this->info('===================================');

        return self::SUCCESS;
    }
}