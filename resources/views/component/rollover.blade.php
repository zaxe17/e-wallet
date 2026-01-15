@if($showRollover)
<div class="fixed inset-0 bg-black/45 flex justify-center items-center z-50 backdrop-blur-sm">
    <div class="w-1/3 bg-[#FFF9F5]/80 rounded-2xl px-6 py-10 text-center">

        <h1 class="text-2xl mb-4">Remaining Budget</h1>

        {{-- 🔴 NEGATIVE --}}
        @if($remainingBudget < 0)
            <p class="font-bold text-red-600 mb-6">
                Aww 😢 you overspent last month.
            </p>

            <form method="POST" action="{{ route('dashboard.rollover') }}">
                @csrf
                <button name="decision" value="CLOSE_ONLY"
                    class="bg-gray-700 text-white px-6 py-3 rounded-lg">
                    Continue
                </button>
            </form>

        {{-- 🟡 ZERO --}}
        @elseif($remainingBudget == 0)
            <p class="font-bold text-green-600 mb-6">
                Congrats 🎉 you allocated your money efficiently.
            </p>

            <form method="POST" action="{{ route('dashboard.rollover') }}">
                @csrf
                <button name="decision" value="CLOSE_ONLY"
                    class="bg-gray-700 text-white px-6 py-3 rounded-lg">
                    Continue
                </button>
            </form>

        {{-- 🟢 POSITIVE --}}
        @else
            <p class="font-bold mb-8">
                You have {{ number_format($remainingBudget, 2) }} remaining.<br>
                Where should it go?
            </p>

            <form method="POST" action="{{ route('dashboard.rollover') }}">
                @csrf
                <div class="flex gap-3">
                    <button name="decision" value="SAVED"
                        class="border w-1/2 h-12 rounded-lg">
                        Savings
                    </button>
                    <button name="decision" value="EXPENSE"
                        class="bg-[#FF3071] text-white w-1/2 h-12 rounded-lg">
                        Expense
                    </button>
                </div>
            </form>
        @endif

    </div>
</div>
@endif
