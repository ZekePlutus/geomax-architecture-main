<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Modules\Core\User\Http\Controllers\Api\UserApiController;

/*
|--------------------------------------------------------------------------
| User Module API Routes
|--------------------------------------------------------------------------
|
| GOVERNANCE: Routes are registered via ModuleServiceProvider.
| ExecutionGateMiddleware applies upstream for protected routes.
| These routes expose identity & delegation data ONLY.
|
*/

Route::prefix('users')->name('api.user.users.')->middleware(['auth:sanctum'])->group(function () {
    // CRUD
    Route::get('/', [UserApiController::class, 'index'])->name('index');
    Route::post('/', [UserApiController::class, 'store'])->name('store');
    Route::get('/{user}', [UserApiController::class, 'show'])->name('show');
    Route::put('/{user}', [UserApiController::class, 'update'])->name('update');

    // Role management
    Route::patch('/{user}/roles', [UserApiController::class, 'updateRoles'])->name('roles.update');

    // Activation status
    Route::post('/{user}/activate', [UserApiController::class, 'activate'])->name('activate');
    Route::post('/{user}/deactivate', [UserApiController::class, 'deactivate'])->name('deactivate');

    // Restrictions
    Route::get('/{user}/restrictions', [UserApiController::class, 'restrictions'])->name('restrictions');
    Route::post('/{user}/restrictions', [UserApiController::class, 'addRestriction'])->name('restrictions.add');
    Route::delete('/{user}/restrictions/{restriction}', [UserApiController::class, 'removeRestriction'])->name('restrictions.remove');

    // Permissions (cached)
    Route::get('/{user}/permissions', [UserApiController::class, 'permissions'])->name('permissions');
});
