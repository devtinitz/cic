<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartementController;

/*
|--------------------------------------------------------------------------
| departements Routes
|--------------------------------------------------------------------------
|
*/

Route::controller(DepartementController::class)->prefix('departements')->group(function (){
    Route::get('/index', 'index')->name('departements.index')->middleware(['departement:lst']);
    Route::get('/create', 'create')->name('departements.create')->middleware(['departement:crte']);
    Route::post('/store', 'store')->name('departements.store')->middleware(['departement:crte']);
    Route::get('/show/{id}', 'show')->name('departements.show');
    Route::get('/edit/{id}', 'edit')->name('departements.edit')->middleware(['departement:edt']);
    Route::post('/update', 'update')->name('departements.update')->middleware(['departement:edt']);
    Route::get('/destroy/{id}', 'destroy')->name('departements.delete')->middleware(['departement:dlt']);
    Route::get('/search', 'search')->name('departements.search')->middleware(['departement:lst']);
    Route::get('/{id}/presences', 'presenceRecap')->name('departements.presence.recap')->middleware(['departement:lst']);
    Route::get('/change-status/{id}', 'editState')->name('departements.editState');

    //Routes of services
    Route::controller(DepartementController::class)->prefix('services')->group(function (){
        Route::get('/', 'indexService')->name('services.index');
        Route::get('/create', 'createService')->name('services.create');
        Route::post('/', 'storeService')->name('services.store');
        Route::get('/edit/{id}', 'editService')->name('services.edit');
        Route::post('/update', 'updateService')->name('services.update');
        Route::get('/delete/{id}', 'destroyService')->name('services.delete');
        Route::get('/change-status/{id}', 'editStateService')->name('services.editState');
        Route::post('getService', 'getService')->name('getServiceDepartement');
    });
});

