<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Area;
use App\Models\Modulo;
use App\Models\Leccion;
use App\Models\Evaluacion;
use App\Models\Pregunta;
use App\Models\Opcion;
use App\Models\Recurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::with('area')->orderBy('nombre')->get();

        return view('admin.cursos.index', compact('cursos'));
    }

    public function create()
    {
        $areas = Area::orderBy('nombre')->get();

        return view('admin.cursos.create', compact('areas'));
    }

    /**
     * Convierte una ruta de foto en una ruta física existente.
     * Solo busca dentro de las carpetas autorizadas.
     */
    private function resolverFotoExistente(string $foto): ?string
    {
        $ruta = str_replace('\\', '/', trim($foto));
        $ruta = ltrim($ruta, '/');

        $ruta = preg_replace('#^public/#i', '', $ruta);
        $ruta = preg_replace('#^storage/#i', '', $ruta);

        $candidatas = [];

        if (preg_match('#^imagenes/(Personal|ContenidoCurso)/(.+)$#i', $ruta, $coincidencias)) {
            $candidatas[] = public_path('imagenes/' . $coincidencias[1] . '/' . $coincidencias[2]);
        } elseif (preg_match('#^(Personal|ContenidoCurso)/(.+)$#i', $ruta, $coincidencias)) {
            $candidatas[] = public_path('imagenes/' . $coincidencias[1] . '/' . $coincidencias[2]);
        } elseif (preg_match('#^cursos/equipo/(.+)$#i', $ruta, $coincidencias)) {
            $nombre = basename($coincidencias[1]);

            $candidatas[] = public_path('imagenes/Personal/' . $nombre);
            $candidatas[] = public_path('imagenes/ContenidoCurso/' . $nombre);
        } else {
            return null;
        }

        foreach ($candidatas as $candidata) {
            if (is_file($candidata)) {
                return $candidata;
            }
        }

        return null;
    }

    /**
     * Normaliza una ruta antigua para mostrarla en la interfaz.
     * No cambia la ruta guardada en la base de datos.
     */
    private function urlFoto(string $foto): ?string
    {
        $archivo = $this->resolverFotoExistente($foto);

        if (!$archivo) {
            return null;
        }

        $rutaRelativa = str_replace('\\', '/', $archivo);
        $rutaPublica = str_replace(
            str_replace('\\', '/', public_path()) . '/',
            '',
            $rutaRelativa
        );

        return asset($rutaPublica);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:150',
            'area_id' => 'required|exists:areas,id',
            'descripcion' => 'nullable|string',
            'modulos.*.nombre' => 'required|string|max:150',
            'modulos.*.leccion_titulo' => 'required|string|max:150',
            'modulos.*.recursos.*' => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx,xls,xlsx,csv,jpg,jpeg,png,webp,txt|max:20480',
            'fotos_equipo.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        $fotosPaths = [];
        $archivosCreados = [];

        try {
            DB::transaction(function () use ($request, &$fotosPaths, &$archivosCreados) {
                if ($request->hasFile('fotos_equipo')) {
                    foreach ($request->file('fotos_equipo') as $foto) {
                        if (!$foto->isValid()) {
                            continue;
                        }

                        $nombre = time() . '_' . uniqid() . '.' .
                            strtolower($foto->getClientOriginalExtension());

                        $directorio = public_path('imagenes/Personal');

                        if (!is_dir($directorio)) {
                            mkdir($directorio, 0755, true);
                        }

                        $foto->move($directorio, $nombre);

                        $fotosPaths[] = 'Personal/' . $nombre;
                        $archivosCreados[] = $directorio . DIRECTORY_SEPARATOR . $nombre;
                    }
                }

                $curso = Curso::create([
                    'area_id' => $request->area_id,
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'estado' => 1,
                    'fotos_equipo' => !empty($fotosPaths) ? $fotosPaths : null,
                ]);

                foreach ($request->input('modulos', []) as $index => $mData) {
                    $modulo = Modulo::create([
                        'curso_id' => $curso->id,
                        'nombre' => $mData['nombre'] ?? 'Módulo General',
                    ]);

                    $leccion = Leccion::create([
                        'modulo_id' => $modulo->id,
                        'titulo' => $mData['leccion_titulo'] ?? 'Lección General',
                        'descripcion' => $mData['leccion_contenido'] ?? null,
                    ]);

                    if ($request->hasFile("modulos.{$index}.recursos")) {
                        foreach ($request->file("modulos.{$index}.recursos") as $file) {
                            if (!$file->isValid()) {
                                continue;
                            }

                            $nombreArchivo = time() . '_' . uniqid() . '.' .
                                strtolower($file->getClientOriginalExtension());

                            $directorio = public_path('imagenes/ContenidoCurso');

                            if (!is_dir($directorio)) {
                                mkdir($directorio, 0755, true);
                            }

                            $file->move($directorio, $nombreArchivo);

                            $archivosCreados[] = $directorio . DIRECTORY_SEPARATOR . $nombreArchivo;

                            $leccion->recursos()->create([
                                'nombre' => $file->getClientOriginalName(),
                                'archivo' => 'ContenidoCurso/' . $nombreArchivo,
                            ]);
                        }
                    }

                    if (
                        $index === 0 &&
                        $request->filled('evaluacion_titulo') &&
                        $request->has('preguntas')
                    ) {
                        $evaluacion = Evaluacion::create([
                            'modulo_id' => $modulo->id,
                            'leccion_id' => $leccion->id,
                            'titulo' => $request->evaluacion_titulo,
                        ]);

                        foreach ($request->input('preguntas', []) as $pData) {
                            if (empty($pData['texto'])) {
                                continue;
                            }

                            $pregunta = Pregunta::create([
                                'evaluacion_id' => $evaluacion->id,
                                'pregunta' => $pData['texto'],
                                'tipo' => 'opcion_multiple',
                                'puntaje' => 1,
                                'orden' => 1,
                            ]);

                            foreach (($pData['opciones'] ?? []) as $oIndex => $oTexto) {
                                if (empty($oTexto)) {
                                    continue;
                                }

                                Opcion::create([
                                    'pregunta_id' => $pregunta->id,
                                    'opcion' => $oTexto,
                                    'es_correcta' =>
                                        (isset($pData['correcta']) &&
                                        (string) $pData['correcta'] === (string) $oIndex)
                                            ? 1
                                            : 0,
                                ]);
                            }
                        }
                    }
                }
            });
        } catch (\Throwable $e) {
            foreach ($archivosCreados as $archivo) {
                if (is_file($archivo)) {
                    @unlink($archivo);
                }
            }

            throw $e;
        }

        return redirect()
            ->route('cursos.index')
            ->with('success', '¡Capacitación y recursos creados con éxito!');
    }

    public function show($id)
    {
        $curso = Curso::with([
            'area',
            'modulos.lecciones.recursos',
            'modulos.evaluaciones.preguntas.opciones',
        ])->findOrFail($id);

        return view('admin.cursos.show', compact('curso'));
    }

    public function edit(Curso $curso)
    {
        $areas = Area::orderBy('nombre')->get();
        $curso->load('modulos.lecciones.recursos');

        return view('admin.cursos.edit', compact('curso', 'areas'));
    }

    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'nombre' => 'required|max:150',
            'area_id' => 'required|exists:areas,id',
            'descripcion' => 'nullable|string',
            'estado' => 'required|boolean',
            'modulos.*.nombre' => 'required|string|max:150',
            'modulos.*.leccion_titulo' => 'required|string|max:150',
            'modulos.*.recursos.*' => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx,xls,xlsx,csv,jpg,jpeg,png,webp,txt|max:20480',
            'eliminar_recursos' => 'nullable|array',
            'archivo_pdf' => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx,xls,xlsx|max:20480',
            'fotos_equipo.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        // Trabajar con rutas relativas originales, nunca con URL completas.
        $fotosActuales = $curso->fotos_equipo ?? [];

        if (!is_array($fotosActuales)) {
            $fotosActuales = [];
        }

        $fotosAEliminar = $request->input('eliminar_fotos', []);

        if (!is_array($fotosAEliminar)) {
            $fotosAEliminar = [];
        }

        foreach ($fotosAEliminar as $fotoAEliminar) {
            $indice = array_search($fotoAEliminar, $fotosActuales, true);

            if ($indice !== false) {
                unset($fotosActuales[$indice]);
            }
        }

        $fotosActuales = array_values($fotosActuales);

        $archivosNuevos = [];

        if ($request->hasFile('fotos_equipo')) {
            foreach ($request->file('fotos_equipo') as $foto) {
                if (!$foto->isValid()) {
                    continue;
                }

                $nombre = time() . '_' . uniqid() . '.' .
                    strtolower($foto->getClientOriginalExtension());

                $directorio = public_path('imagenes/Personal');

                if (!is_dir($directorio)) {
                    mkdir($directorio, 0755, true);
                }

                $foto->move($directorio, $nombre);

                $fotosActuales[] = 'Personal/' . $nombre;
                $archivosNuevos[] = $directorio . DIRECTORY_SEPARATOR . $nombre;
            }
        }

        try {
            DB::transaction(function () use ($request, $curso, $fotosActuales, &$archivosNuevos) {
                $curso->update([
                    'area_id' => $request->area_id,
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'estado' => $request->estado,
                    'fotos_equipo' => $fotosActuales,
                ]);

                // Eliminar recursos marcados por el usuario
                if ($request->has('eliminar_recursos')) {
                    $recursosAEliminar = Recurso::whereIn('id', $request->input('eliminar_recursos'))->get();
                    foreach ($recursosAEliminar as $rec) {
                        $rutaFisica = $this->resolverFotoExistente($rec->archivo);
                        if ($rutaFisica && is_file($rutaFisica)) {
                            @unlink($rutaFisica);
                        }
                        $rec->delete();
                    }
                }

                // Recorrer y actualizar los módulos y sus archivos nuevos
                foreach ($request->input('modulos', []) as $index => $mData) {
                    $modulo = Modulo::find($mData['id'] ?? null);
                    if (!$modulo) {
                        continue;
                    }

                    $modulo->update([
                        'nombre' => $mData['nombre'] ?? $modulo->nombre
                    ]);

                    $leccion = Leccion::where('modulo_id', $modulo->id)->first();
                    if ($leccion) {
                        if (isset($mData['leccion_titulo'])) {
                            $leccion->update([
                                'titulo' => $mData['leccion_titulo']
                            ]);
                        }

                        if ($request->hasFile("modulos.{$index}.recursos")) {
                            foreach ($request->file("modulos.{$index}.recursos") as $file) {
                                if (!$file->isValid()) {
                                    continue;
                                }

                                $nombreArchivo = time() . '_' . uniqid() . '.' .
                                    strtolower($file->getClientOriginalExtension());

                                $directorio = public_path('imagenes/ContenidoCurso');

                                if (!is_dir($directorio)) {
                                    mkdir($directorio, 0755, true);
                                }

                                $file->move($directorio, $nombreArchivo);
                                $archivosNuevos[] = $directorio . DIRECTORY_SEPARATOR . $nombreArchivo;

                                $leccion->recursos()->create([
                                    'nombre' => $file->getClientOriginalName(),
                                    'archivo' => 'ContenidoCurso/' . $nombreArchivo,
                                ]);
                            }
                        }
                    }
                }

                // Compatibilidad con PDF general si se envía
                if ($request->hasFile('archivo_pdf')) {
                    $file = $request->file('archivo_pdf');

                    $nombreArchivo = time() . '_' . uniqid() . '.' .
                        strtolower($file->getClientOriginalExtension());

                    $directorio = public_path('imagenes/ContenidoCurso');

                    if (!is_dir($directorio)) {
                        mkdir($directorio, 0755, true);
                    }

                    $file->move($directorio, $nombreArchivo);

                    $rutaArchivo = 'ContenidoCurso/' . $nombreArchivo;
                    $nombreOriginal = $file->getClientOriginalName();

                    foreach ($curso->modulos as $modulo) {
                        $leccion = Leccion::where('modulo_id', $modulo->id)->first();

                        if ($leccion) {
                            Recurso::updateOrCreate(
                                ['leccion_id' => $leccion->id],
                                [
                                    'nombre' => $nombreOriginal,
                                    'archivo' => $rutaArchivo,
                                ]
                            );
                        }
                    }
                }
            });
        } catch (\Throwable $e) {
            foreach ($archivosNuevos as $archivo) {
                if (is_file($archivo)) {
                    @unlink($archivo);
                }
            }

            throw $e;
        }

        // Borrar únicamente fotos que fueron marcadas y retiradas del registro.
        foreach ($fotosAEliminar as $fotoAEliminar) {
            if (in_array($fotoAEliminar, $fotosActuales, true)) {
                continue;
            }

            $ruta = $this->resolverFotoExistente($fotoAEliminar);

            if ($ruta && is_file($ruta)) {
                @unlink($ruta);
            }
        }

        return redirect()
            ->route('cursos.index')
            ->with('success', 'Curso y documentos actualizados correctamente.');
    }

    public function destroy(Curso $curso)
    {
        $fotos = $curso->fotos_equipo ?? [];

        if (!is_array($fotos)) {
            $fotos = [];
        }

        // Guardar las rutas existentes antes de eliminar el registro.
        $rutasFisicas = [];

        foreach ($fotos as $foto) {
            if (!is_string($foto)) {
                continue;
            }

            $ruta = $this->resolverFotoExistente($foto);

            if ($ruta) {
                $rutasFisicas[] = $ruta;
            }
        }

        $curso->delete();

        foreach (array_unique($rutasFisicas) as $ruta) {
            if (is_file($ruta)) {
                @unlink($ruta);
            }
        }

        return redirect()
            ->route('cursos.index')
            ->with('success', 'Curso eliminado.');
    }
}