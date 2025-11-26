<div class="flex flex-col gap-3">
    <p class="text-xl font-bold lato-normal">Transaction History</p>

    <!-- HISTORY TABLE -->
    <div id="tableWrapper" class="h-[50vh] overflow-y-auto rounded-xl p-3">
        <table class="table-auto w-full text-center border-collapse">
            <thead id="tableHead" class="sticky top-0 z-10 transition-all duration-300 ease-in-out">
                <tr class="text-xl">
                    <th class="px-4 py-2 font-normal">{{ $colTitle }}</th>
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
                @if(isset($earnings))
                    @foreach($earnings as $earning)
                    <tr class="text-sm">
                        <td class="px-4 py-2">{{ $earning->in_id }}</td>
                        <td class="px-4 py-2">{{ date('F j, Y', strtotime($earning->date_received)) }}</td>
                        <td class="px-4 py-2">{{ $earning->income_source }}</td>
                        <td class="px-4 py-2 text-green-600 font-semibold">+ ₱{{ number_format($earning->amount, 0) }}</td>
                        <td class="py-2 cursor-pointer"><span class="icon bg-[#3a3a3a] transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/lucide/edit.svg'); --size: 20px; --icon-color: black;"></span></td>
                        <td class="pr-4 py-2 cursor-pointer"><span class="icon bg-[#3a3a3a] transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/weui/delete-filled.svg'); --size: 20px; --icon-color: black;"></span></td>
                    </tr>
                    @endforeach
                @endif

                @if(isset($expenses))
                    @foreach($expenses as $expense)
                    <tr class="text-sm">
                        <td class="px-4 py-2">{{ $expense->out_id }}</td>
                        <td class="px-4 py-2">{{ date('F j, Y', strtotime($expense->date_out)) }}</td>
                        <td class="px-4 py-2">{{ $expense->category_expense }}</td>
                        <td class="px-4 py-2 text-red-600 font-semibold">- ₱{{ number_format($expense->cashout_amount, 0) }}</td>
                        <td class="py-2 cursor-pointer"><span class="icon bg-[#3a3a3a] transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/lucide/edit.svg'); --size: 20px; --icon-color: black;"></span></td>
                        <td class="pr-4 py-2 cursor-pointer"><span class="icon bg-[#3a3a3a] transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/weui/delete-filled.svg'); --size: 20px; --icon-color: black;"></span></td>
                    </tr>
                    @endforeach
                @endif

                @if(isset($savings))
                    @foreach($savings as $saving)
                    <tr class="text-sm">
                        <td class="px-4 py-2">{{ $saving->savingsno }}</td>
                        <td class="px-4 py-2">{{ date('F j, Y', strtotime($saving->date_of_save)) }}</td>
                        <td class="px-4 py-2">{{ $saving->bank ?? $saving->description }}</td>
                        <td class="px-4 py-2 text-blue-600 font-semibold">₱{{ number_format($saving->savings_amount, 2) }}</td>
                        <td class="px-4 py-2 text-green-500 text-xs">+₱{{ number_format($saving->interest_earned, 2) }} ({{ $saving->interest_rate }}%)</td>
                        <td class="py-2 cursor-pointer"><span class="icon bg-[#3a3a3a] transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/lucide/edit.svg'); --size: 20px; --icon-color: black;"></span></td>
                        <td class="pr-4 py-2 cursor-pointer"><span class="icon bg-[#3a3a3a] transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/weui/delete-filled.svg'); --size: 20px; --icon-color: black;"></span></td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>