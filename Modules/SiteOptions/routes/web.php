<?php

use Illuminate\Support\Facades\Route;
use Modules\SiteOptions\App\Http\Controllers\FacebookSettingController;
use Modules\SiteOptions\App\Http\Controllers\SiteOptionsController;
use Modules\SiteOptions\App\Http\Controllers\SMSSettingController;
use Modules\SiteOptions\App\Http\Controllers\WhatsappSettingController;

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
    'middleware' => ['auth', 'PreventBackHistory']
], function () {
    Route::get('/welcome-message', [SiteOptionsController::class, 'welcomeMessage'])->name('welcome-message');
    Route::post('/welcome-message/update', [SiteOptionsController::class, 'welcomeMessageUpdate'])->name('welcome-message.update');

    Route::get('/account-message', [SiteOptionsController::class, 'accountMessage'])->name('account-message');
    Route::post('/account-message/selfapply-message', [SiteOptionsController::class, 'accountMessageUpdate'])->name('account.message.selfapply.update');
    Route::post('/account-message/loanagent-message', [SiteOptionsController::class, 'accountMessageUpdate'])->name('account.message.loanagent.update');

    Route::group(['prefix' => 'facebook-setting', 'as' => 'facebook-setting.'], function () {
        Route::get('/', [FacebookSettingController::class, 'index'])->name('index');
        Route::post('/', [FacebookSettingController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'whatsapp-setting', 'as' => 'whatsapp-setting.'], function () {
        Route::get('/', [WhatsappSettingController::class, 'index'])->name('index');
        Route::post('/', [WhatsappSettingController::class, 'update'])->name('update');
    });
    
    Route::group(['prefix' => 'sms-setting', 'as' => 'sms-setting.'], function () {
        Route::get('/', [SMSSettingController::class, 'index'])->name('index');
        Route::post('/', [SMSSettingController::class, 'update'])->name('update');
    });

    Route::get('/sms-settings', [SiteOptionsController::class, 'smsSettings'])->name('sms.settings');
    Route::post('/sms-settings-update', [SiteOptionsController::class, 'smsSettingsUpdate'])->name('sms.settings.update');
});
