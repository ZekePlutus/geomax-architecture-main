<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

Route::get('/locale/{locale}', function ($locale) {
    $supported = config('app.supported_locales', []);
    $locale = Str::lower($locale);

    if (! in_array($locale, $supported, true)) {
        $locale = config('app.fallback_locale');
    }

    session(['locale' => $locale]);
    return redirect()->back() ?: redirect()->to('/');
})->name('set-locale');

