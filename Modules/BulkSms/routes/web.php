<?php

use Illuminate\Support\Facades\Route;
use Modules\BulkSms\App\Http\Controllers\BulkSmsController;

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
    Route::get('/bulksms', [BulkSmsController::class, 'index'])->name('bulk.sms');
    Route::post('/blog-remarketing/upload', [BulkSmsController::class, 'upload'])->name('blog.remarketing.upload');
    Route::post('/blog-remarketing/destroy', [BulkSmsController::class, 'destroy'])->name('blog.remarketing.destroy');
});
