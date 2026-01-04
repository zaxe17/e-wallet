<div class="show opacity-0 flex flex-col gap-3" data-delay="0.3">
    <p class="text-xl font-bold lato-normal">Transaction History</p>

    <!-- HISTORY TABLE -->
    <div id="tableWrapper" class="h-[50vh] overflow-y-auto rounded-xl p-3">
        <table class="table-auto w-full text-center border-collapse">
            <thead id="tableHead" class="sticky top-0 z-10 transition-all duration-300 ease-in-out">
                <tr class="text-xl">
                    <th class="px-4 py-2 font-normal">Date</th>
                    <th class="px-4 py-2 font-normal">{{ isset($savings) ? 'Bank/Description' : 'Category' }}</th>
                    <th class="px-4 py-2 font-normal">Amount</th>
                    @if(isset($savings))
                    <th class="px-4 py-2 font-normal">Interest</th>
                    @endif
                    <th class=""></th>
                    <th class=""></th>
                </tr>
            </thead>

            <tbody class="bg-[#d1d1d1]/30 input-shadow">
                @if((!empty($earnings) && count($earnings) > 0) || (!empty($expenses) && count($expenses) > 0))

                {{-- EARNINGS --}}
                @if(!empty($earnings))
                @foreach($earnings as $earning)
                <tr class="table-row opacity-0 text-sm" data-delay="{{ $loop->iteration * 0.3 }}">
                    <!-- DATE -->
                    <td class="px-4 py-2">{{ date('F j, Y', strtotime($earning->date_received)) }}</td>

                    <!-- FOR EDIT -->
                    <form action="{{ route('earnings.update', $earning->in_id) }}" method="POST" class="edit-form contents">
                        @csrf
                        @method('PUT')

                        <!-- INCOME SOURCE -->
                        <td class="px-4 py-2">
                            <span class="text">{{ $earning->income_source }}</span>
                            <input type="text" name="income_source" class="text-center input hidden focus:outline-none rounded" value="{{ $earning->income_source }}" required>
                        </td>

                        <!-- AMOUNT -->
                        <td class="px-4 py-2 amount text-green-600 font-semibold">
                            <span class="text">+ ₱{{ number_format($earning->amount, 0) }}</span>
                            <input type="number" name="amount" class="text-center input hidden focus:outline-none rounded text-black" value="{{ $earning->amount }}" required>
                        </td>

                        <td class="py-2">
                            <!-- EDIT -->
                            <button type="button" class="edit-btn cursor-pointer">
                                <span class="icon bg-[#3a3a3a]"
                                    style="--svg: url('https://api.iconify.design/lucide/edit.svg'); --size: 20px;">
                                </span>
                            </button>

                            <!-- SAVE -->
                            <button type="submit" class="save-btn hidden ml-2 cursor-pointer">
                                <span class="icon bg-green-600"
                                    style="--svg: url('https://api.iconify.design/lucide/check.svg'); --size: 20px;">
                                </span>
                            </button>

                            <!-- CANCEL -->
                            <button type="button" class="cancel-btn hidden ml-1 cursor-pointer">
                                <span class="icon bg-red-600"
                                    style="--svg: url('https://api.iconify.design/lucide/x.svg'); --size: 20px;">
                                </span>
                            </button>
                        </td>
                    </form>

                    <!-- DELETE -->
                    <td class="pr-4 py-2">
                        <form action="{{ route('earnings.delete', $earning->in_id) }}" method="POST" class="inline-block delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="cursor-pointer deleteBtn">
                                <span class="icon bg-[#3a3a3a]" style="--svg: url('https://api.iconify.design/weui/delete-filled.svg'); --size: 20px;"></span>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @endif

                {{-- EXPENSES --}}
                @if(!empty($expenses))
                @foreach($expenses as $expense)
                <tr class="table-row opacity-0 text-sm" data-delay="{{ $loop->iteration * 0.3 }}">
                    <td class="px-4 py-2">{{ date('F j, Y', strtotime($expense->date_spent)) }}</td>

                    <!-- FOR EDIT -->
                    <form action="{{ route('expenses.update', $expense->out_id) }}" method="POST" class="edit-form contents">
                        @csrf
                        @method('PUT')

                        <td class="px-4 py-2">
                            <span class="text">{{ $expense->category }}</span>
                            <input type="text" name="category" class="text-center input hidden focus:outline-none rounded" value="{{ $expense->category }}" required>
                        </td>
                        <td class="px-4 py-2 text-red-600 font-semibold">
                            <span class="text">- ₱{{ number_format($expense->amount, 0) }}</span>
                            <input type="number" name="amount" class="text-center input hidden focus:outline-none rounded text-black" value="{{ $expense->amount }}" required>
                        </td>

                        <td class="py-2 cursor-pointer">
                            <!-- EDIT -->
                            <button type="button" class="edit-btn cursor-pointer">
                                <span class="icon bg-[#3a3a3a]"
                                    style="--svg: url('https://api.iconify.design/lucide/edit.svg'); --size: 20px;">
                                </span>
                            </button>

                            <!-- SAVE -->
                            <button type="submit" class="save-btn hidden ml-2 cursor-pointer">
                                <span class="icon bg-green-600"
                                    style="--svg: url('https://api.iconify.design/lucide/check.svg'); --size: 20px;">
                                </span>
                            </button>

                            <!-- CANCEL -->
                            <button type="button" class="cancel-btn hidden ml-1 cursor-pointer">
                                <span class="icon bg-red-600"
                                    style="--svg: url('https://api.iconify.design/lucide/x.svg'); --size: 20px;">
                                </span>
                            </button>
                        </td>
                    </form>

                    <!-- DELETE -->
                    <td class="pr-4 py-2">
                        <form action="{{ route('expenses.delete', $expense->out_id) }}" method="POST" class="inline-block delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="cursor-pointer deleteBtn">
                                <span class="icon bg-[#3a3a3a]" style="--svg: url('https://api.iconify.design/weui/delete-filled.svg'); --size: 20px;"></span>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @endif

                @else
                {{-- NO RECORDS --}}
                <tr class="text-sm">
                    <td colspan="{{ isset($savings) ? 7 : 6 }}" class="px-4 py-2 text-center text-gray-500">
                        No {{ $title }} Recorded Yet.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>