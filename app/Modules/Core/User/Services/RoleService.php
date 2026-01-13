<?php

declare(strict_types=1);

namespace App\Modules\Core\User\Services;

use App\Modules\Core\User\Models\Role;
use App\Modules\Core\User\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Role Service
 *
 * GOVERNANCE: Handles role CRUD and permission assignments.
 * - System roles cannot be modified
 * - Permission changes trigger cache rebuild for affected users
 */
class RoleService
{
    public function __construct(
        protected PermissionCacheService $cacheService
    ) {}

    /**
     * Create a new custom role.
     */
    public function createRole(
        string $name,
        int $companyId,
        ?string $description = null,
        array $permissionIds = []
    ): Role {
        return DB::transaction(function () use ($name, $companyId, $description, $permissionIds) {
            $role = Role::create([
                'name' => $name,
                'company_id' => $companyId,
                'is_system' => false,
                'description' => $description,
            ]);

            if (!empty($permissionIds)) {
                $role->permissions()->attach($permissionIds);
            }

            return $role;
        });
    }

    /**
     * Update an existing role.
     */
    public function updateRole(
        Role $role,
        string $name,
        ?string $description = null,
        array $permissionIds = []
    ): Role {
        if ($role->isSystemRole()) {
            throw new \InvalidArgumentException('System roles cannot be modified.');
        }

        return DB::transaction(function () use ($role, $name, $description, $permissionIds) {
            $role->update([
                'name' => $name,
                'description' => $description,
            ]);

            // Sync permissions
            $role->permissions()->sync($permissionIds);

            // Rebuild cache for affected users
            $this->rebuildCacheForRoleUsers($role);

            return $role->fresh();
        });
    }

    /**
     * Delete a role.
     */
    public function deleteRole(Role $role): bool
    {
        if ($role->isSystemRole()) {
            throw new \InvalidArgumentException('System roles cannot be deleted.');
        }

        if ($role->users()->count() > 0) {
            throw new \InvalidArgumentException('Cannot delete role that is assigned to users.');
        }

        return DB::transaction(function () use ($role) {
            $role->permissions()->detach();
            return $role->delete();
        });
    }

    /**
     * Duplicate a role with a new name.
     */
    public function duplicateRole(Role $sourceRole, int $companyId): Role
    {
        return DB::transaction(function () use ($sourceRole, $companyId) {
            $newRole = Role::create([
                'name' => $sourceRole->name . ' (Copy)',
                'company_id' => $companyId,
                'is_system' => false,
                'description' => $sourceRole->description,
            ]);

            // Copy permissions
            $permissionIds = $sourceRole->permissions()->pluck('permissions.id')->toArray();
            if (!empty($permissionIds)) {
                $newRole->permissions()->attach($permissionIds);
            }

            return $newRole;
        });
    }

    /**
     * Assign a role to a user.
     */
    public function assignRoleToUser(Role $role, User $user): void
    {
        if (!$user->roles()->where('role_id', $role->id)->exists()) {
            $user->roles()->attach($role->id);
            $this->cacheService->rebuildForUser($user);
        }
    }

    /**
     * Remove a role from a user.
     */
    public function removeRoleFromUser(Role $role, User $user): void
    {
        $user->roles()->detach($role->id);
        $this->cacheService->rebuildForUser($user);
    }

    /**
     * Sync roles for a user (replaces all existing roles).
     */
    public function syncUserRoles(User $user, array $roleIds): void
    {
        DB::transaction(function () use ($user, $roleIds) {
            $user->roles()->sync($roleIds);
            $this->cacheService->rebuildForUser($user);
        });
    }

    /**
     * Rebuild permission cache for all users with this role.
     */
    protected function rebuildCacheForRoleUsers(Role $role): void
    {
        $role->users->each(function (User $user) {
            $this->cacheService->rebuildForUser($user);
        });
    }

    /**
     * Get available roles for a company (system + company-specific).
     */
    public function getAvailableRoles(int $companyId): \Illuminate\Database\Eloquent\Collection
    {
        return Role::where(function ($query) use ($companyId) {
            $query->where('is_system', true)
                  ->orWhere('company_id', $companyId);
        })
        ->orderBy('is_system', 'desc')
        ->orderBy('name')
        ->get();
    }
}
