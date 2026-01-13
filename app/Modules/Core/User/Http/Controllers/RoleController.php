<?php

declare(strict_types=1);

namespace App\Modules\Core\User\Http\Controllers;

use App\Modules\Core\User\Models\Role;
use App\Modules\Core\User\Models\Permission;
use App\Modules\Core\User\Services\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

/**
 * Role Controller
 *
 * GOVERNANCE: Manages custom roles for companies.
 * System roles cannot be edited or deleted.
 */
class RoleController extends Controller
{
    public function __construct(
        protected RoleService $roleService
    ) {}

    /**
     * Display a listing of roles.
     */
    public function index(Request $request): View
    {
        // TODO: Get company_id from authenticated user
        $companyId = $request->get('company_id', 1);

        $roles = Role::forCompany($companyId)
            ->withCount(['users', 'permissions'])
            ->orderBy('is_system', 'desc')
            ->orderBy('name')
            ->get();

        $systemRoles = $roles->where('is_system', true);
        $customRoles = $roles->where('is_system', false);

        return view('user::roles.index', compact('roles', 'systemRoles', 'customRoles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create(): View
    {
        $permissions = Permission::active()
            ->orderBy('key')
            ->get()
            ->groupBy(fn ($p) => explode('.', $p->key)[0]);

        return view('user::roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // TODO: Get company_id from authenticated user
        $companyId = $request->get('company_id', 1);

        $role = $this->roleService->createRole(
            name: $validated['name'],
            companyId: $companyId,
            description: $validated['description'] ?? null,
            permissionIds: $validated['permissions'] ?? []
        );

        // Return JSON for AJAX requests
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Role '{$role->name}' created successfully.",
                'role' => [
                    'id' => $role->id,
                    'name' => $role->name,
                    'description' => $role->description,
                    'permissions_count' => $role->permissions()->count(),
                ],
            ]);
        }

        return redirect()
            ->route('user.roles.show', $role)
            ->with('success', "Role '{$role->name}' created successfully.");
    }

    /**
     * Display the specified role.
     */
    public function show(Role $role): View
    {
        $role->load(['permissions', 'users']);

        $permissionsByModule = $role->permissions
            ->groupBy(fn ($p) => explode('.', $p->key)[0]);

        return view('user::roles.show', compact('role', 'permissionsByModule'));
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role): View|RedirectResponse
    {
        if ($role->isSystemRole()) {
            return redirect()
                ->route('user.roles.show', $role)
                ->with('error', 'System roles cannot be edited.');
        }

        $permissions = Permission::active()
            ->orderBy('key')
            ->get()
            ->groupBy(fn ($p) => explode('.', $p->key)[0]);

        $rolePermissionIds = $role->permissions->pluck('id')->toArray();

        return view('user::roles.edit', compact('role', 'permissions', 'rolePermissionIds'));
    }

    /**
     * Update the specified role.
     */
    public function update(Request $request, Role $role): RedirectResponse
    {
        if ($role->isSystemRole()) {
            return redirect()
                ->route('user.roles.show', $role)
                ->with('error', 'System roles cannot be edited.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $this->roleService->updateRole(
            role: $role,
            name: $validated['name'],
            description: $validated['description'] ?? null,
            permissionIds: $validated['permissions'] ?? []
        );

        return redirect()
            ->route('user.roles.show', $role)
            ->with('success', "Role '{$role->name}' updated successfully.");
    }

    /**
     * Remove the specified role.
     */
    public function destroy(Role $role): RedirectResponse
    {
        if ($role->isSystemRole()) {
            return redirect()
                ->route('user.roles.index')
                ->with('error', 'System roles cannot be deleted.');
        }

        if ($role->users()->count() > 0) {
            return redirect()
                ->route('user.roles.show', $role)
                ->with('error', 'Cannot delete role that is assigned to users. Remove users first.');
        }

        $roleName = $role->name;
        $this->roleService->deleteRole($role);

        return redirect()
            ->route('user.roles.index')
            ->with('success', "Role '{$roleName}' deleted successfully.");
    }

    /**
     * Duplicate an existing role.
     */
    public function duplicate(Role $role): RedirectResponse
    {
        // TODO: Get company_id from authenticated user
        $companyId = 1;

        $newRole = $this->roleService->duplicateRole($role, $companyId);

        return redirect()
            ->route('user.roles.edit', $newRole)
            ->with('success', "Role duplicated. You can now customize '{$newRole->name}'.");
    }
}
