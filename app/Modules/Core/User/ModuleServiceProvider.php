<?php

declare(strict_types=1);

namespace App\Modules\Core\User;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Modules\Core\User\Services\UserService;
use App\Modules\Core\User\Services\RoleService;
use App\Modules\Core\User\Services\PermissionCacheService;

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

        // Register RoleService as singleton
        $this->app->singleton(RoleService::class, function ($app) {
            return new RoleService(
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
        $this->registerAssets();
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

    /**
     * Register module assets (CSS/JS)
     *
     * Assets are self-contained within the module's Resources folder.
     * Publish to make them accessible from the public directory.
     */
    protected function registerAssets(): void
    {
        // Publish CSS assets
        $this->publishes([
            __DIR__ . '/Resources/css' => public_path('modules/user/css'),
        ], 'user-css');

        // Publish JS assets
        $this->publishes([
            __DIR__ . '/Resources/js' => public_path('modules/user/js'),
        ], 'user-js');

        // Publish all assets at once
        $this->publishes([
            __DIR__ . '/Resources/css' => public_path('modules/user/css'),
            __DIR__ . '/Resources/js' => public_path('modules/user/js'),
        ], 'user-assets');
    }
}
