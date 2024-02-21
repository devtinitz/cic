<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EspaceController;

/*
|--------------------------------------------------------------------------
| ESPACE UTILISATEURS Routes
|--------------------------------------------------------------------------
|
*/

Route::prefix('espaces')->group(function () {
    Route::get('/',[EspaceController::class,'index'])->name('espaces.index')->middleware(['espace:lst']);
    Route::get('/create',[EspaceController::class,'create'])->name('espaces.create')->middleware(['espace:crte']);
    Route::post('/store',[EspaceController::class,'store'])->name('espaces.store')->middleware(['espace:crte']);
    Route::get('/edit/{id}',[EspaceController::class,'edit'])->name('espaces.edit')->middleware(['espace:edt']);
    Route::post('/update',[EspaceController::class,'update'])->name('espaces.update')->middleware(['espace:edt']);
    Route::get('/delete/{id}',[EspaceController::class,'destroy'])->name('espaces.delete')->middleware(['espace:dlt']);
    Route::get('/show/{id}',[EspaceController::class,'show'])->name('espaces.show');
    Route::get('/default/{id}',[EspaceController::class,'parDefaut'])->name('espaces.parDefaut')->middleware(['espace:edt']);
});