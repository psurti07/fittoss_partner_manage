<?php

use Illuminate\Support\Facades\Route;
use Modules\Career\App\Http\Controllers\CareerController;

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
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth'],
], function () {
    Route::resource('career', CareerController::class)->names('career');
});

Route::post('/change-career-status', [CareerController::class, 'changeStatus'])->name('career.changeStatus');
