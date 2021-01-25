<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

//rutas login google

Route::get('/auth/{driver}', [LoginController::class, 'redirectToProvider']);

Route::get('/auth/{driver}/callback', [LoginController::class, 'handleProviderCallback']);


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::post('/home/rut', [HomeController::class, 'create_rut']);

/* Route::get('/{optional?}', function () {
    return view('welcome');
})->name('basepath')
->where('optional','.*'); */

