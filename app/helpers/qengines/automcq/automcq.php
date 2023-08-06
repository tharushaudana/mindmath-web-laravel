<?php

class ENGINE_AUTOMCQ {
    public static function generateQuestion($opOrder, $dsOrder, $shuffleOpOrder, $shuffleDsOrder, $integerAnswersOnly) {
        if ($shuffleOpOrder) ENGINE_AUTOMCQ::fisherYatesShuffle($opOrder);
        if ($shuffleDsOrder) ENGINE_AUTOMCQ::fisherYatesShuffle($dsOrder);
        
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

        return [$opOrder, $numbers];
    }

    public static function fixDigitSizeOrderToIntegersOnly(&$dsOrder, $opOrder) {
        if (ENGINE_AUTOMCQ::isDigitSizeOrderValidForOnlyIntegerAnswers($dsOrder, $opOrder)) return true;
        
        do {
            ENGINE_AUTOMCQ::fisherYatesShuffle($dsOrder);
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

    private static function fisherYatesShuffle(&$array) {
        $count = count($array);
        
        for ($i = $count - 1; $i > 0; $i--) {
            $randIndex = mt_rand(0, $i);
            
            // Swap elements at $i and $randIndex
            $temp = $array[$i];
            $array[$i] = $array[$randIndex];
            $array[$randIndex] = $temp;
        }
    }
}