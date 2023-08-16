<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Http\Requests\student\UpdateProfileRequest;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index() {
        return view('student.profile', [
            'me' => Auth::guard('student')->user(),
            'grades' => Grade::all(),
        ]);
    }

    public function update(UpdateProfileRequest $request) {
        $me = Auth::guard('student')->user();

        $me->name = $request->get('name');
        $me->grade_id = $request->get('grade');
        $me->save();

        return redirect()->route('student.profile');
    }
}
