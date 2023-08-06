<?php

include 'automcq/automcq.php';

class ENGINE_TOOLS {
    public static function fisherYatesShuffle(&$array) {
        $count = count($array);
        
        for ($i = $count - 1; $i > 0; $i--) {
            $randIndex = mt_rand(0, $i);
            
            // Swap elements at $i and $randIndex
            $temp = $array[$i];
            $array[$i] = $array[$randIndex];
            $array[$randIndex] = $temp;
        }
    }

    public static function getResultOfExpression($expression) {
        $expressionWithoutSpaces = str_replace(' ', '', $expression);

        if (preg_match('~^[0-9+\-*/]+$~', $expressionWithoutSpaces)) {
            $result = 0;
            eval("\$result = $expressionWithoutSpaces;");
            return $result;
        } else {
            return NAN;
        }
    }

    public static function toExpression($operations, $numbers) {
        $exp = '';
        
        for ($i=0; $i < count($numbers); $i++) { 
            $exp .= $numbers[$i];
            if ($i <= count($operations) - 1) 
                $exp .= $operations[$i];
        }

        return $exp;
    }
}