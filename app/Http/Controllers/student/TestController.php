<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\StudentAttempt;
use App\Models\Test;
use Carbon\Carbon;
use ENGINE_AUTOMCQ;
use ENGINE_TOOLS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use McqHelper;

include 'helpers/test/helper.php';

class TestController extends Controller
{
    public function index(Test $test) {
        /*$previousOpOrders = [];
        $previousNumberSets = [];

        $nq = 40;
        //$oo = ['+', '*', '/', '/', '/', '*', '-'];
        //$do = [2, 2, 3, 2, 2, 1, 2, 1];
        $oo = ['+'];
        $do = [1,1];
        $io = true;
        $soo = true;
        $sdo = true;

        $fails = 0;

        //dd(ENGINE_AUTOMCQ::isOrdersValidForOnlyIntegerAnswers(['+', '/', '/', '/', '-'], [9, 3, 3, 3, 3, 3]));

        $test = [];

        for ($i=0; $i < $nq; $i++) {             
            $fails = 0;

            do {
                $q = ENGINE_AUTOMCQ::generateQuestion($oo, $do, $soo, $sdo, 1, 4);
                $fails++;
            } while (in_array($q[0], $previousOpOrders) && in_array($q[1], $previousNumberSets));

            //if ($fails >= 1000) break;

            array_push($previousOpOrders, $q[0]);
            array_push($previousNumberSets, $q[1]);

            //$q = ENGINE_AUTOMCQ::generateQuestion($oo, $do, $soo, $sdo, 1, 4);
            $answers = $q[2];

            $exp = $this->showExpression($q[0], $q[1]);
            $exp .= " | R: ".$answers[1];

            foreach ($answers[0] as $a) {
                $exp .= ' | '.$a.' | ';
            }

            array_push($test, $exp);
        }

        dd($test);*/

        if (!$this->validateGrade($test)) abort(404);

        $currentAttempt = Auth::guard('student')->user()->currentAttempt();
        
        if (!is_null($currentAttempt) && $currentAttempt->test_id != $test->id) {
            return redirect()->route('student.test', $currentAttempt->test_id);
        }

        return view('student.test.welcome', [
            'test' => $test
        ]);
    }

    public function ready(Test $test) {
        if (!$this->validateGrade($test)) abort(404);

        if (Auth::guard('student')->user()->attempts->count() == $test->max_attempts) return response('Bad Request', 400);

        return view('student.test.ready', [
            'test' => $test
        ]);
    }

    public function attempt(Test $test) {
        if (!$this->validateGrade($test)) abort(404);

        if (Auth::guard('student')->user()->attempts->count() == $test->max_attempts) return response('Bad Request', 400);

        //### save attempt

        $attempt = new StudentAttempt();
        $attempt->test_id = $test->id;
        $attempt->student_id = Auth::guard('student')->user()->id;
        $attempt->expire_at = Carbon::now()->addSeconds($test->config->totalDurationInSecs());
        $attempt->save();

        //### store questions

        $type = $test->type->name;

        if ($type == 'mcq' && !McqHelper::init($test, $attempt)) return response('Bad Request', 400);
    }

    private function validateGrade($test) {
        if (is_null($test->grade)) return true;
        return $test->grade->id == Auth::guard('student')->user()->grade->id;
    }

    //============================

    public function showExpression($operations, $numbers) {
        $exp = '';
        
        for ($i=0; $i < count($numbers); $i++) { 
            $exp .= $numbers[$i];
            if ($i <= count($operations) - 1) 
                $exp .= ' '.$operations[$i].' ';
        }

        return $exp;
    }

    function evaluateExpression($expression) {
        return eval("return $expression;");
    }
    
    function generateExpressions($operationsOrder, $digitSizeOrder) {
        $totalExpressions = 0;
        $numDigits = count($digitSizeOrder);
        $numOperators = count($operationsOrder);
        
        for ($i = 0; $i <= $numDigits; $i++) {
            for ($j = 0; $j <= $numOperators; $j++) {
                if ($i + $j == $numDigits) {
                    $numOperands = $i + 1;
                    $numOperatorsUsed = $j;
                    $numEmptySlots = $numOperands + $numOperatorsUsed - 1;
    
                    $combinations = $this->nCr($numEmptySlots, $numOperands - 1);
    
                    for ($k = 0; $k < $combinations; $k++) {
                        $expression = '';
                        for ($m = 0; $m < $numOperands - 1; $m++) {
                            $expression .= $digitSizeOrder[$m] . $operationsOrder[$k % $numOperatorsUsed];
                        }
                        $expression .= $digitSizeOrder[$numOperands - 1];
                        
                        if ($this->evaluateExpression($expression) % 1 === 0) {
                            $totalExpressions++;
                        }
                    }
                }
            }
        }
        
        return $totalExpressions;
    }    

    function nCr($n, $r) {
        if ($r == 0 || $n == $r) {
            return 1;
        }
        return $this->nCr($n - 1, $r - 1) + $this->nCr($n - 1, $r);
    }
}
