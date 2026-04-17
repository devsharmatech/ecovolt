<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\RouteHandle;

class RoleController extends Controller
{
    use RouteHandle;
    public function index()
    {
        $roles = Role::paginate(10);
        return view($this->getRoutePrefix() . '.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::get()
            ->groupBy(fn($p) => explode('.', $p->name)[0]);

        return view($this->getRoutePrefix() . '.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|unique:roles,name',
            'permissions' => 'array|nullable',
        ]);

        $role = Role::create([
            'name'       => $request->name,
            'guard_name' => $request->guard_name ?? 'web'
        ]);

        if ($request->permissions) {
            $permissionIds = Permission::whereIn('name', $request->permissions)->pluck('id')->toArray();
            $role->permissions()->sync($permissionIds);
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        }

        return redirect()->route($this->getRoutePrefix() . '.roles.index')->with('success', 'Role created successfully');

    }

    public function show($id)
    {
        $role = Role::findOrFail($id);
        $rolePermissions = $role->permissions;

        return view($this->getRoutePrefix() . '.roles.show', compact('role', 'rolePermissions'));
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);

        $permissions = Permission::get()
            ->groupBy(fn($p) => explode('.', $p->name)[0]);

        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view($this->getRoutePrefix() . '.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|unique:roles,name,' . $id,
            'permissions' => 'array|nullable',
        ]);

        $role = Role::findOrFail($id);

        $role->update([
            'name'       => $request->name,
            'guard_name' => $request->guard_name ?? $role->guard_name
        ]);

        $permissionIds = $request->permissions ? Permission::whereIn('name', $request->permissions)->pluck('id')->toArray() : [];
        $role->permissions()->sync($permissionIds);
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->route($this->getRoutePrefix() . '.roles.index')->with('success', 'Role updated successfully');

    }

    public function destroy($id)
    {
        Role::findOrFail($id)->delete();

        return redirect()->route($this->getRoutePrefix() . '.roles.index')->with('success', 'Role deleted successfully');
    }
}
