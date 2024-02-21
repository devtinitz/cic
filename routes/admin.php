<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingsController;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/settings', [SettingsController::class, 'index'])->name('settings')->middleware(['setting:edt']);
Route::post('/settings/update', [SettingsController::class, 'updatesettings'])->name('settings.updatesettings')->middleware(['setting:edt']);
Route::get('/logs', [HomeController::class, 'logs'])->name('logs')->middleware(['setting:edt']);
Route::get('/logs/search', [HomeController::class, 'logSearch'])->name('logs.search')->middleware(['setting:edt']);
