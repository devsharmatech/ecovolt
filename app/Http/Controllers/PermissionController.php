<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\RouteHandle;

class PermissionController extends Controller
{
    use RouteHandle;

    public function index()
    {
        $permissions = Permission::paginate(10);
        return view($this->getRoutePrefix() . '.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view($this->getRoutePrefix() . '.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create([
            'name'       => $request->name,
            'guard_name' => $request->guard_name ?? 'web'
        ]);

        return redirect()->route($this->getRoutePrefix() . '.permissions.index')
            ->with('success', 'Permission created successfully!');
    }

    public function show($id)
    {
        $permission = Permission::findOrFail($id);
        return view($this->getRoutePrefix() .'.permissions.show', compact('permission'));
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view($this->getRoutePrefix() .'.permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $id,
        ]);

        $permission = Permission::findOrFail($id);

        $permission->update([
            'name'       => $request->name,
            'guard_name' => $request->guard_name ?? $permission->guard_name
        ]);

        return redirect()->route($this->getRoutePrefix() .'.permissions.index')
            ->with('success', 'Permission updated successfully!');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route($this->getRoutePrefix() .'.permissions.index')
            ->with('success', 'Permission deleted successfully!');
    }
}
