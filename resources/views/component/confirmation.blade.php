<div id="deleteModal" class="hidden">
    <div class="fixed top-0 left-0 w-full h-screen bg-black/45 flex justify-center items-center z-50 backdrop-blur-[2px]">
        <div class="w-2/5 bg-[#FFF9F5]/80 form-shadow rounded-2xl px-5 py-11 backdrop-blur-sm">
            <h1 class="text-2xl text-center text-[#1F1F1F] mb-2 lato-normal font-semibold">Are you sure?</h1>
            <div class="flex flex-col mx-10">
                <p class="text-center text-[#4c4c4c] font-bold mb-10">
                    Are you sure you want to delete this? This action cannot be undone.
                </p>
                <div class="flex justify-center items-center gap-3">
                    <button id="cancelDeleteBtn" type="button" class="border-2 border-[#1F1F1F] text-[#1F1F1F] font-bold w-1/2 h-13 rounded-lg cursor-pointer">
                        Cancel
                    </button>
                    <button id="confirmDeleteBtn" type="button" class="bg-[#FF3071] text-[#FFFFFF] font-bold w-1/2 h-13 rounded-lg cursor-pointer">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>