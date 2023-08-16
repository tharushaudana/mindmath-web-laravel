<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Student extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'grade_id',
    ];

    protected $appends = ['grade'];

    public function getGradeAttribute()
    {
        return Grade::find($this->grade_id);
    }

    public function attempts(Test $test) {
        return StudentAttempt::where('student_id', $this->id)->where('test_id', $test->id)->orderBy('id', 'desc')->get();
    }

    public function recentFinishedAttempts($test_type_id = null, $order = 'asc') {
        $attempts = StudentAttempt::select('student_attempts.id', 'student_attempts.test_id', 'student_attempts.marks');
        $attempts->where('student_id', $this->id);
        
        if (!is_null($test_type_id)) {
            $attempts->join('tests', 'tests.id', '=', 'student_attempts.test_id');
            $attempts->where('tests.test_type_id', '=', $test_type_id);
        }
        
        return $attempts->orderBy('student_attempts.id', $order)->take(20)->get();
    }

    public function currentAttempt() {
        return StudentAttempt::where('student_id', $this->id)->where('finished_at', null)->where('expire_at', '>', Carbon::now())->first();
    }

    public function latestAttempt() {
        return StudentAttempt::where('student_id', $this->id)->orderBy('id', 'desc')->first();
    }
}
