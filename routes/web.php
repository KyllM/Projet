<?php

use App\Http\Controllers\connexionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\sauceController;
use App\Http\Controllers\inscriptionController;
use App\Http\Controllers\CreateSauceController;
use App\Models\sauce;


Route::get('/', function () {
    return view('welcome');
});

Route::get('sauce/{id}', [sauceController::class, 'voir'])->name('sauce.voir');

Route::get('sauce', [sauceController::class, 'index'])->name('sauce');


Route::get('register', [inscriptionController::class, 'register'])->name('register');

Route::post('nouveauUser', [inscriptionController::class, 'nouveauUser'])->name('nouveauUser');

Route::get('login', [connexionController::class, 'login'])->name('login');

Route::post('authenticate', [connexionController::class, 'authenticate'])    ->name('authenticate');

Route::get('logout', [connexionController::class, 'logout'])->name('logout');


Route::get('creerUneSauce', [sauceController::class, 'creerUneSauce'])->name('creerUneSauce');

Route::post('ajoutSauce', [sauceController::class, 'ajoutSauce'])->name('ajoutSauce');

Route::get('likeSauce/{id}', [sauceController::class, 'likeSauce'])->name('likeSauce');

Route::get('dislikeSauce/{id}', [sauceController::class, 'dislikeSauce'])->name('dislikeSauce');


Route::get('deleteSauce/{id}', [sauceController::class, 'deleteSauce'])->name('deleteSauce');

Route::post('editSauce/{id}', [sauceController::class, 'editSauce'])->name('editSauce');
