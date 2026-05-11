<?php

use Illuminate\Support\Facades\Route;
use Modules\SMS\App\Http\Controllers\SMSController;

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
    'prefix' => 'sms/',
    'as' => 'manage.sms.',
    'middleware' => ['auth', 'PreventBackHistory']
], function () {
    Route::get('sms-message', [SMSController::class, 'smsMessage'])->name('smsmessage');
    Route::get('send-custom-sms', [SMSController::class, 'sendCustomSms'])->name('send.custom.sms');

    Route::post('/smslist-toggle-status/{id}', [SMSController::class, 'toggleStatus'])->name('smslist.toggleStatus');
    Route::get('sms-message-edit/{id}', [SMSController::class, 'editSmsMessage'])->name('smsmessage.editSmsMessage');
    Route::post('sms-message-update/{id}', [SMSController::class, 'updateSmsMessage'])->name('smsmessage.updateSmsMessage');

    Route::get('send-test-sms', [SMSController::class, 'testSms'])->name('send.test.sms');
    Route::post('get-message', [SMSController::class, 'getMessage'])->name('get.title.message');
    Route::post('fire-sms', [SMSController::class, 'fireSms'])->name('fire.sms');
});
