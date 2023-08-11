@extends('student.student')

@section('content')
    <div class="w-100 h-100" style="position: relative; background-image: url('{{ asset('assets/student/images/bg3.jpg') }}'); background-color: rgba(237,228,255,1); background-blend-mode: lighten;">
        <div style="height: 10px;"></div>
        <div class="px-4 w-100 d-flex justify-content-between align-items-center info-box" style="background-color: rgba(255,255,255,0.5); backdrop-filter: blur(10px); color: #6528F7;">
            <div>
                <span style="font-size: 10px;">Mind<b>Math</b> MathExp Engine</span>
                <br>
                <h3 class="test-name"><b>{{ $test->name }}</b></h3>
            </div>
            <span class="time-left">
                1<span style="opacity: 0.6">:</span>59<span style="opacity: 0.6">:</span>00&nbsp;&nbsp;<i class="fa-solid fa-stopwatch" style="opacity: 0.8;"></i>
            </span>
        </div>
        <div class="w-100 mt-3" style="position: relative; display: flex; justify-content: center; align-items: center; height: 68%;">
            <div class="card h-100 border-0 rounded-5 py-5 px-3" style="position: absolute; transform: translateY(30px); width: 75%; box-shadow: 0 1px 1px rgba(0,0,0,0.12), 0 2px 2px rgba(0,0,0,0.12);">
                <div class="card-body"></div>
            </div>
            <div class="card h-100 border-0 rounded-5 py-5 px-3" style="position: absolute; transform: translateY(15px); width: 80%; box-shadow: 0 1px 1px rgba(0,0,0,0.12), 0 2px 2px rgba(0,0,0,0.12);">
                <div class="card-body"></div>
            </div>
            <div class="h-100 py-4" style="position: absolute; width: 85%; transform: translateY(6px);">
                <div style="height: 20px; background-color: #6F61C0; width: 50px; transform: translateX(-7px);">
                    <div class="w-100" style="background-color: #A084E8; height: 6px; border-bottom-left-radius: 15px; border-top-left-radius: 15px; transform: translateY(-3px);"></div>
                </div>
            </div>
            <div class="card h-100 rounded-5 py-3 px-3" style="position: absolute; width: 85%; box-shadow: 0 1px 1px rgba(0,0,0,0.12), 0 2px 2px rgba(0,0,0,0.12);">
                <div class="card-body">
                    <div style="background-color: #6F61C0; color: white; box-shadow: 0px 5px 10px 0px #6F61C0; transform: translateX(-40px); width: calc(100% + 40px); border-top-right-radius: 10px; border-bottom-right-radius: 10px; border-bottom-left-radius: 4px; position: relative; overflow: hidden;">
                        <div class="p-3">
                            <div class="w-100 d-flex justify-content-between align-items-center">
                                <span style="font-size: 14px; opacity: 0.8;"><i class="fa-solid fa-stopwatch"></i>&nbsp;&nbsp;{{ $test->config->dur_per }} secs</span>
                                <span style="font-size: 14px; opacity: 0.8;"><b>{{ $question->qNo() }}</b> of {{ $test->config->num_questions }}</span>
                            </div>
                            <div class="mt-2"></div>
                            What is the answer? 
                            <div style="font-weight: bold;">
                                <table>
                                    @php
                                        $questionItems = str_split($question->question);
    
                                        $symbolNames = [
                                            '+' => 'plus',
                                            '-' => 'minus',
                                            '*' => 'xmark',
                                            '/' => 'divide'
                                        ];
                                    @endphp
    
                                    <tr>
                                        @foreach ($questionItems as $item)
                                            @if (in_array($item, ['+', '-', '*', '/']))
                                            <td><span class="exp-symbol" style="color: #FFE5AD;"><i class="fa-sharp fa-solid fa-{{ $symbolNames[$item] }}"></i></span></td>
                                            @else
                                            <td><span class="p-2 exp-number">{{ $item }}</span></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4" id="answers-container" style="display: {{ $question->isExpired($test->config->dur_per) ? 'none' : 'block' }};">
                        @livewire('student.test.auto-mcq-answer-box', [
                            'question' => $question,
                            'test' => $test,
                            'attempt' => $attempt
                        ])
                    </div>

                    <div class="mt-5" id="expired-container" style="display: {{ $question->isExpired($test->config->dur_per) ? 'block' : 'none' }};">
                        <h5 class="text-danger" style="font-weight: bold;" align="center">Question Expired!</h5>
                        <p class="text-danger" style="font-size: 12px;" align="center">You can't answer to this question. Please click on the <b>Next</b> button for load next question.</p>
                    </div>

                    @push('scripts')
                    <script>
                        const durPer = {{ $test->config->dur_per }};
                        var qMillis = {{ $question->timeLeft($test->config->dur_per) }} * 1000;

                        var selectedAnswer = -1;

                        const qInterval = setInterval(() => {
                            qMillis -= 10;

                            if (qMillis == 0) {
                                $('#answers-container').hide();
                                $('#expired-container').show();
                                clearInterval(qInterval);
                            }
                        }, 10);
                    </script>
                    @endpush
                </div>
            </div>
        </div>
        <div class="w-100 mt-5" style="display: flex; justify-content: center; align-items: center;">
            <div class="rounded-pill" style="width: 180px; height: 60px; border: 1px solid #6F61C0; padding: 1px 4px;">
                <div class="rounded-pill" style="width: 100%; height: 100%; border: 1px solid #6F61C0; padding: 1px 4px;">
                    <div class="rounded-pill" style="width: 100%; height: 100%; border: 1px solid #6F61C0; padding: 1px 4px;">
                        <form method="POST" action="{{ $question->isLast() ? route('student.test.questions.automcq.finish', $test->id) : '' }}" style="width: 100%; height: 100%;">
                            @csrf
                            <button class="rounded-pill" style="width: 100%; height: 100%; border: none; color: white; background-color: #6F61C0; padding: 1px 4px; box-shadow: 0px 5px 10px 0px #6F61C0; font-weight: bold;">
                                {{ $question->isLast() ? 'Finish' : 'Next' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .info-box {
            height: 80px;
        }

        .info-box .time-left {
            font-size: 20px;
        }

        .exp-symbol {
            font-size: 25px;
        }

        .exp-number {
            font-size: 40px;
        }

        .ans-card {
            padding-top: 15px;
            padding-bottom: 15px;
        }

        @media only screen and (max-width: 600px) {
            .info-box {
                height: 50px;
            }

            .info-box .time-left {
                font-size: 15px;
            }

            .info-box .test-name {
                font-size: 17px;
            }

            .exp-symbol {
                font-size: 15px;
            }

            .exp-number {
                font-size: 25px;
            }

            .ans-card {
                padding-top: 10px;
                padding-bottom: 10px;
            }
        }
    </style>
@endpush