@extends('userpage')
@section('title', 'Dashboard')
@section('user_content')
<h1 class="text-3xl mb-3 lato-normal">Hello, {{ $user ? $user : 'User' }}!</h1>

<div class="flex flex-col">
    <div class="show flex flex-col justify-center items-start gap-4 opacity-0">
        <h1 class="text-xl lato-bold border border-b-[#485349] border-transparent border-solid w-full">This {{ $monthList }}</h1>
        <div class="w-full flex flex-col items-center">
            <div class="w-full">
                <canvas id="dayChart" class="w-full h-64" data-chart='@json($dailyEarnings)'></canvas>
            </div>
        </div>
    </div>

    <div class="flex flex-col gap-4">
        <div class="show input-shadow opacity-0 bg-transparent flex flex-col rounded-lg p-4" data-delay="0.6">
            <div class="flex justify-start items-center gap-3">
                <span class="icon bg-[#ffa93f] transition-all duration-300 ease-in-out group-hover:bg-[#485349]" style="--svg: url('https://api.iconify.design/streamline-ultimate/presentation-projector-screen-budget-analytics-bold.svg'); --size: 18px; --icon-color: black;"></span>
                <p class="font-extrabold text-xl lato-normal">Remaining Budget</p>
            </div>
            <!-- OUTPUT BOX -->
            <div class="bg-white rounded-sm px-6 py-1.5 flex items-center justify-between">
                <div class="text-lg flex items-center justify-start gap-2 lato-bold">
                    <!-- AMOUNT -->
                    <span class="icon bg-black transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/pepicons-pop/peso.svg'); --size: 18px; --icon-color: black;"></span>
                    <span>{{ number_format($remainingBudget, 0) }}</span>
                </div>
                <span>{{ $budgetRemarks }}</span>
            </div>
        </div>

        {{-- 3 BOXES --}}
        <div class="grid grid-cols-3 gap-4">
            {{-- EARNINGS --}}
            <div class="up opacity-0" data-delay="0.9">
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
            <div class="up opacity-0" data-delay="1.2">
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
            <div class="up opacity-0" data-delay="1.5">
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
</div>


@include('component.rollover')
@endsection