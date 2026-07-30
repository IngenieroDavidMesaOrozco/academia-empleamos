<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Area;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::with('area')
            ->orderBy('nombre')
            ->get();

        return view('admin.cursos.index', compact('cursos'));
    }

    public function create()
    {
        $areas = Area::orderBy('nombre')->get();

        return view('admin.cursos.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'area_id' => 'required|exists:areas,id',
            'nombre' => 'required|max:150',
            'descripcion' => 'nullable',
            'imagen' => 'nullable',
            'estado' => 'required'
        ]);

        Curso::create($request->all());

        return redirect()
            ->route('cursos.index')
            ->with('success', 'Curso creado correctamente.');
    }

    public function edit(Curso $curso)
    {
        $areas = Area::orderBy('nombre')->get();

        return view('admin.cursos.edit', compact('curso', 'areas'));
    }

    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'area_id' => 'required|exists:areas,id',
            'nombre' => 'required|max:150',
            'descripcion' => 'nullable',
            'imagen' => 'nullable',
            'estado' => 'required'
        ]);

        $curso->update($request->all());

        return redirect()
            ->route('cursos.index')
            ->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy(Curso $curso) {
         $curso->delete(); return redirect()
         ->route('cursos.index') 
         ->with('success', 'Curso eliminado correctamente.'); }
}
