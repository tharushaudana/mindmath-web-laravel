<?php

namespace App\Http\Livewire\Student\Test;

use App\Models\McqQuestion;
use App\Models\StudentAttempt;
use App\Models\StudentMcqAnswer;
use App\Models\Test;
use Livewire\Component;

class AutoMcqAnswerBox extends Component
{
    public McqQuestion $question;
    public Test $test;
    public StudentAttempt $attempt;

    //public StudentMcqAnswer $studentAnswer;

    public function mount() {
        /*$this->studentAnswer = $this->question->studentAnswer();
        
        $this->studentAnswer = !is_null($a) ? $a : new StudentMcqAnswer([
            'question_id' => $this->question->id,
            'attempt_id' => $this->question->attempt_id
        ]);*/
    }

    public function saveAnswer($index) {
        if ($this->question->isExpired($this->test->config->dur_per)) return;
        
        $studentAnswer = $this->question->studentAnswer();

        if (is_null($studentAnswer)) {
            $studentAnswer = new StudentMcqAnswer([
                'question_id' => $this->question->id,
                'attempt_id' => $this->question->attempt_id
            ]);
        }
        
        $studentAnswer->answer = $index;
        $studentAnswer->save();

        //### mark corrects

        if ($index != $this->question->correct_answer) return;

        //$attempt->corrects = 
    }

    private function calcMarks($iscorrect) {

    }

    public function render()
    {
        return view('livewire.student.test.auto-mcq-answer-box', [
            'question' => $this->question,
            'test' => $this->test,
        ]);
    }
}
