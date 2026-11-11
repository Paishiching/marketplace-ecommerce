<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Services\PermissionSyncService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function __construct(protected PermissionSyncService $sync)
    {
    }

    public function index()
    {
        $roles = Role::withCount(['permissions', 'users'])->orderBy('name')->get();
        $superRole = $this->sync->superAdminRole();

        return view('superadmin.roles.index', compact('roles', 'superRole'));
    }

    public function create()
    {
        $this->sync->syncIfRoutesChanged();

        return view('superadmin.roles.create', [
            'role'     => new Role(),
            'groups'   => $this->groups(),
            'assigned' => [],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => ['required', 'string', 'max:50', 'unique:roles,name', Rule::notIn([$this->sync->superAdminRole()])],
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $role = Role::create([
            'name'       => $data['name'],
            'guard_name' => $this->sync->guard(),
        ]);
        $role->syncPermissions($data['permissions'] ?? []);

        return redirect()->route('superadmin.roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        if ($this->isSuper($role)) {
            return redirect()->route('superadmin.roles.index')
                ->with('error', 'Super admin role has full access and cannot be edited.');
        }

        $this->sync->syncIfRoutesChanged();

        return view('superadmin.roles.edit', [
            'role'     => $role,
            'groups'   => $this->groups(),
            'assigned' => $role->permissions->pluck('name')->all(),
        ]);
    }

    public function update(Request $request, Role $role)
    {
        if ($this->isSuper($role)) {
            abort(403);
        }

        $data = $request->validate([
            'name'          => ['required', 'string', 'max:50', Rule::unique('roles', 'name')->ignore($role->id), Rule::notIn([$this->sync->superAdminRole()])],
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $role->update(['name' => $data['name']]);
        $role->syncPermissions($data['permissions'] ?? []);

        return redirect()->route('superadmin.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        if ($this->isSuper($role)) {
            return back()->with('error', 'Super admin role cannot be deleted.');
        }

        if ($role->users()->exists()) {
            return back()->with('error', 'This role is assigned to users. Re-assign them first.');
        }

        $role->delete();

        return redirect()->route('superadmin.roles.index')->with('success', 'Role deleted successfully.');
    }

    protected function isSuper(Role $role): bool
    {
        return $role->name === $this->sync->superAdminRole();
    }

    protected function groups()
    {
        return Permission::where('guard_name', $this->sync->guard())
            ->where(function ($q) {
                foreach ($this->sync->panels() as $panel) {
                    $q->orWhere('name', 'like', $panel . '.%');
                }
            })
            ->orderBy('group_name')
            ->orderBy('name')
            ->get()
            ->groupBy('group_name');
    }
}