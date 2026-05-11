<?php

use Illuminate\Support\Facades\Route;
use Modules\SupportRequest\App\Http\Controllers\SupportRequestController;

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
    Route::resource('supportrequest', SupportRequestController::class)->names('supportrequest');
});

Route::post('/supportrequest/add-remark', [SupportRequestController::class, 'storeRemark'])->name('supportrequest.add-remark');
Route::post('/supportrequest/change-status', [SupportRequestController::class, 'changeSupportStatus'])->name('supportrequest.change-status');
