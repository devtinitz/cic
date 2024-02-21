<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;



/*

|--------------------------------------------------------------------------

| UTILISATEURS Routes

|--------------------------------------------------------------------------

|

*/





Route::prefix('users')->group(function () {

    Route::get('/index',[UserController::class,'index'])->name('users.index')->middleware(['user:lst']);
    Route::get('/create',[UserController::class,'create'])->name('users.create')->middleware(['user:crte']);
    Route::post('/store',[UserController::class,'store'])->name('users.store')->middleware(['user:crte']);
    Route::get('/edit/{id}',[UserController::class,'edit'])->name('users.edit')->middleware(['user:edt']);
    Route::post('/update',[UserController::class,'update'])->name('users.update')->middleware(['user:edt']);
    Route::get('/delete/{id}',[UserController::class,'destroy'])->name('users.delete')->middleware(['user:dlt']);
    Route::get('/show/{id}',[UserController::class,'show'])->name('users.show')->middleware(['user:lst']);
    Route::get('/state/{id}',[UserController::class,'editstate'])->name('users.editstate')->middleware(['user:lst']);
    Route::get('/profile',[UserController::class,'monprofil'])->name('users.profile');
    Route::post('/profile/store',[UserController::class,'updateProfile'])->name('users.profile.store');
    Route::get('/password',[UserController::class,'monpassword'])->name('users.password');
    Route::post('/pass/store',[UserController::class,'updatePassword'])->name('users.password.store');

	

});







