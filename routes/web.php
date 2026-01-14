<?php

use Illuminate\Support\Facades\Route;



require __DIR__ . '/locale.php';
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Component Showcase (DEV ONLY)
|--------------------------------------------------------------------------
*/
if (in_array(app()->environment(), ['local', 'staging', 'development', 'testing'])) {
    Route::prefix('__components')->group(function () {
        Route::get('/', function () {
            return view('core-ui.components.showcase');
        })->name('core-ui.showcase');

        Route::get('/{category}/{component}', function (string $category, string $component) {
            $viewPath = "core-ui.components.examples.{$category}.{$component}";
            if (!view()->exists($viewPath)) {
                abort(404, "Component example not found: {$category}/{$component}");
            }
            return view($viewPath);
        })->name('core-ui.component.preview');
    });
}

// Component Examples
Route::prefix('examples')->name('examples')->group(function () {
    Route::get('/', function () {
        return view('layout50.examples.index');
    });

    // Form Components
    Route::get('/form/input', function () {
        return view('layout50.examples.form.input');
    })->name('.form.input');

    // General Components
    Route::get('/drawer', function () {
        return view('layout50.examples.drawer');
    })->name('.drawer');


});
