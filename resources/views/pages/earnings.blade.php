@extends('userpage')
@section('title', 'Earnings')
@section('user_content')
<div class="flex flex-col gap-6">
    @include('component.boxes', [
        'iconUrl' => 'https://api.iconify.design/clarity/coin-bag-solid.svg',
        'boxName' => 'Earnings',
        'amount' => number_format($totalEarnings, 2),
        'addButtonIcon' => 'https://api.iconify.design/lets-icons/add-duotone.svg'
    ])

    @if(!empty($earnings) && count($earnings) > 0)
        @include('component.table', [
            'colTitle' => 'IN ID',
            'earnings' => $earnings
        ])
    @else
        <div class="bg-white rounded-lg p-8 text-center text-gray-500">
            No earnings recorded yet.
        </div>
    @endif
</div>
@endsection