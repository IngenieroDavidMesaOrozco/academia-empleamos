<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leccion;
use App\Models\ProgresoLeccion;
use Illuminate\Support\Facades\Auth;

class ProgresoController extends Controller
{
    public function completar($id)
    {
        // 1. Buscamos la lección para saber a qué curso pertenece
        $leccion = Leccion::with('modulo.curso')->findOrFail($id);
        $cursoId = $leccion->modulo->curso_id ?? null;

        if (!$cursoId) {
            return redirect()->back()->with('error', 'No se encontró el curso asociado a esta lección.');
        }

        // 2. Registramos o actualizamos el progreso usando el modelo correcto de tu sistema (ProgresoLeccion)
        ProgresoLeccion::firstOrCreate([
            'usuario_id' => Auth::id(),
            'leccion_id' => $leccion->id
        ]);

        // 3. Redirigimos al curso del estudiante
        // Al usar ProgresoLeccion, la barra de progreso subirá, se quitará el candado del examen y podrás avanzar.
        return redirect()->route('estudiante.curso', $cursoId)
            ->with('success', '¡Lección completada con éxito! Ya puedes avanzar.');
    }
}