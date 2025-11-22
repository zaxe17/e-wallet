@extends('userpage')
@section('title', 'Earnings')
@section('user_content')
<div class="flex flex-col gap-6">
    @include('component.boxes', [
        'iconUrl' => 'https://api.iconify.design/clarity/coin-bag-solid.svg',
        'boxName' => 'Earnings',
        'amount' => '10,000.00'
    ])

    <div class="grid grid-cols-3 gap-6">
        
    </div>
</div>
@endsection