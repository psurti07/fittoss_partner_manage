<?php

use Illuminate\Support\Facades\Route;
use Modules\Partner\App\Http\Controllers\PartnerController;

Route::group([
    'prefix' => 'partner',
    'as' => 'manage.partner.',
    'middleware' => ['auth', 'PreventBackHistory']
], function () {
    Route::get('', [PartnerController::class, 'index'])->name('index');
    Route::get('create', [PartnerController::class, 'create'])->name('create');
    Route::post('store', [PartnerController::class, 'store'])->name('store');
    Route::get('{id}', [PartnerController::class, 'details'])->name('details');
    Route::post('company-info/update', [PartnerController::class, 'updateCompany'])->name('companyinfo.update');
    Route::post('personal-info/update', [PartnerController::class, 'updatePersonal'])->name('personalinfo.update');
    Route::post('social-info/update', [PartnerController::class, 'updateCompanySocial'])->name('socialinfo.update');
    Route::post('update-password', [PartnerController::class, 'updatePassword'])->name('update.password');
    Route::post('account/deactivate', [PartnerController::class, 'deactivateAccount'])->name('account.deactivate');
    Route::post('account/delete', [PartnerController::class, 'destroy'])->name('account.delete');
});

// Partner/Staff
Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth', 'PreventBackHistory']
], function () {
    Route::get('profile', [PartnerController::class, 'partnerDetail'])->name('profile.detail');
    Route::post('profile/update', [PartnerController::class, 'updatePartnerDetail'])->name('profile.update');
});
