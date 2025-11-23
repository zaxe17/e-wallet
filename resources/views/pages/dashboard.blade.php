@extends('userpage')
@section('title', 'Dashboard')
@section('user_content')
<h1 class="text-3xl mb-14 lato-normal">Hello, Jan Marc!</h1>

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
            <div class="text-3xl pt-7 flex items-center justify-start gap-2 lato-bold"><span class="icon bg-black transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/pepicons-pop/peso.svg'); --size: 30px; --icon-color: black;"></span>10,000.00</div>
            <div class="text-[#76b068] pb-2.5 flex items-center justify-end lato-bold">20, 000 - 10, 000</div>
        </div>
        <!-- SUB-HEADING -->
        <p class="text-sm font-light lato-normal">It’s a good idea to save this in your account!</p>
    </div>

    <!-- 3 BOXES -->
    <div class="grid grid-cols-3 gap-6">
        <a class="block transition-all duration-300 ease-in-out hover:scale-105" href="{{ route('earnings.index') }}">
            @include('component.boxes', [
                'iconUrl' => 'https://api.iconify.design/clarity/coin-bag-solid.svg',
                'boxName' => 'Earnings',
                'amount' => '10,000.00',
                'addButtonIcon' => ''
            ])
        </a>
        <a class="block transition-all duration-300 ease-in-out hover:scale-105" href="{{ route('savings.index') }}">
            @include('component.boxes', [
                'iconUrl' => 'https://api.iconify.design/tdesign/saving-pot-filled.svg',
                'boxName' => 'Savings',
                'amount' => '********',
                'addButtonIcon' => ''
            ])
        </a>
        <a class="block transition-all duration-300 ease-in-out hover:scale-105" href="{{ route('expenses.index') }}">
            @include('component.boxes', [
                'iconUrl' => 'https://api.iconify.design/icon-park-outline/expenses.svg',
                'boxName' => 'Expenses',
                'amount' => '40,000.00',
                'addButtonIcon' => ''
            ])
        </a>
    </div>
</div>
@endsection