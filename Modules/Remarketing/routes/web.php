<?php

use Illuminate\Support\Facades\Route;
use Modules\Remarketing\App\Http\Controllers\RemarketingScheduleController;
use Modules\Remarketing\App\Http\Controllers\RemarketingLogController;

Route::group([
    'prefix' => '',
    'as' => 'manage.',
    'middleware' => ['auth','PreventBackHistory']
], function () {
    Route::get('/remarketing-log', [RemarketingLogController::class,'index'])->name('remarketing.log');
    Route::get('/remarketing-log/details/{id}', [RemarketingLogController::class,'details'])->name('remarketing.log.details');

    Route::group(['prefix' => 'remarketing-schedule', 'as' => 'remarketing.schedule.',], function () {
        Route::get('/', [RemarketingScheduleController::class, 'index'])->name('index');
        Route::get('create/{id}', [RemarketingScheduleController::class, 'create'])->name('create');
        // Route::post('store', [RemarketingScheduleController::class, 'store'])->name('store');
        // Route::get('edit/{product_id}/{type}', [RemarketingScheduleController::class, 'edit'])->name('edit');
        Route::post('update', [RemarketingScheduleController::class, 'update'])->name('update');
    });
});
