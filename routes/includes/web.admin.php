<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\manage\TestController;
use App\Http\Controllers\admin\ProfileController;
use Illuminate\Support\Facades\Route; 

Route::middleware('auth:web')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('admin.home');
    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');

    Route::group(['prefix' => '/dashboard'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/manage/tests', [TestController::class, 'index'])->name('admin.manage.tests');
    });
});

Route::view('login', 'admin.login')->name('admin.login'); 