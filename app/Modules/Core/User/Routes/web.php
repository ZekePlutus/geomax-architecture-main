<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Modules\Core\User\Http\Controllers\UserController;
use App\Modules\Core\User\Http\Controllers\RoleController;
use App\Modules\Core\User\Http\Controllers\ActivationController;

/*
|--------------------------------------------------------------------------
| User Module Web Routes
|--------------------------------------------------------------------------
|
| GOVERNANCE: Routes are registered via ModuleServiceProvider.
| ExecutionGateMiddleware applies upstream for protected routes.
|
*/

// Password setup routes (for users created without password)
Route::prefix('setup')->name('user.setup.')->group(function () {
    Route::get('/{user}', [ActivationController::class, 'showSetupForm'])->name('form');
    Route::post('/{user}', [ActivationController::class, 'setup'])->name('submit');
});

// Protected user management routes
// TODO: Re-enable auth middleware once login is set up
Route::prefix('users')->name('user.users.')->group(function () {
    // CRUD
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{user}', [UserController::class, 'show'])->name('show');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('update');

    // Role management
    Route::get('/{user}/roles', [UserController::class, 'edit'])->name('roles.edit');
    Route::patch('/{user}/roles', [UserController::class, 'updateRoles'])->name('roles.update');

    // Activation status
    Route::post('/{user}/activate', [UserController::class, 'activate'])->name('activate');
    Route::post('/{user}/deactivate', [UserController::class, 'deactivate'])->name('deactivate');

    // Restrictions
    Route::get('/{user}/restrictions', [UserController::class, 'restrictions'])->name('restrictions');
    Route::post('/{user}/restrictions', [UserController::class, 'addRestriction'])->name('restrictions.add');
    Route::delete('/{user}/restrictions/{restriction}', [UserController::class, 'removeRestriction'])->name('restrictions.remove');

    // Module Permissions
    Route::get('/{user}/permissions', [UserController::class, 'permissions'])->name('permissions');
    Route::patch('/{user}/permissions', [UserController::class, 'updatePermissions'])->name('permissions.update');
});

// Role management routes
Route::prefix('roles')->name('user.roles.')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('index');
    Route::get('/create', [RoleController::class, 'create'])->name('create');
    Route::post('/', [RoleController::class, 'store'])->name('store');
    Route::get('/{role}', [RoleController::class, 'show'])->name('show');
    Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
    Route::put('/{role}', [RoleController::class, 'update'])->name('update');
    Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
    Route::post('/{role}/duplicate', [RoleController::class, 'duplicate'])->name('duplicate');
});
