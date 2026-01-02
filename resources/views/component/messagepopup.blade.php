@if(session('success'))
<div id="success-message" class="success fixed bottom-0 left-0 m-4 z-50">
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded m-6 flex justify-center items-center gap-5">
        {{ session('success') }}
        <button id="message-close" class="group text-lg text-green-700 hover:text-green-500 flex justify-center items-center">
            <span class="icon bg-green-700 transition-all duration-300 ease-in-out group-hover:bg-[#485349]" style="--svg: url('https://api.iconify.design/lets-icons/close-round-duotone.svg'); --size: 20px; --icon-color: white;"></span>
        </button>
    </div>
</div>
@endif