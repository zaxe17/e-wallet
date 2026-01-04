@extends('main')
@section('content')
<div class="bg-[#485349] h-screen flex">
    @include('component.sidebar')
    <div class="relative w-full h-screen bg-white rounded-l-4xl overflow-hidden">
        <div class="absolute inset-0 h-screen overflow-hidden">
            <div class="absolute top-1/2 left-1/3 w-[60%] h-[60%] -translate-y-1/2 -translate-x-1/2 bg-[#b1d0ab] rounded-full blur-[120px] opacity-0 ball-green"></div>

            <div class="absolute top-[70%] left-[72%] w-[35%] h-[35%] -translate-y-1/2 -translate-x-1/2 bg-[#f7eaa2] rounded-full blur-[120px] opacity-0 ball-yellow"></div>
        </div>

        @include('component.dashboardnav')

        <div class="relative container h-screen mx-auto px-14">
            @yield('user_content')
        </div>

        @include('component.pin')
    </div>
</div>

@include('component.messagepopup')
@include('component.confirmation')
@endsection