<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\App\Http\Controllers\AuthController;

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
    'middleware' => ['guest', 'PreventBackHistory'],
], function () {
    Route::get('/', [AuthController::class, 'index'])->name('auth');
    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
});

Route::get('test', [AuthController::class, 'test'])->name('test');
