<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificado;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class CertificadoController extends Controller
{
    // 1. Esta función solo muestra la pantalla web de éxito (la del 🎉)
    public function show($id)
    {
        $certificado = Certificado::findOrFail($id);
        
        // Carga tu archivo certificado.blade.php
        return view('admin.estudiante.certificado', compact('certificado'));
    }

    // 2. Esta función EXCLUSIVAMENTE arma y descarga el PDF
  public function descargar($id)
    {
        $certificado = Certificado::findOrFail($id);

        $data = [
            // Toma el nombre de quien hizo el examen
            'nombre_usuario' => $certificado->usuario->name . ' ' . $certificado->usuario->last_name,
            'documento'      => $certificado->usuario->documento ?? '', 
            // Toma el nombre del curso/área que aprobó
            'curso_nombre'   => $certificado->curso->nombre,
            'codigo'         => $certificado->codigo,
            'fecha'          => \Carbon\Carbon::parse($certificado->fecha_emision)->format('d/m/Y')
        ];

        $pdf = Pdf::loadView('admin.estudiante.certificado_pdf', $data);
        
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Certificado_' . $certificado->codigo . '.pdf');
    }
}