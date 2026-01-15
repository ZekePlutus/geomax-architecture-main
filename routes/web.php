<?php

use Illuminate\Support\Facades\Route;



require __DIR__ . '/locale.php';
Route::get('/', function () {
    return view('welcome');
});

// Showcase Page
Route::get('/components', function () {
    return view('core-ui.components.showcase');
})->name('components.showcase');

// Component Examples
Route::prefix('examples')->name('examples')->group(function () {
    Route::get('/', function () {
        return view('examples.index');
    });

    // Form Components
    Route::get('/form/input', function () {
        return view('examples.form.input');
    })->name('.form.input');

    Route::get('/form/range', function () {
        return view('examples.form.range');
    })->name('.form.range');

    // General Components
    Route::get('/drawer', function () {
        return view('examples.drawer');
    })->name('.drawer');

    Route::get('/datatable', function () {
        return view('examples.datatable');
    })->name('.datatable');
});
