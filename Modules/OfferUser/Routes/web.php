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
use Modules\OfferUser\Http\Controllers\CustomersController;
use Modules\OfferUser\Http\Controllers\ExpertConsultationController;
use Modules\OfferUser\Http\Controllers\FitoneUserController;
use Modules\OfferUser\Http\Controllers\LeadsController;

Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => 'leads', 'as' => 'manage.leads.'], function () {
        Route::post('info', [LeadsController::class, 'info'])->name('info');
        Route::post('block-user', [LeadsController::class, 'blockUser'])->name('block.user');
        Route::post('dnd-user', [LeadsController::class, 'dndUser'])->name('dnd.user');
        Route::post('delete-user', [LeadsController::class, 'destroyUser'])->name('destroy.user');
        Route::post('convert-customer', [LeadsController::class, 'convertCustomer'])->name('convertcustomer');
    });

    Route::group(['prefix' => 'customers', 'as' => 'manage.customers.'], function () {
        Route::get('{userId}', [CustomersController::class, 'usersDetails'])->name('details');
        Route::post('update', [CustomersController::class, 'usersDetailsUpdate'])->name('update');
        Route::get('/invoice/{id}/pdf', [CustomersController::class, 'downloadPdf'])->name('invoice.pdf');

        Route::post('update-password', [CustomersController::class, 'updatePassword'])->name('update.password');
        Route::post('deactivate-account', [CustomersController::class, 'deactivateAccount'])->name('deactivate.account');
        Route::post('delete-account', [CustomersController::class, 'deleteAccount'])->name('delete.account');
    });

    Route::group(['prefix' => 'weight-loss-offer', 'as' => 'manage.weight-loss-offer.'], function () {
        Route::get('leads', [LeadsController::class, 'wloLeads'])->name('leads');
        Route::get('customers', [CustomersController::class, 'wloCustomers'])->name('customers');
    });

    Route::group(['prefix' => 'ultimate-program', 'as' => 'manage.ultimate-program.'], function () {
        Route::get('leads', [LeadsController::class, 'UPLeads'])->name('leads');
        Route::get('customers', [CustomersController::class, 'UPCustomers'])->name('customers');
    });

    Route::group(['prefix' => 'customize-program', 'as' => 'manage.customize-program.'], function () {
        Route::get('leads', [LeadsController::class, 'CPLeads'])->name('leads');
        Route::get('customers', [CustomersController::class, 'CPCustomers'])->name('customers');
    });
    
    Route::group(['prefix' => 'weight-loss-webinar-offer', 'as' => 'manage.weight-loss-webinar-offer.'], function () {
        Route::get('leads', [LeadsController::class, 'WLWOLeads'])->name('leads');
        Route::get('customers', [CustomersController::class, 'WLWOCustomers'])->name('customers');
    });

    Route::group(['prefix' => 'fitone', 'as' => 'manage.fitone.'], function () {
        Route::get('leads', [FitoneUserController::class, 'leads'])->name('leads');
        Route::get('customers', [FitoneUserController::class, 'customers'])->name('customers');
        Route::get('/invoice/{userId}/pdf', [FitoneUserController::class, 'downloadPdf'])->name('invoice.pdf');
    });

    Route::group(['prefix' => 'expert-consultation', 'as' => 'manage.expert.consultation.'], function () {
        Route::get('leads', [ExpertConsultationController::class, 'leads'])->name('leads');
        Route::get('customers', [ExpertConsultationController::class, 'customers'])->name('customers');
    });

    Route::group(['prefix' => 'membership-plan', 'as' => 'manage.membership-plan.'], function () {
        Route::get('leads', [ExpertConsultationController::class, 'membershipLeads'])->name('leads');
        Route::get('customers', [ExpertConsultationController::class, 'membershipCustomers'])->name('customers');
    });

    Route::group(['prefix' => 'associate-partner-program', 'as' => 'manage.associate-partner-program.'], function () {
        Route::get('leads', [ExpertConsultationController::class, 'associatePartnerLeads'])->name('leads');
        Route::get('customers', [ExpertConsultationController::class, 'associatePartnerCustomers'])->name('customers');
    });

    Route::group(['prefix' => 'advance-plan', 'as' => 'manage.advance-plan.'], function () {
        Route::get('leads', [ExpertConsultationController::class, 'advancePlanLeads'])->name('leads');
        Route::get('customers', [ExpertConsultationController::class, 'advancePlanCustomers'])->name('customers');
    });

    Route::group(['prefix' => 'onboard-upi-payment', 'as' => 'manage.onboard-upi-payment.'], function () {
        Route::get('customers', [ExpertConsultationController::class, 'onboardUPICustomers'])->name('customers');
    });
});
