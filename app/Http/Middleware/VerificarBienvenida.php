<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificarBienvenida
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        // Only enforce for students
        if ($user->hasRole(['estudiante', 'Estudiante'])) {
            // Allow access to the welcome view and complete action
            if ($request->routeIs('estudiante.bienvenida') || $request->routeIs('estudiante.bienvenida.completar')) {
                return $next($request);
            }

            // Redirect if they haven't watched the video
            if (!$user->vio_video_bienvenida) {
                return redirect()->route('estudiante.bienvenida');
            }
        }

        return $next($request);
    }
}
