<?php

use Illuminate\Support\Facades\Route;
use Modules\Invoice\App\Http\Controllers\InvoiceController;

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
    Route::get('invoice', [InvoiceController::class, 'getInvoices'])->name('invoice');
    Route::get('/invoice/{id}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoice.pdf');
    Route::get('/customer-invoice/{id}', [InvoiceController::class, 'generateInvoice'])->name('customers.invoice');
    Route::delete('/invoice/{id}', [InvoiceController::class, 'deleteInvoice'])->name('invoice.delete');

    Route::get('gst', [InvoiceController::class, 'getGST'])->name('gst');
    Route::get('refunds', [InvoiceController::class, 'getRefunds'])->name('refunds');
    Route::get('refund/{id}/{no}', [InvoiceController::class, 'refundProcess'])->name('refund.process');
    Route::post('refund', [InvoiceController::class, 'refundAmtProcess'])->name('refund.amount.process');
});
