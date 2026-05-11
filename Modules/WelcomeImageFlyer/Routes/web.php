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
use Modules\WelcomeImageFlyer\Http\Controllers\WelcomeImageFlyerController;

Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth'],
], function () {
    Route::get('welcome-image-flyer', [WelcomeImageFlyerController::class, 'index'])->name('welcome_image_flyer.index');
    Route::get('welcome-image-flyer-create', [WelcomeImageFlyerController::class, 'create'])->name('welcome_image_flyer.create');
    Route::post('welcome-image-flyer-create-store', [WelcomeImageFlyerController::class, 'store'])->name('welcome_image_flyer.save');
    Route::get('welcome-image-flyer-edit/{id}', [WelcomeImageFlyerController::class, 'edit'])->name('welcome_image_flyer.edit');
    Route::post('welcome-image-flyer-update/{id}', [WelcomeImageFlyerController::class, 'update'])->name('welcome_image_flyer.update');
    Route::post('welcome-image-flyer-destroy/{id}', [WelcomeImageFlyerController::class, 'destroy'])->name('welcome_image_flyer.delete');
    Route::post('welcome-image-flyer-toggle-status/{id}', [WelcomeImageFlyerController::class, 'toggleStatus'])->name('welcome_image_flyer.toggleStatus');
    Route::get('welcome-image-flyer/{id}', [WelcomeImageFlyerController::class, 'show'])->name('welcome_image_flyer.show');
});
