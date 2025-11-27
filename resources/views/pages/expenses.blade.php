@extends('userpage')
@section('title', 'Expenses')
@section('user_content')
<div class="flex flex-col gap-6">
    @include('component.boxes', [
    'iconUrl' => 'https://api.iconify.design/icon-park-outline/expenses.svg',
    'boxName' => 'Expenses',
    'amount' => number_format($totalExpenses, 2),
    'addButtonIcon' => 'https://api.iconify.design/lets-icons/add-duotone.svg'
    ])

    @include('component.table', [
    'title' => 'Expenses',
    'expenses' => $expenses
    ])
</div>

<!-- ADD MODAL -->
@include('component.inputpopup', [
'title' => 'Expenses',
'fields' => [
['label' => 'Date', 'type' => 'date', 'name' => ''],
['label' => 'Category', 'type' => 'text', 'name' => ''],
['label' => 'Amount', 'type' => 'number', 'name' => ''],
]
])
@endsection