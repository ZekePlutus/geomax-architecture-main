<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * UserEffectivePermission Model
 *
 * GOVERNANCE: This is a DERIVED CACHE table.
 * - Recalculated automatically when roles/modules change
 * - Authorization checks MUST read from this table
 * - DO NOT compute permissions dynamically per request
 * - Cache invalidation is handled by PermissionCacheService
 *
 * @property int $id
 * @property int $user_id
 * @property int $company_id
 * @property string $permission_key
 * @property string $source (role|direct|inherited|system)
 * @property bool $has_restriction
 * @property bool $is_valid
 */
class UserEffectivePermission extends Model
{
    protected $fillable = [
        'user_id',
        'company_id',
        'permission_key',
        'source',
        'has_restriction',
        'is_valid',
    ];

    protected $casts = [
        'has_restriction' => 'boolean',
        'is_valid' => 'boolean',
    ];

    /**
     * Source types enum values.
     */
    public const SOURCE_ROLE = 'role';
    public const SOURCE_DIRECT = 'direct';
    public const SOURCE_INHERITED = 'inherited';
    public const SOURCE_SYSTEM = 'system';

    /**
     * Get the user this permission belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the company context.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Check if permission is valid.
     */
    public function isValid(): bool
    {
        return $this->is_valid;
    }

    /**
     * Check if permission has restrictions applied.
     */
    public function hasRestriction(): bool
    {
        return $this->has_restriction;
    }

    /**
     * Scope to valid permissions only.
     */
    public function scopeValid($query)
    {
        return $query->where('is_valid', true);
    }

    /**
     * Scope to permissions with restrictions.
     */
    public function scopeWithRestrictions($query)
    {
        return $query->where('has_restriction', true);
    }

    /**
     * Scope to permissions for a user.
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to permissions for a specific key.
     */
    public function scopeForKey($query, string $permissionKey)
    {
        return $query->where('permission_key', $permissionKey);
    }

    /**
     * Scope to permissions by source.
     */
    public function scopeBySource($query, string $source)
    {
        return $query->where('source', $source);
    }
}
