<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() {
        /*if (!Auth::check()) {
            return redirect()->route('student.login');
        }*/

        $me = Auth::guard('student')->user();

        return view('student.home', [
            'me' => $me,
            'upcommingTests' => Test::upcommingTests(),
            'ongoingTests' => Test::ongoingTests(),
            'marksData' => $this->calcMarksData($me),
        ]);
    }

    private function calcMarksData($me) {
        $recentFinishedMcqAttempts = $me->recentFinishedAttempts(1);
      
        $mcqMarksChartData = $this->genChartData($recentFinishedMcqAttempts);
        $mcqMarksWholeChange = $this->wholeMarksChange($mcqMarksChartData['marks']);

        return [
            'mcq' => [
                'chartData' => json_encode($mcqMarksChartData),
                'marksChange' => $mcqMarksWholeChange,
            ],
        ];
    }

    private function genChartData($attempts) {
        $chartData = [
            'labels' => [],
            'marks' => []
          ];
      
        foreach ($attempts as $a) {
            array_push($chartData['labels'], $a->test->name);
            array_push($chartData['marks'], $a->calcMarks());
        }
      
        return $chartData;
    }

    function wholeMarksChange($marks) {
        $totalTests = count($marks);

        if ($totalTests < 2) return 0;

        $totalPercentageChange = 0;
  
        for ($i = 1; $i < $totalTests; $i++) {
            $previousMark = $marks[$i - 1];
            $currentMark = $marks[$i];
            
            $percentageChange = $currentMark - $previousMark;
            $totalPercentageChange += $percentageChange;
        }
  
        return $totalPercentageChange / ($totalTests - 1);
    }
}
