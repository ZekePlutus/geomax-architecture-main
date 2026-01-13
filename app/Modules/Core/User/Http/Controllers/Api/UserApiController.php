<?php

declare(strict_types=1);

namespace App\Modules\Core\User\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Core\User\Http\Requests\CreateUserRequest;
use App\Modules\Core\User\Http\Requests\UpdateUserRequest;
use App\Modules\Core\User\Http\Requests\AssignRolesRequest;
use App\Modules\Core\User\Http\Requests\AddRestrictionRequest;
use App\Modules\Core\User\Models\User;
use App\Modules\Core\User\Models\UserRestriction;
use App\Modules\Core\User\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * User API Controller
 *
 * Handles API requests for user management.
 *
 * GOVERNANCE COMPLIANCE:
 * - NO permission checks in this controller
 * - NO role == admin shortcuts
 * - ExecutionGateMiddleware runs BEFORE this controller
 * - Returns identity & delegation data ONLY
 */
class UserApiController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    /**
     * List users in the company
     */
    public function index(Request $request): JsonResponse
    {
        $companyId = $request->get('company_id');
        $activeOnly = $request->has('active_only') ? (bool) $request->get('active_only') : null;

        $users = $this->userService->listUsersForCompany($companyId, $activeOnly);

        return response()->json([
            'data' => $users->map(fn (User $user) => $this->transformUser($user)),
        ]);
    }

    /**
     * Get a specific user
     */
    public function show(User $user): JsonResponse
    {
        $user->load(['userType', 'company', 'roles', 'restrictions']);

        return response()->json([
            'data' => $this->transformUser($user),
        ]);
    }

    /**
     * Create a new user
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['company_id'] = $request->get('company_id');

        $user = $this->userService->createUser($data);

        return response()->json([
            'data' => $this->transformUser($user),
            'message' => 'User created successfully',
        ], 201);
    }

    /**
     * Update user
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user = $this->userService->updateUser($user, $request->validated());

        return response()->json([
            'data' => $this->transformUser($user),
            'message' => 'User updated successfully',
        ]);
    }

    /**
     * Update user roles
     */
    public function updateRoles(AssignRolesRequest $request, User $user): JsonResponse
    {
        $user = $this->userService->assignRoles($user, $request->validated('role_ids'));

        return response()->json([
            'data' => $this->transformUser($user),
            'message' => 'Roles updated successfully',
        ]);
    }

    /**
     * Activate user
     */
    public function activate(User $user): JsonResponse
    {
        $user = $this->userService->activateUser($user);

        return response()->json([
            'data' => $this->transformUser($user),
            'message' => 'User activated successfully',
        ]);
    }

    /**
     * Deactivate user
     */
    public function deactivate(User $user): JsonResponse
    {
        $user = $this->userService->deactivateUser($user);

        return response()->json([
            'data' => $this->transformUser($user),
            'message' => 'User deactivated successfully',
        ]);
    }

    /**
     * Get user restrictions
     */
    public function restrictions(User $user): JsonResponse
    {
        $user->load('restrictions');

        return response()->json([
            'data' => $user->restrictions->map(fn ($r) => [
                'id' => $r->id,
                'type' => $r->restriction_type,
                'value' => $r->restriction_value,
                'created_at' => $r->created_at?->toISOString(),
            ]),
        ]);
    }

    /**
     * Add a restriction to user
     */
    public function addRestriction(AddRestrictionRequest $request, User $user): JsonResponse
    {
        $restriction = $this->userService->addRestriction(
            $user,
            $request->validated('restriction_type'),
            $request->validated('restriction_value')
        );

        return response()->json([
            'data' => [
                'id' => $restriction->id,
                'type' => $restriction->restriction_type,
                'value' => $restriction->restriction_value,
                'created_at' => $restriction->created_at?->toISOString(),
            ],
            'message' => 'Restriction added successfully',
        ], 201);
    }

    /**
     * Remove a restriction from user
     */
    public function removeRestriction(User $user, UserRestriction $restriction): JsonResponse
    {
        if ($restriction->user_id !== $user->id) {
            return response()->json(['error' => 'Restriction not found'], 404);
        }

        $this->userService->removeRestriction($restriction);

        return response()->json([
            'message' => 'Restriction removed successfully',
        ]);
    }

    /**
     * Get user effective permissions (from cache)
     */
    public function permissions(User $user): JsonResponse
    {
        $user->load('effectivePermissions');

        return response()->json([
            'data' => $user->effectivePermissions
                ->where('is_valid', true)
                ->map(fn ($p) => [
                    'permission_key' => $p->permission_key,
                    'source' => $p->source,
                    'has_restriction' => $p->has_restriction,
                ]),
        ]);
    }

    /**
     * Transform user for API response
     *
     * GOVERNANCE: Exposes identity & delegation data ONLY.
     */
    private function transformUser(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'is_active' => $user->is_active,
            'company_id' => $user->company_id,
            'user_type' => $user->userType ? [
                'id' => $user->userType->id,
                'name' => $user->userType->name,
            ] : null,
            'roles' => $user->roles->map(fn ($role) => [
                'id' => $role->id,
                'name' => $role->name,
                'is_system' => $role->is_system,
            ])->toArray(),
            'restrictions_count' => $user->restrictions?->count() ?? 0,
            'last_login_at' => $user->last_login_at?->toISOString(),
            'created_at' => $user->created_at?->toISOString(),
            'updated_at' => $user->updated_at?->toISOString(),
        ];
    }
}
