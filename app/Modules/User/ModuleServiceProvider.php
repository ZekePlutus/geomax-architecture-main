<?php

declare(strict_types=1);

namespace App\Modules\User;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Modules\User\Services\UserService;
use App\Modules\User\Services\PermissionCacheService;

/**
 * User Module Service Provider
 *
 * Registers the User module's routes, views, and services.
 *
 * GOVERNANCE COMPLIANCE:
 * - Routes registered ONLY via this provider
 * - Module is isolated with no cross-module coupling
 * - No billing or capability enforcement logic
 */
class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register PermissionCacheService as singleton
        $this->app->singleton(PermissionCacheService::class, function ($app) {
            return new PermissionCacheService();
        });

        // Register UserService as singleton
        $this->app->singleton(UserService::class, function ($app) {
            return new UserService(
                $app->make(PermissionCacheService::class)
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerRoutes();
        $this->registerViews();
        $this->registerMigrations();
    }

    /**
     * Register module routes
     */
    protected function registerRoutes(): void
    {
        // Web routes
        Route::middleware('web')
            ->group(__DIR__ . '/Routes/web.php');

        // API routes
        Route::prefix('api')
            ->middleware('api')
            ->group(__DIR__ . '/Routes/api.php');
    }

    /**
     * Register module views
     */
    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/Views', 'user');

        // Publish views for customization
        $this->publishes([
            __DIR__ . '/Views' => resource_path('views/vendor/user'),
        ], 'user-views');
    }

    /**
     * Register module migrations
     */
    protected function registerMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
    }
}
