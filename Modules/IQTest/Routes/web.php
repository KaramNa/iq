<?php

use Modules\IQTest\Http\Controllers\QuestionController;
use Modules\IQTest\Http\Controllers\TestCategoryController;
use Modules\IQTest\Http\Controllers\TestController;
use Modules\IQTest\Http\Controllers\TestTakerController;


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::prefix('admin')->name('admin.')->group(function () {
//            Route::resource('iqtest',TeamController::class);
            Route::resource('test-taker', TestTakerController::class);
            Route::resource('test-categories', TestCategoryController::class);
            Route::resource('tests', TestController::class);
            Route::resource('questions', QuestionController::class);
        });
    }
);
