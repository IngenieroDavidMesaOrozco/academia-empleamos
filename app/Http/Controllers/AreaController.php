<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::orderBy('nombre')->get();
        return view('admin.areas.index', compact('areas'));
    }

    public function create()
    {
        return view('admin.areas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100|unique:areas,nombre',
            'descripcion' => 'nullable|string',
            'video' => 'nullable|string', // URL o path
            'archivo_diapositivas' => 'nullable|file|mimes:pdf,ppt,pptx|max:10240', // Max 10MB
        ]);

        $data = $request->only(['nombre', 'descripcion', 'video']);

        if ($request->hasFile('archivo_diapositivas')) {
            $path = $request->file('archivo_diapositivas')->store('diapositivas', 'public');
            $data['archivo_diapositivas'] = $path;
        }

        Area::create($data);

        return redirect()
            ->route('areas.index')
            ->with('success', 'Área creada correctamente.');
    }

    public function edit(Area $area)
    {
        return view('admin.areas.edit', compact('area'));
    }

    public function update(Request $request, Area $area)
    {
        $request->validate([
            'nombre' => 'required|max:100|unique:areas,nombre,' . $area->id,
            'descripcion' => 'nullable|string',
            'video' => 'nullable|string',
            'archivo_diapositivas' => 'nullable|file|mimes:pdf,ppt,pptx|max:10240',
        ]);

        $data = $request->only(['nombre', 'descripcion', 'video']);

        if ($request->hasFile('archivo_diapositivas')) {
            // Delete old file
            if ($area->archivo_diapositivas && Storage::disk('public')->exists($area->archivo_diapositivas)) {
                Storage::disk('public')->delete($area->archivo_diapositivas);
            }

            $path = $request->file('archivo_diapositivas')->store('diapositivas', 'public');
            $data['archivo_diapositivas'] = $path;
        }

        $area->update($data);

        return redirect()
            ->route('areas.index')
            ->with('success', 'Área actualizada correctamente.');
    }

    public function destroy(Area $area)
    {
        if ($area->archivo_diapositivas && Storage::disk('public')->exists($area->archivo_diapositivas)) {
            Storage::disk('public')->delete($area->archivo_diapositivas);
        }

        $area->delete();

        return redirect()
            ->route('areas.index')
            ->with('success', 'Área eliminada correctamente.');
    }
}
