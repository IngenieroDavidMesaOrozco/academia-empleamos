<?php

namespace App\Listeners;

use App\Models\Parametro;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class VerificarCambioPasswordListener
{
    public function handle(\Illuminate\Auth\Events\Login $event)
    {
        // ⚠️ Refrescar datos desde base de datos
        $user = $event->user->fresh();

        $parametro = Parametro::first();
        $dias = $parametro ? $parametro->tiempo_para_cambio_contraseña : 90;

        if (is_null($dias)) {
            return;
        }

        $fechaUltimaActualizacion = $user->updated_at ?? $user->created_at;

        $fechaLimite = Carbon::parse($fechaUltimaActualizacion)->addDays($dias);

        if (now()->greaterThan($fechaLimite)) {
            Session::put('forzar_cambio_password', true);
        }
    }
}
