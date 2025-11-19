@extends('main')
@section('title', 'Dashboard')
@section('content')
<div class="bg-[#485349] h-screen flex">
    @include('component.sidebar')
    <div class="w-full h-screen bg-[url('/public/assets/PAYNOY_bg.png')] bg-center bg-cover rounded-l-4xl">

        @include('component.dashboardnav')

        <div class="">
            
        </div>
        
    </div>
</div>
@endsection 