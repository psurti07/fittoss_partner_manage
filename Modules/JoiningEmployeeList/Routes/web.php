<?php

use Illuminate\Support\Facades\Route;
use Modules\JoiningEmployeeList\Http\Controllers\JoiningEmployeeListController;

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
    Route::get('/joining-list', [JoiningEmployeeListController::class, 'index'])->name('joining-list.index');
    Route::get('employee-show/{id}', [JoiningEmployeeListController::class, 'show'])->name('employee.show');
});