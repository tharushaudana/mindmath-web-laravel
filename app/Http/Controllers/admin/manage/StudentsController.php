<?php

namespace App\Http\Controllers\admin\manage;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    public function index() {
        return view('admin.manage.students.index');
    }
}
