<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgenceController;

Route::controller(AgenceController::class)->prefix('agences')->group(function (){
    Route::get('/index', 'index')->name('agences.index');
    Route::get('/create', 'create')->name('agences.create');
    Route::post('/store', 'store')->name('agences.store');
    Route::get('/edit/{id}', 'edit')->name('agences.edit');
    Route::post('/update', 'update')->name('agences.update');
    Route::get('/delete/{id}', 'destroy')->name('agences.delete');
    Route::get('/show/{id}', 'show')->name('agences.show');
    Route::get('/change-status/{id}', 'editState')->name('agences.editState');
});