<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\UserTypesController;
use App\Http\Controllers\StockReportsController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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

Route::prefix('/users')
    ->controller(UsersController::class)
    ->group(function () {
        Route::get('/', 'index')->name('users');
        Route::get('/user_form', 'showCreateForm')->name('users.user_form');
        Route::post('/', 'create')->name('users.create');
        Route::get('/{user}', 'view')->name('users.view');
        Route::put('/{user}', 'update')->name('users.update');
        Route::delete('/{user}', 'delete')->name('users.delete');
    });

Route::prefix('/products')
    ->controller(ProductsController::class)
    ->group(function () {
        Route::get('/', 'index')->name('products');
        Route::get('/product_form', 'showCreateForm')->name('products.product_form');
        Route::post('/', 'create')->name('products.create');
        Route::get('/{product}', 'view')->name('products.view');
        Route::put('/{product}', 'update')->name('products.update');
        Route::delete('/{product}', 'delete')->name('products.delete');
    });

Route::prefix('/orders')
    ->controller(OrdersController::class)
    ->group(function (){
        Route::get('/', 'index')->name('orders');
        Route::post('/', 'create')->name('orders.create');
        Route::post('/get_orders', 'getOrders')->name('orders.get_orders');
        Route::get('/show_store', 'showStore')->name('orders.show_store');
        Route::get('/{order}', 'view')->name('orders.view');
        Route::delete('/{order}', 'delete')->name('orders.delete');
    });

Route::prefix('/reports')
    ->controller(StockReportsController::class)
    ->group(function () {
        Route::get('/', 'index')->name('reports');
    });
