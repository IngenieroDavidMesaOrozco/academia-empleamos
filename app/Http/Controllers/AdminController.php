<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\User;
use App\Models\Certificado;

class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Estadísticas y métricas generales calculadas dinámicamente
        $stats = [
            'total_estudiantes' => User::role('estudiante')->count(), // Si usas Spatie Roles
            'total_cursos'      => Curso::count(),
            // Contamos tanto 'activo' como 'Activo' por seguridad para evitar el 0
            'cursos_activos'    => Curso::whereIn('estado', ['activo', 'Activo', 'PUBLISHED', 'publicado'])->count(),
        ];

        // 2. Últimos cursos registrados para las tarjetas del dashboard
        $ultimosCursos = Curso::with('area')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // 3. Últimos usuarios registrados
        $ultimosUsuarios = User::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'ultimosCursos', 'ultimosUsuarios'));
    }
}