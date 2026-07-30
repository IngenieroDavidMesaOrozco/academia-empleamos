<?php

// app/Http/Controllers/PermissionController.php
namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
public function index(Request $request)
{
    $search = $request->input('search');

    $permisos = Permission::when($search, function ($query, $search) {
        return $query->where('name', 'like', "%{$search}%");
    })->paginate(10)->withQueryString();

    return view('permissions.index', compact('permisos', 'search'));
}
    public function create() { return view('permissions.create'); }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:permissions']);
        Permission::create($request->only('name'));
        return redirect()->route('permissions.index')->with('success', 'Permiso creado.');
    }

    public function edit(Permission $permission) { return view('permissions.edit', compact('permission')); }

    public function update(Request $request, Permission $permission)
    {
        $request->validate(['name' => 'required|string|unique:permissions,name,'.$permission->id]);
        $permission->update($request->only('name'));
        return redirect()->route('permissions.index')->with('success', 'Permiso actualizado.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return back()->with('success', 'Permiso eliminado.');
    }
}
