@extends('userpage')
@section('title', 'Savings')
@section('user_content')
<div class="flex flex-col gap-6">
    @include('component.boxes', [
    'iconUrl' => 'https://api.iconify.design/tdesign/saving-pot-filled.svg',
    'boxName' => 'Savings',
    'amount' => '1,000,000.00',
    'addButtonIcon' => ''
    ])

    <div class="flex flex-col gap-3 h-[55vh]">
        <p class="text-xl font-bold lato-normal">Breakdown</p>
        <!-- SCROLABBLE -->
        <div class="h-full overflow-y-auto p-3">
            <div class="grid grid-cols-3 gap-6">
                <!-- SAVINGS BOX -->
                <div class="bg-white/30 backdrop-blur-3xl rounded-xl input-shadow p-6 flex flex-col gap-3.5 cursor-pointer transition-all duration-300 ease-in-out hover:scale-105">
                    <div class="bg-[#f5f5f5] px-7 py-3 flex items-center justify-between rounded-lg">
                        <div class="flex items-center gap-2 text-lg">
                            <span class="icon bg-black transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/pepicons-pop/peso.svg'); --size: 18px; --icon-color: black;"></span>
                            1,000,000.00
                        </div>
                        <!-- ADD BUTTON AMOUNT -->
                        <span class="icon bg-black transition-all duration-300 ease-in-out cursor-pointer" style="--svg: url('https://api.iconify.design/lets-icons/add-duotone.svg'); --size: 30px; --icon-color: black;"></span>
                    </div>
                    <!-- BOX CONTENT DATA -->
                    <div class="h-full flex justify-center flex-col bg-[#e7e7e7] px-6 py-3 rounded-lg">
                        <span class="font-medium">1,000,000.00</span>
                        <p class="">Interest earned: <span class="font-medium">10.5</span></p>
                        <p class="">Bank: <span class="font-medium">BPI</span></p>
                        <p class="">Category: <span class="font-medium">travel</span></p>
                    </div>
                </div>

                <!-- ADD BUTTON -->
                <div id="openModal" class="bg-white/30 backdrop-blur-3xl rounded-xl input-shadow flex justify-center items-center py-16 cursor-pointer transition-all duration-300 ease-in-out hover:scale-105">
                    <span class="icon bg-[#b4b4b4] transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/lets-icons/add-duotone.svg'); --size: 135px; --icon-color: black;"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalOverlay" class="hidden">
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-black/45 w-full h-screen flex justify-center items-center z-50">
        <div class="bg-[#F5F5F5]/50 form-shadow rounded-2xl px-28 py-11 backdrop-blur-sm">
            <h1 class="text-xl text-center mb-10 lato-normal font-semibold">Add New Savings</h1>

            <form action="" class="flex flex-col gap-5">
                <div class="flex justify-between items-center gap-16">
                    <label for="" class="text-xl lato-normal font-semibold">Bank</label>
                    <input type="text" class="w-3xs h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none">
                </div>
                <div class="flex justify-between items-center gap-16">
                    <label for="" class="text-xl lato-normal font-semibold">Date</label>
                    <input type="date" class="w-3xs h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none">
                </div>
                <div class="flex justify-between items-center gap-16">
                    <label for="" class="text-xl lato-normal font-semibold">Savings Amount</label>
                    <input type="text" class="w-3xs h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none">
                </div>
                <div class="flex justify-between items-center gap-16">
                    <label for="" class="text-xl lato-normal font-semibold">Category</label>
                    <input type="text" class="w-3xs h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none">
                </div>
                <div class="flex justify-between items-center gap-16">
                    <label for="" class="text-xl lato-normal font-semibold">Interest Rate</label>
                    <input type="text" class="w-3xs h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none">
                </div>

                <div class="flex justify-center items-center gap-9 mt-5">
                    <button type="reset" id="cancelBtn" class="bg-white/20 border-2 border-[#485349] border-solid text-[#485349] w-22 h-9 rounded-lg cursor-pointer lato-normal">Cancel</button>
                    <button type="submit" class="bg-[#485349] text-white w-22 h-9 rounded-lg cursor-pointer lato-normal">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection