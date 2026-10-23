<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'foto_lider' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_lider')) {
            $file = $request->file('foto_lider');
            $nombre = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('imagenes/JefeDeArea'), $nombre);
            $fotoPath = 'JefeDeArea/' . $nombre;
        }

        Area::create([
            'nombre' => $request->nombre,
            'foto_lider' => $fotoPath,
        ]);

        return redirect()->route('areas.index')->with('success', 'Área creada correctamente.');
    }

    public function edit(Area $area)
    {
        return view('admin.areas.edit', compact('area'));
    }

   public function update(Request $request, Area $area)
    {
        $request->validate([
            'nombre' => 'required|max:100|unique:areas,nombre,' . $area->id,
            'foto_lider' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $fotoPath = $area->foto_lider;
        
        if ($request->hasFile('foto_lider')) {
            // Eliminar la foto anterior si existe en public/imagenes/
            if ($area->foto_lider) {
                $oldPath = public_path('imagenes/' . $area->foto_lider);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Subir la nueva imagen a public/imagenes/JefeDeArea
            $file = $request->file('foto_lider');
            $nombre = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('imagenes/JefeDeArea'), $nombre);
            
            // Guardamos la ruta relativa que va dentro de public/imagenes/
            $fotoPath = 'JefeDeArea/' . $nombre;
        }

        $area->update([
            'nombre' => $request->nombre,
            'foto_lider' => $fotoPath,
        ]);

        return redirect()->route('areas.index')->with('success', 'Área actualizada correctamente.');
    }

    public function destroy(Area $area)
    {
        DB::transaction(function () use ($area) {
            if ($area->foto_lider) {
                $oldPath = public_path('imagenes/' . $area->foto_lider);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            foreach ($area->cursos as $curso) {
                $curso->delete();
            }

            $area->delete();
        });

        return redirect()->route('areas.index')->with('success', 'Área y sus cursos asociados eliminados correctamente.');
    }
}
