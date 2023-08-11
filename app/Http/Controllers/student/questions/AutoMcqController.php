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
    public function get(Test $test, $clickNext = false) {
        $attempt = null;

        if (!$this->validateAttempt($test, $attempt)) return redirect()->route('student.test', $test->id);

        $durPer = $test->config->dur_per;

        $question = $test->config->lastLoadedQuestionOfAttempt($attempt);

        if (is_null($question) || (($clickNext || $question->isExpired($durPer) || !is_null($question->studentAnswer())) && !$question->isLast())) {
            $question = $this->nextQuestion($test, $attempt);
            $question->save();
        }

        return view('student.test.questions.automcq', [
            'test' => $test,
            'attempt' => $attempt,
            'question' => $question,
        ]);
    }

    public function getNext(Test $test) {
        return $this->get($test, true);
    }

    public function finish(Test $test) {
        $attempt = null;

        if (!$this->validateAttempt($test, $attempt)) return redirect()->route('student.test', $test->id);

        $attempt->calcMarks();

        $attempt->finished_at = Carbon::now();
        $attempt->save();

        return redirect()->route('student.test', $test->id);
    }

    private function nextQuestion($test, $attempt) {
        $question = $test->config->nextQuestionOfAttempt($attempt);
        $question->loaded_at = Carbon::now()->addSeconds(2);
        return $question;
    }

    private function validateAttempt($test, &$attempt) {
        $attempt = Auth::guard('student')->user()->currentAttempt();

        if (is_null($attempt)) return false;

        if ($attempt->test_id != $test->id) return false;

        return $attempt;
    }
}
