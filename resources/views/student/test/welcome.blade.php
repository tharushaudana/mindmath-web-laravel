@extends('student.student-bt5')

@section('content')
    <div class="w-100 h-100" style="position: relative; background-image: url('{{ asset('assets/student/images/bg3.jpg') }}'); background-color: rgba(237,228,255,1); background-blend-mode: lighten;">
        <div class="w-100 h-100" style="position: absolute; display: flex; justify-content: center; align-items: center;">
            <div class="rounded-5 shadow-lg p-0" style="width: 300px; backdrop-filter: blur(5px); position: relative; border: 1px solid #A076F9;">
                <div class="w-100">
                    <h1 class="mt-3 p-3" align="center" style="color: #6528F7;">
                        <b>{{ $test->name }}</b>
                        <br>
                        <span class="text-muted" style="font-size: 14px; font-weight: bold;">{{ $test->type->description }}</span>
                    </h1>

                    @if (is_null(Auth::guard('student')->user()->currentAttempt()))
                        @if ($test->isOpen())
                            @if (Auth::guard('student')->user()->attempts($test)->count() < $test->max_attempts)
                                <div class="p-3">
                                    @if (Auth::guard('student')->user()->attempts($test)->count() > 0)
                                    <p class="text-danger" align="center" style="font-size: 12px;">
                                        {{ Auth::guard('student')->user()->attempts($test)->count() }} attempt(s) already used.
                                        <br>
                                        <b>{{ $test->max_attempts - Auth::guard('student')->user()->attempts($test)->count() }} more attempts left.</b>
                                    </p>
                                    @endif
                                    <ul class="mt-4">
                                        <li><span><b style="color: #6528F7;">{{ $test->config->num_questions }}</b> Questions</span></li>
                                        <li><span><b style="color: #6528F7;">{{ $test->config->dur_per }} secs</b> for Per Question</span></li>        
                                        <li><span><b style="color: #6528F7;">{{ \Carbon\CarbonInterval::seconds($test->config->totalDurationInSecs())->cascade()->forHumans(['join' => true, 'parts' => 2, 'long' => true ]) }}</b> of Total Duration</span></li>
                                    </ul>
                                </div>

                                <div style="height: 30px;"></div>

                                <div class="w-100" style="display: flex; justify-content: center; align-items: center;">
                                    <form method="POST" action="{{ route('student.test.ready', $test->id) }}">
                                        @csrf
                                        <button class="btn btn-outline-primary rounded-pill">I'M READY</button>
                                    </form>
                                </div>                        
                            @else
                                <h5 align="center" class="text-danger mt-3"><b>No more Attempts for You!</b></h5>
                            @endif
                        @else
                            @if ($test->isClosed())
                            <h5 align="center" class="text-danger mt-3"><b>Test Closed</b></h5>
                            <p class="text-danger" align="center" style="font-size: 12px;">Can't attempt at this time.</p>
                            @else
                            <p class="text-danger" align="center" style="font-size: 12px;">Not Opened Yet</p>
                            <p align="center">
                                <span style="font-size: 14px;">Sheduled to</span>
                                <br>
                                <b>{{ \Carbon\Carbon::parse($test->open_at)->format('F j \a\t g:i A') }}</b>
                            </p>
                            @endif
                        @endif

                        <div style="height: 20px;"></div>

                        @php
                            $acount = Auth::guard('student')->user()->attempts($test)->count();
                        @endphp
                        
                        @if ($acount > 0)
                            <div class="p-3" style="border-top: 1px solid #A076F9;">
                                @foreach (Auth::guard('student')->user()->attempts($test) as $i => $attempt)
                                <div class="card mb-1" style="background-color: #8BE8E5; {{ $i == 0 ? 'border: 2px solid #A076F9;' : 'border: none;' }}">
                                    <div class="card-body p-1 d-flex justify-content-between align-items-center">
                                        <span style="font-size: 13px;">Attempt #{{ $acount - $i }}</span>
                                        <span style="font-size: 13px; font-weight: bold;">{{ $attempt->calcMarks() }} %</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="p-3">
                            <h5 align="center" class="text-danger mt-3"><b>Already Attempted</b></h5>

                            @if (Auth::guard('student')->user()->attempts($test)->count() > 1)
                            <p class="text-danger" align="center" style="font-size: 12px;">attempt <b>#{{ Auth::guard('student')->user()->attempts($test)->count() }}</b></p>
                            @endif

                            <p class="text-muted mt-5" align="center" style="font-size: 12px;">time left</p>
                            <p align="center" style="font-size: 20px; font-weight: bold; font-family: 'Courier New', Courier, monospace;">
                                <span id="left-hrs" style="color: #6528F7">_</span>
                                <span style="color: #A076F9">:</span>
                                <span id="left-mins" style="color: #6528F7">_</span>
                                <span style="color: #A076F9">:</span>
                                <span id="left-secs" style="color: #6528F7">_</span>
                            </p>
                        </div>

                        @push('scripts')
                        <script>
                            var secs = {{ \Carbon\Carbon::parse(Auth::guard('student')->user()->currentAttempt()->expire_at)->diffInSeconds(\Carbon\Carbon::now()) }};
                            
                            const interval = setInterval(() => {
                                secs--;

                                var h = parseInt(secs / 3600);
                                var m = parseInt((secs % 3600) / 60);
                                var s = secs - h*3600 - m*60;

                                if (secs >= 0) {
                                    $('#left-hrs').html(`${('00'+h).slice(-2)}`);
                                    $('#left-mins').html(`${('00'+m).slice(-2)}`);
                                    $('#left-secs').html(`${('00'+s).slice(-2)}`);
                                }

                                if (secs == -1) {
                                    clearInterval(interval);
                                    location.reload();
                                } 
                            }, 1000);
                        </script>
                        @endpush

                        <div style="height: 40px;"></div>

                        <div class="w-100" style="display: flex; justify-content: center; align-items: center;">
                            <a href="{{ route('student.test.questions.automcq', $test->id) }}"><button class="btn btn-warning rounded-pill">GO QUICK</button></a>
                        </div>

                        <div style="height: 20px;"></div>
                    @endif

                </div>

            </div>
        </div>
    </div>
@endsection