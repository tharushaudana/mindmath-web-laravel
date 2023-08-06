<?php

class ENGINE_AUTOMCQ {
    public static function generateQuestion($opOrder, $dsOrder, $shuffleOpOrder, $shuffleDsOrder, $integerAnswersOnly, $numAnswers) {
        if ($shuffleOpOrder) ENGINE_TOOLS::fisherYatesShuffle($opOrder);
        if ($shuffleDsOrder) ENGINE_TOOLS::fisherYatesShuffle($dsOrder);
        
        if ($integerAnswersOnly == 1) {
            if (!ENGINE_AUTOMCQ::isOrdersValidForOnlyIntegerAnswers($opOrder, $dsOrder))
                return false;

            ENGINE_AUTOMCQ::fixDigitSizeOrderToIntegersOnly($dsOrder, $opOrder);
        }

        $numbers = [];

        $divSector = [];

        for ($i=0; $i < count($dsOrder); $i++) { 
            if ($i <= count($opOrder) - 1) $op = $opOrder[$i];
            else $op = null;

            $ds = $dsOrder[$i];
            
            if ($op == '/') {
                array_push($divSector, $ds);
            } else {
                if (count($divSector) > 0) {
                    array_push($divSector, $ds);
                    $numbers = array_merge($numbers, ENGINE_AUTOMCQ::resolveDivitionForOnlyIntegers($divSector));
                    $divSector = [];
                } else {
                    array_push($numbers, ENGINE_AUTOMCQ::generateRandNum($ds));
                }
            } 
        }

        return [$opOrder, $numbers, ENGINE_AUTOMCQ::generateAnswers($opOrder, $numbers, $numAnswers)];
    }

    private static function generateAnswers($opOrder, $dsOrder, $numAnswers) {
        $correctAnswer = ENGINE_TOOLS::getResultOfExpression(ENGINE_TOOLS::toExpression($opOrder, $dsOrder));

        $fakeAnswers = [];

        for ($i=2; $i <= 9; $i++) { 
            /*do {
                $rn1  = mt_rand(0, 1);
                $rn2 = mt_rand(1, 100);
                $rn3 = mt_rand(1, 5);
    
                if ($correctAnswer % $i == 0) {
                    $fa = $correctAnswer + ($i * $rn2) * ($rn1 == 1 ? -1 : 1);
                    $fa += $rn3 * ($rn1 == 1 ? -1 : 1);
                } else {
                    $fa = $correctAnswer + ($correctAnswer % $i) + $rn3 * ($rn1 == 1 ? -1 : 1); 
                }
            } while (in_array($fa, $fakeAnswers));*/

            $rn1  = mt_rand(0, 1);
            $rn2 = mt_rand(1, 100);
            $rn3 = mt_rand(1, 5);

            if ($correctAnswer % $i == 0) {
                $fa = $correctAnswer + ($i * $rn2) * ($rn1 == 1 ? -1 : 1);
                $fa += $rn3 * ($rn1 == 1 ? -1 : 1);
            } else {
                $fa = $correctAnswer + ($correctAnswer % $i) + $rn3 * ($rn1 == 1 ? -1 : 1); 
            }

            if (!in_array($fa, $fakeAnswers) && $fa != $correctAnswer) array_push($fakeAnswers, $fa);
        }

        ENGINE_TOOLS::fisherYatesShuffle($fakeAnswers);

        $answers = [];
        $usedIndexes = [];

        for ($i=0; $i < $numAnswers - 1; $i++) { 
            $index = -1;
            
            do {
                $index = mt_rand(0, count($fakeAnswers) - 1);
            } while(in_array($index, $usedIndexes));

            array_push($answers, $fakeAnswers[$index]);
            array_push($usedIndexes, $index);
        }

        array_push($answers, $correctAnswer);

        ENGINE_TOOLS::fisherYatesShuffle($answers);

        return [$answers, $correctAnswer];
    }

    public static function fixDigitSizeOrderToIntegersOnly(&$dsOrder, $opOrder) {
        if (ENGINE_AUTOMCQ::isDigitSizeOrderValidForOnlyIntegerAnswers($dsOrder, $opOrder)) return true;
        
        do {
            ENGINE_TOOLS::fisherYatesShuffle($dsOrder);
        } while (!ENGINE_AUTOMCQ::isDigitSizeOrderValidForOnlyIntegerAnswers($dsOrder, $opOrder));

        return true;
    }

    public static function isDigitSizeOrderValidForOnlyIntegerAnswers($dsOrder, $opOrder) {
        $n = 0;
        
        for ($i=0; $i < count($dsOrder) - 1; $i++) { 
            $op = $opOrder[$i];
            
            if ($op == '/') {
                if ($n == 0) $n = $dsOrder[$i];

                $ds = $dsOrder[$i + 1];
                $n = $n - $ds + 1;
    
                if ($n <= 0) return false;

                continue;
            } 

            $n = 0;
        }

        return true;
    }

    public static function isOrdersValidForOnlyIntegerAnswers($opOrder, $dsOrder) {
        if (count($dsOrder) == 2) return true;  
        
        $opCounts = array_count_values($opOrder);

        if (!isset($opCounts['/'])) return true;
        $expectedNumCount = $opCounts['/'] + 1;

        $dsCounts = array_count_values($dsOrder);

        if (isset($dsCounts[1])) {
            if ($dsCounts[1] >= $expectedNumCount) return true;
            $expectedNumCount -= $dsCounts[1];
            unset($dsCounts[1]);
        } 

        $dsCountsKeys = array_keys($dsCounts);

        rsort($dsCountsKeys); // sort DESC
        $maxDs = $dsCountsKeys[0];

        //### check for expectedNumCount can complete like 9,9,1,1,1,... (twice of maxds at beginning others are 1)
        if ($dsCounts[$maxDs] > 1 && $expectedNumCount - 2 <= 0) return true; 

        // ### maxds number is used
        $expectedNumCount -= 1;
        
        if ($expectedNumCount == 0) return true; 

        //### remove all maxds values
        $dsCountsKeys = array_diff($dsCountsKeys, array_fill(0, $dsCounts[$maxDs], $maxDs));

        sort($dsCountsKeys); // sort ASC

        $n = $maxDs;

        foreach ($dsCountsKeys as $ds) {
            if ($ds == 1) return false;

            for ($i=0; $i < $dsCounts[$ds]; $i++) { 
                $n = $n - $ds + 1;
                
                if ($n >= 1) $expectedNumCount -= 1;
                else return false;

                if ($expectedNumCount == 0) return true;
            }
        }

        return false;
    }

    private static function resolveDivitionForOnlyIntegers($dsOrder) {
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
                $num = ENGINE_AUTOMCQ::generateRandNum($ds);
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

    private static function generateRandNum($ds) {
        if ($ds <= 0) return NAN;
    
        $min = pow(10, $ds - 1);
        $max = pow(10, $ds) - 1;

        return mt_rand($min, $max);
    }
}