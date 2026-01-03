@extends('userpage')
@section('title', 'Savings')
@section('user_content')
<div class="flex flex-col gap-6">
    @include('component.boxes', [
    'iconUrl' => 'https://api.iconify.design/icon-park-outline/expenses.svg',
    'boxName' => 'Savings',
    'amount' => number_format($totalSavings, 2),
    'addButtonIcon' => '',
    'viewButton' => 'https://api.iconify.design/mdi/eye-off.svg',
    'dataTarget' => ''
    ])

    <div class="flex flex-col gap-3 h-[55vh]">
        <p class="show text-xl font-bold lato-normal" data-delay="0.3">Breakdown</p>
        <!-- SCROLLABLE -->
        <div class="h-full overflow-y-auto p-3">
            <div class="grid grid-cols-3 gap-6">
                @foreach($savings as $saving)
                <!-- SAVINGS BOX -->
                <div class="boxes opacity-0" data-delay="{{ $loop->iteration * 0.2 }}">
                    <div class="bg-white/30 h-70 backdrop-blur-3xl rounded-xl input-shadow p-6 flex flex-col gap-3.5 cursor-pointer transition-all duration-300 ease-in-out hover:scale-105">
                        <div class="bg-[#f5f5f5] px-7 py-3 flex items-center justify-between rounded-lg">
                            <div class="flex items-center gap-2 text-lg font-bold">
                                <span class="icon bg-black transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/pepicons-pop/peso.svg'); --size: 18px; --icon-color: black;"></span>
                                {{ number_format($saving->total_with_interest, 2) }}
                            </div>
                            <!-- ADD AMOUNT -->
                            <span class="openModalBtn icon bg-[#4d4d4d] transition-all duration-300 ease-in-out" data-target="modalAmount" style="--svg: url('https://api.iconify.design/lets-icons/add-duotone.svg'); --size: 25px; --icon-color: black;"></span>
                        </div>
                        <!-- BOX CONTENT DATA -->
                        <div class="h-full flex justify-center flex-col bg-[#e7e7e7] px-6 py-3 rounded-lg overflow-y-auto text-sm">
                            <p class="">Principal: <span class="font-medium">₱{{ number_format($saving->savings_amount, 2) }}</span></p>
                            <p class="">Interest earned: <span class="font-medium">₱{{ number_format($saving->interest_earned, 2) }} ({{ $saving->interest_rate }}%)</span></p>
                            <p class="">Bank: <span class="font-medium">{{ $saving->bank ?? 'N/A' }}</span></p>
                            <p class="">Description: <span class="font-medium">{{ $saving->description ?? 'N/A' }}</span></p>
                            <p class="text-xs text-gray-600 mt-2">Date: {{ date('M j, Y', strtotime($saving->date_of_save)) }}</p>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- ADD NEW SAVINGS -->
                <div class="boxes opacity-0">
                    <div class="openModalBtn bg-white/30 h-70 backdrop-blur-3xl rounded-xl input-shadow flex justify-center items-center py-16 cursor-pointer transition-all duration-300 ease-in-out hover:scale-105" data-target="modalNewSavings">
                        <span class="icon bg-[#b4b4b4] transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/lets-icons/add-duotone.svg'); --size: 135px; --icon-color: black;"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ADD NEW SAVINGS -->
@include('component.inputpopup', [
'title' => 'New Savings',
'routesName' => 'savings.store',
'targetBtn' => 'modalNewSavings',
'fields' => [
['label' => 'Bank', 'type' => 'text', 'name' => 'bank'],
['label' => 'Date', 'type' => 'date', 'name' => 'date_of_save'],
['label' => 'Savings Amount', 'type' => 'number', 'name' => 'savings_amount'],
['label' => 'Category', 'type' => 'text', 'name' => 'description'],
['label' => 'Interest Rate', 'type' => 'number', 'name' => 'interest_rate'],
]
])

@include('component.savingsdepwith', [
'title' => 'Amount',
'routesName' => '',
'targetBtn' => 'modalAmount'
])
@endsection