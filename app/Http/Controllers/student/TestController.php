<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Test $test) {
        // for divition

        $oo = ['+', '-', '/', '/', '/', '*'];
        $do = [3, 2, 2, 1, 2, 2, 3];
        $soo = true;
        $sdo = true;
        
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

        dd($this->isOrdersCanBeChangeForOnlyIntegerAnswers(['+', '/', '/', '/', '-'], [3,3,2,2,1,3]));
    }

    public function showExpression($operations, $numbers) {
        $exp = '';
        
        for ($i=0; $i < count($numbers); $i++) { 
            $exp .= $numbers[$i];
            if ($i <= count($operations) - 1) 
                $exp .= $operations[$i];
        }

        return $exp;
    }

    public function isOrdersCanBeChangeForOnlyIntegerAnswers($opOrder, $dsOrder) {
        if (count($dsOrder) == 2) return;  
        
        $opCounts = array_count_values($opOrder);

        if (!isset($opCounts['/'])) return true;

        $dsCounts = array_count_values($dsOrder);
        
        //if (isset($dsCounts[1]) && )
        
        $dsCountsKeys = array_keys($dsCounts);

        $divCount = $opCounts['/'];

        $maxDs = max($dsCountsKeys);
        $maxCount = max(array_values($dsCounts));

        if ($maxCount > 2) {
            $maxCountDs = 0;

            foreach ($dsCounts as $ds => $count) {
                if ($count == $maxCount) {
                    if ($ds > $maxCountDs) $maxCountDs = $ds;
                }
            }


        }

        $ds = $maxDs;

        /*rsort($dsOrder);

        dd($dsOrder);

        $n = $dsOrder[0];

        for ($i=0; $i < $divCount - 1; $i++) { 
            $n -= $dsOrder[$i + 1] - 1;
            if ($n < 1) return false;
        }*/

        return true;
    }

    public function generateQuestion($opOrder, $dsOrder) {

    }

    public function resolveDivitionForOnlyIntegers($dsOrder) {
        if (count($dsOrder) <= 1) return NAN;
        
        $firstDs = $dsOrder[0];
        $remain = array_slice($dsOrder, 1);

        $maxMultiplyValue = pow(10, $firstDs) - 1;
        $maxMultiplyOfRemain = $maxMultiplyValue / 2;

        //@@@ find numbers for remaining digit sizes

        do {
            $multiplyResultOfRemain = 1;
            $narr = [];

            foreach ($remain as $ds) {
                $num = $this->generateRandNum($ds);
                $multiplyResultOfRemain *= $num;
                array_push($narr, $num);
            }
        } while ($multiplyResultOfRemain > $maxMultiplyOfRemain);

        //@@@ find all factors for generate first number

        $factors = [];

        for ($i = 2; $i <= 9; $i++) { 
            if ($multiplyResultOfRemain * $i <= $maxMultiplyValue) {
                array_push($factors, $i);
            }
        }

        //@@@ select random factor if has more than one factors

        // no more factors
        if (count($factors) == 1) {
            array_unshift($narr, $multiplyResultOfRemain * $factors[0]);
        } 
        // select factor randomly
        else {
            $i = mt_rand(0, count($factors) - 1);
            array_unshift($narr, $multiplyResultOfRemain * $factors[$i]);
        }

        return $narr;
    }

    public function generateRandNum($ds) {
        if ($ds <= 0) return NAN;
    
        $min = pow(10, $ds - 1);
        $max = pow(10, $ds) - 1;

        return mt_rand($min, $max);
    }

    function fisherYatesShuffle(&$array) {
        $count = count($array);
        
        for ($i = $count - 1; $i > 0; $i--) {
            $randIndex = mt_rand(0, $i);
            
            // Swap elements at $i and $randIndex
            $temp = $array[$i];
            $array[$i] = $array[$randIndex];
            $array[$randIndex] = $temp;
        }
    }

    //########## not used

    public function generateRandNumForDivition($ds, $divisableDs) {
        if ($ds <= 0) return null;
    
        do {
            $min = pow(10, $ds - 1);
            $max = pow(10, $ds) - 1;
            $randomNumber = mt_rand($min, $max);
        } while ($this->isPrime($randomNumber) || $randomNumber == 1);
    
        return [$randomNumber, $this->findNearestDivisibleNumber($randomNumber, $divisableDs)];
    }

    function findNearestDivisibleNumber($number, $divisibleDigitSize) {
        $minDivisible = pow(10, $divisibleDigitSize - 1);
        $maxDivisible = pow(10, $divisibleDigitSize) - 1;

        $nearestDivisible = floor($number / $maxDivisible) * $maxDivisible;
    
        if ($nearestDivisible < $minDivisible) {
            $nearestDivisible = $minDivisible;
        }
    
        return $nearestDivisible;
    }
    

    function isPrime($number) {
        if ($number <= 1) {
            return false;
        }
    
        if ($number <= 3) {
            return true;
        }
    
        if ($number % 2 == 0 || $number % 3 == 0) {
            return false;
        }
    
        $i = 5;
        while ($i * $i <= $number) {
            if ($number % $i == 0 || $number % ($i + 2) == 0) {
                return false;
            }
            $i += 6;
        }
    
        return true;
    }
}
