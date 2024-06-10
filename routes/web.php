<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\DashboardController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/profile', [ProfileController::class, 'index']);
Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');



Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->middleware('guest')->name('login');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout')->middleware('auth');
    Route::get('/register', 'register')->middleware('guest');
    Route::post('/register', 'register')->middleware('guest')->name('register');
});

Route::get('/panel', [DashboardController::class, 'index'])->middleware('admin');
Route::get('/report', [ReportController::class, 'index'])->middleware('superadmin');
Route::get('/report/export', [ReportController::class, 'export'])->middleware('superadmin');
Route::resource('/products', ProductsController::class)->middleware('auth');
Route::resource('/people', PeopleController::class)->middleware('superadmin');

Route::get('/orders/trash', [OrdersController::class, 'trash'])->name('orders.trash')->middleware('superadmin');
Route::delete('/orders/force/{order:code}', [OrdersController::class, 'force'])->withTrashed()->name('orders.force')->middleware('superadmin');
Route::get('/orders/restore/{order:code}', [OrdersController::class, 'restore'])->withTrashed()->name('orders.restore')->middleware('superadmin');
Route::resource('/orders', OrdersController::class)->withTrashed()->middleware('auth');

Route::resource('/users', UsersController::class)->middleware('auth');
Route::controller(MidtransController::class)->group(function () {
    Route::get('/midtrans/pay', 'index');
    Route::get('/midtrans/success/{id}', 'success');
});

Route::middleware('auth')->group(function () {
    Route::get('/products/trash', [ProductController::class, 'recycle'])->name('products.trash');
    Route::patch('/products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
});
