@extends('userpage')
@section('title', 'Earnings')
@section('user_content')
<div class="flex flex-col gap-6">
    @include('component.boxes', [
    'iconUrl' => 'https://api.iconify.design/clarity/coin-bag-solid.svg',
    'boxName' => 'Earnings',
    'amount' => '10,000.00',
    'addButtonIcon' => 'https://api.iconify.design/lets-icons/add-duotone.svg'
    ])

    <div class="flex flex-col gap-3">
        <p class="text-xl font-bold lato-normal">Transaction History</p>

        <!-- HISTORY TABLE -->
        <div id="tableWrapper" class="h-[50vh] overflow-y-auto rounded-xl p-3">
            <table class="table-auto w-full text-center border-collapse">
                <thead id="tableHead" class="sticky top-0 z-10 transition-all duration-300 ease-in-out">
                    <tr class="text-xl">
                        <th class="px-4 py-2 font-normal">IN ID</th>
                        <th class="px-4 py-2 font-normal">Date</th>
                        <th class="px-4 py-2 font-normal">Category</th>
                        <th class="px-4 py-2 font-normal">Amount</th>
                        <th class=""></th>
                        <th class=""></th>
                    </tr>
                </thead>
                <tbody class="bg-[#d1d1d1]/30 input-shadow">
                    <tr class="text-sm">
                        <td class="px-4 py-2">IN-000004</td>
                        <td class="px-4 py-2">October 6, 2025</td>
                        <td class="px-4 py-2">Allowance</td>
                        <td class="px-4 py-2 text-green-600 font-semibold">+ P2,000</td>
                        <td class="py-2 cursor-pointer"><span class="icon bg-[#3a3a3a] transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/lucide/edit.svg'); --size: 20px; --icon-color: black;"></span></td>
                        <td class="pr-4 py-2 cursor-pointer"><span class="icon bg-[#3a3a3a] transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/weui/delete-filled.svg'); --size: 20px; --icon-color: black;"></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection