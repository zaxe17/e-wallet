@extends('userpage')
@section('title', 'Expenses')
@section('user_content')
<div class="flex flex-col gap-6">
    @include('component.boxes', [
    'iconUrl' => 'https://api.iconify.design/icon-park-outline/expenses.svg',
    'boxName' => 'Expenses',
    'amount' => '40,000.00',
    'addButtonIcon' => 'https://api.iconify.design/lets-icons/add-duotone.svg'
    ])

    @include('component.table', [
    'colTitle' => 'OUT ID',
    'idData' => 'OUT-000002',
    'dateData' => 'October 14, 2025',
    'categoryData' => 'Phone',
    'amountData' => '9,750'
    ])
</div>
@endsection