<?php

use Illuminate\Support\Facades\Route;
use Modules\DriveLinks\Http\Controllers\DriveLinksController;

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
    Route::get('/drive-links', [DriveLinksController::class, 'index'])->name('drive.links.index');
    Route::get('/drive-links-create', [DriveLinksController::class, 'create'])->name('drive.links.create');
    Route::post('/drive-links-create-store', [DriveLinksController::class, 'store'])->name('drive.links.store');
    Route::get('/drive-links/{id}', [DriveLinksController::class, 'show'])->name('drive.links.show');
    Route::get('/drive-links-edit/{id}', [DriveLinksController::class, 'edit'])->name('drive.links.edit');
    Route::put('/drive-links-update/{id}', [DriveLinksController::class, 'update'])->name('drive.links.update');
    Route::delete('/drive-links-destroy/{id}', [DriveLinksController::class, 'destroy'])->name('drive.links.destroy');
    Route::post('/drive-links-change-status/{id}', [DriveLinksController::class, 'changeStatus'])->name('drive.links.changeStatus');
});
