<?php

use App\Http\Controllers\student\HomeController;
use App\Http\Controllers\student\questions\AutoMcqController;
use App\Http\Controllers\student\TestController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:student')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('student.home');
    
    Route::group(['prefix' => '/test/{test}'], function () {
        Route::get('/', [TestController::class, 'index'])->name('student.test');
        Route::post('/ready', [TestController::class, 'ready'])->name('student.test.ready');
        Route::post('/attempt', [TestController::class, 'attempt'])->name('student.test.attempt');

        Route::group(['prefix' => '/questions'], function () {
            //### AutoMcq
            Route::get('/automcq', [AutoMcqController::class, 'get'])->name('student.test.questions.automcq');
            Route::post('/automcq', [AutoMcqController::class, 'getNext']);
        });
    });
});

Route::view('login', 'student.login')->name('student.login'); 