<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() {
        /*if (!Auth::check()) {
            return redirect()->route('student.login');
        }*/

        return view('student.home', [
            'me' => Auth::guard('student')->user(),
            'upcommingTests' => Test::upcommingTests(),
            'ongoingTests' => Test::ongoingTests(),
        ]);
    }
}
