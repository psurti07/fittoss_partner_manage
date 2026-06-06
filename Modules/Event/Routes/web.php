<?php

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

use Illuminate\Support\Facades\Route;
use Modules\Event\Http\Controllers\CustomersController;
use Modules\Event\Http\Controllers\EventController;
use Modules\Event\Http\Controllers\LeadsController;

Route::group([
    'prefix' => 'events',
    'as' => 'manage.events.',
    'middleware' => ['auth', 'PreventBackHistory']
], function () {
    Route::get('/', [EventController::class, 'index'])->name('index');
    // Route::get('create', [EventController::class, 'create'])->name('create');
    // Route::post('store', [EventController::class, 'store'])->name('store');
    // Route::get('edit/{event}', [EventController::class, 'edit'])->name('edit');
    // Route::post('update/{event}', [EventController::class, 'update'])->name('update');
    // Route::delete('delete/{event}', [EventController::class, 'destroy'])->name('destroy');
    // Route::post('price-update', [EventController::class, 'priceUpdate'])->name('price.update');

    Route::get('leads', [LeadsController::class, 'leads'])->name('leads');
    Route::get('customers', [CustomersController::class, 'customers'])->name('customers');

    Route::group(['prefix' => 'leads', 'as' => 'leads.'], function () {
        Route::post('info', [LeadsController::class, 'info'])->name('info');
        Route::post('block-user', [LeadsController::class, 'blockUser'])->name('block.user');
        Route::post('dnd-user', [LeadsController::class, 'dndUser'])->name('dnd.user');
        Route::post('delete-user', [LeadsController::class, 'destroyUser'])->name('destroy.user');
        Route::post('convert-customer', [LeadsController::class, 'convertCustomer'])->name('convertcustomer');
    });

    Route::group(['prefix' => 'customers', 'as' => 'customers.'], function () {
        Route::get('{userId}', [CustomersController::class, 'usersDetails'])->name('details');
        Route::post('update', [CustomersController::class, 'usersDetailsUpdate'])->name('update');
        Route::get('/invoice/{id}/pdf', [CustomersController::class, 'downloadPdf'])->name('invoice.pdf');

        Route::post('update-password', [CustomersController::class, 'updatePassword'])->name('update.password');
        Route::post('deactivate-account', [CustomersController::class, 'deactivateAccount'])->name('deactivate.account');
        Route::post('delete-account', [CustomersController::class, 'deleteAccount'])->name('delete.account');

        Route::post('attended', [CustomersController::class, 'markAsAttended'])->name('attended');
        Route::post('enrolled', [CustomersController::class, 'enrollUser'])->name('enrolled');
    });
});
