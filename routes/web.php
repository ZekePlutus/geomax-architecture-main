<?php

use Illuminate\Support\Facades\Route;



require __DIR__ . '/locale.php';
Route::get('/', function () {
    return view('welcome');
});
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
    
    Route::get('/datatable', function () {
        return view('layout50.examples.datatable');
    })->name('.datatable');
});