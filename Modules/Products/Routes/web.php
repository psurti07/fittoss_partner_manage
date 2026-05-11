<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Modules\Products\Http\Controllers\ProductsController;

Route::group([
    'prefix' => 'products',
    'as' => 'manage.products.',
    'middleware' => ['auth', 'PreventBackHistory']
], function () {
    Route::get('/', [ProductsController::class, 'index'])->name('index');
    Route::get('/{product}/edit', [ProductsController::class, 'edit'])->name('edit');
    Route::post('update/{product}', [ProductsController::class, 'update'])->name('update');
    Route::post('price-update', [ProductsController::class, 'priceUpdate'])->name('price.update');
});
