<?php

namespace App\Http\Controllers;

use App\Models\Certificado;

class CertificadoController extends Controller
{
    public function show(Certificado $certificado)
    {
        if ($certificado->usuario_id != auth()->id()) {
            abort(403);
        }

        $certificado->load('curso', 'usuario');

        return view(
            'estudiante.certificado',
            compact('certificado')
        );
    }
}