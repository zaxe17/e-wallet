<div id="{{ $targetBtn }}" class="modal hidden">
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-black/45 w-full h-screen flex justify-center items-center z-50 backdrop-blur-[2px]">
        <div class="openModalBtn bg-[#F5F5F5]/80 form-shadow rounded-2xl px-28 py-11 backdrop-blur-sm">
            <div class="flex justify-center gap-5 mb-6">
                <!-- Deposit Button -->
                <button type="button" id="depositBtn" class="text-2xl text-white px-9 py-2 bg-[#485349] rounded-2xl transition-all duration-300 ease-in-out border-2 border-[#485349] border-solid">Deposit</button>

                <!-- Withdrawal Button -->
                <button type="button" id="withdrawalBtn" class="text-2xl text-[#485349] px-9 py-2 rounded-2xl transition-all duration-100 ease-in-out border-2 border-[#485349] border-solid">Withdrawal</button>
            </div>

            <!-- Deposit -->
            <form id="depositForm" method="POST" action="" class="flex flex-col gap-5">
                @csrf
                <div class="flex justify-between items-center gap-16">
                    <label for="" class="text-xl lato-normal font-semibold">Bank</label>
                    <input oninput="capitalizeInput(this)" type="text" name="bank" value="" id="" class="w-3xs h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none">
                </div>
                <div class="flex justify-between items-center gap-16">
                    <label for="" class="text-xl lato-normal font-semibold">Date</label>
                    <input oninput="capitalizeInput(this)" type="date" name="date_of_save" value="" id="" class="w-3xs h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none">
                </div>
                <div class="flex justify-between items-center gap-16">
                    <label for="" class="text-xl lato-normal font-semibold">Savings amount</label>
                    <input oninput="capitalizeInput(this)" type="number" name="savings_amount" value="" id="" class="w-3xs h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none">
                </div>
                <div class="flex justify-between items-center gap-16">
                    <label for="" class="text-xl lato-normal font-semibold">Category</label>
                    <input oninput="capitalizeInput(this)" type="text" name="description" value="" id="" class="w-3xs h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none">
                </div>
                <div class="flex justify-between items-center gap-16">
                    <label for="" class="text-xl lato-normal font-semibold">Interest rate</label>
                    <input oninput="capitalizeInput(this)" type="number" name="interest_rate" value="" id="" class="w-3xs h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none">
                </div>

                <div class="flex justify-center items-center gap-9 mt-5">
                    <button type="button" data-target="{{ $targetBtn }}" class="cancelBtn bg-white/20 border-2 border-[#485349] border-solid text-[#485349] w-22 h-9 rounded-lg cursor-pointer lato-normal">Cancel</button>
                    <button type="submit" class="bg-[#485349] text-white w-22 h-9 rounded-lg cursor-pointer lato-normal">Add</button>
                </div>
            </form>

            <!-- WITHDRAWAL -->
            <div id="withdrawalForm" class="hidden">
                <form method="POST" action="" class="flex flex-col gap-5">
                    @csrf
                    <div class="flex justify-between items-center gap-16">
                        <label for="" class="text-xl lato-normal font-semibold">Bank</label>
                        <input oninput="capitalizeInput(this)" type="text" name="bank" id="" class="w-3xs h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none">
                    </div>
                    <div class="flex justify-between items-center gap-16">
                        <label for="" class="text-xl lato-normal font-semibold">Date</label>
                        <input oninput="capitalizeInput(this)" type="date" name="date_of_save" id="" class="w-3xs h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none">
                    </div>
                    <div class="flex justify-between items-center gap-16">
                        <label for="" class="text-xl lato-normal font-semibold">Savings amount</label>
                        <input oninput="capitalizeInput(this)" type="number" name="savings_amount" id="" class="w-3xs h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none">
                    </div>

                    <div class="flex justify-center items-center gap-9 mt-5">
                        <button type="button" data-target="{{ $targetBtn }}" class="cancelBtn bg-white/20 border-2 border-[#485349] border-solid text-[#485349] w-22 h-9 rounded-lg cursor-pointer lato-normal">Cancel</button>
                        <button type="submit" class="bg-[#485349] text-white w-22 h-9 rounded-lg cursor-pointer lato-normal">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>