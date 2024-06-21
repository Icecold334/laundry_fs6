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
use App\Http\Controllers\NotificationController;

// landing page controller
Route::get('/', [HomeController::class, 'index']);
// profile page controller
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index')->middleware('auth');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->middleware('auth');
Route::get('/profile/password', [ProfileController::class, 'password'])->middleware('auth');
Route::put('/profile/password', [ProfileController::class, 'updatepass'])->middleware('auth');
Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
// auth controller
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->middleware('guest')->name('login');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout')->middleware('auth');
    Route::get('/register', 'register')->middleware('guest');
    Route::post('/register', 'register')->middleware('guest')->name('register');
    Route::get('/auth/google', 'redirectToGoogle');
    Route::get('/auth/google/callback', 'GoogleCallback');
});
// dashboard controller
Route::get('/panel', [DashboardController::class, 'index'])->middleware('admin');
// report controller
Route::get('/report', [ReportController::class, 'index'])->middleware('superadmin');
Route::get('/report/export', [ReportController::class, 'export'])->middleware('superadmin');
// product controller
Route::get('/products/trash', [ProductsController::class, 'trash'])->name('products.trash')->middleware('superadmin');
Route::delete('/products/{product}/force/', [ProductsController::class, 'force'])->withTrashed()->name('products.force')->middleware('superadmin');
Route::get('/products/{product}/restore/', [ProductsController::class, 'restore'])->withTrashed()->name('products.restore')->middleware('superadmin');
Route::resource('/products', ProductsController::class)->withTrashed()->middleware('auth');
// people controller

Route::get('/people/trash', [PeopleController::class, 'trash'])->name('people.trash')->middleware('superadmin');
Route::delete('/people/force/{person}', [PeopleController::class, 'force'])->withTrashed()->name('people.force')->middleware('superadmin');
Route::get('/people/restore/{person}', [PeopleController::class, 'restore'])->withTrashed()->name('people.restore')->middleware('superadmin');
Route::resource('/people', PeopleController::class)->withTrashed()->middleware('superadmin');
// order controller
Route::get('/orders/trash', [OrdersController::class, 'trash'])->name('orders.trash')->middleware('superadmin');
Route::delete('/orders/force/{order:code}', [OrdersController::class, 'force'])->withTrashed()->name('orders.force')->middleware('superadmin');
Route::get('/orders/restore/{order:code}', [OrdersController::class, 'restore'])->withTrashed()->name('orders.restore')->middleware('superadmin');
Route::resource('/orders', OrdersController::class)->withTrashed()->middleware('auth');

Route::get('/users/trash', [UsersController::class, 'trash'])->name('users.trash')->middleware('superadmin');
Route::delete('/users/force/{user}', [UsersController::class, 'force'])->withTrashed()->name('users.force')->middleware('superadmin');
Route::get('/users/restore/{user}', [UsersController::class, 'restore'])->withTrashed()->name('users.restore')->middleware('superadmin');
Route::resource('/users', UsersController::class)->withTrashed()->middleware('auth');

// notifications controller
Route::get('/notification/delete/{user_id}/{id}', [NotificationController::class, 'delete']);

// midtrans controller
Route::controller(MidtransController::class)->group(function () {
    Route::get('/midtrans/pay', 'index');
    Route::get('/midtrans/success/{id}', 'success');
});
