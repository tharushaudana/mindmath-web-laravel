@extends('student.student')

@section('content')
    <div class="w-100 h-100" style="position: relative; background-image: url('{{ asset('assets/student/images/bg3.jpg') }}'); background-color: rgba(237,228,255,1); background-blend-mode: lighten;">
        <div style="height: 10px;"></div>
        <div class="px-4 py-2 w-100 d-flex justify-content-between align-items-center" style="background-color: #FFE5AD; border: 1px solid #6F61C0; color: #6528F7;">
            <div>
                <span style="font-size: 10px;">Mind<b>Math</b> MCQ Engine</span>
                <br>
                <h3><b>Test No 02</b></h3>
            </div>
            <span style="font-size: 30px;">
                1<span style="opacity: 0.6">:</span>59<span style="opacity: 0.6">:</span>00&nbsp;&nbsp;<i class="fa-solid fa-stopwatch" style="opacity: 0.8;"></i>
            </span>
        </div>
        <div class="w-100 mt-3" style="position: absolute; display: flex; justify-content: center; align-items: center; height: 68%;">
            <div class="card h-100 border-0 rounded-5 py-5 px-3" style="position: absolute; transform: translateY(30px); width: 65%; box-shadow: 0 1px 1px rgba(0,0,0,0.12), 0 2px 2px rgba(0,0,0,0.12);">
                <div class="card-body">
                    dsds kk
                </div>
            </div>
            <div class="card h-100 border-0 rounded-5 py-5 px-3" style="position: absolute; transform: translateY(15px); width: 70%; box-shadow: 0 1px 1px rgba(0,0,0,0.12), 0 2px 2px rgba(0,0,0,0.12);">
                <div class="card-body">
                    dsds
                </div>
            </div>
            <div class="h-100 py-4" style="position: absolute; width: 75%; transform: translateY(6px);">
                <div style="height: 20px; background-color: #6F61C0; width: 50px; transform: translateX(-7px);">
                    <div class="w-100" style="background-color: #A084E8; height: 6px; border-bottom-left-radius: 15px; border-top-left-radius: 15px; transform: translateY(-3px);"></div>
                </div>
            </div>
            <div class="card h-100 rounded-5 py-3 px-3" style="position: absolute; width: 75%; box-shadow: 0 1px 1px rgba(0,0,0,0.12), 0 2px 2px rgba(0,0,0,0.12);">
                <div class="card-body">
                    <div class="p-3" style="background-color: #6F61C0; color: white; box-shadow: 0px 5px 10px 0px #6F61C0; transform: translateX(-40px); width: calc(100% + 40px); border-top-right-radius: 10px; border-bottom-right-radius: 10px; border-bottom-left-radius: 4px;">
                        <div class="w-100 d-flex justify-content-between align-items-center">
                            <span style="font-size: 14px; opacity: 0.8;"><i class="fa-solid fa-stopwatch"></i>&nbsp;&nbsp;5 secs</span>
                            <span style="font-size: 14px; opacity: 0.8;"><b>10</b> of 40</span>
                        </div>
                        <div class="mt-2"></div>
                        What is the answer? 
                        <div style="font-weight: bold;">
                            <table>
                                <tr>
                                    <td><span class="p-2" style="font-size: 40px">50</span></td>
                                    <td><span style="font-size: 25px; color: #FFE5AD;"><i class="fa-sharp fa-solid fa-plus"></i></span></td>
                                    <td><span class="p-2" style="font-size: 40px">40</span></td>
                                    <td><span style="font-size: 25px; color: #FFE5AD;"><i class="fa-sharp fa-solid fa-minus"></i></span></td>
                                    <td><span class="p-2" style="font-size: 40px">3</span></td>
                                    <td><span style="font-size: 25px; color: #FFE5AD;"><i class="fa-sharp fa-solid fa-xmark"></i></span></td>
                                    <td><span class="p-2" style="font-size: 40px">30</span></td>
                                    <td><span style="font-size: 25px; color: #FFE5AD;"><i class="fa-sharp fa-solid fa-divide"></i></span></td>
                                    <td><span class="p-2" style="font-size: 40px">5</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="w-100 px-4 py-3 rounded-4 mb-2" style="background-color: #EDE4FF; color: #6F61C0; font-weight: bold; position: relative;">
                            300
                            <span style="position: absolute; right: 0; margin-right: 20px;"><i class="fa-solid fa-chevron-right"></i></span>
                        </div>
                        <div class="w-100 px-4 py-3 rounded-4 mb-2" style="background-color: #EDE4FF; color: #6F61C0; font-weight: bold; position: relative;">
                            400
                            <span style="position: absolute; right: 0; margin-right: 20px;"><i class="fa-solid fa-chevron-right"></i></span>
                        </div>
                        <div class="w-100 px-4 py-3 rounded-4 mb-2" style="background-color: #EDE4FF; color: #6F61C0; font-weight: bold; position: relative;">
                            500
                            <span style="position: absolute; right: 0; margin-right: 20px;"><i class="fa-solid fa-chevron-right"></i></span>
                        </div>
                        <div class="w-100 px-4 py-3 rounded-4 mb-2" style="background-color: #EDE4FF; color: #6F61C0; font-weight: bold; position: relative;">
                            600
                            <span style="position: absolute; right: 0; margin-right: 20px;"><i class="fa-solid fa-chevron-right"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-100" style="position: absolute; bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="rounded-pill" style="width: 180px; height: 60px; border: 1px solid #6F61C0; padding: 1px 4px;">
                <div class="rounded-pill" style="width: 100%; height: 100%; border: 1px solid #6F61C0; padding: 1px 4px;">
                    <div class="rounded-pill" style="width: 100%; height: 100%; border: 1px solid #6F61C0; padding: 1px 4px;">
                        <button class="rounded-pill" style="width: 100%; height: 100%; border: none; color: white; background-color: #6F61C0; padding: 1px 4px; box-shadow: 0px 5px 10px 0px #6F61C0; font-weight: bold;">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection