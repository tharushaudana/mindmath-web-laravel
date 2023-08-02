<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\HomeController;
use Illuminate\Support\Facades\Route; 

Route::middleware('auth:web')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('admin.home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::view('login', 'admin.login')->name('admin.login'); 