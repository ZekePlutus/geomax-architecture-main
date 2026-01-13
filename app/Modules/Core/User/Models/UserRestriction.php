<?php

namespace App\Modules\Core\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * UserRestriction Model
 *
 * GOVERNANCE: Stores user-specific restrictions.
 * - Restriction types: vehicle, geofence, time, sub_account
 * - Evaluated at runtime by the Execution Gate
 * - Restrictions limit WHAT data a user can access
 *
 * @property int $id
 * @property int $user_id
 * @property string $restriction_type (vehicle|geofence|time|sub_account)
 * @property array $restriction_value
 */
class UserRestriction extends Model
{
    protected $fillable = [
        'user_id',
        'restriction_type',
        'restriction_value',
    ];

    protected $casts = [
        'restriction_value' => 'array',
    ];

    /**
     * Restriction types enum values.
     */
    public const TYPE_VEHICLE = 'vehicle';
    public const TYPE_GEOFENCE = 'geofence';
    public const TYPE_TIME = 'time';
    public const TYPE_SUB_ACCOUNT = 'sub_account';

    /**
     * Get the user this restriction belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if this is a vehicle restriction.
     */
    public function isVehicleRestriction(): bool
    {
        return $this->restriction_type === self::TYPE_VEHICLE;
    }

    /**
     * Check if this is a geofence restriction.
     */
    public function isGeofenceRestriction(): bool
    {
        return $this->restriction_type === self::TYPE_GEOFENCE;
    }

    /**
     * Check if this is a time restriction.
     */
    public function isTimeRestriction(): bool
    {
        return $this->restriction_type === self::TYPE_TIME;
    }

    /**
     * Check if this is a sub-account restriction.
     */
    public function isSubAccountRestriction(): bool
    {
        return $this->restriction_type === self::TYPE_SUB_ACCOUNT;
    }

    /**
     * Scope by restriction type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('restriction_type', $type);
    }

    /**
     * Scope to restrictions for a user.
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get restriction value as collection for easier manipulation.
     */
    public function getValueCollection(): \Illuminate\Support\Collection
    {
        return collect($this->restriction_value);
    }
}
