<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::latest()->paginate(20);

        return view('admin.users.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Role
        ]);

        $role = Role::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Role created successfully.');
    }

    public function show(Role $role)
    {
        return view('admin.users.show', compact('role'));
    }

    public function edit(Role $role)
    {
        return view('admin.users.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Role
        ]);

        $role->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('admin.users.index')->with('success', 'Role deleted successfully.');
    }
}
