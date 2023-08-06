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
        // for divition

        $nq = 40;
        $oo = ['+', '*', '/', '/', '/', '*', '-'];
        $do = [2, 2, 3, 2, 2, 1, 2, 1];
        //$oo = ['/'];
        //$do = [1,1];
        $io = true;
        $soo = false;
        $sdo = false;
        
        //$dsOrder = [3, 2, 2, 1];
        //$dsOrder = [4, 1, 4, 1];
        //$dsOrder = [4, 1, 2, 2, 1];
        //$dsOrder = [1,1,1];

        //$r = $this->resolveDivitionForOnlyIntegers($dsOrder);
        //dd($r);

        //return 'dsds';

        /*$test = [];

        for ($i=0; $i < 10; $i++) {             
            if ($soo) $this->fisherYatesShuffle($oo);
            if ($sdo) $this->fisherYatesShuffle($do);
            array_push($test, $this->showExpression($oo, $do));
        }

        dd($test);*/

        //dd(ENGINE_AUTOMCQ::isOrdersValidForOnlyIntegerAnswers(['+', '/', '/', '/', '-'], [9, 3, 3, 3, 3, 3]));

        $test = [];

        for ($i=0; $i < $nq; $i++) {             
            $q = ENGINE_AUTOMCQ::generateQuestion($oo, $do, $soo, $sdo, 1, 4);
            
            $exp = $this->showExpression($q[0], $q[1]);

            $answers = $q[2];

            $exp .= " | R: ".$answers[1];

            foreach ($answers[0] as $a) {
                $exp .= ' | '.$a.' | ';
            }

            array_push($test, $exp);
        }

        dd($test);
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
