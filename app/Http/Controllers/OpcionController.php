<?php

namespace App\Http\Controllers;

use App\Models\Opcion;
use App\Models\Pregunta;
use Illuminate\Http\Request;

class OpcionController extends Controller
{
    public function index()
    {
        $opciones = Opcion::with('pregunta')
            ->orderBy('id')
            ->get();

        return view('admin.opciones.index', compact('opciones'));
    }

    public function create(Request $request)
    {
        $preguntas = Pregunta::orderBy('pregunta')->get();

        $preguntaSeleccionada = $request->pregunta;

        return view(
            'admin.opciones.create',
            compact(
                'preguntas',
                'preguntaSeleccionada'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'pregunta_id'=>'required|exists:preguntas,id',
            'texto'=>'required',
            'es_correcta'=>'required'
        ]);

        Opcion::create($request->all());

        return redirect()
            ->route('opciones.index')
            ->with('success','Opción creada correctamente.');
    }

    public function edit(Opcion $opcion)
    {
        $preguntas = Pregunta::orderBy('pregunta')->get();

        return view(
            'admin.opciones.edit',
            compact(
                'opcion',
                'preguntas'
            )
        );
    }

    public function update(Request $request,Opcion $opcion)
    {
        $request->validate([
            'pregunta_id'=>'required|exists:preguntas,id',
            'texto'=>'required',
            'es_correcta'=>'required'
        ]);

        $opcion->update($request->all());

        return redirect()
            ->route('opciones.index')
            ->with('success','Opción actualizada correctamente.');
    }

    public function destroy(Opcion $opcion)
    {
        $opcion->delete();

        return redirect()
            ->route('opciones.index')
            ->with('success','Opción eliminada correctamente.');
    }
}