<?php

use Illuminate\Support\Facades\Route;
use Modules\BeforeAfterTestimonial\App\Http\Controllers\BeforeAfterTestimonialController;

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
    'middleware' => ['auth'],
], function () {
    Route::resource('before-after-testimonial', BeforeAfterTestimonialController::class)->names('before-after-testimonial');
});
