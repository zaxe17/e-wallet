@extends('userpage')
@section('title', 'Earnings')
@section('user_content')
<div class="flex flex-col gap-6">
    @include('component.boxes', [
    'iconUrl' => 'https://api.iconify.design/clarity/coin-bag-solid.svg',
    'boxName' => 'Earnings',
    'amount' => number_format($totalEarnings, 2),
    'addButtonIcon' => 'https://api.iconify.design/lets-icons/add-duotone.svg',
    'dataTarget' => 'modalNewEarnings'
    ])

    @include('component.table', [
    'title' => 'Earnings',
    'earnings' => $earnings
    ])
</div>

<!-- ADD MODAL -->
@include('component.inputpopup', [
'title' => 'New Earnings',
'targetBtn' => 'modalNewEarnings',
'fields' => [
['label' => 'Date', 'type' => 'date', 'name' => ''],
['label' => 'Category', 'type' => 'text', 'name' => ''],
['label' => 'Amount', 'type' => 'number', 'name' => ''],
]
])
@endsection