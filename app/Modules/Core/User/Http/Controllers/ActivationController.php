<?php

declare(strict_types=1);

namespace App\Modules\Core\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Core\User\Models\User;
use App\Modules\Core\User\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Activation Controller
 *
 * Handles user login recording and password setup.
 * 
 * Note: The old invitation flow has been replaced with direct user creation.
 * This controller now handles password setup for users created without passwords.
 *
 * GOVERNANCE COMPLIANCE:
 * - NO permission checks (this is for self-service)
 * - NO role-based shortcuts
 * - NO billing references
 */
class ActivationController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    /**
     * Show password setup form for users without passwords
     */
    public function showSetupForm(Request $request, User $user): View|RedirectResponse
    {
        // Verify user has a valid setup token (if implementing token-based setup)
        $token = $request->get('token');
        
        if ($user->password !== null) {
            return redirect()
                ->route('login')
                ->with('info', 'Your account is already set up. Please log in.');
        }

        return view('user::activation.setup', [
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Process password setup
     */
    public function setup(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($user->password !== null) {
            return redirect()
                ->route('login')
                ->with('error', 'Account already set up.');
        }

        $this->userService->updateUser($user, [
            'password' => $request->input('password'),
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Password set successfully. Please log in.');
    }
}
