<div id="{{ $targetBtn }}" class="modal hidden">
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-black/45 w-full h-screen flex justify-center items-center z-50 backdrop-blur-[2px]">
        <div class="openModal bg-[#F5F5F5]/80 form-shadow rounded-2xl px-28 py-11 backdrop-blur-sm">
            <h1 class="text-xl text-center mb-10 lato-normal font-semibold">{{ $title }}</h1>

            <!-- Add/Edit Form -->
            <form method="POST" action="" class="flex flex-col gap-5 add-edit-form">
                @csrf
                @method('PUT')
                <input type="hidden" name="savingsno" value="">

                @foreach ($fields as $field)
                <div class="flex justify-between items-center gap-16">
                    <label class="text-xl lato-normal font-semibold">
                        {{ $field['label'] }}
                    </label>

                    <div class="flex justify-end items-center gap-2 w-3xs">
                        <input
                            type="{{ $field['type'] }}"
                            name="{{ $field['name'] }}"
                            id="{{ $field['name'] }}"
                            value="{{ $field['value'] ?? date('Y-m-d') }}"
                            @if(!empty($field['readonly'])) readonly @endif
                            @if($field['name']==='interest_rate' )
                            inputmode="decimal"
                            pattern="^[0-9]+(\.[0-9]{1,2})?$"
                            @else
                            oninput="capitalizeInput(this)"
                            @endif
                            class="w-3xs h-8 rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none {{ !empty($field['readonly']) ? 'bg-gray-200 cursor-not-allowed' : 'bg-white/30 backdrop-blur-[15px]' }}"
                            {{ isset($field['required']) && $field['required'] ? 'required' : '' }}
                            {{ isset($field['step']) ? 'step=' . $field['step'] : '' }}>

                        @if($field['name'] === 'interest_rate' && $title === 'Edit Rate')
                        <button type="button" class="changeBtn text-[#485349] underline text-sm cursor-pointer">
                            change?
                        </button>
                        @endif
                    </div>
                </div>
                @endforeach

                <!-- SAVE SECTION -->
                <div class="saveSection hidden">
                    <div class="flex justify-center items-center gap-9 mt-5">
                        <button type="button" class="cancelEditBtn bg-white/20 border-2 border-[#485349] text-[#485349] w-22 h-9 rounded-lg">
                            Cancel
                        </button>
                        <button type="submit" class="bg-[#485349] text-white w-22 h-9 rounded-lg">
                            Save
                        </button>
                    </div>
                </div>
            </form>

            <!-- DELETE SECTION -->
            @if($title === 'Edit Rate')
            <div class="deleteSection flex justify-center items-center gap-9 mt-10">
                <button type="button" data-target="{{ $targetBtn }}" class="cancelBtn bg-white/20 border-2 border-[#485349] text-[#485349] w-22 h-9 rounded-lg">
                    Close
                </button>
                <form method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="deleteBtn bg-[#FF3071] text-white w-22 h-9 rounded-lg">
                        Delete
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>