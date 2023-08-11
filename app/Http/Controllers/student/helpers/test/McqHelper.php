<?php

use App\Models\McqQuestion;

class McqHelper {
    public static function init($test, $attempt) {
        if ($test->config->questions($attempt)->count() > 0) return false;

        $struct = json_decode($test->config->struct, true);

        $questions = [];

        foreach ($struct as $item) {
            $nq = intval($item['nq']);
            $oo = explode(',', $item['oo']);
            $do = array_map('intval', explode(',', $item['do']));
            $io = $item['io'] == 1;
            $soo = $item['soo'] == 1;
            $sdo = $item['sdo'] == 1;

            $fails = 0;
    
            $previousOpOrders = [];
            $previousNumberSets = [];
    
            for ($i=0; $i < $nq; $i++) {             
                $fails = 0;
    
                do {
                    $q = ENGINE_AUTOMCQ::generateQuestion($oo, $do, $soo, $sdo, 1, 4);
                    $fails++;
                } while (in_array($q[0], $previousOpOrders) && in_array($q[1], $previousNumberSets));
    
                //if ($fails >= 1000) break;
    
                array_push($previousOpOrders, $q[0]);
                array_push($previousNumberSets, $q[1]);
    
                $answers = $q[2];
    
                $exp = ENGINE_TOOLS::toExpression($q[0], $q[1]);

                $question = new McqQuestion();

                $question->mcq_test_id = $test->config->id;
                $question->attempt_id = $attempt->id;
                $question->question = $exp;
                $question->answers = json_encode($answers[0]);
                $question->correct_answer = array_search($answers[1], $answers[0]);
    
                array_push($questions, $question);
            }
        }

        //### save in database

        $collection = collect($questions);

        $collection->each(function ($model) {
            $model->save();
        });

        return true;
    }
}