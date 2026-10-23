<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Pregunta;
use App\Models\Opcion;
use App\Models\Evaluacion;
use App\Models\Modulo;
use App\Models\Leccion;
use App\Models\Certificado; // Agregado para generar el certificado
use Illuminate\Http\Request;

class EvaluacionController extends Controller
{
    public function index()
    {
        $evaluaciones = Evaluacion::with('modulo.curso')
            ->orderBy('titulo')
            ->get();

        return view('admin.evaluaciones.index', compact('evaluaciones'));
    }

    public function create()
    {
        $modulos = Modulo::with('curso')
            ->orderBy('nombre')
            ->get();

        return view('admin.evaluaciones.create', compact('modulos'));
    }

  public function store(Request $request)
    {
        $request->validate([
            'modulo_id'           => 'required|exists:modulos,id',
            'titulo'             => 'required|max:150',
            'puntaje_aprobacion' => 'required|integer|min:1|max:100',
            'tiempo'             => 'required|integer',
            'estado'             => 'required',
            'archivo_pdf'        => 'nullable|mimes:pdf|max:10000', // Máximo 10MB
            'preguntas'          => 'nullable|array',
        ]);

        $leccion = \App\Models\Leccion::where('modulo_id', $request->modulo_id)->orderBy('orden')->first();

        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $leccion) {
            
            // 1. Guardar el archivo PDF
            $rutaPdf = null;
            if ($request->hasFile('archivo_pdf')) {
                $rutaPdf = $request->file('archivo_pdf')->store('cursos', 'public');
            }

            // 2. Crear la evaluación
            $evaluacion = \App\Models\Evaluacion::create([
                'modulo_id'          => $request->modulo_id,
                'leccion_id'         => $leccion ? $leccion->id : null,
                'titulo'             => $request->titulo,
                'descripcion'        => $request->descripcion,
                'puntaje_aprobacion' => $request->puntaje_aprobacion,
                'tiempo'             => $request->tiempo,
                'estado'             => $request->estado,
                'archivo_pdf'        => $rutaPdf,
            ]);

            // 3. Guardar las preguntas y opciones de forma robusta
            if ($request->has('preguntas')) {
                foreach ($request->preguntas as $pIndex => $pData) {
                    if (empty($pData['texto'])) continue;

                    $pregunta = $evaluacion->preguntas()->create([
                        'texto' => $pData['texto']
                    ]);

                    if (isset($pData['opciones']) && is_array($pData['opciones'])) {
                        // Obtenemos qué opción marcó el administrador como correcta para esta pregunta específica
                        $opcionCorrectaIndex = $pData['correcta'] ?? null;

                        foreach ($pData['opciones'] as $oIndex => $oTexto) {
                            if (empty($oTexto)) continue;

                            // Comprobación flexible (permite comparar tanto cadenas como números de forma segura)
                            $esCorrecta = (!is_null($opcionCorrectaIndex) && (string)$opcionCorrectaIndex === (string)$oIndex) ? 1 : 0;

                            $pregunta->opciones()->create([
                                'texto'       => $oTexto,
                                'es_correcta' => $esCorrecta
                            ]);
                        }
                    }
                }
            }
        });

        return redirect()->route('evaluaciones.index')->with('success', 'Evaluación y presentación creadas exitosamente.');
    }

    public function edit(Evaluacion $evaluacion)
    {
        $modulos = Modulo::with('curso')->orderBy('nombre')->get();

        return view('admin.evaluaciones.edit', compact('evaluacion', 'modulos'));
    }

    public function update(Request $request, Evaluacion $evaluacion)
    {
        $request->validate([
            'modulo_id' => 'required|exists:modulos,id',
            'titulo' => 'required|max:150',
            'descripcion' => 'nullable',
            'puntaje_aprobacion' => 'required|integer|min:1|max:100',
            'tiempo' => 'required|integer',
            'estado' => 'required'
        ]);

        $leccion = Leccion::where('modulo_id', $request->modulo_id)->orderBy('orden')->first();

        if (!$leccion) {
            return back()->withInput()->with('error', 'El módulo seleccionado no tiene lecciones.');
        }

        $evaluacion->update([
            'modulo_id'          => $request->modulo_id,
            'leccion_id'         => $leccion->id,
            'titulo'             => $request->titulo,
            'descripcion'        => $request->descripcion,
            'puntaje_aprobacion' => $request->puntaje_aprobacion,
            'tiempo'             => $request->tiempo,
            'estado'             => $request->estado,
        ]);

        return redirect()->route('evaluaciones.index')->with('success', 'Evaluación actualizada correctamente.');
    }

    public function destroy(Evaluacion $evaluacion)
    {
        $evaluacion->delete();

        return redirect()->route('evaluaciones.index')->with('success', 'Evaluación eliminada correctamente.');
    }

public function procesarExamen(Request $request, Evaluacion $evaluacion)
{
    // Aprobación directa eliminando la validación de respuestas
    $puntaje = 100;

    // Generamos o recuperamos el certificado directamente
    $cursoId = $evaluacion->modulo->curso_id; 
    $codigoUnico = strtoupper(uniqid('CERT-'));

    $certificado = Certificado::where('usuario_id', auth()->id())
                               ->where('curso_id', $cursoId)
                               ->first();

    if (!$certificado) {
        $certificado = Certificado::create([
            'usuario_id'    => auth()->id(),
            'curso_id'      => $cursoId,
            'codigo'        => $codigoUnico,
            'fecha_emision' => now(),
        ]);
    }

    return redirect()->route('certificado.show', $certificado->id)
                     ->with('success', '¡Felicitaciones! Evaluación completada con éxito.');
}
}