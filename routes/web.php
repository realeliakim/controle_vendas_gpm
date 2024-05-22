<?php

use App\Http\Controllers\ProductsController;
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
Route::post('/users', [UsersController::class, 'create'])->name('users.create');
Route::get('/users/{user}', [UsersController::class, 'view'])->name('users.view');
Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UsersController::class, 'delete'])->name('users.delete');

Route::get('/products', [ProductsController::class, 'index'])->name('products');
Route::get('/products/product_form', [ProductsController::class, 'showCreateForm'])->name('products.product_form');
Route::post('/products', [ProductsController::class, 'create'])->name('products.create');
Route::get('/products/{product}', [ProductsController::class, 'view'])->name('products.view');
Route::put('/products/{product}', [ProductsController::class, 'update'])->name('products.update');
Route::delete('/products/{products}', [ProductsController::class, 'delete'])->name('products.delete');
/*
Route::get('/users/user_form', [UsersController::class, 'showCreateForm'])->name('users.user_form');
Route::post('/users/create', [UsersController::class, 'create'])->name('users.create');
Route::get('/users/view/{user}', [UsersController::class, 'view'])->name('users.view');
Route::put('/users/update/{user}', [UsersController::class, 'update'])->name('users.update');
Route::delete('/users/delete/{user}', [UsersController::class, 'delete'])->name('users.delete');


/*

Route::prefix('/users')
    ->controller(UsersController::class)
    ->group(function () {
        Route::get('/', 'index')->name('users');
        Route::get('/user_form', 'showCreateForm')->name('users.user_form');
        Route::post('/create', 'create')->name('users.create');
        Route::get('/view/{user}', 'view')->name('users.view');
        Route::update('/update/{user}', 'update')->name('users.update');
        Route::delete('/delete/{user}', 'delete')->name('users.delete');
    });

Route::prefix('/products')
    ->controller(ProductsController::class)
    ->group(function () {
        Route::get('/', 'index')->name('products.index');
        Route::get('/product_form', 'showCreateForm')->name('products.product_form');
        Route::get('/create', 'create')->name('products.create');
        Route::get('/view/{product}', 'view')->name('products.view');
        Route::update('/update/{product}', 'update')->name('products.update');
        Route::delete('/delete/{product}', 'delete')->name('products.delete');
    });

*/
