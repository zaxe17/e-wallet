<div class="show input-shadow opacity-0 bg-transparent flex flex-col px-12 py-6 rounded-lg" data-delay="0.3">
    <!-- HEADER -->
    <div class="flex justify-start items-center gap-3">
        <span class="icon bg-[#ffa93f] transition-all duration-300 ease-in-out group-hover:bg-[#485349]" style="--svg: url('{{ $iconUrl }}'); --size: 24px; --icon-color: black;"></span>
        <p class="font-extrabold text-2xl lato-normal">{{ $boxName }}</p>

        <!-- EYE TOGGLE BUTTON -->
        @if ($boxName === 'Savings')
        <span id="toggleSavings" class="icon bg-[#3a3a3a] transition-all duration-300 ease-in-out cursor-pointer" style="--svg: url('{{ $viewButton }}'); --size: 24px; --icon-color: black;" onclick="event.preventDefault(); event.stopPropagation(); toggleSavingsVisibility();"></span>
        @endif
    </div>
    <!-- OUTPUT BOX -->
    <div class="bg-white my-4 rounded-sm px-7 py-2.5 flex items-center justify-between">
        <div class="text-2xl flex items-center justify-start gap-2 lato-bold">
            <!-- AMOUNT -->
            <span class="icon bg-black transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/pepicons-pop/peso.svg'); --size: 24px; --icon-color: black;"></span>
            @if ($boxName === 'Savings')
            <span id="savingsAmount" class="hidden">{{ $amount }}</span>
            <span id="savingsHidden">********</span>
            @else
            <span>{{ $amount }}</span>
            @endif
        </div>
        <!-- ADD BUTTON -->
        <span class="openModalBtn icon bg-[#3a3a3a] transition-all duration-300 ease-in-out cursor-pointer" data-target="{{ $dataTarget }}" style="--svg: url('{{ $addButtonIcon }}'); --size: 40px; --icon-color: black;"></span>
    </div>
</div>