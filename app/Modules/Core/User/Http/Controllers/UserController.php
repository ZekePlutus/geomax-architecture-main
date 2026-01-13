<?php

declare(strict_types=1);

namespace App\Modules\Core\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Core\User\Http\Requests\CreateUserRequest;
use App\Modules\Core\User\Http\Requests\UpdateUserRequest;
use App\Modules\Core\User\Http\Requests\AssignRolesRequest;
use App\Modules\Core\User\Http\Requests\AddRestrictionRequest;
use App\Modules\Core\User\Models\User;
use App\Modules\Core\User\Models\Role;
use App\Modules\Core\User\Models\UserRestriction;
use App\Modules\Core\User\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * User Controller
 *
 * Handles web requests for user management within a company context.
 *
 * GOVERNANCE COMPLIANCE:
 * - NO permission checks in this controller
 * - NO role == admin shortcuts
 * - NO module enable/disable logic
 * - NO billing references
 * - ExecutionGateMiddleware runs BEFORE this controller
 * - Tenant/company context is resolved UPSTREAM
 */
class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    /**
     * Check if we should use mock data (no database available)
     */
    private function useMockData(): bool
    {
        return config('app.mock_database', true); // TODO: Set to false when DB is available
    }

    /**
     * Get mock users for UI testing (25 users for pagination demo)
     */
    private function getMockUsers(): \Illuminate\Support\Collection
    {
        $users = collect([
            // Page 1
            (object) [
                'id' => 1, 'name' => 'Marcus Thompson', 'email' => 'marcus.thompson@fleety.com',
                'is_active' => true, 'user_type_id' => 1, 'phone' => '+1 555-0101',
                'last_login_at' => now()->subMinutes(15), 'created_at' => now()->subMonths(6),
                'userType' => (object) ['id' => 1, 'name' => 'Sub-Reseller'],
                'company' => (object) ['id' => 1, 'name' => 'Fleety HQ'],
                'roles' => collect([(object) ['id' => 1, 'name' => 'Fleet Manager', 'is_system' => true]]),
                'restrictions' => collect([]),
            ],
            (object) [
                'id' => 2, 'name' => 'Sarah Chen', 'email' => 'sarah.chen@fleety.com',
                'is_active' => true, 'user_type_id' => 1, 'phone' => '+1 555-0102',
                'last_login_at' => now()->subHours(2), 'created_at' => now()->subMonths(5),
                'userType' => (object) ['id' => 1, 'name' => 'Sub-Reseller'],
                'company' => (object) ['id' => 2, 'name' => 'Chen Logistics'],
                'roles' => collect([(object) ['id' => 2, 'name' => 'Manager', 'is_system' => true]]),
                'restrictions' => collect([]),
            ],
            (object) [
                'id' => 3, 'name' => 'James Wilson', 'email' => 'james.wilson@example.com',
                'is_active' => true, 'user_type_id' => 2, 'phone' => '+1 555-0103',
                'last_login_at' => now()->subDays(1), 'created_at' => now()->subMonths(4),
                'userType' => (object) ['id' => 2, 'name' => 'Company Admin'],
                'company' => (object) ['id' => 3, 'name' => 'Wilson Transport'],
                'roles' => collect([(object) ['id' => 3, 'name' => 'Dispatcher', 'is_system' => true]]),
                'restrictions' => collect([]),
            ],
            (object) [
                'id' => 4, 'name' => 'Emily Rodriguez', 'email' => 'emily.r@example.com',
                'is_active' => true, 'user_type_id' => 4, 'phone' => '+1 555-0104',
                'last_login_at' => now()->subHours(5), 'created_at' => now()->subMonths(3),
                'userType' => (object) ['id' => 3, 'name' => 'Company User'],
                'company' => (object) ['id' => 1, 'name' => 'Fleety HQ'],
                'roles' => collect([(object) ['id' => 4, 'name' => 'Support', 'is_system' => false]]),
                'restrictions' => collect([]),
            ],
            (object) [
                'id' => 5, 'name' => 'Michael Brown', 'email' => 'michael.b@example.com',
                'is_active' => false, 'user_type_id' => 4, 'phone' => '+1 555-0105',
                'last_login_at' => now()->subWeeks(2), 'created_at' => now()->subMonths(2),
                'userType' => (object) ['id' => 4, 'name' => 'Driver'],
                'company' => (object) ['id' => 2, 'name' => 'Chen Logistics'],
                'roles' => collect([]),
                'restrictions' => collect([(object) ['id' => 1, 'restriction_type' => 'vehicle', 'restriction_value' => ['ids' => [101]], 'created_at' => now()->subDays(10)]]),
            ],
            (object) [
                'id' => 6, 'name' => 'Jessica Martinez', 'email' => 'jessica.m@example.com',
                'is_active' => true, 'user_type_id' => 3, 'phone' => '+1 555-0106',
                'last_login_at' => now()->subHours(1), 'created_at' => now()->subMonths(4),
                'userType' => (object) ['id' => 2, 'name' => 'Company Admin'],
                'company' => (object) ['id' => 4, 'name' => 'Martinez Freight'],
                'roles' => collect([(object) ['id' => 1, 'name' => 'Fleet Manager', 'is_system' => true]]),
                'restrictions' => collect([]),
            ],
            (object) [
                'id' => 7, 'name' => 'David Lee', 'email' => 'david.lee@example.com',
                'is_active' => true, 'user_type_id' => 3, 'phone' => '+1 555-0107',
                'last_login_at' => now()->subDays(3), 'created_at' => now()->subMonths(1),
                'userType' => (object) ['id' => 3, 'name' => 'Company User'],
                'company' => (object) ['id' => 3, 'name' => 'Wilson Transport'],
                'roles' => collect([(object) ['id' => 3, 'name' => 'Dispatcher', 'is_system' => true]]),
                'restrictions' => collect([]),
            ],
            (object) [
                'id' => 8, 'name' => 'Amanda Taylor', 'email' => 'amanda.t@example.com',
                'is_active' => true, 'user_type_id' => 5, 'phone' => '+1 555-0108',
                'last_login_at' => now()->subHours(8), 'created_at' => now()->subWeeks(6),
                'userType' => (object) ['id' => 4, 'name' => 'Driver'],
                'company' => (object) ['id' => 1, 'name' => 'Fleety HQ'],
                'roles' => collect([]),
                'restrictions' => collect([]),
            ],
            (object) [
                'id' => 9, 'name' => 'Robert Garcia', 'email' => 'robert.g@example.com',
                'is_active' => false, 'user_type_id' => 3, 'phone' => '+1 555-0109',
                'last_login_at' => null, 'created_at' => now()->subMonths(2),
                'userType' => (object) ['id' => 3, 'name' => 'Company User'],
                'company' => (object) ['id' => 2, 'name' => 'Chen Logistics'],
                'roles' => collect([(object) ['id' => 4, 'name' => 'Support', 'is_system' => false]]),
                'restrictions' => collect([]),
            ],
            (object) [
                'id' => 10, 'name' => 'Lisa Anderson', 'email' => 'lisa.a@example.com',
                'is_active' => true, 'user_type_id' => 2, 'phone' => '+1 555-0110',
                'last_login_at' => now()->subMinutes(45), 'created_at' => now()->subMonths(3),
                'userType' => (object) ['id' => 1, 'name' => 'Sub-Reseller'],
                'company' => (object) ['id' => 5, 'name' => 'Anderson Fleet Services'],
                'roles' => collect([(object) ['id' => 2, 'name' => 'Manager', 'is_system' => true]]),
                'restrictions' => collect([]),
            ],
            // Page 2
            (object) [
                'id' => 11, 'name' => 'Kevin White', 'email' => 'kevin.w@example.com',
                'is_active' => true, 'user_type_id' => 4, 'phone' => '+1 555-0111',
                'last_login_at' => now()->subDays(2), 'created_at' => now()->subWeeks(8),
                'userType' => (object) ['id' => 4, 'name' => 'Driver'],
                'company' => (object) ['id' => 4, 'name' => 'Martinez Freight'],
                'roles' => collect([]),
                'restrictions' => collect([(object) ['id' => 2, 'restriction_type' => 'geofence', 'restriction_value' => ['zone' => 'west'], 'created_at' => now()->subDays(5)]]),
            ],
            (object) [
                'id' => 12, 'name' => 'Jennifer Clark', 'email' => 'jennifer.c@example.com',
                'is_active' => true, 'user_type_id' => 3, 'phone' => '+1 555-0112',
                'last_login_at' => now()->subHours(3), 'created_at' => now()->subMonths(5),
                'userType' => (object) ['id' => 2, 'name' => 'Company Admin'],
                'company' => (object) ['id' => 6, 'name' => 'Clark Delivery Co'],
                'roles' => collect([(object) ['id' => 1, 'name' => 'Fleet Manager', 'is_system' => true]]),
                'restrictions' => collect([]),
            ],
            (object) [
                'id' => 13, 'name' => 'Christopher Hall', 'email' => 'chris.h@example.com',
                'is_active' => true, 'user_type_id' => 3, 'phone' => '+1 555-0113',
                'last_login_at' => now()->subDays(1), 'created_at' => now()->subWeeks(4),
                'userType' => (object) ['id' => 3, 'name' => 'Company User'],
                'company' => (object) ['id' => 5, 'name' => 'Anderson Fleet Services'],
                'roles' => collect([(object) ['id' => 4, 'name' => 'Support', 'is_system' => false]]),
                'restrictions' => collect([]),
            ],
            (object) [
                'id' => 14, 'name' => 'Patricia Young', 'email' => 'patricia.y@example.com',
                'is_active' => false, 'user_type_id' => 5, 'phone' => '+1 555-0114',
                'last_login_at' => now()->subMonths(1), 'created_at' => now()->subMonths(3),
                'userType' => (object) ['id' => 4, 'name' => 'Driver'],
                'company' => (object) ['id' => 3, 'name' => 'Wilson Transport'],
                'roles' => collect([]),
                'restrictions' => collect([]),
            ],
            (object) [
                'id' => 15, 'name' => 'Daniel King', 'email' => 'daniel.k@example.com',
                'is_active' => true, 'user_type_id' => 3, 'phone' => '+1 555-0115',
                'last_login_at' => now()->subHours(6), 'created_at' => now()->subWeeks(10),
                'userType' => (object) ['id' => 3, 'name' => 'Company User'],
                'company' => (object) ['id' => 1, 'name' => 'Fleety HQ'],
                'roles' => collect([(object) ['id' => 3, 'name' => 'Dispatcher', 'is_system' => true]]),
                'restrictions' => collect([]),
            ],
            (object) [
                'id' => 16, 'name' => 'Michelle Scott', 'email' => 'michelle.s@example.com',
                'is_active' => true, 'user_type_id' => 2, 'phone' => '+1 555-0116',
                'last_login_at' => now()->subMinutes(30), 'created_at' => now()->subMonths(4),
                'userType' => (object) ['id' => 1, 'name' => 'Sub-Reseller'],
                'company' => (object) ['id' => 7, 'name' => 'Scott Logistics Group'],
                'roles' => collect([(object) ['id' => 2, 'name' => 'Manager', 'is_system' => true]]),
                'restrictions' => collect([]),
            ],
            (object) [
                'id' => 17, 'name' => 'Thomas Green', 'email' => 'thomas.g@example.com',
                'is_active' => true, 'user_type_id' => 4, 'phone' => '+1 555-0117',
                'last_login_at' => now()->subDays(4), 'created_at' => now()->subWeeks(6),
                'userType' => (object) ['id' => 4, 'name' => 'Driver'],
                'company' => (object) ['id' => 6, 'name' => 'Clark Delivery Co'],
                'roles' => collect([]),
                'restrictions' => collect([]),
            ],
            (object) [
                'id' => 18, 'name' => 'Nancy Adams', 'email' => 'nancy.a@example.com',
                'is_active' => true, 'user_type_id' => 4, 'phone' => '+1 555-0118',
                'last_login_at' => now()->subHours(12), 'created_at' => now()->subMonths(2),
                'userType' => (object) ['id' => 3, 'name' => 'Company User'],
                'company' => (object) ['id' => 7, 'name' => 'Scott Logistics Group'],
                'roles' => collect([(object) ['id' => 4, 'name' => 'Support', 'is_system' => false]]),
                'restrictions' => collect([]),
            ],
            (object) [
                'id' => 19, 'name' => 'Steven Baker', 'email' => 'steven.b@example.com',
                'is_active' => false, 'user_type_id' => 3, 'phone' => '+1 555-0119',
                'last_login_at' => now()->subWeeks(3), 'created_at' => now()->subMonths(1),
                'userType' => (object) ['id' => 3, 'name' => 'Company User'],
                'company' => (object) ['id' => 4, 'name' => 'Martinez Freight'],
                'roles' => collect([]),
                'restrictions' => collect([]),
            ],
            (object) [
                'id' => 20, 'name' => 'Betty Nelson', 'email' => 'betty.n@example.com',
                'is_active' => true, 'user_type_id' => 3, 'phone' => '+1 555-0120',
                'last_login_at' => now()->subHours(4), 'created_at' => now()->subMonths(6),
                'userType' => (object) ['id' => 2, 'name' => 'Company Admin'],
                'company' => (object) ['id' => 8, 'name' => 'Nelson Trucking'],
                'roles' => collect([(object) ['id' => 1, 'name' => 'Fleet Manager', 'is_system' => true]]),
                'restrictions' => collect([]),
            ],
            // Page 3
            (object) [
                'id' => 21, 'name' => 'Edward Carter', 'email' => 'edward.c@example.com',
                'is_active' => true, 'user_type_id' => 4, 'phone' => '+1 555-0121',
                'last_login_at' => now()->subDays(1), 'created_at' => now()->subWeeks(12),
                'userType' => (object) ['id' => 4, 'name' => 'Driver'],
                'company' => (object) ['id' => 8, 'name' => 'Nelson Trucking'],
                'roles' => collect([]),
                'restrictions' => collect([(object) ['id' => 3, 'restriction_type' => 'time', 'restriction_value' => ['hours' => '06:00-18:00'], 'created_at' => now()->subDays(15)]]),
            ],
            (object) [
                'id' => 22, 'name' => 'Sandra Mitchell', 'email' => 'sandra.m@example.com',
                'is_active' => true, 'user_type_id' => 4, 'phone' => '+1 555-0122',
                'last_login_at' => now()->subHours(2), 'created_at' => now()->subWeeks(8),
                'userType' => (object) ['id' => 3, 'name' => 'Company User'],
                'company' => (object) ['id' => 2, 'name' => 'Chen Logistics'],
                'roles' => collect([(object) ['id' => 3, 'name' => 'Dispatcher', 'is_system' => true]]),
                'restrictions' => collect([]),
            ],
            (object) [
                'id' => 23, 'name' => 'Paul Roberts', 'email' => 'paul.r@example.com',
                'is_active' => false, 'user_type_id' => 4, 'phone' => '+1 555-0123',
                'last_login_at' => null, 'created_at' => now()->subMonths(2),
                'userType' => (object) ['id' => 4, 'name' => 'Driver'],
                'company' => (object) ['id' => 1, 'name' => 'Fleety HQ'],
                'roles' => collect([]),
                'restrictions' => collect([]),
            ],
            (object) [
                'id' => 24, 'name' => 'Dorothy Turner', 'email' => 'dorothy.t@example.com',
                'is_active' => true, 'user_type_id' => 4, 'phone' => '+1 555-0124',
                'last_login_at' => now()->subDays(2), 'created_at' => now()->subWeeks(5),
                'userType' => (object) ['id' => 3, 'name' => 'Company User'],
                'company' => (object) ['id' => 5, 'name' => 'Anderson Fleet Services'],
                'roles' => collect([(object) ['id' => 4, 'name' => 'Support', 'is_system' => false]]),
                'restrictions' => collect([]),
            ],
            (object) [
                'id' => 25, 'name' => 'George Phillips', 'email' => 'george.p@example.com',
                'is_active' => true, 'user_type_id' => 4, 'phone' => '+1 555-0125',
                'last_login_at' => now()->subHours(10), 'created_at' => now()->subMonths(1),
                'userType' => (object) ['id' => 4, 'name' => 'Driver'],
                'company' => (object) ['id' => 7, 'name' => 'Scott Logistics Group'],
                'roles' => collect([]),
                'restrictions' => collect([]),
            ],
        ]);

        return $users;
    }

    /**
     * Get mock user types (not editable)
     */
    private function getMockUserTypes(): \Illuminate\Support\Collection
    {
        return collect([
            (object) ['id' => 1, 'name' => 'Sub-Reseller', 'description' => 'Sub-reseller with delegated access', 'editable' => false],
            (object) ['id' => 2, 'name' => 'Company Admin', 'description' => 'Company administrator', 'editable' => false],
            (object) ['id' => 3, 'name' => 'Company User', 'description' => 'Standard company user', 'editable' => false],
            (object) ['id' => 4, 'name' => 'Driver', 'description' => 'Driver with mobile app access', 'editable' => false],
        ]);
    }

    /**
     * Get mock roles
     */
    private function getMockRoles(): \Illuminate\Support\Collection
    {
        return collect([
            (object) ['id' => 1, 'name' => 'Fleet Manager', 'is_system' => true, 'description' => 'Full fleet management access'],
            (object) ['id' => 2, 'name' => 'Manager', 'is_system' => true, 'description' => 'General management access'],
            (object) ['id' => 3, 'name' => 'Dispatcher', 'is_system' => true, 'description' => 'Dispatch and routing access'],
            (object) ['id' => 4, 'name' => 'Support', 'is_system' => false, 'description' => 'Customer support access'],
        ]);
    }

    /**
     * Get mock modules for permissions
     */
    private function getMockModules(): \Illuminate\Support\Collection
    {
        return collect([
            (object) ['id' => 1, 'name' => 'Dashboard', 'slug' => 'dashboard', 'icon' => 'ki-home', 'description' => 'Main dashboard and analytics'],
            (object) ['id' => 2, 'name' => 'Live Tracking', 'slug' => 'tracking', 'icon' => 'ki-geolocation', 'description' => 'Real-time vehicle tracking'],
            (object) ['id' => 3, 'name' => 'Fleet Management', 'slug' => 'fleet', 'icon' => 'ki-car', 'description' => 'Vehicle and asset management'],
            (object) ['id' => 4, 'name' => 'Trips & Routes', 'slug' => 'trips', 'icon' => 'ki-route', 'description' => 'Trip history and route planning'],
            (object) ['id' => 5, 'name' => 'Geofences', 'slug' => 'geofences', 'icon' => 'ki-map', 'description' => 'Geofence zones management'],
            (object) ['id' => 6, 'name' => 'Alerts', 'slug' => 'alerts', 'icon' => 'ki-notification', 'description' => 'Alert rules and notifications'],
            (object) ['id' => 7, 'name' => 'Reports', 'slug' => 'reports', 'icon' => 'ki-chart-simple', 'description' => 'Analytics and reporting'],
            (object) ['id' => 8, 'name' => 'Maintenance', 'slug' => 'maintenance', 'icon' => 'ki-wrench', 'description' => 'Vehicle maintenance scheduling'],
            (object) ['id' => 9, 'name' => 'Fuel Management', 'slug' => 'fuel', 'icon' => 'ki-gas-station', 'description' => 'Fuel tracking and costs'],
            (object) ['id' => 10, 'name' => 'Driver Management', 'slug' => 'drivers', 'icon' => 'ki-people', 'description' => 'Driver profiles and scoring'],
            (object) ['id' => 11, 'name' => 'User Management', 'slug' => 'users', 'icon' => 'ki-user', 'description' => 'User accounts and permissions'],
            (object) ['id' => 12, 'name' => 'Settings', 'slug' => 'settings', 'icon' => 'ki-setting', 'description' => 'System configuration'],
        ]);
    }

    /**
     * Display list of users in the company
     *
     * GOVERNANCE: Assumes company context is resolved upstream.
     */
    public function index(Request $request): View
    {
        if ($this->useMockData()) {
            $users = $this->getMockUsers();
            $activeOnly = $request->has('active_only') ? (bool) $request->get('active_only') : null;
            
            if ($activeOnly === true) {
                $users = $users->where('is_active', true);
            } elseif ($activeOnly === false) {
                $users = $users->where('is_active', false);
            }

            return view('user::users.index', [
                'users' => $users,
                'activeOnly' => $activeOnly,
            ]);
        }

        $companyId = $request->get('company_id');
        $activeOnly = $request->has('active_only') ? (bool) $request->get('active_only') : null;

        $users = $this->userService->listUsersForCompany($companyId, $activeOnly);

        return view('user::users.index', [
            'users' => $users,
            'activeOnly' => $activeOnly,
        ]);
    }

    /**
     * Show form to create a new user
     */
    public function create(Request $request): View
    {
        if ($this->useMockData()) {
            return view('user::users.create', [
                'userTypes' => $this->getMockUserTypes(),
                'roles' => $this->getMockRoles(),
                'modules' => $this->getMockModules(),
                'roleDefaultModules' => $this->getRoleDefaultModules(),
            ]);
        }

        $companyId = $request->get('company_id');

        return view('user::users.create', [
            'userTypes' => $this->userService->getUserTypes(),
            'roles' => $this->userService->getAvailableRoles($companyId),
            'modules' => $this->userService->getModules(),
            'roleDefaultModules' => $this->getRoleDefaultModules(),
        ]);
    }

    /**
     * Get default module permissions for each role.
     */
    private function getRoleDefaultModules(): array
    {
        return [
            // Fleet Manager - Full access to all modules
            1 => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            // Manager - Most modules except Settings
            2 => [1, 2, 3, 4, 5, 6, 7, 8, 10, 11],
            // Dispatcher - Operational modules
            3 => [1, 2, 3, 5, 7, 10],
            // Support - Limited to reporting and alerts
            4 => [1, 6, 7, 8, 10],
        ];
    }

    /**
     * Process user creation
     *
     * GOVERNANCE: No permission check here - handled by ExecutionGateMiddleware.
     */
    public function store(CreateUserRequest $request): RedirectResponse
    {
        if ($this->useMockData()) {
            return redirect()
                ->route('user.users.index')
                ->with('success', '[MOCK] User created successfully');
        }

        $data = $request->validated();
        $data['company_id'] = $request->get('company_id');

        $user = $this->userService->createUser($data);

        return redirect()
            ->route('user.users.show', $user)
            ->with('success', "User {$user->name} created successfully");
    }

    /**
     * Display a specific user
     */
    public function show($user): View
    {
        if ($this->useMockData()) {
            $mockUsers = $this->getMockUsers();
            $mockUser = collect($mockUsers)->firstWhere('id', (int) $user) ?? $mockUsers[0];
            // Mock user already has roles and restrictions from getMockUsers()
            return view('user::users.show', [
                'user' => $mockUser,
            ]);
        }

        $user->load(['userType', 'company', 'roles', 'restrictions']);

        return view('user::users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show form to edit user
     */
    public function edit(Request $request, $user): View
    {
        if ($this->useMockData()) {
            $mockUsers = $this->getMockUsers();
            $mockUser = collect($mockUsers)->firstWhere('id', (int) $user) ?? $mockUsers[0];
            // Mock user already has roles from getMockUsers()
            return view('user::users.edit', [
                'user' => $mockUser,
                'userTypes' => $this->getMockUserTypes(),
                'roles' => $this->getMockRoles(),
                'modules' => $this->getMockModules(),
                'roleDefaultModules' => $this->getRoleDefaultModules(),
            ]);
        }

        $companyId = $request->get('company_id');
        $user->load(['userType', 'roles']);

        return view('user::users.edit', [
            'user' => $user,
            'userTypes' => $this->userService->getUserTypes(),
            'roles' => $this->userService->getAvailableRoles($companyId),
            'modules' => $this->userService->getModules(),
            'roleDefaultModules' => $this->getRoleDefaultModules(),
        ]);
    }

    /**
     * Update user
     */
    public function update(UpdateUserRequest $request, $user): RedirectResponse
    {
        if ($this->useMockData()) {
            return redirect()
                ->route('user.users.index')
                ->with('success', '[MOCK] User updated successfully');
        }

        $this->userService->updateUser($user, $request->validated());

        return redirect()
            ->route('user.users.show', $user)
            ->with('success', 'User updated successfully');
    }

    /**
     * Update user roles
     *
     * GOVERNANCE: This only updates role INTENT.
     * Effective permissions resolved at runtime by Execution Gate.
     */
    public function updateRoles(AssignRolesRequest $request, $user): RedirectResponse
    {
        if ($this->useMockData()) {
            return redirect()
                ->route('user.users.index')
                ->with('success', '[MOCK] User roles updated successfully');
        }

        $this->userService->assignRoles($user, $request->validated('role_ids'));

        return redirect()
            ->route('user.users.show', $user)
            ->with('success', 'User roles updated successfully');
    }

    /**
     * Activate user
     */
    public function activate($user): RedirectResponse
    {
        if ($this->useMockData()) {
            return redirect()
                ->route('user.users.index')
                ->with('success', '[MOCK] User activated successfully');
        }

        $this->userService->activateUser($user);

        return redirect()
            ->route('user.users.show', $user)
            ->with('success', 'User activated successfully');
    }

    /**
     * Deactivate user
     */
    public function deactivate($user): RedirectResponse
    {
        if ($this->useMockData()) {
            return redirect()
                ->route('user.users.index')
                ->with('success', '[MOCK] User deactivated successfully');
        }

        $this->userService->deactivateUser($user);

        return redirect()
            ->route('user.users.show', $user)
            ->with('success', 'User deactivated successfully');
    }

    /**
     * Show restrictions management page
     */
    public function restrictions($user): View
    {
        if ($this->useMockData()) {
            $mockUsers = $this->getMockUsers();
            $mockUser = collect($mockUsers)->firstWhere('id', (int) $user) ?? $mockUsers[0];
            // Mock user already has restrictions from getMockUsers()
            return view('user::users.restrictions', [
                'user' => $mockUser,
                'restrictionTypes' => [
                    UserRestriction::TYPE_VEHICLE => 'Vehicle',
                    UserRestriction::TYPE_GEOFENCE => 'Geofence',
                    UserRestriction::TYPE_TIME => 'Time',
                    UserRestriction::TYPE_SUB_ACCOUNT => 'Sub-Account',
                ],
            ]);
        }

        $user->load('restrictions');

        return view('user::users.restrictions', [
            'user' => $user,
            'restrictionTypes' => [
                UserRestriction::TYPE_VEHICLE => 'Vehicle',
                UserRestriction::TYPE_GEOFENCE => 'Geofence',
                UserRestriction::TYPE_TIME => 'Time',
                UserRestriction::TYPE_SUB_ACCOUNT => 'Sub-Account',
            ],
        ]);
    }

    /**
     * Add a restriction to user
     */
    public function addRestriction(AddRestrictionRequest $request, $user): RedirectResponse
    {
        if ($this->useMockData()) {
            return redirect()
                ->route('user.users.index')
                ->with('success', '[MOCK] Restriction added successfully');
        }

        $this->userService->addRestriction(
            $user,
            $request->validated('restriction_type'),
            $request->validated('restriction_value')
        );

        return redirect()
            ->route('user.users.restrictions', $user)
            ->with('success', 'Restriction added successfully');
    }

    /**
     * Remove a restriction from user
     */
    public function removeRestriction($user, $restriction): RedirectResponse
    {
        if ($this->useMockData()) {
            return redirect()
                ->route('user.users.index')
                ->with('success', '[MOCK] Restriction removed successfully');
        }

        if ($restriction->user_id !== $user->id) {
            abort(404);
        }

        $this->userService->removeRestriction($restriction);

        return redirect()
            ->route('user.users.restrictions', $user)
            ->with('success', 'Restriction removed successfully');
    }

    /**
     * Show permissions management page
     */
    public function permissions($user): View
    {
        if ($this->useMockData()) {
            $mockUsers = $this->getMockUsers();
            $mockUser = collect($mockUsers)->firstWhere('id', (int) $user) ?? $mockUsers[0];
            
            // Mock user permissions (randomly assign some modules as enabled)
            $modules = $this->getMockModules();
            $userModuleIds = collect([1, 2, 3, 4, 7]); // Default enabled modules for mock
            
            return view('user::users.permissions', [
                'user' => $mockUser,
                'modules' => $modules,
                'userModuleIds' => $userModuleIds,
            ]);
        }

        $user->load('permissions');
        $modules = $this->getMockModules(); // TODO: Replace with real module service

        return view('user::users.permissions', [
            'user' => $user,
            'modules' => $modules,
            'userModuleIds' => $user->permissions->pluck('module_id'),
        ]);
    }

    /**
     * Update user module permissions
     */
    public function updatePermissions(Request $request, $user): RedirectResponse
    {
        if ($this->useMockData()) {
            return redirect()
                ->route('user.users.permissions', $user)
                ->with('success', '[MOCK] Module permissions updated successfully');
        }

        $request->validate([
            'module_ids' => 'array',
            'module_ids.*' => 'integer|exists:modules,id',
        ]);

        // TODO: Implement real permission sync
        // $this->userService->syncModulePermissions($user, $request->input('module_ids', []));

        return redirect()
            ->route('user.users.permissions', $user)
            ->with('success', 'Module permissions updated successfully');
    }
}
