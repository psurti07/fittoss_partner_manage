<?php

use Illuminate\Support\Facades\Route;
use Modules\Employee\Http\Controllers\EmployeeController;
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
    'prefix' => '/',
    'as' => 'manage.',
    'middleware' => ['auth', 'PreventBackHistory']
], function () {
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
    Route::get('/employee-create', [EmployeeController::class, 'create'])->name('employee.create');
    Route::post('/employee-create-store', [EmployeeController::class, 'store'])->name('employee.save');
    Route::get('/employee/{id}', [EmployeeController::class, 'show'])->name('employee.show');
    Route::get('/employee-edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::post('/employee-update/{id}', [EmployeeController::class, 'update'])->name('employee.update');
    Route::post('/employee-destroy/{id}', [EmployeeController::class, 'destroy'])->name('employee.delete');
    Route::post('/employee-toggle-status/{id}', [EmployeeController::class, 'toggleStatus'])->name('employee.toggleStatus');
    Route::post('employees/{id}/toggle-kyc-approval', [EmployeeController::class, 'toggleKycApproval'])->name('employee.toggleKyc');
    Route::post('/employee/{id}/delete-kyc-file', [EmployeeController::class, 'deleteKycFile'])->name('employee.deleteKycFile');
});
