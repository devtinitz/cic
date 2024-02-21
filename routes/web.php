<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Setup\SetupController;
use App\Http\Controllers\Setup\AccountController;
use App\Http\Controllers\Setup\ConfigurationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes(['register' => false]);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('install')->group(function(){
    Route::get('/start', [SetupController::class, 'index'])->name('install.index');
    Route::get('requirements', [SetupController::class, 'requirements'])->name('install.requirements');
    Route::get('database', [SetupController::class, 'database'])->name('install.database');
    Route::post('database_test_connexion', [SetupController::class, 'database_test_connexion'])->name('install.database.testconnexion');
    Route::post('database', [SetupController::class, 'databaseSubmit'])->name('install.database.submit');
    Route::get('account', [AccountController::class, 'account'])->name('install.account');
    Route::post('account-submit', [AccountController::class, 'accountSubmit'])->name('install.account.submit');
    Route::get('configuration', [ConfigurationController::class, 'setting'])->name('install.configuration');
    Route::post('configuration-submit', [ConfigurationController::class, 'configurationSubmit'])->name('install.configuration.submit');
    Route::get('complete', [SetupController::class, 'setupComplete'])->name('install.complete');
});