<?php

use App\Http\Controllers\student\HomeController;
use App\Http\Controllers\student\TestController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:student')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('student.home');
    Route::get('/test/{test}', [TestController::class, 'index'])->name('student.test');
});

Route::view('login', 'student.login')->name('student.login'); 