<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * UserType Model
 *
 * GOVERNANCE: User types define identity classification intent.
 * Predefined types: reseller_owner, company_admin, company_user, driver
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 */
class UserType extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get users of this type.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if this is a reseller owner type.
     */
    public function isResellerOwner(): bool
    {
        return $this->name === 'reseller_owner';
    }

    /**
     * Check if this is a company admin type.
     */
    public function isCompanyAdmin(): bool
    {
        return $this->name === 'company_admin';
    }

    /**
     * Check if this is a driver type.
     */
    public function isDriver(): bool
    {
        return $this->name === 'driver';
    }
}
