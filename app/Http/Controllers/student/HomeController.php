<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() {
        /*if (!Auth::check()) {
            return redirect()->route('student.login');
        }*/

        return view('student.home');
    }
}
