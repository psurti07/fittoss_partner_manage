<?php

use Illuminate\Support\Facades\Route;
use Modules\PaymentLog\App\Http\Controllers\PaymentLogController;

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
    // 'prefix' => 'payment',
    'as' => 'manage.',
    'middleware' => ['auth', 'PreventBackHistory']
], function () {
    Route::get('payu-log', [PaymentLogController::class, 'index'])->name('payu-log');
    Route::get('sabpaisa-log', [PaymentLogController::class, 'index'])->name('sabpaisa-log');
    Route::get('paytm-log', [PaymentLogController::class, 'index'])->name('paytm-log');
    Route::get('phonepay-log', [PaymentLogController::class, 'index'])->name('phonepay-log');
    Route::get('vegaah-log', [PaymentLogController::class, 'index'])->name('vegaah-log');
    Route::get('paygic-log', [PaymentLogController::class, 'index'])->name('paygic-log');

    Route::get('cipherpay-log', [PaymentLogController::class, 'index'])->name('cipherpaylog');
    Route::get('lyra-log', [PaymentLogController::class, 'index'])->name('lyralog');
    Route::get('zaakpay-log', [PaymentLogController::class, 'index'])->name('zaakpaylog');
});
