<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\manage\AdminsController;
use App\Http\Controllers\admin\manage\TestsController;
use App\Http\Controllers\admin\ProfileController;
use Illuminate\Support\Facades\Route; 

Route::middleware('auth:web')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('admin.home');
    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');

    Route::group(['prefix' => '/dashboard'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::group(['prefix' => '/manage'], function () {
            Route::group(['prefix' => '/tests'], function () {
                Route::view('/', 'admin.manage.tests.index')->name('admin.manage.tests');
                Route::get('/{test}', [TestsController::class, 'test'])->name('admin.manage.tests.test');
            });
            Route::group(['prefix' => '/admins'], function () {
                Route::get('/', [AdminsController::class, 'index'])->name('admin.manage.admins');
            }); 
        });
    });
});

Route::view('login', 'admin.login')->name('admin.login'); 