<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PresenceController;

Route::controller(PresenceController::class)->prefix('presences')->group(function (){
    //Route::get('/pointages', 'index')->name('presences.index')->middleware(['presence:edt'])
    Route::get('/', 'pointage')->name('presences.index')->middleware(['presence:edt']);
    Route::get('/index', 'presence')->name('presences.liste');
    Route::get('/pointages/search', 'search')->name('presences.search');
    Route::get('/search', 'searchPresence')->name('presences.search.alt');
    Route::post('/import', 'import')->name('presences.import');
    Route::get('/export-pdf', 'exportToPdf')->name('presences.pdf');
});