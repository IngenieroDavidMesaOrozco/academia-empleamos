<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use App\Providers\RouteServiceProvider;
class AuthenticatedSessionController extends Controller
{

public function create()
    {
        return view('auth.login');
    }
public function store(Request $request)
{
    $request->validate([
        'login' => 'required|string',
        'password' => 'required|string',
    ]);

    $login_type = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    $user = \App\Models\User::where($login_type, $request->login)->first();

    if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'login' => __('auth.failed'),
        ]);
    }

    if ($user->activo != 1) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'login' => 'Tu cuenta está inactiva. Contacta al administrador.',
        ]);
    }

    Auth::login($user, $request->boolean('remember'));

    $request->session()->regenerate();

    return redirect()->intended(RouteServiceProvider::HOME);
}

/**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}