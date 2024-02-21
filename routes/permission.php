<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;

Route::controller(PermissionController::class)->prefix('permissions')->group(function (){
    Route::name('permissions.')->group(function(){
        Route::get('/index', 'index')->name('index')->middleware(['permission:lst']);
        Route::get('/create', 'created')->name('create')->middleware(['permission:crte']);
        Route::post('/store', 'store')->name('store')->middleware(['permission:crte']);
        Route::get('/show/{id}', 'showPdf')->name('show')->middleware(['permission:lst']);
        Route::get('/edit/{id}', 'edit')->name('edit')->middleware(['permission:edt']);
        Route::post('/update', 'update')->name('update')->middleware(['permission:edt']);
        Route::get('/delete/{id}', 'destroy')->name('delete')->middleware(['permission:dlt']);
        Route::get('/change-satus/{id}/{type}', 'changeStatus')->name('change.status')->middleware(['permission:edt']);
        Route::get('/search', 'search')->name('search')->middleware(['permission:lst']);
    });
});