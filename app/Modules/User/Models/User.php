<?php

declare(strict_types=1);

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * User Model
 *
 * GOVERNANCE: Users store IDENTITY data only.
 * - A User has ONE user_type (intent classification)
 * - A User belongs to ONE Company (tenant isolation)
 * - Authorization is delegated to UserEffectivePermission cache
 * - DO NOT check permissions dynamically; use cache table
 *
 * @property int $id
 * @property int $user_type_id
 * @property int $company_id
 * @property string $email
 * @property string|null $password
 * @property string $name
 * @property bool $is_active
 * @property \Carbon\Carbon|null $last_login_at
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'user_type_id',
        'company_id',
        'email',
        'password',
        'name',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the user's type (identity classification).
     */
    public function userType(): BelongsTo
    {
        return $this->belongsTo(UserType::class);
    }

    /**
     * Get the company this user belongs to.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get roles assigned to this user.
     * GOVERNANCE: Roles define INTENT, not effective permissions.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles')
            ->withTimestamps();
    }

    /**
     * Get effective permissions from cache.
     * GOVERNANCE: Use this for authorization checks.
     */
    public function effectivePermissions(): HasMany
    {
        return $this->hasMany(UserEffectivePermission::class);
    }

    /**
     * Get user restrictions.
     */
    public function restrictions(): HasMany
    {
        return $this->hasMany(UserRestriction::class);
    }

    /**
     * Check if user has a specific permission.
     * GOVERNANCE: Reads from cached user_effective_permissions table.
     *
     * @param string $permissionKey Format: module.entity.action
     * @return bool
     */
    public function hasPermission(string $permissionKey): bool
    {
        return $this->effectivePermissions()
            ->where('permission_key', $permissionKey)
            ->where('is_valid', true)
            ->exists();
    }

    /**
     * Check if user has any restrictions.
     */
    public function hasRestrictions(): bool
    {
        return $this->restrictions()->exists();
    }

    /**
     * Get restrictions by type.
     */
    public function getRestrictionsByType(string $type): \Illuminate\Database\Eloquent\Collection
    {
        return $this->restrictions()->where('restriction_type', $type)->get();
    }

    /**
     * Check if user is a reseller owner.
     */
    public function isResellerOwner(): bool
    {
        return $this->userType?->isResellerOwner() ?? false;
    }

    /**
     * Check if user is a company admin.
     */
    public function isCompanyAdmin(): bool
    {
        return $this->userType?->isCompanyAdmin() ?? false;
    }

    /**
     * Check if user is a driver.
     */
    public function isDriver(): bool
    {
        return $this->userType?->isDriver() ?? false;
    }

    /**
     * Check if user is active.
     */
    public function isActive(): bool
    {
        return $this->is_active && ($this->company?->isActive() ?? false);
    }

    /**
     * Scope: Users belonging to a specific company
     */
    public function scopeForCompany($query, int $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Scope: Active users only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Users by type
     */
    public function scopeOfType($query, int $userTypeId)
    {
        return $query->where('user_type_id', $userTypeId);
    }
}
