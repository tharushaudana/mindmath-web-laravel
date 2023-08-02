<?php

use App\Http\Controllers\student\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:student')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('student.home');
});

Route::view('login', 'student.login')->name('student.login'); 