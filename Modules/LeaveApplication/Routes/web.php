<?php
use Illuminate\Support\Facades\Route;
use Modules\LeaveApplication\Http\Controllers\LeaveApplicationController;
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

Route::prefix('/')->name('manage.')->middleware(['auth','PreventBackHistory'])->group(function() {
    Route::get('/apply-leave', [LeaveApplicationController::class, 'index'])->name('apply-leave.index');
    Route::post('/apply-leave-approve/{id}', [LeaveApplicationController::class, 'approveLeave'])->name('apply-leave.approve');
    Route::get('apply-leave-edit/{id}', [LeaveApplicationController::class, 'edit'])->name('apply-leave.edit');
    Route::put('apply-leave-update/{id}', [LeaveApplicationController::class, 'update'])->name('apply-leave.update');
});
