<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/users', [UsersController::class, 'index'])->name('users');
Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
/*
Route::prefix('/users')
    ->controller(UsersController::class)
    ->group(function () {
        Route::get('/', 'index')->name('users');
        Route::get('/create', 'create')->name('users.create');
        Route::post('/store', 'store')->name('users.store');
        Route::get('/{user}', 'view')->name('users.view');
        Route::update('/{user}', 'update')->name('users.update');
        Route::delete('/{user}', 'delete')->name('users.delete');
    });

Route::prefix('/products')
    ->controller(UsersController::class)
    ->group(function () {
        Route::get('/', 'index')->name('products.index');
        Route::get('/', 'create')->name('products.create');
        Route::get('/{product}', 'view')->name('products.view');
        Route::get('/{product}', 'update')->name('products.update');
        Route::get('/{product}', 'delete')->name('products.delete');
    });
*/
