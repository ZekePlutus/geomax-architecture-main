<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Permission Model
 *
 * GOVERNANCE: Permissions are module-driven and auto-generated.
 * - DO NOT hardcode permissions manually
 * - Key format: module.entity.action
 * - Permissions are registered by modules during boot
 *
 * @property int $id
 * @property int|null $module_id
 * @property string $key
 * @property string $name
 * @property bool $is_active
 */
class Permission extends Model
{
    protected $fillable = [
        'module_id',
        'key',
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get roles that have this permission.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permissions')
            ->withTimestamps();
    }

    /**
     * Check if permission is active.
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Parse the permission key into components.
     *
     * @return array{module: string, entity: string, action: string}
     */
    public function parseKey(): array
    {
        $parts = explode('.', $this->key);

        return [
            'module' => $parts[0] ?? '',
            'entity' => $parts[1] ?? '',
            'action' => $parts[2] ?? '',
        ];
    }

    /**
     * Scope to active permissions.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to permissions for a specific module.
     */
    public function scopeForModule($query, int $moduleId)
    {
        return $query->where('module_id', $moduleId);
    }
}
