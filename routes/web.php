<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/components', 'components-gallery')->name('components');

Route::middleware('auth')->group(function (): void {
    Route::view('/dashboard', 'app.dashboard')->name('dashboard');
    Route::view('/schedule', 'app.schedule')->name('schedule');
    Route::view('/files', 'app.files')->name('files');
    Route::view('/team', 'app.team')->name('team');
    Route::view('/settings', 'app.settings')->name('settings');
});
