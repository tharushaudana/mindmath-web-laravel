@extends('student.student-bt5')

@section('content')
    <div class="h-100 w-100 bg-body-tertiary" style="">
        <div class="h-100 w-100" style="position: absolute; display: flex; align-items: center; justify-content: center;">
            <div class="p-4" style="width: 400px;">
                <h3 class="text-muted" align="center">Mind<b>Math</b> Student</h3>
                <br>
                @livewire('student.login-register')
            </div>
        </div>
    </div>
@endsection