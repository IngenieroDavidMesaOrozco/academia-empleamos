<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTAR ÁREAS
    |--------------------------------------------------------------------------
    | Muestra todas las áreas registradas ordenadas alfabéticamente.
    | Esta es la vista principal que ve el administrador.
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $areas = Area::orderBy('nombre')->get();

        return view('admin.areas.index', compact('areas'));
    }

    /*
    |--------------------------------------------------------------------------
    | FORMULARIO DE CREACIÓN
    |--------------------------------------------------------------------------
    | Muestra el formulario para crear una nueva área.
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('admin.areas.create');
    }

    /*
    |--------------------------------------------------------------------------
    | GUARDAR NUEVA ÁREA
    |--------------------------------------------------------------------------
    | Valida la información enviada por el formulario y crea el registro
    | en la base de datos.
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        // Validación del formulario
        $request->validate([
            'nombre' => 'required|max:100|unique:areas,nombre',
        ]);

        // Crear el área
        Area::create([
            'nombre' => $request->nombre,
        ]);

        // Redireccionar con mensaje de éxito
        return redirect()
            ->route('areas.index')
            ->with('success', 'Área creada correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | FORMULARIO DE EDICIÓN
    |--------------------------------------------------------------------------
    | Muestra el formulario con los datos del área seleccionada.
    |--------------------------------------------------------------------------
    */
    public function edit(Area $area)
    {
        return view('admin.areas.edit', compact('area'));
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR ÁREA
    |--------------------------------------------------------------------------
    | Valida la información y actualiza el área seleccionada.
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Area $area)
    {
        // Validación
        $request->validate([
            'nombre' => 'required|max:100|unique:areas,nombre,' . $area->id,
        ]);

        // Actualizar datos
        $area->update([
            'nombre' => $request->nombre,
        ]);

        // Redireccionar con mensaje
        return redirect()
            ->route('areas.index')
            ->with('success', 'Área actualizada correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | ELIMINAR ÁREA
    |--------------------------------------------------------------------------
    | Elimina el área seleccionada de la base de datos.
    |--------------------------------------------------------------------------
    */
    public function destroy(Area $area)
    {
        $area->delete();

        return redirect()
            ->route('areas.index')
            ->with('success', 'Área eliminada correctamente.');
    }
}