<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgresoLeccion;
use Illuminate\Support\Facades\Auth;

class ProgresoController extends Controller
{
    public function completar($id)
    {
        ProgresoLeccion::updateOrCreate(

            [
                'usuario_id' => Auth::id(),
                'leccion_id' => $id
            ],

            [
                'completada' => true,
                'fecha' => now()
            ]

        );

        return back()->with(
            'success',
            'Lección completada correctamente.'
        );
    }
}