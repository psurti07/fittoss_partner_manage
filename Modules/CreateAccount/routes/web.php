<?php

use Illuminate\Support\Facades\Route;
use Modules\CreateAccount\App\Http\Controllers\CreateAccountController;

Route::group([
    'prefix' => 'customers',
    'as' => 'manage.',
    'middleware' => ['auth', 'PreventBackHistory']
], function () {
    Route::get('create-customer', [CreateAccountController::class, 'create'])->name('customers.create');
    Route::post('create-customer', [CreateAccountController::class, 'store'])->name('customers.store');
    Route::post('postal-details', [CreateAccountController::class, 'getPostalDetails'])->name('postal.details');
});
