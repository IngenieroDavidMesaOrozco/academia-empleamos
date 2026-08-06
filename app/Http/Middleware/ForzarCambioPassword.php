<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if ($request->routeIs('password.forzar.cambio') || $request->routeIs('password.procesar.cambio') || $request->routeIs('password.procesar_cambio')) {
            return $next($request);
        }

        // ** NUEVO ** Si es estudiante y no ha visto el video, no lo obligue a cambiar la clave AUN
        if ($user->hasRole(['estudiante', 'Estudiante']) && !$user->vio_video_bienvenida) {
            return $next($request);
        }

        // Expulsar a usuarios cuya clave temporal expiró
        if ($user->password_temporal && $user->password_expires_at && now()->greaterThan($user->password_expires_at)) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Tu contraseña temporal ha caducado. Ponte en contacto con soporte.',
            ]);
        }

        // Evaluar cambio periódico desde la tabla de parámetros
        $diasPeriodo = 90;
        $diasDesdeUltimoCambio = $user->last_password_change ? $user->last_password_change->diffInDays(now()) : 999;

        if ($user->password_temporal || $diasDesdeUltimoCambio >= $diasPeriodo) {
            session(['forzar_cambio_password' => true]);
            return redirect()->route('password.forzar.cambio');
        }

        return $next($request);
    }
}
