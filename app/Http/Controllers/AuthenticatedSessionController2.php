<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Procesar login
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validar los datos del formulario
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // 2. Revisar si escribió un correo o un nombre de usuario
        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // 3. Intentar iniciar sesión
        if (Auth::attempt([$field => $request->login, 'password' => $request->password], $request->boolean('remember'))) {
            
            // Regenerar la sesión por seguridad (evita ataques de fijación de sesión)
            $request->session()->regenerate();

            // Redirigir al evaluador principal de rutas
            return redirect()->intended('/home');
        }

        // SI FALLA: Lo devolvemos al login con el error
        return back()->withErrors([
            'login' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('login');
    }

    /**
     * Cerrar sesión
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}