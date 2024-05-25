<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FuncController;
use App\Http\Controllers\PeopleController;

Route::get('/', function () {
    return view('welcome');
});
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->middleware('guest')->name('login');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout')->middleware('auth');
    Route::get('/register', 'register')->middleware('guest');
    Route::post('/register', 'register')->middleware('guest')->name('register');
});

Route::get('/panel', [DashboardController::class, 'index'])->middleware('auth');
Route::resource('/products', ProductsController::class)->middleware('auth');
Route::resource('/people', PeopleController::class)->middleware('auth');
