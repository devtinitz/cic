<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiegeController;

Route::controller(SiegeController::class)->prefix('sieges')->group(function (){
    Route::get('/index', 'index')->name('sieges.index');
    Route::get('/create', 'create')->name('sieges.create');
    Route::post('/store', 'store')->name('sieges.store');
    Route::get('/edit/{id}', 'edit')->name('sieges.edit');
    Route::post('/update', 'update')->name('sieges.update');
    Route::get('/delete/{id}', 'destroy')->name('sieges.delete');
    Route::get('/show/{id}', 'show')->name('sieges.show');
    Route::post('/horaires-store', 'storeHoraire')->name('sieges.storeHoraire');
    Route::get('/change-status/{id}', 'editState')->name('sieges.editState');

    //Routes of types preavis
    Route::controller(SiegeController::class)->prefix('types-preavis')->group(function (){
        Route::get('/', 'indexPreavis')->name('typepreavis.index');
        Route::get('/create', 'createPreavis')->name('typepreavis.create');
        Route::post('/', 'storePreavis')->name('typepreavis.store');
        Route::get('/edit/{id}', 'editPreavis')->name('typepreavis.edit');
        Route::post('/update', 'updatePreavis')->name('typepreavis.update');
        Route::get('/delete/{id}', 'destroyPreavis')->name('typepreavis.delete');
        Route::get('/change-status/{id}', 'editStatePreavis')->name('typepreavis.editState');
    });

    //Routes of types conges
    Route::controller(SiegeController::class)->prefix('types-conges')->group(function (){
        Route::get('/', 'indexConge')->name('typeconges.index');
        Route::get('/create', 'createConge')->name('typeconges.create');
        Route::post('/', 'storeConge')->name('typeconges.store');
        Route::get('/edit/{id}', 'editConge')->name('typeconges.edit');
        Route::post('/update', 'updateConge')->name('typeconges.update');
        Route::get('/delete/{id}', 'destroyConge')->name('typeconges.delete');
        Route::get('/change-status/{id}', 'editStateConge')->name('typeconges.editState');
    });


});