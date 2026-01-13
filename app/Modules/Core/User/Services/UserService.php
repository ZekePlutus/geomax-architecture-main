<?php

declare(strict_types=1);

namespace App\Modules\Core\User\Services;

use App\Modules\Core\User\Models\User;
use App\Modules\Core\User\Models\UserType;
use App\Modules\Core\User\Models\Role;
use App\Modules\Core\User\Models\UserRestriction;
use Illuminate\Support\Facades\DB;

/**
 * User Service
 *
 * Handles user lifecycle operations:
 * - Create
 * - Update
 * - Activate/Deactivate
 * - Role Assignment
 * - Restrictions Management
 *
 * GOVERNANCE: This service manages identity and delegation data ONLY.
 * It does NOT:
 * - Check billing
 * - Enable/disable modules
 * - Perform capability enforcement
 * - Assume access based on role alone
 */
class UserService
{
    public function __construct(
        protected PermissionCacheService $permissionCache
    ) {}

    /**
     * Create a new user.
     *
     * @param array $data User data
     * @return User
     */
    public function createUser(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'user_type_id' => $data['user_type_id'],
                'company_id' => $data['company_id'],
                'email' => $data['email'],
                'password' => isset($data['password']) ? bcrypt($data['password']) : null,
                'name' => $data['name'],
                'is_active' => $data['is_active'] ?? true,
            ]);

            // Assign roles if provided
            if (!empty($data['role_ids'])) {
                $user->roles()->sync($data['role_ids']);
            }

            // Rebuild permission cache
            $this->permissionCache->rebuildForUser($user);

            return $user->fresh(['userType', 'company', 'roles']);
        });
    }

    /**
     * Update an existing user.
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public function updateUser(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            $fieldsToUpdate = array_filter([
                'user_type_id' => $data['user_type_id'] ?? null,
                'name' => $data['name'] ?? null,
                'email' => $data['email'] ?? null,
                'is_active' => $data['is_active'] ?? null,
            ], fn($v) => $v !== null);

            if (isset($data['password'])) {
                $fieldsToUpdate['password'] = bcrypt($data['password']);
            }

            $user->update($fieldsToUpdate);

            // Update roles if provided
            if (isset($data['role_ids'])) {
                $user->roles()->sync($data['role_ids']);
                $this->permissionCache->rebuildForUser($user);
            }

            return $user->fresh(['userType', 'company', 'roles']);
        });
    }

    /**
     * Activate a user.
     *
     * @param User $user
     * @return User
     */
    public function activateUser(User $user): User
    {
        $user->update(['is_active' => true]);
        $this->permissionCache->rebuildForUser($user);

        return $user->fresh();
    }

    /**
     * Deactivate a user.
     *
     * @param User $user
     * @return User
     */
    public function deactivateUser(User $user): User
    {
        $user->update(['is_active' => false]);
        $this->permissionCache->invalidateForUser($user->id);

        return $user->fresh();
    }

    /**
     * Assign roles to a user.
     *
     * GOVERNANCE: This updates role assignment (intent).
     * Triggers permission cache rebuild.
     *
     * @param User $user
     * @param array $roleIds
     * @return User
     */
    public function assignRoles(User $user, array $roleIds): User
    {
        return DB::transaction(function () use ($user, $roleIds) {
            $user->roles()->sync($roleIds);
            $this->permissionCache->rebuildForUser($user);

            return $user->fresh(['roles']);
        });
    }

    /**
     * Add a role to a user.
     *
     * @param User $user
     * @param int $roleId
     * @return User
     */
    public function addRole(User $user, int $roleId): User
    {
        return DB::transaction(function () use ($user, $roleId) {
            $user->roles()->attach($roleId);
            $this->permissionCache->rebuildForUser($user);

            return $user->fresh(['roles']);
        });
    }

    /**
     * Remove a role from a user.
     *
     * @param User $user
     * @param int $roleId
     * @return User
     */
    public function removeRole(User $user, int $roleId): User
    {
        return DB::transaction(function () use ($user, $roleId) {
            $user->roles()->detach($roleId);
            $this->permissionCache->rebuildForUser($user);

            return $user->fresh(['roles']);
        });
    }

    /**
     * Add a restriction to a user.
     *
     * @param User $user
     * @param string $type
     * @param array $value
     * @return UserRestriction
     */
    public function addRestriction(User $user, string $type, array $value): UserRestriction
    {
        return DB::transaction(function () use ($user, $type, $value) {
            $restriction = UserRestriction::create([
                'user_id' => $user->id,
                'restriction_type' => $type,
                'restriction_value' => $value,
            ]);

            // Rebuild permission cache to reflect restrictions
            $this->permissionCache->rebuildForUser($user);

            return $restriction;
        });
    }

    /**
     * Remove a restriction from a user.
     *
     * @param UserRestriction $restriction
     * @return bool
     */
    public function removeRestriction(UserRestriction $restriction): bool
    {
        $userId = $restriction->user_id;
        $result = $restriction->delete();

        // Rebuild permission cache
        $user = User::find($userId);
        if ($user) {
            $this->permissionCache->rebuildForUser($user);
        }

        return $result;
    }

    /**
     * Update user's last login timestamp.
     *
     * @param User $user
     * @return User
     */
    public function recordLogin(User $user): User
    {
        $user->update(['last_login_at' => now()]);

        return $user->fresh();
    }

    /**
     * List users for a company.
     *
     * @param int $companyId
     * @param bool|null $activeOnly
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function listUsersForCompany(int $companyId, ?bool $activeOnly = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = User::forCompany($companyId)
            ->with(['userType', 'roles']);

        if ($activeOnly !== null) {
            $query->where('is_active', $activeOnly);
        }

        return $query->orderBy('name')->get();
    }

    /**
     * Get user by email.
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Get available user types.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserTypes(): \Illuminate\Database\Eloquent\Collection
    {
        return UserType::all();
    }

    /**
     * Get available roles for a company.
     *
     * @param int $companyId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAvailableRoles(int $companyId): \Illuminate\Database\Eloquent\Collection
    {
        return Role::forCompany($companyId)->get();
    }
}
