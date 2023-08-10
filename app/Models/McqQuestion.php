<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McqQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'mcq_test_id',
        'attempt_id',
        'question',
        'answers',
        'correct_answer',
        'loaded_at',
    ];

    public function isExpired($dur) {
        //if (is_null($this->loaded_at)) return false;
        //return Carbon::now()->diffInSeconds($this->loaded_at) > $dur;
        return $this->timeLeft($dur) <= 0;
    }

    public function timeLeft($dur) {
        return 5;
        if (is_null($this->loaded_at)) return 0;
        return $dur - Carbon::now()->diffInSeconds($this->loaded_at);
    }

    public function qNo() {
        return McqQuestion::where('attempt_id', $this->attempt_id)->where('id', '<=', $this->id)->count();
    }

    public function isLast() {
        $last = McqQuestion::where('attempt_id', $this->attempt_id)->latest('id')->first();
        return $last->id == $this->id;
    }

    public function studentAnswer() {
        return StudentMcqAnswer::where('question_id', $this->id)->where('attempt_id', $this->attempt_id)->first();
    }
}
