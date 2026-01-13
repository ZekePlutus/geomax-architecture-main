<?php

declare(strict_types=1);

namespace App\Modules\Core\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Create User Request
 *
 * Validates data for creating a new user.
 */
class CreateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorization handled by ExecutionGateMiddleware
    }

    public function rules(): array
    {
        return [
            'user_type_id' => ['required', 'integer', 'exists:user_types,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role_ids' => ['nullable', 'array'],
            'role_ids.*' => ['integer', 'exists:roles,id'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_type_id.required' => 'Please select a user type.',
            'user_type_id.exists' => 'Invalid user type selected.',
            'email.unique' => 'This email address is already in use.',
            'role_ids.*.exists' => 'One or more selected roles are invalid.',
        ];
    }
}
