<?php

declare(strict_types=1);

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Company Model
 *
 * GOVERNANCE: Companies provide tenant/subaccount context isolation.
 * All data scoping happens at the company level.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property bool $is_active
 */
class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get users belonging to this company.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get company-specific roles.
     */
    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    /**
     * Get effective permissions cache for this company.
     */
    public function effectivePermissions(): HasMany
    {
        return $this->hasMany(UserEffectivePermission::class);
    }

    /**
     * Check if company is active.
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Scope to active companies.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
