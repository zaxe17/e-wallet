<div id="{{ $targetBtn }}" class="modal hidden">
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-black/45 w-full h-screen flex justify-center items-center z-50 backdrop-blur-[2px]">
        <div class="openModal bg-[#F5F5F5]/80 form-shadow rounded-2xl px-28 py-11 backdrop-blur-sm">
            <h1 class="text-xl text-center mb-10 lato-normal font-semibold">Add {{ $title }}</h1>

            <form method="POST" action="{{ route($routesName) }}" class="flex flex-col gap-5">
                @csrf
                @foreach ($fields as $field)
                <div class="flex justify-between items-center gap-16">
                    <label for="{{ $field['name'] }}" class="text-xl lato-normal font-semibold">{{ $field['label'] }}</label>
                    <input oninput="capitalizeInput(this)" type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}" class="w-3xs h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none" {{ isset($field['required']) && $field['required'] ? 'required' : '' }} {{ isset($field['step']) ? 'step=' . $field['step'] : '' }}>
                </div>
                @endforeach

                <div class="flex justify-center items-center gap-9 mt-5">
                    <button type="button" data-target="{{ $targetBtn }}" class="cancelBtn bg-white/20 border-2 border-[#485349] border-solid text-[#485349] w-22 h-9 rounded-lg cursor-pointer lato-normal">Cancel</button>
                    <button type="submit" class="bg-[#485349] text-white w-22 h-9 rounded-lg cursor-pointer lato-normal">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>