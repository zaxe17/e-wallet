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

    @if(!empty($expenses) && count($expenses) > 0)
        @include('component.table', [
            'colTitle' => 'OUT ID',
            'expenses' => $expenses
        ])
    @else
        <div class="bg-white rounded-lg p-8 text-center text-gray-500">
            No expenses recorded yet.
        </div>
    @endif
</div>
@endsection