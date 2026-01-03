@extends('userpage')
@section('title', 'Dashboard')
@section('user_content')
<h1 class="text-3xl mb-7 lato-normal">Hello, {{ $user ? explode(' ', $user->full_name)[0] : 'User' }}!</h1>

<div class="flex flex-col gap-6">
    <div class="show flex flex-col justify-center items-start gap-4 opacity-0">
        <h1 class="text-xl lato-bold border border-b-[#485349] border-transparent border-solid w-full">This {{ $monthList }}</h1>
        <div class="w-full flex flex-col items-center">
            <div class="w-full">
                <canvas id="lineChart" class="w-full h-64" data-chart='@json($chartData)'></canvas>
            </div>
        </div>
    </div>

    {{-- 3 BOXES --}}
    <div class="grid grid-cols-3 gap-6">
        {{-- EARNINGS --}}
        <div class="up opacity-0" data-delay="0.6">
            <a class="block transition-all duration-300 ease-in-out hover:scale-105" href="{{ route('earnings.index') }}">
                @include('component.boxes', [
                'iconUrl' => 'https://api.iconify.design/clarity/coin-bag-solid.svg',
                'boxName' => 'Earnings',
                'amount' => number_format($totalEarnings ?? 0, 2),
                'addButtonIcon' => '',
                'dataTarget' => ''
                ])
            </a>
        </div>
        {{-- SAVINGS --}}
        <div class="up opacity-0" data-delay="0.9">
            <a class="openPinModalBtn block transition-all duration-300 ease-in-out hover:scale-105">
                @include('component.boxes', [
                'iconUrl' => 'https://api.iconify.design/tdesign/saving-pot-filled.svg',
                'boxName' => 'Savings',
                'amount' => number_format($totalSavings ?? 0, 2),
                'addButtonIcon' => '',
                'viewButton' => '',
                'dataTarget' => ''
                ])
            </a>
        </div>
        {{-- EXPENSES --}}
        <div class="up opacity-0" data-delay="1.2">
            <a class="block transition-all duration-300 ease-in-out hover:scale-105" href="{{ route('expenses.index') }}">
                @include('component.boxes', [
                'iconUrl' => 'https://api.iconify.design/icon-park-outline/expenses.svg',
                'boxName' => 'Expenses',
                'amount' => number_format($totalExpenses ?? 0, 2),
                'addButtonIcon' => '',
                'dataTarget' => ''
                ])
            </a>
        </div>
    </div>
</div>
@endsection