<?php
// app/Http/Controllers/RoleController.php
namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
    $search = $request->input('search');
   $roles = Role::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('id', 'like', "%{$search}%")
 ->orWhereHas('permissions', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });        })
   ->paginate(10);

    return view('roles.index', compact('roles', 'search'));
    }

public function create(Request $request)
{
    $search = $request->input('search');

    $permisos = Permission::when($search, function ($query, $search) {
        return $query->where('name', 'like', "%{$search}%");
    })->get();

    return view('roles.create', compact('permisos', 'search'));
}


public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|unique:roles',
        'permissions' => 'array'
    ]);

    if (strtolower($data['name']) === 'superadmin') {
        return back()->withInput()->with('error', 'Ya existe un rol SuperAdmin. No se puede duplicar.');
    }

    $role = Role::create(['name' => $data['name']]);
    $role->syncPermissions($data['permissions'] ?? []);

    return redirect()->route('roles.index')->with('success', 'Rol creado.');
}


public function edit(Request $request, Role $role)
{
    $search = $request->input('search');

    $permisos = Permission::when($search, function ($query, $search) {
        return $query->where('name', 'like', "%{$search}%");
    })->get();

    $role->load('permissions');

    return view('roles.edit', compact('role', 'permisos', 'search'));
}




public function update(Request $request, Role $role)
{
    $request->validate([
        'name' => 'required|string|unique:roles,name,' . $role->id,
        'permissions' => 'nullable|array',
    ]);

    // No permitir cambiar el nombre si es SuperAdmin
    if (strtolower($role->name) === 'superadmin' && strtolower($request->name) !== 'superadmin') {
        return back()->withInput()->with('error', 'No puedes cambiar el nombre del rol SuperAdmin.');
    }

    // Solo actualiza el nombre si NO es SuperAdmin
    if (strtolower($role->name) !== 'superadmin') {
        $role->name = $request->name;
    }

    $role->save();

    if ($request->filled('permissions')) {
        $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
        $role->syncPermissions($permissionNames);
    } else {
        $role->syncPermissions([]);
    }

    return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
}



public function destroy(Role $role)
{
    if (strtolower($role->name) === 'superadmin') {
        return redirect()->route('roles.index')->with('error', 'No puedes eliminar el rol SuperAdmin.');
    }

    $role->delete();
    return back()->with('success', 'Rol eliminado.');
}

}
