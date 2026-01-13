<?php

declare(strict_types=1);

namespace App\Modules\Core\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Role Model
 *
 * GOVERNANCE: Roles represent INTENT, not guaranteed permissions.
 * - System roles have company_id = NULL and is_system = true
 * - Company roles are scoped to a specific company
 * - Role permissions are source data for cache generation
 * - DO NOT use role_permissions directly for authorization
 *
 * @property int $id
 * @property string $name
 * @property int|null $company_id
 * @property bool $is_system
 * @property string|null $description
 */
class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'company_id',
        'is_system',
        'description',
    ];

    protected $casts = [
        'is_system' => 'boolean',
    ];

    /**
     * Get the company this role belongs to (if any).
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get users assigned to this role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_roles')
            ->withTimestamps();
    }

    /**
     * Get permissions associated with this role.
     * GOVERNANCE: This defines INTENT, not runtime permissions.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions')
            ->withTimestamps();
    }

    /**
     * Check if this is a system role.
     */
    public function isSystemRole(): bool
    {
        return $this->is_system;
    }

    /**
     * Check if this is a company-specific role.
     */
    public function isCompanyRole(): bool
    {
        return $this->company_id !== null;
    }

    /**
     * Scope to system roles only.
     */
    public function scopeSystem($query)
    {
        return $query->where('is_system', true);
    }

    /**
     * Scope to company roles.
     */
    public function scopeForCompany($query, int $companyId)
    {
        return $query->where(function ($q) use ($companyId) {
            $q->where('company_id', $companyId)
              ->orWhere('is_system', true);
        });
    }
}
