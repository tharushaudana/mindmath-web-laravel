<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TT;

class StudentAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'student_id',
        'finished_at',
        'marks',
        'expire_at'
    ];

    public function test() {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function student() {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function calcMarks() {
        if (!is_null($this->finished_at)) return $this->marks;

        $test = $this->test;

        switch (TT($test->type->name)) {
            case TT::$AUTOMCQ:
                $this->marks = $this->calcAutoMcqMarks($test);
                break;
            default:
                break;
        }

        $this->save();

        return $this->marks;
    }

    private function calcAutoMcqMarks($test) {
        $nq = $test->config->num_questions;
        $corrects = 0;

        foreach ($test->config->questions($this)->get() as $q) {
            $a = $q->studentAnswer();
            if (is_null($a)) continue;
            if ($a->answer != $q->correct_answer) continue;
            $corrects++;
        }

        $p = ($corrects / $nq) * 100;

        return number_format($p, 2, '.', '');
    }
}
