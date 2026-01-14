<?php

/**
 * ================================================================================
 * CORE UI ROUTES - DEVELOPER PLAYGROUND
 * ================================================================================
 *
 * These routes are for DEVELOPMENT PURPOSES ONLY.
 * They provide a visual showcase for global UI components.
 *
 * SECURITY:
 * - Routes are ONLY available in local/staging environments
 * - No authentication required (dev tool)
 * - No business logic or tenant data
 *
 * USAGE:
 * Visit: /__components to see the component showcase
 *
 * TO DISABLE:
 * - Remove this file from RouteServiceProvider
 * - Or set APP_ENV=production
 * ================================================================================
 */

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Environment Guard
|--------------------------------------------------------------------------
|
| These routes are ONLY registered in non-production environments.
| This is enforced at the route registration level.
|
*/

if (!in_array(app()->environment(), ['local', 'staging', 'development', 'testing'])) {
    return;
}

/*
|--------------------------------------------------------------------------
| Component Showcase Route
|--------------------------------------------------------------------------
*/

Route::middleware(middleware: 'web')->prefix('__components')->group(function () {

    // Main showcase page
    Route::get('/', function () {
        return view('core-ui.components.showcase');
    })->name('core-ui.showcase');

    // Individual component preview (for future AJAX loading)
    Route::get('/{category}/{component}', function (string $category, string $component) {
        $viewPath = "core-ui.components.examples.{$category}.{$component}";

        if (!view()->exists($viewPath)) {
            abort(404, "Component example not found: {$category}/{$component}");
        }

        return view($viewPath);
    })->name('core-ui.component.preview');

});
