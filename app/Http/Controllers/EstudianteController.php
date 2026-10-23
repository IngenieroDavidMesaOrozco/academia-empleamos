<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Modulo;
use App\Models\Leccion;
use App\Models\Evaluacion;
use App\Models\Certificado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EstudianteController extends Controller
{
    /**
     * Vista de bienvenida para el estudiante.
     */
    public function bienvenida()
    {
        return view('admin.estudiante.bienvenida');
    }

    /**
     * Procesa la confirmación de que el estudiante vio el video de bienvenida.
     */
    public function completarBienvenida(Request $request)
    {
        $estudiante = Auth::user();

        // Marcar que ya vio el video / bienvenida en la base de datos
        if (isset($estudiante->vio_video_bienvenida)) {
            $estudiante->vio_video_bienvenida = 1;
            $estudiante->save();
        }

        // Redirigir al dashboard del estudiante
        return redirect()->route('estudiante.dashboard');
    }

    /**
     * Dashboard principal del estudiante con sus cursos y certificados.
     */
    public function dashboard()
    {
        $estudiante = Auth::user();
        
        // Obtener cursos activos con su área y módulos
        $cursos = Curso::with('area', 'modulos.lecciones')->where('estado', 1)->orderBy('nombre')->get();
        
        // Lecciones completadas por el estudiante de forma segura
        $completadas = method_exists($estudiante, 'leccionesCompletadas') 
            ? $estudiante->leccionesCompletadas()->pluck('leccion_id')->toArray() 
            : [];

        // Obtener los certificados del estudiante indexados por curso_id usando usuario_id
        $certificados = Certificado::where('usuario_id', $estudiante->id)
            ->pluck('id', 'curso_id')
            ->toArray();

        return view('admin.estudiante.dashboard', compact('cursos', 'completadas', 'certificados'));
    }

    /**
     * Vista detallada del curso para el estudiante.
     */
    public function curso($id)
    {
        $estudiante = Auth::user();

        $curso = Curso::with([
            'area', 
            'modulos.lecciones.recursos', 
            'modulos.evaluaciones'
        ])->findOrFail($id);

        $completadas = method_exists($estudiante, 'leccionesCompletadas') 
            ? $estudiante->leccionesCompletadas()->pluck('leccion_id')->toArray() 
            : [];

        // Todos los módulos quedan desbloqueados libremente para el estudiante
        $modulosDesbloqueados = [];
        foreach ($curso->modulos as $modulo) {
            $modulosDesbloqueados[$modulo->id] = true;
        }

        return view('admin.estudiante.curso', compact('curso', 'completadas', 'modulosDesbloqueados'));
    }
}