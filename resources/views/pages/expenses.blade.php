@extends('userpage')
@section('title', 'Expenses')
@section('user_content')
<div class="flex flex-col gap-6">
    @include('component.boxes', [
    'iconUrl' => 'https://api.iconify.design/icon-park-outline/expenses.svg',
    'boxName' => 'Expenses',
    'amount' => number_format($totalExpenses, 2),
    'addButtonIcon' => 'https://api.iconify.design/lets-icons/add-duotone.svg',
    'dataTarget' => 'modalNewExpenses'
    ])

    @include('component.table', [
    'title' => 'Expenses',
    'expenses' => $expenses
    ])
</div>

<!-- ADD MODAL -->
@include('component.inputpopup', [
'title' => 'New Expenses',
'routesName' => 'expenses.store',
'targetBtn' => 'modalNewExpenses',
'fields' => [
['label' => 'Date', 'type' => 'date', 'name' => 'date_spent'],
['label' => 'Category', 'type' => 'text', 'name' => 'category'],
['label' => 'Amount', 'type' => 'number', 'name' => 'amount', 'step' => '0.01'],
]
])
@endsection