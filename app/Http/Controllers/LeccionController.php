<?php

namespace App\Http\Controllers;

use App\Models\Leccion;
use App\Models\Modulo;
use Illuminate\Http\Request;

class LeccionController extends Controller
{
    public function index(Request $request)
    {
        $query = Leccion::with('modulo');

        if ($request->filled('modulo')) {
            $query->where('modulo_id', $request->modulo);
        }

        $lecciones = $query
            ->orderBy('orden')
            ->get();

        return view(
            'admin.lecciones.index',
            compact('lecciones')
        );
    }

    public function create()
    {
        $modulos = Modulo::orderBy('nombre')->get();

        return view(
            'admin.lecciones.create',
            compact('modulos')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'modulo_id'   => 'required',
            'titulo'      => 'required|max:150',
            'descripcion' => 'nullable',
            'video'       => 'nullable',
            'documento'   => 'nullable',
            'orden'       => 'required|integer'
        ]);

        Leccion::create($request->all());

        return redirect()
            ->route('lecciones.index')
            ->with('success', 'Lección creada correctamente.');
    }

    /**
     * Vista para el estudiante
     */
    public function show(Leccion $leccion)
    {
        $leccion->load([
            'modulo',
            'recursos'
        ]);

        return view(
            'estudiante.leccion',
            compact('leccion')
        );
    }

    public function edit(Leccion $leccion)
    {
        $modulos = Modulo::orderBy('nombre')->get();

        return view(
            'admin.lecciones.edit',
            compact(
                'leccion',
                'modulos'
            )
        );
    }

    public function update(Request $request, Leccion $leccion)
    {
        $request->validate([
            'modulo_id'   => 'required',
            'titulo'      => 'required|max:150',
            'descripcion' => 'nullable',
            'video'       => 'nullable',
            'documento'   => 'nullable',
            'orden'       => 'required|integer'
        ]);

        $leccion->update($request->all());

        return redirect()
            ->route('lecciones.index')
            ->with('success', 'Lección actualizada correctamente.');
    }

    public function destroy(Leccion $leccion)
    {
        $leccion->delete();

        return redirect()
            ->route('lecciones.index')
            ->with('success', 'Lección eliminada correctamente.');
    }
}