<?php

declare(strict_types=1);

namespace App\Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Assign Roles Request
 *
 * Validates data for assigning roles to a user.
 */
class AssignRolesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorization handled by ExecutionGateMiddleware
    }

    public function rules(): array
    {
        return [
            'role_ids' => ['required', 'array', 'min:1'],
            'role_ids.*' => ['integer', 'exists:roles,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'role_ids.required' => 'Please select at least one role.',
            'role_ids.min' => 'Please select at least one role.',
            'role_ids.*.exists' => 'One or more selected roles are invalid.',
        ];
    }
}
