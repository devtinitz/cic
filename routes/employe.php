<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeController;

/*
|--------------------------------------------------------------------------
| Employes Routes
|--------------------------------------------------------------------------
|
*/

Route::controller(EmployeController::class)->prefix('employes')->group(function (){

   Route::get('/index', 'index')->name('employes.index')->middleware(['employe:lst']);
   Route::get('/create', 'create')->name('employes.create')->middleware(['employe:crte']);
   Route::post('/store', 'store')->name('employes.store')->middleware(['employe:crte']);
   Route::get('/edit/{id}', 'edit')->name('employes.edit')->middleware(['employe:edt']);
   Route::post('/update', 'update')->name('employes.update')->middleware(['employe:edt']);
   Route::get('/destroy/{id}', 'destroy')->name('employes.delete')->middleware(['employe:dlt']);
   Route::get('/search', 'search')->name('employes.search')->middleware(['employe:lst']);
   Route::get('/{id}/presences', 'presenceRecap')->name('employes.presence.recap')->middleware(['employe:lst']);
   Route::post('/import', 'importEmploye')->name('employes.import')->middleware(['employe:crte']);

});

