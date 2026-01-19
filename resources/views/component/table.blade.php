<div class="flex flex-col flex-1 min-h-0">
    <p class="show opacity-0 text-xl font-bold lato-normal" data-delay="0.3">Transaction History</p>

    <!-- HISTORY TABLE -->
    <div id="tableWrapper" class="flex-1 min-h-0 overflow-y-auto rounded-xl px-3 pb-3">
        <table class="table-auto w-full text-center border-collapse">
            <thead id="tableHead" class="show opacity-0 sticky top-0 z-10 transition-all duration-300 ease-in-out" data-delay="0.6">
                <tr class="text-xl">
                    @if($title === 'History')
                    <th class="px-4 py-2 font-normal">Section</th>
                    @endif
                    <th class="px-4 py-2 font-normal">Date</th>
                    <th class="px-4 py-2 font-normal">{{ isset($savings) ? 'Bank/Description' : 'Category' }}</th>
                    <th class="px-4 py-2 font-normal">Amount</th>
                    <th class=""></th>
                    <th class=""></th>
                </tr>
            </thead>

            <tbody class="bg-[#d1d1d1]/30 input-shadow">
                @if(!empty($rows) && count($rows))

                @foreach($rows as $row)
                <tr class="show table-row opacity-0 text-sm" data-delay="0.2">
                    @if($title === 'History')
                    <td class="px-4 py-2 font-semibold">{{ $row['section'] ?? '' }}</td>
                    @endif
                    
                    <td class="px-4 py-2">{{ date('F j, Y', strtotime($row['date'])) }}</td>

                    <!-- FOR EDIT -->
                    <form action="{{ $row['update'] }}" method="POST" class="edit-form contents">
                        @csrf
                        @method('PUT')

                        <td class="px-4 py-2">
                            <span class="text">{{ $row['label'] }}</span>
                            <input type="text" name="{{ $row['type'] === 'income' ? 'income_source' : 'category' }}" class="text-center input hidden focus:outline-none rounded" value="{{ $row['label'] }}" required>
                        </td>
                        <td class="px-4 py-2 font-semibold">
                            <span class="text {{ $row['type'] === 'income' ? 'text-green-600' : ($row['type'] === 'savings' ? 'text-blue-600' : 'text-red-600') }}">
                                {{ $row['type'] === 'income' ? '+' : ($row['type'] === 'savings' ? '+' : '-') }}
                                ₱{{ number_format($row['amount'], 0) }}
                            </span>
                            <input type="number" name="amount" class="text-center input hidden focus:outline-none rounded text-black" value="{{ $row['amount'] }}" required>
                        </td>

                        <td class="py-2 cursor-pointer {{ $title === 'History' ? 'hidden' : ''}}">
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
                    <td class="pr-4 py-2 {{ $title === 'History' ? 'hidden' : ''}}">
                        <form action="{{ $row['delete'] }}" method="POST" class="inline-block delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="cursor-pointer deleteBtn">
                                <span class="icon bg-[#3a3a3a]" style="--svg: url('https://api.iconify.design/weui/delete-filled.svg'); --size: 20px;"></span>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach

                @else
                <tr>
                    <td colspan="{{ $title === 'History' ? '6' : '5' }}" class="px-4 py-6 text-gray-500">
                        No records yet.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>