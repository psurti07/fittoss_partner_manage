<?php

use Illuminate\Support\Facades\Route;
use Modules\BirthDay\Http\Controllers\BirthDayController;

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
    Route::get('/birthday-list', [BirthDayController::class, 'index'])->name('birthday-list.index');
    Route::get('employee-show/{id}', [BirthDayController::class, 'show'])->name('employee.show');
});
