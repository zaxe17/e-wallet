<div id="pinModal" class="hidden">
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-black/45 w-full h-screen flex justify-center items-center z-50 backdrop-blur-[2px]">
        <div class="openModal bg-[#F5F5F5]/80 form-shadow rounded-2xl px-15 py-11 backdrop-blur-sm">
            <h1 class="text-xl text-center mb-10 lato-normal font-semibold">Enter savings PIN</h1>

            <div class="flex flex-col gap-5">
                <div class="flex justify-center">
                    <div class="grid grid-cols-4 gap-6 text-3xl">
                        <div class="pin-box flex justify-center items-center rounded-xl w-12 h-12 border-3 border-[#485349] border-solid"></div>
                        <div class="pin-box flex justify-center items-center rounded-xl w-12 h-12 border-3 border-[#485349] border-solid"></div>
                        <div class="pin-box flex justify-center items-center rounded-xl w-12 h-12 border-3 border-[#485349] border-solid"></div>
                        <div class="pin-box flex justify-center items-center rounded-xl w-12 h-12 border-3 border-[#485349] border-solid"></div>
                    </div>
                </div>

                <div class="grid grid-cols-3 text-3xl gap-x-10">
                    <button type="button" class="cursor-pointer p-5" onclick="addDigit(1)">1</button>
                    <button type="button" class="cursor-pointer p-5" onclick="addDigit(2)">2</button>
                    <button type="button" class="cursor-pointer p-5" onclick="addDigit(3)">3</button>

                    <button type="button" class="cursor-pointer p-5" onclick="addDigit(4)">4</button>
                    <button type="button" class="cursor-pointer p-5" onclick="addDigit(5)">5</button>
                    <button type="button" class="cursor-pointer p-5" onclick="addDigit(6)">6</button>

                    <button type="button" class="cursor-pointer p-5" onclick="addDigit(7)">7</button>
                    <button type="button" class="cursor-pointer p-5" onclick="addDigit(8)">8</button>
                    <button type="button" class="cursor-pointer p-5" onclick="addDigit(9)">9</button>

                    <button type="button" id="cancelPinBtn" class="cursor-pointer text-xl">Cancel</button>
                    <button type="button" onclick="addDigit(0)">0</button>
                    <button type="button" onclick="removeDigit()">←</button>
                </div>
            </div>
        </div>
    </div>
</div>