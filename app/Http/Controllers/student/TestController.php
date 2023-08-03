<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Test $test) {
        return 'dsds';
    }

    public function generateQuestion($nplus, $nminus, $nmultiply, $ndivition, $opOder, $digitsOrder, $shuffleDigitsOrder) {

    }

    public function generateOperationsArray($nplus, $nminus, $nmultiply, $ndivition, $opOder) {
        if (!is_null($opOder)) return explode(',', $opOder);

        $arr = [];

        //array_push($arr,  array_fill($nplus, $repeatCount, $element));
    }
}
