<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Area;
use App\Models\Modulo;
use App\Models\Leccion;
use App\Models\Evaluacion;
use App\Models\Pregunta;
use App\Models\Opcion;
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

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:150',
            'area_id' => 'required|exists:areas,id',
        ]);

        DB::transaction(function () use ($request) {
            $curso = Curso::create([
                'area_id' => $request->area_id,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'estado' => 1,
            ]);

            $modulo = Modulo::create([
                'curso_id' => $curso->id,
                'nombre' => $request->modulo_nombre ?? 'Módulo General',
            ]);

            $leccion = Leccion::create([
                'modulo_id' => $modulo->id,
                'titulo' => $request->leccion_titulo ?? 'Lección General',
            ]);

            if ($request->filled('evaluacion_titulo') && $request->has('preguntas')) {
                $evaluacion = Evaluacion::create([
                    'modulo_id'  => $modulo->id,
                    'leccion_id' => $leccion->id,
                    'titulo'     => $request->evaluacion_titulo,
                ]);

                foreach ($request->preguntas as $pData) {
                    if (!empty($pData['texto'])) {
                        $pregunta = Pregunta::create([
                            'evaluacion_id' => $evaluacion->id,
                            'pregunta'      => $pData['texto'], 
                            'tipo'          => 'opcion_multiple',
                            'puntaje'       => 1,
                            'orden'         => 1,
                        ]);

                        if (isset($pData['opciones'])) {
                            foreach ($pData['opciones'] as $index => $oTexto) {
                                if (!empty($oTexto)) {
                                    Opcion::create([
                                        'pregunta_id' => $pregunta->id,
                                        'opcion'      => $oTexto,
                                        'es_correcta' => (isset($pData['correcta']) && $pData['correcta'] == $index) ? 1 : 0,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        });

        return redirect()->route('cursos.index')->with('success', '¡Capacitación creada con éxito!');
    }

    public function show($id)
    {
        // CORREGIDO: Se cambia 'evaluaciones' por 'modulos.evaluaciones' para que coincida con la base de datos
        $curso = Curso::with(['area', 'modulos.lecciones', 'modulos.evaluaciones.preguntas.opciones'])->findOrFail($id);
        return view('admin.cursos.show', compact('curso'));
    }

    public function edit(Curso $curso)
    {
        $areas = Area::orderBy('nombre')->get();
        return view('admin.cursos.edit', compact('curso', 'areas'));
    }

    public function update(Request $request, Curso $curso)
    {
        $curso->update($request->all());
        return redirect()->route('cursos.index')->with('success', 'Curso actualizado.');
    }

    public function destroy(Curso $curso)
    {
        $curso->delete();
        return redirect()->route('cursos.index')->with('success', 'Curso eliminado.');
    }
}