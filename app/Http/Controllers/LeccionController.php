<?php

namespace App\Http\Controllers;

use App\Models\Leccion;
use App\Models\Modulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'orden'       => 'required|integer',
            'recursos.*'  => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx,jpg,jpeg,png,webp|max:10240'
        ]);

        $leccion = Leccion::create([
            'modulo_id'   => $request->modulo_id,
            'titulo'      => $request->titulo,
            'descripcion' => $request->descripcion,
            'video'       => $request->video,
            'documento'   => $request->documento,
            'orden'       => $request->orden,
        ]);

        // Procesamiento seguro de multiples recursos adjuntos con nombres limpios
        if ($request->hasFile('recursos')) {
            foreach ($request->file('recursos') as $file) {
                // Generamos un nombre unico y seguro para evitar conflictos de caracteres especiales
                $nombreArchivo = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                $path = $file->storeAs('lecciones/recursos', $nombreArchivo, 'public');
                
                $leccion->recursos()->create([
                    'titulo'  => $file->getClientOriginalName(),
                    'archivo' => $path
                ]);
            }
        }

        return redirect()
            ->route('lecciones.index')
            ->with('success', 'Leccion y recursos creados correctamente.');
    }

    public function show(Leccion $leccion)
    {
        $leccion->load([
            'modulo',
            'recursos'
        ]);

        return view(
            'admin.lecciones.show',
            compact('leccion')
        );
    }

    public function edit(Leccion $leccion)
    {
        $leccion->load('recursos');
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
            'orden'       => 'required|integer',
            'recursos.*'  => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx,jpg,jpeg,png,webp|max:10240'
        ]);

        $leccion->update([
            'modulo_id'   => $request->modulo_id,
            'titulo'      => $request->titulo,
            'descripcion' => $request->descripcion,
            'video'       => $request->video,
            'documento'   => $request->documento,
            'orden'       => $request->orden,
        ]);

        // Agregar nuevos recursos si se adjuntan en la edicion
        if ($request->hasFile('recursos')) {
            foreach ($request->file('recursos') as $file) {
                $nombreArchivo = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                $path = $file->storeAs('lecciones/recursos', $nombreArchivo, 'public');
                
                $leccion->recursos()->create([
                    'titulo'  => $file->getClientOriginalName(),
                    'archivo' => $path
                ]);
            }
        }

        return redirect()
            ->route('lecciones.index')
            ->with('success', 'Leccion actualizada correctamente.');
    }

    public function destroy(Leccion $leccion)
    {
        // Eliminacion fisica de los archivos almacenados antes de borrar la leccion
        foreach ($leccion->recursos as $recurso) {
            if (Storage::disk('public')->exists($recurso->archivo)) {
                Storage::disk('public')->delete($recurso->archivo);
            }
            $recurso->delete();
        }

        $leccion->delete();

        return redirect()
            ->route('lecciones.index')
            ->with('success', 'Leccion y archivos eliminados correctamente.');
    }
}