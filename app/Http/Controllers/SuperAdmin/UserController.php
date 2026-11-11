<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(20);

        return view('superadmin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = $this->assignableRoles();

        return view('superadmin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'avatar'   => 'nullable|image|max:2048',
            'status'   => 'nullable|boolean',
            'role'     => ['nullable', Rule::exists('roles', 'name')],
        ]);

        $this->authorizeRoleAssignment($validated['role'] ?? null);

        $data = Arr::except($validated, ['role']);
        $data['password']        = Hash::make($data['password']);
        $data['password_set_at'] = now();
        $data['status']          = $request->boolean('status');

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('users', 'public');
        }

        $user = User::create($data);
        $user->syncRoles(! empty($validated['role']) ? [$validated['role']] : []);

        return redirect()->route('superadmin.users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $user->load('roles');

        return view('superadmin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->guardSuperUser($user);

        $roles = $this->assignableRoles();
        $user->load('roles');

        return view('superadmin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $this->guardSuperUser($user);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'avatar'   => 'nullable|image|max:2048',
            'status'   => 'nullable|boolean',
            'role'     => ['nullable', Rule::exists('roles', 'name')],
        ]);

        $newRole = $validated['role'] ?? null;
        $this->authorizeRoleAssignment($newRole);

        $superRole = config('route_permissions.super_admin_role');

        if ($user->is($request->user()) && $user->hasRole($superRole) && $newRole !== $superRole) {
            return back()->withInput()->withErrors(['role' => 'You cannot remove your own super admin role.']);
        }

        $data = Arr::except($validated, ['role']);
        $data['status'] = $request->boolean('status');

        if (! empty($data['password'])) {
            $data['password']        = Hash::make($data['password']);
            $data['password_set_at'] = now();
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('users', 'public');
        }

        $user->update($data);
        $user->syncRoles($newRole ? [$newRole] : []);

        return redirect()->route('superadmin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(Request $request, User $user)
    {
        $this->guardSuperUser($user);

        if ($user->is($request->user())) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('superadmin.users.index')->with('success', 'User deleted successfully.');
    }

    /* ---------------- helpers ---------------- */

    protected function isSuperAdmin(?User $user): bool
    {
        return $user && $user->hasRole(config('route_permissions.super_admin_role'));
    }

    /** Super admin chara keu super admin role dekhte/assign korte parbe na */
    protected function assignableRoles()
    {
        $query = Role::orderBy('name');

        if (! $this->isSuperAdmin(auth()->user())) {
            $query->where('name', '!=', config('route_permissions.super_admin_role'));
        }

        return $query->get();
    }

    protected function authorizeRoleAssignment(?string $role): void
    {
        if ($role === config('route_permissions.super_admin_role') && ! $this->isSuperAdmin(auth()->user())) {
            abort(403, 'Only a super admin can assign the super admin role.');
        }
    }

    protected function guardSuperUser(User $user): void
    {
        if ($this->isSuperAdmin($user) && ! $this->isSuperAdmin(auth()->user())) {
            abort(403, 'Only a super admin can manage this user.');
        }
    }
}