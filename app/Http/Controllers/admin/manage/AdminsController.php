<?php

namespace App\Http\Controllers\admin\manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminsController extends Controller
{
    public function index() {
        return view('admin.manage.admins.index');
    }
}
