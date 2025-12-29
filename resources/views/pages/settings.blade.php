@extends('userpage')
@section('title', 'Settings')
@section('user_content')
<div class="container mx-auto px-5">
    <div class="flex flex-col">
        <div class="flex justify-center items-center mb-10">
            <p class="text-xl text-[#323d33]">Profile</p>
            <div class="w-full h-px bg-[#485349]/80 mx-8"></div>
        </div>

        <form action="" class="flex flex-col gap-6 mb-5 px-20" novalidate>
            <!-- PROFILE -->
            <div class="flex justify-center items-center gap-8">
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
                <div class="flex flex-col">
                    <label for="" class="text-sm font-bold ml-1.5">Last Name</label>
                    <input type="text" id="" name="" placeholder="" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none" required>
                </div>
                <div class="flex flex-col">
                    <label for="" class="text-sm font-bold ml-1.5">First Name</label>
                    <input type="text" id="" name="" placeholder="" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none" required>
                </div>
                <div class="flex flex-col">
                    <label for="" class="text-sm font-bold ml-1.5">Middle Name</label>
                    <input type="text" id="" name="" placeholder="" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none" required>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-8">
                <div class="flex flex-col">
                    <label for="" class="text-sm font-bold ml-1.5">Username</label>
                    <input type="text" id="" name="" placeholder="" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none" required>
                </div>
                <div class="flex flex-col">
                    <label for="" class="text-sm font-bold ml-1.5">Email address</label>
                    <input type="text" id="" name="" placeholder="" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none" required>
                </div>
                <div class="flex flex-col">
                    <label for="" class="text-sm font-bold ml-1.5">Phone number</label>
                    <input type="text" id="" name="" placeholder="" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none" required>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="flex items-center text-sm text-white px-7 py-1.5 rounded-lg bg-[#488c42] cursor-pointer">
                    <span class="icons bg-white mr-2 transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/material-symbols/save-as.svg');"></span>
                    Save
                </button>
            </div>
        </form>
    </div>


    <div class="flex flex-col">
        <div class="flex justify-center items-center mb-3.5">
            <p class="text-xl text-[#323d33]">Passwords</p>
            <div class="w-full h-px bg-[#485349]/80 mx-8"></div>
        </div>

        <div class="flex flex-col gap-6 px-20">
            <div class="flex justify-center items-center gap-8">
                <form class="flex flex-col w-full">
                    <label for="" class="text-sm font-bold ml-1.5">Password</label>
                    <div class="flex items-center gap-3.5">
                        <input type="password" id="" name="" placeholder="" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <button type="submit" class="text-sm px-5 py-1.5 rounded-lg border-2 border-[#b4b4b4] cursor-pointer">Change</button>
                    </div>
                </form>

                <div class="flex items-stretch h-10">
                    <div class="w-px bg-[#485349]/80"></div>
                </div>

                <form class="flex flex-col w-full">
                    <label for="" class="text-sm font-bold ml-1.5">Savings pin</label>
                    <div class="flex items-center gap-3.5">
                        <input type="password" id="" name="" placeholder="" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <button type="submit" class="text-sm px-5 py-1.5 rounded-lg border-2 border-[#b4b4b4] cursor-pointer">Change</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="flex justify-center mt-10">
            <button type="submit" class="flex items-center text-sm text-white px-7 py-1.5 rounded-lg bg-[#f2546b] cursor-pointer">
                <span class="icons bg-white mr-2 transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/material-symbols/logout.svg');"></span>
                Logout
            </button>
        </div>
    </div>
</div>
@endsection