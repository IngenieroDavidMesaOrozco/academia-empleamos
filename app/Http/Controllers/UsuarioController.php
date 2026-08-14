<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    /**
     * Listado de usuarios
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('username', 'like', '%' . $request->search . '%');
            });
        }

        $usuarios = $query->with('roles')->paginate(10);

        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Formulario crear usuario
     */
    public function create()
    {
        $roles = Role::all();

        return view('usuarios.create', compact('roles'));
    }

    /**
     * Guardar usuario
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'nullable|array',
        ]);

        $usuario = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),

            // NUEVO
            'activo' => true,
            'password_temporal' => true,
            'password_expires_at' => now()->addDays(3),
            'vio_video_bienvenida' => false,
        ]);

        if ($request->filled('roles')) {
            $roles = Role::whereIn('id', $request->roles)->pluck('name')->toArray();
            $usuario->syncRoles($roles);
        }

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Ver usuario
     */
    public function show($id)
    {
        $usuario = User::with('roles')->findOrFail($id);

        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Editar usuario
     */
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $roles = Role::all();

        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Actualizar usuario
     */
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'username' => 'required|string|unique:users,username,' . $usuario->id,
            'password' => 'nullable|string|min:8',
            'roles' => 'nullable|array',
        ]);

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->username = $request->username;

        // Si el administrador escribe una nueva contraseña, la actualiza de forma segura
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
            $usuario->password_temporal = false;
            $usuario->password_expires_at = null;
            $usuario->last_password_change = now();
        }

        $usuario->save();

        // Actualización de roles
        if ($request->filled('roles')) {
            $roles = Role::whereIn('id', $request->roles)->pluck('name')->toArray();
            $usuario->syncRoles($roles);
        } else {
            $usuario->syncRoles([]);
        }

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }
    /**
     * Activar / desactivar usuario
     */
    public function toggleActivo(User $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes desactivar tu propio usuario.');
        }

        $usuario->activo = !$usuario->activo;
        $usuario->save();

        return back()->with('success', 'Estado del usuario actualizado correctamente.');
    }

    /**
     * Mostrar formulario de cambio de contraseña
     */
    public function mostrarFormularioCambio()
    {
        return view('auth.forzar_cambio_password');
    }

    /**
     * Procesar cambio de contraseña
     */
    public function procesarCambio(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                function ($attribute, $value, $fail) use ($user) {
                    if (Hash::check($value, $user->password)) {
                        $fail('La nueva contraseña no puede ser igual a la clave actual.');
                    }
                },
            ],
        ]);

        $user->password = Hash::make($request->password);
        $user->password_temporal = false;
        $user->password_expires_at = null;
        $user->last_password_change = now();
        $user->save();

        session()->forget('forzar_cambio_password');

        if ($user->hasRole(['estudiante', 'Estudiante'])) {

            if (!$user->vio_video_bienvenida) {
                return redirect()->route('estudiante.bienvenida')
                    ->with('status', 'Contraseña actualizada. Bienvenido.');
            }

            return redirect()->route('estudiante.dashboard')
                ->with('status', 'Contraseña actualizada correctamente.');
        }

        return redirect()->route('admin.dashboard')
            ->with('status', 'Contraseña actualizada correctamente.');
    }
       public function destroy(User $usuario)
    {
    if ($usuario->id === auth()->id()) {
        return back()->with('error', 'No puedes eliminar tu propio usuario.');
    }

    $usuario->delete();

    return redirect()->route('usuarios.index')
        ->with('success', 'Usuario eliminado correctamente.');
}
}