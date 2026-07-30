<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\Curso;
use Illuminate\Http\Request;

class ModuloController extends Controller
{
    public function index()
    {
        $modulos = Modulo::with('curso')
            ->orderBy('orden')
            ->get();

        return view('admin.modulos.index', compact('modulos'));
    }

    public function create()
    {
        $cursos = Curso::orderBy('nombre')->get();

        return view('admin.modulos.create', compact('cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'curso_id' => 'required',
            'nombre' => 'required|max:150',
            'descripcion' => 'nullable',
            'orden' => 'required|integer'
        ]);

        Modulo::create($request->all());

        return redirect()
            ->route('modulos.index')
            ->with('success', 'Módulo creado correctamente.');
    }

    public function edit(Modulo $modulo)
    {
        $cursos = Curso::orderBy('nombre')->get();

        return view('admin.modulos.edit', compact('modulo', 'cursos'));
    }

    public function update(Request $request, Modulo $modulo)
    {
        $request->validate([
            'curso_id' => 'required',
            'nombre' => 'required|max:150',
            'descripcion' => 'nullable',
            'orden' => 'required|integer'
        ]);

        $modulo->update($request->all());

        return redirect()
            ->route('modulos.index')
            ->with('success', 'Módulo actualizado correctamente.');
    }

    public function destroy(Modulo $modulo)
    {
        $modulo->delete();

        return redirect()
            ->route('modulos.index')
            ->with('success', 'Módulo eliminado correctamente.');
    }
}