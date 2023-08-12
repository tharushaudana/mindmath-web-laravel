<?php

namespace App\Http\Controllers\admin\manage;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;

class TestsController extends Controller
{
    public function test(Test $test) {
        return view('admin.manage.tests.test')->with('test', Test::find($test->id));
    }
}
