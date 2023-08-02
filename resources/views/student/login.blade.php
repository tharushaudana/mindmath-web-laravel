@extends('student.student')

@section('content')
    <div class="h-100 w-100 bg-dark" style="background-image: url('{{ asset('assets/student/images/bg.jpg') }}');">
        <div class="h-100 w-100" style="position: absolute; display: flex; align-items: center; justify-content: center;">
            @livewire('student.login-register')
        </div>
    </div>
@endsection