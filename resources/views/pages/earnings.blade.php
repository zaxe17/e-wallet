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

    @include('component.table', [
    'colTitle' => 'IN ID',
    'idData' => 'IN-000004',
    'dateData' => 'October 6, 2025',
    'categoryData' => 'Allowance',
    'amountData' => '2,000'
    ])
</div>
@endsection