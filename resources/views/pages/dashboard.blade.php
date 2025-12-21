@extends('userpage')
@section('title', 'Dashboard')
@section('user_content')
<h1 class="text-3xl mb-14 lato-normal">Hello, {{ $user ? explode(' ', $user->full_name)[0] : 'User' }}!</h1>

<div class="flex flex-col gap-6">
    <!-- Box -->
    <div class="bg-transparent flex flex-col px-16 py-7 rounded-lg input-shadow">
        <!-- HEADER -->
        <div class="flex justify-start items-center gap-3">
            <span class="icon bg-[#488c42] transition-all duration-300 ease-in-out group-hover:bg-[#485349]" style="--svg: url('https://api.iconify.design/vaadin/wallet.svg'); --size: 20px; --icon-color: black;"></span>
            <p class="font-extrabold text-2xl lato-normal">Remaining Budget for the Month</p>
        </div>
        <!-- OUTPUT BOX -->
        <div class="bg-white my-4 rounded-sm px-8">
            <div class="text-3xl pt-7 flex items-center justify-start gap-2 lato-bold">
                <span class="icon bg-black transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/pepicons-pop/peso.svg'); --size: 30px; --icon-color: black;"></span>
                {{ number_format($remainingBudget, 2) }}
            </div>
            <div class="text-[#76b068] pb-2.5 flex items-center justify-end lato-bold">
                {{ number_format($totalEarnings, 0) }} - {{ number_format($totalExpenses, 0) }}
            </div>
        </div>
        <!-- SUB-HEADING -->
        <p class="text-sm font-light lato-normal">It's a good idea to save this in your account!</p>
    </div>

    <!-- 3 BOXES -->
    <div class="grid grid-cols-3 gap-6">
        <!-- EARNINGS -->
        <a class="block transition-all duration-300 ease-in-out hover:scale-105" href="{{ route('earnings.index') }}">
            @include('component.boxes', [
            'iconUrl' => 'https://api.iconify.design/clarity/coin-bag-solid.svg',
            'boxName' => 'Earnings',
            'amount' => number_format($totalEarnings, 2),
            'addButtonIcon' => '',
            'dataTarget' => ''
            ])
        </a>
        <!-- SAVINGS -->
        <a class="openPinModalBtn block transition-all duration-300 ease-in-out hover:scale-105">
            @include('component.boxes', [
            'iconUrl' => 'https://api.iconify.design/tdesign/saving-pot-filled.svg',
            'boxName' => 'Savings',
            'amount' => number_format($totalSavings, 2),
            'addButtonIcon' => '',
            'viewButton' => '',
            'dataTarget' => ''
            ])
        </a>
        <!-- EXPENSES -->
        <a class="block transition-all duration-300 ease-in-out hover:scale-105" href="{{ route('expenses.index') }}">
            @include('component.boxes', [
            'iconUrl' => 'https://api.iconify.design/icon-park-outline/expenses.svg',
            'boxName' => 'Expenses',
            'amount' => number_format($totalExpenses, 2),
            'addButtonIcon' => '',
            'dataTarget' => ''
            ])
        </a>
    </div>
</div>
@endsection