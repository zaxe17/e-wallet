@extends('userpage')
@section('title', 'Expenses')
@section('user_content')
<div class="flex flex-col gap-6">
    @include('component.boxes', [
        'iconUrl' => 'https://api.iconify.design/icon-park-outline/expenses.svg',
        'boxName' => 'Expenses',
        'amount' => '40,000.00',
        'addButtonIcon' => ''
    ])

    <div class="grid grid-cols-3 gap-6">
        
    </div>
</div>
@endsection