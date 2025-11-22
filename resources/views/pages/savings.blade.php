@extends('userpage')
@section('title', 'Savings')
@section('user_content')
<div class="flex flex-col gap-6">
    @include('component.boxes', [
        'iconUrl' => 'https://api.iconify.design/tdesign/saving-pot-filled.svg',
        'boxName' => 'Savings',
        'amount' => '1,000,000.00'
    ])

    <div class="grid grid-cols-3 gap-6">

    </div>
</div>
@endsection