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

    public function currentAttempt() {
        return StudentAttempt::where('student_id', $this->id)->where('finished_at', null)->where('expire_at', '>', Carbon::now())->first();
    }

    public function latestAttempt() {
        return StudentAttempt::where('student_id', $this->id)->orderBy('id', 'desc')->first();
    }
}
