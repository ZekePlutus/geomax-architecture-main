<?php

declare(strict_types=1);

namespace App\Modules\Core\User\Http\Requests;

use App\Modules\Core\User\Models\UserRestriction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Add Restriction Request
 *
 * Validates data for adding a restriction to a user.
 */
class AddRestrictionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorization handled by ExecutionGateMiddleware
    }

    public function rules(): array
    {
        return [
            'restriction_type' => [
                'required',
                'string',
                Rule::in([
                    UserRestriction::TYPE_VEHICLE,
                    UserRestriction::TYPE_GEOFENCE,
                    UserRestriction::TYPE_TIME,
                    UserRestriction::TYPE_SUB_ACCOUNT,
                ]),
            ],
            'restriction_value' => ['required', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'restriction_type.required' => 'Please select a restriction type.',
            'restriction_type.in' => 'Invalid restriction type.',
            'restriction_value.required' => 'Restriction value is required.',
            'restriction_value.array' => 'Restriction value must be an array.',
        ];
    }
}
