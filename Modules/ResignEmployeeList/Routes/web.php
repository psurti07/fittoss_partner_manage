<?php

use Illuminate\Support\Facades\Route;
use Modules\ResignEmployeeList\Http\Controllers\ResignEmployeeListController;

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

Route::group([
    'prefix' => '/',
    'as' => 'manage.',
    'middleware' => ['auth', 'PreventBackHistory']
], function () {
    Route::get('/resigning-list', [ResignEmployeeListController::class, 'index'])->name('resigning-list.index');
    Route::get('employee-show/{id}', [ResignEmployeeListController::class, 'show'])->name('employee.show');
});