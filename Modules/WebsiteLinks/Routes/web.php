<?php

use Illuminate\Support\Facades\Route;
use Modules\WebsiteLinks\Http\Controllers\WebsiteLinksController;

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
    Route::get('/website-links', [WebsiteLinksController::class, 'index'])->name('website.links.index');
    Route::get('/website-links-create', [WebsiteLinksController::class, 'create'])->name('website.links.create');
    Route::post('/website-links-create-store', [WebsiteLinksController::class, 'store'])->name('website.links.store');
    Route::get('/website-links/{id}', [WebsiteLinksController::class, 'show'])->name('website.links.show');
    Route::get('/website-links-edit/{id}', [WebsiteLinksController::class, 'edit'])->name('website.links.edit');
    Route::put('/website-links-update/{id}', [WebsiteLinksController::class, 'update'])->name('website.links.update');
    Route::delete('/website-links-destroy/{id}', [WebsiteLinksController::class, 'destroy'])->name('website.links.destroy');
    Route::post('/website-links-change-status/{id}', [WebsiteLinksController::class, 'changeStatus'])->name('website.links.changeStatus');
});
