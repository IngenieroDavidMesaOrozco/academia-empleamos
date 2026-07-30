<?php

// app/Http/Controllers/ParametroController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parametro;

class ParametroController extends Controller
{
    public function edit()
    {
        $parametro = Parametro::first(); // solo hay uno
        return view('parametros.edit', compact('parametro'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'tiempo_para_cambio_contraseña' => 'required|integer|min:1|max:365',
        ]);

        $parametro = Parametro::first();
        $parametro->update([
            'tiempo_para_cambio_contraseña' => $request->tiempo_para_cambio_contraseña,
        ]);

        return redirect()->route('parametros.edit')->with('success', 'Parámetro actualizado correctamente.');
    }
}
