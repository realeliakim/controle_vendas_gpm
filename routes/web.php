<?php

use App\Http\Controllers\SectionsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserTypesController;
use App\Models\Section;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
/*
Route::prefix('/users')
    ->controller(UsersController::class)
    ->group(function () {
        Route::get('/', 'index')->name('users');
        Route::get('/user_form', 'showCreateForm')->name('users.user_form');
        Route::post('/create', 'create')->name('users.create');
        //Route::get('/{user}', 'view')->name('users.view');
        //Route::update('/{user}', 'update')->name('users.update');
        Route::delete('/{user}', 'delete')->name('users.delete');
    });
*/
Route::prefix('/user_types')
    ->controller(UserTypesController::class)
    ->group(function () {
        Route::get('/', 'index')->name('types');
    });

Route::prefix('/sections')
    ->controller(SectionsController::class)
    ->group(function () {
        Route::get('/', 'index')->name('sections');
    });

Route::get('/users', [UsersController::class, 'index'])->name('users');
Route::get('/users/user_form', [UsersController::class, 'showCreateForm'])->name('users.user_form');
Route::post('/users/create', [UsersController::class, 'create'])->name('users.create');
Route::get('/users/view/{user}', [UsersController::class, 'create'])->name('users.view');
Route::put('/users/update/{user}', [UsersController::class, 'create'])->name('users.update');
Route::delete('/users/delete/{user}', [UsersController::class, 'create'])->name('users.delete');
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
