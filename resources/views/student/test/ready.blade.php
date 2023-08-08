@extends('student.student')

@section('content')
    <div class="w-100 h-100" style="position: relative; background-image: url('{{ asset('assets/student/images/bg3.jpg') }}'); background-color: rgba(237,228,255,1); background-blend-mode: lighten;">
        <div class="w-100 h-100" style="position: absolute; display: flex; justify-content: center; align-items: center;">
            <div class="rounded-5 shadow-lg p-0" style="width: 300px; height: 400px; backdrop-filter: blur(5px); position: relative; border: 1px solid #A076F9;">
                <div class="w-100 p-3">
                    <h5 class="mt-3 text-muted" align="center"><b>{{ $test->name }}</b></h5>
                </div>

                <div class="w-100 h-100" style="position: absolute; bottom: 30px; display: flex; justify-content: center; align-items: center;">
                    <div class="w-100" style="text-align: center;">
                        <h1 class="mb-3" align="center" style="color: #6528F7;">Good Luck!</h1>
                        <form method="POST" action="{{ route('student.test.attempt', $test->id) }}">
                            @csrf
                            <button class="btn btn-primary">ATTEMPT NOW</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection