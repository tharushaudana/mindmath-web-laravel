<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Test;
use ENGINE_AUTOMCQ;
use ENGINE_TOOLS;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Test $test) {
        /*$nq = 40;
        $oo = ['+', '*', '/', '/', '/', '*', '-'];
        $do = [2, 2, 3, 2, 2, 1, 2, 1];
        //$oo = ['/'];
        //$do = [1,1];
        $io = true;
        $soo = true;
        $sdo = true;

        //dd(ENGINE_AUTOMCQ::isOrdersValidForOnlyIntegerAnswers(['+', '/', '/', '/', '-'], [9, 3, 3, 3, 3, 3]));

        $test = [];

        for ($i=0; $i < $nq; $i++) {             
            $q = ENGINE_AUTOMCQ::generateQuestion($oo, $do, $soo, $sdo, 1, 4);
            $answers = $q[2];

            $exp = $this->showExpression($q[0], $q[1]);
            $exp .= " | R: ".$answers[1];

            foreach ($answers[0] as $a) {
                $exp .= ' | '.$a.' | ';
            }

            array_push($test, $exp);
        }

        dd($test);*/

        return view('student.test');
    }

    public function showExpression($operations, $numbers) {
        $exp = '';
        
        for ($i=0; $i < count($numbers); $i++) { 
            $exp .= $numbers[$i];
            if ($i <= count($operations) - 1) 
                $exp .= ' '.$operations[$i].' ';
        }

        return $exp;
    }
}
