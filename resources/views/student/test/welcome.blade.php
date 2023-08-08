@extends('student.student')

@section('content')
    <div class="w-100 h-100" style="position: relative; background-image: url('{{ asset('assets/student/images/bg3.jpg') }}'); background-color: rgba(237,228,255,1); background-blend-mode: lighten;">
        <div class="w-100 h-100" style="position: absolute; display: flex; justify-content: center; align-items: center;">
            <div class="rounded-5 shadow-lg p-0" style="width: 300px; height: 400px; backdrop-filter: blur(5px); position: relative; border: 1px solid #A076F9;">
                @if (is_null(Auth::guard('student')->user()->currentAttempt()))
                    @if (Auth::guard('student')->user()->attempts->count() < $test->max_attempts)
                        <div class="w-100 p-3">
                            <h1 class="mt-3" align="center" style="color: #6528F7;">
                                <b>{{ $test->name }}</b>
                                <br>
                                <span class="text-muted" style="font-size: 14px; font-weight: bold;">{{ $test->type->description }}</span>
                            </h1>
                            @if (Auth::guard('student')->user()->attempts->count() > 0)
                            <p class="text-danger" align="center" style="font-size: 12px;">
                                {{ Auth::guard('student')->user()->attempts->count() }} attempt(s) already used.
                                <br>
                                <b>{{ $test->max_attempts - Auth::guard('student')->user()->attempts->count() }} more attempts left.</b>
                            </p>
                            @endif
                            <ul class="mt-4">
                                <li><span><b style="color: #6528F7;">{{ $test->config->num_questions }}</b> Questions</span></li>
                                <li><span><b style="color: #6528F7;">{{ $test->config->dur_per }} secs</b> for Per Question</span></li>        
                                <li><span><b style="color: #6528F7;">{{ \Carbon\CarbonInterval::seconds($test->config->totalDurationInSecs())->cascade()->forHumans(['join' => true, 'parts' => 2, 'long' => true ]) }}</b> of Total Duration</span></li>
                            </ul>
                        </div>

                        <div class="w-100" style="position: absolute; bottom: 30px; display: flex; justify-content: center; align-items: center;">
                            <form method="POST" action="{{ route('student.test.ready', $test->id) }}">
                                @csrf
                                <button class="btn btn-outline-primary rounded-pill">I'M READY</button>
                            </form>
                        </div>                        
                    @else
                        <h1 class="mt-3" align="center" style="color: #6528F7;">
                            <b>{{ $test->name }}</b>
                            <br>
                            <span class="text-muted" style="font-size: 14px; font-weight: bold;">{{ $test->type->description }}</span>
                        </h1>
                        <h5 align="center" class="text-danger mt-3"><b>No more Attempts for You!</b></h5>
                    @endif
                @else
                    <div class="w-100 p-3">
                        <h1 class="mt-3" align="center" style="color: #6528F7;">
                            <b>{{ $test->name }}</b>
                            <br>
                            <span class="text-muted" style="font-size: 14px; font-weight: bold;">{{ $test->type->description }}</span>
                        </h1>

                        <div>
                            <h5 align="center" class="text-danger mt-3"><b>Already Attempted</b></h5>

                            @if (Auth::guard('student')->user()->attempts->count() > 1)
                            <p class="text-danger" align="center" style="font-size: 12px;">attempt <b>#{{ Auth::guard('student')->user()->attempts->count() }}</b></p>
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
                    </div>

                    <div class="w-100" style="position: absolute; bottom: 30px; display: flex; justify-content: center; align-items: center;">
                        <form method="POST" action="{{ route('student.test.ready', $test->id) }}">
                            @csrf
                            <button class="btn btn-warning rounded-pill">GO QUICK</button>
                        </form>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection