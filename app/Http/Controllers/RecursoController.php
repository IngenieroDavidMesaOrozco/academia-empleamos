<?php

namespace App\Http\Controllers;

use App\Models\Recurso;
use App\Models\Leccion;
use Illuminate\Http\Request;

class RecursoController extends Controller
{
    public function index(Request $request)
    {
        $query = Recurso::with('leccion');

        if ($request->filled('leccion')) {
            $query->where('leccion_id', $request->leccion);
        }

        $recursos = $query->latest()->get();

        return view(
            'admin.recursos.index',
            compact('recursos')
        );
    }

    public function create(Request $request)
    {
        $lecciones = Leccion::orderBy('titulo')->get();

        $leccionSeleccionada = $request->leccion;

        return view(
            'admin.recursos.create',
            compact(
                'lecciones',
                'leccionSeleccionada'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'leccion_id' => 'required|exists:lecciones,id',
            'nombre'     => 'required|max:150',
            'tipo'       => 'required',
            'archivo'    => 'required|file|max:51200'
        ]);

        $ruta = $request->file('archivo')->store('recursos', 'public');

        Recurso::create([
            'leccion_id' => $request->leccion_id,
            'nombre'     => $request->nombre,
            'tipo'       => $request->tipo,
            'archivo'    => $ruta
        ]);

        return redirect()
            ->route('recursos.index')
            ->with('success', 'Recurso cargado correctamente.');
    }

    public function edit(Recurso $recurso)
    {
        $lecciones = Leccion::orderBy('titulo')->get();

        return view(
            'admin.recursos.edit',
            compact(
                'recurso',
                'lecciones'
            )
        );
    }

    public function update(Request $request, Recurso $recurso)
    {
        $request->validate([
            'leccion_id' => 'required|exists:lecciones,id',
            'nombre'     => 'required|max:150',
            'tipo'       => 'required',
            'archivo'    => 'nullable|file|max:51200'
        ]);

        if ($request->hasFile('archivo')) {

            $ruta = $request->file('archivo')
                ->store('recursos', 'public');

            $recurso->archivo = $ruta;
        }

        $recurso->leccion_id = $request->leccion_id;
        $recurso->nombre     = $request->nombre;
        $recurso->tipo       = $request->tipo;

        $recurso->save();

        return redirect()
            ->route('recursos.index')
            ->with('success', 'Recurso actualizado correctamente.');
    }

    public function destroy(Recurso $recurso)
    {
        $recurso->delete();

        return redirect()
            ->route('recursos.index')
            ->with('success', 'Recurso eliminado correctamente.');
    }
}