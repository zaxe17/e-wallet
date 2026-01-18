@extends('userpage')
@section('title', 'Settings')
@section('user_content')
<div class="container mx-auto px-5">
    <div class="flex flex-col flex-1 min-h-0">
        <div class="flex justify-start items-center mb-10">
            <p class="show opacity-0 text-xl text-[#323d33]" data-delay="1.5">Profile</p>
            <div class="line w-0 h-px bg-[#485349]/80 mx-8" data-delay="1.8"></div>
        </div>

        <form action="{{ route('settings.save') }}" method="POST" id="settingsForm" class="flex flex-col gap-6 mb-5 px-20" novalidate>
            @csrf

            <!-- INFORMATION FORM -->
            <div class="grid grid-cols-3 gap-8">
                <div class="show opacity-0 flex flex-col" data-delay="0.3">
                    <label for="" class="text-sm font-bold ml-1.5">Last Name</label>
                    <input type="text" id="" name="last_name" placeholder="" value="{{ $lastName }}" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none" required readonly>
                </div>
                <div class="show opacity-0 flex flex-col" data-delay="0.6">
                    <label for="" class="text-sm font-bold ml-1.5">First Name</label>
                    <input type="text" id="" name="first_name" placeholder="" value="{{ $firstName }}" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none" required readonly>
                </div>
                <div class="show opacity-0 flex flex-col" data-delay="0.9">
                    <label for="" class="text-sm font-bold ml-1.5">Middle Name</label>
                    <input type="text" id="" name="middle_name" placeholder="" value="{{ $middleName }}" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none" required readonly>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-8">
                <div class="show opacity-0 flex flex-col" data-delay="0.3">
                    <label for="" class="text-sm font-bold ml-1.5">Username</label>
                    <input type="text" id="" name="username" placeholder="" value="{{ $user->username }}" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none" required readonly>
                </div>
                <div class="show opacity-0 flex flex-col" data-delay="0.6">
                    <label for="" class="text-sm font-bold ml-1.5">Email address</label>
                    <input type="text" id="" name="email_address" placeholder="" value="{{ $user->email_address }}" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none" required readonly>
                </div>
                <div class="show opacity-0 flex flex-col" data-delay="0.9">
                    <label for="" class="text-sm font-bold ml-1.5">Phone number</label>
                    <input type="text" id="" name="phone_number" placeholder="" value="{{ $user->phone_number }}" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none" required readonly>
                </div>
            </div>

            <div class="show opacity-0 flex justify-end" data-delay="1.2">
                <div id="saveBtn" class="hidden">
                    <div class="flex items-center gap-2">
                        <button type="button" id="cancelBtn" class="flex items-center text-sm text-white px-6 py-1.5 rounded-lg bg-[#6B7C99] cursor-pointer">
                            <span class="icons bg-white mr-2 transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/material-symbols/cancel.svg');"></span>
                            Cancel
                        </button>
                        <button type="submit" class="flex items-center text-sm text-white px-7 py-1.5 rounded-lg bg-[#488c42] cursor-pointer">
                            <span class="icons bg-white mr-2 transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/material-symbols/save-as.svg');"></span>
                            Save
                        </button>
                    </div>
                </div>
                <button type="button" id="editBtn" class="flex items-center text-sm text-white px-7 py-1.5 rounded-lg bg-[#3459A6] cursor-pointer">
                    <span class="icons bg-white mr-2 transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/material-symbols/edit-square-outline.svg');"></span>
                    Edit
                </button>
            </div>
        </form>
    </div>


    <div class="flex flex-col">
        <div class="flex justify-start items-center mb-3.5">
            <p class="show opacity-0 text-xl text-[#323d33]" data-delay="1.5">Passwords</p>
            <div class="line w-0 h-px bg-[#485349]/80 mx-8" data-delay="1.8"></div>
        </div>

        <div class="flex flex-col gap-6 px-20">
            <div class="flex justify-center items-center gap-8">
                <div class="show opacity-0 flex flex-col w-full" data-delay="0.3">
                    <label for="" class="text-sm font-bold ml-1.5">Password</label>
                    <div class="flex items-center gap-3.5">
                        <input type="password" id="" name="" placeholder="" value="********" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none" required readonly>
                        <button type="button" class="openModalBtn text-sm px-5 py-1.5 rounded-lg border-2 border-[#b4b4b4] cursor-pointer" data-target="modalChangePassword">Change</button>
                    </div>
                </div>

                <div class="show opacity-0 flex items-stretch h-10" data-delay="1.8">
                    <div class="w-px bg-[#485349]/80"></div>
                </div>

                <div class="show opacity-0 flex flex-col w-full" data-delay="0.6">
                    <label for="" class="text-sm font-bold ml-1.5">Savings pin</label>
                    <div class="flex items-center gap-3.5">
                        <input type="password" id="" name="" placeholder="" value="****" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none" required readonly>
                        <button type="button" class="openModalBtn text-sm px-5 py-1.5 rounded-lg border-2 border-[#b4b4b4] cursor-pointer" data-target="modalChangePin">Change</button>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST" class="show opacity-0 flex justify-center mt-10" data-delay="0.9">
            @csrf
            <button type="submit" class="flex items-center text-sm text-white px-7 py-1.5 rounded-lg bg-[#f2546b] cursor-pointer">
                <span class="icons bg-white mr-2 transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/material-symbols/logout.svg');"></span>
                Logout
            </button>
        </form>
    </div>
</div>

@include('component.forgotpasspin', [
    'title' => 'Change password',
    'routesName' => 'settings.changePassword',
    'targetBtn' => 'modalChangePassword',
    'buttonText' => 'Change',
    'fields' => [
        ['label' => 'Current password', 'type' => 'password', 'name' => 'current_password', 'value' => ''],
        ['label' => 'New password', 'type' => 'password', 'name' => 'new_password', 'value' => ''],
        ['label' => 'Confirm new password', 'type' => 'password', 'name' => 'confirm_password', 'value' => ''],
    ]
])

@include('component.forgotpasspin', [
    'title' => 'Change savings pin',
    'routesName' => 'settings.changePasskey',
    'targetBtn' => 'modalChangePin',
    'buttonText' => 'Change',
    'fields' => [
        ['label' => 'Current pin', 'type' => 'password', 'name' => 'current_pin', 'value' => ''],
        ['label' => 'New pin', 'type' => 'password', 'name' => 'new_pin', 'value' => ''],
        ['label' => 'Confirm new pin', 'type' => 'password', 'name' => 'confirm_pin', 'value' => ''],
    ]
])
@endsection