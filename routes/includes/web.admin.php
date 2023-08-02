<?php

use App\Http\Controllers\admin\HomeController;
use Illuminate\Support\Facades\Route; 

Route::get('/', [HomeController::class, 'index'])->name('admin.home');