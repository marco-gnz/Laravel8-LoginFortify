<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::post('/home/rut', [HomeController::class, 'create_rut']);

Route::get('/{optional?}', function () {
    return view('app');
})->name('basepath')
->where('optional','.*');

