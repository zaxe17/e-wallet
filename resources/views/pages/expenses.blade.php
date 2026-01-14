@extends('userpage')
@section('title', 'Expenses')
@section('user_content')
<div class="flex flex-col flex-1 min-h-0 gap-6">
    @include('component.boxdropdown', [
    'iconUrl' => 'https://api.iconify.design/icon-park-outline/expenses.svg',
    'boxName' => 'Total Expenses',
    'amount' => number_format($totalExpenses, 2),
    'addButtonIcon' => 'https://api.iconify.design/lets-icons/add-duotone.svg',
    'dataTarget' => 'modalNewExpenses'
    ])

    @include('component.table', [
    'title' => 'Expenses',
    'rows' => $expensesTable
    ])
</div>

<!-- ADD MODAL -->
@include('component.inputpopup', [
'title' => 'New Expenses',
'routesName' => 'expenses.store',
'targetBtn' => 'modalNewExpenses',
'fields' => [
['label' => 'Date', 'type' => 'date', 'name' => 'date_spent', 'value' => date('Y-m-d')],
['label' => 'Category', 'type' => 'text', 'name' => 'category', 'value' => ''],
['label' => 'Amount', 'type' => 'number', 'name' => 'amount', 'step' => '0.01', 'value' => ''],
]
])
@endsection