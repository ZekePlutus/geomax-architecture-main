<?php

declare(strict_types=1);

namespace App\Modules\User\Services;

use App\Modules\User\Models\User;
use App\Modules\User\Models\UserEffectivePermission;
use Illuminate\Support\Facades\DB;

/**
 * PermissionCacheService
 *
 * GOVERNANCE: This service manages the user_effective_permissions cache table.
 * - Recalculates permissions when roles/modules change
 * - Invalidates cache entries as needed
 * - Used by the Execution Gate for authorization lookups
 */
class PermissionCacheService
{
    /**
     * Rebuild effective permissions for a specific user.
     *
     * @param User $user
     * @return int Number of permissions cached
     */
    public function rebuildForUser(User $user): int
    {
        return DB::transaction(function () use ($user) {
            // Invalidate existing permissions
            $this->invalidateForUser($user->id);

            $permissionsAdded = 0;

            // Get all permissions from user's roles
            foreach ($user->roles as $role) {
                foreach ($role->permissions as $permission) {
                    if (!$permission->isActive()) {
                        continue;
                    }

                    // Check if user has restrictions for this permission
                    $hasRestriction = $user->hasRestrictions();

                    UserEffectivePermission::create([
                        'user_id' => $user->id,
                        'company_id' => $user->company_id,
                        'permission_key' => $permission->key,
                        'source' => UserEffectivePermission::SOURCE_ROLE,
                        'has_restriction' => $hasRestriction,
                        'is_valid' => true,
                    ]);

                    $permissionsAdded++;
                }
            }

            return $permissionsAdded;
        });
    }

    /**
     * Rebuild effective permissions for all users in a company.
     *
     * @param int $companyId
     * @return int Number of users processed
     */
    public function rebuildForCompany(int $companyId): int
    {
        $users = User::where('company_id', $companyId)->get();
        $count = 0;

        foreach ($users as $user) {
            $this->rebuildForUser($user);
            $count++;
        }

        return $count;
    }

    /**
     * Rebuild effective permissions for all users with a specific role.
     *
     * @param int $roleId
     * @return int Number of users processed
     */
    public function rebuildForRole(int $roleId): int
    {
        $users = User::whereHas('roles', fn($q) => $q->where('roles.id', $roleId))->get();
        $count = 0;

        foreach ($users as $user) {
            $this->rebuildForUser($user);
            $count++;
        }

        return $count;
    }

    /**
     * Invalidate all effective permissions for a user.
     *
     * @param int $userId
     * @return int Number of rows affected
     */
    public function invalidateForUser(int $userId): int
    {
        return UserEffectivePermission::where('user_id', $userId)
            ->update(['is_valid' => false]);
    }

    /**
     * Invalidate all effective permissions for a company.
     *
     * @param int $companyId
     * @return int Number of rows affected
     */
    public function invalidateForCompany(int $companyId): int
    {
        return UserEffectivePermission::where('company_id', $companyId)
            ->update(['is_valid' => false]);
    }

    /**
     * Invalidate all permissions containing a specific key.
     *
     * @param string $permissionKey
     * @return int Number of rows affected
     */
    public function invalidateByKey(string $permissionKey): int
    {
        return UserEffectivePermission::where('permission_key', $permissionKey)
            ->update(['is_valid' => false]);
    }

    /**
     * Remove all invalid (stale) cache entries.
     *
     * @return int Number of rows deleted
     */
    public function pruneInvalid(): int
    {
        return UserEffectivePermission::where('is_valid', false)->delete();
    }

    /**
     * Check if a user has a specific permission (cached lookup).
     *
     * GOVERNANCE: This is the primary method for authorization checks.
     *
     * @param int $userId
     * @param string $permissionKey
     * @return bool
     */
    public function hasPermission(int $userId, string $permissionKey): bool
    {
        return UserEffectivePermission::where('user_id', $userId)
            ->where('permission_key', $permissionKey)
            ->where('is_valid', true)
            ->exists();
    }

    /**
     * Get all valid permissions for a user.
     *
     * @param int $userId
     * @return \Illuminate\Support\Collection
     */
    public function getPermissionsForUser(int $userId): \Illuminate\Support\Collection
    {
        return UserEffectivePermission::where('user_id', $userId)
            ->where('is_valid', true)
            ->pluck('permission_key');
    }

    /**
     * Get permissions with restrictions for a user.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRestrictedPermissions(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        return UserEffectivePermission::where('user_id', $userId)
            ->where('is_valid', true)
            ->where('has_restriction', true)
            ->get();
    }
}
