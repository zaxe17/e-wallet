@extends('userpage')
@section('title', 'Savings')
@section('user_content')

<!-- Success/Error Messages -->
@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
    <span class="block sm:inline">{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
    <span class="block sm:inline">{{ session('error') }}</span>
</div>
@endif

@if($errors->any())
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="flex flex-col gap-6">
    <div class="bg-transparent flex flex-col px-12 py-6 rounded-lg input-shadow">
        <!-- HEADER -->
        <div class="flex justify-start items-center gap-3">
            <span class="icon bg-[#ffa93f] transition-all duration-300 ease-in-out group-hover:bg-[#485349]" style="--svg: url('https://api.iconify.design/tdesign/saving-pot-filled.svg'); --size: 24px; --icon-color: black;"></span>
            <p class="font-extrabold text-2xl lato-normal">Savings</p>
            <!-- EYE TOGGLE BUTTON -->
            <span id="toggleSavings" class="icon bg-[#3a3a3a] transition-all duration-300 ease-in-out cursor-pointer" style="--svg: url('https://api.iconify.design/mdi/eye-off.svg'); --size: 24px; --icon-color: black;" onclick="toggleSavingsVisibility();"></span>
        </div>
        <!-- OUTPUT BOX -->
        <div class="bg-white my-4 rounded-sm px-7 py-2.5 flex items-center justify-between">
            <div class="text-2xl flex items-center justify-start gap-2 lato-bold font-bold">
                <!-- AMOUNT -->
                <span class="icon bg-black transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/pepicons-pop/peso.svg'); --size: 24px; --icon-color: black;"></span>
                <span id="savingsAmount" class="hidden">{{ number_format($totalSavings, 2) }}</span>
                <span id="savingsHidden">********</span>
            </div>
        </div>
    </div>

    <div class="flex flex-col gap-3 h-[55vh]">
        <p class="text-xl font-bold lato-normal">Breakdown</p>
        <!-- SCROLLABLE -->
        <div class="h-full overflow-y-auto p-3">
            <div class="grid grid-cols-3 gap-6">
                @if(!empty($savings) && count($savings) > 0)
                    @foreach($savings as $saving)
                    <!-- SAVINGS BOX -->
                    <div class="bg-white/30 backdrop-blur-3xl rounded-xl input-shadow p-6 flex flex-col gap-3.5 cursor-pointer transition-all duration-300 ease-in-out hover:scale-105">
                        <div class="bg-[#f5f5f5] px-7 py-3 flex items-center justify-between rounded-lg">
                            <div class="flex items-center gap-2 text-lg font-bold">
                                <span class="icon bg-black transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/pepicons-pop/peso.svg'); --size: 18px; --icon-color: black;"></span>
                                {{ number_format($saving->total_with_interest, 2) }}
                            </div>
                            <!-- PLUS BUTTON -->
                            <div class="flex items-center gap-2">
                                <div class="bg-[#b4b4b4] rounded-full p-1.5 cursor-pointer transition-all duration-300 ease-in-out hover:bg-[#9a9a9a] flex items-center justify-center">
                                    <span class="icon bg-white transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/mdi/plus.svg'); --size: 18px; --icon-color: black;"></span>
                                </div>
                            </div>
                        </div>
                        <!-- BOX CONTENT DATA -->
                        <div class="h-full flex justify-center flex-col bg-[#e7e7e7] px-6 py-3 rounded-lg">
                            <p class="">Principal: <span class="font-medium">₱{{ number_format($saving->savings_amount, 2) }}</span></p>
                            <p class="">Interest earned: <span class="font-medium">₱{{ number_format($saving->interest_earned, 2) }} ({{ $saving->interest_rate }}%)</span></p>
                            <p class="">Bank: <span class="font-medium">{{ $saving->bank ?? 'N/A' }}</span></p>
                            <p class="">Description: <span class="font-medium">{{ $saving->description ?? 'N/A' }}</span></p>
                            <p class="text-xs text-gray-600 mt-2">Date: {{ date('M j, Y', strtotime($saving->date_of_save)) }}</p>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-span-2 bg-white/30 backdrop-blur-3xl rounded-xl input-shadow p-8 text-center text-gray-500">
                        No savings recorded yet.
                    </div>
                @endif

                <!-- ADD BUTTON -->
                <div id="openModal" class="bg-white/30 backdrop-blur-3xl rounded-xl input-shadow flex justify-center items-center py-16 cursor-pointer transition-all duration-300 ease-in-out hover:scale-105">
                    <span class="icon bg-[#b4b4b4] transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/lets-icons/add-duotone.svg'); --size: 135px; --icon-color: black;"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ADD SAVINGS MODAL -->
<div id="modalOverlay" class="hidden">
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-black/45 w-full h-screen flex justify-center items-center z-50">
        <div class="bg-[#F5F5F5]/50 form-shadow rounded-2xl px-28 py-11 backdrop-blur-sm">
            <h1 class="text-xl text-center mb-10 lato-normal font-semibold">Add New Savings</h1>

            <form id="savingsForm" class="flex flex-col gap-5">
                <div class="flex justify-between items-center gap-16">
                    <label for="bank" class="text-xl lato-normal font-semibold">Bank</label>
                    <input type="text" name="bank" id="bank" class="w-3xs h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none">
                </div>
                <div class="flex justify-between items-center gap-16">
                    <label for="date_of_save" class="text-xl lato-normal font-semibold">Date</label>
                    <input type="date" name="date_of_save" id="date_of_save" class="w-3xs h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none" value="{{ date('Y-m-d') }}">
                </div>
                <div class="flex justify-between items-center gap-16">
                    <label for="savings_amount" class="text-xl lato-normal font-semibold">Savings Amount</label>
                    <input type="number" step="0.01" name="savings_amount" id="savings_amount" class="w-3xs h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none" required>
                </div>
                <div class="flex justify-between items-center gap-16">
                    <label for="description" class="text-xl lato-normal font-semibold">Category</label>
                    <input type="text" name="description" id="description" class="w-3xs h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none">
                </div>
                <div class="flex justify-between items-center gap-16">
                    <label for="interest_rate" class="text-xl lato-normal font-semibold">Interest Rate</label>
                    <input type="number" step="0.01" name="interest_rate" id="interest_rate" class="w-3xs h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none">
                </div>

                <div class="flex justify-center items-center gap-9 mt-5">
                    <button type="button" id="cancelBtn" class="bg-white/20 border-2 border-[#485349] border-solid text-[#485349] w-22 h-9 rounded-lg cursor-pointer lato-normal">Cancel</button>
                    <button type="button" id="addBtn" class="bg-[#485349] text-white w-22 h-9 rounded-lg cursor-pointer lato-normal">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- PIN MODAL -->
<div id="pinModal" class="hidden">
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-black/45 w-full h-screen flex justify-center items-center z-[60]">
        <div class="bg-[#F5F5F5]/50 form-shadow rounded-2xl px-28 py-11 backdrop-blur-sm">
            <h1 class="text-xl text-center mb-10 lato-normal font-semibold">Enter PIN to Confirm</h1>

            <form id="pinForm" action="{{ route('savings.store') }}" method="POST" class="flex flex-col gap-5">
                @csrf
                <!-- Hidden fields to store form data -->
                <input type="hidden" name="bank" id="hidden_bank">
                <input type="hidden" name="date_of_save" id="hidden_date_of_save">
                <input type="hidden" name="savings_amount" id="hidden_savings_amount">
                <input type="hidden" name="description" id="hidden_description">
                <input type="hidden" name="interest_rate" id="hidden_interest_rate">

                <div class="flex flex-col items-center gap-5">
                    <label for="passkey" class="text-xl lato-normal font-semibold">PIN (4 digits)</label>
                    <input type="password" name="passkey" id="passkey" maxlength="4" pattern="[0-9]{4}" class="w-48 h-12 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-4 py-2 text-2xl text-center tracking-widest focus:outline-none" placeholder="••••" required autofocus>
                </div>

                <div class="flex justify-center items-center gap-9 mt-5">
                    <button type="button" id="pinCancelBtn" class="bg-white/20 border-2 border-[#485349] border-solid text-[#485349] w-22 h-9 rounded-lg cursor-pointer lato-normal">Cancel</button>
                    <button type="submit" class="bg-[#485349] text-white w-22 h-9 rounded-lg cursor-pointer lato-normal">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection