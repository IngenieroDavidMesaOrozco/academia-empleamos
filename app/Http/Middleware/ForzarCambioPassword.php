<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ForzarCambioPassword
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        // Omitir verificación a roles administrativos
        if ($user->hasRole(['SuperAdmin', 'Admin', 'admin', 'Administrador'])) {
            return $next($request);
        }

        // Permitir acceso libre a las rutas del propio formulario de cambio
        if ($request->routeIs('password.forzar.cambio') || $request->routeIs('password.procesar.cambio')) {
            return $next($request);
        }

        // Expulsar a usuarios cuya clave temporal expiró
        if ($user->password_temporal && $user->password_expires_at && now()->greaterThan($user->password_expires_at)) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'login' => 'Tu contraseña temporal ha caducado. Ponte en contacto con soporte.',
            ]);
        }

        // Evaluar cambio periódico
        $diasPeriodo = 90;
        $diasDesdeUltimoCambio = 999;

        // PARSEO SEGURO: Convertimos a fecha de Carbon para evitar errores 500
        if ($user->last_password_change) {
            $fechaCambio = Carbon::parse($user->last_password_change);
            $diasDesdeUltimoCambio = $fechaCambio->diffInDays(now());
        }

        if ($user->password_temporal || $diasDesdeUltimoCambio >= $diasPeriodo) {
            session(['forzar_cambio_password' => true]);
            return redirect()->route('password.forzar.cambio');
        }

        return $next($request);
    }
}