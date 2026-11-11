<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::latest()->paginate(20);

        return view('admin.users.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Permission
        ]);

        $permission = Permission::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Permission created successfully.');
    }

    public function show(Permission $permission)
    {
        return view('admin.users.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
        return view('admin.users.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Permission
        ]);

        $permission->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('admin.users.index')->with('success', 'Permission deleted successfully.');
    }
}
