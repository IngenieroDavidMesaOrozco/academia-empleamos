<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Parametro;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        Parametro::create([
            'tiempo_para_cambio_contraseña' => 90
        ]);

        $admin = User::factory()->create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $admin->assignRole('SuperAdmin');
    }
}
