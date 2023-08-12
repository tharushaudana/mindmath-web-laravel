@extends('admin.admin')

@section('title', 'Manage Test / '.$test->name)

@section('content')
    @livewire('admin.manage.tests.test', [
        'test' => $test
    ])
@endsection