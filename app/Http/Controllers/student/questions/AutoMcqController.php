<?php

namespace App\Http\Controllers\student\questions;

use App\Http\Controllers\Controller;
use App\Models\McqQuestion;
use App\Models\Test;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutoMcqController extends Controller
{
    public function get(Test $test) {
        $attempt = null;

        if (!$this->validateAttempt($test, $attempt)) abort(404);

        $durPer = $test->config->dur_per;

        $question = $test->config->lastLoadedQuestionOfAttempt($attempt);

        if (is_null($question) || (($question->isExpired($durPer) || !is_null($question->studentAnswer())) && !$question->isLast())) {
            $question = $test->config->nextQuestionOfAttempt($attempt);
            $question->loaded_at = Carbon::now()->addSeconds(2);
            //$question->save();
        }

        return view('student.test.questions.automcq', [
            'test' => $test,
            'attempt' => $attempt,
            'question' => $question,
        ]);
    }

    private function validateAttempt($test, &$attempt) {
        $attempt = Auth::guard('student')->user()->currentAttempt();

        if (is_null($attempt)) return false;

        if ($attempt->test_id != $test->id) return false;

        return $attempt;
    }
}
