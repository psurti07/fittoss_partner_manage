<?php

use Illuminate\Support\Facades\Route;
use Modules\HolidayList\Http\Controllers\HolidayListController;

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
    Route::get('/holiday-list', [HolidayListController::class, 'index'])->name('holiday-list.index');
    Route::get('/holiday-list-create', [HolidayListController::class, 'create'])->name('holiday-list.create');
    Route::post('/holiday-list-create-store', [HolidayListController::class, 'store'])->name('holiday-list.save');
    Route::get('/holiday-list/{id}', [HolidayListController::class, 'show'])->name('holiday-list.show');
    Route::get('/holiday-list-edit/{id}', [HolidayListController::class, 'edit'])->name('holiday-list.edit');
    Route::post('/holiday-list-update/{id}', [HolidayListController::class, 'update'])->name('holiday-list.update');
    Route::post('/holiday-list-destroy/{id}', [HolidayListController::class, 'destroy'])->name('holiday-list.delete');
});
