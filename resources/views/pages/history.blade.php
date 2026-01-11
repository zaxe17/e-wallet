@extends('userpage')
@section('title', 'Dashboard')
@section('user_content')
<h1 class="text-3xl mb-3 lato-normal">Hello, {{ $user ? $user : 'User' }}!</h1>

<div class="flex flex-col">
    <div class="show flex flex-col justify-center items-start gap-4 opacity-0">
        <div class="flex justify-between items-center 
        border border-b-[#485349] border-transparent border-solid w-full">
            <h1 class="text-xl lato-bold">Wallet History</h1>
            <p class="">This Year</p>
        </div>
        <div class="w-full flex flex-col items-center">
            <div class="w-full">
                <canvas id="lineChart" class="w-full h-64" data-chart='@json($chartData)'></canvas>
            </div>
        </div>
    </div>

    @include('component.table', [
    'title' => 'History',
    'earnings' => ''
    ])
</div>
@endsection