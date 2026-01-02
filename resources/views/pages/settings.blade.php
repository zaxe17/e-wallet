@extends('userpage')
@section('title', 'Settings')
@section('user_content')
<div class="container mx-auto px-5">
    <div class="flex flex-col">
        <div class="flex justify-start items-center mb-10">
            <p class="show opacity-0 text-xl text-[#323d33]" data-delay="1.5">Profile</p>
            <div class="line w-0 h-px bg-[#485349]/80 mx-8" data-delay="1.8"></div>
        </div>

        <form action="{{ route('settings.save') }}" method="POST" id="settingsForm" class="flex flex-col gap-6 mb-5 px-20" novalidate>
            @csrf

            <!-- PROFILE -->
            <div class="show opacity-0 flex justify-center items-center gap-8" data-delay="">
                <div class="flex items-center justify-center gap-1">
                    <img src="/assets/PAYNOY.png" alt="user_profile" class="w-17 object-contain rounded-full block">
                </div>

                <div class="flex flex-col justify-center text-sm">
                    <p>Profile picture</p>
                    <button class="flex items-center gap-2 cursor-pointer">
                        <span class="icon bg-[#3a3a3a]" style="--svg: url('https://api.iconify.design/lucide/upload.svg'); --size: 20px;"></span>
                        Upload photo
                    </button>
                </div>

                <button class="flex items-center text-sm text-[#323d33] px-5 py-1.5 ml-10 rounded-lg border-2 border-[#b4b4b4] cursor-pointer">
                    <span class="icons bg-[#323d33] mr-2 transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/material-symbols/delete.svg');"></span>
                    Delete
                </button>
            </div>

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
                        <button type="submit" class="flex items-center text-sm text-white px-7 py-1.5 rounded-lg bg-[#488c42] cursor-pointer">
                            <span class="icons bg-white mr-2 transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/material-symbols/cancel.svg');"></span>
                            Save
                        </button>
                        <button type="button" id="cancelBtn" class="flex items-center text-sm text-white px-6 py-1.5 rounded-lg bg-[#6B7C99] cursor-pointer">
                            <span class="icons bg-white mr-2 transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/material-symbols/save-as.svg');"></span>
                            Cancel
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
                        <button type="submit" class="text-sm px-5 py-1.5 rounded-lg border-2 border-[#b4b4b4] cursor-pointer">Change</button>
                    </div>
                </div>

                <div class="show opacity-0 flex items-stretch h-10" data-delay="1.8">
                    <div class="w-px bg-[#485349]/80"></div>
                </div>

                <div class="show opacity-0 flex flex-col w-full" data-delay="0.6">
                    <label for="" class="text-sm font-bold ml-1.5">Savings pin</label>
                    <div class="flex items-center gap-3.5">
                        <input type="password" id="" name="" placeholder="" value="****" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none" required readonly>
                        <button type="submit" class="text-sm px-5 py-1.5 rounded-lg border-2 border-[#b4b4b4] cursor-pointer">Change</button>
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

@include('component.messagepopup')
@endsection