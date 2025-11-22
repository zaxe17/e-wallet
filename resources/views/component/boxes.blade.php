<div class="bg-transparent flex flex-col px-12 py-6 rounded-lg" style="box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px, rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;">
    <!-- HEADER -->
    <div class="flex justify-start items-center gap-3">
        <span class="icon bg-[#ffa93f] transition-all duration-300 ease-in-out group-hover:bg-[#485349]" style="--svg: url('{{ $iconUrl }}'); --size: 24px; --icon-color: black;"></span>
        <p class="font-extrabold text-2xl lato-normal">{{ $boxName }}</p>
    </div>
    <!-- OUTPUT BOX -->
    <div class="bg-white my-4 rounded-sm px-7 py-2.5">
        <div class="text-2xl flex items-center justify-start gap-2 lato-bold"><span class="icon bg-black transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/pepicons-pop/peso.svg'); --size: 24px; --icon-color: black;"></span>{{ $amount }}</div>
    </div>
</div>
