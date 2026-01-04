@extends('userpage')
@section('title', 'Earnings')
@section('user_content')
<div class="flex flex-col gap-6">
    @include('component.boxes', [
        'iconUrl' => 'https://api.iconify.design/clarity/coin-bag-solid.svg',
        'boxName' => 'Total Earnings',
        'amount' => number_format($totalEarnings, 2),
        'addButtonIcon' => 'https://api.iconify.design/lets-icons/add-duotone.svg',
        'dataTarget' => 'modalNewEarnings'
    ])

    @include('component.table', [
        'title' => 'Earnings History',
        'earnings' => $earnings
    ])
</div>

<!-- ADD MODAL -->
@include('component.inputpopup', [
    'title' => 'New Earnings',
    'routesName' => 'earnings.store',
    'targetBtn' => 'modalNewEarnings',
    'fields' => [
        ['label' => 'Date Received', 'type' => 'date', 'name' => 'date_received', 'value' => date('Y-m-d'), 'required' => true],
        ['label' => 'Income Source', 'type' => 'text', 'name' => 'income_source', 'value' => '', 'required' => true],
        ['label' => 'Amount', 'type' => 'number', 'name' => 'amount', 'step' => '0.01', 'value' => '', 'required' => true],
    ]
])
@endsection