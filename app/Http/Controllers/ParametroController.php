<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parametro;
use Illuminate\Support\Facades\File;

class ParametroController extends Controller
{
    public function edit()
    {
        $parametro = Parametro::first();
        return view('parametros.edit', compact('parametro'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'tiempo_para_cambio_contraseña' => 'required|integer|min:1|max:365',
            'video_bienvenida' => 'nullable|file|mimes:mp4|max:51200',
        ]);

        $parametro = Parametro::first();
        $parametro->update([
            'tiempo_para_cambio_contraseña' => $request->tiempo_para_cambio_contraseña,
        ]);

        // Manejar video
        if ($request->has('eliminar_video')) {
            $path = public_path('videos/Bienvenida.mp4');
            if (File::exists($path)) {
                File::delete($path);
            }
            return redirect()->route('parametros.edit')
                ->with('success', 'Video eliminado correctamente.');
        }

        if ($request->hasFile('video_bienvenida')) {
            $file = $request->file('video_bienvenida');
            
            // Crear carpeta si no existe
            $videosPath = public_path('videos');
            if (!File::exists($videosPath)) {
                File::makeDirectory($videosPath, 0755, true);
            }

            // Eliminar video anterior
            $oldPath = public_path('videos/Bienvenida.mp4');
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }

            // Guardar nuevo video
            $file->move($videosPath, 'Bienvenida.mp4');

            return redirect()->route('parametros.edit')
                ->with('success', 'Video subido correctamente.');
        }

        return redirect()->route('parametros.edit')
            ->with('success', 'Configuración actualizada correctamente.');
    }
}