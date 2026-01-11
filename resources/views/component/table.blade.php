<div class="show opacity-0 flex flex-col gap-3" data-delay="0.3">
    <p class="text-xl font-bold lato-normal">Transaction History</p>

    <!-- HISTORY TABLE -->
    <div id="tableWrapper" class="h-[50vh] overflow-y-auto rounded-xl p-3">
        <table class="table-auto w-full text-center border-collapse">
            <thead id="tableHead" class="sticky top-0 z-10 transition-all duration-300 ease-in-out">
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
                <tr class="table-row opacity-0 text-sm" data-delay="{{ $loop->iteration * 0.3 }}">
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
                            <span class="text {{ $row['type'] === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $row['type'] === 'income' ? '+' : '-' }}
                                ₱{{ number_format($row['amount'], 0) }}
                            </span>
                            <input type="number" name="amount" class="text-center input hidden focus:outline-none rounded text-black" value="{{ $row['amount'] }}" required>
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
                    <td colspan="5" class="px-4 py-6 text-gray-500">
                        No records yet.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>