<?php

use Illuminate\Support\Facades\Route;
use Modules\ProgramUsers\App\Http\Controllers\BFAWorkshopController;
use Modules\ProgramUsers\App\Http\Controllers\WLPCustomersController;
use Modules\ProgramUsers\App\Http\Controllers\WLPLeadsController;
use Modules\ProgramUsers\App\Http\Controllers\CustomersController;
use Modules\ProgramUsers\App\Http\Controllers\LeadsController;
use Modules\ProgramUsers\App\Http\Controllers\WLWebinarController;

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
    'prefix' => 'wlp',
    'as' => 'manage.weight-loss-program.',
    'middleware' => ['auth'],
], function () {
    Route::get('leads', [WLPLeadsController::class, 'leads'])->name('leads');
    Route::post('leads-info', [WLPLeadsController::class, 'info'])->name('leads.info');
    Route::post('leads/block-user', [WLPLeadsController::class, 'blockUser'])->name('leads.block.user');
    Route::post('leads/dnd-user', [WLPLeadsController::class, 'dndUser'])->name('leads.dnd.user');
    Route::post('leads/delete-user', [WLPLeadsController::class, 'destroyUser'])->name('leads.destroy.user');
    Route::post('leads/convert-customer', [WLPLeadsController::class, 'convertCustomer'])->name('leads.convertcustomer');

    Route::get('customers', [WLPCustomersController::class, 'customers'])->name('customers');
    Route::get('customers/{userId}', [WLPCustomersController::class, 'usersDetails'])->name('customers.details');
    Route::post('customers/update', [WLPCustomersController::class, 'usersDetailsUpdate'])->name('customers.update');
    Route::get('/invoice/{id}/pdf', [WLPCustomersController::class, 'downloadPdf'])->name('customers.invoice.pdf');
    Route::get('bmi/{id}/pdf', [WLPCustomersController::class, 'downloadBMIReport'])->name('customers.bmi.pdf');

    Route::post('customers/update-password', [WLPCustomersController::class, 'updatePassword'])->name('customers.update.password');
    Route::post('customers/deactivate-account', [WLPCustomersController::class, 'deactivateAccount'])->name('customers.deactivate.account');
    Route::post('customers/delete-account', [WLPCustomersController::class, 'deleteAccount'])->name('customers.delete.account');

    Route::get('statistics', [WLPLeadsController::class, 'statistics'])->name('statistics');
});

Route::group([
    'prefix' => 'wlw',
    'as' => 'manage.weight-loss-webinar.',
    'middleware' => ['auth'],
], function () {
    Route::get('leads', [WLWebinarController::class, 'leads'])->name('leads');
    Route::post('leads-info', [WLWebinarController::class, 'info'])->name('leads.info');
    Route::post('leads/block-user', [WLWebinarController::class, 'blockUser'])->name('leads.block.user');
    Route::post('leads/dnd-user', [WLWebinarController::class, 'dndUser'])->name('leads.dnd.user');
    Route::post('leads/delete-user', [WLWebinarController::class, 'destroyUser'])->name('leads.destroy.user');
    Route::post('leads/convert-customer', [WLWebinarController::class, 'convertCustomer'])->name('leads.convertcustomer');

    Route::get('customers', [WLWebinarController::class, 'customers'])->name('customers');
    Route::get('customers/{userId}', [WLWebinarController::class, 'usersDetails'])->name('customers.details');
    Route::post('customers/update', [WLWebinarController::class, 'usersDetailsUpdate'])->name('customers.update');
    Route::get('/invoice/{id}/pdf', [WLWebinarController::class, 'downloadPdf'])->name('customers.invoice.pdf');
    Route::get('bmi/{id}/pdf', [WLWebinarController::class, 'downloadBMIReport'])->name('customers.bmi.pdf');

    Route::post('customers/update-password', [WLWebinarController::class, 'updatePassword'])->name('customers.update.password');
    Route::post('customers/deactivate-account', [WLWebinarController::class, 'deactivateAccount'])->name('customers.deactivate.account');
    Route::post('customers/delete-account', [WLWebinarController::class, 'deleteAccount'])->name('customers.delete.account');

    Route::get('statistics', [WLWebinarController::class, 'statistics'])->name('statistics');
});

Route::group([
    'prefix' => 'bfaw',
    'as' => 'manage.bodyfat-analysis-workshop.',
    'middleware' => ['auth'],
], function () {
    Route::get('leads', [BFAWorkshopController::class, 'leads'])->name('leads');
    Route::post('leads-info', [BFAWorkshopController::class, 'info'])->name('leads.info');
    Route::post('leads/block-user', [BFAWorkshopController::class, 'blockUser'])->name('leads.block.user');
    Route::post('leads/dnd-user', [BFAWorkshopController::class, 'dndUser'])->name('leads.dnd.user');
    Route::post('leads/delete-user', [BFAWorkshopController::class, 'destroyUser'])->name('leads.destroy.user');
    Route::post('leads/convert-customer', [BFAWorkshopController::class, 'convertCustomer'])->name('leads.convertcustomer');

    Route::get('customers', [BFAWorkshopController::class, 'customers'])->name('customers');
    Route::get('customers/{userId}', [BFAWorkshopController::class, 'usersDetails'])->name('customers.details');
    Route::post('customers/update', [BFAWorkshopController::class, 'usersDetailsUpdate'])->name('customers.update');
    Route::get('/invoice/{id}/pdf', [BFAWorkshopController::class, 'downloadPdf'])->name('customers.invoice.pdf');
    Route::get('bmi/{id}/pdf', [BFAWorkshopController::class, 'downloadBMIReport'])->name('customers.bmi.pdf');

    Route::post('customers/update-password', [BFAWorkshopController::class, 'updatePassword'])->name('customers.update.password');
    Route::post('customers/deactivate-account', [BFAWorkshopController::class, 'deactivateAccount'])->name('customers.deactivate.account');
    Route::post('customers/delete-account', [BFAWorkshopController::class, 'deleteAccount'])->name('customers.delete.account');

    Route::get('statistics', [BFAWorkshopController::class, 'statistics'])->name('statistics');
});

Route::group([
    'prefix' => 'health-coach-webinar',
    'as' => 'manage.health-coach-webinar.',
    'middleware' => ['auth'],
], function () {
    Route::get('leads', [LeadsController::class, 'hcwLeads'])->name('leads');
    Route::get('customers', [CustomersController::class, 'hcwCustomers'])->name('customers');
});
