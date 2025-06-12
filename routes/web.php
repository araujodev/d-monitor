<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

Livewire::setScriptRoute(function ($handle) {
    $base = env('LIVEWIRE_BASE_PATH');
    return Route::post(
        is_null($base) ? null : rtrim($base, '/') . '/livewire.js',
        $handle
    );
});

Livewire::setUpdateRoute(function ($handle) {
    $base = env('LIVEWIRE_BASE_PATH');
    return Route::post(
        is_null($base) ? null : rtrim($base, '/') . '/update',
        $handle
    );
});

Route::get('/', function () {
    return view('welcome');
});


