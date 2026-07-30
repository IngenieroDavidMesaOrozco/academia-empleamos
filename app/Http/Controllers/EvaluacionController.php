<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Pregunta;
use App\Models\Opcion;
use App\Models\Evaluacion;
use App\Models\Modulo;
use App\Models\Leccion;
use Illuminate\Http\Request;

class EvaluacionController extends Controller
{
    public function index()
    {
        $evaluaciones = Evaluacion::with('modulo.curso')
            ->orderBy('titulo')
            ->get();

        return view(
            'admin.evaluaciones.index',
            compact('evaluaciones')
        );
    }

    public function create()
    {
        $modulos = Modulo::with('curso')
            ->orderBy('nombre')
            ->get();

        return view(
            'admin.evaluaciones.create',
            compact('modulos')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'modulo_id'          => 'required|exists:modulos,id',
            'titulo'             => 'required|max:150',
            'descripcion'        => 'nullable',
            'puntaje_aprobacion' => 'required|integer|min:1|max:100',
            'tiempo'             => 'required|integer',
            'estado'             => 'required',
            'preguntas'          => 'nullable|array',
            'preguntas.*.texto'  => 'required_with:preguntas|string',
        ]);

        // Busca lección pero ya NO detiene el proceso si no existe
        $leccion = Leccion::where('modulo_id', $request->modulo_id)->orderBy('orden')->first();

        DB::transaction(function () use ($request, $leccion) {
            // 1. Guardar la evaluación
            $evaluacion = Evaluacion::create([
                'modulo_id'          => $request->modulo_id,
                'leccion_id'         => $leccion ? $leccion->id : null,
                'titulo'             => $request->titulo,
                'descripcion'        => $request->descripcion,
                'puntaje_aprobacion' => $request->puntaje_aprobacion,
                'tiempo'             => $request->tiempo,
                'estado'             => $request->estado,
            ]);

            // 2. Guardar Preguntas y Opciones
            if ($request->has('preguntas')) {
                foreach ($request->preguntas as $pIndex => $pData) {
                    if (empty($pData['texto'])) continue;

                    $pregunta = $evaluacion->preguntas()->create([
                        'texto' => $pData['texto']
                    ]);

                    if (isset($pData['opciones']) && is_array($pData['opciones'])) {
                        foreach ($pData['opciones'] as $oIndex => $oTexto) {
                            if (empty($oTexto)) continue;

                            $pregunta->opciones()->create([
                                'texto'       => $oTexto,
                                'es_correcta' => (isset($pData['correcta']) && $pData['correcta'] == $oIndex)
                            ]);
                        }
                    }
                }
            }
        });

        // Redirección al Dashboard
        return redirect()->route('admin.dashboard')->with('success', 'Evaluación creada exitosamente.');
    }

    public function edit(Evaluacion $evaluacion)
    {
        $modulos = Modulo::with('curso')
            ->orderBy('nombre')
            ->get();

        return view(
            'admin.evaluaciones.edit',
            compact(
                'evaluacion',
                'modulos'
            )
        );
    }

    public function update(Request $request, Evaluacion $evaluacion)
    {
        $request->validate([
            'modulo_id' => 'required|exists:modulos,id',
            'titulo' => 'required|max:150',
            'descripcion' => 'nullable',
            'puntaje_aprobacion' => 'required|integer|min:1|max:100',
            'tiempo' => 'required|integer',
            'estado' => 'required'
        ]);

        $leccion = Leccion::where(
            'modulo_id',
            $request->modulo_id
        )->orderBy('orden')->first();

        if (!$leccion) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'El módulo seleccionado no tiene lecciones.'
                );
        }

        $evaluacion->update([
            'modulo_id'            => $request->modulo_id,
            'leccion_id'           => $leccion->id,
            'titulo'               => $request->titulo,
            'descripcion'          => $request->descripcion,
            'puntaje_aprobacion'   => $request->puntaje_aprobacion,
            'tiempo'               => $request->tiempo,
            'estado'               => $request->estado,
        ]);

        return redirect()
            ->route('evaluaciones.index')
            ->with(
                'success',
                'Evaluación actualizada correctamente.'
            );
    }

    public function destroy(Evaluacion $evaluacion)
    {
        $evaluacion->delete();

        return redirect()
            ->route('evaluaciones.index')
            ->with(
                'success',
                'Evaluación eliminada correctamente.'
            );
    }
}