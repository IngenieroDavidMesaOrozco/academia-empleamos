<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\ProgresoLeccion;
use App\Models\Certificado;
use App\Models\Evaluacion;
use App\Models\ResultadoEvaluacion;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function evaluacion(Evaluacion $evaluacion)
    {
        $evaluacion->load('preguntas.opciones');

        return view(
            'admin.estudiante.evaluacion',
            compact('evaluacion')
        );
    }

    public function responder(Request $request, Evaluacion $evaluacion)
    {
        $evaluacion->load('preguntas.opciones');

        $correctas = 0;

        $total = $evaluacion->preguntas->count();

        foreach ($evaluacion->preguntas as $pregunta) {

            $respuesta = $request->input(
                'pregunta_' . $pregunta->id
            );

            $correcta = $pregunta->opciones
                ->where('correcta', 1)
                ->first();

            if ($correcta && $respuesta == $correcta->id) {
                $correctas++;
            }
        }

        $nota = $total > 0
            ? round(($correctas / $total) * 100)
            : 0;

        ResultadoEvaluacion::updateOrCreate(

            [
                'usuario_id' => auth()->id(),
                'evaluacion_id' => $evaluacion->id
            ],

            [
                'nota' => $nota,
                'aprobado' => $nota >= $evaluacion->puntaje_aprobacion
            ]

        );

        $curso = Curso::with([
            'modulos.evaluacion'
        ])->findOrFail(
            $evaluacion->modulo->curso_id
        );

        $evaluaciones = ResultadoEvaluacion::where(
            'usuario_id',
            auth()->id()
        )->pluck(
            'aprobado',
            'evaluacion_id'
        );

        $aproboTodo = true;

        foreach ($curso->modulos as $modulo) {

            if (!$modulo->evaluacion) {
                continue;
            }

            if (
                !isset($evaluaciones[$modulo->evaluacion->id]) ||
                !$evaluaciones[$modulo->evaluacion->id]
            ) {
                $aproboTodo = false;
                break;
            }
        }

        $certificado = null;

        if ($aproboTodo) {

            $certificado = Certificado::firstOrCreate(

                [
                    'usuario_id' => auth()->id(),
                    'curso_id' => $curso->id
                ],

                [
                    'codigo' => 'CERT-' . time() . '-' . rand(1000, 9999),
                    'fecha_emision' => now()
                ]

            );
        }

        if ($certificado) {

            return redirect()->route(
                'certificado.show',
                $certificado
            );
        }

        return redirect()
            ->route('estudiante.dashboard')
            ->with(
                'success',
                'Evaluación terminada. Nota: ' . $nota . '%'
            );
    }

    public function dashboard()
    {
        $cursos = Curso::with('modulos')
            ->orderBy('nombre')
            ->get();

        $certificados = Certificado::where(
            'usuario_id',
            auth()->id()
        )->pluck(
            'id',
            'curso_id'
        );

        return view(
            'admin.estudiante.dashboard',
            compact(
                'cursos',
                'certificados'
            )
        );
    }

    public function curso($id)
    {
        $curso = Curso::with([
            'modulos.lecciones.recursos',
            'modulos.evaluacion'
        ])->findOrFail($id);

        $completadas = ProgresoLeccion::where(
            'usuario_id',
            auth()->id()
        )->pluck('leccion_id')->toArray();

        $totalLecciones = 0;

        foreach ($curso->modulos as $modulo) {
            $totalLecciones += $modulo->lecciones->count();
        }

        $leccionesCompletadas = count($completadas);

        $porcentaje = 0;

        if ($totalLecciones > 0) {

            $porcentaje = round(
                ($leccionesCompletadas / $totalLecciones) * 100
            );
        }

        $modulosDesbloqueados = [];

        foreach ($curso->modulos as $modulo) {

            $total = $modulo->lecciones->count();

            $completadasModulo = 0;

            foreach ($modulo->lecciones as $leccion) {

                if (in_array($leccion->id, $completadas)) {
                    $completadasModulo++;
                }
            }

            // A module is unlocked if it's the first one, or if it has 0 lessons, or if all lessons are completed.
            $porcentajeModulo = $total > 0 ? ($completadasModulo / $total) * 100 : 0;
            $modulosDesbloqueados[$modulo->id] =
                ($total == 0 || $porcentajeModulo >= 80);
        }

        return view(
            'admin.estudiante.curso',
            compact(
                'curso',
                'completadas',
                'porcentaje',
                'totalLecciones',
                'leccionesCompletadas',
                'modulosDesbloqueados'
            )
        );
    }

    public function bienvenida()
    {
        return view('admin.estudiante.bienvenida');
    }

    public function completarBienvenida()
    {
        $user = auth()->user();

        $user->vio_video_bienvenida = true;
        $user->save();

        // Redirect to change password if necessary after watching video.
        if ($user->password_temporal) {
            return redirect()->route('password.forzar.cambio');
        }

        return redirect()->route('estudiante.dashboard');
    }
}
