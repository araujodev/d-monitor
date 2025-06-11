<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

\Livewire\Livewire::setScriptRoute(function($handle) {
    return Route::get(config('app.assetUrl') . '/livewire/livewire.js', $handle);
});

\Livewire\Livewire::setUpdateRoute(function($handle) {
    return Route::get(config('app.assetUrl') . '/livewire/update', $handle);
});
