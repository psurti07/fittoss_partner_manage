<?php

use Illuminate\Support\Facades\Route;
use Modules\Disease\App\Http\Controllers\DiseaseController;

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
    Route::resource('disease', DiseaseController::class)->names('disease');
});
