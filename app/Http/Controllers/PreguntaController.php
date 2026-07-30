<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use App\Models\Evaluacion;
use Illuminate\Http\Request;

class PreguntaController extends Controller
{
    public function index()
    {
        $preguntas = Pregunta::with('evaluacion')
            ->latest()
            ->get();

        return view('admin.preguntas.index', compact('preguntas'));
    }

    public function create(Request $request)
    {
        $evaluaciones = Evaluacion::orderBy('titulo')->get();

        $evaluacionSeleccionada = $request->evaluacion;

        return view(
            'admin.preguntas.create',
            compact(
                'evaluaciones',
                'evaluacionSeleccionada'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'evaluacion_id' => 'required|exists:evaluaciones,id',
            'pregunta' => 'required'
        ]);

        Pregunta::create([
            'evaluacion_id' => $request->evaluacion_id,
            'pregunta' => $request->pregunta
        ]);

        return redirect()
            ->route('preguntas.index')
            ->with('success','Pregunta creada correctamente.');
    }

    public function edit(Pregunta $pregunta)
    {
        $evaluaciones = Evaluacion::orderBy('titulo')->get();

        return view(
            'admin.preguntas.edit',
            compact(
                'pregunta',
                'evaluaciones'
            )
        );
    }

    public function update(Request $request, Pregunta $pregunta)
    {
        $request->validate([
            'evaluacion_id' => 'required|exists:evaluaciones,id',
            'pregunta' => 'required'
        ]);

        $pregunta->update([
            'evaluacion_id' => $request->evaluacion_id,
            'pregunta' => $request->pregunta
        ]);

        return redirect()
            ->route('preguntas.index')
            ->with('success','Pregunta actualizada correctamente.');
    }

    public function destroy(Pregunta $pregunta)
    {
        $pregunta->delete();

        return redirect()
            ->route('preguntas.index')
            ->with('success','Pregunta eliminada correctamente.');
    }
}