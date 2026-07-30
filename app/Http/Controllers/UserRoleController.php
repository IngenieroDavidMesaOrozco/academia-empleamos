<?php     

// app/Http/Controllers/UserRoleController.php
namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    /* ROLES ------------------------------------------------*/
    public function editRoles(User $user)
    {
        $roles = Role::all();
        $user->load('roles');
        return view('usuarios.edit-roles', compact('user','roles'));
    }

    public function updateRoles(Request $request, User $user)
    {
        $request->validate(['roles' => 'array']);
        $user->syncRoles($request->roles ?? []);
        return back()->with('success', 'Roles actualizados.');
    }

    /* PERMISOS ---------------------------------------------*/
    public function editPermisos(User $user)
    {
        $permisos = Permission::all();
        $user->load('permissions');
        return view('usuarios.edit-permisos', compact('user','permisos'));
    }

    public function updatePermisos(Request $request, User $user)
    {
        $request->validate(['permisos' => 'array']);
        $user->syncPermissions($request->permisos ?? []);
        return back()->with('success', 'Permisos actualizados.');
    }
}
