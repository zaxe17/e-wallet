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
                <div class="bg-white/30 backdrop-blur-3xl rounded-xl input-shadow flex justify-center items-center py-16 cursor-pointer transition-all duration-300 ease-in-out hover:scale-105">
                    <span class="icon bg-[#b4b4b4] transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/lets-icons/add-duotone.svg'); --size: 135px; --icon-color: black;"></span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection